<?php
class lw_import {

  function __construct() {
    add_action('admin_menu', array($this, 'add_menu_item'));
    add_action('admin_enqueue_scripts', array($this, 'admin_enqueue'));
    add_filter('upload_mimes', array($this, 'add_xml_mimetype'));
    add_action('wp_ajax_process', array($this, 'process'));
    add_action('wp_ajax_generate_image_size', array($this, 'generate_image_size'));
  }

  function add_menu_item() {
    add_submenu_page(
      'tools.php',
      'Last Word Import',
      'Last Word Import',
      'manage_options',
      'lw_import',
      array($this, 'add_admin_page')
    );
  }

  function add_admin_page() {
    wp_enqueue_media();

    ?>
    <div class="lw-import wrap">
      <h2>Last Word Import <img class="ajax-loader hide" src="<?php echo plugin_dir_url(__FILE__) . 'images/ajax-loader.gif' ?>" /></h2>
      <h3>Categories <span id="category-complete">Processing complete!</span></h3>
      <div id="category-import-file-url">No file selected</div>
      <input type="button" id="category" class="button-primary open" value="Select" />
      <input type="button" id="category-process" class="button-primary process hide" value="Process" import="category" />
      <input type="hidden" id="category-import-file-id" />

      <h3>Tags <span id="tag-complete">Processing complete!</span></h3>
      <div id="tag-import-file-url">No file selected</div>
      <input type="button" id="tag" class="button-primary open" value="Select" />
      <input type="button" id="tag-process" class="button-primary process hide" value="Process" import="tag" />
      <input type="hidden" id="tag-import-file-id" />

      <h3>Types <span id="type-complete">Processing complete!</span></h3>
      <div id="type-import-file-url">No file selected</div>
      <input type="button" id="type" class="button-primary open" value="Select" />
      <input type="button" id="type-process" class="button-primary process hide" value="Process" import="type" />
      <input type="hidden" id="type-import-file-id" />

      <h3>Collections <span id="collection-complete">Processing complete!</span></h3>
      <div id="collection-import-file-url">No file selected</div>
      <input type="button" id="collection" class="button-primary open" value="Select" />
      <input type="button" id="collection-process" class="button-primary process hide" value="Process" import="collection" />
      <input type="hidden" id="collection-import-file-id" />

      <h3>Authors <span id="author-complete">Processing complete!</span></h3>
      <div id="author-import-file-url">No file selected</div>
      <input type="button" id="author" class="button-primary open" value="Select" />
      <input type="button" id="author-process" class="button-primary process hide" value="Process" import="author" />
      <input type="hidden" id="author-import-file-id" />

      <h3>Copy Images <span id="copy-image-complete">Processing complete!</span></h3>
      <div id="copy-image-import-file-url">No file selected</div>
      <input type="button" id="copy-image" class="button-primary open" value="Select" />
      <input type="button" id="copy-image-process" class="button-primary process hide" value="Process" import="copy-image" />
      <input type="hidden" id="copy-image-import-file-id" />

      <h3>Generate Image Sizes <span id="generate-image-size-complete">Processing complete!</span></h3>
      <input type="button" id="generate-image-size" class="button-primary generate-image-size" value="Start" />

      <h3>Articles <span id="article-complete">Processing complete!</span></h3>
      <div id="article-import-file-url">No file selected</div>
      <input type="button" id="article" class="button-primary open" value="Select" />
      <input type="button" id="article-process" class="button-primary process hide" value="Process" import="article" />
      <input type="hidden" id="article-import-file-id" />
    </div>
    <?php
  }

  function admin_enqueue() {
    wp_enqueue_script( 'lw_import_main_js', plugin_dir_url(__FILE__) . 'js/main.js', array(), '1.0.0',  true);

    wp_register_style('lw_import_main_css', plugin_dir_url(__FILE__) . 'css/main.css', false, '1.0.0');
    wp_enqueue_style('lw_import_main_css');
  }

  function add_xml_mimetype($existing_mimes) {
    $existing_mimes['xml'] = 'application/atom+xml';
    return $existing_mimes;
  }

