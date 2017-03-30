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

$search_input_name = bp_core_get_component_search_query_arg();
the_telabotanica_module('cover', [
	'title' => __( 'Annuaire des telabotanistes', 'telabotanica' ),
	'subtitle' => __( 'Recherchez et contactez les autres inscrits', 'telabotanica' ),
	'search' => [
		'id' => bp_current_component() . '-dir-search',
		'action' => '',
		'input_id' => bp_current_component() . '_search',
		'input_name' => $search_input_name,
		'placeholder' => __("Rechercher un utilisateur...", 'telabotanica'),
		'value' => $search_input_name && ! empty( $_REQUEST[ $search_input_name ] ) ? wp_unslash( $_REQUEST[ $search_input_name ] ) : false,
		'modifiers' => ['dir-search', 'large']
	]
]); ?>
<form action="" method="post" id="members-directory-form" class="dir-form">
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

							<li id="members-order-select" class="last filter toc-item">
								<label for="members-order-by"><?php _e( 'Order By:', 'buddypress' ); ?></label>
								<select id="members-order-by">
									<option value="active"><?php _e( 'Last Active', 'buddypress' ); ?></option>
									<option value="newest"><?php _e( 'Newest Registered', 'buddypress' ); ?></option>

									<!-- incompatible avec BP Members Directory Actions (pour l'instant) -->
									<!--<?php if ( bp_is_active( 'xprofile' ) ) : ?>
										<option value="alphabetical"><?php _e( 'Alphabetical', 'buddypress' ); ?></option>
									<?php endif; ?>-->

									<?php

									/**
									 * Fires inside the members directory member order options.
									 *
									 * @since 1.2.0
									 */
									do_action( 'bp_members_directory_order_options' ); ?>
								</select>
							</li>
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

		<?php

		/**
		 * Fires after the display of the members.
		 *
		 * @since 1.1.0
		 */
		do_action( 'bp_after_directory_members' ); ?>

		</div>
	</div>
</div>
</form><!-- #members-directory-form -->

<?php

/**
 * Fires at the bottom of the members directory template file.
 *
 * @since 1.5.0
 */
do_action( 'bp_after_directory_members_page' );
