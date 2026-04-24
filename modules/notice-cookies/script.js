/* Vanilla JS version (no jQuery) for Notice Cookies module */
(function(){
  // Simple PubSub shim
  var PubSub = window.PubSub || {
    _events: {},
    publish: function(topic, data){ (this._events[topic] || []).forEach(function(cb){ cb(null, data); }); },
    subscribe: function(topic, cb){ this._events[topic] = this._events[topic] || []; this._events[topic].push(cb); }
  };
  // Simple cookie helpers
  function getCookie(name){ var m = document.cookie.match('(?:^|; )' + name + '=([^;]*)'); return m ? decodeURIComponent(m[1]) : null; }
  function setCookie(name, value, days){ var d = new Date(); d.setTime(d.getTime() + days*24*60*60*1000); document.cookie = name + '=' + encodeURIComponent(value) + ';path=/;expires=' + d.toUTCString(); }

  var Tela = window.Tela || {};
  Tela.modules = Tela.modules || {};

  Tela.modules.noticeCookies = (function(){
    function module(el){
      var noticeEl = el;
      var buttonAccept;

      function init(){
        // If the user already accepts cookies, remove the notice and quit
        if (getCookie('cookies-accept') === 'true') {
          noticeEl.remove();
          return;
        }
        openNotice();
        buttonAccept = noticeEl.querySelector('.button[data-action="accept-cookies"]');
        if (buttonAccept) buttonAccept.addEventListener('click', onClickAccept);
      }

      function onClickAccept(e){
        e.preventDefault();
        setCookie('cookies-accept', 'true', 395);
        closeNotice();
      }

      function closeNotice(){
        // Simple hide/remove without animation
        noticeEl.style.display = 'none';
        PubSub.publish('notice-cookies.closed');
        noticeEl.remove();
      }

      function openNotice(){
        noticeEl.style.display = 'block';
        PubSub.publish('notice-cookies.opened');
      }

      init();
      return noticeEl;
    }

    return function(selector){
      Array.from(document.querySelectorAll(selector)).forEach(function(el){ module(el); });
    };
  })();

  document.addEventListener('DOMContentLoaded', () => {
    Tela.modules.noticeCookies('.notice-cookies');
  });
})();
