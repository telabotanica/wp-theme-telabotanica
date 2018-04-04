<?php function telabotanica_module_icon($data) {
  if ( isset($data->color) ) {
    $data->color = 'icon-color-' . $data->color;
  } else {
    $data->color = '';
  }
  echo sprintf(
    '<svg aria-hidden="true" role="img" class="icon icon-%s %s"><use xlink:href="#icon-%s"></use></svg>',
    $data->icon,
    $data->color,
    $data->icon
  );
}
