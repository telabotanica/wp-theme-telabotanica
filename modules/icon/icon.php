<?php function telabotanica_module_icon($data) {
  echo sprintf(
    '<svg aria-hidden="true" role="img" class="icon icon-%s"><use xlink:href="#icon-%s"></use></svg>',
    $data->icon,
    $data->icon
  );
}
