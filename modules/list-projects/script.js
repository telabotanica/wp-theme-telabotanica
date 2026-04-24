/* Vanilla JS version (no jQuery) for List Projects module */
(function(){
  // Simple PubSub shim to replace pubsub-js usage
  var PubSub = window.PubSub || {
    _events: {},
    subscribe: function(topic, cb){
      this._events[topic] = this._events[topic] || [];
      this._events[topic].push(cb);
    },
    publish: function(topic, data){
      (this._events[topic] || []).forEach(function(cb){ cb(null, data); });
    }
  };

  // Minimal renderer for project card (replacing card-project template)
  function renderCardFromHit(hit){
    var title = (hit._highlightResult && hit._highlightResult.name && hit._highlightResult.name.value) || '';
    var description = (hit._highlightResult && hit._highlightResult.description && hit._highlightResult.description.value) || '';
    var avatar = hit.image || '';
    var permalink = hit.permalink || '#';
    return '<li class="card-project"><a href="' + permalink + '"><img src="' + avatar + '" alt="" /><div class="card-content"><h4>' + title + '</h4><p>' + description + '</p></div></a></li>';
  }

  var Tela = window.Tela || {};
  Tela.modules = Tela.modules || {};

  Tela.modules.listProjects = (function(){
    function module(el){
      var container = el;
      var savedContent;

      function init(){
        savedContent = container.innerHTML;
        PubSub.subscribe('search-box.results', onSearchBoxResults);
      }

      function onSearchBoxResults(e, data) {
        if (data === false || data.query === '') {
          container.innerHTML = savedContent;
          return;
        }
        if (data.nbHits === 0) {
          container.innerHTML = 'Aucun resultat';
          return;
        }
        var cards = [];
        (data.hits || []).forEach(function(hit){
          cards.push(renderCardFromHit(hit));
        });
        container.innerHTML = cards.join('');
      }

      init();
    }

    return function(selector){
      Array.from(document.querySelectorAll(selector)).forEach(function(el){
        module(el);
      });
    };
  })();

  document.addEventListener('DOMContentLoaded', () => {
    Tela.modules.listProjects('.list-projects');
  });
})();
