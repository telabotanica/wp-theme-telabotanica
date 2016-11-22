<?php function telabotanica_module_button_top($data) {
  echo sprintf(
    '<a href="%s" class="button-top" title="%s" tabindex="-1">%s %s</a>',
    '#',
    __( 'Remonter en haut de la page', 'telabotanica' ),
    get_telabotanica_module('icon', ['icon' => 'arrow-up']),
    __( 'Remonter', 'telabotanica' )
  );
}
