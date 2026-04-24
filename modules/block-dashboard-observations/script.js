/* Vanilla JS version (no jQuery) for Block Dashboard Observations */
(function(){
  function formatDateFR(ts){
    var d = new Date(ts);
    return d.toLocaleDateString('fr-FR', { day: 'numeric', month: 'short', year: 'numeric' });
  }
  function formatNumber(n){ return Number(n).toLocaleString('fr-FR'); }
  // Simple renderer for feed-item
  function renderFeedItem(item){
    return '<li class="feed-item"><a href="' + item.href + '" target="' + item.target + '">' +
      '<img src="' + item.image + '" alt="" /><div class="feed-content"><div class="feed-title">' + item.title + '</div>' +
      '<div class="feed-text">' + item.text + '</div></div></a></li>';
  }

  var Tela = window.Tela || {};
  Tela.modules = Tela.modules || {};

  Tela.modules.blockDashboardObservations = function(selector) {
    var el = document.querySelector(selector);
    var titleSuffix;
    var content;
    var apiUrl;
    var data = {
      total: 0,
      items: []
    };

    function init(){
      titleSuffix = el ? el.querySelector('.title-suffix') : null;
      content = el ? el.querySelector('.block-dashboard-content') : null;
      apiUrl = el ? el.getAttribute('data-api-url') : null;
      loadData();
    }

    function loadData(){
      if (!apiUrl) return;
      fetch(apiUrl)
        .then(function(res){ return res.json(); })
        .then(function(json){
          data.total = json.entete.total;
          (json.resultats || []).forEach(function(item){
            var dateObservation = new Date(item.date_observation);
            data.items.push({
              type: 'feed-item',
              href: 'http://www.tela-botanica.org/appli:identiplante#obs~' + item.id_observation,
              target: '_blank',
              image: item.images[0]['binaire.href'].replace('XL.', 'CRXS.'),
              title: item['determination.ns'] || '?',
              text: 'Observé le ' + formatDateFR(item.date_observation) + ' - Par ' + item['auteur.prenom'] + ' ' + item['auteur.nom'],
              meta: {
                place: item.zone_geo
              }
            });
          });
          updateSuffix();
          renderContent();
        });
    }

    function updateSuffix(){
      if (titleSuffix) titleSuffix.textContent = formatNumber(data.total);
    }

    function renderContent(){
      var contentHTML = '';
      data.items.forEach(function(item){ contentHTML += renderFeedItem(item); });
      if (content){ content.insertAdjacentHTML('afterbegin', contentHTML); }
    }

    init();
  };

  document.addEventListener('DOMContentLoaded', function(){
    Tela.modules.blockDashboardObservations('.block-dashboard-observations');
  });
})();
