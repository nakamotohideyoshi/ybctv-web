<?php
/*
Plugin Name: Last Word 404
Plugin URI: http://www.ybc.tv
Description: Redirect pages on 404
Author: yBC
Version: 1.0
Author URI: http://www.ybc.tv
*/

function last_word_redirect_404() {
  if (http_response_code() == 404) {
    $request = $_SERVER['REQUEST_URI'];
    preg_match('/\d+/', $request, $match);

    if ($match) {
      $args = array(
        'post_type' => 'post',
        'meta_key' => 'lw_old_article_id',
        'meta_value' => $match[0],
        'posts_per_page' => 1
      );
      $new_post = get_posts($args);
      if ($new_post) {
        $new_permalink = get_permalink($new_post[0]->ID);

        header("HTTP/1.1 301 Moved Permanently");
        header("Location: " . $new_permalink);
        exit();
      }
    }
    else {
      $slug = basename(parse_url($request, PHP_URL_PATH));
      if (strpos($request, 'static/')) {
        $args = array(
          'post_type' => 'page',
          'name' => $slug,
          'posts_per_page' => 1
        );
        $new_page = get_posts($args);

        if ($new_page) {
          $new_permalink = get_permalink($new_post[0]->ID);

          header("HTTP/1.1 301 Moved Permanently");
          header("Location: " . $new_permalink);
          exit();
        }
        else {
          check_special_case_url($slug);
        }
      }
      else {
        $args = array(
          'post_type' => 'post',
          'name' => $slug,
          'posts_per_page' => 1
        );
        $new_post = get_posts($args);

        if ($new_post) {
          $new_permalink = get_permalink($new_post[0]->ID);

          header("HTTP/1.1 301 Moved Permanently");
          header("Location: " . $new_permalink);
          exit();
        }
        else {
          check_special_case_url($slug);
        }
      }
    }
  }
}

function check_special_case_url($slug) {
  switch ($slug) {
    case 'acceptable-policy' :
      header("HTTP/1.1 301 Moved Permanently");
      header("Location: " . '/acceptable-use-policy');
      exit();
      break;
    case 'event_list' :
      header("HTTP/1.1 301 Moved Permanently");
      header("Location: " . '/events');
      exit();
      break;
    case 'login_page' :
      header("HTTP/1.1 301 Moved Permanently");
      header("Location: " . '/');
      exit();
      break;
    case 'magazine' :
      header("HTTP/1.1 301 Moved Permanently");
      header("Location: " . '/magazines');
      exit();
      break;
    case 'terms-conditions' :
      header("HTTP/1.1 301 Moved Permanently");
      header("Location: " . '/terms-and-conditions');
      exit();
      break;
    case 'research-centre' :
      header("HTTP/1.1 301 Moved Permanently");
      header("Location: " . '/fund-research-centre');
      exit();
    case 'about-eie' :
      header("HTTP/1.1 301 Moved Permanently");
      header("Location: " . '/about-ei');
      exit();
    case 'expert-investor-europe-editorial-panel' :
      header("HTTP/1.1 301 Moved Permanently");
      header("Location: " . '/editorial-panel');
      exit();
      break;
  }
}
