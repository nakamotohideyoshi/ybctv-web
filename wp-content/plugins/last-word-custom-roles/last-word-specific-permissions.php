<?php
/*
Plugin Name: Last Word Custom Roles
Plugin URI: http://www.ybc.tv
Description: Define custom roles
Author: yBC
Version: 1.0
Author URI: http://www.ybc.tv
*/

function last_word_custom_roles() {
  // Last Word Administrator
  $role = get_role('last_word_administrator');

  if (!$role) {
    add_role(
      'last_word_administrator',
      'Last Word Administrator',
      array(
        'delete_others_pages' => true,
        'delete_others_posts' => true,
        'delete_pages' => true,
        'delete_posts' => true,
        'delete_private_pages' => true,
        'delete_private_posts' => true,
        'delete_published_pages' => true,
        'delete_published_posts' => true,
        'edit_others_pages' => true,
        'edit_others_posts' => true,
        'edit_pages' => true,
        'edit_posts' => true,
        'edit_private_pages' => true,
        'edit_private_posts' => true,
        'edit_published_pages' => true,
        'edit_published_posts' => true,
        'manage_categories' => true,
        'manage_links' => true,
        'moderate_comments' => true,
        'publish_pages' => true,
        'publish_posts' => true,
        'read' => true,
        'read_private_pages' => true,
        'read_private_posts' => true,
        'upload_files' => true,
        'list_users' => true,
        'edit_users' => true,
        'create_users' => true,
        'delete_users' => true,
        'manage_network_users' => true
      )
    );
  }
  else {
    $role->add_cap('delete_others_pages');
    $role->add_cap('delete_others_posts');
    $role->add_cap('delete_pages');
    $role->add_cap('delete_posts');
    $role->add_cap('delete_private_pages');
    $role->add_cap('delete_private_posts');
    $role->add_cap('delete_published_pages');
    $role->add_cap('delete_published_posts');
    $role->add_cap('edit_others_pages');
    $role->add_cap('edit_others_posts');
    $role->add_cap('edit_pages');
    $role->add_cap('edit_posts');
    $role->add_cap('edit_private_pages');
    $role->add_cap('edit_private_posts');
    $role->add_cap('edit_published_pages');
    $role->add_cap('edit_published_posts');
    $role->add_cap('manage_categories');
    $role->add_cap('manage_links');
    $role->add_cap('moderate_comments');
    $role->add_cap('publish_pages');
    $role->add_cap('publish_posts');
    $role->add_cap('read');
    $role->add_cap('read_private_pages');
    $role->add_cap('read_private_posts');
    $role->add_cap('upload_files');
    $role->add_cap('list_users');
    $role->add_cap('edit_users');
    $role->add_cap('create_users');
    $role->add_cap('delete_users');
    $role->add_cap('manage_network_users');
  }
}

add_action('admin_init', 'last_word_custom_roles');
