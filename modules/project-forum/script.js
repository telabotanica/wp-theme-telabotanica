/* Vanilla JS version (no jQuery) for Project Forum module */
(function(){
  var Tela = window.Tela || {};
  Tela.modules = Tela.modules || {};

  Tela.modules.epForum = (function(){
    function module(el){
      var form = el;
      var submitBtn = form.querySelector('input[type="submit"]');

      function init(){
        if (!submitBtn) return;
        submitBtn.addEventListener('click', confirmFormSubmit);
      }

      function confirmFormSubmit(e){
        e.preventDefault();
        e.stopPropagation();
        var message = submitBtn.getAttribute("title");
        if (confirm(message)) {
          form.submit();
        }
      }

      init();
    }

    return function(selector){
      Array.from(document.querySelectorAll(selector)).forEach(function(el){
        module(el);
      });
    };
  })();

  document.addEventListener('DOMContentLoaded', function(){
    Tela.modules.epForum('#tb-forum-inscription');
  });
})();
