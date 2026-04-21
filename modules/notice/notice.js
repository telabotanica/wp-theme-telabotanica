/**
 * Notice template component
 * Replaces notice.pug
 */
const iconTemplate = require('./icon');

module.exports = function(options) {
  const data = options.data || options;
  const type = data.type || 'info';
  const modifiers = ['notice', `notice-${type}`];
  
  if (data.closable) {
    modifiers.push('is-closable');
  }
  
  const title = data.title ? `<strong class="notice-title">${data.title}</strong> ` : '';
  const text = data.text || '';
  const closeButton = data.closable 
    ? `<button class="notice-close">${iconTemplate({data: {icon: 'close'}})}</button>`
    : '';
  
  return `
    <div class="${modifiers.join(' ')}">
      ${title}<span class="notice-text">${text}</span>
      ${closeButton}
    </div>
  `.trim();
};
