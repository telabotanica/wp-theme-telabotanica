/**
 * Search Hit template component
 * Replaces search-hit.pug
 */
const listArticlesItemTemplate = require('../list-articles-item/list-articles-item');
const cardProjectTemplate = require('../card-project/card-project');

function searchHitActualites(data) {
  const itemData = {
    modifiers: data.post_classes,
    id: data.post_id,
    href: data.permalink,
    title: data._highlightResult?.post_title?.value || '',
    text: data._snippetResult?.post_content?.value || '',
    thumbnail_url: data.thumbnail,
    date: {
      title: data.post_date?.formatted || '',
      datetime: data.post_date?.datetime || '',
      text: data.post_date?.text || '',
    },
    author: {
      prefix: 'par',
      text: data.post_author?.display_name || '',
      href: data.post_author?.permalink || '',
    },
    categories: data.category_links || [],
  };
  return `<div class="search-hit">${listArticlesItemTemplate({data: itemData})}</div>`;
}

function searchHitEvenements(data) {
  const itemData = {
    modifiers: data.post_classes,
    id: data.post_id,
    href: data.permalink,
    title: data._highlightResult?.post_title?.value || '',
    text: data._snippetResult?.post_content?.value || '',
    thumbnail_url: data.thumbnail,
    date: {
      title: data.post_date?.formatted || '',
      datetime: data.post_date?.datetime || '',
      text: data.post_date?.text || '',
    },
    author: {
      prefix: 'par',
      text: data.post_author?.display_name || '',
      href: data.post_author?.permalink || '',
    },
    categories: data.category_links || [],
    event: true,
    dates: {
      start: data.event_date,
      end: data.event_date_end || null,
    },
    place: data.event_place?.formatted || '',
  };
  return `<div class="search-hit">${listArticlesItemTemplate({data: itemData})}</div>`;
}

function searchHitFlore(data) {
  const referentiel = data.bdtfx ? 'bdtfx' : (data.referentiels ? data.referentiels[0] : '');
  const title = data._highlightResult?.[referentiel]?.scientific_name?.value || '';
  const suffix = data[referentiel]?.year ? `[${data[referentiel].year}]` : '';
  const href = data[referentiel]?.permalink || '#';
  const noms = data._highlightResult?.[referentiel]?.common_name || [];
  const synonyms = data._highlightResult?.[referentiel]?.synonyms || [];
  
  let nomsHtml = '';
  if (noms && noms.length > 0) {
    const nomsTxt = noms.map(n => n.value).join(', ');
    nomsHtml = `<div class="search-hit-text"><h6 class="search-hit-name">${nomsTxt}</h6></div>`;
  }
  
  let synonymsHtml = '';
  if (synonyms && synonyms.length > 0) {
    const firstSynonyms = synonyms.slice(0, 2);
    const diffSynonyms = synonyms.length - firstSynonyms.length;
    const synItems = firstSynonyms.map(s => `<li class="search-hit-synonyms-item"><strong>syn.</strong> ${s.value}</li>`).join('');
    const diffHtml = diffSynonyms > 1 
      ? `<li class="search-hit-synonyms-item">+ ${diffSynonyms} autres synonymes</li>`
      : diffSynonyms === 1
      ? `<li class="search-hit-synonyms-item">+ un autre synonyme</li>`
      : '';
    synonymsHtml = `<ul class="search-hit-synonyms">${synItems}${diffHtml}</ul>`;
  }
  
  let imagesHtml = '';
  if (data[referentiel]?.thumbnails) {
    const thumbs = data[referentiel].thumbnails;
    if (thumbs.coste) {
      imagesHtml += `<img class="search-hit-image search-hit-image-coste" src="${thumbs.coste}" alt="${title} (illustration de Coste)">`;
    }
    if (thumbs.cel) {
      Object.entries(thumbs.cel).forEach(([organe, src]) => {
        imagesHtml += `<img class="search-hit-image search-hit-image-cel-${organe}" src="${src}" alt="${title} - ${organe} (image CeL)">`;
      });
    }
    if (thumbs.chorodep) {
      imagesHtml += `<img class="search-hit-image search-hit-image-chorodep" src="${thumbs.chorodep}" alt="${title} (carte de répartition Chorodep)">`;
    }
  }
  
  const refTags = data.referentiels ? data.referentiels.map(ref => 
    `<a class="search-hit-tag search-hit-tag-${ref}" href="${data[ref]?.permalink || '#'}">${ref}</a>`
  ).join('') : '';
  
  return `
    <div class="search-hit">
      <h3 class="search-hit-title">
        <a href="${href}">${title}${suffix ? `<span class="search-hit-title-suffix"> ${suffix}</span>` : ''}</a>
        ${refTags}
      </h3>
      ${nomsHtml}
      ${synonymsHtml}
      <div class="search-hit-images">${imagesHtml}</div>
    </div>
  `.trim();
}

function searchHitVegetation(data) {
  const title = data._highlightResult?.syntaxon?.value || '';
  const href = data.permalink || '#';
  const text = data._highlightResult?.commonName?.value || '';
  
  return `
    <div class="search-hit">
      <h3 class="search-hit-title"><a href="${href}">${title}</a></h3>
      ${text ? `<div class="search-hit-text">${text}</div>` : ''}
    </div>
  `.trim();
}

function searchHitProjets(data) {
  const itemData = {
    permalink: data.permalink,
    cover_image_url: data.cover_image,
    tela: data.tela,
    tela_title: 'Un projet Tela Botanica',
    avatar: data.image,
    name: data.name,
    description: data.description,
    meta: [
      {icon: 'members', text: data.member_count}
    ]
  };
  return cardProjectTemplate({data: itemData});
}

module.exports = function(options) {
  const data = options.data || options;
  const type = data.type || '';
  
  switch(type) {
    case 'actualites':
      return searchHitActualites(data);
    case 'evenements':
      return searchHitEvenements(data);
    case 'flore':
      return searchHitFlore(data);
    case 'vegetation':
      return searchHitVegetation(data);
    case 'projets':
      return searchHitProjets(data);
    default:
      return '';
  }
};
