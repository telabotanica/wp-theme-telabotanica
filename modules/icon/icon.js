/**
 * Icon template component
 * Replaces icon.pug
 */
module.exports = function(options) {
  const data = options.data || {};
  const icon = data.icon || '';
  const color = data.color ? ` icon-color-${data.color}` : '';
  const modifiers = `icon-${icon}${color}`;
  const href = `#icon-${icon}`;
  
  return `<svg class="icon ${modifiers}" aria-hidden="true" role="img"><use xlink:href="${href}"></use></svg>`;
};
