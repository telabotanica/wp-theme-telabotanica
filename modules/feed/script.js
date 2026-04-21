import feedItemTemplate from './../feed-item/feed-item.js';

const Tela = window.Tela || {};
Tela.modules = Tela.modules || {};

function groupBy(array, key) {
  return array.reduce((acc, item) => {
    const k = item[key];
    if (!acc[k]) acc[k] = [];
    acc[k].push(item);
    return acc;
  }, {});
}

function sortByDateDesc(items) {
  return [...items].sort((a, b) => new Date(b.date) - new Date(a.date));
}

function maxBy(arr, key) {
  return arr.reduce((max, item) =>
    new Date(item[key]) > new Date(max[key]) ? item : max
  );
}

function escapeHtml(str = '') {
  return str
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;');
}

function formatDateFR(date) {
  return new Intl.DateTimeFormat('fr-FR', {
    dateStyle: 'medium'
  }).format(new Date(date));
}

Tela.modules.feed = (function () {
  function module(selector) {
    const el = document.querySelector(selector);
    if (!el) return;

    const content = el.querySelector('.feed-items');
    if (!content) return;

    const userId = el.dataset.userId;
    const siteUrl = el.dataset.siteUrl;

    const apiUrls = {
      observations: `https://api.tela-botanica.org/service:del:0.1/observations?navigation.depart=0&navigation.limite=50&tri=date_transmission&ordre=desc&masque.auteur=${userId}`,
      images: `https://api.tela-botanica.org/service:del:0.1/images?navigation.depart=0&navigation.limite=50&tri=date_transmission&ordre=desc&format=CRS&masque.auteur=${userId}`,
      actualites: `${siteUrl}/wp-json/wp/v2/posts?author=${userId}&_embed`
    };

    const data = { items: [] };
    const maxItems = 8;

    async function init() {
      const loader = document.createElement('div');
      loader.className = 'feed-loading';
      loader.textContent = 'Chargement...';
      content.before(loader);

      try {
        await Promise.all([loadActualites(), loadObservations(), loadImages()]);
        renderContent();
      } catch (e) {
        content.before(document.createTextNode('Erreur lors du chargement du flux.'));
      } finally {
        loader.remove();
      }
    }

    async function loadActualites() {
      const res = await fetch(apiUrls.actualites);
      const json = await res.json();

      json.forEach((item) => {
        const categories =
          item._embedded?.['wp:term']?.[0]?.map((t) => t.name) || [];

        data.items.push({
          article: true,
          href: item.link,
          image:
            item._embedded?.['wp:featuredmedia']?.[0]?.media_details?.sizes
              ?.thumbnail?.source_url || false,
          title: escapeHtml(item.title.rendered),
          date: item.modified,
          day: item.modified.slice(0, 10),
          text: item.excerpt.rendered,
          meta: {
            text: categories.join(', ')
          }
        });
      });
    }

    async function loadObservations() {
      const res = await fetch(apiUrls.observations);
      const json = await res.json();

      json.resultats.forEach((item) => {
        data.items.push({
          href: `http://www.tela-botanica.org/appli:identiplante#obs~${item.id_observation}`,
          target: '_blank',
          image: item.images?.length
            ? item.images[0]['binaire.href'].replace('XL.', 'CRXS.')
            : false,
          title: item['determination.ns'],
          date: item.date_transmission,
          day: item.date_transmission.slice(0, 10),
          text: 'Nouvelle observation ajoutée au Carnet en Ligne',
          meta: {
            place: item.zone_geo
          }
        });
      });
    }

    async function loadImages() {
      const res = await fetch(apiUrls.images);
      const json = await res.json();

      const images = json.resultats.map((item) => {
        const date = item.observation.date_transmission;
        return {
          date,
          day: date.slice(0, 10),
          image: item['binaire.href']
        };
      });

      const grouped = groupBy(images, 'day');

      Object.entries(grouped).forEach(([day, items]) => {
        data.items.push({
          href: 'http://www.tela-botanica.org/appli:cel',
          target: '_blank',
          images: items.slice(0, maxItems).map((i) => i.image),
          title: `${items.length} photo${items.length > 1 ? 's' : ''} ajoutée${
            items.length > 1 ? 's' : ''
          }`,
          date: maxBy(items, 'date').date,
          day,
          text: 'Au Carnet en Ligne',
          meta: { text: '' }
        });
      });
    }

    function renderContent() {
      const sorted = sortByDateDesc(data.items);

      const grouped = groupBy(sorted, 'day');

      const flat = [];

      Object.keys(grouped).forEach((day) => {
        flat.push({
          date: formatDateFR(grouped[day][0].date)
        });
        flat.push(...grouped[day]);
      });

      content.innerHTML = flat
        .map((item) => feedItemTemplate({ data: item }))
        .join('');
    }

    init();
  }

  return function (selector) {
    document.querySelectorAll(selector).forEach((el) => module(el));
  };
})();

document.addEventListener('DOMContentLoaded', () => {
  Tela.modules.feed('.feed');
});
