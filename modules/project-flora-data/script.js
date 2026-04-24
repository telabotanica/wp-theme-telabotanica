var Tela = window.Tela || {};
Tela.modules = Tela.modules || {};

// Vanilla, simplified Flora Data module renderer
(function(){
  function module(menuSelector, bodySelector){
    var zoneMenu = document.querySelector(menuSelector);
    var zoneOutils = document.querySelector(bodySelector);
    if (!zoneMenu || !zoneOutils) return;

    var tabs = zoneMenu.querySelectorAll('a.toc-item-link');
    var entreesListe = zoneMenu.querySelectorAll('li.toc-item');
    var outils = zoneOutils.querySelectorAll('.ep-flora-data-tab');

    function init(){
      manageMenu();
      tabs.forEach(function(tab){ tab.addEventListener('click', changeTab); });
    }

    function manageMenu(){
      tabs.forEach(function(tab){
        var idOutil = tab.getAttribute('href');
        var outilPointe = document.querySelector(idOutil);
        if (!outilPointe){
          var li = tab.closest('li');
          if (li && li.parentNode) li.parentNode.removeChild(li);
        }
      });
      if (outils.length){
        var outilVisible = outils[0];
        var idOutilVisible = outilVisible.id;
        var lienMenu = Array.from(tabs).find(function(t){ return t.getAttribute('href') === '#' + idOutilVisible; });
        if (lienMenu && lienMenu.closest('li')) lienMenu.closest('li').classList.add('is-active');
      }
    }

    function changeTab(e){
      e.preventDefault();
      e.stopPropagation();
      entreesListe.forEach(function(li){ li.classList.remove('is-active'); });
      if (this.closest('li')) this.closest('li').classList.add('is-active');

      var idOutil = this.getAttribute('href');
      var outilChoisi = document.querySelector(idOutil);
      outils.forEach(function(o){ o.style.display = 'none'; });
      if (outilChoisi) outilChoisi.style.display = '';
    }

    init();
  }
  Tela.modules.epFloraData = (function(){
    return function(selector, menuSelector, bodySelector){
      Array.from(document.querySelectorAll(selector)).forEach(function(){ module(menuSelector, bodySelector); });
    };
  })();
})();

document.addEventListener('DOMContentLoaded', () => {
  Tela.modules.epFloraData('.project-flora-data', '#ep-flora-data-menu', '#ep-flora-data-tabs');
});
