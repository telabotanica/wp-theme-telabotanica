var Tela = window.Tela || {};
Tela.modules = Tela.modules || {};

Tela.modules.epForum = (function(){

  function module(selector){
    var $formAbonnement = $(selector),
        $boutonAbonnement = $formAbonnement.find('input[type="submit"]');

    function init(){
      $boutonAbonnement.on('click', confirmFormSubmit);
    }

    function confirmFormSubmit(e){
      e.preventDefault();
      e.stopPropagation();
      var message = $boutonAbonnement.attr("title");
      if (confirm(message)) {
        $formAbonnement.submit();
      }
    }

    init();
  }

  return function(selector){
    $(selector).each(function() {
      module(this);
    });
  };

})();

$(document).ready(function(){
  Tela.modules.epForum('#tb-forum-inscription');
});
