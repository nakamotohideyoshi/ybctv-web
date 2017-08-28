jQuery(document).ready(function(){

    // method body font
    var FontCheck2 = jQuery("#TZFontType").attr('value');
    switch (FontCheck2){
        case 'TzFontSquirrel':
            jQuery('#setting_TzFontSquirrel').css("display","block");
            break;
        case 'TzFontDefault':
            jQuery('#setting_TzFontDefault').css("display","block");

            break;
        case 'Tzgoogle':

            jQuery('#setting_TzFontFami').css("display","block");
            jQuery('#setting_TzFontFaminy').css("display","block");
            break;
    }

    jQuery("#TZFontType").change(function(){
        var FontCheck = jQuery("#TZFontType").attr('value');
        switch (FontCheck){
            case 'TzFontSquirrel':
                jQuery('#setting_TzFontSquirrel').slideDown();
                jQuery('#setting_TzFontDefault').slideUp();
                jQuery('#setting_TzFontFami').slideUp();
                jQuery('#setting_TzFontFaminy').slideUp();
                break;
            case 'TzFontDefault':
                jQuery('#setting_TzFontDefault').slideDown();
                jQuery('#setting_TzFontSquirrel').slideUp();
                jQuery('#setting_TzFontFami').slideUp();
                jQuery('#setting_TzFontFaminy').slideUp();
                break;
            case 'Tzgoogle':
                jQuery('#setting_TzFontDefault').slideUp();
                jQuery('#setting_TzFontSquirrel').slideUp();
                jQuery('#setting_TzFontFami').slideDown();
                jQuery('#setting_TzFontFaminy').slideDown();
                break;
        }
    });


    // method header font
    var FontCheckHead = jQuery("#TZFontTypeHead").attr('value');
    switch (FontCheckHead){
        case 'TzFontSquirrel':
            jQuery('#setting_TzFontHeadSquirrel').css("display","block");
            break;
        case 'TzFontDefault':
            jQuery('#setting_TzFontHeadDefault').css("display","block");

            break;
        case 'Tzgoogle':

            jQuery('#setting_TzFontHeadGoodurl').css("display","block");
            jQuery('#setting_TzFontFaminyHead').css("display","block");
            break;
    }

    jQuery("#TZFontTypeHead").change(function(){
        var FontCheckHead2 = jQuery("#TZFontTypeHead").attr('value');
        switch (FontCheckHead2){
            case 'TzFontSquirrel':
                jQuery('#setting_TzFontHeadSquirrel').slideDown();
                jQuery('#setting_TzFontHeadDefault').slideUp();
                jQuery('#setting_TzFontHeadGoodurl').slideUp();
                jQuery('#setting_TzFontFaminyHead').slideUp();
                break;
            case 'TzFontDefault':
                jQuery('#setting_TzFontHeadDefault').slideDown();
                jQuery('#setting_TzFontHeadSquirrel').slideUp();
                jQuery('#setting_TzFontHeadGoodurl').slideUp();
                jQuery('#setting_TzFontFaminyHead').slideUp();
                break;
            case 'Tzgoogle':
                jQuery('#setting_TzFontHeadDefault').slideUp();
                jQuery('#setting_TzFontHeadSquirrel').slideUp();
                jQuery('#setting_TzFontHeadGoodurl').slideDown();
                jQuery('#setting_TzFontFaminyHead').slideDown();
                break;
        }
    });

    // method Menu font
    var FontCheckMenu= jQuery("#TZFontTypeMenu").attr('value');
    switch (FontCheckMenu){
        case 'TzFontSquirrel':
            jQuery('#setting_TzFontMenuSquirrel').css("display","block");
            break;
        case 'TzFontDefault':
            jQuery('#setting_TzFontMenuDefault').css("display","block");

            break;
        case 'Tzgoogle':

            jQuery('#setting_TzFontMenuGoodurl').css("display","block");
            jQuery('#setting_TzFontFaminyMenu').css("display","block");
            break;
    }

    jQuery("#TZFontTypeMenu").change(function(){
        var FontCheckMenu2 = jQuery("#TZFontTypeMenu").attr('value');
        switch (FontCheckMenu2){
            case 'TzFontSquirrel':
                jQuery('#setting_TzFontMenuSquirrel').slideDown();
                jQuery('#setting_TzFontMenuDefault').slideUp();
                jQuery('#setting_TzFontMenuGoodurl').slideUp();
                jQuery('#setting_TzFontFaminyMenu').slideUp();
                break;
            case 'TzFontDefault':
                jQuery('#setting_TzFontMenuDefault').slideDown();
                jQuery('#setting_TzFontMenuSquirrel').slideUp();
                jQuery('#setting_TzFontMenuGoodurl').slideUp();
                jQuery('#setting_TzFontFaminyMenu').slideUp();
                break;
            case 'Tzgoogle':
                jQuery('#setting_TzFontMenuDefault').slideUp();
                jQuery('#setting_TzFontMenuSquirrel').slideUp();
                jQuery('#setting_TzFontMenuGoodurl').slideDown();
                jQuery('#setting_TzFontFaminyMenu').slideDown();
                break;
        }
    });

    // method custom font
    var FontCheckCustom= jQuery("#TZFontTypeCustom").attr('value');
    switch (FontCheckCustom){
        case 'TzFontSquirrel':
            jQuery('#setting_TzFontCustomSquirrel').css("display","block");
            break;
        case 'TzFontDefault':
            jQuery('#setting_TzFontCustomDefault').css("display","block");

            break;
        case 'Tzgoogle':

            jQuery('#setting_TzFontCustomGoodurl').css("display","block");
            jQuery('#setting_TzFontFaminyCustom').css("display","block");
            break;
    }

    jQuery("#TZFontTypeCustom").change(function(){
        var FontCheckCustom2 = jQuery("#TZFontTypeCustom").attr('value');
        switch (FontCheckCustom2){
            case 'TzFontSquirrel':
                jQuery('#setting_TzFontCustomSquirrel').slideDown();
                jQuery('#setting_TzFontCustomDefault').slideUp();
                jQuery('#setting_TzFontCustomGoodurl').slideUp();
                jQuery('#setting_TzFontFaminyCustom').slideUp();
                break;
            case 'TzFontDefault':
                jQuery('#setting_TzFontCustomDefault').slideDown();
                jQuery('#setting_TzFontCustomSquirrel').slideUp();
                jQuery('#setting_TzFontCustomGoodurl').slideUp();
                jQuery('#setting_TzFontFaminyCustom').slideUp();
                break;
            case 'Tzgoogle':
                jQuery('#setting_TzFontCustomDefault').slideUp();
                jQuery('#setting_TzFontCustomSquirrel').slideUp();
                jQuery('#setting_TzFontCustomGoodurl').slideDown();
                jQuery('#setting_TzFontFaminyCustom').slideDown();
                break;
        }
    });




    // method logo type

    var LogoType= jQuery("#logotype").attr('value');
    if(LogoType==1){
        jQuery('#setting_logo').slideDown();
        jQuery('#setting_logoText').slideUp();
        jQuery('#setting_logoTextcolor').slideUp();
    }else{
        jQuery('#setting_logo').slideUp();
        jQuery('#setting_logoText').slideDown();
        jQuery('#setting_logoTextcolor').slideDown();
    }

    jQuery("#logotype").change(function(){
        var LogoTypeChange= jQuery("#logotype").attr('value');
        if(LogoTypeChange==1){
            jQuery('#setting_logo').slideDown();
            jQuery('#setting_logoText').slideUp();
            jQuery('#setting_logoTextcolor').slideUp();
        }else{
            jQuery('#setting_logo').slideUp();
            jQuery('#setting_logoText').slideDown();
            jQuery('#setting_logoTextcolor').slideDown();
        }
    });


    jQuery("#tab_TzSyle").toggle(function(){
        jQuery('#tab_TzFontMenu').slideDown();
        jQuery('#tab_TzFontCustom').slideDown();
        jQuery('#tab_TZBackground').slideDown();
        jQuery('#tab_TZBody').slideDown();
        jQuery('#tab_TzFontHeader').slideDown();
    },function(){
        jQuery('#tab_TzFontMenu').slideUp();
        jQuery('#tab_TzFontCustom').slideUp();
        jQuery('#tab_TZBackground').slideUp();
        jQuery('#tab_TZBody').slideUp();
        jQuery('#tab_TzFontHeader').slideUp();
    });



    // Home page settings


});



