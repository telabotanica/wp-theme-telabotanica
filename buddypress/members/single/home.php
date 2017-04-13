<?php
/**
 * BuddyPress - Members Home
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

if ( bp_is_user_front() && bp_displayed_user_id() !== get_current_user_id() ) :

	// Profil public d'un autre utilisateur

	the_telabotanica_module('cover-member');

	?>
	<div class="layout-central-col">
		<div class="layout-wrapper">
			<div class="layout-content"><?php

			// Display XProfile
			if ( bp_is_active( 'xprofile' ) )
				bp_get_template_part( 'members/single/profile/profile-loop' );

			// Display WordPress profile (fallback)
			else
				bp_get_template_part( 'members/single/profile/profile-wp' );

		?>
		</div>
	</div>
</div>
<?php

else :

	// Tableau de bord
?>
<div class="layout-content-col is-dashboard reversed-colors">
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
						'current' => bp_is_user_front()
					],
					[
						'href' => bp_loggedin_user_domain() . 'messages/',
						'text' => __( 'Mes messages', 'telabotanica' ),
						'icon' => 'mail',
						'dot' => true,
						'current' => bp_is_user_messages()
					],
					[
						'href' => bp_loggedin_user_domain() . 'outils/',
						'text' => __( 'Mes outils', 'telabotanica' ),
						'icon' => 'tool',
						'current' => bp_is_current_component('outils')
					],
					[
						'href' => bp_loggedin_user_domain() . 'projets/',
						'text' => __( 'Mes projets', 'telabotanica' ),
						'icon' => 'projects',
						'current' => bp_is_user_groups()
					],
					// TODO: réafficher quand la page est prête
					// [
					// 	'href' => bp_loggedin_user_domain() . 'thematiques/',
					// 	'text' => __( 'Mes thématiques', 'telabotanica' ),
					// 	'icon' => 'bookmark',
					// 	'current' => bp_is_current_component('thematiques')
					// ],
					[
						'href' => bp_loggedin_user_domain() . 'documents/',
						'text' => __( 'Mes documents', 'telabotanica' ),
						'icon' => 'doc',
						'current' => bp_is_current_component('documents')
					],
					[
						'href' => bp_loggedin_user_domain() . 'contributions/',
						'text' => __( 'Mes contributions', 'telabotanica' ),
						'icon' => 'hand',
						'current' => bp_is_current_component('contributions')
					],
					[
						'href' => bp_loggedin_user_domain() . 'profile/',
						'text' => __( 'Mon profil', 'telabotanica' ),
						'icon' => 'user',
						'current' => bp_is_user_profile()
					],
					[
						'href' => bp_loggedin_user_domain() . 'settings/',
						'text' => __( 'Mes réglages', 'telabotanica' ),
						'icon' => 'settings',
						'current' => bp_is_user_settings()
					],
					// TODO: réafficher quand la page est prête
					// [
					// 	'href' => bp_loggedin_user_domain() . 'dons/',
					// 	'text' => __( 'Mes dons', 'telabotanica' ),
					// 	'icon' => 'heart',
					// 	'current' => bp_is_current_component('dons')
					// ],
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
				// if ( bp_displayed_user_use_cover_image_header() ) :
				// 	bp_get_template_part( 'members/single/cover-image-header' );
				// else :
				// 	bp_get_template_part( 'members/single/member-header' );
				// endif;
				?>

			</div><!-- #item-header -->

			<!-- <div id="item-nav">
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
			</div>-->

			<div id="item-body">

				<div id="template-notices" role="alert" aria-atomic="true">
					<?php
					/** This action is documented in bp-templates/bp-legacy/buddypress/activity/index.php */
					do_action( 'template_notices' ); ?>
				</div>

				<?php

				/**
				 * Fires before the display of member body content.
				 *
				 * @since 1.2.0
				 */
				do_action( 'bp_before_member_body' );

				if ( bp_is_user_front() ) :
					// Accueil du tableau de bord
					bp_displayed_user_front_template_part();

				elseif ( bp_is_user_activity() ) :
					bp_get_template_part( 'members/single/activity' );

				elseif ( bp_is_user_blogs() ) :
					bp_get_template_part( 'members/single/blogs' );

				elseif ( bp_is_user_friends() ) :
					bp_get_template_part( 'members/single/friends' );

				elseif ( bp_is_user_groups() ) :
					bp_get_template_part( 'members/single/groups' );

				elseif ( bp_is_user_messages() ) :
					bp_get_template_part( 'members/single/messages' );

				elseif ( bp_is_user_profile() ) :
					bp_get_template_part( 'members/single/profile' );

				elseif ( bp_is_user_forums() ) :
					bp_get_template_part( 'members/single/forums' );

				elseif ( bp_is_user_notifications() ) :
					bp_get_template_part( 'members/single/notifications' );

				elseif ( bp_is_user_settings() ) :
					bp_get_template_part( 'members/single/settings' );

				elseif ( bp_is_current_component('documents') ) :
					bp_get_template_part( 'members/single/documents' );

				elseif ( bp_is_current_component('thematiques') ) :
					bp_get_template_part( 'members/single/thematiques' );

				elseif ( bp_is_current_component('outils') ) :
					bp_get_template_part( 'members/single/outils' );

				elseif ( bp_is_current_component('contributions') ) :
					bp_get_template_part( 'members/single/contributions' );

				elseif ( bp_is_current_component('dons') ) :
					bp_get_template_part( 'members/single/dons' );

				// If nothing sticks, load a generic template
				else :
					bp_get_template_part( 'members/single/plugins' );

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
<?php
endif;
