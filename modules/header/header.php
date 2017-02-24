<?php function telabotanica_module_header($data) {
	// $header_small can be set be true before calling get_header()
	// in a template file to force a small header (without use cases navigation)
	global $header_small;

	$defaults = [
		'image' => get_field('cover_image'),
		'title' => get_the_title(),
		'subtitle' => get_field('cover_subtitle'),
		'content' => false,
		'search' => false,
		'modifiers' => []
	];

	$data = telabotanica_styleguide_data($defaults, $data);
	$data->modifiers = telabotanica_styleguide_modifiers_array('header', $data->modifiers);
	if ( $header_small === true ) $data->modifiers[] = 'is-small';

	printf(
		'<header class="%s" role="banner">',
		implode(' ', $data->modifiers)
	);

		echo '<div class="header-fixed">';

			$logo_element = ( is_front_page() && is_home() ) ? 'h1' : 'div';

			printf(
				'<%s class="header-logo"><a href="%s" rel="home">%s</a></%s>',
				$logo_element,
				esc_url( home_url( '/' ) ),
				sprintf(
					'<img src="%s" alt="Tela Botanica" />',
					get_template_directory_uri() . '/modules/header/logo.svg'
				),
				$logo_element
			);

			if ( has_nav_menu('secondary') ) :

				printf(
					'<nav class="header-nav" role="navigation" aria-label="%s">',
					esc_attr__( 'Menu secondaire', 'telabotanica' )
				);
					wp_nav_menu( [
						'theme_location'	=> 'secondary',
						'menu_class'			=> 'header-nav-items',
						'depth'						=> 1,
					 ] );
				echo '</nav>';

			endif;

			echo '<ul class="header-links">';

			if ( is_user_logged_in() ) :
				$current_user = wp_get_current_user();
				$avatar_url = get_avatar_url($current_user->ID, [ 'size' => 22 ]); ?>
				<li class="header-links-item header-links-item-user">
					<a href="<?php echo admin_url(); ?>">
						<span class="header-links-item-text">
							<?php echo $current_user->display_name; ?>
							<span class="header-links-item-user-avatar" style="background-image: url(<?php echo $avatar_url ?>);"></span>
						</span>
					</a>
				</li>
			<?php else : ?>
				<li class="header-links-item header-links-item-login"><a href="<?php echo wp_login_url( get_permalink() ); ?>"><span class="header-links-item-text"><?php _e( 'Connexion', 'telabotanica' ) ?></span></a></li>
			<?php endif; ?>
			<li class="header-links-item">
				<?php
				if (function_exists('icl_get_languages')) :
					try {
						foreach (icl_get_languages() as $locale) {
							if ($locale['active'] === '1') {continue;}
							echo '<a href="' . $locale['url'] . '" rel="alternate" hreflang="' . $locale['code'] . '" title="' . $locale['native_name'] . '"><span class="header-links-item-text">' . strtoupper($locale['code']) . '</span></a>';
						}
					} catch (Exception $e) {
						echo $e->getMessage();
					}
				endif; ?>
			</li>
			<li class="header-links-item header-links-item-donate"><a href="#"><?php _e( 'Faites un don !', 'telabotanica' ) ?></a></li>
			<li class="header-links-item header-links-item-search"><a href="<?php echo get_search_link(); ?>"><span class="header-links-item-text"><?php the_telabotanica_module('icon', ['icon' => 'search']) ?></span></a></li>
		<?php
		echo '</ul>';
	echo '</div>';

	if ( has_nav_menu('principal') && $header_small !== true ) :

		printf(
			'<nav class="header-nav-usecases" role="navigation" aria-label="%s">',
			esc_attr__( 'Menu principal', 'telabotanica' )
		);
			wp_nav_menu( [
				'theme_location'	=> 'principal',
				'menu_class'			=> 'header-nav-usecases-items',
				'depth'						=> 1,
			] );
		echo '</nav>';

	endif;

	echo '</header>';
}
