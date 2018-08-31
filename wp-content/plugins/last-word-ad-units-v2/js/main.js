;
// var billboardFixed = true;
var billboardFixed = false;

function adSticky(event) {
  (function($) {
    // Top Billboard
    // if (event.slot === billboard) {
    //   var timer = 8000;
    //   var topBillboard = $('.ads-top-billboard-container');
    //   var contentContainer = topBillboard.next('.container');
    //
    //   if (topBillboard.outerHeight() > 0) {
    //     topBillboard.css({ 'position' : 'fixed' });
    //     contentContainer.css({ 'marginTop' : topBillboard.outerHeight() });
    //   }
    //   setTimeout(function () {
    //     topBillboard.css({ 'position' : 'relative' });
    //     contentContainer.css({ 'marginTop' : 0 });
    //     billboardFixed = false;
    //   }, timer);
    // }
  })(jQuery);
}

(function($) {
  $(document).ready(function() {
    var rhsSidebarContent = $('.sidebar-content-container');
    var rhsHomeSidebarContent = $('.home-sidebar-content-container');
    var main = $('[role="main"]');
    var lhsHpu1 = $('.ads-lhs-hpu-1');
    var lhsHpu2 = $('.ads-lhs-hpu-2');
    var rhsHpu1 = $('.ads-rhs-hpu-1');
    var rhsHpu2 = $('.ads-rhs-hpu-2');


    if (lhsHpu2.length) {
      setLhsHpu2Top(main.offset().top + (main.outerHeight() / 2));
    }

    $(window).on('scroll', function() {
      stickyAds();
    });

    function stickyAds() {
      var headerHeight = $('#masthead').outerHeight();
      var billboardHeight = billboardFixed ? $('.ads-top-billboard-container').outerHeight() : 0;
      var topHeight = headerHeight + billboardHeight;
      var vPos = $(window).scrollTop() + headerHeight + billboardHeight;
      var mainTop = 0;
      var mainHeight = 0;
      var mainMiddle = 0;
      var newsletter = $('.newsletter-wrapper');
      var newsletterHeight = newsletter.outerHeight();

      if (main.length) {
        mainTop = main.offset().top;
        mainHeight = main.outerHeight();
        mainMiddle = mainTop + (mainHeight / 2);
      }


      // ** Home page RHS
      if (rhsHomeSidebarContent.length) {
        var mediaTop = $('.media-row').offset().top;

        stickyRhsHomeSidebarContent(vPos, topHeight, mediaTop);

        if (rhsHpu2.length) {
          stickyHomeRhsHpu2(vPos, topHeight, mainTop, mainHeight);
        }
      }

      // ** Articles and other pages
      // Left hand HPU 1 & 2
      if (lhsHpu1.length) {
        stickyLhsHpu1(vPos, mainMiddle, topHeight);
      }

      if (lhsHpu2.length) {
        stickyLhsHpu2(vPos, mainMiddle, topHeight);
      }

      // Right hand HPU 1
      if (rhsSidebarContent.length && rhsHpu1.length && (rhsSidebarContent.outerHeight() < mainHeight)) {
        stickyRhsSidebarContent(vPos, mainTop, mainHeight, mainMiddle, topHeight);
      }
    }

    function stickyRhsHomeSidebarContent(vPos, topHeight, mediaTop) {
      var rhsHomeSidebarContentParentTop = rhsHomeSidebarContent.parent().offset().top;
      var rhsHpu1Height = rhsHpu1.outerHeight();

      if (vPos >= rhsHomeSidebarContentParentTop) {
        if (vPos + rhsHpu1Height >= mediaTop) {
          rhsHomeSidebarContent.css({ 'position' : 'absolute', 'top' : mediaTop - rhsHpu1Height - rhsHomeSidebarContentParentTop });
        }
        else {
          rhsHomeSidebarContent.css({ 'position' : 'fixed', 'top' : topHeight });
        }
      }
      else {
        rhsHomeSidebarContent.css({ 'position' : 'static', 'top' : 0 });
      }
    }

    function stickyHomeRhsHpu2(vPos, topHeight, mainTop, mainHeight) {
      var rhsHpu2Top = rhsHpu2.offset().top;
      var rhsHpu2Height = rhsHpu2.outerHeight();
      var rhsHpu2PrevTop = rhsHpu2.prev().offset().top;
      var rhsHpu2PrevHeight = rhsHpu2.prev().outerHeight();
      var rhsHpu2ParentTop = rhsHpu2.parent().offset().top;

      if (vPos >= (rhsHpu2PrevTop + rhsHpu2PrevHeight)) {
        if ((vPos + rhsHpu2Height) >= (mainTop + mainHeight)) {
          rhsHpu2.css({ 'position' : 'absolute', 'top' : (mainTop + mainHeight) - rhsHpu2Height - rhsHpu2ParentTop });
        }
        else {
          rhsHpu2.css({ 'position' : 'fixed', 'top' : topHeight });
        }
      }
      else {
        rhsHpu2.css({ 'position' : 'static', 'top' : 0 });
      }
    }

    function stickyRhsSidebarContent(vPos, mainTop, mainHeight, mainMiddle, topHeight) {
      var rhsSidebarContentTop = rhsSidebarContent.offset().top;
      var rhsSidebarContentHeight = rhsSidebarContent.outerHeight();
      var rhsSidebarContentParentTop = rhsSidebarContent.parent().offset().top;
      var rhsHpu1Height = rhsHpu1.outerHeight();


      if (vPos >= (mainHeight + mainTop) - rhsSidebarContentHeight) {
        if (rhsSidebarContent.css('position') != 'absolute') {
          rhsSidebarContent.css({ 'position' : 'absolute', 'top' : (mainHeight + mainTop) - (rhsSidebarContentHeight +  rhsSidebarContentParentTop) });
        }
      }
      else {
        if (vPos >= rhsSidebarContentParentTop) {
          if (vPos + rhsHpu1Height >= mainMiddle) {
            rhsSidebarContent.css({ 'position' : 'absolute', 'top' : mainMiddle - rhsHpu1Height - rhsSidebarContentParentTop });
          }
          else {
            rhsSidebarContent.css({ 'position' : 'fixed', 'top' : topHeight });
          }
        }
        else {
          rhsSidebarContent.css({ 'position' : 'static', 'top' : 0 });
        }
      }

    }

    function stickyLhsHpu1(vPos, mainMiddle, topHeight) {
      var lhsHpu1Height = lhsHpu1.outerHeight(true);
      var lhsHpu1ParentTop = lhsHpu1.parent().offset().top;

      if (vPos >= lhsHpu1ParentTop) {
        if ((vPos + lhsHpu1Height) >= mainMiddle) {
          lhsHpu1.css({ 'position' : 'absolute', 'top' : mainMiddle - lhsHpu1Height - lhsHpu1ParentTop });
        }
        else {
          lhsHpu1.css({ 'position' : 'fixed', 'top' : topHeight });
        }
      }
      else {
        lhsHpu1.css({ 'position' : 'static', 'top' : 0 });
      }
    }

    function stickyLhsHpu2(vPos, mainMiddle, topHeight) {
      var lhsHpu2Height = lhsHpu2.outerHeight(true);
      var lhsHpu2ParentTop = lhsHpu2.parent().offset().top;
      var lhsHpu2ParentHeight = lhsHpu2.parent().outerHeight();

      if (vPos >= mainMiddle) {
        if ((vPos + lhsHpu2Height) >= (lhsHpu2ParentHeight + lhsHpu2ParentTop)) {
          lhsHpu2.css({ 'position' : 'absolute', 'top' : lhsHpu2ParentHeight - lhsHpu2Height });
        }
        else {
          lhsHpu2.css({ 'position' : 'fixed', 'top' : topHeight });
        }
      }
      else {
        setLhsHpu2Top(mainMiddle);
      }
    }

    function setLhsHpu2Top(mainMiddle) {
      var lhsHpu2ParentTop = lhsHpu2.parent().offset().top;
      lhsHpu2.css({ 'position' : 'absolute', 'top' : mainMiddle - lhsHpu2ParentTop });
    }
  });
})(jQuery);
