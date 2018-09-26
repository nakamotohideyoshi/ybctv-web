<?php namespace last_word_ad_units;

class frontend {
  function __construct() {
    $show_ad_units_status = get_option('show_ad_units');

    if ($show_ad_units_status && $show_ad_units_status == 'yes') {
      add_action('wp_enqueue_scripts', array($this, 'enqueue_resources'));
      add_action('script_loader_tag', array($this, 'add_async_attribute'), 10, 2);
    }
  }

  // Enqueue resources.
  function enqueue_resources() {
    // Google Tag Services
    wp_register_script('google-tag-services', 'https://www.googletagservices.com/tag/js/gpt.js', array(), null, false);
    wp_enqueue_script('google-tag-services');

    wp_register_script('ad-unit-js', plugin_dir_url(__FILE__) . 'js/main.js', array('jquery'), null, false);
    wp_enqueue_script('ad-unit-js');

    // Ad Unit CSS
    wp_enqueue_style('last-word-ad-units', plugin_dir_url(__FILE__) . 'css/main.css', array(), '1.0.0');
  }

  function add_async_attribute($tag, $handle) {
    if ('google-tag-services' !== $handle) {
      return $tag;
    }

    return str_replace(' src', ' async="async" src', $tag);
  }

  // Add required JS for Ad Units
  public static function last_word_ad_unit_initialize($post_id) {
    $group_slug = 'rest-of-site';

    if ($post_id == 0) { // Homepage
      $group_slug = 'home';
    }
    else if (is_search() && get_current_blog_id() == 2) { // Search Page on Portfolio Adviser
      $group_slug = 'search';
    }
    else if (is_page() && get_page_template_slug($post_id) == 'template-nri.php') { // NRI Adviser on IA
      $group_slug = 'nri';
    }
    else if (is_page() && get_page_template_slug($post_id) == 'template-blog.php') { // Category Page
      $category_id = get_post_meta($post_id, 'category_page', true);
      $category = get_term_by('id', $category_id, 'category');

      if ($category) {
        $group_slug = $category->slug;
      }
    }
    else if (is_page() && get_page_template_slug($post_id) != 'template-blog.php') { // Normal Page
      $page = sanitize_post($GLOBALS['wp_the_query']->get_queried_object());
      $group_slug = $page->post_name;
    }
    else if (is_archive()) { // Archive Category Page
      $category_id = get_query_var('cat');
      $category = get_category($category_id);
      if ($category) {
        $group_slug = $category->slug;
      }
    }
    else if (is_single()) { // Article
      $category = get_the_category();

      if ($category) {
        $group_slug = $category[0]->slug;
      }
    }

    // Check if ad unit group exists otherwise use 'rest-of-site'
    $ad_unit_group = get_term_by('slug', $group_slug, 'lw_ad_unit_group');
    if ($ad_unit_group) {
      $ad_unit_group_slug = $ad_unit_group->slug;
    }
    else {
      $ad_unit_group_slug = 'rest-of-site';
    }

    $ad_units = get_posts(
      array(
        'posts_per_page' => -1,
        'post_type' => 'lw_ad_unit',
        'tax_query' => array(
          array(
            'taxonomy' => 'lw_ad_unit_group',
            'field' => 'slug',
            'terms' => $ad_unit_group_slug
          )
        )
      )
    );

    if ($ad_units) {
      // Put variable names into array
      $variables = array();

      foreach ($ad_units as $ad_unit) {
        if ($ad_unit->lw_ad_unit_variable_name != '') {
          $variables[] = $ad_unit->lw_ad_unit_variable_name;
        }
      }

      // JS Output
      ob_start();
      ?>
      <script type="text/javascript">
        var googletag = googletag || {};
        var jqueryReady = false;
        var storeAdChanges = [];
        <?php echo count($variables) != 0 ? 'var ' . implode(', ', $variables) . ';' : ''; ?>

        googletag.cmd = googletag.cmd || [];
        googletag.cmd.push(function() {
          <?php
            self::generate_ad_slots($ad_units);
            self::generate_article_targeting();
            self::generate_tags_targeting();
          ?>


          googletag.pubads().enableSingleRequest();
          googletag.pubads().addEventListener('slotRenderEnded', function(event) {
            adSticky(event);

            // Popup functionality for oop overlay
            (function($) {
              var adUnit = $('#' + event.slot.getSlotElementId());
              var adUnitContainer = adUnit.parent();

              if (!event.isEmpty && adUnitContainer.hasClass('ads-oop-overlay')) {
                $('#lw-ad-unit-popup-overlay').css({ 'display' : 'block' });
                $('#lw-ad-unit-popup-holder').css({ 'display' : 'flex' });

                $(document).keyup(function(e) {
                  if (e.which == 27) {
                    $('#lw-ad-unit-popup-overlay').css({ 'display' : 'none' });
                    $('#lw-ad-unit-popup-holder').css({ 'display' : 'none' });
                  }
                });

                $('#lw-ad-unit-popup-close').on('click', function(e) {
                  e.preventDefault();
                  $('#lw-ad-unit-popup-overlay').css({ 'display' : 'none' });
                  $('#lw-ad-unit-popup-holder').css({ 'display' : 'none' });
                });
              }
            })(jQuery);
          });
          googletag.enableServices();
        });
      </script>
      <?php
      return ob_get_clean();
    }
    else {
      return '';
    }
  }

