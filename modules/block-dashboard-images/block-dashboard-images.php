<?php function telabotanica_module_block_dashboard_images($data) {
	$defaults = [
		'title' => [],
		'modifiers' => ['block-dashboard-images'],
		'api_url' => 'https://api.tela-botanica.org/service:del:0.1/images?navigation.depart=0&navigation.limite=50&tri=date_transmission&ordre=desc&format=CRS&masque.auteur=' . bp_get_displayed_user_email()
		// For local debugging:
		// 'api_url' => '/wp-content/themes/telabotanica/modules/block-dashboard-images/test.xml'
	];

	$data = telabotanica_styleguide_data($defaults, $data);

	// Add the API url as a data-* attribute
	$data->extra_attributes['data-api-url'] = $data->api_url;
	unset($data->api_url);

	the_telabotanica_module('block-dashboard', $data);
}
