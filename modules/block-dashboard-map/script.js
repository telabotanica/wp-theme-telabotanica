var PubSub = require('pubsub-js');

var Tela = window.Tela || {};
Tela.modules = Tela.modules || {};

Tela.modules.blockDashboardMap = (function(){

	function module(selector){
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
			PubSub.publish('block-dashboard-map.images', data);
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
	Tela.modules.blockDashboardMap('.block-dashboard-map');
});
