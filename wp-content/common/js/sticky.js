var scrolled ="";
var billboardFired = false;
var topSlotFired= false;
var topSlot2Fired= false;
var billboardCSS = ".ads-top-billboard";
var billboardTopCSS = ".billboard-top-padding";
var billboardBottomCSS = ".billboard-bottom-padding";
var billboardTop = "";
var billboardHeight = "";
var billboardLeft = "";
var billboardWidth ="";
var topSlot2 = "";
var topSlot2Height = "";
var stillTime = true;
var container = "";
var masthead = "#masthead";
var windowWidth = "";
var topOffset = "";
var absoluteTopOfAd = "";
var t = 5000;
var width = 320;
var padding = 90;
var tooSmall = false;
//  setting up the top sticky area
function setUpTopcss() {
    if (billboardFired && topSlotFired) {
        //  work out the aspects of the aspects of the advert first such as top and position left before moving it
        windowWidth = jQuery(window).width();
        billboardLeft = parseInt(windowWidth) / 2 - parseInt(billboardWidth) / 2;
        //  console.log('windowWidth  ' + windowWidth + 'left start  ' + billboardLeft);
        billboardTop = jQuery(billboardCSS).css('padding-top');
        //  console.log('This is the billboard with top ' + billboardTop + ' left ' + billboardLeft);
        //  because they add padding to the advert we need to not start at the right height but 0
        billboardTop = 0;
        //  Work out and add the top area
        //  because they add padding to the advert we need to be 15px higher
        billboardHeight = billboardHeight + 15;
        jQuery(billboardTopCSS).css('height', billboardHeight + 'px');
        //  Work out and add the bottom area
        var billboardBottomStyle = {
            'width': '100%',
            'position': 'fixed',
            'height': billboardHeight,
            'background-color': 'rgb(242, 242, 242)',
            'top': 0,
            'z-index': 2
        };
        jQuery(billboardBottomCSS).css(billboardBottomStyle);
        //  move the add
        var adsTopBillboardStyle = {'position': 'fixed', 'top': billboardTop, 'left': billboardLeft, 'z-index': 2};
        jQuery(billboardCSS).css(adsTopBillboardStyle);
        //   fix the navigation
        var headerMastheadStyle = {'top': billboardHeight, 'left': '0'};
        jQuery("header#masthead").css(headerMastheadStyle);
    }
}
function checkSize() {
    if (jQuery(".content-page .list-content-page").length) {
        if (jQuery(".content-page .list-content-page").outerHeight() < jQuery(".content-page .content-right").outerHeight()) {
            tooSmall = true;
        }
    }
    if (jQuery(".content-page .content-single").length) {
        if (jQuery(".content-page .content-single").outerHeight() < jQuery(".content-page .content-right").outerHeight()) {
            tooSmall = true;
        }
    }
}
function stickySide() {
    var ww = window.innerWidth
            || document.documentElement.clientWidth
            || document.body.clientWidth;
    if( ww < 992 ) {
        return;
    }
    //  top advert  home page
    if ( jQuery("section.multimedia").length) {
        var topOfSideAdContainerTop = ".all-new-analysis .content-right";
        var parentWidth = jQuery(topOfSideAdContainerTop).parent().width();
        
        if( parentWidth < width ) {
            width = parentWidth;
        }
        var stopPoint = "section.multimedia";
        if (stillTime) {
            if (billboardFired && topSlotFired) {
                topOffset = parseInt(jQuery(masthead).outerHeight() + parseInt(billboardHeight));
                if (scrolled >= 0) {
                    jQuery(topOfSideAdContainerTop).css('position', 'fixed');
                    jQuery(topOfSideAdContainerTop).css('top', topOffset);
                    jQuery(topOfSideAdContainerTop).css('overflow', 'hidden');
                    jQuery(topOfSideAdContainerTop).css('width', width);
                }
                if (scrolled > jQuery(stopPoint).offset().top - (parseInt(jQuery(topOfSideAdContainerTop).outerHeight()) + topOffset) && jQuery(stopPoint).offset().top - (parseInt(jQuery(topOfSideAdContainerTop).outerHeight()) + topOffset) > 0) {
                    var absoluteTopOfAdTop = jQuery(stopPoint).offset().top - (parseInt(jQuery(topOfSideAdContainerTop).outerHeight()) + topOffset  );
                    console.log(" Absolute 1" + absoluteTopOfAdTop);
                    jQuery(topOfSideAdContainerTop).css('position', 'absolute');
                    jQuery(topOfSideAdContainerTop).css('top', absoluteTopOfAdTop + 'px');
                }
            }
        } else {
            topOffset = parseInt(jQuery(masthead).outerHeight());
            if (scrolled < parseInt(jQuery(billboardCSS).outerHeight())) {
                jQuery(topOfSideAdContainerTop).css('position', 'static');
                jQuery(topOfSideAdContainerTop).css('top', 'topOffset');
            }
            if (scrolled >= parseInt(jQuery(billboardCSS).outerHeight())) {
                jQuery(topOfSideAdContainerTop).css('position', 'fixed');
                jQuery(topOfSideAdContainerTop).css('top', topOffset);
                jQuery(topOfSideAdContainerTop).css('overflow', 'hidden');
                jQuery(topOfSideAdContainerTop).css('width', width);
            }
            if (scrolled > jQuery(stopPoint).offset().top - (parseInt(jQuery(topOfSideAdContainerTop).outerHeight()) + topOffset)) {
                var absoluteTopOfAdTop = jQuery(stopPoint).offset().top - (parseInt(jQuery(topOfSideAdContainerTop).outerHeight()) + topOffset + billboardHeight );
                jQuery(topOfSideAdContainerTop).css('position', 'absolute');
                jQuery(topOfSideAdContainerTop).css('top', absoluteTopOfAdTop + 'px');
            }
        }
    }

    // bottom advert
    if (billboardFired && topSlotFired) {
        if (jQuery(".content-page .content-right").length || jQuery(".popular-porfolio .content-right").length || jQuery(".team-members .content-right").length) {
            if (jQuery(".content-page .content-right").length) {

                    //bottom side advert not home page
                    //bits above are advert and slideshow .ads-rhs-hpu-1 . box-sponsored which is
                    // parseInt(jQuery(topOfSideAdContainer)) - parseInt(jQuery(topSlotRef))
                    var topSlotRef = ".content-page .content-right .ads-rhs-hpu-2";
                    var topOfSideAdContainer = ".content-page .content-right";
                    var stopPoint = ".ads-bottom-billboard";
                    var offset = topSlotHeight + padding;
                    if (jQuery(".content-right .box-sponsored").length) {
                        offset = offset + parseInt(jQuery(".content-right .box-sponsored").outerHeight())
                    }
                    if (jQuery(".content-page .feature-sponsored").length) {
                        offset = offset + parseInt(jQuery(".content-right .feature-sponsored").outerHeight())
                    }
                    var absoluteTopOfAd = jQuery(stopPoint).offset().top - topSlot2Height - jQuery(topOfSideAdContainer).offset().top;
                    var stopPointHeight = 0;

            } else {

//bottom side advert  home page
                var topSlotRef, topOfSideAdContainer;
                if (jQuery(".team-members .content-right").length) {
                  topSlotRef = ".team-members .content-right .ads-rhs-hpu-2";
                  topOfSideAdContainer = ".team-members .content-right";
                  stopPoint = ".team-members";
                }
                else {
                  topSlotRef = ".popular-porfolio .content-right .ads-rhs-hpu-2";
                  topOfSideAdContainer = ".popular-porfolio .content-right";
                  stopPoint = ".event";
                }

                var offset = 0;
                var absoluteTopOfAd = jQuery(stopPoint).offset().top + jQuery(stopPoint).outerHeight() - topSlot2Height - jQuery(topOfSideAdContainer).offset().top;
                var stopPointHeight = jQuery(stopPoint).outerHeight()
            }
            if (stillTime) {
                topOffset = parseInt(jQuery(masthead).outerHeight()) + parseInt(billboardHeight);
            } else {
                topOffset = parseInt(jQuery(masthead).outerHeight());
            }
            if (scrolled < jQuery(topOfSideAdContainer).offset().top - topOffset + offset) {
                jQuery(topSlotRef).css('position', 'static');
                jQuery(topSlotRef).css('top', 'topOffset');
            }
            if (scrolled >= jQuery(topOfSideAdContainer).offset().top - topOffset + offset) {
                jQuery(topSlotRef).css('top', topOffset + 'px');
                jQuery(topSlotRef).css('position', 'fixed');
            }
            if (scrolled > jQuery(stopPoint).offset().top + stopPointHeight - (topSlot2Height + topOffset)) {
                jQuery(topSlotRef).css('position', 'absolute');
                jQuery(topSlotRef).css('top', absoluteTopOfAd + 'px');
            }
        }
    }
}
function updateAds(event){
    //  console.log(event);
    if(event.type === "scroll"){
        scrolled = jQuery(window).scrollTop();
        //console.log('Scrolled to :' + scrolled);
        setTimeout(function () {
            //console.log('Time up ');
            jQuery(billboardTopCSS).remove();
            jQuery(billboardBottomCSS).remove();
            jQuery(billboardCSS).removeAttr("style");
            jQuery("header#masthead").removeAttr("style");
            stillTime = false;
        }, t);
    } else if (event.type == "resize") {
        //console.log('resized');
    }else{
          // console.log(event);
        if(event.slot === billboard) {
            billboardHeight = event.size !== null ? event.size[1] : 0;
            billboardWidth = event.size !== null ? event.size[0] : 0;
            billboardFired = true;
            //console.log('This is the billboard with height ' + billboardHeight + ' And width ' + billboardWidth);
            if (jQuery(billboardTopCSS).length){
                //console.log('Inside setUpTopcss function after creation ');
                if (stillTime) {
                    setUpTopcss();
                }
            }else {
                //console.log('Inside setUpTopcss function first time ');
                jQuery(billboardCSS).before('<div class="billboard-top-padding"></div>');
                jQuery(billboardCSS).before('<div class="billboard-bottom-padding"></div>');
                if (stillTime) {
                    setUpTopcss();
                }
            }
        }else if(event.slot === topSlot2) {
            topSlot2Height = event.size !== null ? event.size[1] : 0;
            topSlot2Fired = true;
        }
        else if(event.slot === topSlot) {
            topSlotHeight = event.size !== null ? event.size[1] : 0;
            topSlotFired = true;
        }

        // else if(event.slot === topSearch) {
        //     topSearchHeight = event.size[1];
        //     //console.log('This is the topSearch with height ' + topSearchHeight);
        // } else if(event.slot === topNews) {
        //     topNewsHeight = event.size[1];
        //     //console.log('This is the topNews with height ' + topNewsHeight);
        // } else if(event.slot === topSlot) {
        //     topSlotHeight = event.size[1];
        //     //console.log('This is the topSlot with height ' + topSlotHeight);
        // } else if(event.slot === bottomBillboard) {
        //     bottomBillboardHeight = event.size[1];
        //     //console.log('This is the bottomSlot with height ' + bottomBillboardHeight);
        // }
    }
    if (billboardFired && topSlotFired && topSlot2Fired) {
    checkSize();
    if (tooSmall){
        //console.log("toosmall");
    }else {
        stickySide();
    }
    }
}
jQuery(document).ready(function() {
    jqueryReady=true;
    var i=0;
    if (storeAdChanges.length>0){
        for (i in storeAdChanges){
            updateAds(storeAdChanges[i]);
        }
    }
    jQuery(window).scroll(updateAds);
    jQuery( window ).resize(updateAds);
});
