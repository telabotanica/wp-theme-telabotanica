<?php
/**
 * BuddyPress - Groups Home
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */


if ( bp_has_groups() ) : while ( bp_groups() ) : bp_the_group();

/**
 * Fires before the display of the group home content.
 *
 * @since 1.2.0
 */
do_action( 'bp_before_group_home_content' );

the_telabotanica_module('cover-project', []);
the_telabotanica_module('nav-project', []);
?>

<div id="item-body">

  <?php

  /**
   * Fires before the display of the group home body.
   *
   * @since 1.2.0
   */
  do_action( 'bp_before_group_body' );

  /**
   * Does this next bit look familiar? If not, go check out WordPress's
   * /wp-includes/template-loader.php file.
   *
   * @todo A real template hierarchy? Gasp!
   */

    // Looking at home location
    if ( bp_is_group_home() ) :

      if ( bp_group_is_visible() ) {

        // Load appropriate front template
        bp_groups_front_template_part();

      } else {

        /**
         * Fires before the display of the group status message.
         *
         * @since 1.1.0
         */
        do_action( 'bp_before_group_status_message' ); ?>

        <div id="message" class="info">
          <p><?php bp_group_status_message(); ?></p>
        </div>

        <?php

        /**
         * Fires after the display of the group status message.
         *
         * @since 1.1.0
         */
        do_action( 'bp_after_group_status_message' );

      }

    // Not looking at home
    else :

      // Group Admin
      if     ( bp_is_group_admin_page() ) : bp_get_template_part( 'groups/single/admin'        );

      // Group Activity
      elseif ( bp_is_group_activity()   ) : bp_get_template_part( 'groups/single/activity'     );

      // Group Members
      // remplace bp_groups_members_template_part() qui impose de placer la recherche / le
      // filtrage des membres hors du template (pas pratique)
      elseif ( bp_is_group_members()    ) : bp_get_template_part( 'groups/single/members'     );

      // Group Invitations
      elseif ( bp_is_group_invites()    ) : bp_get_template_part( 'groups/single/send-invites' );

      // Membership request
      elseif ( bp_is_group_membership_request() ) : bp_get_template_part( 'groups/single/request-membership' );

      // Anything else (plugins mostly)
      else :
        $current_action = bp_current_action();
        //var_dump($current_action);
        switch ($current_action) :
          case 'forum':
            bp_get_template_part('groups/single/ep-forum');
            break;
          case 'porte-documents':
            bp_get_template_part('groups/single/ep-documents');
            break;
          case 'wiki':
            bp_get_template_part('groups/single/ep-wiki');
            break;
          case 'flora-data':
            bp_get_template_part('groups/single/ep-flora-data');
            break;
          default:
            bp_get_template_part('groups/single/plugins');
        endswitch;

      endif;

    endif;

  /**
   * Fires after the display of the group home body.
   *
   * @since 1.2.0
   */
  do_action( 'bp_after_group_body' ); ?>

</div><!-- #item-body -->

<?php

/**
 * Fires after the display of the group home content.
 *
 * @since 1.2.0
 */
do_action( 'bp_after_group_home_content' ); ?>

<?php endwhile; endif; ?>
