/*global jQuery: false, themeprefix: false */

jQuery(function(){
  "use strict";
  jQuery('#portfolio_meta_box .btn-group .btn').click(function () {
    jQuery(this).parent().find('> input').attr('checked', false);
    jQuery('#' + jQuery(this).attr('value')).attr('checked', true);
  });


  jQuery('.portfolio-slideshow-item').parent().parent().addClass('width100');
  jQuery('#' + 'portfolio_fullsize_image').parent().parent().parent().parent().hide();
  jQuery('#' + 'portfolio_slideshows_settings_array').parent().parent().parent().hide();
  jQuery('#' + 'portfolio_video').parent().parent().parent().hide();
  jQuery('#' + 'portfolio_video_type').parent().parent().parent().parent().hide();
  jQuery('#' + 'portfolio_soundCloud_id').parent().parent().parent().hide();
  jQuery('#' + 'portfolio_Quote_Autor').parent().parent().parent().hide();
  jQuery('#' + 'portfolio_Link_Title').parent().parent().parent().hide();
  jQuery('#' + 'portfolio_Link_Url').parent().parent().parent().hide();

  jQuery('#' + 'portfolio_type').live('change', function(){
    switch(jQuery(this).val()){
      case 'images':
        jQuery('#' + 'portfolio_fullsize_image').parent().parent().parent().parent().slideDown();
        jQuery('#' + 'portfolio_slideshows_settings_array').parent().parent().parent().slideUp();
        jQuery('#' + 'portfolio_video').parent().parent().parent().slideUp();
          jQuery('#' + 'portfolio_video_type').parent().parent().parent().parent().slideUp();
          jQuery('#' + 'portfolio_soundCloud_id').parent().parent().parent().slideUp();
          jQuery('#' + 'portfolio_Quote_Autor').parent().parent().parent().slideUp();
          jQuery('#' + 'portfolio_Link_Title').parent().parent().parent().slideUp();
          jQuery('#' + 'portfolio_Link_Url').parent().parent().parent().slideUp();
        break;
      case 'slideshows':
        jQuery('#' + 'portfolio_fullsize_image').parent().parent().parent().parent().slideUp();
        jQuery('#' + 'portfolio_slideshows_settings_array').parent().parent().parent().slideDown();
        jQuery('#' + 'portfolio_video').parent().parent().parent().slideUp();
          jQuery('#' + 'portfolio_video_type').parent().parent().parent().parent().slideUp();
          jQuery('#' + 'portfolio_soundCloud_id').parent().parent().parent().slideUp();
          jQuery('#' + 'portfolio_Quote_Autor').parent().parent().parent().slideUp();
          jQuery('#' + 'portfolio_Link_Title').parent().parent().parent().slideUp();
          jQuery('#' + 'portfolio_Link_Url').parent().parent().parent().slideUp();
        break;
      case 'video':
          jQuery('#' + 'portfolio_video_type').parent().parent().parent().parent().slideDown();
        jQuery('#' + 'portfolio_video').parent().parent().parent().slideDown();
        jQuery('#' + 'portfolio_slideshows_settings_array').parent().parent().parent().slideUp();
        jQuery('#' + 'portfolio_fullsize_image').parent().parent().parent().parent().slideUp();
          jQuery('#' + 'portfolio_soundCloud_id').parent().parent().parent().slideUp();
          jQuery('#' + 'portfolio_Quote_Autor').parent().parent().parent().slideUp();
          jQuery('#' + 'portfolio_Link_Title').parent().parent().parent().slideUp();
          jQuery('#' + 'portfolio_Link_Url').parent().parent().parent().slideUp();
        break;
      case 'audio':
        jQuery('#' + 'portfolio_video_type').parent().parent().parent().parent().slideUp();
        jQuery('#' + 'portfolio_video').parent().parent().parent().slideUp();
        jQuery('#' + 'portfolio_slideshows_settings_array').parent().parent().parent().slideUp();
        jQuery('#' + 'portfolio_fullsize_image').parent().parent().parent().parent().slideUp();
          jQuery('#' + 'portfolio_soundCloud_id').parent().parent().parent().slideDown();
          jQuery('#' + 'portfolio_Quote_Autor').parent().parent().parent().slideUp();
          jQuery('#' + 'portfolio_Link_Title').parent().parent().parent().slideUp();
          jQuery('#' + 'portfolio_Link_Url').parent().parent().parent().slideUp();
        break;
    case 'quote':
        jQuery('#' + 'portfolio_video_type').parent().parent().parent().parent().slideUp();
        jQuery('#' + 'portfolio_video').parent().parent().parent().slideUp();
        jQuery('#' + 'portfolio_slideshows_settings_array').parent().parent().parent().slideUp();
        jQuery('#' + 'portfolio_fullsize_image').parent().parent().parent().parent().slideUp();
        jQuery('#' + 'portfolio_soundCloud_id').parent().parent().parent().slideUp();
        jQuery('#' + 'portfolio_Quote_Autor').parent().parent().parent().slideDown();
        jQuery('#' + 'portfolio_Link_Title').parent().parent().parent().slideUp();
        jQuery('#' + 'portfolio_Link_Url').parent().parent().parent().slideUp();
        break;
    case 'link':
        jQuery('#' + 'portfolio_video_type').parent().parent().parent().parent().slideUp();
        jQuery('#' + 'portfolio_video').parent().parent().parent().slideUp();
        jQuery('#' + 'portfolio_slideshows_settings_array').parent().parent().parent().slideUp();
        jQuery('#' + 'portfolio_fullsize_image').parent().parent().parent().parent().slideUp();
        jQuery('#' + 'portfolio_soundCloud_id').parent().parent().parent().slideUp();
        jQuery('#' + 'portfolio_Quote_Autor').parent().parent().parent().slideUp();
        jQuery('#' + 'portfolio_Link_Title').parent().parent().parent().slideDown();
        jQuery('#' + 'portfolio_Link_Url').parent().parent().parent().slideDown();
        break;
      case 'none':
        jQuery('#' + 'portfolio_fullsize_image').parent().parent().parent().parent().slideUp();
        jQuery('#' + 'portfolio_slideshows_settings_array').parent().parent().parent().slideUp();
        jQuery('#' + 'portfolio_video').parent().parent().parent().slideUp();
          jQuery('#' + 'portfolio_video_type').parent().parent().parent().parent().slideUp();
          jQuery('#' + 'portfolio_soundCloud_id').parent().parent().parent().slideUp();
          jQuery('#' + 'portfolio_Quote_Autor').parent().parent().parent().slideUp();
          jQuery('#' + 'portfolio_Link_Title').parent().parent().parent().slideUp();
          jQuery('#' + 'portfolio_Link_Url').parent().parent().parent().slideUp();
        break;
    }
  });

  jQuery('#' + 'portfolio_type').each(function(){
    if(jQuery(this).find('option').is(':checked')){

      switch(jQuery(this).val()){
        case 'images':
          jQuery('#' + 'portfolio_fullsize_image').parent().parent().parent().parent().slideDown();
          jQuery('#' + 'portfolio_slideshows_settings_array').parent().parent().parent().slideUp();
          jQuery('#' + 'portfolio_video').parent().parent().parent().slideUp();
            jQuery('#' + 'portfolio_video_type').parent().parent().parent().parent().slideUp();
            jQuery('#' + 'portfolio_soundCloud_id').parent().parent().parent().slideUp();
            jQuery('#' + 'portfolio_Quote_Autor').parent().parent().parent().slideUp();
            jQuery('#' + 'portfolio_Link_Title').parent().parent().parent().slideUp();
            jQuery('#' + 'portfolio_Link_Url').parent().parent().parent().slideUp();

          break;
        case 'slideshows':
          jQuery('#' + 'portfolio_fullsize_image').parent().parent().parent().parent().slideUp();
          jQuery('#' + 'portfolio_slideshows_settings_array').parent().parent().parent().slideDown();
          jQuery('#' + 'portfolio_video').parent().parent().parent().slideUp();
            jQuery('#' + 'portfolio_video_type').parent().parent().parent().parent().slideUp();
            jQuery('#' + 'portfolio_soundCloud_id').parent().parent().parent().slideUp();
            jQuery('#' + 'portfolio_Quote_Autor').parent().parent().parent().slideUp();
            jQuery('#' + 'portfolio_Link_Title').parent().parent().parent().slideUp();
            jQuery('#' + 'portfolio_Link_Url').parent().parent().parent().slideUp();

          break;
        case 'video':
          jQuery('#' + 'portfolio_video').parent().parent().parent().slideDown();
          jQuery('#' + 'portfolio_fullsize_image').parent().parent().parent().parent().slideUp();
          jQuery('#' + 'portfolio_slideshows_settings_array').parent().parent().parent().slideUp();
            jQuery('#' + 'portfolio_video_type').parent().parent().parent().parent().slideDown();
            jQuery('#' + 'portfolio_soundCloud_id').parent().parent().parent().slideUp();
            jQuery('#' + 'portfolio_Quote_Autor').parent().parent().parent().slideUp();
            jQuery('#' + 'portfolio_Link_Title').parent().parent().parent().slideUp();
            jQuery('#' + 'portfolio_Link_Url').parent().parent().parent().slideUp();
          break;
          case 'audio':
              jQuery('#' + 'portfolio_video_type').parent().parent().parent().parent().slideUp();
              jQuery('#' + 'portfolio_video').parent().parent().parent().slideUp();
              jQuery('#' + 'portfolio_slideshows_settings_array').parent().parent().parent().slideUp();
              jQuery('#' + 'portfolio_fullsize_image').parent().parent().parent().parent().slideUp();
              jQuery('#' + 'portfolio_soundCloud_id').parent().parent().parent().slideDown();
              jQuery('#' + 'portfolio_Quote_Autor').parent().parent().parent().slideUp();
              jQuery('#' + 'portfolio_Link_Title').parent().parent().parent().slideUp();
              jQuery('#' + 'portfolio_Link_Url').parent().parent().parent().slideUp();
              break;
          case 'quote':
              jQuery('#' + 'portfolio_video_type').parent().parent().parent().parent().slideUp();
              jQuery('#' + 'portfolio_video').parent().parent().parent().slideUp();
              jQuery('#' + 'portfolio_slideshows_settings_array').parent().parent().parent().slideUp();
              jQuery('#' + 'portfolio_fullsize_image').parent().parent().parent().parent().slideUp();
              jQuery('#' + 'portfolio_soundCloud_id').parent().parent().parent().slideUp();
              jQuery('#' + 'portfolio_Quote_Autor').parent().parent().parent().slideDown();
              jQuery('#' + 'portfolio_Link_Title').parent().parent().parent().slideUp();
              jQuery('#' + 'portfolio_Link_Url').parent().parent().parent().slideUp();
              break;
          case 'link':
              jQuery('#' + 'portfolio_video_type').parent().parent().parent().parent().slideUp();
              jQuery('#' + 'portfolio_video').parent().parent().parent().slideUp();
              jQuery('#' + 'portfolio_slideshows_settings_array').parent().parent().parent().slideUp();
              jQuery('#' + 'portfolio_fullsize_image').parent().parent().parent().parent().slideUp();
              jQuery('#' + 'portfolio_soundCloud_id').parent().parent().parent().slideUp();
              jQuery('#' + 'portfolio_Quote_Autor').parent().parent().parent().slideUp();
              jQuery('#' + 'portfolio_Link_Title').parent().parent().parent().slideDown();
              jQuery('#' + 'portfolio_Link_Url').parent().parent().parent().slideDown();
              break;
          case 'none':
              jQuery('#' + 'portfolio_fullsize_image').parent().parent().parent().parent().slideUp();
              jQuery('#' + 'portfolio_slideshows_settings_array').parent().parent().parent().slideUp();
              jQuery('#' + 'portfolio_video').parent().parent().parent().slideUp();
              jQuery('#' + 'portfolio_video_type').parent().parent().parent().parent().slideUp();
              jQuery('#' + 'portfolio_soundCloud_id').parent().parent().parent().slideUp();
              jQuery('#' + 'portfolio_Quote_Autor').parent().parent().parent().slideUp();
              jQuery('#' + 'portfolio_Link_Title').parent().parent().parent().slideUp();
              jQuery('#' + 'portfolio_Link_Url').parent().parent().parent().slideUp();
              break;
      }
    }
  });



});
