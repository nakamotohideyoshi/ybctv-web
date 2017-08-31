<?php
/*
Plugin Name: Last Word Ad Units
Plugin URI: http://www.ybc.tv
Description: Configure and display Ad Units on Last Word sites
Author: yBC
Version: 1.0
Author URI: http://www.ybc.tv
*/

class last_word_ad_units {
  function __construct() {
    add_action('init', array($this, 'register_ad_unit_post_type'));
    add_action('init', array($this, 'register_ad_unit_group_taxonomy'));

    add_filter('manage_edit-lw_ad_unit_columns', array($this, 'add_ad_unit_columns'));
    add_action('manage_lw_ad_unit_posts_custom_column', array($this, 'manage_ad_unit_columns'), 10, 2);

    add_action('admin_menu', array($this, 'remove_ad_unit_group_meta_box'));
    add_action('add_meta_boxes', array($this, 'add_ad_unit_group_meta_box'));
    add_action('add_meta_boxes', array($this, 'add_ad_unit_detail_meta_box'));

    add_action('save_post', array($this, 'save_ad_unit_detail_meta'));

    add_action('wp_enqueue_scripts', array($this, 'enqueue_google_tag_services'));
    add_action('script_loader_tag', array($this, 'add_async_attribute'), 10, 2);
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
      'search_items' => 'Search Ad Units',
      'not_found' => 'No Ad Units Found',
      'not_found_in_trash' => 'No Ad Units Found in Trash',
      'all_items' => 'Ad Units',
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
      'lw_ad_unit_div' => 'Target Div'
    );

    return $columns;
  }

  // Populate columns in Ad Unit listing
  function manage_ad_unit_columns($column, $post_id) {
    $groups = get_the_terms($post_id, 'lw_ad_unit_group');
    switch($column) {
      case 'lw_ad_unit_slug' :
        echo get_post_meta($post_id, 'lw_ad_unit_slug', true);
        break;
      case 'lw_ad_unit_group_name' :
        echo $groups[0]->name;
        break;
      case 'lw_ad_unit_group_slug' :
        echo $groups[0]->slug;
        break;
      case 'lw_ad_unit_path' :
        echo get_post_meta($post_id, 'lw_ad_unit_path', true);
        break;
      case 'lw_ad_unit_size' :
        echo get_post_meta($post_id, 'lw_ad_unit_size', true);
        break;
      case 'lw_ad_unit_div' :
        echo get_post_meta($post_id, 'lw_ad_unit_div', true);
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
        <td><input size="40" type="text" name="lw_ad_unit_slug" id="lw_ad_unit_slug" value="<?php echo get_post_meta($post->ID, 'lw_ad_unit_slug', true); ?>" /></td>
      </tr>
      <tr>
        <th scope="row">Ad Unit Path</th>
        <td><input size="40" type="text" name="lw_ad_unit_path" id="lw_ad_unit_path" value="<?php echo get_post_meta($post->ID, 'lw_ad_unit_path', true); ?>" /></td>
      </tr>
      <tr>
        <th scope="row">Size(s)</th>
        <td><input size="40" type="text" name="lw_ad_unit_size" id="lw_ad_unit_size" value="<?php echo get_post_meta($post->ID, 'lw_ad_unit_size', true); ?>" /></td>
      </tr>
      <tr>
        <th scoope="row">Target Div ID</th>
        <td><input size="40" type="text" name="lw_ad_unit_div" id="lw_ad_unit_div" value="<?php echo get_post_meta($post->ID, 'lw_ad_unit_div', true); ?>" /></td>
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
    }
  }

  // Google Tag Services JS.
  function enqueue_google_tag_services() {
    wp_register_script('google-tag-services', 'https://www.googletagservices.com/tag/js/gpt.js', array(), null, false);
    wp_enqueue_script('google-tag-services');
  }

  function add_async_attribute($tag, $handle) {
    if ('google-tag-services' !== $handle) {
      return $tag;
    }

    return str_replace(' src', ' async="async" src', $tag);
  }

  // Add required JS for Ad Units
  public static function last_word_ad_unit_initialize($group_slug) {
    $ad_unit_group = get_term_by('slug', $group_slug, 'lw_ad_unit_group');

    if ($ad_unit_group) {
      $ad_units = get_posts(
        array(
          'posts_per_page' => -1,
          'post_type' => 'lw_ad_unit',
          'tax_query' => array(
            array(
              'taxonomy' => 'lw_ad_unit_group',
              'field' => 'slug',
              'terms' => $ad_unit_group->slug
            )
          )
        )
      );

      if ($ad_units) {
        $output = "<script type=\"text/javascript\">\n";
        $output .= "var googletag = googletag || {};\n";
        $output .= "googletag.cmd = googletag.cmd || [];\n";
        $output .= "googletag.cmd.push(function() {\n";

        foreach ($ad_units as $ad_unit) {
          $output .= "\tgoogletag.defineSlot('";
          $output .= get_post_meta($ad_unit->ID, 'lw_ad_unit_path', true);
          $output .= "', ";
          $output .= get_post_meta($ad_unit->ID, 'lw_ad_unit_size', true);
          $output .= ", '";
          $output .= get_post_meta($ad_unit->ID, 'lw_ad_unit_div', true);
          $output .= "').addService(googletag.pubads()).setCollapseEmptyDiv(true);\n";
        }

        $output .= "\tgoogletag.pubads().enableSingleRequest();\n";
        $output .= "\tgoogletag.enableServices();\n";
        $output .= "});\n";
        $output .= "</script>\n";
      }
    }

    return $output;
  }

  // Displays Ad Unit
  public static function last_word_ad_unit($slug) {
    $args = array(
      'post_type' => 'lw_ad_unit',
      'posts_per_page' => 1,
      'meta_query' => array(
        array(
          'key' => 'lw_ad_unit_slug',
          'value' => $slug,
          'compare' => '='
        )
      )
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
      $query->the_post();
      $ad_unit_div = get_post_meta(get_the_ID(), 'lw_ad_unit_div', true);
      $output = "<div class=\"ads-" . get_post_meta(get_the_ID(), 'lw_ad_unit_slug', true) . "\">\n";
      $output .= "\t<div id=\"" . $ad_unit_div . "\">\n";
      $output .= "\t\t<script type=\"text/javascript\">\n";
      $output .= "\t\t\tgoogletag.cmd.push(function() { googletag.display('" . $ad_unit_div . "'); });\n";
      $output .= "\t\t</script>\n";
      $output .= "\t</div>\n";
      $output .= "</div>\n";
    }

    return $output;
  }
}

// Expose function for Initialize Ad Units Template Tag
if (!function_exists('lastWordAdUnitInitialize')) {
  function lastWordAdUnitInitialize($group_slug) {
    echo last_word_ad_units::last_word_ad_unit_initialize($group_slug);
  }
}

// Expose function for Ad Unit Template Tag
if (!function_exists('lastWordAdUnit')) {
  function lastWordAdUnit($slug) {
    echo last_word_ad_units::last_word_ad_unit($slug);
  }
}


$last_word_ad_units = new last_word_ad_units();
