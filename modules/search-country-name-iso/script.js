var Tela = window.Tela || {};
Tela.modules = Tela.modules || {};

Tela.modules.searchBarCountryMembersPage = ( function() {

  function module( selector ) {
    var $el = $( selector ),
      $search;

    function init() {
      $search = $el.find( 'input.search-box-input' );
      searchCountry( $search );
    }

    // Add country iso codes to search query
    function searchCountry( $search ) {
      $.getJSON( '/wp-content/themes/telabotanica/modules/country-iso-name/pays.json' )
        .done( function( countryToIso ) {
          $search.on( 'change' , function() {
            var countryName = replaceDiacritics( $( this ).val() ),// Format search string
                countries   = Object.values( countryToIso ),
                isoCodes    = Object.keys( countryToIso ),
                queryVars   = [];

            countries.forEach( function( coutryNameInJsonFIle , index ) {
              countries[ index ] = replaceDiacritics(  coutryNameInJsonFIle );// Format country names
            });

            // When search maches country name part add country iso to query string
            matches = countries.filter( x => x.includes( countryName ) );
            matches.forEach( function( matchedCountry , index ) {
              queryVars.push( isoCodes[ countries.indexOf( matchedCountry ) ] );
            });

            if( 0 < queryVars.length ) {
              $search.attr( 'name' , 'tb_search' );
              $search.after(
                '<input type="hidden" name="countries" value="' + queryVars.join() + '">'
              );
            }

          });
        });
    }

    // user can forget accents when entering search strings
    function replaceDiacritics( string ) {
      var diacritics = [
        { char: 'A' , base: /[\300-\306]/g },
        { char: 'a' , base: /[\340-\346]/g },
        { char: 'E' , base: /[\310-\313]/g },
        { char: 'e' , base: /[\350-\353]/g },
        { char: 'I' , base: /[\314-\317]/g },
        { char: 'i' , base: /[\354-\357]/g },
        { char: 'O' , base: /[\322-\330]/g },
        { char: 'o' , base: /[\362-\370]/g },
        { char: 'U' , base: /[\331-\334]/g },
        { char: 'u' , base: /[\371-\374]/g },
        { char: 'N' , base: /[\321]/g },
        { char: 'n' , base: /[\361]/g },
        { char: 'C' , base: /[\307]/g },
        { char: 'c' , base: /[\347]/g },
        { char: ''  , base: /[\(\,\)]/g },// Strip parenthesis and commas
        { char: ' ' , base: /[-_]/g }// replace dashes and underscrores
      ];

      string = utf8Decode( string );

      diacritics.forEach( function( letter ) {
        string = string.replace( letter.base, letter.char );
      });

      return string.toLowerCase();
    }

    // Decode utf8 special characters (for strings in Object resulting from json file)
    function utf8Decode( string ) {
      var regex = /\\u([\d\w]{4})/gi;
      string = string.replace( regex , function ( match, group ) {
        return String.fromCharCode( parseInt( group, 16 ) );
      });
      return unescape( string );
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
  Tela.modules.searchBarCountryMembersPage( '.directory.members.buddypress .cover-search-box .search-box.dir-search form' );
});
