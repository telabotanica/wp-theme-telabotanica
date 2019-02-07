<?php function telabotanica_module_cover_home($data) {

  $defaults = [
    'image' => get_field('cover_image'),
    'title' => __('Bienvenue sur Tela Botanica, <br />le réseau des botanistes francophones', 'telabotanica'),
    'modifiers' => []
  ];
  $data = telabotanica_styleguide_data($defaults, $data);
  $data->modifiers = telabotanica_styleguide_modifiers_array(['cover', 'cover-home'], $data->modifiers);

  printf(
    '<div class="%s" style="background-image: url(%s);">',
    implode(' ', $data->modifiers),
    $data->image['sizes']['cover-background']
  );

    echo '<div class="layout-wrapper">';
      echo '<div class="cover-home-content">';

      if ( is_user_logged_in() ) :
        $current_user = wp_get_current_user();
        printf(
          '<h1 class="cover-home-title">%s</h1>',
          sprintf(__('Bienvenue %s !', 'telabotanica'), $current_user->display_name)
        );
        printf(
          '<div class="cover-home-link"><a href="%s">%s</a></div>',
          bp_loggedin_user_domain(),
          __('Accéder à votre espace personnel', 'telabotanica')
        );
      else :
        printf(
          '<h1 class="cover-home-title">%s</h1>',
          $data->title
        );
      endif;

      the_telabotanica_module('search-box', [
        // TODO: make the suggestions configurable
        'suggestions' => ['coquelicot', 'quercus ilex', 'végétation', 'mooc'],
        'modifiers' => ['large', 'is-primary']
      ]);

      echo '</div>';

      $users_link = get_permalink( get_option('bp-pages')['members'] );
      $user_count = bp_get_total_member_count();
      $observations_link = get_permalink( get_page_by_path( 'cartographies/observations-botaniques' ) );

      if ( false === ( $observations_count = get_transient( 'cover_home_observations_count' ) ) ) {
        // TODO: définir cette URL en config
        $observations_count = file_get_contents('https://api.tela-botanica.org/service:cel:CelStatistiqueTxt/NbObsPubliques');
        if (is_int($observations_count)) {
          set_transient( 'cover_home_observations_count', $observations_count, 1 * HOUR_IN_SECONDS );
        }
      }

      $get_involved_link = get_permalink( get_page_by_path( 'comment-participer' ) );
      $get_involved_count = wp_count_posts('tb_participer')->publish;
      ?>
      <ul class="cover-home-stats">
        <li class="cover-home-stats-item cover-home-stats-item-users">
          <a href="<?php echo $users_link ?>">
            <div class="cover-home-stats-icon"><?php the_telabotanica_module('icon', ['icon' => 'users-outline']) ?></div>
            <?php printf(__('%s telabotanistes', 'telabotanica'), '<var>' . $user_count . '</var>') ?>
          </a>
        </li>
        <li class="cover-home-stats-item cover-home-stats-item-get-involved">
          <a href="<?php echo $get_involved_link ?>">
            <div class="cover-home-stats-icon"><?php the_telabotanica_module('icon', ['icon' => 'hand-outline']) ?></div>
            <?php printf(__('%s façons de participer', 'telabotanica'), '<var>' . number_format_i18n($get_involved_count) . '</var>') ?>
          </a>
        </li>
        <li class="cover-home-stats-item cover-home-stats-item-observations">
          <a href="<?php echo $observations_link ?>">
            <div class="cover-home-stats-icon"><?php the_telabotanica_module('icon', ['icon' => 'leaf-outline']) ?></div>
            <?php printf(__('%s observations', 'telabotanica'), '<var>' . number_format_i18n($observations_count) . '</var>') ?>
          </a>
        </li>
      </ul>
    <?php
    echo '</div>';

    telabotanica_image_credits( $data->image, 'cover' );

    echo '</div>';
}
