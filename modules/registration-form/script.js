var Tela = window.Tela || {};
Tela.modules = Tela.modules || {};

Tela.modules.register = (function(){

  function unbind(){
    // prevents Buddypress[.min.js] from displaying a "leave page" warning
    // (onbeforeunload) when validating the form
    // This overloads /plugins/buddypress/bp-templates/bp-legacy/js/buddypress.js:1208
    // (actually loadded : buddypress.min.js)
    $('#profile-edit-form input:not(:submit), #profile-edit-form textarea, #profile-edit-form select, #signup_form input:not(:submit), #signup_form textarea, #signup_form select').change(function(){
      window.onbeforeunload = function(event) {
        event.stopPropagation();
      };
    });
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
