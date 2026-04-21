var feedItemTemplate = require('./../feed-item/feed-item');

var moment = require('moment');
moment.locale('fr');

var numeral = require('numeral');
require('numeral/locales/fr');
numeral.locale('fr');

var Tela = window.Tela || {};
Tela.modules = Tela.modules || {};

Tela.modules.blockDashboardObservations = function(selector) {

  var $el = $(selector),
    $titleSuffix,
    $content,
    apiUrl,
    data = {
      total: 0,
      items: []
    };

  function init() {
    $titleSuffix = $el.find('.title-suffix');
    $content = $el.find('.block-dashboard-content');
    apiUrl = $el.data('apiUrl');
    loadData();
  }

  function loadData() {
    $.getJSON(apiUrl, function(json) {

      data.total = json.entete.total;

      json.resultats.forEach(function(item) {
        var dateObservation = moment(item.date_observation);

        data.items.push({
          type: 'feed-item',
          href: 'http://www.tela-botanica.org/appli:identiplante#obs~' + item.id_observation,
          target: '_blank',
          image: item.images[0]['binaire.href'].replace('XL.', 'CRXS.'),
          title: item['determination.ns'] || '?',
          text: 'Observé le ' + dateObservation.format('ll') + ' - Par ' + item['auteur.prenom'] + ' ' + item['auteur.nom'],
          meta: {
            place: item.zone_geo
          }
        });
      });

      updateSuffix();
      renderContent();
    });
  }

  function updateSuffix() {
    $titleSuffix.text(numeral(data.total).format('0,0'));
  }

  function renderContent() {
    var content = '';

    data.items.forEach(function(item) {
      content += feedItemTemplate({data: item});
    });

    $content.prepend(content);
  }

  init();

  return $el;
};

$(document).ready(function() {
  Tela.modules.blockDashboardObservations('.block-dashboard-observations');
});
