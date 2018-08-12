<?php
/*
Plugin Name: Last Word Tag Manager
Plugin URI: http://www.ybc.tv
Description: Adds Google Tag Manager functionality
Author: yBC
Version: 1.0
Author URI: http://www.ybc.tv
*/

require_once(plugin_dir_path(__FILE__) . 'class.last-word-tag-manager.admin.php' );
require_once(plugin_dir_path(__FILE__) . 'class.last-word-tag-manager.frontend.php' );

$admin = new last_word_tag_manager\admin();
$frontend = new last_word_tag_manager\frontend();

add_action('init', 'tag_manager_add_scripts');

function tag_manager_add_scripts() {
  if (!is_admin()) {
    add_action('tagManagerHeadScript', 'tagManagerHeadScript');
    add_action('tagManagerBodyScript', 'tagManagerBodyScript');
  }
}

function tagManagerHeadScript() {
  echo last_word_tag_manager\frontend::tag_manager_head_script();
}

function tagManagerBodyScript() {
  echo last_word_tag_manager\frontend::tag_manager_body_script();
}
