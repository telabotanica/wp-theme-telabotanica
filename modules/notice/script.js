'use strict';

var Tela = window.Tela || {};

Tela.notice = (function(){

  function module(selector){
    var $el     = $(selector),
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
  Tela.notice('.notice');
});