  function process() {
    parse_str($_POST['data_post'], $options);
    $type = $options['type'];
    $id = $options['id'];
    $url = wp_get_attachment_url($id);

    $xml = simplexml_load_file($url);

    switch ($type) {
      case 'category' :
        $this->import_category($xml);
        break;
      case 'tag' :
        $this->import_tag($xml);
        break;
      case 'type' :
        $this->import_type($xml);
        break;
      case 'collection' :
        $this->import_collection($xml);
        break;
      case 'author' :
        $this->import_author($xml);
        break;
      case 'copy-image' :
        $this->copy_image($xml);
        break;
      case 'generate-image-sizes' :
        $this->generate_image_size();
      case 'article' :
        $this->import_article($xml);
        break;
      default :
        break;
    }
    die();
  }

  /*
    * Import categories
    * - Add new categories
    * - Update categories (slug only)
    * - Add parent category
  */
  function import_category($xml) {
    // Loop through all xml categories and insert/update
    foreach ($xml->category as $category) {
      // Check if exists
      $existing_category = get_term_by('name', $category->name, 'category');
      $existing_category_id = $existing_category ? $existing_category->term_id : 0;


      if ($existing_category_id == 0) {
        // New category
        wp_insert_term($category->name, 'category', array('slug' => $category->alias_name));
      }
      else {
        // Update category
        wp_update_term($category_id, 'category', array('slug' => $category->alias_name));
      }
    }

    // Loop through and add parent relationships
    foreach ($xml->category as $category) {
      if (isset($category->parent_name)) {
        $current_category = get_term_by('name', $category->name, 'category');
        $parent_category = get_term_by('name', $category->parent_name, 'category');
        wp_update_term($current_category->term_id, 'category', array('parent' => $parent_category->term_id));
      }
    }
  }

  /*
    * Import tags
    * - Add new tags
    * - Update tags (slug only)
    * Wordpress sanitizes slugs, so to keep the slugs the same a raw query is used.
  */
  function import_tag($xml) {
    global $wpdb;
    $blog_id = get_current_blog_id();

    // Loop through all xml tags and insert/update
    foreach ($xml->tag as $tag) {
      // Check if exists
      $existing_tag = $wpdb->get_row("SELECT term_id FROM wp_terms WHERE name = '" . addslashes($tag->name) . "'");

      if (is_null($existing_tag)) {
        // New tag
        $wpdb->query("INSERT INTO wp_" . $blog_id . "_terms (name, slug, term_group) VALUES ('" . addslashes($tag->name) . "', '" . addslashes((string)$tag->alias_name) . "', 0)");
        $wpdb->query("INSERT INTO wp_" . $blog_id . "_term_taxonomy (term_id, taxonomy, count) VALUES (" . $wpdb->insert_id . ", 'post_tag', 0)");
      }
      else {
        // Update tag
        $wpdb->query("UPDATE wp_" . $blog_id . "_terms SET slug = '" . (string)$tag->alias_name . "' WHERE term_id = " . $existing_tag['term_id']);
        if ($tag->name == 'Shaun Port') {
          print_r("UPDATE wp_" . $blog_id . "_terms SET slug = '" . (string)$tag->alias_name . "' WHERE term_id = " . $existing_tag['term_id']);
        }
      }
    }
  }

  /*
    * Import types
    * - Add new types
    * - Update types (slug only)
  */
  function import_type($xml) {
    // Loop through all xml sections and insert/update
    foreach ($xml->section as $type) {
      // Check if exists
      $existing_type = get_term_by('name', $type->name, 'type');
      $existing_type_id = $existing_type ? $existing_type->term_id : 0;


      if ($existing_type_id == 0) {
        // New type
        wp_insert_term($type->name, 'type', array('slug' => $type->alias_name));
      }
      else {
        // Update type
        wp_update_term($type_id, 'type', array('slug' => $type->alias_name));
      }
    }
  }

