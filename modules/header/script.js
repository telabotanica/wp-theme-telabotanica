require('accessible-mega-menu');
var iconTemplate = require('../icon/icon.pug');

var Tela = window.Tela || {};
Tela.modules = Tela.modules || {};

Tela.modules.header = (function(){

	function module(selector){
		var $el = $(selector),
			$nav;

		function init(){
			$nav = $el.find('.header-nav');
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
