<?php
/**
 * BuddyPress - Members Single Messages Compose
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>
<?php if(isset( $_GET['r'] )) : // is this page loaded after recipient(s) has (have) been chosen ? ?>
<h2 class="bp-screen-reader-text"><?php
	/* translators: accessibility text */
	_e( 'Compose Message', 'buddypress' );
?></h2>

	<form action="<?php bp_messages_form_action('compose' ); ?>" method="post" id="send_message_form" class="standard-form" enctype="multipart/form-data">

		<?php

		/**
		 * Fires before the display of message compose content.
		 *
		 * @since 1.1.0
		 */
		do_action( 'bp_before_messages_compose_content' ); ?>

		<label for="send-to-input"><?php _e("Send To (Username or Friend's Name)", 'buddypress' ); ?></label>
		<ul class="first acfb-holder">
			<li>
				<?php bp_message_get_recipient_tabs(); ?>
				<!-- <input type="text" name="send-to-input" class="send-to-input" id="send-to-input" /> -->
			</li>
		</ul>

		<?php if ( bp_current_user_can( 'bp_moderate' ) ) : ?>
			<p><label for="send-notice"><input type="checkbox" id="send-notice" name="send-notice" value="1" /> <?php _e( "This is a notice to all users.", 'buddypress' ); ?></label></p>
		<?php endif; ?>

		<label for="subject"><?php _e( 'Subject', 'buddypress' ); ?></label>
		<input type="text" name="subject" id="subject" value="<?php bp_messages_subject_value(); ?>" />

		<label for="message_content"><?php _e( 'Message', 'buddypress' ); ?></label>
		<textarea name="content" id="message_content" rows="15" cols="40"><?php bp_messages_content_value(); ?></textarea>

		<input type="hidden" name="send_to_usernames" id="send-to-usernames" value="<?php bp_message_get_recipient_usernames(); ?>" class="<?php bp_message_get_recipient_usernames(); ?>" />

		<?php

		/**
		 * Fires after the display of message compose content.
		 *
		 * @since 1.1.0
		 */
		do_action( 'bp_after_messages_compose_content' ); ?>

		<div class="submit">
			<input type="submit" value="<?php esc_attr_e( "Send Message", 'buddypress' ); ?>" name="send" id="send" />
		</div>

		<?php wp_nonce_field( 'messages_send_message' ); ?>
	</form>
	<script type="text/javascript">
		document.getElementById("send-to-input").focus();
	</script>
<?php
else : // user needs to choose recipient from members search page
	echo '</div>'; // closing div with id buddypress to allow button module style
	echo '<div>';
		the_telabotanica_module('notice', [
			'type' => 'info',
			'text' => __( "Rendez-vous sur l'annuaire des telabotanistes pour choisir les destinataires et envoyer votre message", 'telabotanica' )
		]);
		echo '<p style="text-align: center">';
		the_telabotanica_module('button', [
			'href' => get_permalink( get_option('bp-pages')['members'] ),
			'text' => __( 'Annuaire', 'telabotanica' )
	    ]);
		echo '</p>';
	echo '</div>';
endif;
?>

