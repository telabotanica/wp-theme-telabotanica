<?php function telabotanica_module_search_box($data) {
  echo '<div class="search-box large">';
    echo '<div class="search-box-wrapper">';
    echo sprintf(
      '<input name="s" class="search-box-input" placeholder="%s" />',
      __('Rechercher une plante, un projet, un mot clé...', 'telabotanica')
    );
    echo '<button type="submit" class="search-box-button">' . get_telabotanica_module('icon', ['icon' => 'search']) . '</button>';
    echo '</div>';
    echo '<div class="search-box-suggestions">Par exemple : coquelicot, quercus ilex, végétation, mooc... </div>';
  echo '</div>';
}
