<?php function telabotanica_module_comments($data)
{
    $defaults = [
		'modifiers' => []
	];

    $data = telabotanica_styleguide_data($defaults, $data);
    $data->modifiers = telabotanica_styleguide_modifiers_array('comments', $data->modifiers);

    printf(
		'<div class="%s">',
		implode(' ', $data->modifiers)
	);

    if (have_comments()) : ?>
			<h2 class="comments-title">
				<?php
					the_telabotanica_module('icon', ['icon' => 'discussion', 'color' => 'vert-clair']);
    $comments_number = get_comments_number();
    if ('1' === $comments_number) {
        __('Un commentaire', 'telabotanica');
    } else {
        printf(
							_n(
								'%1$s commentaire',
								'%1$s commentaires',
								$comments_number,
								'telabotanica'
							),
							number_format_i18n($comments_number)
						);
    } ?>
			</h2>

			<ol class="comments-items">
				<?php
					wp_list_comments([
						'avatar_size' => 100,
						'style'       => 'ol',
						'short_ping'  => true,
						'reply_text'  => __('Répondre à ce commentaire', 'telabotanica'),
					]); ?>
			</ol>

			<?php the_comments_pagination([
				'prev_text' => '<span class="screen-reader-text">' . __('Précédent', 'telabotanica') . '</span>',
				'next_text' => '<span class="screen-reader-text">' . __('Suivant', 'telabotanica') . '</span>',
			]);

    endif; // Check for have_comments().

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>

			<p class="no-comments"><?php _e('Les commentaires sont fermés.', 'telabotanica'); ?></p>
		<?php
		endif;

    echo '</div>';
}
