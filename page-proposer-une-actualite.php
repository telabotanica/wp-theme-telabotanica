<?php
/**
 * Page "Proposer une actualité"
 */

// Force a small header (without use cases navigation)
$header_small = true;

// A-t-on défini une catégorie?
$post_category_slug = get_query_var('categorie', false);
$post_category = get_category_by_slug($post_category_slug);
$confirmation = get_query_var('confirmation', false);

// 404 si la catégorie passée en paramètre n'existe pas
if ($post_category_slug && !$post_category) {
    global $wp_query;
    $wp_query->set_404();
    status_header(404);
    get_template_part(404);
    exit();
}

// Sanitize values
function my_kses_post($value)
{
    if (is_array($value)) {
        return array_map('my_kses_post', $value);
    }

    return wp_kses_post($value);
}
add_filter('acf/update_value', 'my_kses_post', 10, 1);

acf_form_head();
get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php the_telabotanica_module('cover'); ?>

			<div class="layout-central-col">
				<div class="layout-wrapper">
					<div class="layout-content">
						<?php

						if ($confirmation) :

							the_telabotanica_module('notice', [
								'type'  => 'confirm',
								'title' => __('Félicitations, votre article a bien été enregistré.', 'telabotanica'),
								'text'  => __("Un membre de l'équipe Tela Botanica en a été informé et mettra votre article en ligne d'ici quelques jours.", 'telabotanica')
							]);

							echo '<p style="text-align: center">';
								the_telabotanica_module('button', [
									'href' => get_category_link(get_category_by_slug('actualites')),
									'text' => __('Retour aux actualités', 'telabotanica')
								]);
							echo '</p>';

						else :

							if ($post_category_slug) :

								$breadcrumbs_items = [
									'home',
									[
										'text' => __('Proposer une actualité', 'telabotanica'),
										'href' => get_permalink(get_page_by_path('proposer-une-actualite'))
									],
									[
										'text' => $post_category->name
									]
								];

								the_telabotanica_module('breadcrumbs', [
									'items' => $breadcrumbs_items
								]);

								echo '<article class="article">';

								// Si l'utilisateur n'est pas connecté
								if (!is_user_logged_in()) :

									the_telabotanica_module('warning', [
										'text' => __('Vous devez être connecté(e) à votre compte pour pouvoir proposer une actualité.', 'telabotanica')
									]);
									echo '<p style="text-align: center">';
										the_telabotanica_module('button', [
											'href' => wp_login_url(get_permalink()),
											'text' => __('Connexion', 'telabotanica')
										]);
									echo '</p>';

								else :

									$options = [
										/* (string) Unique identifier for the form. Defaults to 'acf-form' */
										'id' => 'suggest-news-form',

										/* (int|string) The post ID to load data from and save data to. Defaults to the current post ID.
										Can also be set to 'new_post' to create a new post on submit */
										'post_id' => 'new_post',

										/* (array) An array of post data used to create a post. See wp_insert_post for available parameters.
										The above 'post_id' setting must contain a value of 'new_post' */
										'new_post' => [
											'post_category' => [$post_category->cat_ID],
											'post_status'   => 'draft'
										],

										/* (array) An array of field group IDs/keys to override the fields displayed in this form */
										// 'field_groups' => [ ],

										/* (array) An array of field IDs/keys to override the fields displayed in this form */
										// 'fields' => false,

										/* (boolean) Whether or not to show the post title text field. Defaults to false */
										'post_title' => true,

										/* (boolean) Whether or not to show the post content editor field. Defaults to false */
										'post_content' => true,

										/* (boolean) Whether or not to create a form element. Useful when a adding to an existing form. Defaults to true */
										'form' => true,

										/* (array) An array or HTML attributes for the form element */
										'form_attributes' => ['class' => 'acf-form suggest-news-form'],

										/* (string) The URL to be redirected to after the form is submit. Defaults to the current URL with a GET parameter '?updated=true'.
										A special placeholder '%post_url%' will be converted to post's permalink (handy if creating a new post) */
										'return' => get_permalink(get_page_by_path('proposer-une-actualite')) . '?confirmation=true',

										/* (string) Extra HTML to add before the fields */
										'html_before_fields' => '',

										/* (string) Extra HTML to add after the fields */
										'html_after_fields' => '',

										/* (string) The text displayed on the submit button */
										'submit_value' => __('Envoyer', 'telabotanica'),

										/* (string) A message displayed above the form after being redirected. Can also be set to false for no message */
										'updated_message' => false,

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

									];

									switch ($post_category_slug) {

										case 'en-kiosque':
											// $options['post_content'] = false;
											$options['field_groups'] = [
												'group_582b32a8aa10c', // Intro d'article
												'group_58034e80e09e5' // Article – En kiosque
											];
											break;

										case 'congres-conferences':
										case 'expositions':
										case 'sorties-de-terrain':
										case 'stages-et-ateliers':
											$options['post_content'] = false;
											$options['field_groups'] = [
												'group_5803515c20ffc' // Article - Évènement
											];
											break;

										case 'cdd-cdi':
										case 'stages':
										case 'service-civique':
											$options['post_content'] = false;
											$options['field_groups'] = [
												'group_58034a4d87ab4' // Article - Offre d'emploi
											];
											break;

										default:
											$options['field_groups'] = [
												'group_582b32a8aa10c' // Intro d'article
											];
											break;

									}

									acf_form($options);

								endif;

								echo '</article>';

							else :

								the_telabotanica_module('breadcrumbs');

								echo '<article class="article">';

								// Si la page utilise des composants
								if (have_rows('components')):

										// On boucle sur les composants
										while (have_rows('components')) : the_row();

											the_telabotanica_component(get_row_layout());

										endwhile;

								endif;

								$categories = get_categories([
									'exclude'    => [1],
									'hide_empty' => false,
									'orderby'    => 'none',
									'parent'     => 0
								]);

								ob_start();
								echo '<ul>';
									foreach ($categories as $category):
										echo '<li>';
											echo $category->description;
											$subcategories = get_term_children($category->term_id, 'category');
											if ($subcategories) :
											echo '<ul>';
												foreach ($subcategories as $subcategory_id):
													$subcategory = get_term_by('id', $subcategory_id, 'category');
													echo '<li>';
														printf(
															'<a href="%s">%s</a>%s',
															esc_url('?categorie=' . $subcategory->slug),
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

								echo '</article>';

							endif;

						endif;

						?>
					</div>
				</div>
			</div>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php
acf_enqueue_uploader();
get_footer();
