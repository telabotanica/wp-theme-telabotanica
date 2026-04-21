// Vanilla ES6 Toc navigation (no jQuery)
(function(){
  function throttle(fn, wait){
    let t = 0;
    return function(){
      const now = Date.now();
      if (now - t >= wait){ t = now; fn.apply(this, arguments); }
    };
  }

  const _ = {
    defer: (fn)=>{ setTimeout(fn, 0); },
    map: (arr, fn)=> Array.from(arr).map((v,i)=>fn(v,i)),
    throttle: throttle
  };
  const Tela = window.Tela || {};
  Tela.modules = Tela.modules || {};

  Tela.modules.toc = (function(){
    const defaultOptions = {
      accordionsSelector: '.component-accordion',
      anchorsSelector: '.component-title.level-2 .component-title-anchor',
      anchorOffset: 40
    };

    function module(selector, userOptions){
      const el = document.querySelector(selector);
      if (!el) return;
      const options = Object.assign({}, defaultOptions, userOptions || {});
      let items = [], headerHeight = 0, currentItemId = null;
      let articleContainer = document.querySelector('.layout-content article');
      let anchors = articleContainer ? articleContainer.querySelectorAll(options.anchorsSelector) : [];
      let accordions = articleContainer ? articleContainer.querySelectorAll(options.accordionsSelector) : [];

      function init(){
        headerHeight = document.querySelector('.header-nav')?.offsetHeight || 0;
        articleContainer = document.querySelector('.layout-content article');
        accordions = articleContainer ? articleContainer.querySelectorAll(options.accordionsSelector) : [];
        anchors = articleContainer ? articleContainer.querySelectorAll(options.anchorsSelector) : [];
        if (anchors.length){
          _.defer(parseItems);
          window.addEventListener('scroll', throttle(onScroll, 250));
        }
        if (accordions.length){
          // simple polling
          setInterval(parseItems, 500);
        }
      }

      function parseItems(){
        items = Array.from(anchors).map(anchor => {
          const name = anchor.getAttribute('name');
          const rect = anchor.getBoundingClientRect();
          const top = Math.round(rect.top + window.scrollY + options.anchorOffset);
          return { id: name, top };
        });
        items.forEach((item, idx) => {
          item.bottom = (idx+1 < items.length) ? items[idx+1].top : Math.round((articleContainer?.offsetTop || 0) + (articleContainer?.offsetHeight || 0));
        });
        onScroll();
      }

      function onScroll(){
        const scrollTop = window.scrollY;
        items.forEach(item => {
          if (scrollTop > item.top - headerHeight && scrollTop < item.bottom - headerHeight && currentItemId !== item.id){
            currentItemId = item.id;
            el.querySelectorAll('.toc-subitem').forEach(n => n.classList.remove('is-active'));
            const a = el.querySelector('a[href="#' + item.id + '"]');
            if (a){ const parent = a.closest('.toc-subitem'); if (parent) parent.classList.add('is-active'); }
          }
        });
      }

      init();
      parseItems();
    }

    return function(selector, userOptions){
      document.querySelectorAll(selector).forEach(el => module(el, userOptions));
    };
  })();

  document.addEventListener('DOMContentLoaded', function(){
    Tela.modules.toc('.toc');
  });
})();
