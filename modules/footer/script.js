/* Vanilla JS version (no jQuery) for Footer module */
(function(){
  // Simple inline icon replacement
  function renderIconArrowRight(){
    return '<span class="icon-arrow-right">→</span>';
  }

  var Tela = window.Tela || {};
  Tela.modules = Tela.modules || {};

  Tela.modules.footer = (function(){
    function module(el){
      var container = el;
      var toggleBtn, nav, itemsMore;

      function init(){
        toggleBtn = container.querySelector('.footer-nav-toggle button');
        nav = container.querySelector('.footer-nav');
        itemsMore = container.querySelector('.menu-item-more');

        if (toggleBtn) toggleBtn.addEventListener('click', toggleNav);

        if (itemsMore) {
          itemsMore.insertAdjacentHTML('beforeend', renderIconArrowRight());
        }
      }

      function toggleNav(){
        if (!nav) return;
        var current = window.getComputedStyle(nav).display;
        nav.style.display = (current === 'none') ? '' : 'none';
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
    Tela.modules.footer('.footer');
  });
})();
