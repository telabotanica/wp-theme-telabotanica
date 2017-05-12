<?php
/**
 * BuddyPress - Members - Custom front page for Tela Botanica
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

$current_user = wp_get_current_user();

$has_messages = bp_has_message_threads( array(
	'box' => 'inbox',
	'type' => 'unread'
) );

the_telabotanica_module('header-dashboard', [
	'title' => sprintf(__('Bonjour %s !', 'telabotanica'), $current_user->display_name),
	'message' => $has_messages ? sprintf(
		__('Vous avez %s <a href="%s">nouveau(x) message(s)</a>', 'telabotanica'),
		bp_get_total_unread_messages_count(),
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
					'href' => 'https://www.tela-botanica.org/appli:cel'
				],
				'button' => [
					'href' => get_permalink( get_page_by_path( 'carnet-en-ligne', OBJECT, 'tb_outil' ) ),
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

			$url_observations_reseau = '#'; // TODO
			the_telabotanica_module('block-dashboard', [
				'title' => [
					'title' => __('Nouvelles observations du réseau - À déterminer', 'telabotanica'),
					'suffix' => '12', // TODO
					'href' => $url_observations_reseau
				],
				'html_content' => $html_content_observations,
				'button' => [
					'href' => $url_observations_reseau,
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
					'href' => 'https://www.tela-botanica.org/appli:pictoflora?masque.auteur=' . bp_get_displayed_user_email()
				],
				'button' => [
					'href' => 'https://www.tela-botanica.org/widget:cel:saisie',
					'text' => __('Envoyer une photo', 'telabotanica')
				]
			]);

			the_telabotanica_module('block-dashboard', [
				'title' => [
					'title' => __('Mes actualités', 'telabotanica'),
					'href' => '#'
				],
				'html_content' => 'mes actualités', // TODO
				'empty' => [
					'icon' => 'news',
					'text' => __("Vous n'avez pas encore ajouté d'actualités", 'telabotanica'),
					'button' => [
						'href' => get_permalink( get_page_by_path( 'proposer-une-actualite' ) ),
						'text' => __('Proposer une actualité', 'telabotanica')
					]
				],
				'is_empty' => true // TODO: ajouter la logique "si l'utilisateur a soumis des actualités"
			]);

			the_telabotanica_module('block-dashboard', [
				'title' => [
					'title' => __('Mes dons', 'telabotanica'),
					'href' => bp_loggedin_user_domain() . 'dons/'
				],
				'html_content' => 'mes dons', // TODO
				'empty' => [
					'icon' => 'heart-outline',
					'text' => __("Retrouvez prochainement ici la liste de vos dons", 'telabotanica'),
					// 'text' => __("Vous n'avez pas encore fait de don", 'telabotanica'),
					'button' => [
						'href' => get_permalink( get_page_by_path( 'soutenir' ) ),
						'text' => __('Faites un don !', 'telabotanica'),
						'modifiers' => 'rouge'
					]
				],
				'is_empty' => true // TODO: ajouter la logique "si l'utilisateur a fait des dons"
			]);
			?>
		</div>
	</div>
</div>
<?php
