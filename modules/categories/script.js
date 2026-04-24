var Tela = window.Tela || {};
Tela.modules = Tela.modules || {};

Tela.modules.categories = (function(){
  function module(el){
    var container = el;
    var title;
    var content;

    function init(){
      title = container.querySelector('.categories-title');
      content = container.querySelector('.categories-items');

      // On mobile only
      if (!window.matchMedia('only screen and (max-width: 767.9px)').matches) {
        return;
      }

      container.classList.add('is-closed');
      if (title) {
        title.addEventListener('click', toggleContent);
      }
    }

    function toggleContent(e){
      e.preventDefault();
      container.classList.toggle('is-closed');
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

document.addEventListener('DOMContentLoaded', () => {
  Tela.modules.categories('.categories');
});
