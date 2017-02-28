<?php

function telabotanica_block_maps($data) {
	$defaults = [
		'query' => false,
		'title' => get_sub_field('title'),
		'items' => get_sub_field('items'),
		'buttons' => get_sub_field('buttons'),
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
			</div>
			<aside class="layout-column">
				<?php
				the_telabotanica_module('title', [
					'title' => __('Cartographies', 'telabotanica'),
					'level' => 2,
					'modifiers' => 'with-margin-top'
				]);

				the_telabotanica_module('column-features', [
					'items' => [
						[
							'href' => '#', // TODO
							'icon' => 'news',
							'color' => '#009fb8',
							'title' => "110 pays",
							'text' => __("Le réseau Tela Botanica rassemble des passionnés de tous pays", 'telabotanica'),
						],
						[
							'href' => '#', // TODO
							'icon' => 'members',
							'color' => '#ff5d55',
							'title' => "28 214 telabotanistes",
							'text' => __("Trouvez les inscrits près de chez vous et prenez contact", 'telabotanica'),
						],
						[
							'href' => '#', // TODO
							'icon' => 'home',
							'color' => '#918a6f',
							'title' => "172 structures",
							'text' => __("À travers le monde, les structures locales vous accompagnent dans vos découvertes naturalistes", 'telabotanica'),
						]
					],
					'modifiers' => 'layout-column-item'
				]);

				the_telabotanica_module('button', [
					'href' => '#', // TODO
					'text' => __('Explorer les cartographies', 'telabotanica'),
					'modifiers' => ['block', 'orange']
				]);
				?>
			</aside>
		</div>
	</div>

	<?php
	echo '</div>';
}
