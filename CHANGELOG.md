# Journal des modifications

## Gestion sémantique de version "SemVer"

Étant donné un numéro de version `x.β.α`, il faut incrémenter :
* `x` quand il y a des changements rétro-incompatibles
* `β` quand il y a des changements rétro-compatibles
* `α` quand il y a des évolutions mineures ou des corrections d’anomalies rétro-compatibles

plus de détails sur http://semver.org/lang/fr/

## x.β.α (bientôt)

* composant `embed` :
  * support de l'intégration avec oEmbed
  * support de l'intégration dans une iframe
* composant `links` :
  * ajout des effets de rollover
  * support des liens de téléchargements
  * fonctionne avec un tableau de données ou les champs ACF
* composant `tools` :
  * colorisation des icônes SVG
  * ajout des liens et des effets de rollover
  * fonctionne avec un tableau de données ou un tableau d'objets WP_Post
  * support des redirections
* module `categories` : exclure seulement la categorie ID=1 (non catégorisé)
* module `cover` : crédits basés sur les champs ACF
* module `footer` : utilisation de la classe `menu-item-more` pour styler certains liens
* module `header` :
  * ajout du lien de changement de langue (avec gestion des erreurs)
* module `toc` ajouté
  * support du sommaire de la page actuelle (basé sur les composants `title`)
  * support des pages parentes et soeurs
  * utilisation d'un `walker` spécifique
* page `404` ajoutée
* I18n : plus de chaînes du thème traduisibles
* groupes de champs offres d'emploi :
  * fusion entre CDD/CDI et stages
  * ajout pour la catégorie Service civique
  * chapo optionnel
* groupe de champs crédits médias
* groupe de champs bandeau de catégorie
* groupes de champs outil :
  * ajout d'un champ redirection
* ajout d'une taxonomie Catégorie d'outils

## 0.0.2 (2016-10-18)

* ACF: utilisation du Synchronized JSON pour définir les champs (au lieu d'includes PHP)

## 0.0.1 (2016-10-17)

Première version testable
