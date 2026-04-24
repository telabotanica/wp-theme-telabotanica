document.addEventListener('DOMContentLoaded', () => {
  // Responsive tweaks on home page
  if (document.body.classList.contains('home-page')) {
    if (matchMedia('only screen and (max-width: 767.9px)').matches) {
      // Move tools after the latest articles
      var tools = document.querySelector('#js-front-page-tools');
      var parentWrapper = tools ? tools.closest('.layout-wrapper') : null;
      if (tools && parentWrapper) {
        parentWrapper.appendChild(tools);
      }

      // Invert order of blocks list projects and focus
      var blockListProjects = document.querySelectorAll('.block-list-projects');
      if (blockListProjects.length > 0) {
        var bp = blockListProjects[0];
        var prev = bp.previousElementSibling;
        if (prev && prev.classList.contains('block-focus')) {
          prev.parentNode.insertBefore(bp, prev);
        }
      }
    }
  }

  // Responsive tweaks on archive page
  if (document.body.classList.contains('archive')) {
    if (matchMedia('only screen and (max-width: 767.9px)').matches) {
      var secondaryElements = document.querySelectorAll('.js-archive-page-secondary');
      var layoutContent = document.querySelector('.list-articles')?.closest('.layout-content');
      if (secondaryElements.length && layoutContent) {
        var container = document.createElement('aside');
        container.className = 'layout-column';
        secondaryElements.forEach(function(el){ container.appendChild(el); });
        layoutContent.parentNode.insertBefore(container, layoutContent.nextSibling);
      }
    }
  }
});
