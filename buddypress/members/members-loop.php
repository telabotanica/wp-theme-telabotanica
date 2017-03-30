<?php
/**
 * BuddyPress - Members Loop
 *
 * Querystring is set via AJAX in _inc/ajax.php - bp_legacy_theme_object_filter()
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

/**
 * Fires before the display of the members loop.
 *
 * @since 1.2.0
 */
do_action( 'bp_before_members_loop' ); ?>

<?php if ( bp_get_current_member_type() ) : ?>
	<p class="current-member-type"><?php bp_current_member_type_message() ?></p>
<?php endif; ?>

<?php
	// IMPORTANT at the moment (2017-02) this plugin guarantees compatibility
	// with BP Profile Search only if the member loop is initiated with default
	// parameters (type="active")
	if ( bp_has_members( bp_ajax_querystring( 'members' ) ) ) :

	/**
	 * Fires before the display of the members list.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_before_directory_members_list' ); ?>

	<div id="members-list" class="item-list" aria-live="assertive" aria-relevant="all">

	<?php while ( bp_members() ) : bp_the_member(); ?>

		<?php

		/**
		 * Fires before the display of a directory member item.
		 *
		 * @since 1.1.0
		 */
		// do_action( 'bp_directory_before_members_item' );

		the_telabotanica_component('contact', [
			'image' => bp_core_fetch_avatar(array(
				'item_id' => bp_get_member_user_id(),
				'html' => 'false',
				'type' => 'full'
			)),
			'name' => bp_get_member_name(),
			'description' => bp_get_member_last_active(),
			'link' => bp_get_member_permalink(),
			'modifiers' => bp_get_member_class(),
			'action_before' => 'bp_directory_before_members_item'
		]);

		/**
		 * Fires inside the display of a directory member item.
		 *
		 * @since 1.1.0
		 */
		do_action( 'bp_directory_members_item' );

		/***
		 * If you want to show specific profile fields here you can,
		 * but it'll add an extra query for each member in the loop
		 * (only one regardless of the number of fields you show):
		 *
		 * bp_member_profile_data( 'field=the field name' );
		 */

		/**
		 * Fires inside the members action HTML markup to display actions.
		 *
		 * @since 1.1.0
		 */
		do_action( 'bp_directory_members_actions' );

	endwhile; ?>

</div>

	<?php

	/**
	 * Fires after the display of the members list.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_after_directory_members_list' ); ?>

	<?php bp_member_hidden_fields(); ?>

	<div id="pag-bottom" class="pagination">

		<div class="pag-count" id="member-dir-count-bottom">

			<?php bp_members_pagination_count(); ?>

		</div>

		<div class="pagination-links" id="member-dir-pag-bottom">

			<?php bp_members_pagination_links(); ?>

		</div>

	</div>

<?php else: ?>

	<div id="message" class="notice notice-warning info">
		<p><?php _e( "Sorry, no members were found.", 'buddypress' ); ?></p>
	</div>

<?php endif; ?>

<?php

/**
 * Fires after the display of the members loop.
 *
 * @since 1.2.0
 */
do_action( 'bp_after_members_loop' ); ?>
