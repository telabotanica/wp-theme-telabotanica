<?php
/**
 * BuddyPress - Members
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

/**
 * Fires at the top of the members directory template file.
 *
 * @since 1.5.0
 */
do_action( 'bp_before_directory_members_page' );


// nom (slug) de la page associée au composant "membres" de Buddypress
// (utiliser le slug du post courant ne marche pas toujours lorsqu'une recherche
// via le bandeau a été effectuée !)
$pages_bp = get_option('bp-pages');
$nom_page_membres = get_post_field('post_name', $pages_bp['members']);

$search_input_name = bp_core_get_component_search_query_arg();
the_telabotanica_module('cover', [
	'image' => get_field('cover_image'),
	'title' => get_the_title(),
	'subtitle' => get_field('cover_subtitle'),
	'search' => [
		'id' => bp_current_component() . '-dir-search',
		'action' => '',
		'input_id' => bp_current_component() . '_search',
		'input_name' => $search_input_name,
		'placeholder' => __("Rechercher des telabotanistes...", 'telabotanica'),
		'value' => $search_input_name && ! empty( $_REQUEST[ $search_input_name ] ) ? wp_unslash( $_REQUEST[ $search_input_name ] ) : false,
		'modifiers' => ['dir-search', 'large'],
		'pageurl' => $nom_page_membres
	]
]); ?>

<div class="layout-content-col">
	<div class="layout-wrapper">
		<aside class="layout-column">

			<div class="toc">

				<h2 class="title toc-title with-border-bottom">
					<?php _e("Filtrer", 'telabotanica') ?>
				</h2>

				<ul class="toc-items">
					<li class="selected toc-item">
						<a class="toc-item-link" href="<?php bp_members_directory_permalink(); ?>"><?php printf( __( 'All Members %s', 'buddypress' ), '<span>(' . bp_get_total_member_count() . ')</span>' ); ?></a>
					</li>

					<?php if ( is_user_logged_in() && bp_is_active( 'friends' ) && bp_get_total_friend_count( bp_loggedin_user_id() ) ) : ?>
						<li id="members-personal"><a href="<?php echo esc_url( bp_loggedin_user_domain() . bp_get_friends_slug() . '/my-friends/' ); ?>"><?php printf( __( 'My Friends %s', 'buddypress' ), '<span>' . bp_get_total_friend_count( bp_loggedin_user_id() ) . '</span>' ); ?></a></li>
					<?php endif; ?>

					<?php

					/**
					 * Fires inside the members directory member types.
					 *
					 * @since 1.2.0
					 */
					do_action( 'bp_members_directory_member_types' ); ?>

					<li class="toc-item">

					<!--<div class="item-list-tabs" id="subnav" aria-label="<?php esc_attr_e( 'Members directory secondary navigation', 'buddypress' ); ?>" role="navigation">-->
						<ul class="toc-subitems">
							<?php

							/**
							 * Fires inside the members directory member sub-types.
							 *
							 * @since 1.5.0
							 */
							do_action( 'bp_members_directory_member_sub_types' ); ?>
						</ul>
					<!--</div>-->
					</li>
				</ul>

			<div class="item-list-tabs advanced-search-container">
				<?php
				/**
				 * Fires before the display of the members list tabs.
				 *
				 * @since 1.8.0
				 */
				do_action( 'bp_before_directory_members_tabs' );
				// BP Profile Search advanced search form hooks here
				?>
			</div>

			</div>

		</aside>
		<div class="layout-content">
			<form action="" method="post" id="members-directory-form" class="dir-form">
			<?php

			/**
			 * Fires before the display of the members.
			 *
			 * @since 1.1.0
			 */
			do_action( 'bp_before_directory_members' ); ?>

			<?php

			/**
			 * Fires before the display of the members content.
			 *
			 * @since 1.1.0
			 */
			do_action( 'bp_before_directory_members_content' );

			?>

				<div id="members-dir-list" class="members dir-list">
					<?php bp_get_template_part( 'members/members-loop' ); ?>
				</div><!-- #members-dir-list -->

				<?php

				/**
				 * Fires and displays the members content.
				 *
				 * @since 1.1.0
				 */
				do_action( 'bp_directory_members_content' ); ?>

				<?php wp_nonce_field( 'directory_members', '_wpnonce-member-filter' ); ?>

				<?php

				/**
				 * Fires after the display of the members content.
				 *
				 * @since 1.1.0
				 */
				do_action( 'bp_after_directory_members_content' ); ?>

			</form><!-- #members-directory-form -->

			<?php

			/**
			 * Displays ACF content for current page
			 * i.e. members index action disclaimer (if set)
			 */
			add_action('display_acf_content', 'display_acf_content', 10, 1);
			function display_acf_content($current_page_id) {
				// On boucle sur les composants ACF
				while ( have_rows('components', $current_page_id) ) :
					the_row();
					the_telabotanica_component(get_row_layout());
				endwhile;
			}
			do_action( 'display_acf_content', get_queried_object()->ID );

			/**
			 * Fires after the display of the members.
			 *
			 * @since 1.1.0
			 */
			do_action( 'bp_after_directory_members' ); ?>

		</div>
	</div>
</div>

<?php

/**
 * Fires at the bottom of the members directory template file.
 *
 * @since 1.5.0
 */
do_action( 'bp_after_directory_members_page' );
