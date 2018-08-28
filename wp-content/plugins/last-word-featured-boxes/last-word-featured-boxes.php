<?php
/*
Plugin Name: Last Word Featured Boxes
Plugin URI: http://www.ybc.tv
Description: Settings for featured boxes
Author: yBC
Version: 1.0
Author URI: http://www.ybc.tv
*/

add_action('admin_menu', 'add_featured_boxes_settings_menu_item');
add_action('admin_init', 'register_featured_boxes_settings');

function add_featured_boxes_settings_menu_item() {
  add_options_page (
      'Featured Boxes',
      'Featured Boxes',
      'edit_posts',
      'featured_box_settings',
      'add_featured_boxes_settings_page'
  );
}

function add_featured_boxes_settings_page() {
  $posts = get_posts(array('posts_per_page' => 100));

  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['featured_left_box_article']))
  {
    update_option('featured_left_box_article', $_POST['featured_left_box_article']);
  }

  $featured_left_box_article = get_option('featured_left_box_article', 0);
  ?>
  <div class="most-read-settings wrap">
    <h2>Featured boxes</h2>
    <form action="" method="post">
      <table class="form-table">
        <tr>
          <th scope="row">Sponsored Box</th>
          <td>
            <div>
              Please either select the article from the drop down option or add the Wordpress article ID in the box.
              To find the Wordpress article ID please use the instructions from this
              <a href="https://www.youtube.com/watch?v=fLg2T1AvmFE" target="_blank">video</a>.
            </div>
            <br/>
            <select name="featured_left_box_article" id="featured_left_box_article_combo" onchange="document.getElementById('featured_left_box_article_field').value = this.value;">
              <option value="">-</option>
              <?php foreach($posts as $post): ?>
                <option value="<?php echo $post->ID; ?>" <?php echo (int)$featured_left_box_article == $post->ID ? 'selected="selected"' : ''; ?>>
                  <?php echo $post->post_title; ?></option>
              <?php endforeach; ?>
            </select>
          </td>
        </tr>
        <tr>
          <th scope="row">&nbsp;</th>
          <td>
            <input type="text" id="featured_left_box_article_field" name="featured_left_box_article" value="<?php echo $featured_left_box_article; ?>" />
            <span>(Wordpress article ID)</span>
          </td>
        </tr>
        <tr>
          <th colspan="2">
            <?php submit_button(); ?>
          </th>
      </table>
    </form>
  </div>
  <?php
}

function sponsoredContentBanner() {
  $sponsored_content_banner = get_option('featured_left_box_article', 0);

  if ($sponsored_content_banner != 0 && $sponsored_content_banner != '0' && $sponsored_content_banner != '') {
    $args = array(
      'posts_per_page' => 1,
      'numberposts' => 1,
      'p' => $sponsored_content_banner
    );

    wp_reset_query();

    $sponsored_article = query_posts($args);

    if (have_posts()) : while (have_posts()) : the_post();
      $sponsored_article_permalink = get_the_permalink();
      $sponsored_article_title = get_the_title();
      $sponsored_article_sponsor = get_post_meta($sponsored_content_banner, 'lw_sponsored', true);
    ?>
    <div class="sponsored-content-banner">
      <?php
        if (has_post_thumbnail()) {
          echo '<a href="' . $sponsored_article_permalink . '">';
          the_post_thumbnail('thumbnail-article');
          echo '</a>';
        }

        if ($sponsored_article_sponsor && $sponsored_article_sponsor != '') {
          echo '<span class="name-cat">Sponsored by ' . $sponsored_article_sponsor . '</span><br>';
        }

        echo '<a href="' . $sponsored_article_permalink . '"><h3>' . $sponsored_article_title . '</h3></a><br>';
        echo '<span class="excerpt">' . get_excerpt(90) . '</span>';
      ?>
    </div>
    <?php
      endwhile;endif;
      wp_reset_query();
  }
}
