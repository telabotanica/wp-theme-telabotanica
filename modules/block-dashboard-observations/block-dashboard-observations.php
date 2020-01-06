<?php function telabotanica_module_block_dashboard_observations($data) {
  $defaults = [
    'title' => [],
    'modifiers' => ['block-dashboard-observations', 'transparent-content'],
    'api_url' => 'https://api.tela-botanica.org/service:del:0.1/observations?navigation.depart=0&navigation.limite=5&masque.pninscritsseulement=1&masque.type=adeterminer&tri=date_transmission&ordre=desc'
    // For local debugging:
    // 'api_url' => '/wp-content/themes/telabotanica/modules/block-dashboard-observations/test.json'
  ];

  $data = telabotanica_styleguide_data($defaults, $data);

  // Add the API url as a data-* attribute
  $data->extra_attributes['data-api-url'] = $data->api_url;
  unset($data->api_url);

  the_telabotanica_module('block-dashboard', $data);
}
