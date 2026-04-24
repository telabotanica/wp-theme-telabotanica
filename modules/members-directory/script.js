var Tela = window.Tela || {};
Tela.modules = Tela.modules || {};

Tela.modules.membersDirectory = (function() {
  function module(el) {
    var container = el;
    var paysEl;
    var departementEl;
    var departementSelect;

    function init(){
      paysEl = container.querySelector('#field_3');
      departementEl = container.querySelector('.field_departement');
      departementSelect = departementEl ? departementEl.querySelector('#field_592') : null;
      departementToggle(paysEl, departementEl);
      if (paysEl){
        paysEl.addEventListener('change', function(){ departementToggle(paysEl, departementEl); });
      }
    }

    function departementToggle(paysEl, departementEl) {
      if (!paysEl) return;
      if (paysEl.value === 'France') {
        departementEl && (departementEl.style.display = '');
      } else {
        if (departementEl) departementEl.style.display = 'none';
        if (departementSelect) departementSelect.value = '';
      }
    }

    init();
  }

  return function(selector) {
    Array.from(document.querySelectorAll(selector)).forEach(function(el){
      module(el);
    });
  };
})();

document.addEventListener('DOMContentLoaded', function(){
  Tela.modules.membersDirectory('#bps_directory24437');
});
