<?php
/**
 * Add ajaxurl
 */
add_action( 'wp_enqueue_scripts', 'latword_enqueue_script' );
 
function latword_enqueue_script(){
    $localize = array('ajaxurl'=> admin_url().'admin-ajax.php');
    wp_localize_script('jquery','lastword',$localize);
}

/**
 * Hook profile update, and send updated to CRM via API
 */
add_action( 'profile_update', 'process_member_update', 10, 2 );

function process_member_update( $user_id, $old_user_data ) {
	
	$user = get_user_by( 'ID', $user_id );
	
	if( $user ){
		
		$company_name = get_user_meta( $user_id, '_company_name', true );
		$job_title = get_user_meta( $user_id, '_job_title', true );
		$country = get_user_meta( $user_id, '_country', true );
		$direct_line = get_user_meta( $user_id, '_direct_line', true );
		$description = get_user_meta( $user_id, '_description', true );
		
		$args=array(
			'asl_transactiontype' => 'Update',
			'asl_websiteuid' => $user->id,
			'asl_firstname' => $user->first_name,
			'asl_lastname' =>  $user->last_name,
			'asl_telephone1' => $direct_line
		);
		$result = dynamic365_create_contact($args);

		// if( $result ) echo "updated"; else echo "failed";
	}
}

/**
 * ajax update user profile
 */
add_action( 'wp_ajax_update_user_profile', 'update_user_profile' );
add_action( 'wp_ajax_nopriv_update_user_profile', 'update_user_profile' );
 
function update_user_profile(){
     if ( isset($_REQUEST) ){//&& wp_verify_nonce( $_POST['wp_nonce'], 'update_key_interest' )  ) {
       	
       	$contactId = $_REQUEST['contact_id'];
     	$user_id = $_REQUEST['user_id'];
     	$first_name = $_REQUEST['first_name'];
     	$last_name = $_REQUEST['last_name'];
     	$telephone = $_REQUEST['telephone'];
       	$fullname = $first_name.' '.$last_name;
       
		$args=array(
				'asl_transactiontype' => 'Update',
				'asl_websiteuid' => $_REQUEST['user_id'],
				'asl_firstname' => $_REQUEST['first_name'],
				'asl_lastname' => $_REQUEST['last_name'],
				'asl_telephone1' => $_REQUEST['telephone']
			);
		$result = dynamic365_create_contact($args);

		$iemi = 'FB218BCE-8985-E711-80FA-00155DD1690D';
 
		$addiemi=array(
			'asl_transactiontype' => 'Additional',
			'asl_websiteuid' => $user_id,
			'asl_product' => $iemi,
			'asl_source1' => '860000006',
			'asl_purchasesource1' => '860000003',
			'asl_startdate' => strtotime(date("Y-m-d H:i:s")),
			'asl_purchasedate' => strtotime(date("Y-m-d H:i:s"))
		);

		if (isset($_POST['lw_product_ei_market_intelligence'])) {
	 		$result2 = dynamic365_create_contact($addiemi);
		}

		if( $result ) echo "updated"; else echo "failed";
		if( $result2 ) echo "updated 2"; else echo "failed";

		$user_data = wp_update_user( 
			array( 
				'ID' => $user_id,
				'first_name' => $first_name,
				'last_name' => $last_name,
				'display_name' => trim($fullname)
			) 
		);

		$userid = wp_update_user( $userdata ) ;
 
		update_user_meta( $user_id, '_direct_line', $direct_line);

        die();
    }
}

/**
 * Ajax update key interest
 */
/*add_action( 'wp_ajax_update_key_interest', 'update_key_interest' );
add_action( 'wp_ajax_nopriv_update_key_interest', 'update_key_interest' );
 
function update_key_interest(){
    if ( isset($_REQUEST) ){//&& wp_verify_nonce( $_POST['wp_nonce'], 'update_key_interest' )  ) {
        $curr_val = $_REQUEST['curr_val'];
		$contactId = $_REQUEST['contactId'];
		$new_status = $curr_val ? 0 : 1;
		$response['new_status']=$curr_val;
		echo json_encode($response);
         
        die();
    }
}*/

/**
 * Ajax update your subscriptions
 */
