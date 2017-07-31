<?php
/**
 * BuddyPress - Group awaiting moderation
 *
 * Adds compatibility with plugin "bp-moderate-group-creation"
 * https://github.com/telabotanica/bp-moderate-group-creation
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */


if ( bp_has_groups() ) : while ( bp_groups() ) : bp_the_group();

/**
 * Fires before the display of the group home content.
 *
 * @since 1.2.0
 */
do_action( 'bp_before_group_home_content' );

the_telabotanica_module('cover-project', []);
?>

<div class="layout-central-col">
	<div class="layout-wrapper">
		<div class="layout-content" id="buddypress">

			<div id="item-body">
			<?php
			$notice_text = __('Ce projet est en attente de modération.', 'telabotanica');

			// Si l'utilisateur en cours est le créateur du groupe, on
			// affiche un message plus élaboré
			$group_id = bp_get_current_group_id();
			$group = groups_get_group(array('group_id' => $group_id));

			if (get_current_user_id() == $group->creator_id):
				$notice_text .= ' ' . __("Vous recevrez une notification dès qu'il sera accepté", 'telabotanica');
			endif;

			the_telabotanica_module('notice', [
				'type' => 'info',
				'text' => $notice_text
			]);
			?>
			</div><!-- #item-body -->

			<?php

			/**
			 * Fires after the display of the group home content.
			 *
			 * @since 1.2.0
			 */
			do_action( 'bp_after_group_home_content' ); ?>

			<?php endwhile; endif; ?>

		</div><!-- #buddypress -->
	</div>
</div>
