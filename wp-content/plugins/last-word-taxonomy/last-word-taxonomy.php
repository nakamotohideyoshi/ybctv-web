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
    add_action('admin_menu', array($this, 'remove_types_meta_box'));
    add_action('add_meta_boxes', array($this, 'add_types_meta_box'));
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
      'hierarchical' => true,
      'labels' => $labels,
      'show_ui' => true,
      'query_var' => true,
      'rewrite' => array('slug' => 'type'),
      'show_in_rest' => true,
      'show_in_nav_menus' => true,
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

  function remove_types_meta_box() {
    remove_meta_box('typediv', 'post', 'side');
  }

  function add_types_meta_box() {
    add_meta_box('type_meta', 'Type', array($this, 'populate_type_meta_box'), 'post', 'side', 'core');
  }

  function populate_type_meta_box($post) {
    $taxonomy_name = 'type';
    $taxonomy = get_taxonomy($taxonomy_name);
    $field_name = 'tax_input[' . $taxonomy_name . ']';

    $types = get_terms($taxonomy_name, array('hide_empty' => 0));

    $post_types = get_the_terms($post->ID, $taxonomy_name);
    $current = ($post_types ? array_pop($post_types) : false);
    $current = ($current ? $current->term_id : 0);

    ?>
    <div id="<?php echo $taxonomy_name; ?>-all">
      <ul id="<?php echo $taxonomy_name; ?>checklist" class="list:<?php echo $taxonomy_name; ?> categorychecklist form-no-clear">
        <?php
          foreach($types as $type) {
            $id = $taxonomy_name . '-' . $type->term_id;

            echo '<li id=' . $id . '>';
            echo '<label class="selectit">';
            echo '<input type="radio" id="in-' . $id . '" name="' . $field_name . '"' . checked($current, $type->term_id, false) . ' value="' . $type->term_id . '" />';
            echo $type->name . '<br />';
            echo '</label>';
            echo '</li>';
          }
        ?>
      </ul>
    </div>
    <?php
  }
}

$taxonomy = new last_word_taxonomy();
