# Journal des modifications

## Gestion sémantique de version "SemVer"

Étant donné un numéro de version `x.β.α`, il faut incrémenter :
* `x` quand il y a des changements rétro-incompatibles
* `β` quand il y a des changements rétro-compatibles
* `α` quand il y a des évolutions mineures ou des corrections d’anomalies rétro-compatibles

plus de détails sur http://semver.org/lang/fr/

## x.β.α (bientôt)

* template `flore` ajouté
* module `toc` :
  * remplacement du comportement "affix" par une solution CSS (`position: sticky`)
  * recalcul de la taille des sections lors de l'utilisation des `accordion`

## 0.1.0 (2018-04-11)

* retour au rendu PHP pour les modules :
  * `card-project`
  * `categories-labels`
  * `event-dates`
  * `feed-item`
  * `icon`
  * `list-articles-item`
  * `notice`
* tableau de bord
* bloc `contribute` : amélioration du remplissage aléatoire
* bloc `list-features` : style des liens
* bloc `list-projects` : ajout d'un dégradé en bas des `card-project`
* bloc `main-features` : style des liens
* composant `articles` ajouté
* composant `image` : amélioration affichage petites images
* composant `contact` :
  * ajout du support de `action_before`
* composant `map` : centre optionnel
* composant `text` :
  * style basique pour les tableaux
  * pas de `margin` pour le dernier paragraphe
* composant `title` : ajout d'un offset pour les ancres (hauteur du header)
* module `article` :
  * meilleure réutilisation (`text` et `intro` optionnels, ajout de `title_level`)
  * ajout d'un modifier `is-small`
  * support d'un `thumbnail`
* module `block-dashboard` ajouté
* module `block-dashboard-images` ajouté
* module `block-dashboard-map` ajouté
* module `block-dashboard-observations` ajouté
* module `button` : ajout de la couleur rouge
* module `breadcrumbs` :
  * ajout d'espace en-dessous
  * support de multiples pages parentes
* module `card-project` : pas de lien dans la description
* module `categories-labels` : refactoring avec Pug
* module `comment-form` ajouté
* module `comments` ajouté
* module `cover` : utilise désormais une image au hasard si aucune n'est définie
* module `cover-home` : ajout du lien vers le tableau de bord
* module `cover-member` ajouté
* module `cover-project` : bouton vers site externe ajouté
* module `error-page` ajouté
* module `event-dates` : refactoring avec Pug
* module `feed` ajouté
* module `feed-item` : ajouté + refactoring avec Pug
* module `footer` :
  * ajout des icônes de flèche au dernier item des colonnes du menu
  * ajout de l'icône CC
* module `header` :
  * fix `z-index`
  * utilise maintenant l'avatar BuddyPress
  * menus déroulants
* module `header-dashboard` ajouté
* module `list-articles` : refactoring avec `list-articles-item`
* module `list-articles-item` ajouté
* module `map-events` ajouté
* module `nav-tabs` ajouté
* module `notice` ajouté
* module `notice-cookies` ajouté
* module `pagination` : support de la pagination Buddypress
* module `search-box` :
  * ajout du support de `id`, `action`, `input_id` et `input_name`
  * refactoring avec deux cas : instantsearch ou autocomplete
  * éviter que plusieurs modules utilisent l'autocomplete sur la même page
