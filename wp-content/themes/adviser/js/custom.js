(function($){
    $(document).ready(function(){

    $('ul.sf-menu').superfish({
        pathClass:  'current'
    });

    $('#carousel-multimedia').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        itemWidth: 448,
        itemMargin: 10,
        asNavFor: '#slider-multimedia'
    });

    $('#slider-multimedia').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        sync: "#carousel-multimedia"
    });

    $('#carousel-portfolio').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        itemWidth: 194,
        itemMargin: 10,
        asNavFor: '#slider-portfolio'
    });

    $('#slider-portfolio').flexslider({
        animation: "slide",
        controlNav: true,
        animationLoop: false,
        slideshow: false,
        sync: "#carousel-portfolio"
    });

    $('.flexslider-spon').flexslider({
        animation: "slide"
    });

    $('.bxslider-related').bxSlider({
      pagerCustom: '#bx-pager'
    });

    $('.bxslider').bxSlider({
      pagerCustom: '#bx-pager'
    });

    $('#feature-sponsored-item').owlCarousel({
        loop:true,
        nav:true,
        responsiveClass:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:2,
            },
            1000:{
                items:2,
            },
            1600:{
                items:2,
            }
        }
    })

    $(window).scroll(function() {
        var scroll = $(window).scrollTop();

        if(scroll >= 300) {
            $("#masthead").addClass("fixed");
        } else {
            $("#masthead").removeClass("fixed");
        }
    });


    if ($('#back-to-top').length) {
    var scrollTrigger = 100, // px
        backToTop = function () {
            var scrollTop = $(window).scrollTop();
            if (scrollTop > scrollTrigger) {
                $('#back-to-top').addClass('show');
            } else {
                $('#back-to-top').removeClass('show');
            }
        };
    backToTop();
    $(window).on('scroll', function () {
        backToTop();
    });
    $('#back-to-top').on('click', function (e) {
        e.preventDefault();
        $('html,body').animate({
            scrollTop: 0
        }, 700);
    });
    };

    $("#scroll-more").click(function() {
        $('html, body').animate({
            scrollTop: $("#box-analysis").offset().top - 93
        }, 700);
    });


    $('.button-video').on('click', function (e) {
        $('.video-img').addClass('hide');
        $('.video-wrap').addClass('show');
    });

    $('.carousel-multimedia li').on('click', function (e) {
        $('.video-img').removeClass('hide');
        $('.video-wrap').removeClass('show');
    });

    $('.infinite-selector').jscroll({
        autoTrigger: false,
        loadingHtml: '<img src="loading.gif" alt="Loading" />',
        padding: 20,
        nextSelector: '#nav-below a:first',
        contentSelector: '.infinite-selector'
    });

    $(document).on('click', '.view-more.view-more-ajax', function(e) {
      e.preventDefault();
      var button = $(this);
      var currentPage = button.attr('page');
      var offset = button.attr('offset');
      var category = button.attr('category');

      $.ajax({
        url: ajaxviewmore.ajaxurl,
        type: 'post',
        data: {
          action: 'ajax_view_more',
          page: currentPage,
          offset: offset,
          category: category
        },
        success: function(result) {
          $('.list-category-ajax').append(result);
          button.attr('page', parseInt(currentPage) + 1);
        }
      });
    });

    }); // End document ready
})(this.jQuery);
