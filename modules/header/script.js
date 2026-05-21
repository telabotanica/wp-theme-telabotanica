import iconTemplate from '../icon/icon.js';

var Tela = window.Tela || {};
Tela.modules = Tela.modules || {};

Tela.modules.header = (function(){
  function module(selector){
    // Gérer à la fois un sélecteur string et un élément DOM
    const el = typeof selector === 'string' ? document.querySelector(selector) : selector;

    if (!el) {
      console.error('Header element not found');
      return;
    }

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

      // Ajouter l'icône edit aux items de contribution
      const itemsContribute = el.querySelectorAll('.menu-item.is-contribution > a');
      const iconEdit = iconTemplate({data: {icon: 'edit'}});
      itemsContribute.forEach(a => a.insertAdjacentHTML('afterbegin', iconEdit));

      // On mobile only
      if (window.matchMedia && window.matchMedia('only screen and (max-width: 1199.9px)').matches) {
        initMobile();
        return;
      }

      // Desktop: initialiser le comportement des sous-menus
      initDesktop();
    }

    function initDesktop() {
      if (!$nav) {
        console.error('Nav element not found');
        return;
      }

      // Chercher les items avec sous-menus dans le menu secondaire
      const menuItems = $nav.querySelectorAll('.header-nav-items > .menu-item-has-children');

      menuItems.forEach((item) => {
        const link = item.querySelector(':scope > a');
        const submenu = item.querySelector(':scope > .sub-menu');

        if (!link || !submenu) return;

        // Empêcher la navigation pour les items parents avec sous-menus
        link.addEventListener('click', (e) => {
          e.preventDefault();
          e.stopPropagation();

          // Fermer tous les autres sous-menus
          menuItems.forEach(otherItem => {
            if (otherItem !== item) {
              const otherSubmenu = otherItem.querySelector(':scope > .sub-menu');
              const otherLink = otherItem.querySelector(':scope > a');

              if (otherSubmenu) {
                otherSubmenu.classList.remove('is-open');
              }
              if (otherLink) {
                otherLink.classList.remove('is-open');
                otherLink.setAttribute('aria-expanded', 'false');
              }
            }
          });

          // Toggle le sous-menu actuel
          const isOpen = submenu.classList.contains('is-open');

          if (isOpen) {
            submenu.classList.remove('is-open');
            link.classList.remove('is-open');
            link.setAttribute('aria-expanded', 'false');
          } else {
            submenu.classList.add('is-open');
            link.classList.add('is-open');
            link.setAttribute('aria-expanded', 'true');
          }
        });

        // Gestion du hover (optionnel)
        item.addEventListener('mouseenter', () => {
          submenu.classList.add('is-open');
          link.setAttribute('aria-expanded', 'true');
        });

        item.addEventListener('mouseleave', () => {
          // Ne fermer que si pas "verrouillé" par un clic
          if (!link.classList.contains('is-open')) {
            submenu.classList.remove('is-open');
            link.setAttribute('aria-expanded', 'false');
          }
        });
      });

      // Fermer les sous-menus en cliquant à l'extérieur
      document.addEventListener('click', (e) => {
        if (!e.target.closest('.header-nav')) {
          menuItems.forEach(item => {
            const submenu = item.querySelector(':scope > .sub-menu');
            const link = item.querySelector(':scope > a');

            if (submenu) submenu.classList.remove('is-open');
            if (link) {
              link.classList.remove('is-open');
              link.setAttribute('aria-expanded', 'false');
            }
          });
        }
      });

      // Support clavier (Escape pour fermer)
      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
          menuItems.forEach(item => {
            const submenu = item.querySelector(':scope > .sub-menu');
            const link = item.querySelector(':scope > a');

            if (submenu) submenu.classList.remove('is-open');
            if (link) {
              link.classList.remove('is-open');
              link.setAttribute('aria-expanded', 'false');
            }
          });
        }
      });
    }

    function initMobile(){
      const container = el.querySelector('.header-container');
      const submenuContainer = el.querySelector('.header-submenu-container');
      const searchBox = el.querySelector('.search-box');

      if (searchBox && container) {
        searchBox.classList.add('is-open');
        container.appendChild(searchBox);
      }

      if (container) {
        container.appendChild(el.querySelector('.header-nav'));
      }

      const headerUses = el.querySelector('.header-nav-usecases');
      if (headerUses && container) {
        container.appendChild(headerUses);
      }

      const headerLinks = el.querySelector('.header-links');
      if (headerLinks && container) {
        container.appendChild(headerLinks);
      }

      // Nettoyer les header-links-item vides
      el.querySelectorAll('.header-links-item').forEach(function(item){
        if (item.textContent.trim() === '') item.remove();
      });

      // Sur mobile, les items avec sous-menus ouvrent un panneau latéral
      const navItems = el.querySelectorAll('.header-nav-items > .menu-item-has-children > a');
      navItems.forEach(n => n.addEventListener('click', openSubmenu));

      $submenuBack = el.querySelector('.header-submenu-back');
      $submenuContainerNav = el.querySelector('.header-submenu-container-nav');
      $toggle = el.querySelector('.header-toggle');

      if ($toggle) $toggle.addEventListener('click', toggleNav);
      if ($submenuBack) $submenuBack.addEventListener('click', closeSubmenu);

      // Références pour compatibilité
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

      if ($submenuContainerNav) {
        $submenuContainerNav.innerHTML = '';
        if (submenu) $submenuContainerNav.appendChild(submenu.cloneNode(true));
      }

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
    if (typeof selector === 'string') {
      const elements = document.querySelectorAll(selector);
      elements.forEach(el => module(el));
    } else {
      // Si c'est déjà un élément DOM
      module(selector);
    }
  };
})();

document.addEventListener('DOMContentLoaded', function(){
  Tela.modules.header('.header');
});
