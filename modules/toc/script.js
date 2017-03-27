'use strict';

var _ = _ || {};
_.defer = require('lodash.defer');
_.each = require('lodash.foreach');
_.map = require('lodash.map');
_.throttle = require('lodash.throttle');

require('./affix.js');
var Tela = window.Tela || {};

Tela.toc = (function(){

	var defaultOptions = {
		anchorsSelector: '.component-title.level-2 .component-title-anchor'
	};

	function module(selector, userOptions){
		var $el = $(selector),
			options = $.extend({}, defaultOptions, userOptions),
			items,
			headerHeight,
			currentItemId,
			$articleContainer,
			$anchors;

		function init(){
			headerHeight = $('.header-nav').height();

			$articleContainer = $('.layout-content article');
			$anchors = $articleContainer.find(options.anchorsSelector);

			if ($anchors.length) {
				_.defer(parseItems);
				$(window).on('scroll', _.throttle(onScroll, 250));
			}

			setAffix();
		}

		function initOptions() {
			$.each($el.data(), function(key, value){
				options[key] = value;
			});
		}

		function parseItems() {
			items = _.map($anchors, function(anchor, index) {
				var $anchor = $(anchor);
				return {
					id: $anchor.attr('name'),
					top: $anchor.offset().top
				};
			});

			_.each(items, function (item, index, list) {
				item.bottom = (list[index+1]) ? list[index+1].top : $articleContainer.position().top + $articleContainer.height();
			});

			onScroll();
		}

		function onScroll() {
			var scrollTop = $(window).scrollTop();

			_.each(items, function (item, index, list) {
				if (scrollTop > item.top - headerHeight
				 && scrollTop < item.bottom - headerHeight
				 && currentItemId != item.id) {
					currentItemId = item.id;
					$el.find('.toc-subitem').removeClass('is-active');
					$el.find('a[href="#' + item.id + '"]').closest('.toc-subitem').addClass('is-active');
				}
			});
		}

		function setAffix(){
			// no affix if there is not enough space to show the whole element
			if ($el.height() > window.innerHeight - headerHeight - 100) return;

			// no affix if the parent is not tall enough
			if ($el.height() > $el.closest('.layout-column').height() - 50) return;

			$el.affix({
				offset: {
					top: $el.offset().top - headerHeight,
					bottom: $('body').height() - $('.footer').offset().top + headerHeight + 50
				}
			});
		}

		initOptions();
		init();

		return $el;
	}

	return function(selector, userOptions){
		return $(selector).each(function(){
			module(this, userOptions);
		});
	};

})();

$(document).ready(function(){
	Tela.toc('.toc');
});
