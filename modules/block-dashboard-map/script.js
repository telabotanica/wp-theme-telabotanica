/* Vanilla JS version (no jQuery) for BlockDashboardMap module */
(function(){
  // Minimal PubSub shim
  var PubSub = {
    _events: {},
    publish: function(topic, data){
      (this._events[topic] || []).forEach(function(cb){ cb(null, data); });
    },
    subscribe: function(topic, cb){
      this._events[topic] = this._events[topic] || [];
      this._events[topic].push(cb);
    }
  };

  var Tela = window.Tela || {};
  Tela.modules = Tela.modules || {};

  Tela.modules.blockDashboardMap = (function(){
    function module(el){
      var $el = el;
      var titleSuffix;
      var apiUrl;
      var data = { total: 0 };

      function init(){
        titleSuffix = $el.querySelector('.title-suffix');
        apiUrl = $el.getAttribute('data-api-url');
        loadData();
      }

      function loadData(){
        if (!apiUrl) return;
        fetch(apiUrl)
          .then(function(res){ return res.json(); })
          .then(function(json){
            data.total = json.observationsPubliques;
            updateSuffix();
            publishTotalImages(json.imagesLieesPubliques);
          })
          .catch(function(err){ console.error(err); });
      }

      function updateSuffix(){
        if (titleSuffix) titleSuffix.textContent = data.total;
      }

      function publishTotalImages(data){
        PubSub.publish('block-dashboard-map.images', data);
      }

      init();
      return $el;
    }

    return function(selector){
      Array.from(document.querySelectorAll(selector)).forEach(function(el){
        module(el);
      });
    };
  })();

  document.addEventListener('DOMContentLoaded', function(){
    Tela.modules.blockDashboardMap('.block-dashboard-map');
  });
})();
