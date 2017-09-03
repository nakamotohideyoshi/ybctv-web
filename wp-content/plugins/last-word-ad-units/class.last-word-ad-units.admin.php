<?php namespace last_word_ad_units;

class admin {
  function __construct() {
    add_action('init', array($this, 'register_ad_unit_post_type'));
    add_action('init', array($this, 'register_ad_unit_group_taxonomy'));

    add_filter('manage_edit-lw_ad_unit_columns', array($this, 'add_ad_unit_columns'));
    add_action('manage_lw_ad_unit_posts_custom_column', array($this, 'manage_ad_unit_columns'), 10, 2);

    add_action('admin_menu', array($this, 'remove_ad_unit_group_meta_box'));
    add_action('add_meta_boxes', array($this, 'add_ad_unit_group_meta_box'));
    add_action('add_meta_boxes', array($this, 'add_ad_unit_detail_meta_box'));

    add_action('save_post', array($this, 'save_ad_unit_detail_meta'));
  }

  // Register custom post type
  function register_ad_unit_post_type() {
    $labels = array(
      'name' => 'Ad Units',
      'singular_name' => 'Ad Unit',
      'add_new_item' => 'Add New Ad Unit',
      'edit_item' => 'Edit Ad Unit',
      'new_item' => 'New Ad Unit',
      'view_item' => 'View Ad Unit',
      'view_items' => 'View Ad Units',
      'search_items' => 'Search Ad Units',
      'not_found' => 'No Ad Units Found',
      'not_found_in_trash' => 'No Ad Units Found in Trash',
      'all_items' => 'All Ad Units',
      'archives' => 'Ad Units Archive',
      'update_item' => 'Update Ad Unit'
    );

    $args = array(
      'labels' => $labels,
      'menu_icon' => 'dashicons-align-right',
      'description' => 'Ad Unit to display on pages and posts',
      'public' => false,
      'show_ui' => true,
      'supports' => array('title')
    );

    register_post_type('lw_ad_unit', $args);
  }

  // Register custom taxonomy
  function register_ad_unit_group_taxonomy() {
    $labels = array(
      'name' => 'Ad Unit Groups',
      'singular_name' => 'Ad Unit Group',
      'search_items' => 'Search Ad Unit Groups',
      'all_items' => 'All Ad Unit Groups',
      'edit_item' => 'Edit Ad Unit Group',
      'update_item' => 'Update Ad Unit Group',
      'add_new_item' => 'Add New Ad Unit Group',
      'new_item_name' => 'New Ad Unit Group Name',
      'menu_name' => 'Ad Unit Groups',
      'view_item' => 'View Ad Unit Group',
      'popular_item' => 'Popular Ad Unit Group',
      'not_found' => 'No Ad Unit Groups Found'
    );

    $args = array(
      'labels' => $labels,
      'rewrite' => array('slug' => 'lw-ad-unit'),
      'hierarchical' => true
    );

    register_taxonomy('lw_ad_unit_group', 'lw_ad_unit', $args);
  }

  // Add columns to Ad Unit listing
  function add_ad_unit_columns() {
    $columns = array(
      'cb' => '<input type="checkbox" />',
      'title' => 'Title',
      'lw_ad_unit_slug' => 'Slug',
      'lw_ad_unit_group_name' => 'Group',
      'lw_ad_unit_group_slug' => 'Group Slug',
      'lw_ad_unit_path' => 'Path',
      'lw_ad_unit_size' => 'Size(s)',
      'lw_ad_unit_div' => 'Target Div',
      'lw_ad_unit_variable_name' => 'Variable Name'
    );

    return $columns;
  }

  // Populate columns in Ad Unit listing
  function manage_ad_unit_columns($column, $post_id) {
    $groups = get_the_terms($post_id, 'lw_ad_unit_group');
    switch($column) {
      case 'lw_ad_unit_slug' :
        $lw_ad_unit_slug = get_post_meta($post_id, 'lw_ad_unit_slug', true);
        echo $lw_ad_unit_slug ? $lw_ad_unit_slug : 'Not specified';
        break;
      case 'lw_ad_unit_group_name' :
        echo $groups ? $groups[0]->name : 'No group specified';
        break;
      case 'lw_ad_unit_group_slug' :
        echo $groups ? $groups[0]->slug : 'No group specified';
        break;
      case 'lw_ad_unit_path' :
        $lw_ad_unit_path = get_post_meta($post_id, 'lw_ad_unit_path', true);
        echo $lw_ad_unit_path ? $lw_ad_unit_path : 'Not specified';
        break;
      case 'lw_ad_unit_size' :
        $lw_ad_unit_size = get_post_meta($post_id, 'lw_ad_unit_size', true);
        echo $lw_ad_unit_size ? $lw_ad_unit_size : 'Not specified';
        break;
      case 'lw_ad_unit_div' :
        $lw_ad_unit_div = get_post_meta($post_id, 'lw_ad_unit_div', true);
        echo $lw_ad_unit_div ? $lw_ad_unit_div : 'Not specified';
        break;
      case 'lw_ad_unit_variable_name' :
        $lw_ad_unit_variable_name = get_post_meta($post_id, 'lw_ad_unit_variable_name', true);
        echo $lw_ad_unit_variable_name ? $lw_ad_unit_variable_name : 'Not specified';
        break;
      default :
        break;
    }
  }

  // Remove default taxonomy meta box
  function remove_ad_unit_group_meta_box() {
    remove_meta_box('lw_ad_unit_groupdiv', 'lw_ad_unit', 'normal');
  }

