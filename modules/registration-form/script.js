var Tela = window.Tela || {};
Tela.modules = Tela.modules || {};

Tela.modules.register = (function(){

  function unbind(){
    // prevents Buddypress[.min.js] from displaying a "leave page" warning
    // (onbeforeunload) when validating the form
    // TODO: enquêter sur l'origine du problème, en attendant, gros fix sale
    $('#profile-edit-form input:not(:submit), #profile-edit-form textarea, #profile-edit-form select, #signup_form input:not(:submit), #signup_form textarea, #signup_form select').unbind('change');
  }

  function changeLinksTargets() {
    // adds target="_blank" to links in fields descriptions, which is not
    // allowed by the fields editor
    $('p.description > a').prop('target', '_blank');
  }

  return function(selector){
    $(selector).each(function() {
      unbind();
      changeLinksTargets();
    });
  };

})();

$(document).ready(function(){
  Tela.modules.register('#signup_form');
});
