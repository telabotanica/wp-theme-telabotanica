// Require all *.svg files in the current folder
var req = require.context('./', true, /.*\.svg$/);
req.keys().forEach(req);
