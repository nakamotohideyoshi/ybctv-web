<?php
/*
Plugin Name: Last Word Gallery
Plugin URI: http://www.ybc.tv
Description: Gallery functionality for Last Word sites
Author: yBC
Version: 1.0
Author URI: http://www.ybc.tv
*/

function enqueue_gallery_style() {
  wp_enqueue_style('last_word_gallery', plugin_dir_url(__FILE__) . '/style.css', array(), '1.0.0');
}

add_action('wp_enqueue_scripts', 'enqueue_gallery_style');

function last_word_gallery() {
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
    <img class="gallery-image" src="http://<?php echo $current_image['url']; ?>" alt="<?php echo $current_image['caption']; ?>" />
    <img class="gallery-icon" src="<?php echo plugin_dir_url(__FILE__); ?>/images/gallery-icon.png" alt="Gallery" />
    <?php
      // Image links
      foreach ($gallery as $key => $gallery_image) {
        if ($key == $current_position) {
          echo '<span class="image-selected">' . $key . '</span>';
        }
        else {
          echo '<a class="image-nav" href="' . home_url($wp->request) . '?gallery-image=' . $key . '">' . $key . '</a>';
        }
      }

      // Prev/Next links
      if ($current_position != count($gallery)) {
        echo '<a class="image-next" href="' . home_url($wp->request) . '?gallery-image=' . ($current_position + 1) . '"><img src="' . plugin_dir_url(__FILE__) . '/images/arrow-right.png" /></a>';
      }

      if ($current_position > 1) {
        echo '<a class="image-prev" href="' . home_url($wp->request) . '?gallery-image=' . ($current_position - 1) . '"><img src="' . plugin_dir_url(__FILE__) .  '/images/arrow-left.png" /></a>';
      }
    ?>

    <p><?php echo $current_image['description']; ?></p>
  </div>
  <?php
}


function add_last_word_gallery_style() {

}

add_action('wp_head', 'add_last_word_gallery_style');
