(function($) {
  $(document).ready(function() {
    $('.flexslider-spon').flexslider({
      animation: "slide",
      controlNav: true,
      start: function(slider) {
        var currSlideHeight = $('.slides > li').eq(slider.currentSlide).outerHeight(true);
        $('.flexslider').height(currSlideHeight);

        var contentDesHeight = 0;
        var flexControlNavHeight = $('.flex-control-nav').outerHeight();

        var contentDesElements = $('.slides').find('.content-des');
        contentDesElements.each(function() {
          if ($(this).height() > contentDesHeight) {
            contentDesHeight = $(this).outerHeight();
          }
          console.log(contentDesHeight);
        });
        contentDesElements.css('height', contentDesHeight + flexControlNavHeight);
      }
    });
  }); // End document ready
})(this.jQuery);

jQuery(function($) {
    'use strict';

    // Set content div margin top to match header height
    function addContentMargin() {
        $('#content').css({ 'marginTop': $('#masthead').outerHeight(), 'paddingTop': 0 });
        console.log($('.site-content').css('marginTop'));
    }
    $(document).ready(addContentMargin());
    $(window).resize(addContentMargin());

    // here for each comment reply link of wordpress
    $('.comment-reply-link').addClass('btn btn-primary');

    // here for the submit button of the comment reply form
    $('#commentsubmit').addClass('btn btn-primary');

    // The WordPress Default Widgets
    // Now we'll add some classes for the wordpress default widgets - let's go

    // the search widget
    $('.widget_search input.search-field').addClass('form-control');
    $('.widget_search input.search-submit').addClass('btn btn-default');
    $('.variations_form .variations .value > select').addClass('form-control');
    $('.widget_rss ul').addClass('media-list');

    $('.widget_meta ul, .widget_recent_entries ul, .widget_archive ul, .widget_categories ul, .widget_nav_menu ul, .widget_pages ul, .widget_product_categories ul').addClass('nav flex-column');
    $('.widget_meta ul li, .widget_recent_entries ul li, .widget_archive ul li, .widget_categories ul li, .widget_nav_menu ul li, .widget_pages ul li, .widget_product_categories ul li').addClass('nav-item');
    $('.widget_meta ul li a, .widget_recent_entries ul li a, .widget_archive ul li a, .widget_categories ul li a, .widget_nav_menu ul li a, .widget_pages ul li a, .widget_product_categories ul li a').addClass('nav-link');

    $('.widget_recent_comments ul#recentcomments').css('list-style', 'none').css('padding-left', '0');
    $('.widget_recent_comments ul#recentcomments li').css('padding', '5px 15px');

    $('table#wp-calendar').addClass('table table-striped');

    // Adding Class to contact form 7 form
    $('.wpcf7-form-control').not(".wpcf7-submit, .wpcf7-acceptance, .wpcf7-file, .wpcf7-radio").addClass('form-control');
    $('.wpcf7-submit').addClass('btn btn-primary');

    // Adding Class to Woocommerce form
    $('.woocommerce-Input--text, .woocommerce-Input--email, .woocommerce-Input--password').addClass('form-control');
    $('.woocommerce-Button.button').addClass('btn btn-primary mt-2').removeClass('button');

    $('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
        $(this).parent().siblings().removeClass('open');
        $(this).parent().toggleClass('open');
    });

    // Fix woocommerce checkout layout
    $('#customer_details .col-1').addClass('col-12').removeClass('col-1');
    $('#customer_details .col-2').addClass('col-12').removeClass('col-2');
    $('.woocommerce-MyAccount-content .col-1').addClass('col-12').removeClass('col-1');
    $('.woocommerce-MyAccount-content .col-2').addClass('col-12').removeClass('col-2');

    // Add Option to add Fullwidth Section
    function fullWidthSection() {
        var screenWidth = $(window).width();
        if ($('.entry-content').length) {
            var leftoffset = $('.entry-content').offset().left;
        } else {
            var leftoffset = 0;
        }
        $('.full-bleed-section').css({
            'position': 'relative',
            'left': '-' + leftoffset + 'px',
            'box-sizing': 'border-box',
            'width': screenWidth,
        });
    }
    fullWidthSection();
    $(window).resize(function() {
        fullWidthSection();
    });

    // Allow smooth scroll
    $('.page-scroller').on('click', function(e) {
        e.preventDefault();
        var target = this.hash;
        var $target = $(target);
        $('html, body').animate({
            'scrollTop': $target.offset().top
        }, 1000, 'swing');
    });
    $('.button-video').on('click', function(e) {
        $('.video-img').addClass('hide');
        $('.video-wrap').addClass('show');
    });

    $('.carousel-multimedia li').on('click', function(e) {
        $('.video-img').removeClass('hide');
        $('.video-wrap').removeClass('show');
    });

    window.onscroll = function() { myFunction() };

    var header = document.getElementById("masthead");
    var sticky = header.offsetTop;

    function myFunction() {
        if (window.pageYOffset > sticky) {
            header.classList.add("sticky");
        } else {
            header.classList.remove("sticky");
        }
    }

    var eventsCalendar = document.getElementById("events-calendar");
    var eventsCalendar = jsCalendar.new(eventsCalendar);
    var current_response = null;

    var template = $('[post-template]');
    var templateCont = $('[post-template-cont]');

    eventsCalendar.onMonthChange(function(event, date) {
        loadEvents(date);
    }).onDateClick(function(event, date) {

        if (current_response == null) {
            loadEventToHtml([]);
            return;
        }

        var events = current_response.filter(function(e) {
            return e.start == new Date(new Date(date).setHours(12)).toISOString().substr(0, 10).split('-').reverse().join('/');
        });

        loadEventToHtml(events);

    });

    $("#exampleModal").on('show.bs.modal', function() {
        loadEvents(new Date());
    });

    var loadEvents = function(date) {
        var y = date.getFullYear(),
            m = date.getMonth() + 1;
        $.get(ajaxuri, { action: "get_events", year: y, month: m }, function(response) {
            current_response = response;
            var events = current_response.filter(function(e) {
                return e.start == new Date(new Date().setHours(12)).toISOString().substr(0, 10).split('-').reverse().join('/');
            });

            loadEventToHtml(events);
            eventsCalendar.select(response.map(function(e) {
                return e.start;
            }));
        });
    }

    var loadEventToHtml = function(events) {
        templateCont.empty();
        if (events.length == 0) {
            $(".target").show();
        } else { $(".target").hide(); }
        for (var i in events) {
            var ev = events[i];
            var t = template.clone();
            $('.event-title', t).html(ev.title);
            $('.event-body', t).html(ev.excerpt);
            $('.event-start-date', t).html(ev.startshow);
            $('span.date.date-event', t).html(ev.start2);
            $('span.date.date-event.end', t).html(ev.end);
            $('span.location', t).html(ev.location);
            t.show();
            templateCont.append(t);
        }
    }
});
