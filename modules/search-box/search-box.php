<?php function telabotanica_module_search_box($data) {
  $defaults = [
    'autocomplete' => true,
    'instantsearch' => false,
    'placeholder' => __('Rechercher une plante, un projet, un mot clé...', 'telabotanica'),
    'value' => get_search_query() ?: get_query_var( 'q', false ),
    'index' => false,
    'suggestions' => false,
    'facetFilters' => '',
    'modifiers' => ['large'],
    'pageurl' => ''
  ];

  $data = telabotanica_styleguide_data($defaults, $data);
  $data->modifiers = telabotanica_styleguide_modifiers_array('search-box', $data->modifiers);
  // If country search display country name instead of iso
  if( 2 === strlen( $data->value ) && ctype_upper( $data->value ) ) :
    $data->value = retrieve_country_name_from_iso( $data->value );
  endif;

  printf(
    '<div class="%s" data-autocomplete="%s" data-instantsearch="%s" data-index="%s" data-facet-filters="%s">',
    implode(' ', $data->modifiers),
    var_export($data->autocomplete, true),
    var_export($data->instantsearch, true),
    $data->index,
    $data->facetFilters
  );
    printf(
      '<form role="search" method="get" action="%s">',
      esc_url( home_url( '/' . $data->pageurl ) )
    );
      if ($data->index) :
        printf(
          '<input name="in" type="hidden" value="%s" />',
          esc_attr( sanitize_key( $data->index ) )
        );
      endif;
      echo '<div class="search-box-wrapper">';
        printf(
          '<input name="s" type="text" class="search-box-input" placeholder="%s" value="%s" autocomplete="off" spellcheck="false" />',
          esc_attr( $data->placeholder ),
          esc_attr( $data->value )
        );
        printf(
          '<button type="submit" class="search-box-button">%s</button>',
          get_telabotanica_module('icon', ['icon' => 'search'])
        );
      echo '</div>';
    echo '</form>';

    if ( $data->suggestions ) :
      $suggestions = array_map(function($suggestion) {
        return sprintf(
          '<a href="%s">%s</a>',
          '#' . $suggestion, // TODO compose URL to search results
          $suggestion
        );
      }, $data->suggestions);

      printf(
        '<div class="search-box-suggestions">%s</div>',
        sprintf(
          __('Par exemple : %s...', 'telabotanica'),
          implode(', ', $suggestions)
        )
      );
    endif;

  echo '</div>';
}
