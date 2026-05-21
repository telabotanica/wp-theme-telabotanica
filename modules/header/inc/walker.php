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
    $atts['href'] = preg_replace("/(.+)\/categorie\/(.+)\/$/", "$1/#$2", $atts['href']);
  }
  return $atts;
}
add_filter('nav_menu_link_attributes', 'telabotanica_header_nav_menu_link_attributes', 10, 4);

/**
 * Walker spécifique pour le menu secondaire avec support ARIA
 * Basé sur Walker_Nav_Menu avec ajout des attributs d'accessibilité
 */
class HeaderNavWalker extends Walker_Nav_Menu {

  /**
   * Starts the list before the elements are added.
   *
   * @param string   $output Used to append additional content (passed by reference).
   * @param int      $depth  Depth of menu item. Used for padding.
   * @param stdClass $args   An object of wp_nav_menu() arguments.
   */
  public function start_lvl( &$output, $depth = 0, $args = null ) {
    if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
      $t = '';
      $n = '';
    } else {
      $t = "\t";
      $n = "\n";
    }
    $indent = str_repeat( $t, $depth );

    // Classes pour le sous-menu
    $classes = array( 'sub-menu' );

    /**
     * Filters the CSS class(es) applied to a menu list element.
     *
     * @param string[] $classes Array of the CSS classes that are applied to the menu `<ul>` element.
     * @param stdClass $args    An object of `wp_nav_menu()` arguments.
     * @param int      $depth   Depth of menu item. Used for padding.
     */
    $class_names = implode( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
    $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

    $output .= "{$n}{$indent}<ul$class_names role=\"menu\">{$n}";
  }

  /**
   * Ends the list of after the elements are added.
   *
   * @param string   $output Used to append additional content (passed by reference).
   * @param int      $depth  Depth of menu item. Used for padding.
   * @param stdClass $args   An object of wp_nav_menu() arguments.
   */
  public function end_lvl( &$output, $depth = 0, $args = null ) {
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
          '<li id="menu-item-description-%s" class="menu-item menu-item-description" role="none">%s%s</li>',
          $args->last_parent_el->ID,
          get_telabotanica_module('icon', ['icon' => 'info']),
          $args->last_parent_el->description
        );
    }

    $output .= "$indent</ul>{$n}";
  }

  /**
   * Starts the element output.
   *
   * @param string   $output Used to append additional content (passed by reference).
   * @param WP_Post  $item   Menu item data object.
   * @param int      $depth  Depth of menu item. Used for padding.
   * @param stdClass $args   An object of wp_nav_menu() arguments.
   * @param int      $id     Current item ID.
   */
  public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
    if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
      $t = '';
      $n = '';
    } else {
      $t = "\t";
      $n = "\n";
    }
    $indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

    $classes   = empty( $item->classes ) ? array() : (array) $item->classes;
    $classes[] = 'menu-item-' . $item->ID;

    /**
     * Filters the arguments for a single nav menu item.
     *
     * @param stdClass $args  An object of wp_nav_menu() arguments.
     * @param WP_Post  $item  Menu item data object.
     * @param int      $depth Depth of menu item. Used for padding.
     */
    $args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

    /**
     * Filters the CSS classes applied to a menu item's list item element.
     *
     * @param string[] $classes Array of the CSS classes that are applied to the menu item's `<li>` element.
     * @param WP_Post  $item    Menu item data object.
     * @param stdClass $args    An object of wp_nav_menu() arguments.
     * @param int      $depth   Depth of menu item. Used for padding.
     */
    $class_names = implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
    $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

    /**
     * Filters the ID applied to a menu item's list item element.
     *
     * @param string   $menu_id The ID that is applied to the menu item's `<li>` element.
     * @param WP_Post  $item    Menu item data object.
     * @param stdClass $args    An object of wp_nav_menu() arguments.
     * @param int      $depth   Depth of menu item. Used for padding.
     */
    $id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
    $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

    $output .= $indent . '<li' . $id . $class_names . ' role="none">';

    $atts           = array();
    $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
    $atts['target'] = ! empty( $item->target ) ? $item->target : '';
    if ( '_blank' === $item->target && empty( $item->xfn ) ) {
      $atts['rel'] = 'noopener';
    } else {
      $atts['rel'] = $item->xfn;
    }
    $atts['href']         = ! empty( $item->url ) ? $item->url : '';
    $atts['aria-current'] = $item->current ? 'page' : '';

    // Ajouter les attributs ARIA pour les menus avec sous-menus
    if ( in_array( 'menu-item-has-children', $classes ) ) {
      $atts['aria-haspopup'] = 'true';
      $atts['aria-expanded'] = 'false';
      $atts['role']          = 'menuitem';
      $atts['class']         = 'has-submenu';
    } else {
      $atts['role'] = 'menuitem';
    }

    /**
     * Filters the HTML attributes applied to a menu item's anchor element.
     *
     * @param array $atts {
     *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
     *
     *     @type string $title        Title attribute.
     *     @type string $target       Target attribute.
     *     @type string $rel          The rel attribute.
     *     @type string $href         The href attribute.
     *     @type string $aria_current The aria-current attribute.
     * }
     * @param WP_Post  $item  Menu item data object.
     * @param stdClass $args  An object of wp_nav_menu() arguments.
     * @param int      $depth Depth of menu item. Used for padding.
     */
    $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

    $attributes = '';
    foreach ( $atts as $attr => $value ) {
      if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
        $value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
        $attributes .= ' ' . $attr . '="' . $value . '"';
      }
    }

    /** This filter is documented in wp-includes/post-template.php */
    $title = apply_filters( 'the_title', $item->title, $item->ID );

    /**
     * Filters a menu item's title.
     *
     * @param string   $title The menu item's title.
     * @param WP_Post  $item  Menu item data object.
     * @param stdClass $args  An object of wp_nav_menu() arguments.
     * @param int      $depth Depth of menu item. Used for padding.
     */
    $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

    $item_output  = $args->before;
    $item_output .= '<a' . $attributes . '>';
    $item_output .= $args->link_before . $title . $args->link_after;
    $item_output .= '</a>';
    $item_output .= $args->after;

    /**
     * Filters a menu item's starting output.
     *
     * The menu item's starting output only includes `$args->before`, the opening `<a>`,
     * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
     * no filter for modifying the opening and closing `<li>` for a menu item.
     *
     * @param string   $item_output The menu item's starting HTML output.
     * @param WP_Post  $item        Menu item data object.
     * @param int      $depth       Depth of menu item. Used for padding.
     * @param stdClass $args        An object of wp_nav_menu() arguments.
     */
    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
  }
}
