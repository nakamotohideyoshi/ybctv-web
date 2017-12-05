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
      </table>
      <h2>Products</h2>
      <table class="form-table">
        <tr>
          <th colspan="2" style="padding: 0 10px 0 0;"><em>Portfolio Adviser</em></th>
        </tr>
        <tr>
          <th>PA News</th>
          <td>
            <?php
              $product_pa_news = get_user_meta($user->ID, 'lw_product_pa_news', true);
              if (current_user_can('manage_options')) {
              ?>
                <input type="checkbox" name="lw_product_pa_news" id="lw_product_pa_news" value="yes"<?php echo $product_pa_news == 'yes' ? ' checked' : ''; ?> />
              <?php
              }
              else {
                echo $product_pa_news == 'yes' ? 'Yes' : 'No';
              }
            ?>
          </td>
        </tr>
        <tr>
          <th>PA Magazine <em style="font-size: 11px;">(Print and Digital)</em></th>
          <td>
            <?php
              $product_pa_magazine_print_digital = get_user_meta($user->ID, 'lw_product_pa_magazine_print_digital', true);
              if (current_user_can('manage_options')) {
              ?>
                <input type="checkbox" name="lw_product_pa_magazine_print_digital" id="lw_product_pa_magazine_print_digital" value="yes"<?php echo $product_pa_magazine_print_digital == 'yes' ? ' checked' : ''; ?> />
              <?php
              }
              else {
                echo $product_pa_magazine_print_digital == 'yes' ? 'Yes' : 'No';
              }
            ?>
          </td>
        </tr>
        <tr>
          <th>PA Magazine <em style="font-size: 11px;">(Digital only)</em></th>
          <td>
            <?php
              $product_pa_magazine_digital = get_user_meta($user->ID, 'lw_product_pa_magazine_digital', true);
              if (current_user_can('manage_options')) {
              ?>
                <input type="checkbox" name="lw_product_pa_magazine_digital" id="lw_product_pa_magazine_digital" value="yes"<?php echo $product_pa_magazine_digital == 'yes' ? ' checked' : ''; ?> />
              <?php
              }
              else {
                echo $product_pa_magazine_digital == 'yes' ? 'Yes' : 'No';
              }
            ?>
          </td>
        </tr>
        <tr>
          <th>PA Magazine Free <em style="font-size: 11px;">(Print and Digital)</em></th>
          <td>
            <?php
              $product_pa_magazine_free_print_digital = get_user_meta($user->ID, 'lw_product_pa_magazine_free_print_digital', true);
              if (current_user_can('manage_options')) {
              ?>
                <input type="checkbox" name="lw_product_pa_magazine_free_print_digital" id="lw_product_pa_magazine_free_print_digital" value="yes"<?php echo $product_pa_magazine_free_print_digital == 'yes' ? ' checked' : ''; ?> />
              <?php
              }
              else {
                echo $product_pa_magazine_free_print_digital == 'yes' ? 'Yes' : 'No';
              }
            ?>
          </td>
        </tr>
        <tr>
          <th>PA Magazine Free <em style="font-size: 11px;">(Digital only)</em></th>
          <td>
            <?php
              $product_pa_magazine_free_digital = get_user_meta($user->ID, 'lw_product_pa_magazine_free_digital', true);
              if (current_user_can('manage_options')) {
              ?>
                <input type="checkbox" name="lw_product_pa_magazine_free_digital" id="lw_product_pa_magazine_free_digital" value="yes"<?php echo $product_pa_magazine_free_digital == 'yes' ? ' checked' : ''; ?> />
              <?php
              }
              else {
                echo $product_pa_magazine_free_digital == 'yes' ? 'Yes' : 'No';
              }
            ?>
          </td>
        </tr>
        <tr>
          <th>PA Magazine IRE <em style="font-size: 11px;">(Print and Digital)</em></th>
          <td>
            <?php
              $product_pa_magazine_ire_print_digital = get_user_meta($user->ID, 'lw_product_pa_magazine_ire_print_digital', true);
              if (current_user_can('manage_options')) {
              ?>
                <input type="checkbox" name="lw_product_pa_magazine_ire_print_digital" id="lw_product_pa_magazine_ire_print_digital" value="yes"<?php echo $product_pa_magazine_ire_print_digital == 'yes' ? ' checked' : ''; ?> />
              <?php
              }
              else {
                echo $product_pa_magazine_ire_print_digital == 'yes' ? 'Yes' : 'No';
              }
            ?>
          </td>
        </tr>
        <tr>
          <th>PA Magazine IRE <em style="font-size: 11px;">(Digital only)</em></th>
          <td>
            <?php
              $product_pa_magazine_ire_digital = get_user_meta($user->ID, 'lw_product_pa_magazine_ire_digital', true);
              if (current_user_can('manage_options')) {
              ?>
                <input type="checkbox" name="lw_product_pa_magazine_ire_digital" id="lw_product_pa_magazine_ire_digital" value="yes"<?php echo $product_pa_magazine_ire_digital == 'yes' ? ' checked' : ''; ?> />
              <?php
              }
              else {
                echo $product_pa_magazine_ire_digital == 'yes' ? 'Yes' : 'No';
              }
            ?>
          </td>
        </tr>
        <tr>
          <th colspan="2" style="padding: 15px 10px 0 0;"><em>International Adviser</em></th>
        </tr>
        <tr>
          <th>IA News</th>
          <td>
            <?php
              $product_ia_news = get_user_meta($user->ID, 'lw_product_ia_news', true);
              if (current_user_can('manage_options')) {
              ?>
                <input type="checkbox" name="lw_product_ia_news" id="lw_product_ia_news" value="yes"<?php echo $product_ia_news == 'yes' ? ' checked' : ''; ?> />
              <?php
              }
              else {
                echo $product_ia_news == 'yes' ? 'Yes' : 'No';
              }
            ?>
          </td>
        </tr>
        <tr>
          <th>IA Magazine <em style="font-size: 11px;">(Print and Digital)</em></th>
          <td>
            <?php
              $product_ia_magazine_print_digital = get_user_meta($user->ID, 'lw_product_ia_magazine_print_digital', true);
              if (current_user_can('manage_options')) {
              ?>
                <input type="checkbox" name="lw_product_ia_magazine_print_digital" id="lw_product_ia_magazine_print_digital" value="yes"<?php echo $product_ia_magazine_print_digital == 'yes' ? ' checked' : ''; ?> />
              <?php
              }
              else {
                echo $product_ia_magazine_print_digital == 'yes' ? 'Yes' : 'No';
              }
            ?>
          </td>
        </tr>
        <tr>
          <th>IA Magazine <em style="font-size: 11px;">(Digital only)</em></th>
          <td>
            <?php
              $product_ia_magazine_digital = get_user_meta($user->ID, 'lw_product_ia_magazine_digital', true);
              if (current_user_can('manage_options')) {
              ?>
                <input type="checkbox" name="lw_product_ia_magazine_digital" id="lw_product_ia_magazine_digital" value="yes"<?php echo $product_ia_magazine_digital == 'yes' ? ' checked' : ''; ?> />
              <?php
              }
              else {
                echo $product_ia_magazine_digital == 'yes' ? 'Yes' : 'No';
              }
            ?>
          </td>
        </tr>
        <tr>
          <th colspan="2" style="padding: 15px 10px 0 0;"><em>Fund Selector Asia</em></th>
        </tr>
        <tr>
          <th>FSA News</th>
          <td>
            <?php
              $product_fsa_news = get_user_meta($user->ID, 'lw_product_fsa_news', true);
              if (current_user_can('manage_options')) {
              ?>
                <input type="checkbox" name="lw_product_fsa_news" id="lw_product_fsa_news" value="yes"<?php echo $product_fsa_news == 'yes' ? ' checked' : ''; ?> />
              <?php
              }
              else {
                echo $product_fsa_news == 'yes' ? 'Yes' : 'No';
              }
            ?>
          </td>
        </tr>
        <tr>
          <th colspan="2" style="padding: 15px 10px 0 0;"><em>Expert Investor Europe</em></th>
        </tr>
        <tr>
          <th>EI News</th>
          <td>
            <?php
              $product_ei_news = get_user_meta($user->ID, 'lw_product_ei_news', true);
              if (current_user_can('manage_options')) {
              ?>
                <input type="checkbox" name="lw_product_ei_news" id="lw_product_ei_news" value="yes"<?php echo $product_ei_news == 'yes' ? ' checked' : ''; ?> />
              <?php
              }
              else {
                echo $product_ei_news == 'yes' ? 'Yes' : 'No';
              }
            ?>
          </td>
        </tr>
        <tr>
          <th>EI Magazine <em style="font-size: 11px;">(Print and Digital)</em></th>
          <td>
            <?php
              $product_ei_magazine_print_digital = get_user_meta($user->ID, 'lw_product_ei_magazine_print_digital', true);
              if (current_user_can('manage_options')) {
              ?>
                <input type="checkbox" name="lw_product_ei_magazine_print_digital" id="lw_product_ei_magazine_print_digital" value="yes"<?php echo $product_ei_magazine_print_digital == 'yes' ? ' checked' : ''; ?> />
              <?php
              }
              else {
                echo $product_ei_magazine_print_digital == 'yes' ? 'Yes' : 'No';
              }
            ?>
          </td>
        </tr>
        <tr>
          <th>EI Magazine <em style="font-size: 11px;">(Digital only)</em></th>
          <td>
            <?php
              $product_ei_magazine_digital = get_user_meta($user->ID, 'lw_product_ei_magazine_digital', true);
              if (current_user_can('manage_options')) {
              ?>
                <input type="checkbox" name="lw_product_ei_magazine_digital" id="lw_product_ei_magazine_digital" value="yes"<?php echo $product_ei_magazine_digital == 'yes' ? ' checked' : ''; ?> />
              <?php
              }
              else {
                echo $product_ei_magazine_digital == 'yes' ? 'Yes' : 'No';
              }
            ?>
          </td>
        </tr>
        <tr>
          <th>EI Market Intelligence</th>
          <td>
            <?php
              $product_ei_market_intelligence = get_user_meta($user->ID, 'lw_product_ei_market_intelligence', true);
              if (current_user_can('manage_options')) {
              ?>
                <input type="checkbox" name="lw_product_ei_market_intelligence" id="lw_product_ei_market_intelligence" value="yes"<?php echo $product_ei_market_intelligence == 'yes' ? ' checked' : ''; ?> />
              <?php
              }
              else {
                echo $product_ei_market_intelligence == 'yes' ? 'Yes' : 'No';
              }
            ?>
          </td>
        </tr>
        <?php
          if (current_user_can('manage_options')) {
        ?>
        <tr>
          <th>Contact GUID</th>
          <td>
            <?php
              $contactId = get_user_meta($user->ID, '_contactId', true);
              echo $contactId;
               ?>
          </td>
        </tr>
        <?php
          }
        ?>
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

      if (isset($_POST['lw_product_pa_news'])) {
        update_user_meta($user_id, 'lw_product_pa_news', 'yes');
      }
      else {
        update_user_meta($user_id, 'lw_product_pa_news', '');
      }

      if (isset($_POST['lw_product_pa_magazine_print_digital'])) {
        update_user_meta($user_id, 'lw_product_pa_magazine_print_digital', 'yes');
      }
      else {
        update_user_meta($user_id, 'lw_product_pa_magazine_print_digital', '');
      }

      if (isset($_POST['lw_product_pa_magazine_digital'])) {
        update_user_meta($user_id, 'lw_product_pa_magazine_digital', 'yes');
      }
      else {
        update_user_meta($user_id, 'lw_product_pa_magazine_digital', '');
      }

      if (isset($_POST['lw_product_pa_magazine_free_print_digital'])) {
        update_user_meta($user_id, 'lw_product_pa_magazine_free_print_digital', 'yes');
      }
      else {
        update_user_meta($user_id, 'lw_product_pa_magazine_free_print_digital', '');
      }

      if (isset($_POST['lw_product_pa_magazine_free_digital'])) {
        update_user_meta($user_id, 'lw_product_pa_magazine_free_digital', 'yes');
      }
      else {
        update_user_meta($user_id, 'lw_product_pa_magazine_free_digital', '');
      }

      if (isset($_POST['lw_product_pa_magazine_ire_print_digital'])) {
        update_user_meta($user_id, 'lw_product_pa_magazine_ire_print_digital', 'yes');
      }
      else {
        update_user_meta($user_id, 'lw_product_pa_magazine_ire_print_digital', '');
      }

      if (isset($_POST['lw_product_pa_magazine_ire_digital'])) {
        update_user_meta($user_id, 'lw_product_pa_magazine_ire_digital', 'yes');
      }
      else {
        update_user_meta($user_id, 'lw_product_pa_magazine_ire_digital', '');
      }

      if (isset($_POST['lw_product_ia_news'])) {
        update_user_meta($user_id, 'lw_product_ia_news', 'yes');
      }
      else {
        update_user_meta($user_id, 'lw_product_ia_news', '');
      }

      if (isset($_POST['lw_product_ia_magazine_print_digital'])) {
        update_user_meta($user_id, 'lw_product_ia_magazine_print_digital', 'yes');
      }
      else {
        update_user_meta($user_id, 'lw_product_ia_magazine_print_digital', '');
      }

      if (isset($_POST['lw_product_ia_magazine_digital'])) {
        update_user_meta($user_id, 'lw_product_ia_magazine_digital', 'yes');
      }
      else {
        update_user_meta($user_id, 'lw_product_ia_magazine_digital', '');
      }

      if (isset($_POST['lw_product_fsa_news'])) {
        update_user_meta($user_id, 'lw_product_fsa_news', 'yes');
      }
      else {
        update_user_meta($user_id, 'lw_product_fsa_news', '');
      }

      if (isset($_POST['lw_product_ei_news'])) {
        update_user_meta($user_id, 'lw_product_ei_news', 'yes');
      }
      else {
        update_user_meta($user_id, 'lw_product_ei_news', '');
      }

      if (isset($_POST['lw_product_ei_magazine_print_digital'])) {
        update_user_meta($user_id, 'lw_product_ei_magazine_print_digital', 'yes');
      }
      else {
        update_user_meta($user_id, 'lw_product_ei_magazine_print_digital', '');
      }

      if (isset($_POST['lw_product_ei_magazine_digital'])) {
        update_user_meta($user_id, 'lw_product_ei_magazine_digital', 'yes');
      }
      else {
        update_user_meta($user_id, 'lw_product_ei_magazine_digital', '');
      }

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
