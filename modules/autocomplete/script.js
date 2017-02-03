'use strict';

var algoliaAutocomplete = require('autocomplete.js');

var Tela = window.Tela || {};

Tela.autocomplete = (function(){

  function autocomplete(selector){
    var $el     = $(selector),
      $searchInput;

    function init(){
      $searchInput = $el.find('.autocomplete-input');

      /* config */
      var config = {
        debug: true,
        hint: false,
        openOnFocus: true
      };

      /* setup sources */
      var sources = [
        {
          source: function(query, cb) {
            console.log('Recherche', query, cb);
            // TODO: faire la recherche et retourner les résultats dans un tableau
            var hits = [];
            cb(hits);
          }
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