  // Add new taxonomy meta box
  function add_ad_unit_group_meta_box($post) {
    add_meta_box('ad_unit_group', 'Ad Unit Group', array($this, 'populate_ad_unit_taxonomy_meta_box'), 'lw_ad_unit', 'side');
  }

  // Populate new taxonomy meta box with radio buttons
  function populate_ad_unit_taxonomy_meta_box($post) {
    $taxonomy_name = 'lw_ad_unit_group';
    $taxonomy = get_taxonomy($taxonomy_name);
    $field_name = 'tax_input[' . $taxonomy_name . ']';

    $ad_unit_groups = get_terms($taxonomy_name, array('hide_empty' => 0));

    $post_ad_unit_groups = get_the_terms($post->ID, $taxonomy_name);
    $current = ($post_ad_unit_groups ? array_pop($post_ad_unit_groups) : false);
    $current = ($current ? $current->term_id : 0);

    ?>
    <div id="<?php echo $taxonomy_name; ?>-all">
      <ul id="<?php echo $taxonomy_name; ?>checklist" class="list:<?php echo $taxonomy_name; ?> categorychecklist form-no-clear">
        <?php
          foreach($ad_unit_groups as $ad_unit_group) {
            $id = $taxonomy_name . '-' . $ad_unit_group->term_id;

            echo '<li id=' . $id . '>';
            echo '<label class="selectit">';
            echo '<input type="radio" id="in-' . $id . '" name="' . $field_name . '"' . checked($current, $ad_unit_group->term_id, false) . ' value="' . $ad_unit_group->term_id . '" />';
            echo $ad_unit_group->name . '<br />';
            echo '</label>';
            echo '</li>';
          }
        ?>
      </ul>
    </div>
    <?php
  }

  // Add detail meta box
  function add_ad_unit_detail_meta_box($post) {
    add_meta_box('lw_ad_unit_detail', 'Details', array($this, 'add_ad_unit_detail_meta'), 'lw_ad_unit', 'normal', 'high');
  }

  // Add fields to detail meta box
  function add_ad_unit_detail_meta() {
    global $post;

    wp_nonce_field( basename( __FILE__ ), 'lw_ad_unit_detail_meta_nonce' );
    ?>
    <table class="form-table">
      <tr>
        <th scope="row">Ad Unit Slug</th>
        <td>
          <input size="40" type="text" name="lw_ad_unit_slug" id="lw_ad_unit_slug" value="<?php echo get_post_meta($post->ID, 'lw_ad_unit_slug', true); ?>" />
        </td>
        <td>
          <p class="description">
            Unique identifier used for CSS class.<br />
            Naming convention [ad_unit_group] followed by [ad_position] (lowercase)<br />
            e.g. News Top Billboard would be news-top-billboard
          </p>
        </td>
      </tr>
      <tr>
        <th scope="row">Ad Unit Path</th>
        <td>
          <input size="40" type="text" name="lw_ad_unit_path" id="lw_ad_unit_path" value="<?php echo get_post_meta($post->ID, 'lw_ad_unit_path', true); ?>" />
        </td>
        <td>
          <p class="description">
            Full path of the ad unit with the network code and unit code. Reference <a href="https://developers.google.com/doubleclick-gpt/reference#googletag.defineSlot">here</a>
          </p>
        </td>
      </tr>
      <tr>
        <th scope="row">Size(s)</th>
        <td>
          <input size="40" type="text" name="lw_ad_unit_size" id="lw_ad_unit_size" value="<?php echo get_post_meta($post->ID, 'lw_ad_unit_size', true); ?>" />
        </td>
        <td>
          <p class="description">
            Ad unit size or sizes in array format. Reference <a href="https://developers.google.com/doubleclick-gpt/reference#googletag.defineSlot">here</a>
          </p>
        </td>
      </tr>
      <tr>
        <th scoope="row">Target Div ID</th>
        <td>
          <input size="40" type="text" name="lw_ad_unit_div" id="lw_ad_unit_div" value="<?php echo get_post_meta($post->ID, 'lw_ad_unit_div', true); ?>" />
        </td>
        <td>
          <p class="description">
            ID of target div. Reference <a href="https://developers.google.com/doubleclick-gpt/reference#googletag.defineSlot">here</a>
          </p>
        </td>
      </tr>
      <tr>
        <th scoope="row">Variable Name</th>
        <td>
          <input size="40" type="text" name="lw_ad_unit_variable_name" id="lw_ad_unit_variable_name" value="<?php echo get_post_meta($post->ID, 'lw_ad_unit_variable_name', true); ?>" />
        </td>
        <td>
          <p class="description">
            Variable name for developers.  Unique to Ad Unit Group.
          </p>
        </td>
      </tr>
    </table>
    <?php
  }

  // Save detail meta on post add/update
  function save_ad_unit_detail_meta($post_id) {
    if (isset($_POST['lw_ad_unit_detail_meta_nonce'])) {
      update_post_meta($post_id, 'lw_ad_unit_slug', strip_tags($_POST['lw_ad_unit_slug']));
      update_post_meta($post_id, 'lw_ad_unit_path', strip_tags($_POST['lw_ad_unit_path']));
      update_post_meta($post_id, 'lw_ad_unit_size', strip_tags($_POST['lw_ad_unit_size']));
      update_post_meta($post_id, 'lw_ad_unit_div', strip_tags($_POST['lw_ad_unit_div']));
      update_post_meta($post_id, 'lw_ad_unit_variable_name', strip_tags($_POST['lw_ad_unit_variable_name']));
    }
  }
}
