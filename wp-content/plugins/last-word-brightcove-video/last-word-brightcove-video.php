<?php
/*
Plugin Name: Last Word Brightcove Video
Plugin URI: http://www.ybc.tv
Description: Handles embedding of Brightcove videos
Author: yBC
Version: 1.0
Author URI: http://www.ybc.tv
*/

add_action('admin_menu', 'add_brightcove_menu_item');
add_action('admin_init', 'register_brightcove_settings');

function add_brightcove_menu_item() {
  add_options_page(
    'Brightcove',
    'Brightcove',
    'manage_options',
    'brightcove_settings',
    'add_brightcove_settings_page'
  );
}

function register_brightcove_settings() {
  register_setting('brightcove_settings', 'brightcove_account_id');
  register_setting('brightcove_settings', 'brightcove_player_id');
  register_setting('brightcove_settings', 'brightcove_player_non_autoplay_id');
}

function add_brightcove_settings_page() {
  ?>
  <div class="brightcove-settings wrap">
    <h2>Brightcove Settings</h2>
    <form action="options.php" method="post">
      <?php
        settings_fields('brightcove_settings');
        do_settings_sections('brightcove_settings');
      ?>
      <table class="form-table">
        <tr>
          <th scope="row">Account ID</th>
          <td>
            <input type="text" name="brightcove_account_id" value="<?php echo esc_attr(get_option('brightcove_account_id')); ?>" size="50" />
          </td>
        </tr>
        <tr>
          <th scope="row">Player ID (Autoplay)</th>
          <td>
            <input type="text" name="brightcove_player_id" value="<?php echo esc_attr(get_option('brightcove_player_id')); ?>" size="50" />
          </td>
        </tr>
        <tr>
          <th scope="row">Player ID (Non Autoplay)</th>
          <td>
            <input type="text" name="brightcove_player_non_autoplay_id" value="<?php echo esc_attr(get_option('brightcove_player_non_autoplay_id')); ?>" size="50" />
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

function brightcove_video($video_id, $autoplay = true) {
  $account_id = esc_attr(get_option('brightcove_account_id'));

  if ($autoplay) {
    $player_id = esc_attr(get_option('brightcove_player_id'));
  }
  else {
    $player_id = esc_attr(get_option('brightcove_player_non_autoplay_id'));
  }

  ?>
  <div class="brightcove-video-wrap">
    <div style="position: relative; display: block; max-width: 100%;">
      <div style="padding-top: 50%;">
        <video data-account="<?php echo $account_id; ?>"
          data-video-id="<?php echo $video_id; ?>"
          data-player="<?php echo $player_id ?>"
          data-embed="default"
          data-application-id
          class="video-js"
          controls
          style="position: absolute; top: 0px; right: 0px; bottom: 0px; left: 0px; width: 100%; height: 100%;">
        </video>
        <script src="//players.brightcove.net/<?php echo $account_id; ?>/<?php echo $player_id ?>_default/index.min.js"></script>
      </div>
    </div>
  </div>
  <?php
}



/***
 * Improved version, capable of lazy loading
 */
function brightcove2_video($video_id, $autoplay = true) {
    $account_id = esc_attr(get_option('brightcove_account_id'));

    if ($autoplay) {
        $player_id = esc_attr(get_option('brightcove_player_id'));
    }
    else {
        $player_id = esc_attr(get_option('brightcove_player_non_autoplay_id'));
    }

    ?>
    <div class="brightcove-video-wrap">
        <div style="position: relative; display: block; max-width: 100%;">
            <div style="padding-top: 50%;">
                <video
                        id="<?php echo $video_id;?>"
                        data-pid="<?php echo $player_id;?>"
                        data-embed="default"
                        class="video-js"
                        controls
                        style="position: absolute; top: 0px; right: 0px; bottom: 0px; left: 0px; width: 100%; height: 100%;">
                </video>

            </div>
        </div>
    </div>
    <?php
}

/***
 * This goes to page footer to save some speed (lazy load)
 */
function brightcove2_footer ()
{
    $account_id = esc_attr(get_option('brightcove_account_id'));
    $player_id = esc_attr(get_option('brightcove_player_non_autoplay_id'));
    ?>
    <script src="//players.brightcove.net/<?php echo $account_id; ?>/<?php echo $player_id ?>_default/index.min.js"></script>

    <script type="text/javascript">
            console.log("brightcove2_footer...");

            var videoDivs = document.querySelectorAll('.video-js[data-pid]');

            if (videoDivs == null || videoDivs.length == 0) {
                console.log("no video divs found");

            } else {
                for (var i = 0; i<videoDivs.length; i++) {
                    var videoId = videoDivs[i].getAttribute('id');
                    var playerId = videoDivs[i].getAttribute('data-pid');

                    var vTag = document.getElementById(videoId);

                    vTag.setAttribute('data-account', "<?php echo $account_id; ?>");
                    vTag.setAttribute('data-player', playerId);
                    vTag.setAttribute('data-video-id', videoId);
                    bc(vTag);
                }
            }

    </script>
    <?php
}