/*add_action( 'wp_ajax_update_your_subscription', 'update_your_subscription' );
add_action( 'wp_ajax_nopriv_update_your_subscription', 'update_your_subscription' );
 
function update_your_subscription(){
    if ( isset($_REQUEST) ){//&& wp_verify_nonce( $_POST['wp_nonce'], 'update_key_interest' )  ) {
        $curr_val = $_REQUEST['curr_val'];
		$contactId = $_REQUEST['contactId'];
		$new_status = $curr_val=="true" ? 0 : 1;
		$response['new_status']=$new_status;
		echo json_encode($response);
         
        die();
    }
}*/

/**
 * Ajax update your activity
 */
add_action( 'wp_ajax_update_your_activity', 'update_your_activity2' );
add_action( 'wp_ajax_nopriv_update_your_activity', 'update_your_activity2' );
 
function update_your_activity2(){
	global $wpdb;
	
    if ( isset($_REQUEST) ){//&& wp_verify_nonce( $_POST['wp_nonce'], 'update_key_interest' )  ) { 
        $timeSpent = $_REQUEST['timeSpent'];
		$timeSpent = floor($timeSpent);
		$view_page = 1;
		$current_user = wp_get_current_user();	
		$modified_date = current_time('mysql');
		$ip = $_SERVER['REMOTE_ADDR'];
		$uactid = $_REQUEST['uactid'];
		$activityId = $_REQUEST['activityid'];
		if( is_user_logged_in() ){
			
			$url = $_REQUEST['url']; 			
			$post_id = url_to_postid($url);
			$post = get_post($post_id);
			$action ='Visit a page';
			$anchor =$url;
			$obj_type = "user";
			// echo "post id" . get_site_url();
			
			if( $url == get_site_url() ){
				// $action = 'Visit a page \"Homepage\"';
				$action ='Visit a';
				$anchor = 'Homepage';
				$obj_type = "homepage";
				
			}else if($post->post_type=='post' || $post->post_type=='page'){				
				$title = $post->post_title;				
				// $action = 'Visit a page \"'.$title.'\"';
				$anchor = $title;
				$obj_type = "page";
			}
			// else if(is_archive()){
				// $title = 'archive';
				//// $action = 'Visit a page \"'.$title.'\"';
				// $anchor = $title;
				// $obj_type = "archive";
			// }
			
			$user_mail = $current_user->user_email;
			$current_user_id = $current_user->ID;
			$user = new WP_User($current_user_id);
			if (!empty($user->roles) && is_array($user->roles)) {
				foreach ($user->roles as $role)
					$user_role = $role;
			} else{
				$user_role="";
			}
			
			if (isset($post_id)){
				
				$table_name = $wpdb->prefix . "ualp_user_activity";
				$select_query = "SELECT * from $table_name where post_id='$post_id' and user_id='$current_user_id'";
				$get_data = $wpdb->get_results($select_query);
				
				if (isset($get_data)){
					
					foreach ($get_data as $data) {
						
						$view_page = $data->view_page + 1;
					}
				}
			}
			
			$post_title = $anchor;
			// $post_title = "<a href='{$url}'>{$anchor}</a>";
			$current_user_display_name = $current_user->display_name;
			
			if(function_exists('ual_user_activity_add') ){
				$table_name = $wpdb->prefix . "ualp_user_activity";
				if( ! $uactid ){ //if not exists, create
					ual_user_activity_add($post_id, $post_title, $obj_type, $current_user_id, $current_user_display_name, $user_role, $user_mail, $modified_date, $ip, $action, $timeSpent, $view_page);
					$uactid = $wpdb->get_var( "SELECT max(uactid) FROM $table_name WHERE user_id = '{$current_user_id}'" );
					$contenttype = get_post_meta( $post_id, 'lw_content_type', true );
					$sitename = get_bloginfo('name');
					$blog_id = get_current_blog_id();
					$posttype = get_post_type( $post_id );
					$categories = get_the_category($post_id);
					$contenttags = '';
					$posttags = get_the_tags($post_id);
						if ($posttags) {
						  foreach($posttags as $tag) {
						    $contenttags .= $tag->name . ', '; 
						  }
						}
					$postcategory = $categories[0]->name;
					$pagepath = get_post_permalink($post_id);
					$pagetitle = get_the_title($post_id);

					if (is_null($contentype)) {
						$contenttype = 'News';
					}

					if (is_null($timeSpent) || $timeSpent == 0 || $timeSpent == '') {
						$timeSpent = rand(5, 600);
					}

					//send data to crm
					$contactId = get_user_meta( $current_user_id, '_contactId', true );
					$args=array(
						'asl_websiteuid' => $current_user_id,
						'asl_duration' => $timeSpent,
						'asl_pagedescription' => $pagetitle,
						'asl_pagemeta' => $pagetitle,
						'asl_contenttype' => $contenttype,
						'asl_tags' => $contenttags,
						'asl_contentcategory' => $postcategory,
						'asl_site' => $blog_id,
						'asl_pageref' => $post_id,
						'asl_pagepath' => $pagepath,
						'asl_date' => strtotime(date("Y-m-d H:i:s")),
					);

					if ($posttype == 'post') {
						if ( is_user_logged_in() ) {
						    $activityId = dynamic365_create_web_activity($args);
						} else {
						    //
						}
					}
					
				}else{ // if exists, update
					$wpdb->update( $table_name, array( 'timespent'=>$timeSpent ), array( 'uactid' => $uactid, 'user_id' => $current_user_id ) );
					
					//send data to crm
					$uactid = $wpdb->get_var( "SELECT max(uactid) FROM $table_name WHERE user_id = '{$current_user_id}'" );
					$contenttype = get_post_meta( $post_id, 'lw_content_type', true );
					$sitename = get_bloginfo('name');
					$blog_id = get_current_blog_id();
					$categories = get_the_category($post_id);
					$posttype = get_post_type( $post_id );
					$postcategory = $categories[0]->name;
					$contenttags = '';
					$posttags = get_the_tags($post_id);
						if ($posttags) {
						  foreach($posttags as $tag) {
						    $contenttags .= $tag->name . ', '; 
						  }
						}
					$pagepath = get_post_permalink($post_id);
					$pagetitle = get_the_title($post_id);

					if (is_null($contentype)) {
						$contenttype = 'News';
					}

					if (is_null($timeSpent) || $timeSpent == 0 || $timeSpent == '') {
						$timeSpent = rand(5, 600);
					}
					//send data to crm
					$contactId = get_user_meta( $current_user_id, '_contactId', true );
					$args=array(						
						'asl_websiteuid' => $current_user_id,
						'asl_duration' => $timeSpent,
						'asl_pagedescription' => $pagetitle,
						'asl_pagemeta' => $pagetitle,
						'asl_contenttype' => $contenttype,
						'asl_contentcategory' => $postcategory,
						'asl_site' => $blog_id,
						'asl_tags' => $contenttags,
						'asl_pageref' => $post_id,
						'asl_pagepath' => $pagepath,
						'asl_date' => strtotime(date("Y-m-d H:i:s")),
					);

					if ($posttype == 'post') {
						if ( is_user_logged_in() ) {
						    $activityId = dynamic365_create_web_activity($args);
						} else {
						    //
						}
					}					
				}
			}
		}
		
		$response['uactid']=$uactid;
		$response['activityid']=$activityId;
		echo json_encode($response);
         
        die();
    }
}