  /*
    * Import collections
    * - Add new collections
    * - Update collections (slug only)
  */
  function import_collection($xml) {
    // Loop through all xml collections and insert/update
    foreach ($xml->collection as $collection) {
      // Check if exists
      $existing_collection = get_term_by('name', $collection->name, 'collection');
      $existing_collection_id = $existing_collection ? $existing_collection->term_id : 0;


      if ($existing_collection_id == 0) {
        // New collection
        wp_insert_term($collection->name, 'collection', array('slug' => $collection->alias_name));
      }
      else {
        // Update collection
        wp_update_term($collection_id, 'collection', array('slug' => $collection->alias_name));
      }
    }
  }

  /*
    * Import Authors
    * - Add new authors
    * - Update authors
  */
  function import_author($xml) {
    // Loop through all xml authors and insert/update
    foreach ($xml->author as $author) {
      // Check if exists
      if ($author->email != '') {
        $existing_author = get_user_by('email', $author->email);

        $userdata = array(
          'user_login' => strtolower(str_replace(' ', '', $author->name)),
          'user_nicename' => strtolower(str_replace(' ', '-', $author->name)),
          'user_email' => $author->email,
          'display_name' => $author->name,
          'first_name' => $author->firstname,
          'last_name' => $author->lastname,
          'description' => $author->profile->biography,
          'user_registered' => $author->created_at,
          'role' => 'author'
        );

        if ($existing_author) {
          // Update author
          $userdata['ID'] = $existing_author->ID;

        }
        else {
          // Add Author
          $userdata['user_pass'] = wp_generate_password();
        }

        $current_user_id = wp_insert_user($userdata);
        $this->process_user_meta($current_user_id, 'lw_company_name', (string)$author->profile->company_name);
        $this->process_user_meta($current_user_id, 'lw_company_website_url', (string)$author->profile->company_website_url);
        $this->process_user_meta($current_user_id, 'lw_company_linkedin_url', (string)$author->profile->company_linkedin_url);
        $this->process_user_meta($current_user_id, 'lw_company_twitter_username', (string)$author->profile->company_twitter_user_name);
        $this->process_user_meta($current_user_id, 'lw_title', (string)$author->profile->title);
        $this->process_user_meta($current_user_id, 'lw_professional_title', (string)$author->profile->professional_title);
        $this->process_user_meta($current_user_id, 'lw_blog_url', (string)$author->profile->blog);
        $this->process_user_meta($current_user_id, 'lw_linkedin_url', (string)$author->profile->linkedin_url);
        $this->process_user_meta($current_user_id, 'lw_twitter_username', (string)$author->profile->twitter_user_name);
        $this->process_user_meta($current_user_id, 'lw_google_plus_url', (string)$author->profile->google_plus);
      }
    }
  }

