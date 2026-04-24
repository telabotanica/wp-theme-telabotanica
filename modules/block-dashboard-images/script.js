/* Vanilla JS version (no jQuery) for BlockDashboardImages module */
(function(){
  // Tiny PubSub shim to replace pubsub-js usage
  var PubSub = {
    _events: {},
    subscribe: function(topic, cb){
      this._events[topic] = this._events[topic] || [];
      this._events[topic].push(cb);
    },
    publish: function(topic, data){
      (this._events[topic] || []).forEach(function(cb){ cb(null, data); });
    }
  };

  var Tela = window.Tela || {};
  Tela.modules = Tela.modules || {};

  Tela.modules.blockDashboardImages = (function(){
    function module(el){
      var container = el;
      var titleSuffix;
      var content;
      var apiUrl;
      var maxItems = 8;
      var data = {
        total: '',
        items: []
      };

      function init(){
        titleSuffix = container.querySelector('.title-suffix');
        content = container.querySelector('.block-dashboard-content');
        apiUrl = container.getAttribute('data-api-url');
        PubSub.subscribe('block-dashboard-map.images', onTotalImages);
        loadData();
      }

      function loadData(){
        if (!apiUrl) return;
        fetch(apiUrl)
          .then(function(res){ return res.json(); })
          .then(function(json){
            (json.resultats || []).slice(0, maxItems).forEach(function(item){
              data.items.push({
                href: '#',
                image: item['binaire.href']
              });
            });
            renderContent();
          })
          .catch(function(err){ console.error(err); });
      }

      function onTotalImages(e, images){
        data.total = images;
        updateSuffix();
      }

      function updateSuffix(){
        if (titleSuffix) titleSuffix.textContent = data.total;
      }

      function renderContent(){
        var contentHTML = '<div class="block-dashboard-content-images">';
        data.items.forEach(function(item){
          contentHTML += '<a href="' + item.href + '"><img src="' + item.image + '" alt="" /></a>';
        });
        contentHTML += '</div>';
        if (content){ content.insertAdjacentHTML('afterbegin', contentHTML); }
      }

      init();
      return container;
    }

    return function(selector){
      Array.from(document.querySelectorAll(selector)).forEach(function(el){
        module(el);
      });
    };
  })();

  document.addEventListener('DOMContentLoaded', function(){
    Tela.modules.blockDashboardImages('.block-dashboard-images');
  });
})();
