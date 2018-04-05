var Tela = window.Tela || {};
Tela.modules = Tela.modules || {};

Tela.modules.membersDirectory = (function() {

  function module(selector) {
    var $el = $(selector),
      $pays,
      $departement,
      $departementSelect;

    function init() {
      $pays = $el.find('#field_3');
      $departement = $el.find('.field_departement');
      $departementSelect = $departement.find('#field_592');

      departementToggle($pays, $departement);

      $pays.change(function() {
        departementToggle($(this), $departement);
      });
    }

    function departementToggle($pays, $departement) {
      // only 'France' has departements
      if ($pays.val() === 'France') {
        $departement.show();
      } else {
        $departement.hide();
        $departementSelect.val('');
      }
    }

    init();
  }

  return function(selector) {
    return $(selector).each(function() {
        module(this);
    });
  };
})();


$(document).ready(function() {
  Tela.modules.membersDirectory('#bps_directory24437');
});
