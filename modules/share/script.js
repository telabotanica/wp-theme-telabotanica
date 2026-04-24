/* Vanilla JS version (no jQuery) for Share module */
(function(){
  var Tela = window.Tela || {};
  Tela.modules = Tela.modules || {};

  Tela.modules.share = (function(){
    function module(el){
      var container = el;
      var links;

      function init(){
        links = container.querySelectorAll('.share-item a');
        links.forEach(function(a){
          a.addEventListener('click', onClickLink);
        });
      }

      function onClickLink(e){
        if (e.currentTarget.getAttribute('target') !== '_blank') { return; }
        e.preventDefault();
        e.stopPropagation();
        openInNewWindow(e.currentTarget.getAttribute('href'));
      }

      function openInNewWindow(url){
        var newWindow = window.open(url, 'share', 'height=400,width=600');
        if (window.focus) { newWindow.focus(); }
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
    Tela.modules.share('.share');
  });
})();
