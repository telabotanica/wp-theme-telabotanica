var iconTemplate = require('../icon/icon.pug');

var Tela = window.Tela || {};
Tela.modules = Tela.modules || {};

Tela.modules.footer = (function(){

  function module(selector){
    var $el     = $(selector),
      $toggleNav,
      $nav,
      $itemsMore;

    function init(){
      $toggleNav = $el.find('.footer-nav-toggle button');
      $nav = $el.find('.footer-nav');
      $itemsMore = $el.find('.menu-item-more');

      $toggleNav.on('click', toggleNav);

      var iconArrowRight = iconTemplate({data: {icon: 'arrow-right'}});
      $itemsMore.append(iconArrowRight);
    }

    function toggleNav(){
      $nav.toggle();
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
  Tela.modules.footer('.footer');
});