* module `search-hit` ajouté
* module `title` : support d'un suffixe optionnel
* module `toc` :
  * ajout du comportement "affix" (reste fixe lors du scroll)
  * ajout du comportement "scrollspy" (mise en évidence de l'item en cours)
* layout `2-col` : ajout d'une version `larger-first-col`
* layout `central-col` : ajout d'un modifier `background-beige`
* layout `content-col` :
  * ajout d'une largeur max en version `is-dashboard`
  * ajout de padding en bas du contenu
* template `archive-tb_thematique` ajouté
* template `single-tb_thematique` ajouté
* template `page-comment-participer` ajouté
* ajout d'une taxonomie Catégorie de moyens de participer
* groupe de champs ACF "Composant liste d'articles" ajouté
* refactoring crédits des images
* pages d'erreur 404, 500, maintenance

## 0.0.7 (2017-03-04)

* bloc `mosaic` : liens vers Identiplante
* composant `contact` : icône mail par défaut quand pas d'image
* composant `info` ajouté
* composant `map` ajouté
* composants : diverses amélioration du rendu dans les articles
* module `cover-home` : ajout des icônes prévues
* module `event-dates` ajouté
* module `footer` : petits changements (réseaux sociaux et licence CC)
* module `header` : refactoring
* module `list-articles` :
  * ajout des liens vers les auteurs
  * refactoring avec `event-dates`
* module `meta-news` :
  * ajout des liens vers les auteurs
  * ajout du lieu pour les évènements
* module `nav-dashboard` ajouté
* module `upcoming-events` :
  * correction bug get_posts
  * refactoring avec `event-dates`
* template `single` :
  * support de la catégorie "En kiosque"
  * support de la catégorie "Évènements"
  * support de la catégorie "Offres d'emploi"
* ACF : utiliser le premier composant image comme vignette, si l'article n'en a pas
* PostCSS :
  * mise à jour d'`autoprefixer` (ajout automatique des vendor prefixes)
  * ajout de `pixrem` (fallback `px` pour les navigateurs ne supportant pas `rem`)
  * ajout de `css-mqpacker` (pour grouper les media queries à la fin du CSS)

## 0.0.6 (2017-03-01)

* bloc `focus` :
  * correction de la taille des composants `embed`
  * centrage des composants `image` placés en haut
* bloc `maps` ajouté
* bloc `list-features` :
  * correction bug icône Chrome
* bloc `mosaic` ajouté
* composant `buttons` : champ passé en optionnel dans ACF
* composant `image` : ajout des crédits
* composant `links` :
  * amélioration du placement des metadata
  * ajout des icônes
* composant `tools` :
  * correction bug icône Chrome
  * correction bug quand redirection vide
* module `breadcrumbs` : support des items passés en data
* module `card-project` :
  * icône Tela si le projet est dans la catégorie dédiée
  * support du nombre de membres depuis l'index Algolia
* module `cover-project` : icônes selon status
* suppression des webfonts SVG
* ajout de la webfont Muli en bold
* fonctionnement avec plugin Algolia désactivé
* compatibilité avec BuddyPress :
  * template `buddypress/groups/index.php` (liste des projets) :
    * support du filtrage par type de projet
* ajout de la taille d'image `medium_square` (250x250)
* groupe de champs ACF "Article sélectionnable pour la Une" ajouté

## 0.0.5 (2017-02-24)

* bloc `contribute` ajouté
* bloc `list-projects` ajouté
* ajout d'une dépendance (`pug-php`) avec Composer
* mise à jour du `README`
* template `front_page.php`
* ajout d'un template `search.php`
* composant `tools` : amélioration du hover des liens
* module `article` ajouté
* module `card-project` : refactoring avec Pug
* module `column-articles` ajouté
* module `column-features` ajouté
* module `column-links` ajouté
* module `cover` : support de l'ajout d'une `search-box`
* module `cover-home` ajouté
* module `cover-search` ajouté
* module `form-newsletter` :
  * renommé `newsletter`
  * remplacement du formulaire par un bouton
* module `icon` :
  * refactoring avec Pug
  * amélioration de la documentation
* module `header` : support d'une version `small` pour certaines pages
* module `list-projects` : ajout d'un script pour gérer la recherche
* module `search-box` ajouté
* module `search-filters` ajouté
* module `search-results` ajouté
* module `title` ajouté
* layout `central-col` : refactoring avec un modifier `is-wide`
* layout `left-col` :
  * renommé `content-col`
  * ajout d'un modifier `reversed`
* groupe de champs ACF "Newsletter" déplacé vers la page newsletter_compose
* dossier `algolia` ajouté (fichiers spécifiques au plugin Algolia)
* configuration de Webpack pour supporter les templates Pug
* refactoring des blocs, modules et composants pour standardiser les data et modifiers

## 0.0.4 (2017-01-25)

* bloc `focus` ajouté
* bloc `main-features` ajouté
* bloc `list-features` ajouté
* styleguide : support des blocs
* template outil :
  * support des boutons du bandeau
* module `cover` :
  * support d'un contenu optionnel
* layout `full-width` ajouté
* module `categories-labels` ajouté
* module `meta-news` ajouté
* module `share` ajouté
* module `button` :
  * support d'une icône avant ou après le texte
* groupes de champs évènements :
  * simplification du choix date unique / date de début et fin
  * remplacement de Google Maps par Algolia Places
* module `button-top` ajouté
* module `nav-project` ajouté
  * boutons de partage ajoutés
* composant `contact` :
  * correction bug photo quand texte trop long
* module `cover-project` ajouté
  * bouton d'adhésion fonctionnel
* module `card-project` ajouté
* module `list-projects` ajouté
* ajout d'un template `generic.php`
* compatibilité avec BuddyPress :
  * ajout de tous les templates par défaut
  * adaptation du template `buddypress/groups/index.php` (liste des projets)
  * adaptation du template `buddypress/groups/single/home.php` (page d'accueil projet)
* layout `left-col` :
  * ajout d'un modifier `full-width`
* module `breadcrumbs` :
  * ajout d'un modifier `no-border`
* module `categories` :
  * fonctionne désormais avec des data passées en paramètre
  * accepte un `number` optionnel
* module `pagination` ajouté
* module `list-articles` ajouté
  * affichage spécifique des évènements
* ajout des icônes SVG
* configuration de webpack pour générer un sprite SVG
* configuration de webpack pour gérer les images dans des `url()`
* personnalisation de la page de login avec `login-style.css`

## 0.0.3 (2016-11-17)

* composant `contact` ajouté
* composant `accordion` ajouté
* composant `image` ajouté
* composant `buttons` ajouté
  * possibilité d'afficher les boutons comme des liens
* composant `embed` :
  * support de l'intégration avec oEmbed
  * support de l'intégration dans une iframe
  * ajout d'une description (accessibilité et référencement)
  * ajout d'une hauteur optionnelle pour l'iframe
* composant `links` :
  * ajout des effets de rollover
  * support des liens de téléchargements
  * fonctionne avec un tableau de données ou les champs ACF
* composant `tools` :
  * colorisation des icônes SVG
  * ajout des liens et des effets de rollover
  * fonctionne avec un tableau de données ou un tableau d'objets WP_Post
  * support des redirections
* module `breadcrumbs` ajouté
* module `button` :
  * ajout d'un modifier `block`
  * ajout d'un modifier `orange`
* module `categories` : exclure seulement la categorie ID=1 (non catégorisé)
* module `cover` : crédits basés sur les champs ACF
* module `footer` :
  * ajout du logo SVG
  * utilisation de la classe `menu-item-more` pour styler certains liens
* module `header` :
  * ajout du logo SVG
  * ajout des icônes et d'effets de hover sur la navigation
  * ajout du lien de changement de langue (avec gestion des erreurs)
  * ajout d'effets de rollover
* module `toc` ajouté
  * support du sommaire de la page actuelle (basé sur les composants `title`)
  * support des pages parentes et soeurs
  * utilisation d'un `walker` spécifique
* module `upcoming-events` ajouté
  * ajout du lien vers tous les évènements
* page `404` ajoutée
* I18n : plus de chaînes du thème traduisibles
* groupes de champs évènements :
  * meilleur ciblage des catégories
* groupes de champs offres d'emploi :
  * fusion entre CDD/CDI et stages
  * ajout pour la catégorie Service civique
  * chapo optionnel
* groupe de champs crédits médias
* groupe de champs bandeau de catégorie
* groupes de champs outil :
  * ajout d'un champ redirection
* groupe de champs newsletter
* ajout d'une taxonomie Catégorie d'outils
* support des SVG dans la build Webpack
* ajout d'une page d'options Lettre d'actu

## 0.0.2 (2016-10-18)

* ACF: utilisation du Synchronized JSON pour définir les champs (au lieu d'includes PHP)

## 0.0.1 (2016-10-17)

Première version testable
