<?php
/*
Plugin Name: Last Word Image Sizes
Plugin URI: http://www.ybc.tv
Description: Image sizes required for Last Word sites
Author: yBC
Version: 1.0
Author URI: http://www.ybc.tv
*/

class last_word_image_sizes {
  function __construct() {
    add_image_size('main-article', 553, 311, true);
    add_image_size('homepage-latest-article', 333, 307, true);
    add_image_size('section-article', 327, 184, true);
    add_image_size('featured-article', 300, 184, true);
    add_image_size('popular-article', 234, 132, true);
    add_image_size('listing-article', 214, 120, true);
    add_image_size('popular-article-small', 185, 104, true);
    add_image_size('thumbnail-article', 96, 96, true);
    add_image_size('email-article', 219, 122, true);
  }
}

$last_word_image_sizes = new last_word_image_sizes();
