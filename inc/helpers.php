<?php
function tb_acf($key, $post = null, $default = null) {
  if (!function_exists('get_field')) {
    return $default;
  }

  $post_id = null;

  if ($post instanceof WP_Post) {
    $post_id = $post->ID;
  } elseif (is_numeric($post)) {
    $post_id = (int) $post;
  }

  return get_field($key, $post_id) ?: $default;
}

function tb_bp_user_url() {
  return function_exists('bp_loggedin_user_domain')
    ? bp_loggedin_user_domain()
    : '#';
}

function tb_bp_members_count() {
  return function_exists('bp_get_total_member_count')
    ? bp_get_total_member_count()
    : 0;
}

function tb_bp_avatar($user_id) {
  if (!function_exists('bp_core_fetch_avatar')) {
    return '';
  }

  return bp_core_fetch_avatar([
    'item_id' => $user_id,
    'html' => false
  ]);
}

function tb_bp_profile_url() {
  return function_exists('bp_loggedin_user_domain')
    ? bp_loggedin_user_domain()
    : '#';
}

function tb_bp_signup_url() {
  return function_exists('bp_get_signup_page')
    ? bp_get_signup_page()
    : wp_login_url();
}

function tb_bp_profile_edit_url() {
  if (!function_exists('bp_loggedin_user_domain')) {
    return wp_login_url();
  }

  return trailingslashit(bp_loggedin_user_domain()) . 'profile/edit';
}

function tb_category_by_slug($slug) {
  return get_category_by_slug($slug) ?: null;
}

function tb_user_url($user_id) {
  return function_exists('bp_core_get_user_domain')
    ? bp_core_get_user_domain($user_id)
    : get_author_posts_url($user_id);
}

function tb_user_name($user_id) {
  return function_exists('bp_core_get_user_displayname')
    ? bp_core_get_user_displayname($user_id)
    : get_the_author_meta('display_name', $user_id);
}

function tb_current_url() {
  if (function_exists('bp_is_group') && bp_is_group()) {
    return function_exists('bp_get_group_permalink')
      ? bp_get_group_permalink()
      : get_permalink();
  }

  return get_permalink();
}
