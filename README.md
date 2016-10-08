# Thème Wordpress du site tela-botanica.org

Ce thème utilise le bundler [Webpack](https://webpack.github.io).

## Pour débuter

Installer [Node](https://nodejs.org)

Installer les dépendences du projet

    npm install

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
