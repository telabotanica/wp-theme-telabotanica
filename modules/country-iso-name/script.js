var Tela = window.Tela || {};
Tela.modules = Tela.modules || {};

Tela.modules.countryIsoName = ( function() {

  function module( selector ) {
    var $el = $( selector ),
      $pays,
      $paysOption;

    function init() {
      $pays = $el.find( '#field_3' );
      displayCountryName( $pays );
    }

    function displayCountryName( $pays ) {
      $paysOption = $pays.find( 'option' );

      $.getJSON( '/wp-content/themes/telabotanica/modules/country-iso-name/pays.json' )
        .done( function( isoToCountry ) {
          var isoKey = '';

          // Browse all country select options
          $paysOption.each( function() {
            isoKey = $( this ).val();

            // When iso mached switch displayed content to country name
            if ( isoToCountry.hasOwnProperty( isoKey ) ) {
              $( this ).text(isoToCountry[ isoKey ]);
            }

            // We want first country be France
            if( isoKey === 'FR') {
              optionFr = $( this );
              $( this ).remove();
              optionFr.insertAfter( $paysOption.first() );
            }

          });
        });
    }

    init();
  }

  return function( selector ) {
    return $( selector ).each( function() {
        module( this );
    });
  };
})();


$( document ).ready( function() {
  Tela.modules.countryIsoName( '.editfield.field_3.field_pays' );
});