/**
 * Ajax update your subscriptions
 */
/*add_action( 'wp_ajax_save_post_article', 'save_post_article' );
add_action( 'wp_ajax_nopriv_save_post_article', 'save_post_article' );
 
function save_post_article(){
    if ( isset($_REQUEST) ){//&& wp_verify_nonce( $_POST['wp_nonce'], 'update_key_interest' )  ) {
		
		$user_id = get_current_user_id();
		$saved_articles = get_user_meta( $user_id, '_saved_articles', true );
        $post_id = $_REQUEST['post_id'];                    
		$saved = $_REQUEST['saved'];
		$saved_articles['id_'.$post_id] = $saved=="true" ? false : true;
		$new_status = $saved_articles['id_'.$post_id];
		$response['new_status']=$new_status;
		
		update_user_meta( $user_id, '_saved_articles', $saved_articles );
		
		echo json_encode($response);
         
        die();
    }
}*/

/**
 * Ajax update your Cookie
 */
/*add_action( 'wp_ajax_update_your_cookie', 'update_your_cookie' );
add_action( 'wp_ajax_nopriv_update_your_cookie', 'update_your_cookie' );*/
 
function update_your_cookie(){
	global $wpdb, $post;
    if ( isset($_REQUEST) ){
		
		$url = $_REQUEST['url']; 
		$uniqueid = $_REQUEST['uniqueid'];
		$mode = $_REQUEST['mode'];
		$timeSpent = $_REQUEST['timeSpent'];
		$timeSpent = floor($timeSpent);
		$view_page = 1;
		$current_user = wp_get_current_user();	
		$modified_date = current_time('mysql');
		$ip = $_SERVER['REMOTE_ADDR'];
		
		$post_id = url_to_postid($url);
		$post = get_post($post_id);
		$action ='Visit a page';
		// $anchor =$url;
		$obj_type = "user";
			
		if( $url == get_site_url() ){
			// $action = 'Visit a page \"Homepage\"';
			$action ='Visit a';
			$anchor = 'Homepage';
			$obj_type = "homepage";
			
		}else if($post->post_type=='post' || $post->post_type=='page'){				
			$title = $post->post_title;				
			// $action = 'Visit a page \"'.$title.'\"';
			$anchor = $title;
			$obj_type = "page";
		}
		$post_title = $anchor;
		
		$url_with_anhor = "<a href='{$url}'>{$anchor}</a>";
		
		if($uniqueid ){
			
			if(!isset($_COOKIE['lastwordmedia']) || empty($_COOKIE['lastwordmedia'])){
				
				if($mode == 'create'){
					
					$arr=array();
					
					$arr[] = array(
						'uniqueid' => $uniqueid,
						'post_id' => $post_id,
						'post_title' => $post_title,
						'obj_type' => $obj_type,
						'post_id' => $post_id,
						'time'=> $modified_date,
						'url'=> $url_with_anhor,
						'deskripsi'=> $action,
						'timespent'=> $timespent,
						'view_page'=> $view_page
						);
					
					$cookie_value = base64_encode(serialize($arr));
				
					ob_start();
					
					?>
					<script>					
						document.cookie = 'lastwordmedia=<?php echo $cookie_value;  ?>; path=/; expires=0';
					</script>
					<?php	
					
					$html = ob_get_clean();
				}
				else{
					
					
				}
				
			} else{
				
				// $cookie = stripslashes($_COOKIE['lastwordmedia']);
				$cookie = ($_COOKIE['lastwordmedia']);
				$arr_cookie = unserialize(base64_decode($cookie));
				
				if($mode == 'create'){
					
					$arr2=array();
					
					$arr2[] = array(
						'uniqueid' => $uniqueid,
						'post_id' => $post_id,
						'post_title' => $post_title,
						'obj_type' => $obj_type,
						'post_id' => $post_id,
						'time'=> $modified_date,
						'url'=> $url_with_anhor,
						'deskripsi'=> $action,
						'timespent'=> $timespent,
						'view_page'=> $view_page
						);
					
					if( is_array( $arr_cookie ) ){
						$array = array_merge($arr_cookie, $arr2);
					}else{
						$array = $arr2;
					}
					
					// echo "<pre>"; print_r( $array ); echo "</pre>";
					$cookie_value = base64_encode( serialize($array) );
					
					ob_start();
					?>
					<script>
						document.cookie = 'lastwordmedia=<?php echo $cookie_value;  ?>; path=/; expires=0';
					</script>
					<?php
					$html = ob_get_clean();
				}
				else{
					
					foreach($arr_cookie as $arr_co => $val){
						
						print_r($arr_co);
						// $idx = $arr_co['uniqueid'];
						// if ($idx == $uniqueid){
							// echo $arr_co['post_title'];
							 // $arr_co['timespent'] = "test";
						// echo "true";
						// }
					}
				}
			}
		}
		$response['html']=$html;
		$response['uniqueid']=$uniqueid;
		echo json_encode($response);
         
        die();
	}
}

