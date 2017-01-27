<?php function telabotanica_module_cover_home($data) {
  if (!isset($data->image)) $data->image = get_field('cover_image');
  if (!isset($data->title)) $data->title = __('Bienvenue sur Tela Botanica, <br />le réseau des botanistes francophones', 'telabotanica');
  if (!isset($data->content)) $data->content = false;
  if (!isset($data->modifiers)) $data->modifiers = '';
  ?>
  <div class="cover-home <?php echo $data->modifiers ?>" style="background-image: url(<?php echo $data->image['url'] ?>);">
    <div class="layout-wrapper">
      <?php
      if ( is_user_logged_in() ) :
        $current_user = wp_get_current_user();
        echo sprintf(
          '<h1 class="cover-home-title">%s</h1>',
          sprintf(__('Bienvenue %s !', 'telabotanica'), $current_user->display_name)
        );
        echo sprintf(
          '<div class="cover-home-link"><a href="%s">%s</a></div>',
          '#',
          __('Accéder à votre espace personnel', 'telabotanica')
        );
      else :
        echo sprintf(
          '<h1 class="cover-home-title">%s</h1>',
          $data->title
        );
      endif;

      if ($data->content) :
        echo sprintf(
          '<div class="cover-home-content">%s</div>',
          $data->content
        );
      endif; ?>

      <ul class="cover-home-stats">
        <li class="cover-home-stats-item cover-home-stats-item-users"><a href="#"><var>XX XXX</var> télabotanistes</a></li>
        <li class="cover-home-stats-item cover-home-stats-item-observations"><a href="#"><var>XX XXX</var> observations</a></li>
        <li class="cover-home-stats-item cover-home-stats-item-get-involved"><a href="#"><var>XX XXX</var> façons de participer</a></li>
      </ul>
    </div>
    <?php
      if ( $data->image ) :
        $credits = get_fields( $data->image['ID'] );
        if ( $credits ) :
          echo '<div class="cover-home-credits">';
          if ($credits['link']) {
            echo sprintf(__('%s par %s', 'telabotanica'), '<a href="' . $credits['link'] . '" target="_blank">' . $data->image['title'] . '</a>', $credits['author']);
          } else {
            echo sprintf(__('%s par %s', 'telabotanica'), $data->image['title'], $credits['author']);
          }
          echo '</div>';
        endif;
    endif; ?>
  </div>
<?php }