  /*
    * Import articles
    * - Add new articles
    * - Update articles
  */
  function import_article($xml) {
    global $coauthors_plus;

    // Loop through all xml articles and insert/update
    foreach ($xml->article as $article) {
      // Post Status
      $post_status = 'draft';

      if ($article->publish_date != '' && $article->active != 'false') {
        $post_status = 'publish';
      }
      else if ($article->waiting_form_approval != '') {
        $post_status = 'pending';
      }


      // Main Details
      $args = array(
        'post_date' => $article->publish_date != '' && $article->active != 'false' ? $article->publish_date : $article->created_at,
        'post_modified' => $article->created_at,
        'post_title' => $article->title,
        'post_name' => $article->url_part,
        'post_status' => $post_status,
        'post_content' => $article->content,
        'post_excerpt' => $article->description
      );

      // Categories
      $categories = array();

      foreach ($article->categories->category as $category) {
        $existing_category = get_term_by('name', htmlspecialchars_decode($category->category_name), 'category');

        if ($existing_category) {
          $categories[] = $existing_category->term_id;
        }
      }

      $args['post_category'] = $categories;

      // Check if exists
      $existing_article = new WP_Query(array(
        'post_type' => 'post',
        'meta_key' => 'lw_old_article_id',
        'meta_value' => (string)$article->id,
        'posts_per_page => 1',
      ));

      if ($existing_article->have_posts()) {
        // Existing Article
        $args['ID'] = $existing_article->posts[0]->ID;
      }

      $post_id = wp_insert_post($args);

      // Tags
      $tags = array();

      foreach ($article->tags->tag as $tag) {
        $existing_tag = get_term_by('slug', (string)$tag->alias_name, 'post_tag');
        if ($existing_tag) {
          $tags[] = $existing_tag->term_id;
        }
      }

      wp_set_object_terms($post_id, $tags, 'post_tag');

      // Type
      if ($article->content_type != '') {
        $existing_type = get_term_by('name', (string)$article->content_type, 'type');

        if ($existing_type) {
          wp_set_object_terms($post_id, $existing_type->term_id, 'type');
        }
      }

      // Authors
      // set the first author as the article author, any further added to Co-Authors Plus
      $first_author_set = false;
      $authors = array();

      foreach ($article->authors->author as $author) {
        if (trim($author->email) != '') {
          $article_author = get_user_by('email', $author->email);
          if ($first_author_set == false) {
            $args['post_author'] = $article_author->ID;
            $first_author_set = true;
          }

          $authors[] = $article_author->user_nicename;
        }
      }

      if (count($authors) != 0) {
        $coauthors_plus->add_coauthors($post_id, $authors);
      }

      // Meta
      update_post_meta($post_id, 'lw_old_article_id', (string)$article->id);
      update_post_meta($post_id, 'lw_primary_medium', (string)$article->primary_medium);
      update_post_meta($post_id, 'lw_content_type', (string)$article->content_type);
      update_post_meta($post_id, 'lw_subtitle', (string)$article->sub_title);
      update_post_meta($post_id, 'lw_description', (string)$article->description);
      update_post_meta($post_id, 'lw_expiry_date', (string)$article->expiry_date);
      update_post_meta($post_id, 'lw_sponsored', (string)$article->sponsored);
      update_post_meta($post_id, 'lw_twitter_headline', (string)$article->twitter_headline);
      update_post_meta($post_id, 'lw_premium', $article->premium != '' && $article->premium != 'Free' ? 'yes' : '');
      update_post_meta($post_id, 'lw_cross_post_facebook', $article->publish_facebook == 'true' ? 'yes' : '');
      update_post_meta($post_id, 'lw_cross_post_twitter', $article->publish_twitter == 'true' ? 'yes' : '');
      update_post_meta($post_id, 'lw_cross_post_linkedin', $article->publish_linkedin == 'true' ? 'yes' : '');
      update_post_meta($post_id, 'lw_cross_post_google_plus', $article->publish_google == 'true' ? 'yes' : '');
      update_post_meta($post_id, 'lw_brightcove_video_id', (string)$article->video_stream_id);
      update_post_meta($post_id, 'lw_read_count', (string)$article->read_count);

      // Gallery
      if ($article->content_type == 'Gallery') {
        $gallery_images = array();
        foreach ($article->gallery->image as $image) {
          $gallery_images[(string)$image->gallery_image_position] = array(
            'caption' => (string)$image->gallery_image_caption,
            'description' => (string)$image->gallery_image_description,
            'order' => (string)$image->gallery_image_position,
            'url' => str_replace('350x250', '640x410', (string)$image->gallery_image_path)
          );
        }

        update_post_meta($post_id, 'lw_gallery', $gallery_images);
      }

      if ($article->image != '') {
        $image_path = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
        $image_path .= '/image-archive/';
        $image_path .= $this->get_image_subdir($article->image);
        $image_path .= strtolower(substr(basename($article->image), 0, 2)) . '/';
        $image_path .= str_replace('350x250', '640x410', basename((string)$article->image));

        update_post_meta($post_id, 'lw_featured_image_url', $image_path);
        update_post_meta($post_id, '_thumbnail_id', 'by_url');
      }
      else {
        delete_post_meta($post_id, 'lw_featured_image_url');
        if (get_post_meta($post_id, '_thumbnail_id', true) === 'by_url') {
          delete_post_meta($post_id, '_thumbnail_id');
        }
      }
    }
  }