/*add_action('wp_footer', 'lastword_save_article');

function lastword_save_article(){
	if( is_single() ){
	?>
		<script>	

			jQuery(".save-article").on( 'click', function(e){// when a div is clicked my form cames to the interface  
				var curr_element = jQuery(this);
				var saved = curr_element.attr('saved');
				var post_id = curr_element.attr('post-id');
				
				var data = {
					action: 'save_post_article',
					'post_id': post_id,                    
					'saved': saved,                    
				};
				// alert(curr_val);
				if(saved=='true'){			
					curr_element.html('Save for later');
					curr_element.attr('saved', "false");
				}else{			
					curr_element.html('Unsave this post');
					curr_element.attr('saved', "true");
				}
				
				jQuery.ajax({
					  type: "POST",
					  url: lastword.ajaxurl,
					  timeout: 30000,
					  data : data,
					  cache: false,
					  error: function(){
						   alert('server not responding');
						},
						success: function( response ) {
							var data = jQuery.parseJSON(response);
							if(data.new_status){
							}else{
							}
						}
				});
				
				e.preventDefault();
			});

		</script>
	<?php
	}
} */

function ual_user_visit_activity2() {
	global $post, $wpdb, $current_user, $wp_query;
	
	$current_user = wp_get_current_user();		
	if( is_user_logged_in() && !is_admin()){			
		$url = home_url(add_query_arg(array()));			
		?>
		<script>
			jQuery(document).ready(function(){					
				var time, curr_uactid, curr_activityId;
				time = new Date();
				curr_uactid = 0;
				curr_activityId = 0;
				// jQuery(window).on('beforeunload', function(){
				save_user_journey(time); //first run					
				/*setInterval(function() {							
					save_user_journey(time, curr_uactid, curr_activityId);
				}, 1000 * 60 * 60); // where X is your every X minutes*/
					
				
				function save_user_journey(start, uactid, activityId){
					var end = new Date();
					// var timeSite = end - start;	
					var timeSite = (end- start)/1000;
					var data = {
						action: 'update_your_activity',
						'url': '<?php echo $url ?>',
						'timeSpent': timeSite,
						'uactid' : uactid,
						'activityid' : activityId,
					};
					
					jQuery.ajax({
						type: "POST",
						url: lastword.ajaxurl,
						data : data,
						cache: false,
						error: function(){
							// alert('server not responding!');
						},
						success: function( response ) {
							var data = jQuery.parseJSON(response);
							if(data.uactid){
								curr_uactid = data.uactid;
								curr_activityId = data.activityid;
							}
						}
					});
				}
			});				
		</script>
		<?php		
	}
}

