<?php
/**
 * BuddyPress - Flora Data
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */
?>

<div class="layout-content-col reversed-colors project-flora-data" id="ep-flora-data">
  <div class="layout-wrapper">
    <aside class="layout-column">
      <div class="toc">
        <h2 class="toc-title">Flora Data</h2>
        <ul class="toc-items" id="ep-flora-data-menu">
          <li class="toc-item" id="ep-flora-data-saisie">
            <a class="toc-item-link" href="#ep-flora-data-tab-saisie">
              <?php _e('Saisie de nouvelles observations', 'telabotanica') ?>
            </a>
          </li>
          <li class="toc-item" id="ep-flora-data-cartoPoint">
            <a class="toc-item-link" href="#ep-flora-data-tab-cartoPoint">
              <?php _e('Carte des observations', 'telabotanica') ?>
            </a>
          </li>
          <li class="toc-item" id="ep-flora-data-photo">
            <a class="toc-item-link" href="#ep-flora-data-tab-photo">
              <?php _e('Galerie photo', 'telabotanica') ?>
            </a>
          </li>
          <li class="toc-item" id="ep-flora-data-observation">
            <a class="toc-item-link" href="#ep-flora-data-tab-observation">
              <?php _e('Flux des dernières observations', 'telabotanica') ?>
            </a>
          </li>
          <li class="toc-item" id="ep-flora-data-export">
            <a class="toc-item-link" href="#ep-flora-data-tab-export">
              <?php _e('Export des observations', 'telabotanica') ?>
            </a>
          </li>
        </ul>
      </div>
      <a href="#" class="button-top" title="<?php _e('Remonter en haut de la page', 'telabotanica') ?>" tabindex="-1">
        <svg aria-hidden="true" role="img" class="icon icon-arrow-up ">
          <use xlink:href="#icon-arrow-up"/>
        </svg> <?php _e('Remonter', 'telabotanica') ?>
      </a>
    </aside>

    <div class="layout-content">
      <?php
      /**
       * Fires before the display of content for plugins using the BP_Group_Extension.
       *
       * @since 1.2.0
       */
      do_action( 'bp_before_group_plugin_template' ); ?>

      <?php
      /**
       * Fires and displays content for plugins using the BP_Group_Extension.
       *
       * @since 1.0.0
       */
      do_action( 'bp_template_content' ); ?>

      <?php
      /**
       * Fires after the display of content for plugins using the BP_Group_Extension.
       *
       * @since 1.2.0
       */
      do_action( 'bp_after_group_plugin_template' );
      ?>
    </div>
  </div>
</div>
