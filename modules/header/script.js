import 'accessible-mega-menu';
import iconTemplate from '../icon/icon.js';

var Tela = window.Tela || {};
Tela.modules = Tela.modules || {};

Tela.modules.header = (function(){

  function module(selector){
    const el = document.querySelector(selector);
    let $body,
        $toggle,
        $nav,
        $container,
        $submenuBack,
        $submenuContainer,
        $submenuContainerNav;

    function init(){
      $body = document.body;
      $nav = el.querySelector('.header-nav');

      const itemsContribute = el.querySelectorAll('.menu-item.is-contribution > a');
      const iconEdit = iconTemplate({data: {icon: 'edit'}});
      itemsContribute.forEach(a => a.insertAdjacentHTML('afterbegin', iconEdit));

      // On mobile only
      if (window.matchMedia && window.matchMedia('only screen and (max-width: 1199.9px)').matches) {
        initMobile();
        return;
      }
      // If a vanilla equivalent exists, prefer that; otherwise rely on existing plugin
      if (typeof $nav !== 'undefined' && typeof $nav.accessibleMegaMenu === 'function') {
        $nav.accessibleMegaMenu({
          panelClass: "sub-menu",
          topNavItemClass: "menu-item-has-children",
          hoverClass: "is-hover",
          focusClass: "is-focus",
          openClass: "is-open"
        });
      }
    }

    function initMobile(){
      const container = el.querySelector('.header-container');
      const submenuContainer = el.querySelector('.header-submenu-container');

      const searchBox = el.querySelector('.search-box');
      if (searchBox && container) { searchBox.classList.add('is-open'); container.appendChild(searchBox); }
      if (container) { container.appendChild(el.querySelector('.header-nav')); }
      const headerUses = el.querySelector('.header-nav-usecases');
      if (headerUses && container) { container.appendChild(headerUses); }
      const headerLinks = el.querySelector('.header-links');
      if (headerLinks && container) { container.appendChild(headerLinks); }
      // Remove empty header-links-item entries (best-effort)
      el.querySelectorAll('.header-links-item').forEach(function(item){ if (item.textContent.trim() === '') item.remove(); });
      const navItems = el.querySelectorAll('.header-nav-items > .menu-item > a');
      navItems.forEach(n => n.addEventListener('click', openSubmenu));

      $submenuBack = el.querySelector('.header-submenu-back');
      $submenuContainerNav = el.querySelector('.header-submenu-container-nav');

      $toggle = el.querySelector('.header-toggle');
      if ($toggle) $toggle.addEventListener('click', toggleNav);
      if ($submenuBack) $submenuBack.addEventListener('click', closeSubmenu);
      // keep reference variables for compatibility
      $container = container;
      $submenuContainer = submenuContainer;
      $submenuContainerNav = $submenuContainerNav;
      $nav = el.querySelector('.header-nav');
    }

    function toggleNav(e){
      e.preventDefault();
      if ($container) $container.scrollTop = 0;
      if ($toggle) $toggle.classList.toggle("is-hidden");
      el.classList.remove("has-submenu-open");
      el.classList.toggle("is-open");
      if ($body) $body.classList.toggle("has-nav-open");
    }

    function openSubmenu(e) {
      e.preventDefault();
      const submenu = e.target.nextElementSibling;
      if ($submenuContainer) $submenuContainer.scrollTop = 0;
      if ($submenuContainerNav) { $submenuContainerNav.innerHTML = ''; if (submenu) $submenuContainerNav.appendChild(submenu.cloneNode(true)); }
      el.classList.add("has-submenu-open");
    }

    function closeSubmenu(e) {
      e.preventDefault();
      el.classList.remove("has-submenu-open");
    }

    init();

    return el;
  }

  return function(selector){
    const elements = document.querySelectorAll(selector);
    elements.forEach(el => module(el));
  };

})();

document.addEventListener('DOMContentLoaded', function(){
  Tela.modules.header('.header');
});
