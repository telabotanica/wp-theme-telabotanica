<?php
/**
 * BuddyPress - Members Home
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>

<div id="buddypress" class="layout-content-col is-dashboard reversed-colors">
	<div class="layout-wrapper">
		<aside class="layout-column">
			<?php
			// $bp = buddypress();
			// $items = array_map( function ( $item ) {
			// 	return $item;
			// }, $bp->members->nav->get_primary() );

			the_telabotanica_module('nav-dashboard', [
				'items' => [
					[
						'href' => bp_loggedin_user_domain(),
						'text' => __( 'Mon espace personnel', 'telabotanica' ),
						'icon' => 'dashboard',
						'current' => bp_is_user_profile() && bp_current_action() === 'public'
					],
					[
						'href' => bp_loggedin_user_domain() . 'messages/',
						'text' => __( 'Mes messages', 'telabotanica' ),
						'icon' => 'mail',
						'dot' => true,
						'current' => bp_is_user_messages()
					],
					[
						'href' => '#',
						'text' => __( 'Mes outils', 'telabotanica' ),
						'icon' => 'tool'
					],
					[
						'href' => bp_loggedin_user_domain() . 'groups/',
						'text' => __( 'Mes projets', 'telabotanica' ),
						'icon' => 'projects',
						'current' => bp_is_user_groups()
					],
					[
						'href' => '#',
						'text' => __( 'Mes thématiques', 'telabotanica' ),
						'icon' => 'bookmark'
					],
					[
						'href' => '#',
						'text' => __( 'Mes documents', 'telabotanica' ),
						'icon' => 'doc'
					],
					[
						'href' => '#',
						'text' => __( 'Mes contributions', 'telabotanica' ),
						'icon' => 'hand'
					],
					[
						'href' => bp_loggedin_user_domain() . 'profile/edit/',
						'text' => __( 'Mon profil', 'telabotanica' ),
						'icon' => 'user',
						'current' => bp_is_user_profile() && bp_current_action() === 'edit'
					],
					[
						'href' => '#',
						'text' => __( 'Mes dons', 'telabotanica' ),
						'icon' => 'heart'
					],
					[
						'href' => wp_logout_url( home_url() ),
						'text' => __( 'Me déconnecter', 'telabotanica' ),
						'icon' => 'log-off',
						'modifiers' => 'is-last'
					]
				]
			]);
			?>
		</aside>
		<div class="layout-content">

			<?php

			/**
			 * Fires before the display of member home content.
			 *
			 * @since 1.2.0
			 */
			do_action( 'bp_before_member_home_content' ); ?>

			<div id="item-header" role="complementary">

				<?php
				/**
				 * If the cover image feature is enabled, use a specific header
				 */
				if ( bp_displayed_user_use_cover_image_header() ) :
					bp_get_template_part( 'members/single/cover-image-header' );
				else :
					bp_get_template_part( 'members/single/member-header' );
				endif;
				?>

			</div><!-- #item-header -->

			<div id="item-nav">
				<div class="item-list-tabs no-ajax" id="object-nav" aria-label="<?php esc_attr_e( 'Member primary navigation', 'buddypress' ); ?>" role="navigation">
					<ul>

						<?php bp_get_displayed_user_nav(); ?>

						<?php

						/**
						 * Fires after the display of member options navigation.
						 *
						 * @since 1.2.4
						 */
						do_action( 'bp_member_options_nav' ); ?>

					</ul>
				</div>
			</div><!-- #item-nav -->

			<div id="item-body">

				<?php

				/**
				 * Fires before the display of member body content.
				 *
				 * @since 1.2.0
				 */
				do_action( 'bp_before_member_body' );

				if ( bp_is_user_front() ) :
					bp_displayed_user_front_template_part();

				elseif ( bp_is_user_activity() ) :
					bp_get_template_part( 'members/single/activity' );

				elseif ( bp_is_user_blogs() ) :
					bp_get_template_part( 'members/single/blogs'    );

				elseif ( bp_is_user_friends() ) :
					bp_get_template_part( 'members/single/friends'  );

				elseif ( bp_is_user_groups() ) :
					bp_get_template_part( 'members/single/groups'   );

				elseif ( bp_is_user_messages() ) :
					bp_get_template_part( 'members/single/messages' );

				elseif ( bp_is_user_profile() ) :
					bp_get_template_part( 'members/single/profile'  );

				elseif ( bp_is_user_forums() ) :
					bp_get_template_part( 'members/single/forums'   );

				elseif ( bp_is_user_notifications() ) :
					bp_get_template_part( 'members/single/notifications' );

				elseif ( bp_is_user_settings() ) :
					bp_get_template_part( 'members/single/settings' );

				// If nothing sticks, load a generic template
				else :
					bp_get_template_part( 'members/single/plugins'  );

				endif;

				/**
				 * Fires after the display of member body content.
				 *
				 * @since 1.2.0
				 */
				do_action( 'bp_after_member_body' ); ?>

			</div><!-- #item-body -->

			<?php

			/**
			 * Fires after the display of member home content.
			 *
			 * @since 1.2.0
			 */
			do_action( 'bp_after_member_home_content' ); ?>
		</div>
	</div>
</div><!-- #buddypress -->
