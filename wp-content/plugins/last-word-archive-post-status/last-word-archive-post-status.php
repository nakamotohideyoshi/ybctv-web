<?php
/*
Plugin Name: Last Word Archive Post Status
Plugin URI: http://www.ybc.tv
Description: Adds a Post Status of Archive
Author: yBC
Version: 1.0
Author URI: http://www.ybc.tv
*/

class last_word_post_status {
  function __construct() {
    add_action('init', array($this, 'add_archive_post_status'));
    add_action('post_submitbox_misc_actions', array($this, 'append_archive_post_status_list'));
  }

  // Add a post status of Archive
  function add_archive_post_status() {
  	register_post_status('archive', array(
  		'label' => 'Archive',
  		'public' => false,
  		'exclude_from_search' => false,
  		'show_in_admin_all_list' => false,
  		'show_in_admin_status_list' => true,
  		'label_count' => _n_noop('Archived <span class="count">(%s)</span>', 'Archived <span class="count">(%s)</span>')
  	));
  }

  // Add to list of available post status options in post edit
  function append_archive_post_status_list() {
  	global $post;
  	?>
  	<script>
    	jQuery(document).ready(function($){
  			var postStatus = '<?php echo $post->post_status; ?>';
  	  	$('select#post_status').append("<option value=\"archive\" <?php selected('archive', $post->post_status); ?>>Archive</option>");

  			if (postStatus == 'archive') {
  				$('#publish').val('Update');
  				$('#publish').attr('name', 'save');
  				$('#original_publish').val('Update');
  				$('#post-status-display').text('Archive');
  			}

  			$(document).on('click', '.save-post-status', function() {
  				if ($('#post_status').val() == 'archive') {
  					$('#publish').val('Update');
  					$('#publish').attr('name', 'save');
  					$('#original_publish').val('Update');
  				}
  			});
  	   });
  	 </script>
  	 <?php
  }
}

$last_word_post_status = new last_word_post_status();
