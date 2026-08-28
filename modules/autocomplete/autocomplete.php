<?php function telabotanica_module_autocomplete($data) {
  echo '<div class="autocomplete">';
    printf(
      '<input name="search" type="search" class="autocomplete-input" placeholder="%s" autocomplete="off" spellcheck="false" />',
      esc_attr__( 'Rechercher une plante, un projet, un mot clé...', 'telabotanica' )
    );
  echo '</div>';
}
