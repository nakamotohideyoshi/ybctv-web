<?php
/*
Plugin Name: Last Word New Password
Plugin URI: http://www.ybc.tv
Description: New password functionality for returning subscribers
Author: yBC
Version: 1.0
Author URI: http://www.ybc.tv
*/

add_action('admin_post_nopriv_last_word_new_password', 'last_word_update_password');
add_action('admin_post_last_word_new_password', 'last_word_update_password');
add_action('wp_enqueue_scripts', 'enqueue_new_password_style');

function enqueue_new_password_style() {
  wp_enqueue_style('new_password', plugin_dir_url(__FILE__) . 'css/main.css', array(), '1.0.0');
}


function last_word_new_password() {
  $status = isset($_GET['status']) ? $_GET['status'] : '';

  ob_start();
  ?>
  <div class="new-password">
    <?php
    if (is_user_logged_in()) {
      wp_redirect(home_url());
      exit;
    }
    if (!isset($_GET['user'])) {
      echo '<div class="new-password-status">';
      echo 'No user specified';
      echo '</div>';
    }
    else {
      $username = $_GET['user'];
      $user = get_user_by('login', esc_attr($username));

      if ($user) {

        if ($status != '') {
          echo '<div class="new-password-status">';

          switch ($status) {
            case 1 :
              echo 'Password and confirm password do not match';
              break;
            case 2 :
              echo 'Please enter a password';
              break;
            case 3 :
              echo 'Please accept the terms and conditions';
              break;
            default :
              break;
          }

          echo '</div>';
        }
      ?>
        <form name="new_password" id="new_password" action="<?php echo admin_url('admin-post.php'); ?>" method="post">
          <input type="hidden" name="action" value="last_word_new_password" />
          <input type="hidden" id="login" name="login" value="<?php echo esc_attr($user->user_login); ?>" autocomplete="off" />
          <table>
            <tr>
              <td class="new-password-label">Your name</td>
              <td><?php echo $user->first_name . ' ' . $user->last_name; ?></td>
            </tr>
            <tr>
              <td class="new-password-label">Your email</td>
              <td><?php echo $user->user_email; ?></td>
            </tr>
            <tr>
              <td class="new-password-label">Enter a new password</td>
              <td><input type="password" name="pass1" id="pass1" class="input" size="20" value="" autocomplete="off" /></td>
            </tr>
            <tr>
              <td class="new-password-label">Confirm new password</td>
              <td><input type="password" name="pass2" id="pass2" class="input" size="20" value="" autocomplete="off" /></td>
            </tr>
            <tr>
              <td colspan="2">
                <input type="checkbox" name="tc-accept" value="yes"> I accept the <a target="_blank" href="/terms-and-conditions">terms and conditions</a>
              </td>
            <tr>
              <td colspan="2">
                <input type="submit" name="submit-new-password" id="submit-new-password" class="button" value="Update Password" />
              </td>
            </tr>
          </table>
        </form>
      <?php
      }
      else {
        echo '<div class="new-password-status">';
        echo 'User does not exist.';
        echo '</div>';
      }
    }
    ?>
  </div>
  <?php
  echo ob_get_clean();
}

function last_word_update_password() {
  $user_login = isset($_POST['login']) ? $_POST['login'] : '';
  $pass1 = isset($_POST['pass1']) ? $_POST['pass1'] : '';
  $pass2 = isset($_POST['pass2']) ? $_POST['pass2'] : '';
  $tc_accept = isset($_POST['tc-accept']) ? $_POST['tc-accept'] : '';

  $redirect_url = '/welcome-back/?user=' . $user_login;

  if ($tc_accept != '') {
    if ($pass1 != '') {
      if ($pass1 != $pass2) {
        $redirect_url .= '&status=1';
      }
      else {
        $user = get_user_by('login', esc_attr($user_login));
        reset_password($user, $pass1);
        update_user_meta($user->id, 'new_tc_accept', 'yes');
        $redirect_url = '/welcome-back-completed/';
      }
    }
    else {
      $redirect_url .= '&status=2';
    }
  }
  else {
    $redirect_url .= '&status=3';
  }

  wp_redirect($redirect_url);
  die();
}
