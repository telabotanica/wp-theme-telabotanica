'use strict';

var feedItemTemplate = require('../feed-item/feed-item.pug');

var _ = _ || {};
_.each = require('lodash.foreach');
var PubSub = require('pubsub-js');
var Tela = window.Tela || {};

Tela.blockDashboardObservations = (function(){

	function blockDashboardObservations(selector){
		var $el = $(selector),
			$titleSuffix,
			$content,
			apiUrl,
			data = {
				total: 0,
				items: []
			};

		function init(){
			$titleSuffix = $el.find('.title-suffix');
			$content = $el.find('.block-dashboard-content');

			// Get the URL to the API from the data-* attribute
			apiUrl = $el.data('apiUrl');

			loadData();
		}

		function loadData(){
			// Call the API
			$.getJSON( apiUrl, function( json ) {
				data.total = json.entete.total;
				_.each(json.resultats, function (item) {
					data.items.push({
						type: 'feed-item',
						href: '#' + item.id_observation,
						image: item.images[0]['binaire.href'].replace('XL.', 'XS.'),
						title: item['determination.ns'] || '???',
						text: 'Le ' + item.date_observation + ' - Par ' + item['auteur.prenom'] + ' ' + item['auteur.nom'],
						meta: {
							place: item.zone_geo
						}
					});
				});
				console.log(data);
				updateSuffix();
				renderContent();
			});
		}

		function updateSuffix(){
			$titleSuffix.text(data.total);
		}

		function renderContent(){
			var content = '';
			_.each(data.items, function(item){
				content += feedItemTemplate({data: item});
			})
			$content.prepend(content);
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
