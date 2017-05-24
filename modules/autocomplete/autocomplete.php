<?php

function telabotanica_module_autocomplete($data)
{
    echo '<div class="autocomplete">';
    printf(
      '<input name="seach" class="autocomplete-input" placeholder="%s" />',
      __('Rechercher une plante, un projet, un mot clé...', 'telabotanica')
    );
    echo '</div>';
}
