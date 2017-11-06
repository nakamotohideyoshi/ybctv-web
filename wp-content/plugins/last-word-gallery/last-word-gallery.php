<?php
/*
Plugin Name: Last Word Gallery
Plugin URI: http://www.ybc.tv
Description: Gallery functionality for Last Word sites
Author: yBC
Version: 1.0
Author URI: http://www.ybc.tv
*/

class last_word_gallery {
  function __construct() {
    add_action('wp_enqueue_scripts', array($this, 'enqueue_gallery_style'));
    add_action('add_meta_boxes', array($this, 'add_gallery_meta_box'));
    add_action('admin_enqueue_scripts', array($this, 'enqueue_admin'));
    add_filter('wp_prepare_attachment_for_js', array($this, 'prep_image_sizes_js'), 10, 3);
    add_action('wp_ajax_add_editor', array($this, 'add_editor'));
    add_action('save_post', array($this, 'save_lw_gallery'));
  }

  function enqueue_gallery_style() {
    wp_enqueue_style('last_word_gallery', plugin_dir_url(__FILE__) . 'css/style.css', array(), '1.0.0');
  }

  function enqueue_admin($hook) {
    if ('post.php' == $hook || 'post-new.php' == $hook) {
      wp_enqueue_script( 'lw_gallery_admin_js', plugin_dir_url(__FILE__) . 'js/main.js', array(), '1.0.0',  true);

      wp_register_style('lw_gallery_css', plugin_dir_url(__FILE__) . 'css/admin.css', false, '1.0.0');
      wp_enqueue_style('lw_gallery_css');
      add_editor_style(plugin_dir_url(__FILE__) . 'css/editor.css');
    }
  }

  public static function last_word_gallery() {
    global $post;
    global $wp;

    $protocol = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://';
    $current_position = isset($_GET['gallery-image']) ? (int)$_GET['gallery-image'] : 1;

    $gallery = get_post_meta($post->ID, 'lw_gallery', true);
    if ($gallery) {
      ksort($gallery);
    }

    $current_image = $gallery[$current_position];
    ?>
    <div class="lw-gallery-wrap">
      <b><?php echo $current_image['caption']; ?></b>
      <?php
      if (isset($current_image['media_id']) && $current_image['media_id'] != '') {
      ?>
        <img class="gallery-image" src="<?php echo wp_get_attachment_url($current_image['media_id']) ?>" alt="<?php echo $current_image['caption']; ?>" />
      <?php
      }
      else if (isset($current_image['url']) && $current_image['url'] != '') {
      ?>
        <img class="gallery-image" src="<?php echo get_site_url() . $current_image['url']; ?>" alt="<?php echo $current_image['caption']; ?>" />
      <?php
      }
      ?>
      <img class="gallery-icon" src="<?php echo plugin_dir_url(__FILE__); ?>/images/gallery-icon.png" alt="Gallery" />
      <?php
        $current_blog = get_current_blog_id();
        $nav_link_background = '';

        switch ($current_blog) {
          case 2 :
            $nav_link_background = 'nav-pa';
            break;
          case 3 :
            $nav_link_background = 'nav-ia';
            break;
          case 4 :
            $nav_link_background = 'nav-fsa';
            break;
          case 5 :
            $nav_link_background = 'nav-ei';
            break;
          default :
            $nav_link_background = 'nav-pa';
            break;
        }

        // Prev/Next links
        if ($current_position != count($gallery)) {
          echo '<a class="image-next ' . $nav_link_background . '" href="' . home_url($wp->request) . '?gallery-image=' . ($current_position + 1) . '"><img src="' . plugin_dir_url(__FILE__) . '/images/arrow-right.png" /></a>';
        }

        if ($current_position > 1) {
          echo '<a class="image-prev ' . $nav_link_background . '" href="' . home_url($wp->request) . '?gallery-image=' . ($current_position - 1) . '"><img src="' . plugin_dir_url(__FILE__) .  '/images/arrow-left.png" /></a>';
        }

        // Image links
        echo '<p class="image-nav-container">';
        foreach ($gallery as $key => $gallery_image) {
          if ($key == $current_position) {
            echo '<span class="image-selected">' . $key . '</span>';
          }
          else {
            echo '<a class="image-nav" href="' . home_url($wp->request) . '?gallery-image=' . $key . '">' . $key . '</a>';
          }
        }
        echo '</p>';
      ?>
      <p><?php echo apply_filters('the_content', $current_image['description']); ?></p>
    </div>
    <?php
  }

  function add_gallery_meta_box() {
    add_meta_box('lw_gallery_meta', 'Gallery', array($this, 'add_lw_gallery'), 'post', 'normal');
  }

