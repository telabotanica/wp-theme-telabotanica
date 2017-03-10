<?php
/**
 * BuddyPress - Members - Custom front page for Tela Botanica
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

$current_user = wp_get_current_user();

printf(
	'<h1 class="cover-home-title">%s</h1>',
	sprintf(__('Bienvenue %s !', 'telabotanica'), $current_user->display_name)
);
