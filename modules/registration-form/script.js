var Tela = window.Tela || {};
Tela.modules = Tela.modules || {};

Tela.modules.register = (function(){
  function unbind(){
    // replaces jQuery-based bindings with vanilla listeners
    var inputs = document.querySelectorAll('#profile-edit-form input:not([type="submit"]), #profile-edit-form textarea, #profile-edit-form select, #signup_form input:not([type="submit"]), #signup_form textarea, #signup_form select');
    inputs.forEach(function(el){
      el.addEventListener('change', function(){
        window.onbeforeunload = function(event){ event.stopPropagation(); };
      });
    });
  }

  function changeLinksTargets() {
    document.querySelectorAll('p.description > a').forEach(function(a){ a.setAttribute('target','_blank'); });
  }

  return function(selector){
    Array.from(document.querySelectorAll(selector)).forEach(function(){
      unbind();
      changeLinksTargets();
    });
  };
})();

document.addEventListener('DOMContentLoaded', () => {
  Tela.modules.register('#signup_form');
});
