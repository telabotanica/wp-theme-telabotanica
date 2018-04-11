<?php
/**
 * Page
 */
get_header(); ?>

  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

      <?php if (have_posts()) : ?>
        <div class="layout-central-col">
          <div class="layout-wrapper">
            <?php while (have_posts()) : the_post(); ?>
              <div class="layout-content">
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                  <header class="entry-header">
                    <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                  </header><!-- .entry-header -->

                  <div class="entry-content">
                    <?php
                    the_content();

                    wp_link_pages([
                      'before'      => '<div class="page-links"><span class="page-links-title">' . __('Pages:', 'twentysixteen') . '</span>',
                      'after'       => '</div>',
                      'link_before' => '<span>',
                      'link_after'  => '</span>',
                      'pagelink'    => '<span class="screen-reader-text">' . __('Page', 'twentysixteen') . ' </span>%',
                      'separator'   => '<span class="screen-reader-text">, </span>',
                    ]);
                    ?>
                  </div><!-- .entry-content -->

                  <?php
                    edit_post_link(
                      sprintf(
                        /* translators: %s: Name of current post */
                        __('Edit<span class="screen-reader-text"> "%s"</span>', 'twentysixteen'),
                        get_the_title()
                      ),
                      '<footer class="entry-footer"><span class="edit-link">',
                      '</span></footer><!-- .entry-footer -->'
                    );
                  ?>

                </article><!-- #post-## -->
              </div>

              <?php
              // If comments are open or we have at least one comment, load up the comment template.
              if (comments_open() || get_comments_number()) {
                  comments_template();
              }

              // End of the loop.
            endwhile; ?>
          </div>
        </div>
      <?php endif; ?>

    </main><!-- .site-main -->
  </div><!-- .content-area -->

<?php get_footer(); ?>
