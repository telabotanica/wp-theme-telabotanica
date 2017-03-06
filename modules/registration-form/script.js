'use strict';

var Tela = window.Tela || {};

Tela.register = (function(){

  function unbind(){
    // prevents Buddypress[.min.js] from displaying a "leave page" warning
    // (onbeforeunload) when validating the form
    // TODO: enquêter sur l'origine du problème, en attendant, gros fix sale
    $('#profile-edit-form input:not(:submit), #profile-edit-form textarea, #profile-edit-form select, #signup_form input:not(:submit), #signup_form textarea, #signup_form select').unbind('change');
  }

  return function(selector){
    $(selector).each(function() {
      unbind();
    });
  };

})();

$(document).ready(function(){
  Tela.register('#signup_form');
});
