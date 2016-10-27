# Journal des modifications

## Gestion sémantique de version "SemVer"

Étant donné un numéro de version `x.β.α`, il faut incrémenter :
* `x` quand il y a des changements rétro-incompatibles
* `β` quand il y a des changements rétro-compatibles
* `α` quand il y a des évolutions mineures ou des corrections d’anomalies rétro-compatibles

plus de détails sur http://semver.org/lang/fr/

## x.β.α (bientôt)

* composant `tools` : colorisation des icônes SVG
* module `categories` : exclure seulement la categorie ID=1 (non catégorisé)
* module `footer` : utilisation de la classe `menu-item-more` pour styler certains liens
* module `header` :
  * ajout du lien de changement de langue (avec gestion des erreurs)
* I18n : plus de chaînes du thème traduisibles

## 0.0.2 (2016-10-18)

* ACF: utilisation du Synchronized JSON pour définir les champs (au lieu d'includes PHP)

## 0.0.1 (2016-10-17)

Première version testable
