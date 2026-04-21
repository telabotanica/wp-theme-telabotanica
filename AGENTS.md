Yes: Run npm install in the theme directory to install JS dependencies.
Yes: Run composer install in the theme directory to install PHP dependencies.
Yes: Algolia is no longer used; remove Algolia constants from wp-config.php and any Algolia indexing code or references.
Yes: For development, run npm start to watch files and auto-recompile.
Yes: For production/build, run npm run build to generate dist/bundle.css and dist/bundle.js (and inline SVGs).
Yes: The build consumes assets/styles/main.scss and assets/scripts/main.js; ensure these exist before building.
Yes: On the server, deploy by pulling the latest and running composer install to refresh PHP deps (git pull; composer install).
Yes: Always run commands from the theme directory wp-content/themes/wp-theme-telabotanica.
Yes: If you modify assets, re-run the appropriate build to update dist bundles.
