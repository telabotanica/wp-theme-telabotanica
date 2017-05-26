'use strict';

// This module has different logic depending on the case

// Use Algolia autocomplete.js when it has data-autocomplete="true"
require('./scripts/autocomplete.js');

// Use Algolia instantsearch.js when it has data-instantsearch="true"
require('./scripts/instantsearch.js');
