// Imports directs au top-level
import moment from 'moment'
import 'moment/locale/fr'
import LazyLoad from 'vanilla-lazyload'

// Configuration moment
moment.locale('fr')

// Styles principaux (une seule fois)
import '../styles/main.scss'
import '../styles/editor-style.scss'
import '../styles/login-style.scss'

// Icons
import '../icons/_all.js'

// Initialize lazy loading
new LazyLoad({
  elements_selector: "iframe.lazyload, img.lazyload"
})

// Responsive utilities
import './responsive.js'

// Glob imports - chargement eager des modules
const moduleScripts = import.meta.glob('../../modules/**/script.js', { eager: true })
const blockScripts = import.meta.glob('../../blocks/**/script.js', { eager: true })
const componentScripts = import.meta.glob('../../components/**/script.js', { eager: true })

// Log pour debug (à enlever en production)
console.log(`Loaded ${Object.keys(moduleScripts).length} modules`)
console.log(`Loaded ${Object.keys(blockScripts).length} blocks`)
console.log(`Loaded ${Object.keys(componentScripts).length} components`)
