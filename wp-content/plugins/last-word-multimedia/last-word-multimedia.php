<?php
/*
Plugin Name: Last Word Multimedia
Plugin URI: http://www.ybc.tv
Description: Multimedia section on Last Word Websites
Author: yBC
Version: 1.0
Author URI: http://www.ybc.tv
*/

add_action('admin_menu', 'add_multimedia_section_menu_item');
function add_multimedia_section_menu_item() {
  add_options_page(
    'Multimedia Section',
    'Multimedia Section',
    'edit_posts',
    'multimedia_section_settings',
    'add_multimedia_section_settings_page'
  );
}

function add_multimedia_section_settings_page() {
  $posts_top = get_posts( array( 
    'posts_per_page' => 100,
    'tax_query' => array(
        array(
          'taxonomy' => 'type',
          'field' => 'slug',
          'terms' => 'video',
        )     
      )
    ) 
  );

  $posts = get_posts( array( 
    'posts_per_page' => 100,
    'tax_query' => array(
        array(
          'taxonomy' => 'type',
          'field' => 'slug',
          'terms' => array('video', 'gallery'),
        )     
      )
    ) 
  );

  

  if ( $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['multimedia_section_article_1']) && isset($_POST['multimedia_section_article_2']) 
    && isset($_POST['multimedia_section_article_3']) && isset($_POST['multimedia_section_article_4']))
  {
    update_option('multimedia_section_article_1', $_POST['multimedia_section_article_1'] );
    update_option('multimedia_section_article_2', $_POST['multimedia_section_article_2'] );
    update_option('multimedia_section_article_3', $_POST['multimedia_section_article_3'] );
    update_option('multimedia_section_article_4', $_POST['multimedia_section_article_4'] );
  }

  $multimedia_section_article_1 = get_option('multimedia_section_article_1', 0);
  $multimedia_section_article_2 = get_option('multimedia_section_article_2', 0);
  $multimedia_section_article_3 = get_option('multimedia_section_article_3', 0);
  $multimedia_section_article_4 = get_option('multimedia_section_article_4', 0);

  ?>
  <div class="most-read-settings wrap">
    <h2>Multimedia Articles</h2>
    <div>
        Please either select the article from the drop down option or add the Wordpress article ID in the box.
        To find the Wordpress article ID please use the instructions from this
        <a href="https://www.youtube.com/watch?v=fLg2T1AvmFE" target="_blank">video</a>.
    </div>

    <form action="" method="post">
      <table class="form-table">
        
        <tr>
          <th scope="row">Multimedia Section Article 1</th>
          <td>
            <br/>

            <select name="multimedia_section_article_1" id="multimedia_section_article_1_combo" onchange="document.getElementById('multimedia_section_article_1_field').value = this.value;">
              <option value="">-</option>
              <?php foreach( $posts_top as $post ): ?>
                <option value="<?php echo $post->ID; ?>" <?php echo (int)$multimedia_section_article_1 == $post->ID ? 'selected="selected"' : ''; ?>>
                  <?php echo $post->post_title; ?></option>
              <?php endforeach; ?>
            </select>
          </td>
        </tr>
        <tr>
          <th scope="row">&nbsp;</th>
          <td>
            <input type="text" id="multimedia_section_article_1_field" name="multimedia_section_article_1" value="<?php echo $multimedia_section_article_1; ?>" />

            <span>(Wordpress article ID)</span>
          </td>
        </tr>
        
        <tr>
          <th scope="row">Multimedia Section Article 2</th>
          <td>
            <br/>

            <select name="multimedia_section_article_2" id="multimedia_section_article_2_combo" onchange="document.getElementById('multimedia_section_article_2_field').value = this.value;">
              <option value="">-</option>
              <?php foreach( $posts as $post ): ?>
                <option value="<?php echo $post->ID; ?>" <?php echo (int)$multimedia_section_article_2 == $post->ID ? 'selected="selected"' : ''; ?>>
                  <?php echo $post->post_title; ?></option>
              <?php endforeach; ?>
            </select>
          </td>
        </tr>
        <tr>
          <th scope="row">&nbsp;</th>
          <td>
            <input type="text" id="multimedia_section_article_2_field" name="multimedia_section_article_2" value="<?php echo $multimedia_section_article_2; ?>" />

            <span>(Wordpress article ID)</span>
          </td>
        </tr>

        <tr>
          <th scope="row">Multimedia Section Article 3</th>
          <td>
            <br/>

            <select name="multimedia_section_article_3" id="multimedia_section_article_3_combo" onchange="document.getElementById('multimedia_section_article_3_field').value = this.value;">
              <option value="">-</option>
              <?php foreach( $posts as $post ): ?>
                <option value="<?php echo $post->ID; ?>" <?php echo (int)$multimedia_section_article_3 == $post->ID ? 'selected="selected"' : ''; ?>>
                  <?php echo $post->post_title; ?></option>
              <?php endforeach; ?>
            </select>
          </td>
        </tr>
        <tr>
          <th scope="row">&nbsp;</th>
          <td>
            <input type="text" id="multimedia_section_article_3_field" name="multimedia_section_article_3" value="<?php echo $multimedia_section_article_3; ?>" />

            <span>(Wordpress article ID)</span>
          </td>
        </tr>

        <tr>
          <th scope="row">Multimedia Section Article 4</th>
          <td>
            <br/>

            <select name="multimedia_section_article_4" id="multimedia_section_article_4_combo" onchange="document.getElementById('multimedia_section_article_4_field').value = this.value;">
              <option value="">-</option>
              <?php foreach( $posts as $post ): ?>
                <option value="<?php echo $post->ID; ?>" <?php echo (int)$multimedia_section_article_4 == $post->ID ? 'selected="selected"' : ''; ?>>
                  <?php echo $post->post_title; ?></option>
              <?php endforeach; ?>
            </select>
          </td>
        </tr>
        <tr>
          <th scope="row">&nbsp;</th>
          <td>
            <input type="text" id="multimedia_section_article_4_field" name="multimedia_section_article_4" value="<?php echo $multimedia_section_article_4; ?>" />

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

function meks_disable_srcset( $sources ) {
    return false;
}
 
add_filter( 'wp_calculate_image_srcset', 'meks_disable_srcset' );