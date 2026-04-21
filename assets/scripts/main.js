import moment from 'moment'
import 'moment/locale/fr'
moment.locale('fr')

import '../styles/main.scss'
import '../styles/editor-style.scss'
import '../styles/login-style.scss'

import '../icons/_all.js'

import LazyLoad from 'vanilla-lazyload'

new LazyLoad({
  elements_selector: "iframe.lazyload, img.lazyload"
})

import 'matchmedia-polyfill'
import './responsive.js'

import.meta.glob('../../modules/**/script.js', { eager: true })
import.meta.glob('../../blocks/**/script.js', { eager: true })
import.meta.glob('../../components/**/script.js', { eager: true })
