var searchHitTemplate = require('../../search-hit/search-hit.pug');
var instantsearch = require('instantsearch.js/dist/instantsearch.js');

var moment = require('moment');
moment.locale('fr');

var numeral = require('numeral');
require('numeral/locales/fr');
numeral.locale('fr');

var PubSub = require('pubsub-js');
var _ = {
  find: require('lodash.find')
};

var Tela = window.Tela || {};
Tela.modules = Tela.modules || {};
Tela.modules.searchBox = Tela.modules.searchBox || {};

Tela.modules.searchBox.instantsearch = (function(){

  function module(selector){
    var $el = $(selector),
      index,
      search,
      $initialContent,
      $searchInput,
      $searchFilters,
      $searchHits,
      $button
      ;

    function init(){
      // The logic for autocomplete is in scripts/autocomplete.js
      if ($el.data('autocomplete') === true) {return;}

      $initialContent = $('#content .layout-content > *:not(#search-hits, .breadcrumbs), .layout-column > *:not(.search-filters)');
      $searchInput = $el.find('.search-box-input');
      $searchFilters = $('#search-filters').closest('.search-filters');
      $searchHits = $('#search-hits');
      $button = $el.find('.search-box-button');

      // console.log($initialContent);
      // console.log($searchInput);
      // console.log($searchFilters);
      // console.log($searchHits);
      // console.log($button);

      var indexId = $el.data('index');
      index = _.find(algolia.autocomplete.sources, ['index_id', indexId]);

      var mapping = {};
      if (isSearchPage()) {
        mapping = {'q': 's'};
      }

      var searchParameters = {
        hitsPerPage: 20
      };
      if ($el.data('facetFilters')) {
        searchParameters.facetFilters = $el.data('facetFilters').split(",");
      }

      var options = {
        appId: algolia.application_id,
        apiKey: algolia.search_api_key,
        indexName: index.index_name,
        searchParameters: searchParameters,
        urlSync: {
          mapping: mapping,
          trackedParameters: ['query', 'attribute:*']
        },
        searchFunction: searchFunction
      };

      search = instantsearch(options);

      initSearchBox();
      initStats();
      initHits();
      initFilters();

      search.start();

      // Remove other elements
      $el.find('input.search-box-input:not(.ais-search-box--input)').remove();
      $el.find('.search-box-button').insertAfter($el.find('.ais-search-box--input'));
    }

    function searchFunction(helper) {
      // If no query has been made, do nothing
      if (helper.state.query === '') {
        search.helper.once('result', function() {
          $searchFilters.hide();
          $searchHits.hide();
          $initialContent.show();
        });
      }

      helper.search();

      // Show hits
      $initialContent.hide();
      $searchFilters.show();
      $searchHits.show();
    }

    function initSearchBox(){
      search.addWidget(
        instantsearch.widgets.searchBox({
          container: $el.find('.search-box-wrapper').get(0),
          placeholder: $searchInput.attr('placeholder'),
          poweredBy: algolia.powered_by_enabled,
          wrapInput: false,
          autofocus: false,
          magnifier: false,
          reset: false,
          // the option below can be enabled to limit the number of requests
          // searchOnEnterKeyPressOnly: true,
          cssClasses: {
            input: 'search-box-input'
          }
        })
      );
    }

    function initStats(){
      if ($('#search-stats').length === 0) return;
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
          container: $searchHits.get(0),
          transformData: {
            item: function(data) {
              data.type = index.index_id;

              // Process relative date
              if (data.post_date && data.post_date.timestamp) {
                data.post_date.text = moment.unix(data.post_date.timestamp).fromNow();
              }

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
        // Only menu is supported for now
        if (filter.type != 'menu') return;

        // Support for filters containing a dot
        var containerId = '#search-filter-' + id.replace('.', '_');

        var options = {
          container: containerId,
          attributeName: id,
          limit: 10,
          sortBy: ['count:desc', 'name:asc'],
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
        };

        // Special options for referentiels
        if ('referentiels' == id) {
          options.transformData = transformFilterReferentiel;
          options.templates.item = '<a class="{{cssClasses.link}}" href="{{url}}"><span class="search-hit-tag search-hit-tag-{{value}}">{{label}}</span> {{fullLabel}} <span class="{{cssClasses.count}}">{{#helpers.formatNumber}}{{count}}{{/helpers.formatNumber}}</span></a>';
        }

        search.addWidget(
          instantsearch.widgets[filter.type](options)
        );
      });
    }

    function transformFilterReferentiel(data){
      // TODO: extract this in I18n files
      var full = {
        bdtfx: 'France métropolitaine',
        bdtxa: 'Antilles françaises',
        isfan: 'Afrique du nord',
        apd: 'Afrique tropicale',
      };
      data.fullLabel = full[data.label];
      return data;
    }

    function isSearchPage(){
      return $('body').hasClass('search');
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
  Tela.modules.searchBox.instantsearch('.search-box[data-instantsearch="true"]');
});
