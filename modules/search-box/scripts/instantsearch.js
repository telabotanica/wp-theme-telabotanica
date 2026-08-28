var searchHitTemplate = require('../../search-hit/search-hit.js');
var instantsearch = require('instantsearch.js/dist/instantsearch.js');

var moment = require('moment');
moment.locale('fr');

var numeral = require('numeral');
require('numeral/locales/fr');
numeral.locale('fr');

var PubSub = require('pubsub-js');

var Tela = window.Tela || {};
Tela.modules = Tela.modules || {};
Tela.modules.searchBox = Tela.modules.searchBox || {};

Tela.modules.searchBox.instantsearch = (function () {

  function module(el) {
    var index,
      search,
      initialContent,
      searchInput,
      searchFilters,
      searchHits,
      button
    ;

    function init() {
      // The logic for autocomplete is in scripts/autocomplete.js
      if (el.dataset.autocomplete === 'true') { return; }

      var content = document.getElementById('content');
      initialContent = content
        ? content.querySelectorAll('.layout-content > *:not(#search-hits, .breadcrumbs), .layout-column > *:not(.search-filters)')
        : [];
      searchInput = el.querySelector('.search-box-input');
      var searchFiltersAnchor = document.getElementById('search-filters');
      searchFilters = searchFiltersAnchor ? searchFiltersAnchor.closest('.search-filters') : null;
      searchHits = document.getElementById('search-hits');
      button = el.querySelector('.search-box-button');

      var indexId = el.dataset.index;
      index = algolia.autocomplete.sources.find(function (source) {
        return source.index_id === indexId;
      });

      var mapping = {};
      if (isSearchPage()) {
        mapping = { 'q': 's' };
      }

      var searchParameters = {
        hitsPerPage: 20
      };
      if (el.dataset.facetFilters) {
        searchParameters.facetFilters = el.dataset.facetFilters.split(',');
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
      var legacyInputs = el.querySelectorAll('input.search-box-input:not(.ais-search-box--input)');
      legacyInputs.forEach(function (input) {
        input.style.display = 'none';
      });

      var aisInput = el.querySelector('.ais-search-box--input');
      if (aisInput && button && aisInput.parentNode) {
        aisInput.parentNode.insertBefore(button, aisInput.nextSibling);
      }
    }

    function searchFunction(helper) {
      // If no query has been made, do nothing
      if (helper.state.query === '') {
        search.helper.once('result', function () {
          if (searchFilters) searchFilters.style.display = 'none';
          if (searchHits) searchHits.style.display = 'none';
          initialContent.forEach(function (item) {
            item.style.display = '';
          });
        });

        helper.search();
      } else {
        helper.search();

        // Show hits
        initialContent.forEach(function (item) {
          item.style.display = 'none';
        });
        if (searchFilters) searchFilters.style.display = '';
        if (searchHits) searchHits.style.display = '';
      }
    }

    function initSearchBox() {
      search.addWidget(
        instantsearch.widgets.searchBox({
          container: el.querySelector('.search-box-wrapper'),
          placeholder: searchInput.getAttribute('placeholder'),
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

    function initStats() {
      if (!document.getElementById('search-stats')) return;
      search.addWidget(
        instantsearch.widgets.stats({
          container: '#search-stats',
          templates: {
            body: function (data) {
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

    function initHits() {
      search.addWidget(
        instantsearch.widgets.infiniteHits({
          container: searchHits,
          transformData: {
            item: function (data) {
              data.type = index.index_id;

              // Process relative date
              if (data.post_date && data.post_date.timestamp) {
                data.post_date.text = moment.unix(data.post_date.timestamp).fromNow();
              }

              return { data: data };
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

    function initFilters() {
      Object.keys(index.filters).forEach(function (id) {
        var filter = index.filters[id];

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

    function transformFilterReferentiel(data) {
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

    function isSearchPage() {
      return document.body.classList.contains('search');
    }

    init();

    return el;
  }

  return function (selector) {
    var elements = document.querySelectorAll(selector);
    elements.forEach(function (el) {
      module(el);
    });
    return elements;
  };

})();

function ready(fn) {
  if (document.readyState !== 'loading') {
    fn();
  } else {
    document.addEventListener('DOMContentLoaded', fn);
  }
}

ready(function () {
  Tela.modules.searchBox.instantsearch('.search-box[data-instantsearch="true"]');
});
