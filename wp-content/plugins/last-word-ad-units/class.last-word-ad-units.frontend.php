<?php namespace last_word_ad_units;

class frontend {
  function __construct() {
    add_action('wp_enqueue_scripts', array($this, 'enqueue_google_tag_services'));
    add_action('script_loader_tag', array($this, 'add_async_attribute'), 10, 2);
  }

  // Google Tag Services JS.
  function enqueue_google_tag_services() {
    wp_register_script('google-tag-services', 'https://www.googletagservices.com/tag/js/gpt.js', array(), null, false);
    wp_enqueue_script('google-tag-services');
  }

  function add_async_attribute($tag, $handle) {
    if ('google-tag-services' !== $handle) {
      return $tag;
    }

    return str_replace(' src', ' async="async" src', $tag);
  }

  // Add required JS for Ad Units
  public static function last_word_ad_unit_initialize($post_id) {
    $group_slug = '';

    if ($post_id == 0) { // Homepage
      $group_slug = 'home';
    }
    else if (is_page() && get_page_template_slug($post_id) == 'template-blog.php') { // Category Page
      $category_id = get_post_meta($post_id, 'category_page', true);
      $category = get_term_by('id', $category_id, 'category');
      $group_slug = $category->slug;
    }

    if ($group_slug != '') {
      $ad_unit_group = get_term_by('slug', $group_slug, 'lw_ad_unit_group');

      if ($ad_unit_group) {
        $ad_units = get_posts(
          array(
            'posts_per_page' => -1,
            'post_type' => 'lw_ad_unit',
            'tax_query' => array(
              array(
                'taxonomy' => 'lw_ad_unit_group',
                'field' => 'slug',
                'terms' => $ad_unit_group->slug
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
              <?php self::generate_ad_slots($ad_units); ?>
              googletag.pubads().enableSingleRequest();
              googletag.pubads().addEventListener('slotRenderEnded', function(event) {
                if(jqueryReady) {
                  updateAds(event);
                } else {
                  storeAdChanges.push(event);
                }
              });
              googletag.enableServices();
            });
          </script>
          <?php
          return ob_get_clean();
        }
      }
      else {
        return '';
      }
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

  // Displays Ad Unit
  public static function last_word_ad_unit($slug, $id) {
    $output = '';
    $full_slug = '';

    if ($id == 0) { // Homepage
      $full_slug = 'home-' . $slug;
    }
    else if (is_page($id) && get_page_template_slug($id) == 'template-blog.php') { // Category
      $category_id = get_post_meta($id, 'category_page', true);
      $category = get_term_by('id', $category_id, 'category');
      $full_slug = $category->slug . '-' . $slug;
    }

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
      $output .= "<div class=\"ads-" . $slug . " ads-" . get_post_meta(get_the_ID(), 'lw_ad_unit_slug', true) . "\">\n";
      $output .= "\t<div id=\"" . $ad_unit_div . "\">\n";
      $output .= "\t\t<script type=\"text/javascript\">\n";
      $output .= "\t\t\tgoogletag.cmd.push(function() { googletag.display('" . $ad_unit_div . "'); });\n";
      $output .= "\t\t</script>\n";
      $output .= "\t</div>\n";
      $output .= "</div>\n";
    }

    wp_reset_query();

    return $output;

  }
}
