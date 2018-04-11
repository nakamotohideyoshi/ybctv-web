<?php
/*
Plugin Name: Last Word Top Stories
Plugin URI: http://www.ybc.tv
Description: Top stories for Frontpage
Author: yBC
Version: 1.0
Author URI: http://www.ybc.tv
*/

add_action('admin_menu', 'add_top_stories_menu_item');
function add_top_stories_menu_item() {
  add_options_page(
    'Top Stories',
    'Top Stories',
    'edit_posts',
    'top_stories_settings',
    'add_top_stories_settings_page'
  );
}

function add_top_stories_settings_page() {
  $posts = get_posts( array( 'posts_per_page' => 100 ) );

  if ( $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['top_stories_article_2']) && isset($_POST['top_stories_article_3']) 
    && isset($_POST['top_stories_article_4']) && isset($_POST['top_stories_article_5']) && isset($_POST['top_stories_article_6']))
  {
    update_option('top_stories_article_2', $_POST['top_stories_article_2'] );
    update_option('top_stories_article_3', $_POST['top_stories_article_3'] );
    update_option('top_stories_article_4', $_POST['top_stories_article_4'] );
    update_option('top_stories_article_5', $_POST['top_stories_article_5'] );
    update_option('top_stories_article_6', $_POST['top_stories_article_6'] );
  }

  $top_stories_article_2 = get_option('top_stories_article_2', 0);
  $top_stories_article_3 = get_option('top_stories_article_3', 0);
  $top_stories_article_4 = get_option('top_stories_article_4', 0);
  $top_stories_article_5 = get_option('top_stories_article_5', 0);
  $top_stories_article_6 = get_option('top_stories_article_6', 0);

  ?>
  <div class="most-read-settings wrap">
    <h2>Top stories</h2>
    <div>
        Please either select the article from the drop down option or add the Wordpress article ID in the box.
        To find the Wordpress article ID please use the instructions from this
        <a href="https://www.youtube.com/watch?v=fLg2T1AvmFE" target="_blank">video</a>.
    </div>

    <form action="" method="post">
      <table class="form-table">
        <tr>
          <th scope="row">Top Stories Article 2</th>
          <td>
            <br/>

            <select name="top_stories_article_2" id="top_stories_article_2_combo" onchange="document.getElementById('top_stories_article_2_field').value = this.value;">
              <option value="">-</option>
              <?php foreach( $posts as $post ): ?>
                <option value="<?php echo $post->ID; ?>" <?php echo (int)$top_stories_article_2 == $post->ID ? 'selected="selected"' : ''; ?>>
                  <?php echo $post->post_title; ?></option>
              <?php endforeach; ?>
            </select>
          </td>
        </tr>
        <tr>
          <th scope="row">&nbsp;</th>
          <td>
            <input type="text" id="top_stories_article_2_field" name="top_stories_article_2" value="<?php echo $top_stories_article_2; ?>" />

            <span>(Wordpress article ID)</span>
          </td>
        </tr>
        
       <tr>
          <th scope="row">Top Stories Article 3</th>
          <td>
            <br/>

            <select name="top_stories_article_3" id="top_stories_article_3_combo" onchange="document.getElementById('top_stories_article_3_field').value = this.value;">
              <option value="">-</option>
              <?php foreach( $posts as $post ): ?>
                <option value="<?php echo $post->ID; ?>" <?php echo (int)$top_stories_article_3 == $post->ID ? 'selected="selected"' : ''; ?>>
                  <?php echo $post->post_title; ?></option>
              <?php endforeach; ?>
            </select>
          </td>
        </tr>
        <tr>
          <th scope="row">&nbsp;</th>
          <td>
            <input type="text" id="top_stories_article_3_field" name="top_stories_article_3" value="<?php echo $top_stories_article_3; ?>" />

            <span>(Wordpress article ID)</span>
          </td>
        </tr>

        <tr>
          <th scope="row">Top Stories Article 4</th>
          <td>
            <br/>

            <select name="top_stories_article_4" id="top_stories_article_4_combo" onchange="document.getElementById('top_stories_article_4_field').value = this.value;">
              <option value="">-</option>
              <?php foreach( $posts as $post ): ?>
                <option value="<?php echo $post->ID; ?>" <?php echo (int)$top_stories_article_4 == $post->ID ? 'selected="selected"' : ''; ?>>
                  <?php echo $post->post_title; ?></option>
              <?php endforeach; ?>
            </select>
          </td>
        </tr>
        <tr>
          <th scope="row">&nbsp;</th>
          <td>
            <input type="text" id="top_stories_article_4_field" name="top_stories_article_4" value="<?php echo $top_stories_article_4; ?>" />

            <span>(Wordpress article ID)</span>
          </td>
        </tr>

        <tr>
          <th scope="row">Top Stories Article 5</th>
          <td>
            <br/>

            <select name="top_stories_article_5" id="top_stories_article_5_combo" onchange="document.getElementById('top_stories_article_5_field').value = this.value;">
              <option value="">-</option>
              <?php foreach( $posts as $post ): ?>
                <option value="<?php echo $post->ID; ?>" <?php echo (int)$top_stories_article_5 == $post->ID ? 'selected="selected"' : ''; ?>>
                  <?php echo $post->post_title; ?></option>
              <?php endforeach; ?>
            </select>
          </td>
        </tr>
        <tr>
          <th scope="row">&nbsp;</th>
          <td>
            <input type="text" id="top_stories_article_5_field" name="top_stories_article_5" value="<?php echo $top_stories_article_5; ?>" />

            <span>(Wordpress article ID)</span>
          </td>
        </tr>

        <tr>
          <th scope="row">Top Stories Article 6</th>
          <td>
            <br/>

            <select name="top_stories_article_6" id="top_stories_article_6_combo" onchange="document.getElementById('top_stories_article_6_field').value = this.value;">
              <option value="">-</option>
              <?php foreach( $posts as $post ): ?>
                <option value="<?php echo $post->ID; ?>" <?php echo (int)$top_stories_article_6 == $post->ID ? 'selected="selected"' : ''; ?>>
                  <?php echo $post->post_title; ?></option>
              <?php endforeach; ?>
            </select>
          </td>
        </tr>
        <tr>
          <th scope="row">&nbsp;</th>
          <td>
            <input type="text" id="top_stories_article_6_field" name="top_stories_article_6" value="<?php echo $top_stories_article_6; ?>" />

            <span>(Wordpress article ID)</span>
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