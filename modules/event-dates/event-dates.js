/**
 * Event Dates template component
 * Replaces event-dates.pug
 */
module.exports = function(options) {
  const data = options.data || options;
  const tag = data.href ? 'a' : 'div';
  const modifiers = data.modifiers ? ` ${data.modifiers}` : '';
  const href = data.href ? ` href="${data.href}"` : '';
  const title = data.title ? ` title="${data.title}"` : '';
  
  let startHtml = '';
  if (data.start) {
    startHtml = `
      <time class="event-dates-item" datetime="${data.start.datetime || ''}">
        <div class="event-dates-day">${data.start.day || ''}</div>
        <div class="event-dates-month">${data.start.month || ''}</div>
      </time>
    `;
  }
  
  let endHtml = '';
  if (data.end) {
    endHtml = `
      <time class="event-dates-item is-end" datetime="${data.end.datetime || ''}">
        <div class="event-dates-day">${data.end.day || ''}</div>
        <div class="event-dates-month">${data.end.month || ''}</div>
      </time>
    `;
  }
  
  return `<${tag} class="event-dates${modifiers}"${href}${title}>${startHtml}${endHtml}</${tag}>`;
};
