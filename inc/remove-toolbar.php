<?php

add_action('after_setup_theme', 'tb_remove_toolbar');

function tb_remove_toolbar()
{
    // si besoin, modifier ici pour que d'autres rôles bénéficient de la barre
    // d'outils (rédacteurs, contributeurs)
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
}
