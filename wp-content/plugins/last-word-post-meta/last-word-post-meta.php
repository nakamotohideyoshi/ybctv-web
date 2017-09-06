<?php
/*
Plugin Name: Last Word Post Meta
Plugin URI: http://www.ybc.tv
Description: Post Meta for Last Word articles
Author: yBC
Version: 1.0
Author URI: http://www.ybc.tv
*/

class last_word_post_meta {

  function __construct() {
    add_action('add_meta_boxes', array($this, 'add_lw_meta_boxes'));
    add_action('save_post', array($this, 'save_lw_meta'));
  }

  function add_lw_meta_boxes() {
    add_meta_box('lw_pull_quote', 'Pull Quote', array($this, 'add_lw_pull_quote'), 'post');
    add_meta_box('lw_meta', 'Last Word Meta', array($this, 'add_lw_meta'), 'post');
    add_meta_box('lw_premium_meta', 'Premium', array($this, 'add_lw_premium'), 'post', 'side');
    add_meta_box('lw_cross_post', 'Cross Post', array($this, 'add_lw_cross_post'), 'post', 'side');
    add_meta_box('lw_brightcove_video', 'Brightcove Video', array($this, 'add_lw_brightcove_video'), 'post', 'side');
  }

  function add_lw_pull_quote() {
    global $post;
    ?>

    <label class="screen-reader-text" for="lw_pull_quote">Pull Quote</label>
    <textarea class="widefat" rows="2" name="lw_pull_quote" id="lw_pull_quote"><?php echo $post->lw_pull_quote ?></textarea>

    <?php
  }

  function add_lw_meta() {
    global $post;

    wp_nonce_field( basename( __FILE__ ), 'lw_meta_nonce' );
    ?>

    <p>
      Old Article ID:<br />
      <input type="text" name="lw_old_article_id" id="lw_old_article_id" value="<?php echo get_post_meta($post->ID, 'lw_old_article_id', true); ?>" />
    </p>
    <p>
      Primary Medium:<br />
      <input type="text" name="lw_primary_medium" value="<?php echo get_post_meta($post->ID, 'lw_primary_medium', true); ?>" />
    </p>
    <p>
      Content Type:<br />
      <input type="text" name="lw_content_type" value="<?php echo get_post_meta($post->ID, 'lw_content_type', true); ?>" />
    </p>
    <p>
      Sub Title:<br />
      <input type="text" name="lw_subtitle" value="<?php echo get_post_meta($post->ID, 'lw_subtitle', true); ?>" />
    </p>
    <p>
      Description:<br />
      <input type="text" name="lw_description" value="<?php echo get_post_meta($post->ID, 'lw_description', true); ?>" />
    </p>
    <p>
      Expiry Date:<br />
      <input type="text" name="lw_expiry_date" value="<?php echo get_post_meta($post->ID, 'lw_expiry_date', true); ?>" />
    </p>
    <p>
      Sponsored:<br />
      <input type="text" name="lw_sponsored" value="<?php echo get_post_meta($post->ID, 'lw_sponsored', true); ?>" />
    </p>
    <p>
      Twitter Headline:<br />
      <input type="text" name="lw_twitter_headline" value="<?php echo get_post_meta($post->ID, 'lw_twitter_headline', true); ?>" />
    </p>
    <p>
      Read Count:<br />
      <input type="text" name="lw_read_count" value="<?php echo get_post_meta($post->ID, 'lw_read_count', true); ?>" />
    </p>

    <?php
  }

  function add_lw_premium() {
    global $post;

    $premium = get_post_meta($post->ID, 'lw_premium', true);
    ?>
    <label for="lw_premium">
      <input type="checkbox" name="lw_premium" id="lw_premium" value="yes"<?php echo $premium == 'yes' ? ' checked' : ''; ?> />
      Premium Content
    </label>
    <?php

  }

