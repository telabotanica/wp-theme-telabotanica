<?php
/**
 * Page d'accueil
 */
get_header();

$category_actualites = get_category_by_slug('actualites');
$category_evenements = get_category_by_slug('evenements');
$category_emploi = get_category_by_slug('offres-emploi');
?>

  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

      <?php
      the_telabotanica_module('cover-home');
      ?>

      <div class="layout-content-col reversed">
        <div class="layout-wrapper">
          <div class="layout-content">
            <?php
            $featured_post_id = false;
            $featured_post = new WP_Query([
              'post_type'      => 'post',
              'meta_key'       => 'featured',
              'meta_value'     => 1,
              'posts_per_page' => 1
            ]);

            if ($featured_post->have_posts()) :
              the_telabotanica_module('title', [
                'title'     => __('À la Une', 'telabotanica'),
                'level'     => 2,
                'modifiers' => 'with-margin-top'
              ]);
              while ($featured_post->have_posts()) : $featured_post->the_post();
                $featured_post_id = get_the_ID();
                the_telabotanica_module('article', [
                  'image' => has_post_thumbnail() ? get_the_post_thumbnail(null, 'home-latest-post') : false,
                  'intro' => get_the_excerpt()
                ]);
              endwhile;

              the_telabotanica_module('button', [
                'href' => get_permalink(),
                'text' => __('Lire la suite', 'telabotanica')
              ]);
              wp_reset_postdata();
            endif;

            $featured_tools = get_field('tools');

            if ($featured_tools) :

              the_telabotanica_module('title', [
                'title'     => __('Les outils de Tela Botanica', 'telabotanica'),
                'level'     => 2,
                'modifiers' => $featured_post->have_posts() ? 'with-separator' : 'with-margin-top'
              ]);

              the_telabotanica_component('tools', $featured_tools);

              the_telabotanica_component('buttons', [
                'items' => [
                  [
                    'link' => [
                      'url' => get_permalink(get_page_by_path('outils'))
                    ],
                    'text' => __('Voir tous les outils', 'telabotanica')
                  ]
                ]
              ]);

            endif;
            ?>
          </div>
          <aside class="layout-column">
            <?php
            $latest_articles = new WP_Query([
              'post_type' => 'post',
              'cat'       => implode(',', [
                $category_actualites->cat_ID
              ]),
              'posts_per_page' => 5,
              // évite d'afficher 2 fois l'actu à la Une
              'post__not_in' => $featured_post_id ? [$featured_post_id] : []
            ]);

            if ($latest_articles->have_posts()) :

              the_telabotanica_module('title', [
                'title'     => __('Les dernières actus', 'telabotanica'),
                'level'     => 2,
                'modifiers' => 'with-margin-top'
              ]);

              the_telabotanica_module('column-articles', [
                'query' => $latest_articles
              ]);

            endif;
            wp_reset_postdata();

            the_telabotanica_module('column-links', [
              'items' => [
                [
                  'text' => __("Toute l'actualité", 'telabotanica'),
                  'href' => get_category_link($category_actualites),
                  'icon' => 'news'
                ],
                [
                  'text' => __('Tous les évènements', 'telabotanica'),
                  'href' => get_category_link($category_evenements),
                  'icon' => 'calendar'
                ],
                [
                  'text' => __("Offres d'emplois / stages", 'telabotanica'),
                  'href' => get_category_link($category_emploi),
                  'icon' => 'laptop'
                ],
                [
                  'text' => __('Proposer une actualité', 'telabotanica'),
                  'href' => get_permalink(get_page_by_path('proposer-une-actualite')),
                  'icon' => 'edit'
                ]
              ],
              'modifiers' => 'layout-column-item'
            ]);

            the_telabotanica_module('newsletter', [
              'modifiers' => ['layout-column-item', 'background-white', 'with-shadow', 'with-padding']
            ]);
            ?>
          </aside>
        </div>
      </div>

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

    </main><!-- .site-main -->
  </div><!-- .content-area -->

<?php get_footer(); ?>
