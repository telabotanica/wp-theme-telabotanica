<?php function telabotanica_module_toc($data) { ?>
  <div class="toc">
    <h2 class="toc-title"><?php _e('Sommaire', 'telabotanica'); ?></h2>
    <ul class="toc-items">
      <li class="toc-item">
        <ul class="toc-subitems">
          <?php
          // Si la page utilise des composants
          if( have_rows('components') ):
              $first = true;

              // On boucle sur les composants
              while ( have_rows('components') ) : the_row();

                // On garde seulement les intertitres
                if (get_row_layout() !== 'title') continue;

                echo '<li class="toc-subitem' . ( $first ? ' is-active' : '' ) . '"><a href="#' . get_sub_field('anchor') . '" class="toc-subitem-link">' . get_sub_field('title') . '</a></li>';

                $first = false;

              endwhile;

          endif;
          ?>
        </ul>
      </li>
    </ul>
  </div>
<?php }