add_action('wp_head', 'ual_user_visit_activity2');

/*function lw_save_user_meta($user_id) {

	$iemi = 'FB218BCE-8985-E711-80FA-00155DD1690D';
 
	$addiemi=array(
		'asl_transactiontype' => 'Additional',
		'asl_websiteuid' => $user_id,
		'asl_product' => $iemi,
		'asl_source1' => '860000006',
		'asl_purchasesource1' => '860000003',
		'asl_startdate' => strtotime(date("Y-m-d H:i:s")),
		'asl_purchasedate' => strtotime(date("Y-m-d H:i:s"))
	);

	$deliemi=array(
		'asl_transactiontype' => 'Delete',
		'asl_websiteuid' => $user_id,
		'asl_product' => $iemi
	);

	$intel = get_user_meta($user_id, 'lw_product_ei_market_intelligence', true);

	
	if (isset($_POST['lw_product_ei_market_intelligence'])) {
		if ($intel != '1') {
			dynamic365_create_contact($addiemi);
		} else {
			dynamic365_create_contact($deliemi);
		}
	}
}

add_action( 'profile_update', 'lw_save_user_meta');*/

/*function user_profile_sync($user) {

	$user_id = $user->ID;

	//dynamic365_check_productconnection($user_id);
	dynamic365_sync_crm_contact($user_id);
}

add_action( 'profile_personal_options', 'user_profile_sync');
add_action( 'show_user_profile', 'user_profile_sync', 10, 1);*/

/*function user_profile_logged_sync() {
	if ( is_user_logged_in() ) {
		$user_id = get_current_user_id();
		dynamic365_sync_crm_contact($user_id);
	}
}

add_action('wp_head', 'user_profile_logged_sync');