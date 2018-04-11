var iconTemplate = require('../icon/icon.pug');

var Tela = window.Tela || {};
Tela.modules = Tela.modules || {};

Tela.modules.footer = (function(){

  function module(selector){
    var $el     = $(selector),
      $itemsMore;

    function init(){
      $itemsMore = $el.find('.menu-item-more');

      var iconArrowRight = iconTemplate({data: {icon: 'arrow-right'}});
      $itemsMore.append(iconArrowRight);
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
  Tela.modules.footer('.footer');
});
