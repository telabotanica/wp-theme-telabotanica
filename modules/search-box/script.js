// This module has different logic depending on the case
// ESM imports — replaces CommonJS require for Vite compatibility

// Use Algolia autocomplete.js when it has data-autocomplete="true"
import './scripts/autocomplete.js';

// Use Algolia instantsearch.js when it has data-instantsearch="true"
import './scripts/instantsearch.js';
