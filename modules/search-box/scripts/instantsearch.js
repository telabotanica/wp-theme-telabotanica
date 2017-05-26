'use strict';

var searchHitTemplate = require('../search-hit/search-hit.pug');
var instantsearch = require('instantsearch.js/dist/instantsearch-preact.js');
var numeral = require('numeral');
require('numeral/locales/fr');
numeral.locale('fr');
var PubSub = require('pubsub-js');
var _ = {
	find: require('lodash.find')
};

var Tela = window.Tela || {};

Tela.searchBoxInstantsearch = (function(){

	function module(selector){
		var $el = $(selector),
			index,
			search,
			$searchInput,
			$button
			;

		function init(){
			// The logic for autocomplete is in script-autocomplete.js
			if ($el.data('autocomplete') === true) {return;}

			$searchInput = $el.find('.search-box-input');
			$button = $el.find('.search-box-button');

			var indexId = $el.find('input[name="index"]').val();
			index = _.find(algolia.autocomplete.sources, ['index_id', indexId]);

			console.log(index);

			search = instantsearch({
				appId: algolia.application_id,
				apiKey: algolia.search_api_key,
				indexName: index.index_name,
				urlSync: {
					mapping: {'q': 's'},
					trackedParameters: ['query', 'attribute:*', 'page', 'hitsPerPage']
				},
				searchFunction: function(helper) {
					// Force index (instead of using the one from the URL)
					search.helper.setIndex(index.index_name);
					helper.search();
				}
			});

			initSearchBox();
			initStats();
			initHits();
			initFilters();

			search.start();
		}

		function initSearchBox(){
			search.addWidget(
				instantsearch.widgets.searchBox({
					container: $el.find('.search-box-wrapper').get(0),
					placeholder: 'Rechercher une plante, un projet, un mot clé...',
					wrapInput: false,
					poweredBy: algolia.powered_by_enabled,
					cssClasses: {
						input: 'search-box-input'
					}
				})
			);

			// Remove other elements
			search.once('render', function(){
				$el.find('.search-box-input:not(.ais-search-box--input)').remove();
				$el.find('.search-box-button').insertAfter($el.find('.ais-search-box--input'));
			})
		}

		function initStats(){
			search.addWidget(
				instantsearch.widgets.stats({
					container: '#search-stats',
					templates: {
						body: function(data) {
							var suffix = ' résultats trouvés';
							if (data.nbHits < 2) {
								suffix = ' résultat trouvé';
							}
							return numeral(data.nbHits).format('0,0') + suffix;
						}
					}
				})
			);
		}

		function initHits(){
			search.addWidget(
				instantsearch.widgets.infiniteHits({
					container: '#search-hits',
					hitsPerPage: 20,
					transformData: {
						item: function(data) {
							data.type = index.index_id;
							return {data: data};
						}
					},
					templates: {
						empty: 'Aucun résultat pour "<strong>{{query}}</strong>".',
						item: searchHitTemplate
					},
					showMoreLabel: 'Plus de résultats'
				})
			);
		}

		function initFilters(){
			$.each(index.filters, function(id, filter){
				search.addWidget(
					instantsearch.widgets[filter.type]({
						container: '#search-filter-' + id,
						attributeName: id,
						limit: 10,
						cssClasses: {
							root: 'search-filters-' + filter.type,
							header: 'search-filters-' + filter.type + '-title',
							list: 'search-filters-' + filter.type + '-items',
							item: 'search-filters-' + filter.type + '-item',
							link: 'search-filters-' + filter.type + '-link',
							active: 'is-active',
							count: 'search-filters-' + filter.type + '-count'
						},
						templates: {
							header: filter.label
						}
					})
				);
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
	Tela.searchBoxInstantsearch('.search-box[data-instantsearch="true"]');
});
