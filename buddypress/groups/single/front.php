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
      //var_dump($group);
      
      $descriptionAAfficher = $group->description;
      $descriptionComplete = groups_get_groupmeta($group->id, 'description-complete');
      //var_dump($descriptionComplete);
      if ($descriptionComplete) {
        $descriptionAAfficher = $descriptionComplete;
      }
      ?>
      <div class="project-front-description"><?php _e("", 'telabotanica') ?>
        <?php echo $descriptionAAfficher; ?>
      </div>
    </div>
  </div>
</div>