  function add_lw_cross_post() {
    global $post;

    $cross_facebook = get_post_meta($post->ID, 'lw_cross_post_facebook', true);
    $cross_twitter = get_post_meta($post->ID, 'lw_cross_post_twitter', true);
    $cross_linkedin = get_post_meta($post->ID, 'lw_cross_post_linkedin', true);
    $cross_google_plus = get_post_meta($post->ID, 'lw_cross_post_google_plus', true);
    ?>
    <p>
      <label for="lw_cross_post_facebook">
        <input type="checkbox" name="lw_cross_post_facebook" id="lw_cross_post_facebook" value="yes"<?php echo $cross_facebook == 'yes' ? ' checked' : ''; ?> />
        Facebook
      </label>
    </p>
    <p>
      <label for="lw_cross_post_twitter">
        <input type="checkbox" name="lw_cross_post_twitter" id="lw_cross_post_twitter" value="yes"<?php echo $cross_twitter == 'yes' ? ' checked' : ''; ?> />
        Twitter
      </label>
    </p>
    <p>
      <label for="lw_cross_post_linkedin">
        <input type="checkbox" name="lw_cross_post_linkedin" id="lw_cross_post_linkedin" value="yes"<?php echo $cross_linkedin == 'yes' ? ' checked' : ''; ?> />
        LinkedIn
      </label>
    </p>
      <label for="lw_cross_post_google_plus">
        <input type="checkbox" name="lw_cross_post_google_plus" id="lw_cross_post_google_plus" value="yes"<?php echo $cross_google_plus == 'yes' ? ' checked' : ''; ?> />
        Google+
      </label>
    </p>
    <?php

  }

  function add_lw_brightcove_video() {
    global $post;

    $brightcove_video_id = get_post_meta($post->ID, 'lw_brightcove_video_id', true);
    ?>

    <label for="lw_premium">Brightcove Video ID</label>
    <input type="text" name="lw_brightcove_video_id" id="lw_brightcove_video_id" value="<?php echo $brightcove_video_id ?>" />
    <?php

  }

  function save_lw_meta($post_id) {
    if (isset($_POST['lw_meta_nonce'])) {
      update_post_meta($post_id, 'lw_old_article_id', strip_tags($_POST['lw_old_article_id']));
      update_post_meta($post_id, 'lw_primary_medium', strip_tags($_POST['lw_primary_medium']));
      update_post_meta($post_id, 'lw_content_type', strip_tags($_POST['lw_content_type']));
      update_post_meta($post_id, 'lw_subtitle', strip_tags($_POST['lw_subtitle']));
      update_post_meta($post_id, 'lw_description', strip_tags($_POST['lw_description']));
      update_post_meta($post_id, 'lw_expiry_date', strip_tags($_POST['lw_expiry_date']));
      update_post_meta($post_id, 'lw_sponsored', strip_tags($_POST['lw_sponsored']));
      update_post_meta($post_id, 'lw_twitter_headline', strip_tags($_POST['lw_twitter_headline']));
      update_post_meta($post_id, 'lw_brightcove_video_id', strip_tags($_POST['lw_brightcove_video_id']));
      update_post_meta($post_id, 'lw_read_count', strip_tags($_POST['lw_read_count']));
      update_post_meta($post_id, 'lw_pull_quote', strip_tags($_POST['lw_pull_quote']));

      if (isset($_POST['lw_premium'])) {
        update_post_meta($post_id, 'lw_premium', 'yes');
      }
      else {
        update_post_meta($post_id, 'lw_premium', '');
      }

      if (isset($_POST['lw_cross_post_facebook'])) {
        update_post_meta($post_id, 'lw_cross_post_facebook', 'yes');
      }
      else {
        update_post_meta($post_id, 'lw_cross_post_facebook', '');
      }

      if (isset($_POST['lw_cross_post_twitter'])) {
        update_post_meta($post_id, 'lw_cross_post_twitter', 'yes');
      }
      else {
        update_post_meta($post_id, 'lw_cross_post_twitter', '');
      }

      if (isset($_POST['lw_cross_post_linkedin'])) {
        update_post_meta($post_id, 'lw_cross_post_linkedin', 'yes');
      }
      else {
        update_post_meta($post_id, 'lw_cross_post_linkedin', '');
      }

      if (isset($_POST['lw_cross_post_google_plus'])) {
        update_post_meta($post_id, 'lw_cross_post_google_plus', 'yes');
      }
      else {
        update_post_meta($post_id, 'lw_cross_post_google_plus', '');
      }
    }
  }

}

$last_word_post_meta = new last_word_post_meta();
