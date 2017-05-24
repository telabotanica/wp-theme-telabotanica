'use strict';

var iconTemplate = require('../icon/icon.pug');

var Tela = window.Tela || {};

Tela.footer = (function(){

	function footer(selector){
		var $el		 = $(selector),
			$itemsMore;

		function init(){
			$itemsMore = $el.find('.menu-item-more');

			var iconArrowRight = iconTemplate({data: {icon: 'arrow-right'}});
			$itemsMore.append(iconArrowRight);
		}

		init();

		return $el;
	}

	return function(selector){
		return $(selector).each(function(){
			footer(this);
		});
	};

})();

$(document).ready(function(){
	Tela.footer('.footer');
});
