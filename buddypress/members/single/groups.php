<?php
/**
 * BuddyPress - Users Groups
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

the_telabotanica_module('header-dashboard', [
	'title' => __('Mes projets', 'telabotanica')
]);

if ( !bp_is_current_action( 'invites' ) ) : ?>

	<div id="groups-order-select" style="float: right">

		<label for="groups-order-by"><?php _e( 'Order By:', 'buddypress' ); ?></label>
		<select id="groups-order-by">
			<option value="active"><?php _e( 'Last Active', 'buddypress' ); ?></option>
			<option value="popular"><?php _e( 'Most Members', 'buddypress' ); ?></option>
			<option value="newest"><?php _e( 'Newly Created', 'buddypress' ); ?></option>
			<option value="alphabetical"><?php _e( 'Alphabetical', 'buddypress' ); ?></option>

			<?php

			/**
			 * Fires inside the members group order options select input.
			 *
			 * @since 1.2.0
			 */
			do_action( 'bp_member_group_order_options' ); ?>

		</select>
	</div>

<?php endif;

if ( bp_is_my_profile() ):
	$nav_tabs_items = array_map(function($item){
		if ($item->parent !== 'groups') return;

		$item = [
			'href' => $item->link,
			'text' => $item->name,
			'current' => in_array('current-menu-item', $item->class)
		];

		return (object) $item;
	}, bp_get_nav_menu_items());

	the_telabotanica_module('nav-tabs', [
		'label' => __( 'Member secondary navigation', 'buddypress' ),
		'items' => array_filter($nav_tabs_items)
	]);
endif;

switch ( bp_current_action() ) :

	// Home/My Groups
	case 'my-groups' :

		/**
		 * Fires before the display of member groups content.
		 *
		 * @since 1.2.0
		 */
		do_action( 'bp_before_member_groups_content' ); ?>

		<?php if ( is_user_logged_in() ) : ?>
			<h2 class="bp-screen-reader-text"><?php
				/* translators: accessibility text */
				_e( 'My groups', 'buddypress' );
			?></h2>
		<?php else : ?>
			<h2 class="bp-screen-reader-text"><?php
				/* translators: accessibility text */
				_e( 'Member\'s groups', 'buddypress' );
			?></h2>
		<?php endif; ?>

		<div class="groups mygroups">

			<?php bp_get_template_part( 'groups/groups-loop' ); ?>

		</div>

		<?php

		/**
		 * Fires after the display of member groups content.
		 *
		 * @since 1.2.0
		 */
		do_action( 'bp_after_member_groups_content' );
		break;

	// Group Invitations
	case 'invites' :
		bp_get_template_part( 'members/single/groups/invites' );
		break;

	// Any other
	default :
		bp_get_template_part( 'members/single/plugins' );
		break;
endswitch;
