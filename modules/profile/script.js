(function () {
  var Tela = window.Tela || {};
  Tela.modules = Tela.modules || {};

  function debounce(fn, wait = 300) {
    let timeout;
    return function (...args) {
      clearTimeout(timeout);
      timeout = setTimeout(() => fn.apply(this, args), wait);
    };
  }

  Tela.modules.profile = (function () {
    function module(selector) {
      const el = document.querySelector(selector);
      if (!el) return;

      let inputVille, inputEspece, departement, pays;

      function init() {
        initAutocompleteVille();
        initAutocompleteEspece();
        initRestrictionDepartements();
      }

      function initAutocompleteVille() {
        inputVille = el.querySelector('.field_ville input[type="text"]');
        if (!inputVille) return;

        inputVille.addEventListener(
          'input',
          debounce(function () {
            const query = inputVille.value;
            if (query.length < 3) return;

            fetch(
              'https://api.tela-botanica.org/service:eflore:0.1/osm/zone-admin/?pays=FR&masque=' +
              encodeURIComponent(query) +
              '%&limite=20'
            )
              .then((r) => r.json())
              .then((data) => {
                // TODO: handle results
              });
          }, 300)
        );
      }

      function initAutocompleteEspece() {
        inputEspece = el.querySelector(
          '.field_espece-dinteret input[type="text"]'
        );
        if (!inputEspece) return;

        inputEspece.addEventListener(
          'input',
          debounce(function () {
            const query = inputEspece.value;
            if (query.length < 3) return;

            fetch(
              'https://api.tela-botanica.org/service:eflore:0.1/bdtfx/noms?masque=' +
              encodeURIComponent(query) +
              '%&retour.format=min&navigation.limite=20&ns.structure=au&retour.tri=alpharet&retour.structure=liste'
            )
              .then((r) => r.json())
              .then((data) => {
                // TODO: handle results
              });
          }, 300)
        );
      }

      function initRestrictionDepartements() {
        pays = el.querySelector('.field_pays > select');
        departement = el.querySelector('.field_departement');

        linkPaysDepartement();

        if (pays) pays.addEventListener('change', linkPaysDepartement);
      }

      function linkPaysDepartement() {
        if (pays && pays.value === 'France') {
          if (departement) departement.style.display = 'block';
        } else {
          if (departement) {
            departement.style.display = 'none';

            departement
              .querySelectorAll('select')
              .forEach((s) => (s.value = ''));
          }
        }
      }

      init();
    }

    return function (selector) {
      document.querySelectorAll(selector).forEach((el) => module(el));
    };
  })();

  document.addEventListener('DOMContentLoaded', function () {
    Tela.modules.profile(
      '#profile-edit-form, #profile-details-section'
    );
  });
})();
