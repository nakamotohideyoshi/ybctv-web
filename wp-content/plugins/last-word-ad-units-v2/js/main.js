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

    var lhsHpu1 = $('.ads-lhs-hpu-1');
    var lhsHpu2 = $('.ads-lhs-hpu-2');
    var rhsSidebarContent = $('.sidebar-content-container');
    var rhsHpu1 = $('.ads-rhs-hpu-1');
    var rhsHpu2 = $('.ads-rhs-hpu-2');


    if (lhsHpu2.length) {
      setLhsHpu2Top($('#main').offset().top + ($('#main').outerHeight() / 2));
    }

    $(window).on('scroll', function() {
      stickyAds();
    });

    function stickyAds() {
      var headerHeight = $('#masthead').outerHeight();
      var billboardHeight = billboardFixed ? $('.ads-top-billboard-container').outerHeight() : 0;
      var topHeight = headerHeight + billboardHeight;
      var vPos = $(window).scrollTop() + headerHeight + billboardHeight;
      var sidebarHeight = $('.newsletter-wrapper').outerHeight() + $('.sidebar-content-wrapper').outerHeight();
      var mainTop = 0;
      var mainHeight = 0;
      var mainMiddle = 0;

      if ($('#main').length) {
        mainTop = $('#main').offset().top;
        mainHeight = $('#main').outerHeight();
        mainMiddle = mainTop + (mainHeight / 2);
      }

      var rhsSidebarContentHeight = rhsSidebarContent.outerHeight();
      if (lhsHpu1.length) {
        stickyLhsHpu1(vPos, mainMiddle, topHeight);
      }

      if (lhsHpu2.length) {
        stickyLhsHpu2(vPos, mainMiddle, topHeight);
      }

      if (rhsSidebarContent.length && rhsHpu1.length && (sidebarHeight < mainHeight)) {
        stickyRhsSidebarContent(vPos, mainMiddle, topHeight);
      }

      if (rhsHpu2.length && (sidebarHeight < mainHeight)) {
        stickyRhsHpu2(vPos, topHeight, mainTop, mainHeight);
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

    function stickyRhsSidebarContent(vPos, mainMiddle, topHeight) {
      var rhsSidebarContentParentTop = rhsSidebarContent.parent().offset().top;
      var rhsHpu1Height = rhsHpu1.outerHeight();

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

    function stickyRhsHpu2(vPos, topHeight, mainTop, mainHeight) {
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

    function setLhsHpu2Top(mainMiddle) {
      var lhsHpu2ParentTop = lhsHpu2.parent().offset().top;
      lhsHpu2.css({ 'position' : 'absolute', 'top' : mainMiddle - lhsHpu2ParentTop });
    }
  });
})(jQuery);
