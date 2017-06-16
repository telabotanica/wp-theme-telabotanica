<?php function telabotanica_module_upcoming_events($data) {

	$defaults = [
		'modifiers' => []
	];

	$data = telabotanica_styleguide_data($defaults, $data);
	$data->modifiers = telabotanica_styleguide_modifiers_array('upcoming-events', $data->modifiers);

	printf(
		'<div class="%s">',
		implode(' ', $data->modifiers)
	);

	?>
		<div class="upcoming-events-title">
			<?php the_telabotanica_module('icon', ['icon' => 'calendar']); ?>
			<?php echo __( "Évènements à venir", 'telabotanica' ) ?>
		</div>
		<ul class="upcoming-events-items">
			<?php
			$query = new WP_Query([
				'meta_query' => [
					[
						'key' => 'date',
						'compare' => '>',
						'value' => date('Ymd'),
						'type' => 'DATE'
					]
				],
				'posts_per_page' => 3,
				'orderby' => 'meta_value_num',
				'meta_key' => 'date',
				'order' => 'ASC',
			]);

			if ( $query->have_posts() ) :
				while ( $query->have_posts() ) : $query->the_post();
					echo '<li class="upcoming-events-item">';
					printf(
						'<a href="%s" class="upcoming-events-item-link">
							%s
							<div class="upcoming-events-name">%s</div>
							<div class="upcoming-events-place">%s</div>
						</a>',
						get_permalink(),
						get_telabotanica_module('event-dates', [
							'modifiers' => 'small'
						]),
						get_the_title(),
						telabotanica_format_place( get_field( 'place' ) )
					);
					echo '</li>';
				endwhile;
			endif;
			?>
		</ul>
<?php
	the_telabotanica_module('button', [
		'href' => get_category_link( get_category_by_slug( 'evenements' ) ),
		'text' => __( "Voir tous les évènements", 'telabotanica' ),
		'modifiers' => ['block', 'orange', 'upcoming-events-button']
	] );

	echo '</div>';

	wp_reset_postdata();
}
