/**
 * List Articles Item template component
 * Replaces list-articles-item.pug
 */
const categoriesLabelsTemplate = require('../categories-labels/categories-labels');
const eventDatesTemplate = require('../event-dates/event-dates');
const iconTemplate = require('../icon/icon');

module.exports = function(options) {
  const data = options.data || options;
  const modifiers = data.modifiers || '';
  const id = data.id ? `id="post-${data.id}"` : '';
  
  // Build dates section if event with dates
  let datesHtml = '';
  if (data.event && data.dates) {
    datesHtml = eventDatesTemplate({
      data: {
        href: data.href,
        start: data.dates.start,
        end: data.dates.end,
        title: data.dates.title,
        modifiers: 'float-left'
      }
    });
  } else {
    // Build image
    let imageContent = '';
    if (data.thumbnail_url) {
      imageContent = `<img class="list-articles-item-image" src="${data.thumbnail_url}" alt="">`;
    } else if (data.thumbnail) {
      imageContent = data.thumbnail;
    }
    datesHtml = `<a class="list-articles-item-image" href="${data.href || '#'}">${imageContent}</a>`;
  }
  
  // Build place
  let placeHtml = '';
  if (data.event && data.place) {
    placeHtml = `<span class="list-articles-item-place">${iconTemplate({data: {icon: 'marker'}})}${data.place}</span>`;
  }
  
  // Build date
  let dateHtml = '';
  if (data.date) {
    dateHtml = `
      <span class="list-articles-item-date" title="${data.date.title || ''}">
        ${iconTemplate({data: {icon: 'clock'}})}
        <time datetime="${data.date.datetime || ''}">${data.date.text || ''}</time>
      </span>
      <span> – </span>
    `;
  }
  
  // Build author
  let authorHtml = '';
  if (data.author) {
    authorHtml = `
      <span class="list-articles-item-author">
        ${data.author.prefix || ''} <a href="${data.author.href || '#'}">${data.author.text || ''}</a>
      </span>
    `;
  }
  
  // Build categories
  let categoriesHtml = '';
  if (data.categories) {
    categoriesHtml = categoriesLabelsTemplate({data: {items: data.categories}});
  }
  
  const metaHtml = `
    <div class="list-articles-item-meta">
      ${placeHtml}${dateHtml}${authorHtml}${categoriesHtml}
    </div>
  `;
  
  return `
    <article class="list-articles-item ${modifiers}" ${id}>
      ${datesHtml}
      <div class="list-articles-item-text">
        ${metaHtml}
        <h2 class="list-articles-item-title">
          <a href="${data.href || '#'}" rel="bookmark">${data.title || ''}</a>
        </h2>
        ${data.text || ''}
      </div>
    </article>
  `.trim();
};
