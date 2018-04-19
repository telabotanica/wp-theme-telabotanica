require('velocity-animate');
var PubSub = require('pubsub-js');
var Cookies = require('js-cookie');

var Tela = window.Tela || {};
Tela.modules = Tela.modules || {};

Tela.modules.noticeCookies = (function(){

  function module(selector){
    var $el = $(selector),
        $buttonAccept;

    function init(){
      // If the user already accepts cookies, remove the notice and quit
      if (Cookies.get('cookies-accept') === 'true') {
        $el.remove();
        return;
      }

      open();

      $buttonAccept = $el.find('.button[data-action="accept-cookies"]');
      $buttonAccept.on('click', onClickAccept);
    }

    function onClickAccept(e){
      e.preventDefault();
      Cookies.set('cookies-accept', 'true', {
        expires: 395 // 13 months
      });
      close();
    }

    function close(){
      $el.velocity({
        height: 0,
        opacity: [0, 1]
      }, {
        duration: 350,
        easing: "ease",
        complete: function(){
          PubSub.publish('notice-cookies.closed');
          $el.remove();
        }
      });
    }

    function open(){
      $el.velocity({
        opacity: [1, 0]
      }, {
        display: 'block',
        duration: 350,
        easing: "ease",
        complete: function(){
          PubSub.publish('notice-cookies.opened');
        }
      });
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
  Tela.modules.noticeCookies('.notice-cookies');
});
