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
			the_telabotanica_module('block-dashboard-map', [
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

			the_telabotanica_module('block-dashboard-observations', [
				'title' => [
					'title' => __('Nouvelles observations du réseau - À déterminer', 'telabotanica'),
					'suffix' => '...', // TODO
					'href' => '#' // TODO
				],
				// 'api_url' => 'https://api.tela-botanica.org/service:del:0.1/observations?navigation.depart=0&navigation.limite=5&masque.pninscritsseulement=1&tri=date_transmission&ordre=desc',
				'button' => [
					'href' => get_permalink( get_page_by_path( 'carnet-en-ligne', OBJECT, 'tb_outil' ) ),
					'text' => __('Ajouter une observation', 'telabotanica')
				]
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
					'href' => '#' // TODO
					// 'href' => bp_loggedin_user_domain() . 'dons/'
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
