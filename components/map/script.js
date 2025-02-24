var L = require('leaflet');

var Tela = window.Tela || {};
Tela.components = Tela.components || {};

Tela.components.map = (function(){

  var defaultOptions = {
    center: {lat: 46.5, lng: 2},
    zoom: 5,
    geojson: false // URL of the GeoJSON to display on the map
  };

  function component(selector, userOptions){
    var $el = $(selector),
      options = $.extend({}, defaultOptions, userOptions),
      $map,
      map;

    function init(){
      $map = $el.find('.component-map-map');

      map = L.map($map.get(0), {
        center: options.center,
        zoom: options.zoom
      });

      L.tileLayer('https://a.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
      }).addTo(map);

      var icon = new L.icon({
        iconUrl: require("./marker-icon.png"),
        iconSize: [25, 41],
        iconAnchor: [12, 41]
      });
      var marker = L.marker(options.center, {icon: icon});
      marker.addTo(map);
    }

    function initOptions(){
      $.each($el.data(), function(key, value){
        options[key] = value;
      });
    }

    initOptions();
    init();

    return $el;
  }

  return function(selector, userOptions){
    return $(selector).each(function(){
      component(this, userOptions);
    });
  };

})();

$(document).ready(function(){
  Tela.components.map('.component-map');

  // Dynamically add CSS (temporary fix)
  $('head').append('<link href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css" rel="stylesheet" />');
});
