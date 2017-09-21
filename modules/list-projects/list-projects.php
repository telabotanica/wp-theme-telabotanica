<?php function telabotanica_module_list_projects($data) {

	echo '<div class="list-projects">';

	if ( bp_has_groups() ) :
		while ( bp_groups() ) : bp_the_group();
			the_telabotanica_module('card-project');
		endwhile;
		?>
	<?php else :
		echo '<p>' . __( 'Aucun projet disponible.', 'telabotanica' ) . '</p>';
	endif;

	echo '</div>';

}
