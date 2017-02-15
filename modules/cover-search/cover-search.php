<?php function telabotanica_module_cover_search($data) {
	global $wp_query;
	if (!isset($data->image)) $data->image = get_field('cover_image');
	if (!isset($data->total_results)) $data->total_results = $wp_query->found_posts;
	if (!isset($data->modifiers)) $data->modifiers = '';
	?>
	<div class="cover cover-search <?php echo $data->modifiers ?>" style="background-image: url(<?php echo $data->image['url'] ?>);">
		<div class="layout-wrapper">
			<div class="cover-search-content">
			<?php
			the_telabotanica_module('search-box', [
				'autocomplete' => false
			]);

			if ( get_search_query() && !empty( $data->total_results ) ) :
				echo sprintf(
					'<h1 class="cover-search-title">%s</h1>',
					sprintf( _n(
						'%s résultat trouvé',
						'%s résultats trouvés',
						$data->total_results,
						'telabotanica'
					), number_format_i18n( $data->total_results ) )
				);
			endif;
			?>
			</div>

		</div>
		<?php
			if ( $data->image ) :
				$credits = get_fields( $data->image['ID'] );
				if ( $credits ) :
					echo '<div class="cover-credits">';
					if ($credits['link']) {
						echo sprintf(__('%s par %s', 'telabotanica'), '<a href="' . $credits['link'] . '" target="_blank">' . $data->image['title'] . '</a>', $credits['author']);
					} else {
						echo sprintf(__('%s par %s', 'telabotanica'), $data->image['title'], $credits['author']);
					}
					echo '</div>';
				endif;
		endif; ?>
	</div>
<?php }
