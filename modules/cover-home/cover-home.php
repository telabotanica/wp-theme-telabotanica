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
		$data->image['url']
	);

		echo '<div class="layout-wrapper">';
			echo '<div class="cover-home-content">';

      if ( is_user_logged_in() ) :
        $current_user = wp_get_current_user();
        echo sprintf(
          '<h1 class="cover-home-title">%s</h1>',
          sprintf(__('Bienvenue %s !', 'telabotanica'), $current_user->display_name)
        );
        echo sprintf(
          '<div class="cover-home-link"><a href="%s">%s</a></div>',
          '#', // TODO
          __('Accéder à votre espace personnel', 'telabotanica')
        );
      else :
        echo sprintf(
          '<h1 class="cover-home-title">%s</h1>',
          $data->title
        );
      endif;

      the_telabotanica_module('search-box', [
        // TODO: make the suggestions configurable
        'suggestions' => ['coquelicot', 'quercus ilex', 'végétation', 'mooc']
      ]);

			echo '</div>';

      // TODO: brancher les liens
      $users_link = '#';
      $user_count = bp_get_total_member_count();
      $observations_link = '#';
      // TODO: définir cette URL en config + mettre en cache
      $observations_count = file_get_contents('https://api.tela-botanica.org/service:cel:CelStatistiqueTxt/NbObsPubliques');
      $get_involved_link = get_permalink( get_page_by_path( 'comment-participer' ) );
      $get_involved_count = wp_count_posts('tb_participer')->publish;
      ?>
      <ul class="cover-home-stats">
        <li class="cover-home-stats-item cover-home-stats-item-users">
          <a href="<?php echo $users_link ?>">
            <div class="cover-home-stats-icon"><?php the_telabotanica_module('icon', ['icon' => 'users-outline']) ?></div>
            <?php printf(__('%s telabotanistes', 'telabotanica'), '<var>' . number_format_i18n($user_count) . '</var>') ?>
          </a>
        </li>
        <li class="cover-home-stats-item cover-home-stats-item-observations">
          <a href="<?php echo $observations_link ?>">
            <div class="cover-home-stats-icon"><?php the_telabotanica_module('icon', ['icon' => 'leaf-outline']) ?></div>
            <?php printf(__('%s observations', 'telabotanica'), '<var>' . number_format_i18n($observations_count) . '</var>') ?>
          </a>
        </li>
        <li class="cover-home-stats-item cover-home-stats-item-get-involved">
          <a href="<?php echo $get_involved_link ?>">
            <div class="cover-home-stats-icon"><?php the_telabotanica_module('icon', ['icon' => 'hand-outline']) ?></div>
            <?php printf(__('%s façons de participer', 'telabotanica'), '<var>' . number_format_i18n($get_involved_count) . '</var>') ?>
          </a>
        </li>
      </ul>
    <?php
		echo '</div>';

      if ( $data->image ) :
        $credits = get_fields( $data->image['ID'] );
        if ( $credits ) :
          echo '<div class="cover-credits">';
          if ($credits['link']) {
            echo sprintf(__('%s par %s', 'telabotanica'), '<a href="' . $credits['link'] . '" target="_blank">' . $data->image['title'] . '</a>', $credits['author']);
          } else {
            echo sprintf(__('%s par %s', 'telabotanica'), $data->image['title'], $credits['author']);
          }
          echo '</div>';
        endif;
    endif;

		echo '</div>';
}
