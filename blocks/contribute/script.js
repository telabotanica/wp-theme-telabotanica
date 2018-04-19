var Flickity = require("flickity");

var Tela = window.Tela || {};
Tela.blocks = Tela.blocks || {};

Tela.blocks.contribute = (function(){

  function block(selector){
    var $el = $(selector),
      $items;

    function init(){
      // On mobile only
      if (!matchMedia('only screen and (max-width: 767.9px)').matches) return;

      $items = $el.find('.block-contribute-items');
      var flkty = new Flickity($items[0], {
        wrapAround: true
      });
    }

    init();

    return $el;
  }

  return function(selector){
    return $(selector).each(function(){
      block(this);
    });
  };

})();

$(document).ready(function(){
  Tela.blocks.contribute('.block-contribute');
});
