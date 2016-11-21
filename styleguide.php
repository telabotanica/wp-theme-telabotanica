<?php
/**
 * Template pour les pages de documentation du styleguide
 */

global $wp_query;

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

      <?php
      $current = false;
      if ( $wp_query->get('styleguide_type') && $wp_query->get('styleguide_nom') ) :
        $type = $wp_query->get('styleguide_type');
        $nom = $wp_query->get('styleguide_nom');
        $current = $type . '/' . $nom;
      endif;
      ?>

      <div class="layout-left-col">
        <div class="layout-wrapper">
          <aside class="layout-column">
            <?php the_telabotanica_module('toc', [
              'items' => [
                [
                  'text' => 'Modules',
                  'href' => '#',
                  'active' => (substr($current, 0, strlen('module')) === 'module'),
                  'items' => array_map(function ($module) {
                    global $current;
                    return [
                      'text' => $module,
                      'href' => site_url('styleguide/module/' . $module),
                      'active' => ($current === 'module/' . $module)
                    ];
                    // echo '<li' . ($current === 'module/' . $module ? ' class="current"' : '') . '><a href="' . site_url('styleguide/module/' . $module) . '"><code>' . $module . '</code></a></li>';
                  }, $telabotanica_modules)
                ],
                [
                  'text' => 'Composants rédactionnels',
                  'href' => '#',
                  'active' => (substr($current, 0, strlen('component')) === 'component'),
                  'items' => array_map(function ($component) {
                    global $current;
                    return [
                      'text' => $component,
                      'href' => site_url('styleguide/component/' . $component),
                      'active' => ($current === 'component/' . $component)
                    ];
                    // echo '<li' . ($current === 'component/' . $component ? ' class="current"' : '') . '><a href="' . site_url('styleguide/component/' . $component) . '"><code>' . $component . '</code></a></li>';
                  }, $telabotanica_components)
                ]
              ]
            ] ); ?>
            <?php the_telabotanica_module('button-top'); ?>
          </aside>
          <div class="layout-content">
			      <h1><a href="<?php echo site_url('styleguide') ?>">Styleguide</a></h1>

            <?php
            if ( $current ) :
              echo '<h2>' . $type . ' <code>' . $nom . '</code></h2>';
              $exemples = require($type . 's/' . $nom . '/exemples.php');
              if ( is_array($exemples) ) :
                foreach ( $exemples as $exemple => $data ) {
                  echo '<h3>' . $exemple . '</h3>';
                  echo '<div class="styleguide-element">' . get_telabotanica_styleguide_element($type, $nom, $data) . '</div>';
                  echo '<pre class="styleguide-data">' . json_encode($data, JSON_PRETTY_PRINT) . '</pre>';
                }
              else :
                echo '<p>' . $exemples . '</p>';
              endif;
            endif;
            ?>
          </div>
        </div>
      </div>

    </main><!-- .site-main -->
  </div><!-- .content-area -->

<?php get_footer(); ?>
