<?php

function telabotanica_module_nav_project($data)
{
    echo '<div class="nav-project">';
    echo '<ul class="nav-project-items">';

    bp_get_options_nav();

      /*
       * Fires after the display of group options navigation.
       *
       * @since 1.2.0
       */
      do_action('bp_group_options_nav');

    echo '</ul>';

    the_telabotanica_module('share');
    echo '</div>';
}
