var algoliaAutocomplete = require('autocomplete.js');
var _ = {
  debounce: require('lodash.debounce')
};

var Tela = window.Tela || {};
Tela.modules = Tela.modules || {};

Tela.modules.profile = (function() {

  function module(selector) {
    var $el = $(selector),
        $searchInputVille,
        $searchInputEspece,
        $currentRequestVille,
        $currentRequestEspece,
        $departement,
        $pays;

    function init() {
      initAutocompleteVille();
      initAutocompleteEspece();
      initRestrictionDepartements();
    }

    function initAutocompleteVille() {
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
      $departement = $el.find('.field_departement');

      linkPaysDepartement();
      $pays.change(linkPaysDepartement);
    }

    /**
     * if chosen country is France, shows the "département" selector; else
     * hides it and clears previously selected "département"
     */
    function linkPaysDepartement() {
      if ($pays.val() === 'France') {
        $departement.show();
      } else {
        $departement.hide().children('select').val('');
      }
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
  Tela.modules.profile('#profile-edit-form, #profile-details-section');
});
