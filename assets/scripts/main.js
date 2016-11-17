require('../styles/main.scss');
require('../styles/editor-style.scss');

// Icons
require('../icons/_all.js');

// Composants
// Require all script.js files in the components folder
var req = require.context('../../components/', true, /script\.js$/);
req.keys().forEach(req);
