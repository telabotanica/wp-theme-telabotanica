require('matchmedia-polyfill');

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
});
