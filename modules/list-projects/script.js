'use strict';

var PubSub = require('pubsub-js');
var cardProjectTemplate = require('../card-project/card-project.pug');

var Tela = window.Tela || {};

Tela.listProjects = (function(){

	function module(selector){
		var $el = $(selector),
			savedContent
			;

		function init(){
			savedContent = $el.html();

			PubSub.subscribe('search-box.results', onSearchBoxResults);
		}

		function onSearchBoxResults(e, data) {

			// Pas de recherche
			if (data === false || data.query === '') {
				$el.html(savedContent);
				return;
			}

			// Recherche sans résultats
			if (data.nbHits === 0) {
				$el.html('Aucun resultat'); // TODO I18n
				return;
			}

			// Recherche avec résultats
			var cards = [];
			$.each(data.hits, function(i, hit){
				var cardData = {
					tag: 'li',
					data: {
						permalink: hit.permalink,
						cover_image_url: '', // TODO
						tela: true, // TODO s'il s'agit d'un projet Tela
						tela_title: 'Un projet Tela Botanica', // TODO I18n
						avatar: hit.image,
						name: hit._highlightResult.name.value,
						description: hit._highlightResult.description.value,
						meta: [
							{icon: 'members', 'text': 'X membres'} // TODO with I18n
						]
					}
				};
				cards.push(cardProjectTemplate(cardData));
			});

			$el.html(cards.join(''));
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
	Tela.listProjects('.list-projects');
});
