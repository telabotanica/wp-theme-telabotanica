/**
 * Feed Item template component
 * Replaces feed-item.pug
 */
const iconTemplate = require('../icon/icon');

module.exports = function(options) {
  const data = options.data || options;
  const modifiers = ['feed-item'];
  
  if (data.date && !data.text) modifiers.push('is-date');
  if (data.image) modifiers.push('has-image');
  if (data.images) modifiers.push('has-images');
  if (data.href) modifiers.push('has-link');
  if (data.article) modifiers.push('is-article');
  if (data.text && !data.image && !data.title && !data.meta && !data.href) modifiers.push('has-only-text');
  
  // Build image HTML
  let imageHtml = '';
  if (data.image) {
    if (data.article) {
      imageHtml = `<div class="feed-item-image" style="background-image: url(${data.image})">${iconTemplate({data: {icon: 'news'}})}</div>`;
    } else {
      imageHtml = `<img class="feed-item-image" src="${data.image}" alt="">`;
    }
  }
  
  // Build images gallery HTML
  let imagesHtml = '';
  if (data.images && Array.isArray(data.images)) {
    const imgs = data.images.map(img => `<img src="${img}" alt="">`).join('');
    imagesHtml = `<div class="feed-item-images">${imgs}</div>`;
  }
  
  // Build title
  const titleHtml = data.title ? `<h3 class="feed-item-title">${data.title}</h3>` : '';
  
  // Build text or date
  let textHtml = '';
  if (data.text) {
    textHtml = `<div class="feed-item-text">${data.text}</div>`;
  } else if (data.date) {
    textHtml = `<div class="feed-item-text">${iconTemplate({data: {icon: 'clock'}})} ${data.date}</div>`;
  }
  
  // Build meta
  let metaHtml = '';
  if (data.meta) {
    const placeHtml = data.meta.place ? `<span class="feed-item-meta-place">${data.meta.place}</span>${iconTemplate({data: {icon: 'marker'}})}` : '';
    const metaText = data.meta.text ? data.meta.text : '';
    metaHtml = `<div class="feed-item-meta">${placeHtml}${metaText}</div>`;
  }
  
  // Build content wrapper
  const content = `${imageHtml}${imagesHtml}${titleHtml}${textHtml}${metaHtml}`;
  
  // Build link wrapper if href exists
  const linkWrapper = data.href 
    ? `<a class="feed-item-link" href="${data.href}" ${data.target ? `target="${data.target}"` : ''}>${content}</a>`
    : content;
  
  return `<div class="${modifiers.join(' ')}">${linkWrapper}</div>`;
};
