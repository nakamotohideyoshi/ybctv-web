;(function($) {
  $(document).ready(function() {
    // Open media browser and select XML to be imported
    $(document).on('click', '.button-primary.open', function(e) {
      e.preventDefault();

      var type = $(this).attr('id');

      if (type != 'generate-image-size') {
        var media_browser;
        if (media_browser) {
          media_browser.open();
        }

        media_browser = wp.media({
          title: 'Select XML File',
          multiple: false,
        });

        // On close of media browser, add id of file selected to hidden field
        // Hidden field selected based on id of button clicked
        media_browser.on('close', function() {
          var selection = media_browser.state().get('selection');
          selection.each(function(attachment) {
            $('#' + type + '-import-file-id').val(attachment['id']);
            $('#' + type + '-import-file-url').html(attachment['attributes']['filename']).css('color', 'black');
            $('#' + type).val('Change');
            $('#' + type + '-process').removeClass('hide');
          });
        });

        media_browser.open();
      }
    });



    // Ajax to process file
    $(document).on('click', '.button-primary.process', function(e) {
      e.preventDefault();

      var ajaxLoader = $('.ajax-loader');
      var type = $(this).attr('import');
      var id = $('#' + type + '-import-file-id').val();
      var dataString = 'type=' + type + '&id=' + id;

      ajaxLoader.removeClass('hide');
      $.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
          action: 'process',
          data_post: dataString
        },
        success: function(data) {
          ajaxLoader.addClass('hide');

          $('#' + type + '-import-file-id').val('');
          $('#' + type + '-import-file-url').css('color', 'green');
          $('#' + type).val('Select');
          $('#' + type + '-process').addClass('hide');
          $('#' + type + '-complete').fadeIn();

          setTimeout(function() {
            $('#' + type + '-complete').fadeOut();
          }, 5000);

        }
      });
    });

    // Ajax to generate image sizes
    $(document).on('click', '.button-primary.generate-image-size', function(e) {
      e.preventDefault();

      var ajaxLoader = $('.ajax-loader');

      ajaxLoader.removeClass('hide');

      $.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
          action: 'generate_image_size'
        },
        success: function(data) {
          ajaxLoader.addClass('hide');

          $('#generate-image-size-complete').fadeIn();

          setTimeout(function() {
            $('#generate-image-size-complete').fadeOut();
          }, 5000);

        }
      });
    })
  });

})(jQuery);
