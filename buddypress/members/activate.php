<?php
/**
 * BuddyPress - Members Activate.
 */
?>

<div id="buddypress">

	<?php the_telabotanica_module('cover'); ?>

	<div class="layout-full-width">
		<div class="layout-wrapper">

	<?php

    /**
     * Fires before the display of the member activation page.
     *
     * @since 1.1.0
     */
    do_action('bp_before_activation_page'); ?>

	<div class="page" id="activate-page">

		<div id="template-notices" class="notice-registration" role="alert" aria-atomic="true">
			<?php

            /** This action is documented in bp-templates/bp-legacy/buddypress/activity/index.php */
            do_action('template_notices'); ?>

		</div>

		<?php

        /**
         * Fires before the display of the member activation page content.
         *
         * @since 1.1.0
         */
        do_action('bp_before_activate_content'); ?>

		<?php if (bp_account_was_activated()) : ?>

			<?php if (isset($_GET['e'])) : ?>
				<p><?php _e('Your account was activated successfully! Your account details have been sent to you in a separate email.', 'buddypress'); ?></p>
			<?php else : ?>
				<p><?php printf(__('Votre compte est validé ! Vous pouvez maintenant <a href="%s">vous connecter</a> avec les identifiant et mot de passe que vous avez renseignés  à l\'inscription. N\'oubliez pas de compléter les informations de votre profil !', 'telabotanica'), wp_login_url(bp_get_root_domain())); ?></p>
			<?php endif; ?>

		<?php else : ?>

			<div class="notice notice-info">
				<?php _e("Si vous vous trouvez ici, c'est probablement que votre compte a déjà été activé", 'telabotanica'); ?>.
				<br>
				<?php printf(__('<strong><a href="%s">Cliquez ici</a></strong> pour vous identifier', 'telabotanica'), wp_login_url(home_url())) ?>.
			</div>

			<p><?php _e('Please provide a valid activation key.', 'buddypress'); ?></p>

			<form action="" method="get" class="standard-form" id="activation-form">

				<label for="key"><?php _e('Activation Key:', 'buddypress'); ?></label>
				<input type="text" name="key" id="key" value="" />

				<p class="submit">
					<input type="submit" name="submit" value="<?php esc_attr_e('Activate', 'buddypress'); ?>" />
				</p>

			</form>

		<?php endif; ?>

		<?php

        /**
         * Fires after the display of the member activation page content.
         *
         * @since 1.1.0
         */
        do_action('bp_after_activate_content'); ?>

	</div><!-- .page -->

	<?php

    /**
     * Fires after the display of the member activation page.
     *
     * @since 1.1.0
     */
    do_action('bp_after_activation_page'); ?>

		</div>
	</div>

</div><!-- #buddypress -->
