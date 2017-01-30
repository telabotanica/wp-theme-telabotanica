<?php
/**
 * BuddyPress - Group - Custom front page for Tela Botanica
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */
?>

<div class="layout-central-col">
  <div class="layout-wrapper">
    <div class="layout-content">
      <?php
      $group = groups_get_current_group();

      $descriptionToDisplay = $group->description;
      $completeDescription = groups_get_groupmeta($group->id, 'description-complete');
      if ($completeDescription) {
        $descriptionToDisplay = $completeDescription;
      }
      ?>
      <div class="project-front-description"><?php _e("", 'telabotanica') ?>
        <?php echo $descriptionToDisplay; ?>
      </div>
    </div>
  </div>
</div>
