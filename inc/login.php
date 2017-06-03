<?php

// Personnalisation de la page de login

function telabotanica_login_logo_url()
{
    return home_url();
}
add_filter('login_headerurl', 'telabotanica_login_logo_url');

function telabotanica_login_logo_url_title()
{
    return 'Tela Botanica';
}
add_filter('login_headertitle', 'telabotanica_login_logo_url_title');

function telabotanica_login_stylesheet()
{
    wp_enqueue_style('custom-login', get_stylesheet_directory_uri().'/dist/login-style.css');
    wp_enqueue_script('telabotanica-script', get_template_directory_uri().'/dist/bundle.js', ['jquery'], null, true);
}
add_action('login_enqueue_scripts', 'telabotanica_login_stylesheet');
