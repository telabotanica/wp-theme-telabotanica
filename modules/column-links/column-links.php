<?php function telabotanica_module_column_links($data) {

	$defaults = [
		'items' => [],
		'modifiers' => []
	];

	$data = telabotanica_styleguide_data($defaults, $data);
	$data->modifiers = telabotanica_styleguide_modifiers_array('column-links', $data->modifiers);

  echo '<div class="' . implode(' ', $data->modifiers) . '">';

	  echo '<ul class="column-links-items">';

	  if ( !empty($data->items) ) :

	    foreach ($data->items as $item) :
	      $item = (object) $item;

	      echo '<li class="column-links-item">';

	        if ( isset($item->text) ) {
	          echo sprintf(
	            '<a href="%s" class="column-links-item-link">%s%s%s</a>',
	            esc_url( $item->href ),
							get_telabotanica_module('icon', ['icon' => $item->icon]),
	            $item->text,
							get_telabotanica_module('icon', ['icon' => 'angle-right'])
	          );
	        }

	      echo '</li>';
	    endforeach;

	  endif;

	  echo '</ul>';
  echo '</div>';
}
