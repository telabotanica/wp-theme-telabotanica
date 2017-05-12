'use strict';

var PubSub = require('pubsub-js');
var Tela = window.Tela || {};

Tela.blockDashboardObservations = (function(){

	function blockDashboardObservations(selector){
		var $el = $(selector),
			$titleSuffix,
			apiUrl,
			data = {
				total: 0
			};

		function init(){
			$titleSuffix = $el.find('.title-suffix');

			// Get the URL to the API from the data-* attribute
			apiUrl = $el.data('apiUrl');

			loadData();
		}

		function loadData(){
			// Call the API
			$.getJSON( apiUrl, function( json ) {
				data.total = json.observations;
				updateSuffix();
				publishTotalImages(json.images);
			});
		}

		function updateSuffix(){
			$titleSuffix.text(data.total);
		}

		function publishTotalImages(data){
			// data contains the total of images for this user
			PubSub.publish('block-dashboard-observations.images', data);
		}


		init();

		return $el;
	}

	return function(selector){
		return $(selector).each(function(){
			blockDashboardObservations(this);
		});
	};

})();

$(document).ready(function(){
	Tela.blockDashboardObservations('.block-dashboard-observations');
});
