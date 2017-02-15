<?php function telabotanica_module_cover($data) {
	if (!isset($data->image)) $data->image = get_field('cover_image');
	if (!isset($data->title)) $data->title = get_the_title();
	if (!isset($data->subtitle)) $data->subtitle = get_field('cover_subtitle');
	if (!isset($data->content)) $data->content = false;
	if (!isset($data->search)) $data->search = false;
	if (!isset($data->modifiers)) $data->modifiers = '';
	?>
	<div class="cover <?php echo $data->modifiers ?>" style="background-image: url(<?php echo $data->image['url'] ?>);">
		<div class="layout-wrapper">
			<?php
			if ($data->search) :
				$data->search['autocomplete'] = false;
				printf(
					'<div class="cover-search-box">%s</div>',
					get_telabotanica_module('search-box', $data->search)
				);
			endif;

			printf(
				'<h1 class="cover-title">%s</h1>',
				$data->title
			);

			if ($data->subtitle) :
				printf(
					'<div class="cover-subtitle">%s</div>',
					$data->subtitle
				);
			endif;

			if ($data->content) :
				printf(
					'<div class="cover-content">%s</div>',
					$data->content
				);
			endif;
			?>
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
