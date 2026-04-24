var Tela = window.Tela || {};
Tela.blocks = Tela.blocks || {};

Tela.blocks.listProjects = (function(){
  function block(el){
    var container = el;
    var items;
    function init(){
      // On mobile only
      if (!matchMedia('only screen and (max-width: 767.9px)').matches) return;
      items = container.querySelectorAll('.block-list-projects-items');
      if (items.length > 0 && typeof Flickity !== 'undefined'){
        new Flickity(items[0], { prevNextButtons: false });
      }
    }
    init();
    return container;
  }

  return function(selector){
    Array.from(document.querySelectorAll(selector)).forEach(function(el){ block(el); });
  };

})();

document.addEventListener('DOMContentLoaded', () => {
  Tela.blocks.listProjects('.block-list-projects');
});
