var Tela = window.Tela || {};
Tela.modules = Tela.modules || {};

Tela.modules.categories = (function(){

  function module(selector){
    var $el = $(selector),
      $title;

    function init(){
      $title = $el.find('.categories-title');
      $content = $el.find('.categories-items');

      // On mobile only
      if (!matchMedia('only screen and (max-width: 767.9px)').matches) {
        return;
      }

      $el.addClass("is-closed");
      $title.on('click', toggleContent);
    }

    function toggleContent(e){
      e.preventDefault();
      $el.toggleClass("is-closed");
    }

    init();

    return $el;
  }

  return function(selector){
    return $(selector).each(function(){
      module(this);
    });
  };

})();

$(document).ready(function(){
  Tela.modules.categories('.categories');
});
