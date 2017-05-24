<?php function telabotanica_module_categories($data)
{
    $defaults = [
        'items'     => [],
        'modifiers' => [],
    ];

    $data = telabotanica_styleguide_data($defaults, $data);
    $data->modifiers = telabotanica_styleguide_modifiers_array('categories', $data->modifiers);

    // Fonction permettant d'afficher les catégories par défaut,
    // en se basant sur les catégories créées dans Wordpress
    if (!function_exists('telabotanica_module_categories_default')) :
        function telabotanica_module_categories_default()
        {
            $category_active = get_query_var('cat');
            $categories = get_categories([
                'exclude'    => [1],
                'hide_empty' => false,
                'orderby'    => 'none',
                'parent'     => 0,
            ]);
            $icons = [
                'actualites'    => 'news',
                'news'          => 'news',
                'evenements'    => 'calendar',
                'events'        => 'calendar',
                'offres-emploi' => 'laptop',
                'job-offers'    => 'laptop',
            ];

            foreach ($categories as $category):
                $icon = @$icons[$category->slug];
            $is_active = $category->term_id === $category_active; ?>
					<li class="categories-item<?php echo $is_active ? ' is-active' : '' ?>">
						<h3 class="categories-item-title"><a href="<?php echo esc_url(get_term_link($category)) ?>" class="categories-item-link">
							<?php if ($icon) {
                the_telabotanica_module('icon', ['icon' => $icon]);
            } ?>
							<?php echo $category->name; ?>
						</a></h3>
						<?php $subitems = get_term_children($category->term_id, 'category');
            if ($subitems): ?>
						<ul class="categories-subitems">
							<?php foreach ($subitems as $subitem_id):
                                $subitem_is_active = (int) $subitem_id === $category_active;
            $subitem = get_term_by('id', $subitem_id, 'category'); ?>
								<li class="categories-subitem<?php echo $subitem_is_active ? ' is-active' : '' ?>">
									<a href="<?php echo esc_url(get_term_link($subitem)) ?>" class="categories-subitem-link"><?php echo $subitem->name; ?></a>
								</li>
							<?php endforeach;
            echo '</ul>';
            endif;
            echo '</li>';
            endforeach;
        }
    endif;

    echo '<div class="'.implode(' ', $data->modifiers).'">';

    the_telabotanica_module('title', [
        'title'     => __('Catégories', 'telabotanica'),
        'level'     => 2,
        'modifiers' => ['categories-title', 'with-border-bottom'],
    ]);

    echo '<ul class="categories-items">';

    if (!empty($data->items)) :

        foreach ($data->items as $item) :
            $item = (object) $item;

    echo '<li class="categories-item'.(isset($item->active) && $item->active ? ' is-active' : '').'">';

    if (isset($item->text)) {
        printf(
                        '<h3 class="categories-item-title"><a href="%s" class="categories-item-link" title="%s">%s%s</a></h3>',
                        esc_url($item->href),
                        isset($item->title) ? $item->title : '',
                        $item->text,
                        isset($item->number) ? ' ('.$item->number.')' : ''
                    );
    }

    if (isset($item->items)) :

                    echo '<ul class="categories-subitems">';

    foreach ($item->items as $subitem) :
                        $subitem = (object) $subitem;

                        // // Tableau d'objets Taxonomies
                        // if (gettype($subitem) === 'object' && get_class($subitem) === 'WP_Term') :
                        //
                        //	 $subitem->text = $subitem->name;
                        //	 $subitem->href = '#' . $subitem->slug;
                        //
                        // // Tableau simple
                        // elseif (gettype($subitem) === 'array') :

                            $subitem = (object) $subitem;

                        // endif;

                        echo '<li class="categories-subitem'.(isset($subitem->active) && $subitem->active ? ' is-active' : '').'">';
    printf(
                                '<a href="%s" class="categories-subitem-link" title="%s">%s</a>',
                                esc_url($subitem->href),
                                isset($item->title) ? $subitem->title : '',
                                $subitem->text
                            );
    echo '</li>';

    endforeach;

    echo '</ul>';

    endif;

    echo '</li>';
    endforeach; else :

        telabotanica_module_categories_default();

    endif;

    echo '</ul>';
    echo '</div>';
}
