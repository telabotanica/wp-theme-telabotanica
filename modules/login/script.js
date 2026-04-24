/* Vanilla JS version (no jQuery) for Login module */
(function(){
  // Simple inline icon replacement (no dependency on icon template)
  function renderIconClose(){
    return '<span class="icon-close">✕</span>';
  }

  var Tela = window.Tela || {};
  Tela.modules = Tela.modules || {};

  Tela.modules.login = (function(){
    function module(el){
      var container = el;
      var inputLogin;
      var defaultProvider;
      var labelsProviders;
      var radiosProviders;

      function init(){
        container.classList.add('has-js');
        inputLogin = document.querySelector('#user_login');
        labelsProviders = container.querySelectorAll('.login-providers label');
        // find element with class login-provider-default among labels
        defaultProvider = Array.from(labelsProviders).find(function(label){ return label.classList && label.classList.contains('login-provider-default'); });
        radiosProviders = container.querySelectorAll('.login-providers input');

        if (defaultProvider) defaultProvider.style.display = 'none';
        replaceDefaultWithIcon();

        radiosProviders.forEach(function(r){ r.addEventListener('change', onChangeRadio); });
      }

      function replaceDefaultWithIcon(){
        var iconClose = renderIconClose();
        if (!defaultProvider) return;
        // Remove text nodes inside the default provider
        Array.from(defaultProvider.childNodes).forEach(function(n){ if (n.nodeType === 3) n.remove(); });
        // Append icon
        defaultProvider.insertAdjacentHTML('beforeend', iconClose);
      }

      function onChangeRadio(e){
        var self = e.target;
        labelsProviders.forEach(function(l){ l.classList.remove('active'); });
        if (self.checked){
          self.closest('label').classList.add('active');
        }

        // Show the default provider only if another one was checked
        if (defaultProvider){
          defaultProvider.style.display = (self.value !== '') ? 'none' : '';
        }

        // Focus the login input
        if (inputLogin) inputLogin.focus();
      }

      init();
    }

    return function(selector){
      Array.from(document.querySelectorAll(selector)).forEach(function(el){
        module(el);
      });
    };
  })();

  document.addEventListener('DOMContentLoaded', () => {
    Tela.modules.login('#login');
  });
})();
