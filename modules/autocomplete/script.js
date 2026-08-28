var algoliaAutocomplete = require('autocomplete.js');

var Tela = window.Tela || {};
Tela.modules = Tela.modules || {};

Tela.modules.autocomplete = (function () {

  function debounce(fn, delay) {
    var timer = null;
    return function () {
      var args = arguments;
      var context = this;
      clearTimeout(timer);
      timer = setTimeout(function () {
        fn.apply(context, args);
      }, delay);
    };
  }

  function module(el) {
    var searchInput = el.querySelector('.autocomplete-input');

    function init() {
      /* config */
      var config = {
        debug: algolia.debug,
        hint: false,
        openOnFocus: true
      };

      /* setup sources */
      var sources = [
        {
          source: debounce(function (query, cb) {
            console.log('Recherche', query, cb);
            // TODO: faire la recherche et retourner les résultats dans un tableau
            var hits = [];
            cb(hits);
          }, 150)
        }
      ];

      algoliaAutocomplete(searchInput, config, sources);
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
  Tela.modules.autocomplete('.autocomplete');
});
