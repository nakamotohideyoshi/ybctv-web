<?php
/*
Plugin Name: Last Word Featured Image
Plugin URI: http://www.ybc.tv
Description: Allow for non Media Library images to be set as Post's Featured Image
Author: yBC
Version: 1.0
Author URI: http://www.ybc.tv
*/

class last_word_featured_image {
  function __construct() {
    add_filter('admin_post_thumbnail_html', array($this, 'add_featured_image_url_field'), 10, 2);
    add_action( 'save_post', array($this, 'save_featured_image_url'), 10, 2);
    add_filter( 'post_thumbnail_html', array($this, 'featured_image_url_replace'), 10, PHP_INT_MAX);
  }

  function add_featured_image_url_field($html, $post_id) {
    global $post;

    $featured_image_url = get_post_meta($post_id, 'lw_featured_image_url', true);
    $nonce = wp_create_nonce('lw_featured_image_url_' . $post_id);

    ob_start();

    ?>
    <input type="hidden" name="lw_featured_image_url_nonce" value="<?php echo esc_attr($nonce); ?>">
    <div>
      <p class="howto">Or enter the url for image outside of the Media Library</p>
      <p><input type="url" name="lw_featured_image_url" value="<?php echo $featured_image_url ?>" /></p>
      <?php
        if (!empty($featured_image_url) && $this->is_image($featured_image_url)) {
          ?>
            <p><img stype="max-width:150px;height:auto" src="<?php echo esc_url($featured_image_url); ?>" /></p>
          <?php
        }
      ?>
    </div>
    <?php

    return $html . ob_get_clean();
  }

  function save_featured_image_url($post_id) {
    if (isset($_POST['lw_featured_image_url_nonce'])) {
      if ($_POST['lw_featured_image_url'] != '') {
        update_post_meta($post_id, 'lw_featured_image_url', esc_url($_POST['lw_featured_image_url']));

        if (!get_post_meta($post_id, '_thumbnail_id', true)) {
          update_post_meta($post_id, '_thumbnail_id', 'by_url');
        }
      }
      else {
        delete_post_meta($post_id, 'lw_featured_image_url');
        if (get_post_meta($post_id, '_thumbnail_id', true) === 'by_url') {
          delete_post_meta($post_id, '_thumbnail_id');
        }
      }
    }
  }

  function featured_image_url_replace($html, $post_id, $post_thumbnail_id, $size) {
    global $_wp_additional_image_sizes;

    $wp_default_sizes = array('thumbnail', 'medium', 'medium-large', 'large', 'post-thumbnail');

    $standard_featured_image = get_post_meta($post_id, '_thumbnail_id', true);
    $featured_image_url = get_post_meta($post_id, 'lw_featured_image_url', true);

    if (empty($featured_image_url)
      || !$this->is_image($featured_image_url)
      || empty($standard_featured_image)
      || $standard_featured_image != 'by_url') {
      return $html;
    }

    if ($size && !in_array($size, $wp_default_sizes)) {
      $width =  $_wp_additional_image_sizes[$size]['width'];
      $height =  $_wp_additional_image_sizes[$size]['height'];

      $featured_image_url = str_replace('640x410', $width . 'x' . $height, $featured_image_url);
    }

    $alt_text = get_post_field('post_title', $post_id);
    $attr = array('alt' => $alt_text);
    $attr = apply_filters('wp_get_attachment_image_attributes', $attr, null, $size);
    $attr = array_map('esc_attr', $attr);

    $html = '<img src="' . esc_url($featured_image_url) . '"';
    foreach($attr as $name => $value) {
      $html .= ' ' . $name . '="' . $value . '"';
    }

    $html .= ' />';

    return $html;
  }

  function is_image($url) {
    $ext = array('jpeg', 'jpg', 'gif', 'png');
    $info = (array) pathinfo( parse_url($url, PHP_URL_PATH));
    return isset($info['extension']) && in_array( strtolower($info['extension']), $ext, true);
  }
}

$last_word_featured_image = new last_word_featured_image();
