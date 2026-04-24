/* Vanilla JS version (no jQuery) for Contribute block */
(function(){
  var Flickity = window.Flickity; // assume Flickity is loaded globally
  var Tela = window.Tela || {};
  Tela.blocks = Tela.blocks || {};

  Tela.blocks.contribute = (function(){
    function block(el){
      var container = el;
      var items;

      function init(){
        // On mobile only
        if (!window.matchMedia('only screen and (max-width: 767.9px)').matches) return;

        items = container.querySelectorAll('.block-contribute-items');
        if (items.length > 0 && typeof Flickity !== 'undefined'){
          new Flickity(items[0], { wrapAround: true });
        }
      }

      init();
      return container;
    }

    return function(selector){
      Array.from(document.querySelectorAll(selector)).forEach(function(el){
        block(el);
      });
    };
  })();

  document.addEventListener('DOMContentLoaded', function(){
    Tela.blocks.contribute('.block-contribute');
  });
})();
