;(function($) {
  $(document).ready(function() {
    // Add jQuery UI Sortable
    $('.last-word-gallery-order').sortable({
      cursor: 'move',
      containment: 'parent',
      stop: updateOrder
    });

    function updateOrder() {
      var i = 1;
      var imageDetails;
      var imageId;
      $('.gallery-image-container').each(function() {
        imageId = $(this).find('input[name=gallery-image-id]').val();
        $(this).find('input[name=gallery-image-order]').val(i);

        imageDetailsId = $('.last-word-gallery').find('input[name="gallery-image-id[]"][value=' + imageId + ']');
        imageDetailsId.closest('.order').find('span').html(i);
        imageDetailsId.parent().find('input[name="gallery-image-order[]"]').val(i);

        i++;
      });

      // Deactivate tinyMCE before moving
      $('.last-word-gallery tbody').children('tr').each(function() {
        var id = $(this).find('input[name="gallery-image-id[]"]').val();
        tinyMCE.execCommand('mceRemoveEditor', false, id + '_gallery-image-description');
      });

      // Add rows to array
      var rows = $('.last-word-gallery tbody').find('tr').get();

      // Remove rows from DOM
      $('.last-word-gallery tbody').empty();

      // Sort rows
      rows.sort(function(a, b) {
        var keyA = parseInt($(a).find('.order span').html());
        var keyB = parseInt($(b).find('.order span').html());

        if (keyA > keyB) return 1;
        if (keyA < keyB) return -1;
        return 0;
      });

      // Add rows back to DOM
      $.each(rows, function(index, row) {
        $('.last-word-gallery tbody').append(row);
      });

      // Reactivate tinyMCE
      $('.last-word-gallery tbody').children('tr').each(function() {
        var id = $(this).find('input[name="gallery-image-id[]"]').val();
        tinyMCE.execCommand('mceAddEditor', false, id + '_gallery-image-description');
      });
    }


    // Add images from media browser
    $(document).on('click', '.button.add_gallery_image', function(e) {
      e.preventDefault();

      var media_browser;
      if (media_browser) {
        media_browser.open();
      }

      media_browser = wp.media({
        title: 'Select Gallery Image(s)',
        multiple: true,
        library: {
          type: 'image'
        }
      });

      media_browser.on('close', function() {
        var selection = media_browser.state().get('selection');
        var orderContainer = $('.last-word-gallery-order');
        var detailContainer = $('.last-word-gallery tbody');
        var imageCount = orderContainer.children().length;
        var output;

        // Get highest image id
        var imageIdFields = $('.last-word-gallery').find('input[name="gallery-image-id[]"]');
        if (imageIdFields.length > 0) {
          var imageIds = imageIdFields.map(function() {
            return $(this).val();
          }).get();
          var imageId = Math.max.apply(Math, imageIds) + 1;
          var order = imageIds.length + 1;
        }
        else {
          imageId = 1;
          order = 1;
        }

        if (selection.length > 0) {
          $('.gallery-container').css({'display' : 'block'});
          selection.each(function(attachment) {
            // Add to Gallery Order section
            output = '<div class="gallery-image-container ui-sortable-handle">';
            output += '<img src="' + attachment['attributes']['sizes']['popular-article-small']['url'] + '" />';
            output += '<input type="hidden" name="gallery-image-id" value="' + imageId + '">';
            output += '<input type="hidden" name="gallery-image-order" value="' + order + '">';
            output += '</div>';
            orderContainer.append(output);

            //Add to Gallery Image Details section
            output = '<tr id="gallery_image_' + imageId + '">';
            output += '<td class="order">';
            output += '<span>' + order + '</span>';
            output += '<input type="hidden" name="gallery-image-id[]" value="' + imageId + '">';
            output += '<input type="hidden" name="gallery-image-order[]" value="' + order + '">';
            output += '<input type="hidden" name="gallery-image-media-id[]" value="' + attachment['id'] + '">';
            output += '<input type="hidden" name="gallery-image-url[]" value="">';
            output += '</td>';
            output += '<td class="thumbnail">';
            output += '<img src="' + attachment['attributes']['sizes']['popular-article-small']['url'] + '" />';
            output += '</td>';
            output += '<td class="caption">';
            output += '<textarea class="widefat" rows="5" name="gallery-image-caption[]"></textarea>';
            output += '</td>';
            output += '<td class="description"></td>';
            output += '<td class="remove">';
            output += '<div class="dashicons-before dashicons-no remove_' + imageId + '"></div>';
            output += '</td>';
            detailContainer.append(output);

            imageId++;
            order++;
          });

          var descriptionIds = [];
          $('.last-word-gallery tbody').children('tr').each(function() {
            description = $(this).find('.description');

            if (description.html() == '') {
              imageId = $(this).find('input[name="gallery-image-id[]"]').val();
              descriptionIds.push(imageId);
            }
          });

          $.each(descriptionIds, function(index, item) {
            $.ajax({
              type: 'POST',
              url: ajaxurl,
              data: {
                action: 'add_editor',
                data_post: 'id=' + item
              },
              success: function(data) {
                descriptionCell = $('#gallery_image_' + item).find('.description');
                descriptionCell.html(data);
                tinyMCE.execCommand('mceAddEditor', false, item + '_gallery-image-description');
              }
            });
          });
        }
      });

      media_browser.open();
    });

    $(document).on('click', '.last-word-gallery div[class*=remove_]', function(e) {
      e.preventDefault();
      var orderContainer = $('.last-word-gallery-order');
      var detailContainer = $('.last-word-gallery tbody');

      var imageId = $(this).closest('tr').find('input[name="gallery-image-id[]"]').val();
      var orderImageId = orderContainer.find('input[name=gallery-image-id][value=' + imageId + ']');

      // Remove from Gallery Details
      tinyMCE.execCommand('mceRemoveEditor', false, imageId + '_lw-gallery-description');
      $(this.closest('tr')).remove();

      // Remove from Gallery Order
      orderImageId.closest('.gallery-image-container').remove();

      // Update order
      var i = 1;
      $('.gallery-image-container').each(function() {
        imageId = $(this).find('input[name="gallery-image-id"]').val();
        $(this).find('input[name="gallery-image-order"]').val(i);

        imageDetailsId = $('.last-word-gallery').find('input[name="gallery-image-id[]"][value=' + imageId + ']');
        imageDetailsId.parent().find('span').html(i);
        imageDetailsId.parent().find('input[name="gallery-image-order[]"]').val(i);

        i++;
      });

    })
  });
})(jQuery);
