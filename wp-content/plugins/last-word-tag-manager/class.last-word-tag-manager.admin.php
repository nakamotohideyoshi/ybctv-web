<?php namespace last_word_tag_manager;

class admin {
  function __construct() {
    add_action('admin_menu', array($this, 'add_tag_manager_settings_menu_item'));
    add_action('admin_init', array($this, 'register_tag_manager_settings'));
  }

  // Add menu item in admin
  function add_tag_manager_settings_menu_item() {
    add_options_page(
      'Tag Manager',
      'Tag Manager',
      'manage_options',
      'tag_manager_settings',
      array($this, 'add_tag_manager_settings_page')
    );
  }

  // Register settings
  function register_tag_manager_settings() {
    register_setting('tag_manager_settings', 'analytics_ignore_roles');
  }

  // Add tag manager settings page
  function add_tag_manager_settings_page() {
    ?>
    <div class="analytics-settings wrap">
      <h2>Tag Manager Settings</h2>
      <form action="options.php" method="post">
        <?php
          settings_fields('tag_manager_settings');
          do_settings_sections('tag_manager_settings');

          $analytics_ignore_roles = get_option('analytics_ignore_roles');

          $roles = get_editable_roles();
        ?>
        <table class="form-table">
          <tr>
            <th scope="row">Analytics ignore roles</th>
            <td>
              <?php
                $html = '';
                foreach ($roles as $key => $role) {
                  $html .= '<p><input type="checkbox" name="analytics_ignore_roles[]" ';
                  $html .= 'value="' . $key . '"';
                  $html .= in_array($key, $analytics_ignore_roles) ? ' checked' : '';
                  $html .= ' /> ' . $role['name'] . '</p>';
                }
                echo $html;
              ?>
              <p class="description">Users within the selected roles will not be included in Google Analytics</p>
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
}
