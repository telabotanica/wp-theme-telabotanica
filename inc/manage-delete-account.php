<?php

// Creates deleted_tb_user role
add_role( 'deleted_tb_user', __('Ex-telabotaniste', 'telabotanica' ), array('read' => false));

/**
 * retrieve user id with 'deleted_tb_user' role
 *
 * @return integer
 */
function retrieve_deleted_tb_user_id() {
  global $wpdb;

  $deleted_tb_user_ID = $wpdb->get_col( $wpdb->prepare( "
    SELECT user_id
    FROM $wpdb->usermeta
    WHERE meta_key = 'capabilities'
    AND meta_value = %s
  ", 'a:1:{s:15:"deleted_tb_user";b:1;}') );

  if(count($deleted_tb_user_ID) > 0) {

    //there can be only one user with the role 'deleted_tb_user'
    return (int) $deleted_tb_user_ID[0];
  }
  return false;
}

/**
 * Hooked on bp_core_delete_account()
 * Reassigns posts, links, comments etc. as bp_core_delete_account() does not allow reassignment
 * @see wp_delete_user()
 */

function reassign_to_deleted_tb_user($id) {
  global $wpdb;

  // set reassign to Ex-telabotaniste user's ID
  $reassign = retrieve_deleted_tb_user_id();

  // Do the reassignment and let bp_core_delete_account() do the rest using wp_delete_user()
  // excerpted from  /wp-admin/includes/user.php
  $post_ids = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_author = %d", $id ) );
  $wpdb->update( $wpdb->posts, array('post_author' => $reassign), array('post_author' => $id) );
  if ( ! empty( $post_ids ) ) {
    foreach ( $post_ids as $post_id ) {
      clean_post_cache( $post_id );
    }
  }
  $link_ids = $wpdb->get_col( $wpdb->prepare("SELECT link_id FROM $wpdb->links WHERE link_owner = %d", $id) );
  $wpdb->update( $wpdb->links, array('link_owner' => $reassign), array('link_owner' => $id) );
  if ( ! empty( $link_ids ) ) {
    foreach ( $link_ids as $link_id ) {
      clean_bookmark_cache( $link_id );
    }
  }
  /*--end of user.php excerpt--*/

  // same for comments
  $comment_ids = $wpdb->get_col( $wpdb->prepare("SELECT comment_id FROM $wpdb->comments WHERE user_id = %d", $id) );
  $wpdb->update( $wpdb->comments, array('user_id' => $reassign), array('user_id' => $id) );
  if ( ! empty( $comment_ids ) ) {
    foreach ( $comment_ids as $comment_id ) {
      clean_bookmark_cache( $comment_id );
    }
  }
}
add_action( 'bp_core_pre_delete_account', 'reassign_to_deleted_tb_user');
