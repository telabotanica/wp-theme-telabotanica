<?php
/**
 * Page "Proposer une actualité"
 */

// A-t-on défini une catégorie?
$post_category = get_query_var( 'categorie', false );

acf_form_head();
get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php the_telabotanica_module('cover'); ?>

			<div class="layout-content-col">
				<div class="layout-wrapper">
					<aside class="layout-column">
						<?php the_telabotanica_module('toc'); ?>
						<?php the_telabotanica_module('button-top'); ?>
					</aside>
					<div class="layout-content">
						<?php the_telabotanica_module('breadcrumbs'); ?>
						<article class="article">
							<?php

							if ($post_category) :

								// Si l'utilisateur n'est pas connecté
								if ( ! is_user_logged_in() ) :

									the_telabotanica_module('notice', [
										'text' => __('Vous devez être connecté(e) à votre compte pour pouvoir proposer une actualité.', 'telabotanica')
									]);
									the_telabotanica_module('button', [
										'href' => wp_login_url( get_permalink() ),
										'text' => __( 'Connexion', 'telabotanica' )
									]);

								else :

									$options = array(
										/* (string) Unique identifier for the form. Defaults to 'acf-form' */
										'id' => 'acf-form',

										/* (int|string) The post ID to load data from and save data to. Defaults to the current post ID.
										Can also be set to 'new_post' to create a new post on submit */
										'post_id' => 'new_post',

										/* (array) An array of post data used to create a post. See wp_insert_post for available parameters.
										The above 'post_id' setting must contain a value of 'new_post' */
										'new_post' => [
											'post_category' => [ $post_category ]
										],

										/* (array) An array of field group IDs/keys to override the fields displayed in this form */
										// 'field_groups' => [ 'group_582b32a8aa10c', 'group_5817760bb75a4' ],

										/* (array) An array of field IDs/keys to override the fields displayed in this form */
										// 'fields' => false,

										/* (boolean) Whether or not to show the post title text field. Defaults to false */
										'post_title' => true,

										/* (boolean) Whether or not to show the post content editor field. Defaults to false */
										'post_content' => true,

										/* (boolean) Whether or not to create a form element. Useful when a adding to an existing form. Defaults to true */
										'form' => true,

										/* (array) An array or HTML attributes for the form element */
										'form_attributes' => array(),

										/* (string) The URL to be redirected to after the form is submit. Defaults to the current URL with a GET parameter '?updated=true'.
										A special placeholder '%post_url%' will be converted to post's permalink (handy if creating a new post) */
										'return' => '',

										/* (string) Extra HTML to add before the fields */
										'html_before_fields' => '',

										/* (string) Extra HTML to add after the fields */
										'html_after_fields' => '',

										/* (string) The text displayed on the submit button */
										'submit_value' => __("Envoyer", 'telabotanica'),

										/* (string) A message displayed above the form after being redirected. Can also be set to false for no message */
										'updated_message' => __("Actualité envoyée", 'telabotanica'),

										/* (string) Determines where field labels are places in relation to fields. Defaults to 'top'.
										Choices of 'top' (Above fields) or 'left' (Beside fields) */
										'label_placement' => 'top',

										/* (string) Determines where field instructions are places in relation to fields. Defaults to 'label'.
										Choices of 'label' (Below labels) or 'field' (Below fields) */
										'instruction_placement' => 'label',

										/* (string) Determines element used to wrap a field. Defaults to 'div'
										Choices of 'div', 'tr', 'td', 'ul', 'ol', 'dl' */
										'field_el' => 'div',

										/* (string) Whether to use the WP uploader or a basic input for image and file fields. Defaults to 'wp'
										Choices of 'wp' or 'basic'. Added in v5.2.4 */
										'uploader' => 'wp',

										/* (boolean) Whether to include a hidden input field to capture non human form submission. Defaults to true. Added in v5.3.4 */
										'honeypot' => true

									);

									acf_form( $options );

								endif;

							else :

								// Si la page utilise des composants
								if( have_rows('components') ):

										// On boucle sur les composants
										while ( have_rows('components') ) : the_row();

											the_telabotanica_component(get_row_layout());

										endwhile;

								endif;

								$categories = get_categories([
									'exclude' => [ 1 ],
									'hide_empty' => false,
									'orderby' => 'none',
									'parent' => 0
								] );

								ob_start();
								echo '<ul>';
									foreach ($categories as $category):
										echo '<li>';
											echo $category->description;
											$subcategories = get_term_children( $category->term_id, 'category' );
											if ($subcategories) :
											echo '<ul>';
												foreach ($subcategories as $subcategory_id):
													$subcategory = get_term_by( 'id', $subcategory_id, 'category' );
													echo '<li>';
														printf(
															'<a href="%s">%s</a>%s',
															esc_url( '?categorie=' . $subcategory->slug ),
															$subcategory->name,
															$subcategory->description ? ' – ' . $subcategory->description : ''
														);
													echo '</li>';
												endforeach;
											echo '</ul>';
											endif;
										echo '</li>';
									endforeach;
								echo '</ul>';
								$list_categories_html = ob_get_clean();

								the_telabotanica_component('text', ['text' => $list_categories_html]);

							endif;

							?>
						</article>
					</div>
				</div>
			</div>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php
acf_enqueue_uploader();
get_footer();
