<?php
/**
 * Page Outil
 */
$fields = (object) get_fields(get_the_ID());

// Si une redirection est définie, la suivre
if (isset($fields->has_page) && $fields->has_page === false
  && isset($fields->redirect)) {
    wp_redirect($fields->redirect['url']);
    exit;
}

get_header(); ?>

  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

      <?php
      if ($fields->cover_buttons) :
        $fields->cover_buttons['display'] = 'seamless';
        $cover_content = get_telabotanica_component('buttons', $fields->cover_buttons);
      endif;

      the_telabotanica_module('cover', [
        'content'   => $cover_content,
        'modifiers' => 'tall'
      ]); ?>

      <div class="layout-full-width">
        <?php
        // Si la page utilise des blocs
        if (have_rows('blocks')):

            // On boucle sur les blocs
            while (have_rows('blocks')) : the_row();

              the_telabotanica_block(get_row_layout());

            endwhile;

        endif;
        ?>
      </div>
      <?php
      // Si la page utilise des composants
      if (have_rows('components')) : ?>
        <div class="layout-full-width background-beige">
          <div class="layout-wrapper">
            <div class="layout-components">
              <?php
              // On boucle sur les composants
              while (have_rows('components')) : the_row();

                the_telabotanica_component(get_row_layout());

              endwhile;
              ?>
            </div>
          </div>
        </div>
      <?php endif; ?>

    </main><!-- .site-main -->
  </div><!-- .content-area -->

<?php get_footer(); ?>
