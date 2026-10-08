<?php function telabotanica_block_maps($data) {
  $defaults = [
    'query' => false,
    'title' => get_sub_field('title'),
    'iframe_url' => get_sub_field('iframe_url'),
    'items' => get_sub_field('items'),
    'button' => get_sub_field('button'),
    'modifiers' => []
  ];

  $data = telabotanica_styleguide_data($defaults, $data);
  $data->modifiers = telabotanica_styleguide_modifiers_array(['block', 'block-maps'], $data->modifiers);

  printf(
    '<div class="%s">',
    implode(' ', $data->modifiers)
  );
  ?>

  <div class="layout-content-col reversed reversed-colors">
    <div class="layout-wrapper">
      <div class="layout-content">
        <?php
        if ( !empty($data->iframe_url) ) :
          printf(
            '<iframe class="lazyload" data-src="%s"></iframe>',
            esc_url( $data->iframe_url )
          );
        endif;
        ?>
      </div>
      <aside class="layout-column">
        <?php
        if ( function_exists('the_telabotanica_module') ) :
          the_telabotanica_module('title', [
            'title' => $data->title ?? '',
            'level' => 2,
            'modifiers' => 'with-margin-top'
          ]);
        endif;

        if ( !empty($data->items) && is_array($data->items) ) :

          // Remplacement des variables
          $data->items = array_filter($data->items, 'is_array');
          $data->items = array_map(function($item){
            $members_count = function_exists('tb_bp_members_count') ? tb_bp_members_count() : 0;
            $item['title'] = str_replace([
              '{countries_count}',
              '{members_count}',
              '{structures_count}'
            ], [
              number_format_i18n( 110 ), // TODO
              $members_count,
              number_format_i18n( 172 ) // TODO
            ], $item['title'] ?? '');
            return $item;
          }, $data->items);

          if ( function_exists('the_telabotanica_module') && !empty($data->items) ) :
            the_telabotanica_module('column-features', [
              'items' => $data->items,
              'modifiers' => 'layout-column-item'
            ]);
          endif;

        endif;

        $data->button = is_array($data->button) ? $data->button : [];

        $data->button['href'] = $data->button['url'] ?? '#';
        $data->button['text'] = $data->button['title'] ?? '';
        $data->button['modifiers'] = ['block', 'orange'];
        if ( function_exists('the_telabotanica_module') && !empty($data->button['text']) ) :
          the_telabotanica_module('button', $data->button);
        endif;
        ?>
      </aside>
    </div>
  </div>

  <?php
  echo '</div>';
}
