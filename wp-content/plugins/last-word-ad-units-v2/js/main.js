;
var billboardFixed = true;

function adSticky(event) {
  (function($) {
    // Top Billboard
    if (event.slot === billboard) {
      var timer = 8000;
      var topBillboard = $('.ads-top-billboard-container');
      var contentContainer = topBillboard.next('.container');

      if (topBillboard.outerHeight() > 0) {
        topBillboard.css({ 'position' : 'fixed' });
        contentContainer.css({ 'marginTop' : topBillboard.outerHeight() });
      }
      setTimeout(function () {
        topBillboard.css({ 'position' : 'relative' });
        contentContainer.css({ 'marginTop' : 0 });
        billboardFixed = false;
      }, timer);
    }
  })(jQuery);
}

(function($) {
  $(document).ready(function() {
    // Sidebar Ad Units
    var sidebarContentContainer = $('.sidebar-content-container');
    if (sidebarContentContainer.length) {
      var sidebarContentContainerTop = sidebarContentContainer.offset().top;

      $(window).on('scroll', function() {
        var headerHeight = $('#masthead').outerHeight();
        var billboardHeight = billboardFixed ? $('.ads-top-billboard-container').outerHeight() : 0;
        var vPos = $(window).scrollTop() + headerHeight + billboardHeight;

        if (sidebarContentContainer.css('position') === 'static') {
          sidebarContentContainerTop = sidebarContentContainer.offset().top;
        }

        var windowHeight = $(window).outerHeight();
        var mainTop = $('#main').offset().top;
        var mainHeight = $('#main').outerHeight();
        var mainMiddle = mainHeight / 1.7;

        if (vPos >= ((mainTop + mainMiddle) - windowHeight)) {
          if (sidebarContentContainer.css('position') != 'absolute') {
            sidebarContentContainer.css({ 'position' : 'absolute', 'top' : (sidebarContentContainer.offset().top - sidebarContentContainer.parent().offset().top) });
          }
          else {
            var rhsHpu2 = $('.ads-rhs-hpu-2');

            if ((vPos + rhsHpu2.outerHeight()) >= (mainTop + mainHeight)) {
              if (rhsHpu2.css('position') != 'absolute') {
                rhsHpu2.css({ 'position' : 'absolute', 'top' : ((mainTop + mainHeight) - rhsHpu2.outerHeight()) - rhsHpu2.parent().offset().top });
              }
            }
            else {
              var elementAbove = rhsHpu2.prev();

              if (vPos <= (elementAbove.offset().top + elementAbove.outerHeight())) {
                rhsHpu2.css({ 'position' : 'static', 'top' : 0 });
              }
              else {
                rhsHpu2.css({ 'position' : 'fixed', 'top' : headerHeight + billboardHeight });
              }
            }
          }
        }
        else {
          if (vPos >= sidebarContentContainerTop) {
            sidebarContentContainer.css({ 'position' : 'fixed', 'top' : headerHeight + billboardHeight });
          }
          else {
            sidebarContentContainer.css({ 'position' : 'static', 'top' : 0 });
          }
        }
      });
    }

    // Homepage Sidebar Ad Units
    var homeSidebarContentContainer = $('.home-sidebar-content-container');
    if (homeSidebarContentContainer.length) {
      var HomeSidebarContentContainerTop = homeSidebarContentContainer.offset().top;

      $(window).on('scroll', function() {
        var headerHeight = $('#masthead').outerHeight();
        var billboardHeight = billboardFixed ? $('.ads-top-billboard-container').outerHeight() : 0;
        var vPos = $(window).scrollTop() + headerHeight + billboardHeight;

        if (homeSidebarContentContainer.css('position') === 'static') {
          homeSidebarContentContainerTop = homeSidebarContentContainer.offset().top;
        }

        var windowHeight = $(window).outerHeight();
        var mediaTop = $('.media-row').offset().top;

        if (vPos >= mediaTop - windowHeight) {
          if (homeSidebarContentContainer.css('position') != 'absolute') {
            homeSidebarContentContainer.css({ 'position' : 'absolute', 'top' : (homeSidebarContentContainer.offset().top - homeSidebarContentContainer.parent().offset().top) });
          }
          else {
            var rhsHpu2 = $('.ads-rhs-hpu-2');
            var magazinesRow = $('.magazines-row');

            if ((vPos + rhsHpu2.outerHeight()) >= (magazinesRow.offset().top + magazinesRow.outerHeight())) {
              if (rhsHpu2.css('position') != 'absolute') {
                rhsHpu2.css({ 'position' : 'absolute', 'top' : ((magazinesRow.offset().top + magazinesRow.outerHeight()) - rhsHpu2.outerHeight()) - rhsHpu2.parent().offset().top });
              }
            }
            else {
              var elementAbove = rhsHpu2.prev();

              if (vPos <= (elementAbove.offset().top + elementAbove.outerHeight())) {
                rhsHpu2.css({ 'position' : 'static', 'top' : 0 });
              }
              else {
                rhsHpu2.css({ 'position' : 'fixed', 'top' : headerHeight + billboardHeight });
              }
            }
          }
        }
        else {
          if (vPos >= homeSidebarContentContainerTop) {
            homeSidebarContentContainer.css({ 'position' : 'fixed', 'top' : headerHeight + billboardHeight });
          }
          else {
            homeSidebarContentContainer.css({ 'position' : 'static', 'top' : 0 });
          }
        }
      });
    }

    // Left hand side article ad unit
    var leftHandSideAdUnit = $('.ads-placeholder-article-left');

    if (leftHandSideAdUnit.length) {
      $(window).on('scroll', function() {
        var headerHeight = $('#masthead').outerHeight();
        var billboardHeight = billboardFixed ? $('.ads-top-billboard-container').outerHeight() : 0;
        var vPos = $(window).scrollTop() + headerHeight + billboardHeight;
        var mainTop = $('#main').offset().top;
        var mainHeight = $('#main').outerHeight();

        if (vPos + leftHandSideAdUnit.outerHeight(true) >= (mainTop + mainHeight)) {
          if (leftHandSideAdUnit.css('position') != 'absolute') {
            leftHandSideAdUnit.css({ 'position' : 'absolute', 'top' : ((mainTop + mainHeight) - leftHandSideAdUnit.outerHeight(true)) - leftHandSideAdUnit.parent().offset().top });
          }
        }
        else {
          if (vPos >= leftHandSideAdUnit.parents().offset().top) {
            leftHandSideAdUnit.css({ 'position' : 'fixed', 'top' : headerHeight + billboardHeight });
          }
          else {
            leftHandSideAdUnit.css({ 'position' : 'static', 'top' : 0 });
          }
        }
      });
    }
  });
})(jQuery);
