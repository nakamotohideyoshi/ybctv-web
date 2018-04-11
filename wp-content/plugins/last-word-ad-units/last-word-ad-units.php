<?php
/*
Plugin Name: Last Word Ad Units
Plugin URI: http://www.ybc.tv
Description: Configure and display Ad Units on Last Word sites
Author: yBC
Version: 1.0
Author URI: http://www.ybc.tv
*/

require_once(plugin_dir_path(__FILE__) . 'class.last-word-ad-units.admin.php' );
require_once(plugin_dir_path(__FILE__) . 'class.last-word-ad-units.frontend.php' );

$admin = new last_word_ad_units\admin();
$frontend = new last_word_ad_units\frontend();

// Expose function for Initialize Ad Units Template Tag
if (!function_exists('lastWordAdUnitInitialize')) {
  function lastWordAdUnitInitialize($post_id) {
    $show_ad_units_status = get_option('show_ad_units');

    if ($show_ad_units_status && $show_ad_units_status == 'yes') {
      echo last_word_ad_units\frontend::last_word_ad_unit_initialize($post_id);
    }
  }
}

// Expose function for Ad Unit Template Tag
if (!function_exists('lastWordAdUnit')) {
  function lastWordAdUnit($slug) {
    $show_ad_units_status = get_option('show_ad_units');

    if ($show_ad_units_status && $show_ad_units_status == 'yes') {
      $id = is_home() ? 0 : get_the_ID();
      echo last_word_ad_units\frontend::last_word_ad_unit($slug, $id);
    }
  }
}


// Expose function for Ad Unit Template Tag (improved performance version)
if (!function_exists('lastWordAdUnit2')) {
    function lastWordAdUnit2($slug) {
        $show_ad_units_status = get_option('show_ad_units');

        if ($show_ad_units_status && $show_ad_units_status == 'yes') {
            $id = is_home() ? 0 : get_the_ID();
            echo last_word_ad_units\frontend::last_word_ad_unit2($slug, $id);
        }
    }
}
