<?php
require_once 'inc/walker.php';

function telabotanica_module_toc($data) { ?>
  <div class="toc">
    <h2 class="toc-title"><?php _e('Sommaire', 'telabotanica'); ?></h2>
    <ul class="toc-items">
      <?php
      $children = get_children(array(
        'post_parent' => get_the_ID(),
        'post_type' => 'page'
      ));
      $has_children = count($children) !== 0;

      // Page de premier niveau
      if ( get_current_page_depth() === 0 ) {
        // Affichage du sommaire de la page actuelle
        wp_list_pages(array(
          'include' => get_the_ID(),
          'title_li' => null,
          'single_page' => !$has_children,
          'walker' => new TocWalker()
        ));

        // Si la page a des enfants
        if ( $has_children ) {
          // Affichage des enfants de la page actuelle
          wp_list_pages(array(
            'child_of' => get_the_ID(),
            'title_li' => null,
            'sort_column' => 'menu_order',
            'walker' => new TocWalker()
          ));
        }
      } else {
        // Affichage de la page parente de la page actuelle
        wp_list_pages(array(
          'include' => wp_get_post_parent_id( get_the_ID() ),
          'title_li' => null,
          'walker' => new TocWalker()
        ));
        // Affichage des pages soeurs de la page actuelle
        wp_list_pages(array(
          'child_of' => wp_get_post_parent_id( get_the_ID() ),
          'title_li' => null,
          'sort_column' => 'menu_order',
          'walker' => new TocWalker()
        ));
      }
      ?>
    </ul>
  </div>
<?php }
