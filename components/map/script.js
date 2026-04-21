import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import markerIcon from './marker-icon.png';

var Tela = window.Tela || {};
Tela.components = Tela.components || {};

Tela.components.map = (function(){

  const defaultOptions = {
    center: {lat: 46.5, lng: 2},
    zoom: 5,
    geojson: false // URL of the GeoJSON to display on the map
  };

  function component(selector, userOptions){
    const el = document.querySelector(selector);
    const options = Object.assign({}, defaultOptions, userOptions);
    let $map,
        map;

    function init(){
      $map = el.querySelector('.component-map-map');

      map = L.map($map, {
        center: options.center,
        zoom: options.zoom
      });

      L.tileLayer('https://a.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
      }).addTo(map);

      const icon = L.icon({
        iconUrl: markerIcon,
        iconSize: [25, 41],
        iconAnchor: [12, 41]
      });
      const marker = L.marker(options.center, {icon: icon});
      marker.addTo(map);
    }

    function initOptions(){
      // Read dataset attributes as overrides
      if (el && el.dataset) {
        Object.keys(el.dataset).forEach(function(key){ options[key] = el.dataset[key]; });
      }
    }

    initOptions();
    init();

    return el;
  }

  return function(selector, userOptions){
    const elements = document.querySelectorAll(selector);
    elements.forEach(el => component(el, userOptions));
  };

})();

document.addEventListener('DOMContentLoaded', function(){
  Tela.components.map('.component-map');
  // Dynamically add CSS (temporary fix)
  const head = document.head;
  const link = document.createElement('link');
  link.rel = 'stylesheet';
  link.href = 'https://unpkg.com/leaflet@1.0.3/dist/leaflet.css';
  head.appendChild(link);
});
