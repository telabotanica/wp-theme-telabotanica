# Journal des modifications

## Gestion sémantique de version "SemVer"

Étant donné un numéro de version `x.β.α`, il faut incrémenter :
* `x` quand il y a des changements rétro-incompatibles
* `β` quand il y a des changements rétro-compatibles
* `α` quand il y a des évolutions mineures ou des corrections d’anomalies rétro-compatibles

plus de détails sur http://semver.org/lang/fr/

## x.β.α (bientôt)

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