// Background Type Event

jQuery('#' + 'background_type').live('change', function () {
    "use strict";

    var value = jQuery(this).val();
    if (String(value) === 'none') {
        jQuery('#setting' + '_background_pattern, ' +
            '#setting' + '_background_single_image').slideUp();
        jQuery('#setting' + '_TZBackgroundColor').slideDown();
    }else if (String(value) === 'pattern') {
        jQuery('#setting' + '_background_pattern').slideDown();
        jQuery('#setting' + '_background_single_image').slideUp();
        jQuery('#setting' + '_TZBackgroundColor').slideUp();
    }else {
        jQuery('#setting' + '_background_pattern').slideUp();
        jQuery('#setting' + '_background_single_image').slideDown();
        jQuery('#setting' + '_TZBackgroundColor').slideUp();
    }
});

var background_type = jQuery('#' + '_background_type').val();
if (String(background_type) === 'none') {
    jQuery('#setting' + '_background_pattern, ' +
        '#setting' + '_background_single_image').slideUp();
    jQuery('#setting' + '_TZBackgroundColor').slideDown();
}else if (String(background_type) === 'pattern') {
    jQuery('#setting' + '_background_pattern').slideDown();
    jQuery('#setting' + '_background_single_image').slideUp();
} else {
    jQuery('#setting' + '_background_pattern').slideUp();
    jQuery('#setting' + '_background_single_image').slideDown();

}

// Background Pattern Preview
jQuery('#setting' + '_background_pattern .background_pattern').live('click', function () {
    "use strict";
    if (jQuery('#wpcontent').length > 0) {
        jQuery('#wpcontent').css('background', 'url("' + jQuery(this).attr('src') + '") repeat');
    }
});