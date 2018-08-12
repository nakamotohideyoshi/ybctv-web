<?php namespace last_word_tag_manager;

class frontend {
  function tag_manager_head_script() {
    if (self::tag_manager_track_user()) {
      ob_start();
      ?>
      <!-- Google Tag Manager -->
      <script>
        <?php echo self::tag_manager_custom_dimensions(); ?>

        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','<?php echo self::tag_manager_account_id(get_current_blog_id()); ?>');
      </script>
      <!-- End Google Tag Manager -->
      <?php
      return ob_get_clean();
    }
  }

  function tag_manager_body_script() {
    if (self::tag_manager_track_user()) {
      ob_start();
      ?>
      <!-- Google Tag Manager (noscript) -->
      <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo self::tag_manager_account_id(get_current_blog_id()); ?>" height="0" width="0" style="display:none;visibility:hidden"></iframe>
      </noscript>
      <!-- End Google Tag Manager (noscript) -->
      <?php
      return ob_get_clean();
    }
  }

  function tag_manager_account_id($blog_id) {
    switch ($blog_id) {
      case 2 : // Portfolio Adviser
        return 'GTM-PFLLMZ3';
        break;
      case 3 : // International Adviser
        return 'GTM-P3KT4QH';
        break;
      case 4 : // Fund Selector Asia
        return 'GTM-56NBHD2';
        break;
      case 5 : // Expert Investor Europe
        return 'GTM-KW2DK2B';
        break;
      default :
        return '';
    }
  }

  function tag_manager_custom_dimensions() {
    $user_id = 0;
    $logged_in = is_user_logged_in();

    if ($logged_in) {
      $user_id = get_current_user_id();
    }

    ob_start();
    ?>

    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push({
      <?php
        echo "'loggedIn' : " . ($logged_in ? "'true'" : "'false'");

        if ($user_id != 0) {
          echo ",\n'userId' : '"  . $user_id . "'";
        }

        if (is_single()) { // Article
          global $post;

          // Primary Category from Yoast SEO plugin
          $primary_category_id = get_post_meta($post->ID, '_yoast_wpseo_primary_category', true);

          if ($primary_category_id) {
            $primary_category = get_term($primary_category_id);

            if (isset($primary_category->slug)) {
              echo ",\n'primaryCategory' : '" . $primary_category->slug . "'";
            }
          }

          // Categories
          $categories = get_the_category($post->ID);
          $output_categories = '';
          $category_slugs = [];

          foreach ($categories as $category) {
              $category_slugs[] = $category->slug;
          }

          if (!empty($category_slugs)) {
            $output_categories =  implode(',', $category_slugs);
            echo ",\n'categories' : '" . $output_categories . "'";
          }

          // Tags
          $tags = get_the_tags($post->ID);
          $output_tags = '';
          $tag_names = [];

          foreach ($tags as $tag) {
            $tag_names[] = $tag->name;
          }

          if (!empty($tag_names)) {
            $output_tags = implode(',', $tag_names);
            echo ",\n'tags' : '" . $output_tags . "'";
          }
        }

        echo "\n";
      ?>
    });

    <?php
    return ob_get_clean();
  }

  function tag_manager_track_user() {
    $user = wp_get_current_user();
    $analytics_ignore_roles = get_option('analytics_ignore_roles');
    $track_user = true;

    if (!empty($analytics_ignore_roles) && is_array($analytics_ignore_roles)) {
      foreach ($analytics_ignore_roles as $analytics_ignore_role) {
        if (current_user_can($analytics_ignore_role)) {
          $track_user = false;
          break;
        }
      }
    }

    return $track_user;
  }
}
