<?php function telabotanica_module_categories ($data) {
  $categorie_active = get_query_var('cat');
  $categories = get_categories(array(
    'exclude' => array(1, 2),
    'hide_empty' => false,
    'orderby' => 'none',
    'parent' => 0
  )); ?>
  <div class="categories">
    <h2 class="categories-titre">Catégories</h2>
    <ul class="categories-items">
      <?php foreach ($categories as $categorie):
        $est_active = $categorie->term_id === $categorie_active; ?>
          <li class="categories-item<?php echo $est_active ? ' est-active' : null ?>">
            <h3 class="categories-item-titre"><a href="<?php echo esc_url( get_term_link( $categorie ) ) ?>" class="categories-item-lien"><?php echo $categorie->name; ?></a></h3>
            <?php $enfants = get_term_children( $categorie->term_id, 'category' );
            if ($enfants): ?>
            <ul class="categories-enfants-items">
              <?php foreach ($enfants as $enfant_id):
                $enfant_est_actif = $enfant_id === $categorie_active;
                $enfant = get_term_by( 'id', $enfant_id, 'category' ); ?>
                <li class="categories-enfants-item<?php echo $enfant_est_actif ? ' est-active' : null ?>">
                  <a href="<?php echo esc_url( get_term_link( $enfant ) ) ?>" class="categories-enfants-item-lien"><?php echo $enfant->name; ?></a>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
          </li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php }