  /*
    * Copy Images
    * - Get images from current site
    * - Update if changed
  */
  function copy_image($xml) {
      foreach($xml->article as $article) {
        $destination = $_SERVER['DOCUMENT_ROOT'] . "/image-archive/";
        if ($article->image != '') {
          $destination .= $this->get_image_subdir($article->image);

          $source = 'http://' . str_replace('350x250', '640x410', (string)$article->image);
          $sub_dir = strtolower(substr(basename($source), 0, 2));

          if (!file_exists($destination . $sub_dir)) {
            mkdir($destination . $sub_dir, 0777, true);
          }

          $destination .= $sub_dir . '/' . basename($source);

          if (!file_exists($destination)) {
            $image = file_get_contents($source);
            $fp = fopen($destination, 'w');

            fwrite($fp, $image);
            fclose($fp);
          }
        }
      }
  }


  function generate_image_size() {
    global $_wp_additional_image_sizes;

    $wp_default_sizes = array('thumbnail', 'medium', 'medium_large', 'large', 'post_thumbnail');
    $image_size_names = get_intermediate_image_sizes();
    $image_sizes = array();
    $initial_width = 640;
    $initial_height = 410;

    foreach($image_size_names as $image_size_name) {
      if (in_array($image_size_name, $wp_default_sizes)) {
        $image_sizes[] = array(
          'name' => $image_size_name,
          'width' => get_option($image_size_name . '_size_w'),
          'height' => get_option($image_size_name . '_size_h'),
          'crop' => get_option($image_size_name . '_crop')
        );
      }
      else if(strpos($image_size_name, 'guest') === false) {
        $image_sizes[] = array(
          'name' => $image_size_name,
          'width' => $_wp_additional_image_sizes[$image_size_name]['width'],
          'height' => $_wp_additional_image_sizes[$image_size_name]['height'],
          'crop' => $_wp_additional_image_sizes[$image_size_name]['crop']
        );
      }
    }
    $path = $_SERVER['DOCUMENT_ROOT'] . "/image-archive/pa/";
    $path_iterator = new RecursiveDirectoryIterator($path);

    foreach (new RecursiveIteratorIterator($path_iterator) as $fileinfo) {

      if (!strpos($fileinfo->getFilename(), '.') == 0) {
        foreach($image_sizes as $image_size) {
          if ($image_size['width'] != 0 && $image_size['height'] != 0
            && $image_size['width'] < $initial_width && $image_size['height'] < $initial_height
            && $image_size['name'] != 'post-thumbnail') {

            $resize_filename = str_replace($initial_width . 'x' . $initial_height, $image_size['width'] . 'x' . $image_size['height'], $fileinfo->getPathname());

            if (!file_exists($resize_filename)) {
              $image = wp_get_image_editor($fileinfo->getPathname());

              if (!is_wp_error($image)) {
                $image->set_quality(90);
                $image->resize($image_size['width'], $image_size['height'], array('center', 'center'));
                $image->save($resize_filename);
              }
            }
          }
        }
      }
    }

    die();
  }

  function get_image_subdir($url) {
    $subdir = '';
    if (strpos($url, 'www.portfolio-adviser.com') !== false) {
      $subdir = 'pa/';
    }
    else if (strpos($url, 'www.fundselectorasia.com') !== false) {
      $subdir = 'fsa/';
    }
    else if (strpos($url, 'www.international-adviser.com') !== false) {
      $subdir = 'ia/';
    }
    else if (strpos($url, 'www.expertinvestoreurope.com') !== false) {
      $subdir = 'ei/';
    }

    return $subdir;
  }

  function process_user_meta($user_id, $meta_key, $meta_value) {
    $user_meta = get_user_meta($user_id, $meta_key, true);

    if ($user_meta) {
      if ($meta_value != '') {
        update_user_meta($user_id, $meta_key, $meta_value);
      }
      else {
        delete_user_meta($user_id, $meta_key);
      }
    }
    else {
      if ($meta_value != '') {
        add_user_meta($user_id, $meta_key, $meta_value, true);
      }
    }
  }
}
