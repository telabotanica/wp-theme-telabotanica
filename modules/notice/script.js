var Tela = window.Tela || {};
Tela.modules = Tela.modules || {};

Tela.modules.notice = (function(){

  function module(selector){
    var $el = $(selector),
      $closeButton;

    function init(){
      $closeButton = $el.find('.notice-close');

      $closeButton.on('click', onClickCloseButton);
    }

    function onClickCloseButton(e){
      e.preventDefault();
      $el.fadeOut();
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
  Tela.modules.notice('.notice');
});
