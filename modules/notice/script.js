var Tela = window.Tela || {};
Tela.modules = Tela.modules || {};

// Vanilla JS version of notice module
Tela.modules.notice = (function(){
  function module(el){
    var container = el;
    var closeButton;

    function init(){
      closeButton = container.querySelector('.notice-close');
      if (closeButton) {
        closeButton.addEventListener('click', onClickCloseButton);
      }
    }

    function onClickCloseButton(e){
      e.preventDefault();
      container.style.display = 'none';
    }

    init();
    return container;
  }

  return function(selector){
    Array.from(document.querySelectorAll(selector)).forEach(function(node){
      module(node);
    });
  };

})();

document.addEventListener('DOMContentLoaded', () => {
  Tela.modules.notice('.notice');
});
