<?php
/**
 * BuddyPress - Groups.
 */

/**
 * Fires at the top of the groups directory template file.
 *
 * @since 1.5.0
 */
do_action('bp_before_directory_groups_page');

$projects_page = get_page_by_path('projets');
the_telabotanica_module('cover', [
    // toujours utiliser l'image de cover de la page Projets
    'image'    => get_field('cover_image', $projects_page),
    'title'    => get_the_title($projects_page),
    'subtitle' => get_field('cover_subtitle', $projects_page),
    'search'   => [
        'index'       => 'projets',
        'placeholder' => __('Rechercher un projet...', 'telabotanica'),
    ],
]);

        /*
         * Fires before the display of the groups.
         *
         * @since 1.1.0
         */
        do_action('bp_before_directory_groups'); ?>

<?php //bp_get_template_part( 'common/search/dir-search-form' );?>

<form action="" method="post" id="groups-directory-form" class="dir-form">
	<div class="layout-content-col full-width reversed-colors">
		<div class="layout-wrapper">
			<aside class="layout-column">
				<?php
                /**
                 * Fires before the display of the groups content.
                 *
                 * @since 1.1.0
                 */
                do_action('bp_before_directory_groups_content');

                $project_categories = bp_groups_get_group_types([], 'objects');

                $categories_items = [
                    [
                        'text' => __('Tous les projets', 'telabotanica'),
                        // 'number' => bp_get_total_group_count(),
                        'href'  => bp_get_groups_directory_permalink(),
                        'items' => array_map(function ($category) {
                            return [
                                'text'   => $category->labels['name'],
                                'href'   => bp_get_group_type_directory_permalink($category->directory_slug),
                                'title'  => $category->description,
                                'active' => bp_get_current_group_directory_type() === $category->name,
                            ];
                        }, $project_categories),
                    ],
                ];

                if (is_user_logged_in() && bp_get_total_group_count_for_user(bp_loggedin_user_id())) :
                    $categories_items[] = [
                        'text'   => __('Mes projets', 'telabotanica'),
                        'number' => bp_get_total_group_count_for_user(bp_loggedin_user_id()),
                        'href'   => trailingslashit(bp_loggedin_user_domain().bp_get_groups_slug().'/my-groups'),
                    ];
                endif;

                $help_project_page = get_page_by_path('projets/aide');
                if ($help_project_page) :
                    $categories_items[] = [
                        'text' => get_the_title($help_project_page),
                        'href' => get_permalink($help_project_page),
                    ];
                endif;

                the_telabotanica_module('categories', [
                    'modifiers' => 'layout-column-item',
                    'items'     => $categories_items,
                ]);

                echo '<div class="layout-column-item">';
                $create_project_page = get_page_by_path('projets/creer-un-projet');
                if ($create_project_page) :
                    the_telabotanica_module('button', [
                        'text'      => get_the_title($create_project_page),
                        'href'      => get_permalink($create_project_page),
                        'modifiers' => 'block',
                    ]);
                endif;
                echo '</div>';

                the_telabotanica_module('button-top');

                /*
                 * Fires inside the groups directory group types.
                 *
                 * @since 1.2.0
                 */
                do_action('bp_groups_directory_group_types');
                ?>

			</aside>
			<div class="layout-content">
				<?php

                $breadcrumbs_items = ['home'];

                if (bp_get_current_group_directory_type()) {
                    $current_type = bp_groups_get_group_type_object(bp_get_current_group_directory_type());
                    $breadcrumbs_items[] = ['href' => get_permalink(get_page_by_path('projets')), 'text' => get_the_title()];
                    $breadcrumbs_items[] = ['text' => $current_type->labels['name']];
                } else {
                    $breadcrumbs_items[] = ['text' => get_the_title()];
                }

                the_telabotanica_module('breadcrumbs', [
                    'modifiers' => 'no-border',
                    'items'     => $breadcrumbs_items,
                ]); ?>

				<div id="template-notices" role="alert" aria-atomic="true">
								<?php
                                /** This action is documented in bp-templates/bp-legacy/buddypress/activity/index.php */
                                do_action('template_notices');
                    ?>
						</div>

							<?php bp_get_template_part('groups/groups-loop'); ?>

					<?php
                    /**
                     * Fires and displays the group content.
                     *
                     * @since 1.1.0
                     */
                    do_action('bp_directory_groups_content');

                    wp_nonce_field('directory_groups', '_wpnonce-groups-filter');

                    /*
                     * Fires after the display of the groups content.
                     *
                     * @since 1.1.0
                     */
                    do_action('bp_after_directory_groups_content'); ?>

			</div>
		</div>
	</div>
</form><!-- #groups-directory-form -->
		<?php

        /**
         * Fires after the display of the groups.
         *
         * @since 1.1.0
         */
        do_action('bp_after_directory_groups');

/*
 * Fires at the bottom of the groups directory template file.
 *
 * @since 1.5.0
 */
do_action('bp_after_directory_groups_page');
