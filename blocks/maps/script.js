var LazyLoad = require("vanilla-lazyload");

var Tela = window.Tela || {};
Tela.blocks = Tela.blocks || {};

Tela.blocks.lazyload = (function(){

  function blocks(selector){
    var $el = $(selector),
      $items;

    function init(){
      // On mobile only
      if (!matchMedia('only screen and (max-width: 767.9px)').matches) return;
      $items = $el.find('iframe');
      var myLazyLoad = new LazyLoad($items[0]);
    }

    init();

    return $el;
  }

  return function(selector){
    return $(selector).each(function(){
      blocks(this);
    });
  };

})();

$(document).ready(function(){
  Tela.blocks.lazyload('.lazyload');
});
