<?php
/*
Plugin Name: Last Word Magazines
Plugin URI: http://www.ybc.tv
Description: Magazines custom post type
Author: yBC
Version: 1.0
Author URI: http://www.ybc.tv
*/

class last_word_magazines {
    function __construct() {
      add_action('init', array($this, 'register_magazine_post_type'));
      add_action('manage_edit-magazine_columns', array($this, 'add_magazine_columns'));
      add_action('manage_magazine_posts_custom_column', array($this, 'manage_magazine_columns'), 10, 2);
      add_action('add_meta_boxes', array($this, 'add_magazine_meta_box'));
      add_action('save_post', array($this, 'save_magazine_detail_meta'));
    }

    function register_magazine_post_type() {
      $labels = array(
        'name' => 'Magazines',
        'singular_name' => 'Magazine',
        'add_new_item' => 'Add New Magazine',
        'edit_item' => 'Edit Magazine',
        'new_item' => 'New Magazine',
        'view_item' => 'View Magazine',
        'view_items' => 'View Magazines',
        'search_items' => 'Search Magazines',
        'not_found' => 'No Magazines Found',
        'not_found_in_trash' => 'No Magazines Found in Trash',
        'all_items' => 'All Magazines',
        'archives' => 'Magazines Archive',
        'update_item' => 'Update Magazine'
      );

      $args = array(
        'labels' => $labels,
        'menu_icon' => 'dashicons-book',
        'description' => 'Magazines post type',
        'public' => true,
        'show_ui' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'rewrite' => array('slug' => 'magazine', 'with_front' => false),
        'menu_position' => 5
      );

      register_post_type('magazine', $args);

    }

    function add_magazine_columns($columns) {
      $columns['lw_magazine_link'] = 'Edition Link';
      return $columns;
    }

    function manage_magazine_columns($column, $post_id) {
      if ($column == 'lw_magazine_link') {
        $link = get_post_meta($post_id, 'lw_magazine_link', true);
        echo $link ? '<a target="_blank" href="' . $link . '">View</a>' : 'Not specified';
      }
    }

    function add_magazine_meta_box($post) {
      add_meta_box('magazine_meta_box', 'Digital Edition Link', array($this, 'populate_magazine_meta_box'), 'magazine', 'normal');
    }

    function populate_magazine_meta_box() {
      global $post;
      wp_nonce_field( basename( __FILE__ ), 'lw_magazine_detail_meta_nonce' );
      ?>
      <table class="form-table">
        <tr>
          <th scope="row">Link</th>
          <td>
            <input size="60" type="text" name="lw_magazine_link" id="lw_magazine_link" value="<?php echo get_post_meta($post->ID, 'lw_magazine_link', true); ?>" />
            <p class="description">
              Please include http:// or https://
            </p>
          </td>
        <tr>
      </table>
      <?php
    }

    function save_magazine_detail_meta($post_id) {
      if (isset($_POST['lw_magazine_detail_meta_nonce'])) {
        update_post_meta($post_id, 'lw_magazine_link', strip_tags($_POST['lw_magazine_link']));
      }
    }
}

$last_word_magazines = new last_word_magazines();
