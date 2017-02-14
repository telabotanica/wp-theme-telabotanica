'use strict';

var algoliaAutocomplete = require('autocomplete.js');
var _ = {
  debounce: require('lodash.debounce')
};

var Tela = window.Tela || {};

Tela.autocomplete = (function(){

  function autocomplete(selector){
    var $el     = $(selector),
      $searchInput;

    function init(){
      $searchInput = $el.find('.autocomplete-input');

      /* config */
      var config = {
        debug: algolia.debug,
        hint: false,
        openOnFocus: true
      };

      /* setup sources */
      var sources = [
        {
          source: _.debounce(function(query, cb) {
            console.log('Recherche', query, cb);
            // TODO: faire la recherche et retourner les résultats dans un tableau
            var hits = [];
            cb(hits);
          }, 150)
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
