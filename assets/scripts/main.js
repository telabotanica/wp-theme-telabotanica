require('../styles/main.scss');
require('../styles/editor-style.scss');
require('../styles/login-style.scss');

// Icons
require('../icons/_all.js');

// Lazyload
var LazyLoad = require('vanilla-lazyload');
var lazy = new LazyLoad({
  elements_selector: "iframe.lazyload"
});

// Responsive
require('matchmedia-polyfill');
require('./responsive.js');

// Modules
// Require all script.js files in the modules folder
var req = require.context('../../modules/', true, /script\.js$/);
req.keys().forEach(req);

// Blocks
// Require all script.js files in the blocks folder
var req = require.context('../../blocks/', true, /script\.js$/);
req.keys().forEach(req);

// Composants
// Require all script.js files in the components folder
var req = require.context('../../components/', true, /script\.js$/);
req.keys().forEach(req);
