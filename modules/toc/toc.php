<?php
require_once 'inc/walker.php';

function telabotanica_module_toc($data) {

	// Fonction permettant d'afficher le sommaire de la page en cours,
	// en se basant sur l'arborescence des pages dans Wordpress et les
	// composants `title` utilisés
	if ( !function_exists( 'telabotanica_module_toc_current_page' ) ) :
		function telabotanica_module_toc_current_page() {
			$children = get_children([
				'post_parent' => get_the_ID(),
				'post_type' => 'page'
			] );
			$has_children = count($children) !== 0;

			// Page de premier niveau
			if ( get_current_page_depth() === 0 ) {
				// Affichage du sommaire de la page actuelle
				wp_list_pages( [
					'include' => get_the_ID(),
					'title_li' => null,
					'single_page' => !$has_children,
					'walker' => new TocWalker()
				] );

				// Si la page a des enfants
				if ( $has_children ) {
					// Affichage des enfants de la page actuelle
					wp_list_pages( [
						'child_of' => get_the_ID(),
						'title_li' => null,
						'sort_column' => 'menu_order',
						'walker' => new TocWalker()
					] );
				}
			} else {
				$parent_id = wp_get_post_parent_id( get_the_ID() );

				// Affichage de la page parente de la page actuelle
				if ( get_post( $parent_id )->post_name !== 'flore' ) : // sauf pour Flore
					wp_list_pages( [
						'include' => $parent_id,
						'title_li' => null,
						'walker' => new TocWalker()
					] );
				endif;

				// Affichage des pages soeurs de la page actuelle
				wp_list_pages( [
					'child_of' => $parent_id,
					'title_li' => null,
					'sort_column' => 'menu_order',
					'walker' => new TocWalker()
				] );
			}
		}
	endif;


	echo '<div class="toc">';

	the_telabotanica_module('title', [
		'title' => __('Sommaire', 'telabotanica'),
		'level' => 2,
		'modifiers' => ['toc-title', 'with-border-bottom']
	]);

	echo '<ul class="toc-items">';

	if ( isset($data->items) ) :

		foreach ($data->items as $item) :
			$item = (object) $item;

			echo '<li class="toc-item' . ( isset($item->active) && $item->active ? ' is-active' : '' ) . '">';

				if ( isset($item->text) ) {
					printf(
						'<a href="%s" class="toc-item-link">%s%s</a>',
						esc_url( $item->href ),
						get_telabotanica_module('icon', ['icon' => 'tela-leaf']),
						$item->text
					);
				}

				if ( isset($item->items) ) :

					echo '<ul class="toc-subitems">';

					foreach ($item->items as $subitem) :
						$subitem = (object) $subitem;

						// Tableau d'objets Taxonomies
						if (gettype($subitem) === 'object' && get_class($subitem) === 'WP_Term') :

							$subitem->text = $subitem->name;
							$subitem->href = '#' . $subitem->slug;

						// Tableau simple
						elseif (gettype($subitem) === 'array') :

							$subitem = (object) $subitem;

						endif;

						echo '<li class="toc-subitem' . ( isset($subitem->active) && $subitem->active ? ' is-active' : '' ) . '">';
							printf(
								'<a href="%s" class="toc-subitem-link">%s%s</a>',
								esc_url( $subitem->href ),
								get_telabotanica_module('icon', ['icon' => 'tela-leaf']),
								$subitem->text
							);
						echo '</li>';

					endforeach;

					echo '</ul>';

				endif;

			echo '</li>';
		endforeach;

	else :

		telabotanica_module_toc_current_page();

	endif;

	echo '</ul>';
	echo '</div>';
}
