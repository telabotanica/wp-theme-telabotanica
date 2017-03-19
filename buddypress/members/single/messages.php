<?php
/**
 * BuddyPress - Users Messages
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

if ( bp_is_messages_inbox() || bp_is_messages_sentbox() ) :

	echo '<div style="float: right">';
	bp_message_search_form();
	echo '</div>';

endif;

the_telabotanica_module('header-dashboard', [
	'title' => __('Mes messages', 'telabotanica')
]);

$nav_tabs_items = array_map(function($item){
	if ($item->parent !== 'messages') return;

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

?>
<div id="buddypress">

<?php
switch ( bp_current_action() ) :

	// Inbox/Sentbox
	case 'inbox'   :
	case 'sentbox' :

		/**
		 * Fires before the member messages content for inbox and sentbox.
		 *
		 * @since 1.2.0
		 */
		do_action( 'bp_before_member_messages_content' ); ?>

		<?php if ( bp_is_messages_inbox() ) : ?>
			<h2 class="bp-screen-reader-text"><?php
				/* translators: accessibility text */
				_e( 'Messages inbox', 'buddypress' );
			?></h2>
		<?php elseif ( bp_is_messages_sentbox() ) : ?>
			<h2 class="bp-screen-reader-text"><?php
				/* translators: accessibility text */
				_e( 'Sent Messages', 'buddypress' );
			?></h2>
		<?php endif; ?>

		<div class="messages">
			<?php bp_get_template_part( 'members/single/messages/messages-loop' ); ?>
		</div><!-- .messages -->

		<?php

		/**
		 * Fires after the member messages content for inbox and sentbox.
		 *
		 * @since 1.2.0
		 */
		do_action( 'bp_after_member_messages_content' );
		break;

	// Single Message View
	case 'view' :
		bp_get_template_part( 'members/single/messages/single' );
		break;

	// Compose
	case 'compose' :
		bp_get_template_part( 'members/single/messages/compose' );
		break;

	// Sitewide Notices
	case 'notices' :

		/**
		 * Fires before the member messages content for notices.
		 *
		 * @since 1.2.0
		 */
		do_action( 'bp_before_member_messages_content' ); ?>

		<h2 class="bp-screen-reader-text"><?php
			/* translators: accessibility text */
			_e( 'Sitewide Notices', 'buddypress' );
		?></h2>

		<div class="messages">
			<?php bp_get_template_part( 'members/single/messages/notices-loop' ); ?>
		</div><!-- .messages -->

		<?php

		/**
		 * Fires after the member messages content for inbox and sentbox.
		 *
		 * @since 1.2.0
		 */
		do_action( 'bp_after_member_messages_content' );
		break;

	// Any other
	default :
		bp_get_template_part( 'members/single/plugins' );
		break;
endswitch;
?>
</div>
