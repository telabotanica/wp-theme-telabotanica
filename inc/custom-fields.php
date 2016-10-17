<?php
if( function_exists('acf_add_local_field_group') ):

  // Requiert tous les fichiers dans le dossier custom-fields
  foreach (glob(get_template_directory() . '/inc/custom-fields/*.php') as $filename) {
    require $filename;
  }

endif;
