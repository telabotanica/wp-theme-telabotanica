<?php
/**
 * Tela Botanica - Users Documents Template
 *
 * copied from "plugins" template; displays the "documents" sub-page for the
 * members component
 */

/**
 * Fires at the start of the member documents template.
 *
 * @since 1.2.0
 */
do_action('bp_before_member_documents_template');

the_telabotanica_module('header-dashboard', [
	'title' => __('Mes documents', 'telabotanica')
]);

the_telabotanica_module('notice', [
	'type'  => 'info',
	'title' => __('Bientôt disponible.', 'telabotanica'),
	'text'  => __('Vous retrouverez prochainement ici tous les documents que vous avez publiés.', 'telabotanica')
]);

if (!bp_is_current_component_core()) : ?>

<div class="item-list-tabs no-ajax" id="subnav" aria-label="<?php esc_attr_e('Member secondary navigation', 'buddypress'); ?>" role="navigation">
	<ul>
		<?php bp_get_options_nav(); ?>

		<?php

		/**
		 * Fires inside the member documents template nav <ul> tag.
		 *
		 * @since 1.2.2
		 */
		do_action('bp_member_documents_options_nav'); ?>
	</ul>
</div><!-- .item-list-tabs -->

<?php endif; ?>

<?php if (has_action('bp_template_title')) : ?>
	<h3><?php

	/**
	 * Fires inside the member plugin template <h3> tag.
	 *
	 * @since 1.0.0
	 */
	do_action('bp_template_title'); ?></h3>

<?php endif; ?>

<?php

/**
 * Fires and displays the member plugin template content.
 *
 * @since 1.0.0
 */
do_action('bp_template_content'); ?>

<?php

/**
 * Fires at the end of the member documents template.
 *
 * @since 1.2.0
 */
do_action('bp_after_member_documents_template'); ?>
