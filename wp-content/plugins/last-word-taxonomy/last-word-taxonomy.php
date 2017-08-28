<?php
/*
Plugin Name: Last Word Taxonomy
Plugin URI: http://www.ybc.tv
Description: Custom Taxonomy for Last Word sites
Author: yBC
Version: 1.0
Author URI: http://www.ybc.tv
*/

class last_word_taxonomy {

  function __construct() {
    add_action('init', array($this, 'add_taxonomy'), 0);
  }

  function add_taxonomy() {
    // Types
    $labels = array(
      'name' => __('Types', 'last_word_taxonomy'),
      'singular_name' => __('Type', 'last_word_taxonomy'),
      'search_items' =>  __('Search Types', 'last_word_taxonomy'),
      'all_items' => __('All Types', 'last_word_taxonomy'),
      'new_item'	=> __('New Type', 'last_word_taxonomy'),
      'edit_item' => __('Edit Type', 'last_word_taxonomy'),
      'update_item' => __('Update Type', 'last_word_taxonomy'),
      'add_new_item' => __('Add New Type', 'last_word_taxonomy'),
      'new_item_name' => __('New Type Name', 'last_word_taxonomy'),
      'view_item' => __('View Type', 'last_word_taxonomy'),
      'archives' => __('Type Archives', 'last_word_taxonomy'),
      'not_found' => __('No Types found', 'last_word_taxonomy'),
      'not_found_in_trash' => __('No Types found in Trash', 'last_word_taxonomy'),
      'menu_name' => __('Types', 'last_word_taxonomy')
    );

    register_taxonomy('type', array('post'), array(
      'hierarchical' => false,
      'labels' => $labels,
      'show_ui' => true,
      'query_var' => true,
      'rewrite' => array('slug' => 'type'),
      'show_in_rest' => true,
      'rest_base' => 'article-types',
      'rest_controller_class' => 'WP_REST_Terms_Controller'
    ));

    // Collections
    $labels = array(
      'name' => __('Collections', 'last_word_taxonomy'),
      'singular_name' => __('Collection', 'last_word_taxonomy'),
      'search_items' =>  __('Search Collections', 'last_word_taxonomy'),
      'all_items' => __('All Collections', 'last_word_taxonomy'),
      'new_item'	=> __('New Collection', 'last_word_taxonomy'),
      'edit_item' => __('Edit Collection', 'last_word_taxonomy'),
      'update_item' => __('Update Collection', 'last_word_taxonomy'),
      'add_new_item' => __('Add New Collection', 'last_word_taxonomy'),
      'new_item_name' => __('New Collection Name', 'last_word_taxonomy'),
      'view_item' => __('View Collection', 'last_word_taxonomy'),
      'archives' => __('Collection Archives', 'last_word_taxonomy'),
      'not_found' => __('No Collections found', 'last_word_taxonomy'),
      'not_found_in_trash' => __('No Collections found in Trash', 'last_word_taxonomy'),
      'menu_name' => __('Collections', 'last_word_taxonomy')
    );

    register_taxonomy('collection', array('post'), array(
      'hierarchical' => false,
      'labels' => $labels,
      'show_ui' => true,
      'query_var' => true,
      'rewrite' => array('slug' => 'collection'),
      'show_in_rest' => true,
      'rest_base' => 'article-collections',
      'rest_controller_class' => 'WP_REST_Terms_Controller'
    ));
  }
}

$taxonomy = new last_word_taxonomy();
