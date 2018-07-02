var _ = _ || {};
_.defer = require('lodash.defer');
_.each = require('lodash.foreach');
_.map = require('lodash.map');
_.throttle = require('lodash.throttle');

var Tela = window.Tela || {};
Tela.modules = Tela.modules || {};

Tela.modules.toc = (function(){

  var defaultOptions = {
    accordionsSelector: '.component-accordion',
    anchorsSelector: '.component-title.level-2 .component-title-anchor',
    anchorOffset: 40 // should be the same as $title-anchor-offset in component title style
  };

  function module(selector, userOptions){
    var $el = $(selector),
      options = $.extend({}, defaultOptions, userOptions),
      items,
      headerHeight,
      currentItemId,
      $articleContainer,
      $anchors;

    function init(){
      headerHeight = $('.header-nav').height();

      $articleContainer = $('.layout-content article');
      $accordions = $articleContainer.find(options.accordionsSelector);
      $anchors = $articleContainer.find(options.anchorsSelector);

      if ($anchors.length) {
        _.defer(parseItems);
        $(window).on('scroll', _.throttle(onScroll, 250));
      }

      if ($accordions.length) {
        // Monitor changes to article height (when an accordion is open/closed)
        onElementHeightChange($articleContainer[0], parseItems);
      }
    }

    function initOptions() {
      $.each($el.data(), function(key, value){
        options[key] = value;
      });
    }

    function parseItems() {
      items = _.map($anchors, function(anchor, index) {
        var $anchor = $(anchor);
        return {
          id: $anchor.attr('name'),
          top: Math.round($anchor.offset().top + options.anchorOffset)
        };
      });

      _.each(items, function (item, index, list) {
        item.bottom = (list[index+1]) ?
          list[index+1].top :
          Math.round($articleContainer.position().top + $articleContainer.height());
      });

      onScroll();
    }

    function onScroll() {
      var scrollTop = $(window).scrollTop();

      _.each(items, function (item, index, list) {
        if (scrollTop > item.top - headerHeight
         && scrollTop < item.bottom - headerHeight
         && currentItemId != item.id) {
          currentItemId = item.id;
          $el.find('.toc-subitem').removeClass('is-active');
          $el.find('a[href="#' + item.id + '"]').closest('.toc-subitem').addClass('is-active');
        }
      });
    }

    function onElementHeightChange(elm, callback){
      var lastHeight = elm.clientHeight, newHeight;

      (function run(){
          newHeight = elm.clientHeight;
          if (lastHeight != newHeight) callback();
          lastHeight = newHeight;

          if (elm.onElementHeightChangeTimer) clearTimeout(elm.onElementHeightChangeTimer);

          elm.onElementHeightChangeTimer = setTimeout(run, 500);
      })();
    }

    initOptions();
    init();

    return $el;
  }

  return function(selector, userOptions){
    return $(selector).each(function(){
      module(this, userOptions);
    });
  };

})();

$(document).ready(function(){
  Tela.modules.toc('.toc');
});
