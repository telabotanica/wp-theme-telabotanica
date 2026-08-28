require('velocity-animate');
var algoliasearch = require('algoliasearch');
var algoliaAutocomplete = require('autocomplete.js');
var Tether = require('tether');
var PubSub = require('pubsub-js');

var Tela = window.Tela || {};
Tela.modules = Tela.modules || {};
Tela.modules.searchBox = Tela.modules.searchBox || {};

Tela.modules.searchBox.autocomplete = (function () {

  function scrollToWithOffset(el, offset) {
    var top = el.getBoundingClientRect().top + window.pageYOffset + offset;
    window.scrollTo({ top: top, behavior: 'smooth' });
  }

  function module(el) {
    var primarySearchBox,
      client,
      tether,
      config,
      sources = [],
      search,
      index,
      isTiny = false,
      searchInput,
      button,
      wrapper,
      menu,
      suggestions,
      dropdownMinWidth;

    function init() {
      // The logic for instantsearch is in scripts/instantsearch.js
      if (el.dataset.instantsearch === 'true') { return; }

      client = algoliasearch(algolia.application_id, algolia.search_api_key);
      if (!client._ua) client._ua = 'Algolia for JavaScript (4.24.0); Browser; autocomplete.js (0.38.1)';
      wrapper = el.querySelector('.search-box-wrapper');
      searchInput = el.querySelector('.search-box-input');
      button = el.querySelector('.search-box-button');
      primarySearchBox = document.querySelector('.search-box.is-primary');

      // Mobile
      var isMobile = matchMedia('only screen and (max-width: 767.9px)').matches;
      // stop here on mobile
      //if (isMobile) return;

      // Tiny mode
      if (el.classList.contains('tiny')) {
        isTiny = true;
        button.addEventListener('click', onTinyClickButton);

        // There is a primary search box on the page, so we do not setup the autocomplete
        if (primarySearchBox) return;
      }

      suggestions = el.querySelectorAll('.search-box-suggestions a');

      var layoutWrapper = document.querySelector('.layout-wrapper');
      dropdownMinWidth = layoutWrapper ? layoutWrapper.offsetWidth : 0;

      // This ensures that when the dropdown overflows the window, Tether can reposition it.
      document.body.style.overflowX = 'hidden';

      document.addEventListener('click', function (e) {
        var link = e.target.closest('.algolia-powered-by-link');
        if (!link) return;
        e.preventDefault();
        window.location = 'https://www.algolia.com/?utm_source=WordPress&utm_medium=extension&utm_content=' + window.location.hostname + '&utm_campaign=poweredby';
      });

      suggestions.forEach(function (suggestion) {
        suggestion.addEventListener('click', onClickSuggestion);
      });

      initConfig();
      initSources();
      initAutocomplete();
      initTether();
    }

    function onTinyClickButton(e) {
      if (primarySearchBox) {
        e.preventDefault();
        scrollToWithOffset(primarySearchBox, -250);
        var primaryInput = primarySearchBox.querySelector('.search-box-input');
        if (primaryInput) primaryInput.focus();
      } else if (!el.classList.contains('is-open')) {
        e.preventDefault();
        el.classList.add('is-open');
        searchInput.focus();
      }
    }

    function initConfig() {
      config = {
        debug: algolia.debug,
        hint: false,
        openOnFocus: true,
        templates: {
          dropdownMenu: '#tmpl-dropdown-menu'
        }
      };

      if (algolia.powered_by_enabled) {
        config.templates.footer = wp.template('autocomplete-footer');
      }
    }

    function initSources() {
      algolia.autocomplete.sources.forEach(function (sourceConfig) {
        var idx = client.initIndex(sourceConfig.index_name);
        if (!idx.as) idx.as = client;
        if (!idx.indexName) idx.indexName = sourceConfig.index_name;
        sources.push({
          source: algoliaAutocomplete.sources.hits(idx, sourceConfig.settings),
          templates: {
            header: function (data, algoliaResponse) {
              return wp.template('autocomplete-header')({
                label: sourceConfig.label,
                nbHits: algoliaResponse.nbHits,
                resultsUrl: algolia.home_url + '/?s=' + algoliaResponse.query + '&in=' + sourceConfig.index_id
              });
            },
            empty: wp.template('autocomplete-empty'),
            suggestion: wp.template(sourceConfig.tmpl_suggestion)
          }
        });
      });
    }

    function initAutocomplete() {
      search = algoliaAutocomplete(searchInput, config, sources)
        .on('autocomplete:selected', function (e, suggestion, datasetName) {
          /* Redirect the user when we detect a suggestion selection. */
          window.location.href = suggestion.permalink;
        });
    }

    function initTether() {
      /* Remove autocomplete.js default inline input search styles. */
      el.removeAttribute('style');

      menu = el.querySelector('.aa-dropdown-menu');
      var tetherConfig = {
        element: menu,
        target: wrapper,
        attachment: isTiny ? 'top right' : 'top left',
        targetAttachment: isTiny ? 'bottom right' : 'bottom left',
        offset: isTiny ? '-9px 0' : '-5px 0',
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
      tether.on('update', function (item) {
        /* todo: fix the inverse of this: https://github.com/HubSpot/tether/issues/182 */
        if (item.attachment.left == 'right' && item.attachment.top == 'top' && item.targetAttachment.left == 'left' && item.targetAttachment.top == 'bottom') {
          config.attachment = 'top right';
          config.targetAttachment = 'bottom right';

          tether.setOptions(config, false);
        }
      });
      searchInput.addEventListener('autocomplete:updated', function () {
        tether.position();
      });
      searchInput.addEventListener('autocomplete:opened', function () {
        updateDropdownWidth();
      });

      /* Trick to ensure the autocomplete is always above all. */
      menu.style.zIndex = '99999';

      /* Makes dropdown match the input size. */
      window.addEventListener('resize', updateDropdownWidth);
    }

    function updateDropdownWidth() {
      var inputWidth = searchInput.offsetWidth;
      if (inputWidth >= dropdownMinWidth) {
        menu.style.width = inputWidth + 'px';
      } else {
        menu.style.width = dropdownMinWidth + 'px';
      }
      tether.position();
    }

    function onClickSuggestion(e) {
      e.preventDefault();
      search.autocomplete.setVal(this.textContent);
      searchInput.focus();
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
  Tela.modules.searchBox.autocomplete('.search-box[data-autocomplete="true"]');
});
