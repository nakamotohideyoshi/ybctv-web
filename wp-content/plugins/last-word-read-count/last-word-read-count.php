<?php
/*
Plugin Name: Last Word Read Count
Plugin URI: http://www.ybc.tv
Description: Updates Read Count on post views
Author: yBC
Version: 1.0
Author URI: http://www.ybc.tv
*/

add_action('admin_menu', 'add_read_count_menu_item');
add_action('admin_init', 'register_read_count_settings');
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

function add_read_count_menu_item() {
  add_options_page(
    'Read Count',
    'Read Count',
    'manage_options',
    'read_count_settings',
    'add_read_count_settings_page'
  );
}

function register_read_count_settings() {
  register_setting('read_count_settings', 'most_read_days');
}

function add_read_count_settings_page() {
  ?>
  <div class="most-read-settings wrap">
    <h2>Read Count Settings</h2>
    <form action="options.php" method="post">
      <?php
        settings_fields('read_count_settings');
        do_settings_sections('read_count_settings');
      ?>
      <table class="form-table">
        <tr>
          <th scope="row">Most Read Days</th>
          <td>
            <input type="text" name="most_read_days" value="<?php echo esc_attr(get_option('most_read_days')); ?>" size="50" />
            <p class="description">The number of days from the current date back to include in a most read query</p>
          </td>
        </tr>
        <tr>
          <th colspan="2">
            <?php submit_button(); ?>
          </th>
      </table>
    </form>
  </div>
  <?
}

function setReadCount($post_id) {
  $read_count = get_post_meta($post_id, 'lw_read_count', true);
  if ($read_count != '') {
    $read_count++;
    update_post_meta($post_id, 'lw_read_count', $read_count);
  }
  else {
    $read_count = 1;
    delete_post_meta($post_id, 'lw_read_count');
    add_post_meta($post_id, 'lw_read_count', $read_count);
  }
}