  function add_lw_gallery() {
    global $post;
    $gallery = get_post_meta($post->ID, 'lw_gallery', true);

    wp_nonce_field( basename( __FILE__ ), 'lw_gallery_nonce' );
    ?>
    <a class="button add_gallery_image" href="#">Add image</a>
    <div class="gallery-container"<?php echo ($gallery && count($gallery) > 0) ? '' : ' style="display: none"'; ?>>
      <h3>Gallery Order</h3>
      <p class="description">Click and drag the thumbnails to reorder gallery images</p>
      <div class="last-word-gallery-order">
        <?php
        if ($gallery && count($gallery) > 0) {
          $image_id = 1;
          foreach ($gallery as $gallery_image) {
            echo '<div class="gallery-image-container">';

            if (isset($gallery_image['media_id']) && $gallery_image['media_id'] != '') {
              $media_url = wp_get_attachment_image_src($gallery_image['media_id'], 'popular-article-small');
              echo '<img src="' . $media_url[0] . '" />';
            }
            else if (isset($gallery_image['url']) && $gallery_image['url'] != '') {
              echo '<img src="' . str_replace('640x410', '185x104', $gallery_image['url']) . '" />';
            }
            echo '<input type="hidden" name="gallery-image-id" value="' . $image_id . '">';
            echo '<input type="hidden" name="gallery-image-order" value="' . $gallery_image['order'] . '">';
            echo '</div>';
            $image_id++;
          }
        }
        ?>
      </div>
      <h3>Gallery Image Details</h3>
      <table class="form-table last-word-gallery">
        <thead>
          <tr>
            <th class="order">Order</th>
            <th class="thumbnail">Thumbnail</th>
            <th class="caption">Caption</th>
            <th class="description">Description</th>
            <th class="remove"></th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($gallery && count($gallery) > 0) {
            $image_id = 1;
            foreach ($gallery as $gallery_image) {
              echo '<tr id="gallery_image_' . $image_id . '">';
              echo '<td class="order">';
              echo '<span>' . $gallery_image['order'] . '</span>';
              echo '<input type="hidden" name="gallery-image-id[]" value="' . $image_id . '">';
              echo '<input type="hidden" name="gallery-image-order[]" value="' . $gallery_image['order'] . '">';
              echo '<input type="hidden" name="gallery-image-media-id[]" value="' . (array_key_exists('media_id', $gallery_image) ?  $gallery_image['media_id'] : '') . '">';
              echo '<input type="hidden" name="gallery-image-url[]" value="' . (array_key_exists('url', $gallery_image) ?  $gallery_image['url'] : '') . '">';
              echo '</td>';

              if (isset($gallery_image['media_id']) && $gallery_image['media_id'] != '') {
                $media_url = wp_get_attachment_image_src($gallery_image['media_id'], 'popular-article-small');
                echo '<td class="thumbnail"><img src="' . $media_url[0] . '" /></td>';
              }
              else if (isset($gallery_image['url']) && $gallery_image['url'] != '') {
                echo '<td class="thumbnail"><img src="' . str_replace('640x410', '185x104', $gallery_image['url']) . '" /></td>';
              }
              echo '<td class="caption"><textarea class="widefat" rows="5" name="gallery-image-caption[]">' . $gallery_image['caption'] . '</textarea></td>';
              echo '<td class="description">';
              wp_editor($gallery_image['description'], $image_id . '_gallery-image-description', array(
                'media_buttons' => false,
                'teeny' => true,
                'textarea_rows' => 4,
                'textarea_name' => 'gallery-image-description[]'
              ));
              echo '</td>';
              echo '<td class="remove"><div class="dashicons-before dashicons-no remove_' . $image_id . '"></div></td>';
              echo '</tr>';
              $image_id++;
            }
          }
          ?>
        </tbody>
      </table>
      <div style="display:none">
        <?php
        wp_editor('', 'no_gallery-image-description', array(
          'media_buttons' => false,
          'teeny' => true,
          'textarea_rows' => 4
        ));
        ?>
      </div>
    </div>
  <?php
  }

  function prep_image_sizes_js($response, $attachment, $meta) {
    $size = 'popular-article-small';

    if (isset($meta['sizes'][$size])) {
      $attachment_url = wp_get_attachment_url($attachment->ID);
      $base_url = str_replace(wp_basename($attachment_url), '', $attachment_url);
      $size_meta = $meta['sizes'][$size];

      $response['sizes'][$size] = array(
        'height' => $size_meta['height'],
        'width' => $size_meta['width'],
        'url' => $base_url . $size_meta['file'],
        'orientation' => $size_meta['height'] > $size_meta['width'] ? 'portrait' : 'landscape'
      );
    }

    return $response;
  }

  function add_editor() {
    parse_str($_POST['data_post'], $options);
    $id = $options['id'];
    wp_editor('', $id . '_gallery-image-description', array(
      'media_buttons' => false,
      'teeny' => true,
      'textarea_rows' => 4,
      'textarea_name' => 'gallery-image-description[]'
    ));

    die();
  }

  function save_lw_gallery($post_id) {
    $lw_gallery = array();
    if (isset($_POST['gallery-image-id'])) {
      $image_ids = $_POST['gallery-image-id'];
      $image_orders = $_POST['gallery-image-order'];
      $image_media_ids = $_POST['gallery-image-media-id'];
      $image_urls = $_POST['gallery-image-url'];
      $image_captions = $_POST['gallery-image-caption'];
      $image_descriptions = $_POST['gallery-image-description'];
      $i = 1;
      foreach($image_ids as $index => $image_id) {
        $lw_gallery[$i] = array(
          'order' => $image_orders[$index],
          'media_id' => $image_media_ids[$index],
          'url' => $image_urls[$index],
          'caption' => $image_captions[$index],
          'description' => $image_descriptions[$index]
        );
        $i++;
      }

      update_post_meta($post_id, 'lw_gallery', $lw_gallery);
    }

  }

}


$last_word_gallery = new last_word_gallery();

// Expose function for Last Word Gallery Template Tag
if (!function_exists('last_word_gallery')) {
  function last_word_gallery() {
    echo last_word_gallery::last_word_gallery();
  }
}
