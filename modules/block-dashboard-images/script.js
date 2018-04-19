var PubSub = require('pubsub-js');

var Tela = window.Tela || {};
Tela.modules = Tela.modules || {};

Tela.modules.blockDashboardImages = (function(){

  function module(selector){
    var $el = $(selector),
      $titleSuffix,
      $content,
      apiUrl,
      maxItems = 8,
      data = {
        total: '',
        items: []
      };

    function init(){
      $titleSuffix = $el.find('.title-suffix');
      $content = $el.find('.block-dashboard-content');

      // Get the URL to the API from the data-* attribute
      apiUrl = $el.data('apiUrl');

      // Subscribe to the total of images that will be retrieved by block-dashboard-map
      PubSub.subscribe('block-dashboard-map.images', onTotalImages);

      loadData();
    }

    function loadData(){
      // useful for local debugging:
      // apiUrl = '/wp-content/themes/telabotanica/modules/feed/images.json';

      // Call the API
      $.getJSON(apiUrl, function(json){
        _.each(json.resultats.slice(0, maxItems), function (item) {
          data.items.push({
            href: '#',
            image: item['binaire.href']
          });
        });

        renderContent();
      });
    }

    function onTotalImages(e, images) {
      // images contains the total of images for this user
      data.total = images;
      updateSuffix();
    }

    function updateSuffix(){
      $titleSuffix.text(data.total);
    }

    function renderContent(){
      var content = '<div class="block-dashboard-content-images">';
      $.each(data.items, function(){
        content += '<a href="' + this.href + '"><img src="' + this.image + '" alt="" /></a>';
      })
      content += '</div>';
      $content.prepend(content);
    }


    init();

    return $el;
  }

  return function(selector){
    return $(selector).each(function(){
      module(this);
    });
  };

})();

$(document).ready(function(){
  Tela.modules.blockDashboardImages('.block-dashboard-images');
});
