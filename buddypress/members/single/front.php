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
					'suffix' => '',
					'href' => 'https://www.tela-botanica.org/appli:cel',
					'target' => '_blank'
				],
				'button' => [
					'href' => get_permalink( get_page_by_path( 'carnet-en-ligne', OBJECT, 'tb_outil' ) ),
					'text' => __('Ajouter une observation', 'telabotanica'),
					'target' => '_blank'
				]
			]);

			the_telabotanica_module('block-dashboard-observations', [
				'title' => [
					'title' => __('Nouvelles observations du réseau - À déterminer', 'telabotanica'),
					'suffix' => '',
					'href' => 'http://www.tela-botanica.org/appli:identiplante?masque.type=adeterminer&page=1&pas=12&masque.pninscritsseulement=1&tri=date_transmission&ordre=desc',
					'target' => '_blank'
				],
				'button' => [
					'href' => get_permalink( get_page_by_path( 'carnet-en-ligne', OBJECT, 'tb_outil' ) ),
					'text' => __('Ajouter une observation', 'telabotanica'),
					'target' => '_blank'
				]
			]);
			?>
		</div>
		<div class="layout-column">
			<?php
			the_telabotanica_module('block-dashboard-images', [
				'title' => [
					'title' => __('Mes photos', 'telabotanica'),
					'suffix' => '',
					'href' => 'https://api.tela-botanica.org/service:del:0.1/images?navigation.depart=0&navigation.limite=8&tri=date_transmission&ordre=desc&format=CRXS&masque.auteur=' . bp_get_displayed_user_email(),
					'target' => '_blank'
				],
				'button' => [
					'href' => 'https://www.tela-botanica.org/widget:cel:saisie',
					'text' => __('Envoyer une photo', 'telabotanica'),
					'target' => '_blank'
				]
			]);

			$user_posts_query = new WP_Query([
				'posts_per_page' => 3,
				'author' => get_current_user_id(),
				'post_status' => 'publish'
			]);
			$user_posts = '';
			if ( $user_posts_query->have_posts() ) :
				while ( $user_posts_query->have_posts() ) : $user_posts_query->the_post();
					$user_posts .= get_telabotanica_module('feed-item', [
						'article' => true,
						'href' => get_permalink(),
						'target' => '_blank',
						'title' => html_entity_decode(get_the_title()),
						'text' => html_entity_decode(wp_trim_words(get_the_excerpt(), 8))
					]);
				endwhile;
			endif;
			wp_reset_postdata();
			$user_posts_button = [
				'href' => get_permalink( get_page_by_path( 'proposer-une-actualite' ) ),
				'text' => __('Proposer une actualité', 'telabotanica')
			];
			the_telabotanica_module('block-dashboard', [
				'title' => [
					'title' => __('Mes actualités', 'telabotanica')
				],
				'html_content' => $user_posts,
				'empty' => [
					'icon' => 'news',
					'text' => __("Vous n'avez pas encore ajouté d'actualités", 'telabotanica'),
					'button' => $user_posts_button
				],
				'is_empty' => $user_posts === '',
				'button' => $user_posts_button
			]);

			the_telabotanica_module('block-dashboard', [
				'title' => [
					'title' => __('Soutenir Tela Botanica', 'telabotanica'),
					'href' => get_permalink( get_page_by_path( 'presentation/soutenir' ) ),
				],
				'html_content' => '', // TODO
				'empty' => [
					'icon' => 'heart-outline',
					'text' => __("Soutenez le réseau et ses actions", 'telabotanica'),
					// 'text' => __("Vous n'avez pas encore fait de don", 'telabotanica'),
					'button' => [
						'href' => get_permalink( get_page_by_path( 'presentation/soutenir' ) ),
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
