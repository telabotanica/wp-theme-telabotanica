<?php function telabotanica_module_search_box($data) {
  $defaults = [
    'autocomplete' => true,
    'instantsearch' => false,
    'placeholder' => __('Rechercher une plante, une actu,...', 'telabotanica'),
    'value' => get_search_query() ?: get_query_var( 'q', false ),
    'index' => false,
    'suggestions' => false,
    'facetFilters' => '',
    'modifiers' => ['large'],
    'pageurl' => ''
  ];

  $data = telabotanica_styleguide_data($defaults, $data);
  $data->modifiers = telabotanica_styleguide_modifiers_array('search-box', $data->modifiers);

  // dataset values are strings — JS compares with === 'true'
  $autocomplete_attr = $data->autocomplete ? 'true' : 'false';
  $instantsearch_attr = $data->instantsearch ? 'true' : 'false';

  printf(
    '<div class="%s" data-autocomplete="%s" data-instantsearch="%s" data-index="%s" data-facet-filters="%s">',
    esc_attr( implode(' ', $data->modifiers) ),
    esc_attr( $autocomplete_attr ),
    esc_attr( $instantsearch_attr ),
    esc_attr( $data->index ),
    esc_attr( $data->facetFilters )
  );
    printf(
      '<form role="search" method="get" action="%s">',
      esc_url( home_url( '/' . ltrim($data->pageurl, '/') ) )
    );
      if ($data->index) :
        printf(
          '<input name="in" type="hidden" value="%s" />',
          esc_attr( sanitize_key( $data->index ) )
        );
      endif;
      echo '<div class="search-box-wrapper">';
        printf(
          '<input name="s" type="search" class="search-box-input" placeholder="%s" value="%s" autocomplete="off" spellcheck="false" aria-label="%s" />',
          esc_attr( $data->placeholder ),
          esc_attr( $data->value ),
          esc_attr__( 'Rechercher', 'telabotanica' )
        );
        printf(
          '<button type="submit" class="search-box-button" aria-label="%s">%s</button>',
          esc_attr__( 'Rechercher', 'telabotanica' ),
          get_telabotanica_module('icon', ['icon' => 'search'])
        );
      echo '</div>';
    echo '</form>';

    if ( $data->suggestions && is_array($data->suggestions) ) :
      $suggestions = array_map(function($suggestion) {
        // Build proper search URL — was '#' (broken)
        $url = add_query_arg('s', $suggestion, home_url('/'));
        return sprintf(
          '<a href="%s">%s</a>',
          esc_url( $url ),
          esc_html( $suggestion )
        );
      }, $data->suggestions);

      printf(
        '<div class="search-box-suggestions">%s</div>',
        sprintf(
          esc_html__('Par exemple : %s...', 'telabotanica'),
          implode(', ', $suggestions)
        )
      );
    endif;

  echo '</div>';
}