  public static function generate_ad_slots($ad_units) {
    $output = "";
    $first = true;
    foreach ($ad_units as $ad_unit) {
      $output .= $first ? "" : str_repeat(" ", 14);
      if ($ad_unit->lw_ad_unit_variable_name != '') {
        $output .= $ad_unit->lw_ad_unit_variable_name . " = ";
      }
      $output .= "googletag.defineSlot('";
      $output .= $ad_unit->lw_ad_unit_path . "', ";
      $output .= $ad_unit->lw_ad_unit_size . ", '";
      $output .= $ad_unit->lw_ad_unit_div . "')";
      $output .= ".addService(googletag.pubads()).setCollapseEmptyDiv(true);\n";

      $first = false;
    }

    echo $output;
  }

  public static function generate_article_targeting() {
    $output = "";
    if (is_single()) {
      $id = get_the_ID();
      $output = str_repeat(" ", 14);
      $output .= "googletag.pubads().setTargeting(\"artID\", \"" . $id . "\");\n";
    }

    echo $output;
  }

  public static function generate_tags_targeting() {
    $output = "";
    if (is_single()) {
      $tags = get_the_tags();
      if ($tags) {
        $output = str_repeat(" ", 14);
        $output .= "googletag.pubads().setTargeting(\"tag\", [\"";
        $output .= implode("\", \"", array_map(function ($tag) { return $tag->name; }, $tags));
        $output .= "\"]);\n";
      }
    }
    else if (is_search()) {
      $search_term = $_GET['s'];
      if ($search_term != '') {
        $output = str_repeat(" ", 14);
        $output .= "googletag.pubads().setTargeting(\"tag\", [\"" . urldecode($search_term) . "\", \"Result\"]);\n";
      }
    }

    echo $output;
  }

  // Displays Ad Unit
  public static function last_word_ad_unit($slug, $id) {
    $output = '';
    $group_slug = 'rest-of-site';
    $full_slug = '';

    if ($id == 0) { // Homepage
      $group_slug = 'home';
    }
    else if (is_page() && get_page_template_slug($post_id) == 'template-nri.php') { // NRI Adviser on IA
      $group_slug = 'nri';
    }
    else if (is_page($id) && get_page_template_slug($id) == 'template-blog.php') { // Category
      $category_id = get_post_meta($id, 'category_page', true);
      $category = get_term_by('id', $category_id, 'category');
      if ($category) {
        $group_slug = $category->slug;
      }
    }
    else if (is_page($id) && get_page_template_slug($id) != 'template-blog.php') { // Normal Page
      $page = sanitize_post($GLOBALS['wp_the_query']->get_queried_object());
      $group_slug = $page->post_name;
    }
    else if (is_archive()) { // Category Archive
      $category_id = get_query_var('cat');
      $category = get_category($category_id);

      if ($category) {
        $group_slug = $category->slug;
      }
    }
    else if (is_single()) { // Article
      $category = get_the_category();

      if ($category) {
        $group_slug = $category[0]->slug;
      }
    }

    // Check if ad unit group exists otherwise use 'rest-of-site'
    $ad_unit_group = get_term_by('slug', $group_slug, 'lw_ad_unit_group');

    if ($ad_unit_group) {
      $ad_unit_group_slug = $ad_unit_group->slug;
    }
    else {
      $ad_unit_group_slug = 'rest-of-site';
    }


    $full_slug = $ad_unit_group_slug . '-' . $slug;

    $args = array(
      'post_type' => 'lw_ad_unit',
      'posts_per_page' => 1,
      'meta_query' => array(
        array(
          'key' => 'lw_ad_unit_slug',
          'value' => $full_slug,
          'compare' => '='
        )
      )
    );
    $query = new \WP_Query($args);

    if ($query->have_posts()) {
      $query->the_post();
      $ad_unit_div = get_post_meta(get_the_ID(), 'lw_ad_unit_div', true);

      if ($slug == 'oop-overlay') {
        $output .= '<div id="lw-ad-unit-popup-overlay"></div>';
        $output .= '<div id="lw-ad-unit-popup-holder">';
        $output .= '<div id="lw-ad-unit-popup">';
        $output .= '<a id="lw-ad-unit-popup-close" href="#">x</a>';
      }

      $output .= "<div class=\"ads-" . $slug . " ads-" . get_post_meta(get_the_ID(), 'lw_ad_unit_slug', true) . "\">\n";
      $output .= "\t<div id=\"" . $ad_unit_div . "\">\n";
      $output .= "\t\t<script type=\"text/javascript\">\n";
      $output .= "\t\t\tgoogletag.cmd.push(function() { googletag.display('" . $ad_unit_div . "'); });\n";
      $output .= "\t\t</script>\n";
      $output .= "\t</div>\n";
      $output .= "</div>\n";

      if ($slug == 'oop-overlay') {
        $output .= '</div>';
        $output .= '</div>';
      }
    }

    wp_reset_query();

    return $output;

  }


