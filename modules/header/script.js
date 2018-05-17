require('accessible-mega-menu');
var iconTemplate = require('../icon/icon.pug');

var Tela = window.Tela || {};
Tela.modules = Tela.modules || {};

Tela.modules.header = (function(){

  function module(selector){
    var $el = $(selector),
      $body,
      $toggle,
      $nav;

    function init(){
      $body = $('body');
      $nav = $el.find('.header-nav');

      // On mobile only
      if (matchMedia('only screen and (max-width: 767.9px)').matches) {
        initMobile();
        return;
      }

      var $itemsContribute = $el.find('.menu-item.is-contribution > a');
      var iconEdit = iconTemplate({data: {icon: 'edit'}});
      $itemsContribute.prepend(iconEdit);

      $nav.accessibleMegaMenu({
        panelClass: "sub-menu",
        topNavItemClass: "menu-item-has-children",
        hoverClass: "is-hover",
        focusClass: "is-focus",
        openClass: "is-open"
      });
    }

    function initMobile(){
      var $container = $('<div class="header-container"></div>');
      $el.append($container);

      $el.find(".search-box").addClass("is-open").appendTo($container);
      $nav.appendTo($container);
      $el.find(".header-nav-usecases").appendTo($container);
      $el.find(".header-links").appendTo($container);
      $el.find(".header-links-item:empty").remove();

      $toggle = $el.find(".header-toggle");
      $toggle.on("click", toggleNav);
    }

    function toggleNav(e){
      e.preventDefault();
      $toggle.toggleClass("is-hidden");
      $el.toggleClass("is-open");
      $body.toggleClass("has-nav-open");
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
  Tela.modules.header('.header');
});
