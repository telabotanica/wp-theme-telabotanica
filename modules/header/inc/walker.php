<?php
// Conserver le dernier élément parent dans les args pour pouvoir le réutiliser dans le walker
function telabotanica_header_walker_nav_menu_start_el($item_output, $item, $depth, $args) {
	if ( $args->theme_location === 'secondary' && $depth === 0 ) {
		$args->last_parent_el = $item;
	}
	return $item_output;
}
add_filter('walker_nav_menu_start_el', 'telabotanica_header_walker_nav_menu_start_el', 10, 4);

// Remplacer à la volée les liens vers les catégories d'outils et de moyens de participer par des ancres
function telabotanica_header_nav_menu_link_attributes($atts, $item, $args, $depth) {
	if ( $args->theme_location === 'secondary' && in_array( $item->object, ['tb_outils_category', 'tb_participer_category'] ) ) {
		$atts['href'] = preg_replace("/(.+)\/(.+)\/$/", "$1#$2", $atts['href']);
	}
	return $atts;
}
add_filter('nav_menu_link_attributes', 'telabotanica_header_nav_menu_link_attributes', 10, 4);


// Walker spécifique, basé sur Aria_Walker_Nav_Menu
// voir documentation : https://github.com/proteusthemes/WAI-ARIA-Walker_Nav_Menu

class HeaderNavWalker extends Aria_Walker_Nav_Menu {

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @since 3.0.0
	 *
	 * @see Walker::end_lvl()
	 *
	 * @param string   $output Passed by reference. Used to append additional content.
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = str_repeat( $t, $depth );

		// Injecter la description de l'élément parent si elle existe
		if ( $depth === 0 && isset( $args->last_parent_el ) && !empty( $args->last_parent_el->description ) ) {
			$output .= $indent . sprintf(
				'<li id="menu-item-description-%s" class="menu-item menu-item-description">%s%s</li>',
				$args->last_parent_el->ID,
				get_telabotanica_module('icon', ['icon' => 'info']),
				$args->last_parent_el->description
			);
		}

		$output .= "$indent</ul>{$n}";
	}

}
