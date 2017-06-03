<?php
/**
 * BuddyPress - Group - Custom front page for Tela Botanica.
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

            the_telabotanica_component('text', [
                'text' => $descriptionToDisplay,
            ]);
      ?>
    </div>
  </div>
</div>
