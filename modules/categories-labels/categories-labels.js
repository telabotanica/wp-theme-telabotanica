/**
 * Categories Labels template component
 * Replaces categories-labels.pug
 */
module.exports = function(options) {
  const data = options.data || options;
  const items = data.items || [];
  
  const itemsHtml = items.map(item => 
    `<a href="${item.href || '#'}" rel="category" title="${item.text || ''}">${item.text || ''}</a>`
  ).join('');
  
  return `<span class="categories-labels">${itemsHtml}</span>`;
};
