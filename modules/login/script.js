var iconTemplate = require('../icon/icon.pug');

var Tela = window.Tela || {};
Tela.modules = Tela.modules || {};

Tela.modules.login = (function(){

  function module(selector){
    var $el = $(selector),
      $inputLogin,
      $defaultProvider,
      $labelsProviders,
      $radiosProviders;

    function init(){
      $el.addClass('has-js');

      $inputLogin = $('#user_login');
      $labelsProviders = $el.find('.login-providers label');
      $defaultProvider = $labelsProviders.filter('.login-provider-default');
      $radiosProviders = $el.find('.login-providers input');

      $defaultProvider.hide();
      replaceDefaultWithIcon();

      $radiosProviders.on('change', onChangeRadio);
    }

    function replaceDefaultWithIcon(){
      var iconClose = iconTemplate({data: {icon: 'close'}});

      // Remove text nodes
      $defaultProvider.contents().filter(function(){return this.nodeType === 3;}).remove();

      // Append icon
      $defaultProvider.append(iconClose);
    }

    function onChangeRadio(e){
      var $this = $(this);
      $labelsProviders.removeClass('active');
      if ($this.is(':checked')) {
        $this.closest('label').addClass('active');
      }

      // Show the default provider only if another one was checked
      $defaultProvider.toggle($this.val() !== '');

      // Focus the login input
      $inputLogin.trigger('focus');
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
  Tela.modules.login('#login');
});
