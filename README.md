# Thème Wordpress du site tela-botanica.org

Ce thème utilise le bundler [Webpack](https://webpack.github.io) et l'outil de
gestion de dépendances [Composer](https://getcomposer.org).

## Pour débuter

Installer [Node](https://nodejs.org)

Installer les dépendences du projet

		npm install
		composer install

Définir les constantes suivantes dans `wp-config.php`:
* `ALGOLIA_APPLICATION_ID`
* `ALGOLIA_SEARCH_API_KEY`
* `ALGOLIA_ADMIN_API_KEY`
* `ALGOLIA_PREFIX` (correspondant à l'environnement en cours, par exemple `prod_`)

### Pendant le développement

		npm start

Cette commande :
- surveille les fichiers du thème
- recompile automatiquement à chaque modification

### Compiler le thème

		npm run build

Cette commande :
- compile `assets/styles/main.scss` dans `dist/bundle.css`
- compile `assets/scripts/main.js` dans `dist/bundle.js`
- inclut en inline les images SVG utilisées dans les feuilles de style

### Déployer le thème avec git

Depuis le serveur :

	git pull
	composer install
