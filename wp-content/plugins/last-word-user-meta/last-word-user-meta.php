<?php
/*
Plugin Name: Last Word User Meta
Plugin URI: http://www.ybc.tv
Description: User Meta for Last Word users
Author: yBC
Version: 1.0
Author URI: http://www.ybc.tv
*/

class last_word_user_meta {

  function __construct() {
    add_action('show_user_profile', array($this, 'add_lw_user_meta'));
    add_action('edit_user_profile', array($this, 'add_lw_user_meta'));
    add_action( 'personal_options_update', array($this, 'save_lw_user_meta'));
    add_action( 'edit_user_profile_update', array($this, 'save_lw_user_meta'));
  }

  function add_lw_user_meta($user) {
    ?>
      <style>
        .user-url-wrap {
          display: none;
        }
      </style>
      <h2>Company Details</h2>
      <table class="form-table">
          <tr>
            <th>
              <label for="lw_company_name">Company Name</label>
            </th>
            <td>
              <input type="text" name="lw_company_name" id="lw_company_name" value="<?php echo esc_attr(get_user_meta($user->ID, 'lw_company_name', true)); ?>" class="regular-text" />
            </td>
          </tr>
          <tr>
            <th>
              <label for="lw_company_website_url">Company Website URL</label>
            </th>
            <td>
              <input type="text" name="lw_company_website_url" id="lw_company_website_url" value="<?php echo esc_attr(get_user_meta($user->ID, 'lw_company_website_url', true)); ?>" class="regular-text" />
            </td>
          </tr>
          <tr>
            <th>
              <label for="lw_company_linkedin_url">Company LinkedIn URL</label>
            </th>
            <td>
              <input type="text" name="lw_company_linkedin_url" id="lw_company_linkedin_url" value="<?php echo esc_attr(get_user_meta($user->ID, 'lw_company_linkedin_url', true)); ?>" class="regular-text" />
            </td>
          </tr>
          <tr>
            <th>
              <label for="lw_company_twitter_username">Company Twitter Username</label>
            </th>
            <td>
              <input type="text" name="lw_company_twitter_username" id="lw_company_twitter_username" value="<?php echo esc_attr(get_user_meta($user->ID, 'lw_company_twitter_username', true)); ?>" class="regular-text" />
            </td>
          </tr>
      </table>
      <h2>Personal Details</h2>
      <table class="form-table">
        <tr>
          <th>
            <label for="lw_title">Title</label>
          </th>
          <td>
            <input type="text" name="lw_title" id="lw_title" value="<?php echo esc_attr(get_user_meta($user->ID, 'lw_title', true)); ?>" class="regular-text" />
          </td>
        </tr>
        <tr>
          <th>
            <label for="lw_professional_title">Professional Title</label>
          </th>
          <td>
            <input type="text" name="lw_professional_title" id="lw_professional_title" value="<?php echo esc_attr(get_user_meta($user->ID, 'lw_professional_title', true)); ?>" class="regular-text" />
          </td>
        </tr>
        <tr>
          <th>
            <label for="lw_blog_url">Blog URL</label>
          </th>
          <td>
            <input type="text" name="lw_blog_url" id="lw_blog_url" value="<?php echo esc_attr(get_user_meta($user->ID, 'lw_blog_url', true)); ?>" class="regular-text" />
          </td>
        </tr>
        <tr>
          <th>
            <label for="lw_linkedin_url">LinkedIn URL</label>
          </th>
          <td>
            <input type="text" name="lw_linkedin_url" id="lw_linkedin_url" value="<?php echo esc_attr(get_user_meta($user->ID, 'lw_linkedin_url', true)); ?>" class="regular-text" />
          </td>
        </tr>
        <tr>
          <th>
            <label for="lw_twitter_username">Twitter Username</label>
          </th>
          <td>
            <input type="text" name="lw_twitter_username" id="lw_twitter_username" value="<?php echo esc_attr(get_user_meta($user->ID, 'lw_twitter_username', true)); ?>" class="regular-text" />
          </td>
        </tr>
        <tr>
          <th>
            <label for="lw_google_plus_url">Google+ URL</label>
          </th>
          <td>
            <input type="text" name="lw_google_plus_url" id="lw_google_plus_url" value="<?php echo esc_attr(get_user_meta($user->ID, 'lw_google_plus_url', true)); ?>" class="regular-text" />
          </td>
        </tr>
      </table>
      <h2>Verification</h2>
      <table class="form-table">
        <tr>
          <th>Email address</th>
          <td><?php echo get_user_meta($user->ID, 'lw_email_verified') == 'yes' ? ' <span style="color:#00dd00;">Verified</span>' : '<span style="color:#dd0000;">Not verified</span>'; ?></td>
        </tr>
        <tr>
          <th>Access to Product: EI Market Intelligence</th>
          <td>
            <?php
              $product_eimi = get_user_meta($user->ID, 'lw_product_ei_market_intelligence', true);
              if (current_user_can('manage_options')) {
              ?>
                <input type="checkbox" name="lw_product_ei_market_intelligence" id="lw_product_ei_market_intelligence" value="yes"<?php echo $product_eimi == 'yes' ? ' checked' : ''; ?> />
              <?php
              }
              else {
                echo $product_eimi == 'yes' ? 'Yes' : 'No';
              }
            ?>
          </td>
      </table>
    <?php
  }

  function save_lw_user_meta($user_id) {
    if (current_user_can('edit_user', $user_id)) {
      $this->process_lw_user_meta($user_id, 'lw_company_name', $_POST['lw_company_name']);
      $this->process_lw_user_meta($user_id, 'lw_company_website_url', $_POST['lw_company_website_url']);
      $this->process_lw_user_meta($user_id, 'lw_company_linkedin_url', $_POST['lw_company_linkedin_url']);
      $this->process_lw_user_meta($user_id, 'lw_company_twitter_username', $_POST['lw_company_twitter_username']);
      $this->process_lw_user_meta($user_id, 'lw_title', $_POST['lw_title']);
      $this->process_lw_user_meta($user_id, 'lw_professional_title', $_POST['lw_professional_title']);
      $this->process_lw_user_meta($user_id, 'lw_blog_url', $_POST['lw_blog_url']);
      $this->process_lw_user_meta($user_id, 'lw_linkedin_url', $_POST['lw_linkedin_url']);
      $this->process_lw_user_meta($user_id, 'lw_twitter_username', $_POST['lw_twitter_username']);
      $this->process_lw_user_meta($user_id, 'lw_google_plus_url', $_POST['lw_google_plus_url']);

      if (isset($_POST['lw_product_ei_market_intelligence'])) {
        update_user_meta($user_id, 'lw_product_ei_market_intelligence', 'yes');
      }
      else {
        update_user_meta($user_id, 'lw_product_ei_market_intelligence', '');
      }
    }
  }

  function process_lw_user_meta($user_id, $meta_key, $meta_value) {
    if ($_POST[$meta_key] != '') {
      update_user_meta($user_id, $meta_key, $meta_value);
    }
    else {
      delete_user_meta($user_id, $meta_key, $meta_value);
    }
  }
}

$last_word_user_meta = new last_word_user_meta();
