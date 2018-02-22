<?php
/*
Plugin Name: Last Word Advertising
Plugin URI: http://www.ybc.tv
Description: Settings for Advertising on Last Word sites
Author: yBC
Version: 1.0
Author URI: http://www.ybc.tv
*/

add_action('admin_menu', 'add_advertising_settings_menu_item');
add_action('admin_init', 'register_advertising_settings');

function add_advertising_settings_menu_item() {
  add_options_page(
    'Advertising',
    'Advertising',
    'manage_options',
    'advertising_settings',
    'add_advertising_settings_page'
  );
}

function register_advertising_settings() {
  register_setting('advertising_settings', 'lazy_load');
  register_setting('advertising_settings', 'show_ad_units');
}

function add_advertising_settings_page() {
  ?>
  <div class="advertising-settings wrap">
    <h2>Advertising Settings</h2>
    <form action="options.php" method="post">
      <?php
        settings_fields('advertising_settings');
        do_settings_sections('advertising_settings');

        $lazy_load = get_option('lazy_load');
        $show_ad_units = get_option('show_ad_units');
        $lazy_load_checked = ($lazy_load && $lazy_load == 'yes') ? ' checked' : '';
        $show_ad_units_checked = ($show_ad_units && $show_ad_units == 'yes') ? ' checked' : '';
      ?>
      <table class="form-table">
        <tr>
          <th scope="row">Lazy Load</th>
          <td>
            <input type="checkbox" name="lazy_load" value="yes"<?php echo $lazy_load_checked; ?> />
            <span class="description">Enable lazy loading on advertising</span>
          </td>
        </tr>
        <tr>
          <th scope="row">Show Ad Units</th>
          <td>
            <input type="checkbox" name="show_ad_units" value="yes"<?php echo $show_ad_units_checked; ?> />
            <span class="description">Enable display of ad units on site</span>
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

function lazyLoadStatus() {
  $lazy_load_status = get_option('lazy_load');
  echo '<input type="hidden" id="ads_lazy_load" value="' . (($lazy_load_status && $lazy_load_status == 'yes') ? '1' : '0') . '" />';
}
