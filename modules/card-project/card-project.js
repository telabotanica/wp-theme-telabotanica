/**
 * Card Project template component
 * Replaces card-project.pug
 */
const iconTemplate = require('../icon/icon');

module.exports = function(options) {
  const data = options.data || options;
  const modifiers = data.modifiers || '';
  const coverStyle = `background-image: url(${data.cover_image_url || ''});`;
  
  const telaHtml = data.tela 
    ? `<div class="card-project-tela" title="${data.tela_title || ''}">${iconTemplate({data: {icon: 'tela-leaf'}})}</div>`
    : '';
  
  const metaHtml = data.meta && Array.isArray(data.meta)
    ? `<div class="card-project-meta">${data.meta.map(item => 
        `<span class="card-project-meta-item">${iconTemplate({data: {icon: item.icon}})}${item.text}</span>`
      ).join('')}</div>`
    : '';
  
  return `
    <div class="card-project ${modifiers}">
      <a class="card-project-link" href="${data.permalink || '#'}">
        <div class="card-project-cover" style="${coverStyle}">
          ${telaHtml}
          <img class="card-project-avatar" src="${data.avatar || ''}" alt="">
        </div>
        <div class="card-project-content">
          <h2 class="card-project-title"><span>${data.name || ''}</span></h2>
          <div class="card-project-description">${data.description || ''}</div>
        </div>
        ${metaHtml}
      </a>
    </div>
  `.trim();
};
