<?php
/*
Plugin Name: Last Word Sponsored Box
Plugin URI: http://www.ybc.tv
Description: Sponsored box on Last Word Websites
Author: yBC
Version: 1.0
Author URI: http://www.ybc.tv
*/

add_action('admin_menu', 'add_sponsored_box_menu_item');
function add_sponsored_box_menu_item() {
  add_options_page(
    'Sponsored Box',
    'Sponsored Box',
    'edit_posts',
    'sponsored_box_settings',
    'add_sponsored_box_settings_page'
  );
}

function add_sponsored_box_settings_page() {
  $posts = get_posts( array( 
    'posts_per_page' => 100,
    'tax_query' => array(
        array(
          'taxonomy' => 'type',
          'field' => 'slug',
          'terms' => 'sponsored',
        )     
      )
    ) 
  );

  

  if ( $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sponsored_box_article_1']) && isset($_POST['sponsored_box_article_2']) 
    && isset($_POST['sponsored_box_article_3']) && isset($_POST['sponsored_box_article_4']) && isset($_POST['sponsored_box_article_5']))
  {
    update_option('sponsored_box_article_1', $_POST['sponsored_box_article_1'] );
    update_option('sponsored_box_article_2', $_POST['sponsored_box_article_2'] );
    update_option('sponsored_box_article_3', $_POST['sponsored_box_article_3'] );
    update_option('sponsored_box_article_4', $_POST['sponsored_box_article_4'] );
    update_option('sponsored_box_article_5', $_POST['sponsored_box_article_5'] );
  }

  $sponsored_box_article_1 = get_option('sponsored_box_article_1', 0);
  $sponsored_box_article_2 = get_option('sponsored_box_article_2', 0);
  $sponsored_box_article_3 = get_option('sponsored_box_article_3', 0);
  $sponsored_box_article_4 = get_option('sponsored_box_article_4', 0);
  $sponsored_box_article_5 = get_option('sponsored_box_article_5', 0);

  ?>
  <div class="most-read-settings wrap">
    <h2>Sponsored Articles</h2>
    <div>
        Please either select the article from the drop down option or add the Wordpress article ID in the box.
        To find the Wordpress article ID please use the instructions from this
        <a href="https://www.youtube.com/watch?v=fLg2T1AvmFE" target="_blank">video</a>.
    </div>

    <form action="" method="post">
      <table class="form-table">
        
        <tr>
          <th scope="row">Sponsored Box Article 1</th>
          <td>
            <br/>

            <select name="sponsored_box_article_1" id="sponsored_box_article_1_combo" onchange="document.getElementById('sponsored_box_article_1_field').value = this.value;">
              <option value="">-</option>
              <?php foreach( $posts as $post ): ?>
                <option value="<?php echo $post->ID; ?>" <?php echo (int)$sponsored_box_article_1 == $post->ID ? 'selected="selected"' : ''; ?>>
                  <?php echo $post->post_title; ?></option>
              <?php endforeach; ?>
            </select>
          </td>
        </tr>
        <tr>
          <th scope="row">&nbsp;</th>
          <td>
            <input type="text" id="sponsored_box_article_1_field" name="sponsored_box_article_1" value="<?php echo $sponsored_box_article_1; ?>" />

            <span>(Wordpress article ID)</span>
          </td>
        </tr>
        
        <tr>
          <th scope="row">Sponsored Box Article 2</th>
          <td>
            <br/>

            <select name="sponsored_box_article_2" id="sponsored_box_article_2_combo" onchange="document.getElementById('sponsored_box_article_2_field').value = this.value;">
              <option value="">-</option>
              <?php foreach( $posts as $post ): ?>
                <option value="<?php echo $post->ID; ?>" <?php echo (int)$sponsored_box_article_2 == $post->ID ? 'selected="selected"' : ''; ?>>
                  <?php echo $post->post_title; ?></option>
              <?php endforeach; ?>
            </select>
          </td>
        </tr>
        <tr>
          <th scope="row">&nbsp;</th>
          <td>
            <input type="text" id="sponsored_box_article_2_field" name="sponsored_box_article_2" value="<?php echo $sponsored_box_article_2; ?>" />

            <span>(Wordpress article ID)</span>
          </td>
        </tr>

        <tr>
          <th scope="row">Sponsored Box Article 3</th>
          <td>
            <br/>

            <select name="sponsored_box_article_3" id="sponsored_box_article_3_combo" onchange="document.getElementById('sponsored_box_article_3_field').value = this.value;">
              <option value="">-</option>
              <?php foreach( $posts as $post ): ?>
                <option value="<?php echo $post->ID; ?>" <?php echo (int)$sponsored_box_article_3 == $post->ID ? 'selected="selected"' : ''; ?>>
                  <?php echo $post->post_title; ?></option>
              <?php endforeach; ?>
            </select>
          </td>
        </tr>
        <tr>
          <th scope="row">&nbsp;</th>
          <td>
            <input type="text" id="sponsored_box_article_3_field" name="sponsored_box_article_3" value="<?php echo $sponsored_box_article_3; ?>" />

            <span>(Wordpress article ID)</span>
          </td>
        </tr>

        <tr>
          <th scope="row">Sponsored Box Article 4</th>
          <td>
            <br/>

            <select name="sponsored_box_article_4" id="sponsored_box_article_4_combo" onchange="document.getElementById('sponsored_box_article_4_field').value = this.value;">
              <option value="">-</option>
              <?php foreach( $posts as $post ): ?>
                <option value="<?php echo $post->ID; ?>" <?php echo (int)$sponsored_box_article_4 == $post->ID ? 'selected="selected"' : ''; ?>>
                  <?php echo $post->post_title; ?></option>
              <?php endforeach; ?>
            </select>
          </td>
        </tr>
        <tr>
          <th scope="row">&nbsp;</th>
          <td>
            <input type="text" id="sponsored_box_article_4_field" name="sponsored_box_article_4" value="<?php echo $sponsored_box_article_4; ?>" />

            <span>(Wordpress article ID)</span>
          </td>
        </tr>

        <tr>
          <th scope="row">Sponsored Box Article 5</th>
          <td>
            <br/>

            <select name="sponsored_box_article_5" id="sponsored_box_article_5_combo" onchange="document.getElementById('sponsored_box_article_5_field').value = this.value;">
              <option value="">-</option>
              <?php foreach( $posts as $post ): ?>
                <option value="<?php echo $post->ID; ?>" <?php echo (int)$sponsored_box_article_5 == $post->ID ? 'selected="selected"' : ''; ?>>
                  <?php echo $post->post_title; ?></option>
              <?php endforeach; ?>
            </select>
          </td>
        </tr>
        <tr>
          <th scope="row">&nbsp;</th>
          <td>
            <input type="text" id="sponsored_box_article_5_field" name="sponsored_box_article_5" value="<?php echo $sponsored_box_article_5; ?>" />

            <span>(Wordpress article ID)</span>
          </td>
        </tr>  
        
        <tr>
          <th colspan="2">
            <?php submit_button(); ?>
          </th>
        </tr>

      </table>
    </form>
  </div>
  <?
}