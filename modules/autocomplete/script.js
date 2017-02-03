'use strict';

var algoliaAutocomplete = require('autocomplete.js');

var Tela = window.Tela || {};

Tela.autocomplete = (function(){

  function autocomplete(selector){
    var $el     = $(selector),
      $searchInput;

    function init(){
      $searchInput = $el.find('.autocomplete-input');

      /* init Algolia client */
  		var client = algoliasearch(algolia.application_id, algolia.search_api_key);

      /* config */
      var config = {
				debug: algolia.debug,
				hint: false,
				openOnFocus: true
			};

  		/* setup sources */
  		var sources = [
        {
          source: function(query, callback) {
            console.log('Recherche', query);
            // TODO: faire la recherche et retourner les résultats dans un tableau
            var hits = [];
            callback(hits);
          };
        }
      ];

      algoliaAutocomplete($searchInput[0], config, sources);

    }

    init();

    return $el;
  }

  return function(selector){
    return $(selector).each(function(){
      autocomplete(this);
    });
  };

})();

$(document).ready(function(){
  Tela.autocomplete('.autocomplete');
});
