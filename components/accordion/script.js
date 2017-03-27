'use strict';

require('jquery-accessible-accordion-aria/jquery-accessible-accordion-aria.js');

$(function () {
	$('.js-accordion').each(function(i){
		$(this).attr('id', 'js-accordion_' + i).accordion();
	});
});
