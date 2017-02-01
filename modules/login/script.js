'use strict';

var Tela = window.Tela || {};

Tela.login = (function(){

  function login(selector){
    var $el     = $(selector),
      $links;

    function init(){
      console.log('login', $el);

      // $links.on('click', onClickLink);
    }

    function onClickLink(e){
      e.preventDefault();
      e.stopPropagation();
      openInNewWindow($(this).attr('href'));
    }

    init();

    return $el;
  }

  return function(selector){
    return $(selector).each(function(){
      login(this);
    });
  };

})();

$(document).ready(function(){
  Tela.login('#login');
});
