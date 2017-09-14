<?php
/*
Plugin Name: Last Word Events
Plugin URI: http://www.ybc.tv
Description: Events custom post type
Author: yBC
Version: 1.0
Author URI: http://www.ybc.tv
*/

class last_word_events {
  function __construct() {
    add_action('init', array($this, 'register_event_post_type'));
    add_action('manage_edit-event_columns', array($this, 'add_event_columns'));
    add_action('manage_event_posts_custom_column', array($this, 'manage_event_columns'), 10, 2);
    add_action('add_meta_boxes', array($this, 'add_event_meta_box'));
    add_action('admin_enqueue_scripts', array($this, 'enqueue_date_picker'));
    add_action('save_post', array($this, 'save_event_detail_meta'));
  }

  function register_event_post_type() {
    $labels = array(
      'name' => 'Events',
      'singular_name' => 'Event',
      'add_new_item' => 'Add New Event',
      'edit_item' => 'Edit Event',
      'new_item' => 'New Event',
      'view_item' => 'View Event',
      'view_items' => 'View Events',
      'search_items' => 'Search Events',
      'not_found' => 'No Events Found',
      'not_found_in_trash' => 'No Events Found in Trash',
      'all_items' => 'All Events',
      'archives' => 'Events Archive',
      'update_item' => 'Update Event'
    );

    $args = array(
      'labels' => $labels,
      'menu_icon' => 'dashicons-calendar-alt',
      'description' => 'Events post type',
      'public' => true,
      'show_ui' => true,
      'supports' => array('title', 'thumbnail'),
      'rewrite' => array('slug' => 'event', 'with_front' => false),
      'menu_position' => 5
    );

    register_post_type('event', $args);
  }

  function add_event_columns($columns) {
    $columns['lw_event_start_date'] = 'Start Date';
    $columns['lw_event_end_date'] = 'End Date';
    $columns['lw_event_location'] = 'Location';
    $columns['lw_event_link'] = 'Booking Link';

    return $columns;
  }

  function manage_event_columns($column, $post_id) {
    switch ($column) {
      case 'lw_event_start_date' :
        $start_date = get_post_meta($post_id, 'lw_event_start_date', true);
        echo $start_date ? date_format(new DateTime($start_date), 'jS F Y') : 'Not specified';
        break;
      case 'lw_event_end_date' :
        $end_date = get_post_meta($post_id, 'lw_event_end_date', true);
        echo $end_date ? date_format(new DateTime($end_date), 'jS F Y') : 'Not specified';
        break;
      case 'lw_event_location' :
        $location = get_post_meta($post_id, 'lw_event_location', true);
        echo $location ? $location : 'Not specified';
        break;
      case 'lw_event_link' :
        $link = get_post_meta($post_id, 'lw_event_link', true);
        echo $link ? '<a target="_blank" href="' . $link . '">View</a>' : 'Not specified';
        break;
      default :
        break;
    }
  }

  function add_event_meta_box($post) {
    add_meta_box('event_meta_box', 'Details', array($this, 'populate_event_meta_box'), 'event', 'normal');
  }

  function populate_event_meta_box() {
    global $post;

    wp_nonce_field( basename( __FILE__ ), 'lw_event_detail_meta_nonce' );
    ?>
    <table class="form-table">
      <tr>
        <th scope="row">Start Date</th>
        <td>
          <?php
            $lw_event_start_date = get_post_meta($post->ID, 'lw_event_start_date', true);
            $lw_event_end_date = get_post_meta($post->ID, 'lw_event_end_date', true);

            if ($lw_event_start_date) {
              $start_date = new DateTime(get_post_meta($post->ID, 'lw_event_start_date', true));
              $start_date = date_format($start_date, 'l j F Y');
            }
            else {
              $start_date = '';
            }

            if ($lw_event_end_date) {
              $end_date = new DateTime(get_post_meta($post->ID, 'lw_event_end_date', true));
              $end_date = date_format($end_date, 'l j F Y');
            }
            else {
              $end_date = '';
            }
          ?>
          <input size="40" type="text" name="lw_event_start_date" id="lw_event_start_date" value="<?php echo $start_date; ?>" />
        </td>
      </tr>
      <tr>
        <th scope="row">End Date</th>
        <td>
          <input size="40" type="text" name="lw_event_end_date" id="lw_event_end_date" value="<?php echo $end_date; ?>" />
        </td>
      </tr>
      <tr>
        <th scope="row">Location</th>
        <td>
          <input size="60" type="text" name="lw_event_location" id="lw_event_location" value="<?php echo get_post_meta($post->ID, 'lw_event_location', true); ?>" />
        </td>
      </tr>
      <tr>
        <th scope="row">Booking Link</th>
        <td>
          <input size="60" type="text" name="lw_event_link" id="lw_event_link" value="<?php echo get_post_meta($post->ID, 'lw_event_link', true); ?>" />
          <p class="description">
            Please include http:// or https://
          </p>
        </td>
      </tr>
      <tr>
        <th scope="row">Open booking link in new tab/window</th>
        <td>
          <p>
            <label for="lw_event_target_blank">
              <?php
                global $pagenow;
                $checked = '';
                $target_blank = get_post_meta($post->ID, 'lw_event_target_blank', true);
                $screen = get_current_screen();

                if ($target_blank == 'yes' || $pagenow == 'post-new.php') {
                  $checked = ' checked';
                }
              ?>
              <input type="checkbox" name="lw_event_target_blank" id="lw_event_target_blank" value="yes"<?php echo $checked; ?> />
            </label>
          </p>
      </tr>
    </table>
    <?php
  }

  function enqueue_date_picker() {
    wp_enqueue_script( 'event_date', plugin_dir_url(__FILE__) . 'js/event-date.js', array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker'), '1.0.0',  true);
		wp_enqueue_style('jquery-ui-datepicker');

    wp_register_style('lw_event_css', plugin_dir_url(__FILE__) . 'css/main.css', false, '1.0.0');
    wp_enqueue_style('lw_event_css');
  }

  function save_event_detail_meta($post_id) {
    if (isset($_POST['lw_event_detail_meta_nonce'])) {
      $end_date = date_create(strip_tags($_POST['lw_event_end_date']));

      if ($_POST['lw_event_start_date'] != '') {
        $start_date = date_create(strip_tags($_POST['lw_event_start_date']));
        update_post_meta($post_id, 'lw_event_start_date', date_format($start_date, 'Ymd'));
      }
      else {
        delete_post_meta($post_id, 'lw_event_start_date');
      }

      if ($_POST['lw_event_end_date'] != '') {
        $end_date = date_create(strip_tags($_POST['lw_event_end_date']));
        update_post_meta($post_id, 'lw_event_end_date', date_format($end_date, 'Ymd'));
      }
      else {
        delete_post_meta($post_id, 'lw_event_end_date');
      }

      update_post_meta($post_id, 'lw_event_location', strip_tags($_POST['lw_event_location']));
      update_post_meta($post_id, 'lw_event_link', strip_tags($_POST['lw_event_link']));

      if (isset($_POST['lw_event_target_blank'])) {
        update_post_meta($post_id, 'lw_event_target_blank', 'yes');
      }
      else {
        update_post_meta($post_id, 'lw_event_target_blank', '');
      }

    }
  }
}

$last_word_events = new last_word_events();
