require('accessible-mega-menu');
var iconTemplate = require('../icon/icon.pug');

var Tela = window.Tela || {};
Tela.modules = Tela.modules || {};

Tela.modules.header = (function(){

  function module(selector){
    var $el = $(selector),
      $body,
      $toggle,
      $nav,
      $container,
      $submenuBack,
      $submenuContainer,
      $submenuContainerNav;

    function init(){
      $body = $('body');
      $nav = $el.find('.header-nav');

      var $itemsContribute = $el.find('.menu-item.is-contribution > a');
      var iconEdit = iconTemplate({data: {icon: 'edit'}});
      $itemsContribute.prepend(iconEdit);

      // On mobile only
      if (matchMedia('only screen and (max-width: 1199.9px)').matches) {
        initMobile();
        return;
      }

      $nav.accessibleMegaMenu({
        panelClass: "sub-menu",
        topNavItemClass: "menu-item-has-children",
        hoverClass: "is-hover",
        focusClass: "is-focus",
        openClass: "is-open"
      });
    }

    function initMobile(){
      $container = $el.find('.header-container');
      $submenuContainer = $el.find('.header-submenu-container');

      $el.find(".search-box").addClass("is-open").appendTo($container);
      $nav.appendTo($container);
      $el.find(".header-nav-usecases").appendTo($container);
      $el.find(".header-links").appendTo($container);
      $el.find(".header-links-item:empty").remove();
      $el.find(".header-nav-items > .menu-item > a").on("click", openSubmenu);

      $submenuBack = $el.find('.header-submenu-back');
      $submenuContainerNav = $el.find('.header-submenu-container-nav');

      $toggle = $el.find(".header-toggle");
      $toggle.on("click", toggleNav);
      $submenuBack.on("click", closeSubmenu);
    }

    function toggleNav(e){
      e.preventDefault();
      $container.scrollTop(0);
      $toggle.toggleClass("is-hidden");
      $el.removeClass("has-submenu-open");
      $el.toggleClass("is-open");
      $body.toggleClass("has-nav-open");
    }

    function openSubmenu(e) {
      e.preventDefault();
      var $submenu = $(e.target).next(".sub-menu");
      $submenuContainer.scrollTop(0);
      $submenuContainerNav.empty();
      $submenu.clone().appendTo($submenuContainerNav);
      $el.addClass("has-submenu-open");
    }

    function closeSubmenu(e) {
      e.preventDefault();
      $el.removeClass("has-submenu-open");
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
