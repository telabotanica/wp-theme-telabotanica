var feedItemTemplate = require('../feed-item/feed-item.pug');

var _ = _ || {};
_.each = require('lodash.foreach');
_.flatten = require('lodash.flatten');
_.groupBy = require('lodash.groupby');
_.map = require('lodash.map');
_.maxBy = require('lodash.maxby');
_.sortBy = require('lodash.sortby');

var moment = require('moment');
moment.locale('fr');

var Tela = window.Tela || {};
Tela.modules = Tela.modules || {};

Tela.modules.feed = (function(){

	function module(selector){
		var $el = $(selector),
			$content,
			apiUrls = {},
			maxItems = 8, // ?
			data = {
				items: []
			};

		function init(){
			$content = $el.find('.feed-items');

			// Get the URL to the API from the data-* attribute
			apiUrls = {
				actualites: 'http://localhost/test/wp-json/wp/v2/posts?author=1&_embed',
				// @TODO vraies URL et format CRXS
				observations: 'http://localhost/test/wp-content/themes/telabotanica/modules/feed/observations.json',
				images: 'http://localhost/test/wp-content/themes/telabotanica/modules/feed/images.xml'
			};

			loadData();
		}

		function loadData(){
			// Call the APIs
			console.log('load data !');
			$.when(loadActualites(), loadObservations(), loadImages())
				.then(renderContent);
		}

		function loadActualites() {
			console.log('load actu !');
			return $.getJSON(apiUrls.actualites, function(json){
				_.each(json, function (item) {
					data.items.push({
						type: 'feed-item',
						article: true,
						href: item.link,
						image: 'wp:featuredmedia' in item._embedded ? item._embedded['wp:featuredmedia'][0].media_details.sizes.thumbnail.source_url : false,
						title: item.title.rendered,
						date: item.modified_gmt,
						day: item.modified_gmt.substring(0,10),
						text: item.excerpt.rendered,
						meta: {
							categories: 'wp:term' in item._embedded ? _.map(item._embedded['wp:term'][0], function(term) {
								return term.name;
							}) : []
						}
					});
				});
			});
		}

		function loadObservations() {
			console.log('load obs !');
			return $.getJSON(apiUrls.observations, function(json){
				_.each(json.resultats, function (item) {
					data.items.push({
						type: 'feed-item',
						href: 'http://www.tela-botanica.org/appli:identiplante#obs~' + item.id_observation,
						image: ('images' in item && item.images.length) ? item.images[0]['binaire.href'] : false,
						title: item['determination.ns'],
						date: item.date_transmission,
						day: item.date_transmission.substring(0,10),
						text: "Nouvelle observation ajoutée au Carnet en Ligne",
						meta: {
							place: item.zone_geo
						}
					});
				});
			});
		}

		function loadImages() {
			console.log('load img !');
			return $.ajax({
				type: "GET",
				url: apiUrls.images,
				dataType: "xml",
				success: function(xml){
					var images = [];
					$(xml).find('entry').each(function(){
						var $this = $(this);
						var date = $this.find('updated').text();
						images.push({
							date: date,
							day: date.substring(0,10),
							image: $this.find('id').text().replace('L.', 'CRXS.')
						});
					});

					// grouper par jour
					var imagesByDay = _.groupBy(images, 'day');

					// pousser des multi-items
					_.each(imagesByDay, function (item, day) {
						data.items.push({
							type: 'feed-item',
							href: 'http://www.tela-botanica.org/appli:cel',
							images: _.map(item, 'image').slice(0,maxItems),
							title: item.length + ' photo' + (item.length > 1 ? 's' : '') + ' ajoutée' + (item.length > 1 ? 's' : ''),
							date: _.maxBy(item, 'date'),
							day: item[0].day,
							text: 'Au Carnet en Ligne',
							meta: {
								text: ''
							}
						});
					});
				}
			});
		}

		function renderContent(){
			console.log('renderContent');
			data.items = _.sortBy(data.items, 'date');
			data.items = data.items.reverse();
			data.items = _.groupBy(data.items, 'day');
			var groupedItems = [];
			for (var day in data.items) {
				groupedItems.push({
					type: 'feed-date',
					text: moment(day).calendar()
				});
				groupedItems.push(data.items[day]);
			}
			data.items = _.flatten(groupedItems);

			console.log(data.items);

			var content = '';
			_.each(data.items, function(item){
				content += feedItemTemplate({data: item});
			});
			$content.append(content);
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
	Tela.modules.feed('.feed');
});
