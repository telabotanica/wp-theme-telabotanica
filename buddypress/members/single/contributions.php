<?php
/**
 * Tela Botanica - Users Contributions Template
 *
 * copied from "plugins" template; displays the "contributions" sub-page for the
 * members component
 *
 * @package telabotanica
 */

/**
 * Fires at the start of the member contributions template.
 *
 * @since 1.2.0
 */
do_action( 'bp_before_member_contributions_template' );

the_telabotanica_module('header-dashboard', [
	'title' => __('Mes contributions', 'telabotanica')
]);

the_telabotanica_module('notice', [
	'type' => 'info',
	'title' => __('Bientôt disponible.', 'telabotanica'),
	'text' => __('Vous retrouverez prochainement ici la liste complète de vos contributions.<br />Pour le moment, seules les plus récentes sont affichées.', 'telabotanica')
]);

the_telabotanica_module('feed', [
	'title' => [
		'title' => "Mon flux d'activité",
		'level' => 2
	],
	'items' => [
		[
			'type' => 'feed-date',
			'text' => 'Hier'
		],
		[
			'type' => 'feed-item',
			'href' => '#',
			'image' => 'https://api.tela-botanica.org/img:001125636CRXS.jpg',
			'title' => 'Allium vineale ??',
			'text' => 'Nouvelle observation ajoutée au Carnet en Ligne',
			'meta' => [
				'place' => 'Saturargues (34)'
			]
		],
		[
			'type' => 'feed-item',
			'href' => '#',
			'images' => [
				'https://api.tela-botanica.org/img:001129797CRXS.jpg',
				'https://api.tela-botanica.org/img:001129789CRXS.jpg',
				'https://api.tela-botanica.org/img:001129777CRXS.jpg',
				'https://api.tela-botanica.org/img:001129768CRXS.jpg',
				'https://api.tela-botanica.org/img:001129757CRXS.jpg',
				'https://api.tela-botanica.org/img:001129710CRXS.jpg',
				'https://api.tela-botanica.org/img:001129705CRXS.jpg',
				'https://api.tela-botanica.org/img:001129701CRXS.jpg'
			],
			'title' => '11 photos ajoutées',
			'text' => 'Au Carnet en Ligne',
			'meta' => [
				'text' => 'Fontainebleau-01.jpg, Fontainebleau-02.jpg, Fontaine....'
			]
		],
		[
			'type' => 'feed-item',
			'article' => true,
			'href' => '#',
			'image' => 'https://api.tela-botanica.org/img:001129701CRXS.jpg',
			'title' => 'Chloris',
			'text' => "Quand l'art et la botanique se mêlent en un ouvrage, un magnifique volume...",
			'meta' => [
				'categories' => 'En kiosque'
			]
		],
		[
			'type' => 'feed-date',
			'text' => 'Il y a deux jours'
		],
		[
			'type' => 'feed-item',
			'href' => '#',
			'image' => 'https://api.tela-botanica.org/img:001125593CRXS.jpg',
			'title' => 'Acer campestre ?',
			'text' => 'Nouvelle observation ajoutée au Carnet en Ligne',
			'meta' => [
				'place' => 'Durtol (63)'
			]
		],
		[
			'type' => 'feed-item',
			'text' => 'Vous avez rejoint le projet <a href="#">Sauvages de ma rue</a> !'
		]
	]
]);

if ( ! bp_is_current_component_core() ) : ?>

<div class="item-list-tabs no-ajax" id="subnav" aria-label="<?php esc_attr_e( 'Member secondary navigation', 'buddypress' ); ?>" role="navigation">
	<ul>
		<?php bp_get_options_nav(); ?>

		<?php

		/**
		 * Fires inside the member documents template nav <ul> tag.
		 *
		 * @since 1.2.2
		 */
		do_action( 'bp_member_documents_options_nav' ); ?>
	</ul>
</div><!-- .item-list-tabs -->

<?php endif; ?>

<?php if ( has_action( 'bp_template_title' ) ) : ?>
	<h3><?php

	/**
	 * Fires inside the member plugin template <h3> tag.
	 *
	 * @since 1.0.0
	 */
	do_action( 'bp_template_title' ); ?></h3>

<?php endif; ?>

<?php

/**
 * Fires and displays the member plugin template content.
 *
 * @since 1.0.0
 */
do_action( 'bp_template_content' ); ?>

<?php

/**
 * Fires at the end of the member documents template.
 *
 * @since 1.2.0
 */
do_action( 'bp_after_member_documents_template' ); ?>
