'use strict';

var Tela = window.Tela || {};

Tela.epFloraData = (function(){

  function manageTabs(menuSelector, bodySelector){
    var $zoneMenu = $(menuSelector),
        $zoneOutils = $(bodySelector),
        $tabs,
        $entreesListe,
        $outils;

    function init(){
      $tabs = $zoneMenu.find('a.toc-item-link');
      $entreesListe = $zoneMenu.find('li.toc-item');
      $outils = $zoneOutils.find('.ep-flora-data-tab');

      manageMenu();

      $tabs.on('click', changeTab);
    }

    function manageMenu() {
      // supprimer les entrées de menu correspondant aux outils non activés
      $tabs.each(function() {
        var idOutil = $(this).attr('href'),
            outilPointe = $(idOutil);
        if (! outilPointe.length) {
            $(this).closest('li').remove();
        }
      });
      // activer l'entrée de menu correspondant à l'outil actuellement visible
      if ($outils.length) {
        var outilVisible = $outils.first(),
          idOutilVisible = outilVisible.attr('id'),
          lienMenu = $tabs.filter('[href="#' + idOutilVisible + '"]');
        lienMenu.closest('li').addClass('is-active');
      }
    }

    function changeTab(e){
      //console.log('ça clique sa mémé');
      e.preventDefault();
      e.stopPropagation();
      // active le bon lien dans le menu
      $entreesListe.removeClass('is-active'); // bruteforce
      $(this).closest('li').addClass('is-active');
      // rend visible le bon outil Flora Data
      var idOutil = $(this).attr('href'),
          outilChoisi = $(idOutil);
      $outils.each(function() {
        $(this).hide();
      });
      outilChoisi.show();
    }

    init();
  }

  return function(menuSelector, bodySelector){
    manageTabs(menuSelector, bodySelector);
  };

})();

$(document).ready(function(){
  Tela.epFloraData('#ep-flora-data-menu', '#ep-flora-data-tabs');
});
