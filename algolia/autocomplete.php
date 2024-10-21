<script type="text/template" id="tmpl-dropdown-menu">
  <div class="search-results aa-dropdown-menu-wrapper">
    <div class="search-results-index aa-dataset aa-dataset-1"></div>
    <div class="search-results-index aa-dataset aa-dataset-2"></div>
    <div class="search-results-index aa-dataset aa-dataset-3"></div>
    <div class="search-results-index aa-dataset aa-dataset-4"></div>
    <div class="search-results-index aa-dataset aa-dataset-5"></div>
    <div class="search-results-index aa-dataset aa-dataset-6"></div>
  </div>
</script>

<script type="text/html" id="tmpl-autocomplete-header">
  <a href="{{{ data.resultsUrl }}}" class="search-results-header">
    <div class="search-results-header-title">{{{ data.label }}}</div>
    <div class="search-results-header-count">{{{ data.nbHits }}}</div>
    <div class="search-results-header-more"><?php _e( 'voir plus', 'telabotanica' ); ?></div>
  </a>
</script>

<script type="text/html" id="tmpl-autocomplete-post-suggestion">
  <a class="search-results-hit-link" href="{{ data.permalink }}" title="{{ data.post_title }}">
    <# if ( data.featured_image ) { #>
      <img class="search-results-hit-post-thumbnail" src="{{ data.featured_image }}" alt="{{ data.post_title }}" />
    <# } #>
    <div class="search-results-hit-post-attributes">
      <span class="search-results-hit-post-title">{{{ data._highlightResult.post_title.value }}}</span>

      <#
      var attributes = ['post_content'];
      var attribute_name;
      var relevant_content = '';
      for ( var index in attributes ) {
        attribute_name = attributes[ index ];
        if ( data._highlightResult[ attribute_name ].matchedWords.length > 0 ) {
          relevant_content = data._snippetResult[ attribute_name ].value;
          break;
        } else if( data._snippetResult[ attribute_name ].value !== '' ) {
          relevant_content = data._snippetResult[ attribute_name ].value;
        }
      }
      #>
      <span class="search-results-hit-post-content">{{{ relevant_content }}}</span>
    </div>
  </a>
</script>

<script type="text/html" id="tmpl-autocomplete-taxon-suggestion">
  <a class="search-results-hit-link" href="{{ data.bdtfx.permalink }}" title="{{ data.bdtfx.scientific_name }}">
    <span class="search-results-hit-post-title">{{{ data._highlightResult.bdtfx.scientific_name.value }}}</span>
    <#
    
    var postContent = data._highlightResult.bdtfx.common_name;
    console.log(postContent);
    var noms_txt='';
    for(var i=0;i<postContent.length;i++){
    	noms_txt+=postContent[i].value + ', ';
    }
    noms_txt=noms_txt.slice(0,-2);
    #>
    <span class="search-results-hit-post-content">{{{ noms_txt }}}</span>
  </a>
</script>

<script type="text/html" id="tmpl-autocomplete-group-suggestion">
  <a class="search-results-hit-link" href="{{ data.permalink }}" title="{{ data.name }}">
    <# if ( data.image ) { #>
    <img class="search-results-hit-group-thumbnail" src="{{ data.image }}" alt="{{ data.name }}" />
    <# } #>

    <div class="search-results-hit-group-attributes">
      <span class="search-results-hit-post-title">{{{ data._highlightResult.name.value }}}</span>

      <#
      var attributes = ['description'];
      var attribute_name;
      var relevant_content = '';
      for ( var index in attributes ) {
        attribute_name = attributes[ index ];
        if ( data._highlightResult[ attribute_name ].matchedWords.length > 0 ) {
          relevant_content = data._snippetResult[ attribute_name ].value;
          break;
        } else if( data._snippetResult[ attribute_name ].value !== '' ) {
          relevant_content = data._snippetResult[ attribute_name ].value;
        }
      }
      #>
      <span class="search-results-hit-post-content">{{{ relevant_content }}}</span>
    </div>
  </a>
</script>

<script type="text/html" id="tmpl-autocomplete-syntaxon-suggestion">
  <a class="search-results-hit-link" href="{{ data.permalink }}" title="{{ data.commonName }}">
    <span class="search-results-hit-post-title">{{{ data._highlightResult.syntaxon.value }}}</span>
  </a>
</script>

<script type="text/html" id="tmpl-autocomplete-term-suggestion">
  <a class="search-results-hit-link" href="{{ data.permalink }}" title="{{ data.name }}">
    <svg viewBox="0 0 21 21" width="21" height="21"><svg width="21" height="21" viewBox="0 0 21 21"><path d="M4.662 8.72l-1.23 1.23c-.682.682-.68 1.792.004 2.477l5.135 5.135c.7.693 1.8.688 2.48.005l1.23-1.23 5.35-5.346c.31-.31.54-.92.51-1.36l-.32-4.29c-.09-1.09-1.05-2.06-2.15-2.14l-4.3-.33c-.43-.03-1.05.2-1.36.51l-.79.8-2.27 2.28-2.28 2.27zm9.826-.98c.69 0 1.25-.56 1.25-1.25s-.56-1.25-1.25-1.25-1.25.56-1.25 1.25.56 1.25 1.25 1.25z" fill-rule="evenodd"></path></svg></svg>
    <span class="search-results-hit-post-title">{{{ data._highlightResult.name.value }}}</span>
  </a>
</script>

<script type="text/html" id="tmpl-autocomplete-user-suggestion">
  <a class="search-results-hit-link" href="{{ data.posts_url }}" title="{{ data.display_name }}">
    <# if ( data.avatar_url ) { #>
    <img class="search-results-hit-user-thumbnail" src="{{ data.avatar_url }}" alt="{{ data.display_name }}" />
    <# } #>

    <span class="search-results-hit-post-title">{{{ data._highlightResult.display_name.value }}}</span>
  </a>
</script>

<script type="text/html" id="tmpl-autocomplete-footer">
  <div class="search-results-footer">
    <div class="search-results-footer-branding">
      <?php esc_html_e( 'Powered by', 'algolia' ); ?>
      <a href="#" class="algolia-powered-by-link" title="Algolia">
        <img class="algolia-logo" src="https://www.algolia.com/assets/algolia128x40.png" alt="Algolia" />
      </a>
    </div>
  </div>
</script>

<script type="text/html" id="tmpl-autocomplete-empty">
  <div class="search-results-empty">
    <?php esc_html_e( 'Aucun résultat pour ', 'telabotanica' ); ?>
    <span class="search-results-empty-query">"{{ data.query }}"</span>
  </div>
</script>
