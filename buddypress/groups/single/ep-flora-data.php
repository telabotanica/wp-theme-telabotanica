<?php
/**
 * BuddyPress - Flora Data
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */
?>

<div class="layout-left-col reverse-colors" id="ep-flora-data">
	<div class="layout-wrapper">
		<aside class="layout-column">
			<div class="toc">
				<h2 class="toc-title">Flora Data</h2>
				<ul class="toc-items" id="ep-flora-data-menu">
					<li class="toc-item is-active" id="ep-flora-data-cartoPoint">
						<a class="toc-item-link" href="#ep-flora-data-tab-cartoPoint">
							<?php echo __('Carte des observations', 'telabotanica') ?>
						</a>
					</li>
					<li class="toc-item" id="ep-flora-data-photo">
						<a class="toc-item-link" href="#ep-flora-data-tab-photo">
							<?php echo __('Galerie photo', 'telabotanica') ?>
						</a>
					</li>
					<li class="toc-item" id="ep-flora-data-observation">
						<a class="toc-item-link" href="#ep-flora-data-tab-observation">
							<?php echo __('Flux des dernières observations', 'telabotanica') ?>
						</a>
					</li>
					<li class="toc-item" id="ep-flora-data-saisie">
						<a class="toc-item-link" href="#ep-flora-data-tab-saisie">
							<?php echo __('Saisie de nouvelles observations', 'telabotanica') ?>
						</a>
					</li>
					<li class="toc-item" id="ep-flora-data-export">
						<a class="toc-item-link" href="#ep-flora-data-tab-export">
							<?php echo __('Export des observations', 'telabotanica') ?>
						</a>
					</li>
				</ul>
			</div>
			<a href="#" class="button-top" title="Remonter en haut de la page" tabindex="-1">
				<svg aria-hidden="true" role="img" class="icon icon-arrow-up ">
					<use xlink:href="#icon-arrow-up"/>
				</svg> Remonter
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