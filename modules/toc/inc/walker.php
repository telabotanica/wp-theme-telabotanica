<?php

// Walker spécifique, basé sur Walker_Page
// voir documentation : https://developer.wordpress.org/reference/classes/walker_page/

class TocWalker extends Walker_Page
{
    /**
	 * Outputs the beginning of the current element in the tree.
	 *
	 * @see Walker::start_el()
	 * @since 2.1.0
	 *
	 * @param string  $output       Used to append additional content. Passed by reference.
	 * @param WP_Post $page         Page data object.
	 * @param int     $depth        Optional. Depth of page. Used for padding. Default 0.
	 * @param array   $args         Optional. Array of arguments. Default empty array.
	 * @param int     $current_page Optional. Page ID. Default 0.
	 */
	public function start_el(&$output, $page, $depth = 0, $args = [], $current_page = 0)
	{
	    if ($depth) {
	        $indent = str_repeat("\t", $depth);
	    } else {
	        $indent = '';
	    }

	    $css_class = ['toc-item', 'toc-item-'.$page->ID];

	    if (isset($args['pages_with_children'][$page->ID])) {
	        $css_class[] = 'has-children';
	    }

	    if (!empty($current_page)) {
	        $_current_page = get_post($current_page);
	        if ($_current_page && in_array($page->ID, $_current_page->ancestors)) {
	            $css_class[] = 'is-ancestor';
	        }
	        if ($page->ID == $current_page) {
	            $css_class[] = 'is-active';
	        } elseif ($_current_page && $page->ID == $_current_page->post_parent) {
	            $css_class[] = 'is-parent';
	        }
	    } elseif ($page->ID == get_option('page_for_posts')) {
	        $css_class[] = 'is-parent';
	    }

		/**
		 * Filters the list of CSS classes to include with each page item in the list.
		 *
		 * @since 2.8.0
		 * @see wp_list_pages()
		 *
		 * @param array   $css_class    An array of CSS classes to be applied
		 *                              to each list item.
		 * @param WP_Post $page         Page data object.
		 * @param int     $depth        Depth of page, used for padding.
		 * @param array   $args         An array of arguments.
		 * @param int     $current_page ID of the current page.
		 */
		$css_classes = implode(' ', apply_filters('page_css_class', $css_class, $page, $depth, $args, $current_page));

	    if ('' === $page->post_title) {
	        /* translators: %d: ID of a post */
			$page->post_title = sprintf(__('#%d (no title)'), $page->ID);
	    }

	    $args['link_before'] = empty($args['link_before']) ? '' : $args['link_before'];
	    $args['link_after'] = empty($args['link_after']) ? '' : $args['link_after'];
	    $args['single_page'] = array_key_exists('single_page', $args) ? $args['single_page'] : false;

		// Quand single_page is true, on n'affiche pas le nom de la page
		if ($args['single_page'] === true) {
		    $output .= $indent.sprintf(
				'<li class="%s">',
				$css_classes
			);
		} else {
		    $output .= $indent.sprintf(
				'<li class="%s"><a href="%s" class="toc-item-link">%s%s%s</a>',
				$css_classes,
				get_permalink($page->ID),
				$args['link_before'],
				/* This filter is documented in wp-includes/post-template.php */
				apply_filters('the_title', $page->post_title, $page->ID),
				$args['link_after']
			);
		}

	    if (!empty($args['show_date'])) {
	        if ('modified' == $args['show_date']) {
	            $time = $page->post_modified;
	        } else {
	            $time = $page->post_date;
	        }

	        $date_format = empty($args['date_format']) ? '' : $args['date_format'];
	        $output .= ' '.mysql2date($date_format, $time);
	    }

		// Sommaire de la page en cours
		$current_toc = '';
	    if ($page->ID == $current_page) {
	        // Si la page utilise des composants
			if (have_rows('components')) {
			    $first = true;
				// On boucle sur les composants
				while (have_rows('components')) : the_row();

					// On garde seulement les intertitres
					if (get_row_layout() !== 'title') {
					    continue;
					}

					// On garde seulement les intertitres de niveau 2
					if (get_sub_field('level') !== '2') {
					    continue;
					}

			    $current_toc .= sprintf(
						'<li class="%s"><a href="%s" class="toc-subitem-link">%s%s</a></li>',
						'toc-subitem'.($first ? ' is-active' : ''),
						'#'.get_sub_field('anchor'),
						get_telabotanica_module('icon', ['icon' => 'tela-leaf']),
						get_sub_field('title')
					);

			    $first = false;

			    endwhile;

			    if (!empty($current_toc)) {
			        $current_toc = '<ul class="toc-subitems">'.$current_toc.'</ul>';
			    }
			}
	        $output .= $current_toc;
	    }
	}
}
