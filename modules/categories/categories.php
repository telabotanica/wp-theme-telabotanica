<?php function telabotanica_module_categories($data) {
  $category_active = get_query_var('cat');
  $categories = get_categories(array(
    'exclude' => array(1),
    'hide_empty' => false,
    'orderby' => 'none',
    'parent' => 0
  )); ?>
  <div class="categories <?php echo $data->modifiers ?>">
    <h2 class="categories-title"><?php _e('Catégories', 'telabotanica'); ?></h2>
    <ul class="categories-items">
      <?php foreach ($categories as $category):
        $is_active = $category->term_id === $category_active; ?>
          <li class="categories-item<?php echo $is_active ? ' is-active' : null ?>">
            <h3 class="categories-item-title"><a href="<?php echo esc_url( get_term_link( $category ) ) ?>" class="categories-item-link"><?php echo $category->name; ?></a></h3>
            <?php $subitems = get_term_children( $category->term_id, 'category' );
            if ($subitems): ?>
            <ul class="categories-subitems">
              <?php foreach ($subitems as $subitem_id):
                $subitem_is_active = $subitem_id === $category_active;
                $subitem = get_term_by( 'id', $subitem_id, 'category' ); ?>
                <li class="categories-subitem<?php echo $subitem_is_active ? ' is-active' : null ?>">
                  <a href="<?php echo esc_url( get_term_link( $subitem ) ) ?>" class="categories-subitem-link"><?php echo $subitem->name; ?></a>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
          </li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php }
