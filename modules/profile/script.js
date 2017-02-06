'use strict';

var algoliaAutocomplete = require('autocomplete.js');
var _ = {
  debounce: require('lodash.debounce')
};
var Tela = window.Tela || {};

Tela.profile = (function(){

  function module(selector){
    var $el = $(selector),
        $searchInput,
        $currentRequest;

    function init(){
      $searchInput = $el.find('.field_ville input[type="text"]');
      $currentRequest = false;

      /* config */
      var config = {
        hint: false,
        minLength: 3
      };

      /* setup sources */
      var sources = [
        {
          source: _.debounce(function(query, cb) {
            if ($currentRequest !== false) {
                $currentRequest.abort();
            }
            $currentRequest = $.get(
              // @TODO parameterize country - tough because we need the ISO code
              'http://api.tela-botanica.org/service:eflore:0.1/osm/zone-admin/?pays=FR&masque=' + query + '%&limite=20',
              function(data) {
                cb(data);
              }
            );
          }, 300),
          displayKey: 'intitule'
        }
      ];

      algoliaAutocomplete($searchInput[0], config, sources);
    }

    init();

    return $el;
  }

  return function(selector){
    $(selector).each(function() {
      module(this);
    });
  };

})();

$(document).ready(function(){
  Tela.profile('#profile-edit-form, #profile-details-section');
});
