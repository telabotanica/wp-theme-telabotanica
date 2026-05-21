# Thème Wordpress du site tela-botanica.org

Ce thème utilise le bundler [Vite](https://vitejs.dev) et l'outil de
gestion de dépendances [Composer](https://getcomposer.org).

Ce thème a été développé en utilisant Node 24 et PHP 8.5, mais il devrait être compatible avec les versions plus anciennes de ces outils.

Ce thème est conçu pour être utilisé avec Wordpress 7.0 ou une version plus récente, mais il devrait être compatible avec les versions plus anciennes de Wordpress.

## Pour débuter

Installer [Node](https://nodejs.org)

Installer les dépendences du projet

    npm install
    composer install

Définir les constantes suivantes dans `wp-config.php`:

### Pendant le développement

    npm run dev

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
    npm install
    npm run build
