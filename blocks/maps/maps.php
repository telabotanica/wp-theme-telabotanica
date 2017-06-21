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
				printf(
					'<iframe src="%s"></iframe>',
					$data->iframe_url
				);
				?>
			</div>
			<aside class="layout-column">
				<?php
				the_telabotanica_module('title', [
					'title' => $data->title,
					'level' => 2,
					'modifiers' => 'with-margin-top'
				]);

				if ( $data->items ) :

					// Remplacement des variables
					$data->items = array_map(function($item){
						$item['title'] = str_replace([
							'{countries_count}',
							'{members_count}',
							'{structures_count}'
						], [
							number_format_i18n( 110 ), // TODO
							bp_get_total_member_count(),
							number_format_i18n( 172 ) // TODO
						], $item['title']);
						return $item;
					}, $data->items);

					the_telabotanica_module('column-features', [
						'items' => $data->items,
						'modifiers' => 'layout-column-item'
					]);

				endif;

				$data->button['href'] = $data->button['url'];
				$data->button['text'] = $data->button['title'];
				$data->button['modifiers'] = ['block', 'orange'];
				the_telabotanica_module('button', $data->button);
				?>
			</aside>
		</div>
	</div>

	<?php
	echo '</div>';
}
