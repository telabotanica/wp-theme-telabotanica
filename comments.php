<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since 1.0
 *
 * @version 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">

	<div class="layout-central-col">
		<div class="layout-wrapper">
			<div class="layout-content">
				<?php
                the_telabotanica_module('comments');
                ?>
			</div>
		</div>
	</div>

	<div class="layout-central-col background-beige">
		<div class="layout-wrapper">
			<div class="layout-content">
				<?php
                the_telabotanica_module('comment-form');
                ?>
			</div>
		</div>
	</div>

</div><!-- #comments -->
