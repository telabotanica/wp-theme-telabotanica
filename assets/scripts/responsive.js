$(document).ready(function(){
  // Responsive tweaks on home page
  if ($("body").hasClass("home-page")) {
    // On mobile only
    if (matchMedia('only screen and (max-width: 767.9px)').matches) {
      // Move tools after the latest articles
      var $tools = $("#js-front-page-tools");
      var $parentWrapper = $tools.closest(".layout-wrapper");
      if ($tools.length && $parentWrapper.length) {
        $tools.appendTo($parentWrapper);
      }

      // Invert order of blocks list projects and focus
      var $blockListProjects = $(".block-list-projects");
      var $blockFocus = $blockListProjects.prev(".block-focus");
      if ($blockListProjects.length && $blockFocus.length) {
        $blockListProjects.insertBefore($blockFocus);
      }
    }
  }

  // Responsive tweaks on archive page
  if ($("body").hasClass("archive")) {
    // On mobile only
    if (matchMedia('only screen and (max-width: 767.9px)').matches) {
      // Move column content to the end
      var $secondaryElements = $(".js-archive-page-secondary");
      var $layoutContent = $(".list-articles").closest(".layout-content");
      if ($secondaryElements.length && $layoutContent.length) {
        var $container = $('<aside class="layout-column"></div>');
        $container.append($secondaryElements);
        $container.insertAfter($layoutContent);
      }
    }
  }
});
