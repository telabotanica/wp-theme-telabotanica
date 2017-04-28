<?php
/**
 * BuddyPress - Members - Custom front page for Tela Botanica
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

$current_user = wp_get_current_user();

the_telabotanica_module('header-dashboard', [
	'title' => sprintf(__('Bonjour %s !', 'telabotanica'), $current_user->display_name),
	// TODO replace `true` by a real condition below
	// TODO add number of messages
	'message' => true ? sprintf(
		__('Vous avez un <a href="%s">nouveau message</a>', 'telabotanica'),
		bp_loggedin_user_domain() . 'messages/'
	) : false
]);

?>
<div class="layout-2-col larger-first-col">
	<div class="layout-wrapper">
		<div class="layout-column">
			<?php
			the_telabotanica_module('block-dashboard-observations', [
				'title' => [
					'title' => __('Mes observations', 'telabotanica'),
					'suffix' => '...',
					'href' => '#' // TODO
				],
				'button' => [
					'href' => '#', // TODO
					'text' => __('Ajouter une observation', 'telabotanica')
				]
			]);


			$observations = [
				[
					'type' => 'feed-item',
					'href' => '#',
					'image' => 'https://api.tela-botanica.org/img:001125636CRXS.jpg',
					'title' => 'Allium vineale ??',
					'text' => 'Le 15 Juin 2016 - Par Hervé Lot',
					'meta' => [
						'place' => 'Saturargues (34)'
					]
				],
				[
					'type' => 'feed-item',
					'href' => '#',
					'image' => 'https://api.tela-botanica.org/img:001129856CRXS.jpg',
					'title' => '??',
					'text' => 'Le 15 Juin 2016 - Par Hervé Lot',
					'meta' => [
						'place' => 'Murol (63)'
					]
				],
				[
					'type' => 'feed-item',
					'href' => '#',
					'image' => 'https://api.tela-botanica.org/img:001129797CRXS.jpg',
					'title' => '??',
					'text' => 'Le 15 Juin 2016 - Par Hervé Lot',
					'meta' => [
						'place' => 'Grenoble (38)'
					]
				]
			];

			$html_content_observations = '';
			foreach ( $observations as $obs ) {
				$html_content_observations .= get_telabotanica_module('feed-item', $obs);
			}

			the_telabotanica_module('block-dashboard', [
				'title' => [
					'title' => __('Nouvelles observations du réseau - À déterminer', 'telabotanica'),
					'suffix' => '12', // TODO
					'href' => '#'
				],
				'html_content' => $html_content_observations,
				'button' => [
					'href' => '#', // TODO
					'text' => __('Tout afficher', 'telabotanica')
				],
				'modifiers' => 'transparent-content'
			]);
			?>
		</div>
		<div class="layout-column">
			<?php
			the_telabotanica_module('block-dashboard-images', [
				'title' => [
					'title' => __('Mes photos', 'telabotanica'),
					'suffix' => '...', // TODO
					'href' => '#' // TODO
				],
				'button' => [
					'href' => '#', // TODO
					'text' => __('Envoyer une photo', 'telabotanica')
				]
			]);

			the_telabotanica_module('block-dashboard', [
				'title' => [
					'title' => __('Mes actualités', 'telabotanica'),
					'href' => '#'
				],
				'html_content' => 'mosaic photos', // TODO
				'empty' => [
					'icon' => 'news',
					'text' => __("Vous n'avez pas encore ajouté d'actualités", 'telabotanica'),
					'button' => [
						'href' => '#', // TODO
						'text' => __('Proposer une actualité', 'telabotanica')
					]
				],
				'is_empty' => true
			]);

			// the_telabotanica_module('block-dashboard', [
			// 	'title' => [
			// 		'title' => __('Mes dons', 'telabotanica'),
			// 		'href' => bp_loggedin_user_domain() . 'dons/'
			// 	],
			// 	'html_content' => 'mosaic photos', // TODO
			// 	'empty' => [
			// 		'icon' => 'heart-outline',
			// 		'text' => __("Vous n'avez pas encore fait de don", 'telabotanica'),
			// 		'button' => [
			// 			'href' => '#', // TODO
			// 			'text' => __('Faites un don !', 'telabotanica'),
			// 			'modifiers' => 'rouge'
			// 		]
			// 	],
			// 	'is_empty' => true
			// ]);
			?>
		</div>
	</div>
</div>
<?php