    // Displays Ad Unit
    // Improved performance in this version
    public static function last_word_ad_unit2($slug, $id) {
        $output = '';
        $group_slug = 'rest-of-site';
        $full_slug = '';

        if ($id == 0) { // Homepage
            $group_slug = 'home';
        }
        else if (is_page() && get_page_template_slug($post_id) == 'template-nri.php') { // NRI Adviser on IA
          $group_slug = 'nri';
        }
        else if (is_page($id) && get_page_template_slug($id) == 'template-blog.php') { // Category
            $category_id = get_post_meta($id, 'category_page', true);
            $category = get_term_by('id', $category_id, 'category');
            if ($category) {
                $group_slug = $category->slug;
            }
        }
        else if (is_page($id) && get_page_template_slug($id) != 'template-blog.php') { // Normal Page
            $page = sanitize_post($GLOBALS['wp_the_query']->get_queried_object());
            $group_slug = $page->post_name;
        }
        else if (is_archive()) { // Category Archive
            $category_id = get_query_var('cat');
            $category = get_category($category_id);

            if ($category) {
                $group_slug = $category->slug;
            }
        }
        else if (is_single()) { // Article
            $category = get_the_category();

            if ($category) {
                $group_slug = $category[0]->slug;
            }
        }

        // Check if ad unit group exists otherwise use 'rest-of-site'
        $ad_unit_group = get_term_by('slug', $group_slug, 'lw_ad_unit_group');

        if ($ad_unit_group) {
            $ad_unit_group_slug = $ad_unit_group->slug;
        }
        else {
            $ad_unit_group_slug = 'rest-of-site';
        }


        $full_slug = $ad_unit_group_slug . '-' . $slug;

        $args = array(
            'post_type' => 'lw_ad_unit',
            'posts_per_page' => 1,
            'meta_query' => array(
                array(
                    'key' => 'lw_ad_unit_slug',
                    'value' => $full_slug,
                    'compare' => '='
                )
            )
        );
        $query = new \WP_Query($args);

        if ($query->have_posts()) {
            $query->the_post();
            $ad_unit_div = get_post_meta(get_the_ID(), 'lw_ad_unit_div', true);

            if ($slug == 'oop-overlay') {
              $output .= '<div id="lw-ad-unit-popup-overlay"></div>';
              $output .= '<div id="lw-ad-unit-popup-holder">';
              $output .= '<div id="lw-ad-unit-popup">';
              $output .= '<a id="lw-ad-unit-popup-close" href="#">x</a>';
            }

            $output .= "<div class=\"ads-" . $slug . " ads-" . get_post_meta(get_the_ID(), 'lw_ad_unit_slug', true) . "\">\n";
            $output .= "\t<div id=\"" . $ad_unit_div . "\">\n";

            $output.=<<<A3
      <script type="text/javascript">
        jQuery(document).ready (function () {
            window.setTimeout ( function () {
                googletag.cmd.push(function() { googletag.display("$ad_unit_div"); });
            }, 150);
        });
      </script>
A3;

            $output .= "\t</div>\n";
            $output .= "</div>\n";

            if ($slug == 'oop-overlay') {
              $output .= '</div>';
              $output .= '</div>';
            }
        }

        wp_reset_query();

        return $output;

    }
}
