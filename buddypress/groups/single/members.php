<?php
/**
 * BuddyPress - Groups Members
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */
?>

<div class="layout-central-col project-members is-wide">
  <div class="layout-wrapper">
    <div class="layout-content">

      <div class="item-list-tabs" id="group-members-subnav" aria-label="<?php esc_attr_e( 'Group secondary navigation', 'buddypress' ); ?>" role="navigation">
        <ul>
          <li class="groups-members-search" role="search">
            <?php bp_directory_members_search_form(); ?>
          </li>

          <?php
          bp_groups_members_filter();

          /**
           * Fires at the end of the group members search unordered list.
           *
           * Part of bp_groups_members_template_part().
           *
           * @since 1.5.0
           */
          do_action( 'bp_members_directory_member_sub_types' ); ?>

        </ul>
      </div>

      <h2 class="bp-screen-reader-text"><?php
        /* translators: accessibility text */
        _e( 'Members', 'buddypress' );
      ?></h2>

      <div id="members-group-list" class="group_members dir-list">

      <?php if ( bp_group_has_members( bp_ajax_querystring( 'group_members' ) ) ) : ?>

        <?php

        /**
         * Fires before the display of the group members content.
         *
         * @since 1.1.0
         */
        do_action( 'bp_before_group_members_content' ); ?>

        <div id="pag-top" class="pagination">

          <div class="pag-count" id="member-count-top">

            <?php bp_members_pagination_count(); ?>

          </div>

          <div class="pagination-links" id="member-pag-top">

            <?php bp_members_pagination_links(); ?>

          </div>

        </div>

        <?php

        /**
         * Fires before the display of the group members list.
         *
         * @since 1.1.0
         */
        do_action( 'bp_before_group_members_list' ); ?>

        <ul id="member-list" class="item-list">

          <?php while ( bp_group_members() ) : bp_group_the_member(); ?>

            <li>
              <?php
              $memberId = bp_get_group_member_id();
              the_telabotanica_component('contact', [
                'image' => bp_core_fetch_avatar(array(
                  'item_id' => $memberId,
                  'html' => 'false',
                  'type' => 'full'
                )),
                'name' => bp_get_group_member_name(),
                'link' => bp_get_group_member_url(),
                'description' => bp_get_group_member_joined_since()
              ]);

              /**
               * Fires inside the listing of an individual group member listing item.
               *
               * @since 1.1.0
               */
              do_action( 'bp_group_members_list_item' ); ?>

              <?php if ( bp_is_active( 'friends' ) ) : ?>

                <div class="action">

                  <?php bp_add_friend_button( bp_get_group_member_id(), bp_get_group_member_is_friend() ); ?>

                  <?php

                  /**
                   * Fires inside the action section of an individual group member listing item.
                   *
                   * @since 1.1.0
                   */
                  do_action( 'bp_group_members_list_item_action' ); ?>

                </div>

              <?php endif; ?>
            </li>

          <?php endwhile; ?>

        </ul>

        <?php

        /**
         * Fires after the display of the group members list.
         *
         * @since 1.1.0
         */
        do_action( 'bp_after_group_members_list' ); ?>

        <div id="pag-bottom" class="pagination">

          <div class="pag-count" id="member-count-bottom">

            <?php bp_members_pagination_count(); ?>

          </div>

          <div class="pagination-links" id="member-pag-bottom">

            <?php bp_members_pagination_links(); ?>

          </div>

        </div>

        <?php

        /**
         * Fires after the display of the group members content.
         *
         * @since 1.1.0
         */
        do_action( 'bp_after_group_members_content' ); ?>

      <?php else: ?>

        <div id="message" class="info">
          <p><?php _e( 'No members were found.', 'buddypress' ); ?></p>
        </div>

      <?php endif; ?>
      </div>
    </div>
  </div>
</div>
