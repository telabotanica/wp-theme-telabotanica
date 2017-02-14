'use strict';

var algoliasearch = require('algoliasearch');
var algoliaAutocomplete = require('autocomplete.js');
var Tether = require('tether');

var Tela = window.Tela || {};

Tela.searchBox = (function(){

  function module(selector){
    var $el = $(selector),
      client,
      tether,
      config,
      sources = [],
      search,
      $searchInput,
      $wrapper,
      $menu,
      $suggestions,
      dropdownMinWidth;

    function init(){
      client = algoliasearch(algolia.application_id, algolia.search_api_key);
      $wrapper = $el.find('.search-box-wrapper');
      $searchInput = $el.find('.search-box-input');
      $suggestions = $el.find('.search-box-suggestions a');

      dropdownMinWidth = $('.layout-wrapper').first().outerWidth();

      /* This ensures that when the dropdown overflows the window, Thether can reposition it. */
      $('body').css('overflow-x', 'hidden');

      $(document).on("click", ".algolia-powered-by-link", function(e) {
        e.preventDefault();
        window.location = "https://www.algolia.com/?utm_source=WordPress&utm_medium=extension&utm_content=" + window.location.hostname + "&utm_campaign=poweredby";
      });

      $suggestions.on('click', onClickSuggestion);

      initConfig();
      initSources();
      initAutocomplete();
      initTether();
    }

    function initConfig(){
      config = {
        debug: algolia.debug,
        hint: false,
        openOnFocus: true,
        templates: {
          dropdownMenu: '#tmpl-dropdown-menu'
        }
      };

      if(algolia.powered_by_enabled) {
        config.templates.footer = wp.template('autocomplete-footer');
      }
    }

    function initSources(){
      $.each(algolia.autocomplete.sources, function(i, config) {
        sources.push({
          source: algoliaAutocomplete.sources.hits(client.initIndex(config['index_name']), {
            hitsPerPage: config['max_suggestions'],
            facetFilters: config['default_facet_filters']
          }),
          templates: {
            header: function(data, algoliaResponse) {
              return wp.template('autocomplete-header')({
                label: config['label'],
                nbHits: algoliaResponse.nbHits,
                resultsUrl: '#' // TODO compose URL
              });
            },
            empty: wp.template('autocomplete-empty'),
            suggestion: wp.template(config['tmpl_suggestion'])
          }
        });

      });
    }

    function initAutocomplete(){
      search = algoliaAutocomplete($searchInput[0], config, sources)
        .on('autocomplete:selected', function(e, suggestion, datasetName) {
          /* Redirect the user when we detect a suggestion selection. */
          window.location.href = suggestion.permalink;
        });
    }

    function initTether(){
      /* Remove autocomplete.js default inline input search styles. */
      $el.removeAttr('style');

      $menu = $el.find('.aa-dropdown-menu');
      var tetherConfig = {
        element: $menu,
        target: $wrapper,
        attachment: 'top left',
        targetAttachment: 'bottom left',
        constraints: [
          {
            to: 'window',
            attachment: 'none element'
          }
        ]
      };

      /* This will make sure the dropdown is no longer part of the same container as */
      /* the search input container. */
      /* It ensures styles are not overridden and limits theme breaking. */
      tether = new Tether(tetherConfig);
      tether.on('update', function(item) {
        /* todo: fix the inverse of this: https://github.com/HubSpot/tether/issues/182 */
        if (item.attachment.left == 'right' && item.attachment.top == 'top' && item.targetAttachment.left == 'left' && item.targetAttachment.top == 'bottom') {
          config.attachment = 'top right';
          config.targetAttachment = 'bottom right';

          tether.setOptions(config, false);
        }
      });
      $searchInput.on('autocomplete:updated', function() {
        tether.position();
      });
      $searchInput.on('autocomplete:opened', function() {
        updateDropdownWidth();
      });

      /* Trick to ensure the autocomplete is always above all. */
      $menu.css('z-index', '99999');

      /* Makes dropdown match the input size. */
      $(window).on('resize', updateDropdownWidth);
    }

    function updateDropdownWidth() {
      var inputWidth = $searchInput.outerWidth();
      if (inputWidth >= dropdownMinWidth) {
        $menu.css('width', $searchInput.outerWidth());
      } else {
        $menu.css('width', dropdownMinWidth);
      }
      tether.position();
    }

    function onClickSuggestion(e) {
      e.preventDefault();
      search.autocomplete.setVal($(this).text());
      $searchInput.focus();
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
  Tela.searchBox('.search-box');
});
