'use strict';

var algoliaAutocomplete = require('autocomplete.js');
var _ = {
  debounce: require('lodash.debounce')
};
var Tela = window.Tela || {};

Tela.profile = (function(){

  function module(selector){
    var $el = $(selector),
        $searchInputVille,
        $searchInputEspece,
        $currentRequestVille,
        $currentRequestEspece,
        $pays;

    function initAutocompleteVille(){
      $searchInputVille = $el.find('.field_ville input[type="text"]');
      $currentRequestVille = false;

      /* config */
      var config = {
        hint: false,
        minLength: 3
      };

      /* setup sources */
      var sources = [
        {
          source: _.debounce(function(query, cb) {
            if ($currentRequestVille !== false) {
                $currentRequestVille.abort();
            }
            $currentRequestVille = $.get(
              // @TODO parameterize country - tough because we need the ISO code
              'https://api.tela-botanica.org/service:eflore:0.1/osm/zone-admin/?pays=FR&masque=' + query + '%&limite=20',
              function(data) {
                cb(data);
              }
            );
          }, 300),
          displayKey: 'intitule'
        }
      ];

      algoliaAutocomplete($searchInputVille[0], config, sources);
    }

    function initAutocompleteEspece() {
      $searchInputEspece = $el.find('.field_espece-dinteret input[type="text"]');
      $currentRequestEspece = false;

      /* config */
      var config = {
        hint: false,
        minLength: 3
      };

      /* setup sources */
      var sources = [
        {
          source: _.debounce(function(query, cb) {
            if ($currentRequestEspece !== false) {
                $currentRequestEspece.abort();
            }
            $currentRequestEspece = $.get(
              'http://api.tela-botanica.org/service:eflore:0.1/bdtfx/noms?masque=' + query + '%&retour.format=min&navigation.limite=20&ns.structure=au&retour.tri=alpharet&retour.structure=liste',
              function(data) {
                cb(data.resultat);
              }
            );
          }, 300),
          displayKey: 'nom_sci_complet'
        }
      ];

      algoliaAutocomplete($searchInputEspece[0], config, sources);
    }

    function initRestrictionDepartements() {
      $pays = $el.find('.field_pays > select');
      $pays.click(function() {
        linkPaysDepartement();
      });
      linkPaysDepartement();
    }

    /**
     * if chosen country is France, enables the "département" selector; else
     * disables it and clears previously selected "département"
     */
    function linkPaysDepartement() {
      var departement = $el.find('.field_departement > select');
      var france = $pays.val() == 'France';
      departement.prop('disabled', !france);
      if (! france) {
        departement.val('');
      }
    }

    initAutocompleteVille();
    initAutocompleteEspece();
    initRestrictionDepartements();

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
