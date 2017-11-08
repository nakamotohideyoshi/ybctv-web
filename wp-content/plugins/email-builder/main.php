<?php
/*
Plugin Name: Email Builder
Plugin URI: http://codebasehq.com
Description: This is an email builder plugin.
Author: Simon Smith
Version: 0.1
Author URI: http://codebasehq.com
Network: True
*/
class EmailBuilder {
	public $plugin_domain;
	public $views_dir;
	public $version;

	public function __construct() {
		$this->plugin_domain = 'email-builder';
		$this->views_dir     = trailingslashit( dirname( __FILE__ ) ) . 'server/views';
		$this->version       = '1.0';
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'rest_api_init', array( $this, 'wpshout_register_routes' ) );
	}
	
	public function wpshout_register_routes() {
	register_rest_route( 
        'email-builder/v1',
        '/emails',
        array(
            'methods' => 'GET',
            'callback' => function ($params ){
				global $wpdb;
				$table_name = 'wp_2_email_builder_emails';
				$no_rows = $wpdb->get_var("SELECT count(*) FROM ".$table_name."");
				$emails = $wpdb->get_results("SELECT EmailId, EmailName, EmailSubject, SendToAdestraOn, EditorId, EditorDisplayName, CreatedAt, UpdatedAt FROM ".$table_name." WHERE  Site = '".$params['prefix']."' ORDER BY EmailId DESC  LIMIT 20 OFFSET ".$params['offset']."");
				if ($wpdb->last_error) {
  					$response = new WP_REST_Response( $wpdb->last_error );
					return $response;
				}	
				foreach($emails as $email){ 
					$email->isSelected = false;					
				}	
			    return (object)array($emails, $no_rows);
			  }
        )
     );
	 register_rest_route( 
        'email-builder/v1',
        '/deleteemails',
        array(
            'methods' => 'POST',
            'callback' => function ($data ){
				$json_result = json_decode($data->get_body(), true);
				$emails = $json_result["emails"];
				
				global $wpdb;
				$table_name = 'wp_2_email_builder_emails';
				$wpdb->query( "DELETE FROM ".$table_name." WHERE EmailId IN($emails)" );
				if ($wpdb->last_error) {
  					$response = new WP_REST_Response( $wpdb->last_error );
					return $response;
				}
			
				return true;
			  }
        )
     );
	 register_rest_route( 
        'email-builder/v1',
        '/emails',
        array(
            'methods' => 'POST',
            'callback' => function ($data ){
            	$json_result = json_decode($data->get_body(), true);
				$email_name = $json_result["name"];
				$email_subject = $json_result["subject"];
				$email_articles = $json_result["articles"];
				$event_articles = $json_result["eventArticles"];
				$editor_articles = $json_result["editorArticles"];
				$mostviewed_articles = $json_result["mostViewedArticles"];
				$mostread_articles = $json_result["mostReadArticles"];
				$investment_articles = $json_result["investmentArticles"];
				$morenews_articles = $json_result["moreNewsArticles"];
				$template_name = $json_result["template"];
				$email_content = $json_result['content'];
				$has_topleaderboard = $json_result['hasTopLeaderboard'];
				$has_footerleaderboard = $json_result['hasFooterLeaderboard'];
				$has_newslettersubscribe = $json_result['hasNewsletterSubscribe'];
				$has_sponseredcontent = $json_result['hasSponsoredContent'];
				$has_sponseredcontent2 = $json_result['hasSponsoredContent2'];
				$has_staticimage1 = $json_result['hasStaticImage1'];
				$has_staticimage2 = $json_result['hasStaticImage2'];
				$has_assetclass = $json_result['hasAssetClass'];
				$has_quotable = $json_result['hasQuotable'];
				$site = $json_result['prefix'];

				$editor_id = isset($json_result['editor_id']) ? $json_result['editor_id'] : 0;
				$editor_display_name = isset($json_result['editor_display_name']) ? $json_result['editor_display_name'] : '';
				
				global $wpdb;
				$table_name = 'wp_2_email_builder_emails';
				$wpdb->get_results("SELECT * FROM ".$table_name." WHERE EmailName = '".$email_name."'");
				if ($wpdb->last_error) {
  					$response = new WP_REST_Response( $wpdb->last_error );
					return $response;
				}
				if($wpdb->num_rows > 0) {
					 $error = new WP_Error;
					 $error->add( "500", "Email with same name already exists." );
					 return $error;
				}
				
				$wpdb->insert( 
					$table_name, 
					$arr = array( 
						'EmailName' => $email_name,
						'EmailSubject' => $email_subject, 
						'Articles' => $email_articles,
						'EventArticles' => $event_articles,
						'EditorArticles' => $editor_articles,
						'MostViewedArticles' => $mostviewed_articles,
						'MostReadArticles' => $mostread_articles,
						'InvestmentArticles' => $investment_articles,
						'MoreNewsArticles' => $morenews_articles,
						'TemplateName' => $template_name,
						'Content' => $email_content,
						'HasTopLeaderboard' => $has_topleaderboard,
						'HasFooterLeaderboard' => $has_footerleaderboard,
						'HasNewsletterSubscribe' => $has_newslettersubscribe,
						'HasSponseredContent' => $has_sponseredcontent,
						'HasSponseredContent2' => $has_sponseredcontent2,
						'HasStaticImage1' => $has_staticimage1,
						'HasStaticImage2' => $has_staticimage2,
						'HasAssetClass' => $has_assetclass,
						'HasQuotable' => $has_quotable,
						'Site' => $site,
						'EditorId' => $editor_id,
						'EditorDisplayName' => $editor_display_name,
						'CreatedAt' => gmdate('Y-m-d H:i:s'),
						'UpdatedAt' => gmdate('Y-m-d H:i:s')
					)
				);	

				if ($wpdb->last_error) {
  					$response = new WP_REST_Response( $wpdb->last_error );
					return $response;
				}
				
                $response = new WP_REST_Response( $json_result["name"] );
				
				return $wpdb->insert_id;
			  }
        )
     );
	 register_rest_route( 
        'email-builder/v1',
        '/email',
        array(
            'methods' => 'POST',
            'callback' => function ($data ){
            	$json_result = json_decode($data->get_body(), true);
				$email_id = $json_result["emailId"];
				$email_articles = $json_result["articles"];
				$event_articles = $json_result["eventArticles"];
				$editor_articles = $json_result["editorArticles"];
				$mostviewed_articles = $json_result["mostViewedArticles"];
				$mostread_articles = $json_result["mostReadArticles"];
				$morenews_articles = $json_result["moreNewsArticles"];
				$investment_articles = $json_result["investmentArticles"];
				$template_name = $json_result["template"];
				$email_content = $json_result['content'];
				$has_topleaderboard = $json_result['hasTopLeaderboard'];
				$has_footerleaderboard = $json_result['hasFooterLeaderboard'];
				$has_newslettersubscribe = $json_result['hasNewsletterSubscribe'];
				$has_sponseredcontent = $json_result['hasSponsoredContent'];
				$has_sponseredcontent2 = $json_result['hasSponsoredContent2'];
				$has_staticimage1 = $json_result['hasStaticImage1'];
				$has_staticimage2 = $json_result['hasStaticImage2'];
				$has_assetclass = $json_result['hasAssetClass'];
				$has_quotable = $json_result['hasQuotable'];
				$site = $json_result['prefix'];

				$editor_id = isset($json_result['editor_id']) ? $json_result['editor_id'] : 0;
				$editor_display_name = isset($json_result['editor_display_name']) ? $json_result['editor_display_name'] : '';
				
				global $wpdb;
				$table_name = 'wp_2_email_builder_emails';
				$wpdb->get_results("SELECT * FROM ".$table_name." WHERE EmailId = ".$email_id."");
				if ($wpdb->last_error) {
  					$response = new WP_REST_Response( $wpdb->last_error );
					return $response;
				}
				if($wpdb->num_rows == 0) {
					 $error = new WP_Error;
					 $error->add( "500", "Email does not exist." );
					 return $error;
				}
				
				$wpdb->update( 
					$table_name, 
					array( 
						'Articles' => $email_articles,
						'EventArticles' => $event_articles,
						'EditorArticles' => $editor_articles,
						'MostViewedArticles' => $mostviewed_articles,
						'MostReadArticles' => $mostread_articles,
						'MoreNewsArticles' => $morenews_articles,
						'InvestmentArticles' => $investment_articles,
						'TemplateName' => $template_name,
						'Content' => $email_content,
						'HasTopLeaderboard' => $has_topleaderboard,
						'HasFooterLeaderboard' => $has_footerleaderboard,
						'HasNewsletterSubscribe' => $has_newslettersubscribe,
						'HasSponseredContent' => $has_sponseredcontent,
						'HasSponseredContent2' => $has_sponseredcontent2,
						'HasStaticImage1' => $has_staticimage1,
						'HasStaticImage2' => $has_staticimage2,
						'HasAssetClass' => $has_assetclass,
						'HasQuotable' => $has_quotable,
						'Site' => $site,
						'EditorId' => $editor_id,
						'EditorDisplayName' => $editor_display_name,
						'UpdatedAt' => gmdate('Y-m-d H:i:s')
					),
					array(
					 'EmailId' => $email_id
					)
				);
				if ($wpdb->last_error) {
  					$response = new WP_REST_Response( $wpdb->last_error );
					return $response;
				}
				return $json_result;
			  }
        )
     );
	register_rest_route( 
        'email-builder/v1',
        '/adestra',
        array(
            'methods' => 'POST',
            'callback' => function ($data ){
				
				try{
					$json_result = json_decode($data->get_body(), true);
					$emailId= $json_result["emailId"];
     				$name= $json_result["name"];
     				$subject = $json_result["subject"];
				    $description= $json_result["name"];
				    $project_id = $json_result["project_id"];
					$content = $json_result["content"];
					$site = $json_result["site"];
				    //$list_id= 1234;
					$client = new XMLRPC_Client( "https://app.adestra.com/api/xmlrpc" );
					$new_campaign = $client->call( 'campaign.create', ['name' => $name,
						                                           'description' => $description,
						                                           'project_id' => $project_id]);

				    $subject_line= $subject;
				    $domain= 'campaign.lastwordmedia.com';
				    $from_prefix= 'mail';
				    if($site == 'wp_2_'){
				    	$from_name= 'Portfolio Adviser';
				    	$unsub_list= 3;
				    	$suppress_lists= [1,3];
				    }
				    else if($site === 'wp_3_'){
				    	$from_name= 'International Adviser';
				    	$unsub_list= 2;
				    	$suppress_lists= [1,2];
				    }
				    else if($site === 'wp_4_'){
				    	$from_name= 'Fund Selector Asia';
				    	$unsub_list= 5;
				    	$suppress_lists= [1,5];
				    }
				    else if($site === 'wp_5_'){
				    	$from_name= 'Expert Investor';
				    	$unsub_list= 4;
				    	$suppress_lists= [1,4];
				    }		
					$from_address= 'newsletter@campaign.lastwordmedia.com';			    
				    $auto_tracking= 1;
				    
					$client->call( 'campaign.setAllOptions', $new_campaign['id'] ,['subject_line' => $subject_line,
						                                           'domain' => $domain,
						                                           'from_prefix' => $from_prefix,
						                                           'user_from' => 1,
						                                           'from_name' => $from_name,
						                                           'from_address' => $from_address,
						                                           'auto_tracking' => $auto_tracking,
						                                           'unsub_list' => $unsub_list,
						                                           'suppress_lists' => $suppress_lists]);
					

					$html_content = $content;

					$client->call( 'campaign.setMessage', $new_campaign['id'], 'html' , $html_content);

					//$client->call( 'campaign.setMessage', $new_campaign['id'], 'text' , $html_content);

					$client->call( 'campaign.publish', $new_campaign['id']);

                    //$launch_label = '2016-01-01 daily email';

					//$response = $client->call( 'campaign.launch', $new_campaign['id'], ['launch_label' => $launch_label]);

                    global $wpdb;
                    $table_name = 'wp_2_email_builder_emails';

					$wpdb->update( 
					$table_name, 
					array( 
						'SendToAdestraOn' => date('Y-m-d H:i:s')
					),
					array(
					 'EmailId' => $emailId
					)
					);
					if ($wpdb->last_error) {
	  					$response = new WP_REST_Response( $wpdb->last_error );
						return $response;
					}
					
				}
				catch(Exception $ex){
				  return $ex;	
				}

			    return $response;
			  }
        )
     );
	register_rest_route(
     	'email_builder/v1',
	    '/clearcache',
		array(
		 'methods' => 'POST',
            'callback' => function ($params ){
				return array( 'success' => wp_cache_delete( 'emails' ) );
			  }) 
	);
	register_rest_route( 
        'email-builder/v1',
        '/types',
        array(
            'methods' => 'GET',
            'callback' => function ($params ){
				global $wpdb;
				$table_terms = $params['prefix']."terms" ;
				$table_term_taxonomy = $params['prefix']."term_taxonomy" ;
				$types = $wpdb->get_results("SELECT t.term_id AS id,t.name AS name FROM ".$table_terms." t  LEFT JOIN ".$table_term_taxonomy." tt ON t.term_id = tt.term_id WHERE  tt.taxonomy = 'type' ORDER  BY name");
				if ($wpdb->last_error) {
  					$response = new WP_REST_Response( $wpdb->last_error );
					return $response;
				}			
			    return $types;
			  }
        )
     );
	register_rest_route( 
        'email-builder/v1',
        '/categories',
        array(
            'methods' => 'GET',
            'callback' => function ($params ){
				global $wpdb;
				$table_terms = $params['prefix']."terms" ;
				$table_term_taxonomy = $params['prefix']."term_taxonomy" ;
				$categories = $wpdb->get_results("SELECT t.term_id AS id,t.name AS name FROM ".$table_terms." t  LEFT JOIN ".$table_term_taxonomy." tt ON t.term_id = tt.term_id WHERE  tt.taxonomy = 'category' AND t.term_id > 1 ORDER  BY name");
				if ($wpdb->last_error) {
  					$response = new WP_REST_Response( $wpdb->last_error );
					return $response;
				}			
			    return $categories;
			  }
        )
     );
	register_rest_route( 
        'email-builder/v1',
        '/postsbytype',
        array(
            'methods' => 'GET',
            'callback' => function ($params ){

global $wpdb;
$posts= $wpdb->get_results("select * from ".$params['prefix']."posts LEFT JOIN ".$params['prefix']."term_relationships tr ON ".$params['prefix']."posts.ID = tr.object_id INNER JOIN ".$params['prefix']."term_taxonomy tt ON tt.term_taxonomy_id=tr.term_taxonomy_id INNER JOIN ".$params['prefix']."terms t ON t.term_id = tt.term_id where t.term_id = ".$params['type']." and  ".$params['prefix']."posts.post_title like '%".$params['search']."%' and ".$params['prefix']."posts.post_type='post' and ".$params['prefix']."posts.post_status='publish' LIMIT 10;");
			    foreach($posts as $row){ 
					$ftd_image = $wpdb->get_results("SELECT meta_value FROM ".$params['prefix']."postmeta WHERE post_id = ".$row->ID." and meta_key = 'lw_featured_image_url'");
					if($ftd_image == null){
					  $thumb = $wpdb->get_results("SELECT (select guid from ".$params['prefix']."posts where ID = pm.meta_value) as guid  FROM ".$params['prefix']."posts ps inner join  ".$params['prefix']."postmeta pm on ps.ID = pm.post_id where meta_key = '_thumbnail_id' and post_id = ".$row->ID."");
					  if($thumb != null){
					  	$ext = "." . pathinfo($thumb[0]->guid, PATHINFO_EXTENSION);
					  	$row->featured_image = str_replace($ext, "-219x122" . $ext, $thumb[0]->guid); 
					  }
					  else{
					  	$row->featured_image = null; 
					  }
					}
					else{
						$row->featured_image = $ftd_image[0]->meta_value; 
					}					
				}	
			    return (object)array($posts, count($posts));
			  }
        )
     );
	 register_rest_route( 
        'email-builder/v1',
        '/postsbysite',
        array(
            'methods' => 'GET',
            'callback' => function ($params ){

				global $wpdb;

                $posts= $wpdb->get_results("SELECT * FROM ".$params['site']."posts where post_title like '%".$params['search']."%' and post_type='post' and post_status='publish' LIMIT 10");

                $count = $wpdb->get_results("SELECT count(*) as count FROM ".$params['site']."posts where post_title like '%".$params['search']."%' and post_type='post' and post_status='publish'");
				

			    foreach($posts as $row){ 
					$ftd_image = $wpdb->get_results("SELECT meta_value FROM ".$params['prefix']."postmeta WHERE post_id = ".$row->ID." and meta_key = 'lw_featured_image_url'");
					if($ftd_image == null){
					  $thumb = $wpdb->get_results("SELECT (select guid from ".$params['prefix']."posts where ID = pm.meta_value) as guid  FROM ".$params['prefix']."posts ps inner join  ".$params['prefix']."postmeta pm on ps.ID = pm.post_id where meta_key = '_thumbnail_id' and post_id = ".$row->ID."");
					  if($thumb != null){
					  	$ext = "." . pathinfo($thumb[0]->guid, PATHINFO_EXTENSION);
					  	$row->featured_image = str_replace($ext, "-219x122" . $ext, $thumb[0]->guid); 
					  }
					  else{
					  	$row->featured_image = null; 
					  }
					}
					else{
						$row->featured_image = $ftd_image[0]->meta_value; 
					}					
				}					
			    return (object)array($posts, $count[0]->count);
			  }
        )
     );
     register_rest_route( 
        'email-builder/v1',
        '/postsbyevent',
        array(
            'methods' => 'GET',
            'callback' => function ($params ){

				global $wpdb;

                $posts= $wpdb->get_results("SELECT ps.*, pm.*, pm.meta_value as link FROM ".$params['site']."posts ps inner join ".$params['site']."postmeta pm on ps.id = pm.post_id where ps.post_type='event' and ps.post_title like '%".$params['search']."%' and pm.meta_key = 'lw_event_link' LIMIT 10");

                $count = $wpdb->get_results("SELECT count(*) as count FROM ".$params['site']."posts ps inner join ".$params['site']."postmeta pm on ps.id = pm.post_id where ps.post_type='event' and ps.post_title like '%".$params['search']."%' and pm.meta_key = 'lw_event_link'");
				

			    foreach($posts as $row){ 

                    $start_date = $wpdb->get_results("SELECT meta_value from ".$params['site']."postmeta where meta_key = 'lw_event_start_date' and post_id = ".$row->ID."");

                    $row->startdate = $start_date[0]->meta_value;

					$ftd_image = $wpdb->get_results("SELECT meta_value FROM ".$params['prefix']."postmeta WHERE post_id = ".$row->ID." and meta_key = 'lw_featured_image_url'");
					if($ftd_image == null){
					  $thumb = $wpdb->get_results("SELECT (select guid from ".$params['prefix']."posts where ID = pm.meta_value) as guid  FROM ".$params['prefix']."posts ps inner join  ".$params['prefix']."postmeta pm on ps.ID = pm.post_id where meta_key = '_thumbnail_id' and post_id = ".$row->ID."");
					  if($thumb != null){
					  	$ext = "." . pathinfo($thumb[0]->guid, PATHINFO_EXTENSION);
					  	$row->featured_image = str_replace($ext, "-219x122" . $ext, $thumb[0]->guid); 
					  }
					  else{
					  	$row->featured_image = null; 
					  }
					}
					else{
						$row->featured_image = $ftd_image[0]->meta_value; 
					}					
				}				
			    return (object)array($posts, $count[0]->count);
			  }
        )
     );
    register_rest_route( 
        'email-builder/v1',
        '/posts',
        array(
            'methods' => 'GET',
            'callback' => function ($params ){

				global $wpdb;

				$offset = ($params['page'] - 1) * 10;

                $posts= $wpdb->get_results("SELECT * FROM ".$params['prefix']."posts p JOIN ".$params['prefix']."term_relationships tr ON (p.ID = tr.object_id) JOIN ".$params['prefix']."term_taxonomy tt ON (tr.term_taxonomy_id = tt.term_taxonomy_id) JOIN ".$params['prefix']."terms t ON (tt.term_id = t.term_id) WHERE p.post_type='post' AND p.post_status = 'publish' AND tt.taxonomy = 'category' AND t.term_id = ".$params['categoryId']." ORDER BY post_date DESC LIMIT 10 OFFSET ".$offset);

                $count = $wpdb->get_results("SELECT count(*) as count FROM ".$params['prefix']."posts p JOIN ".$params['prefix']."term_relationships tr ON (p.ID = tr.object_id) JOIN ".$params['prefix']."term_taxonomy tt ON (tr.term_taxonomy_id = tt.term_taxonomy_id) JOIN ".$params['prefix']."terms t ON (tt.term_id = t.term_id) WHERE p.post_type='post' AND p.post_status = 'publish' AND tt.taxonomy = 'category' AND t.term_id = ".$params['categoryId']);
				
			    foreach($posts as $row){
					$ftd_image = $wpdb->get_results("SELECT meta_value FROM ".$params['prefix']."postmeta WHERE post_id = ".$row->ID." and meta_key = 'lw_featured_image_url'");
					if($ftd_image == null){
					  $thumb = $wpdb->get_results("SELECT (select guid from ".$params['prefix']."posts where ID = pm.meta_value) as guid  FROM ".$params['prefix']."posts ps inner join  ".$params['prefix']."postmeta pm on ps.ID = pm.post_id where meta_key = '_thumbnail_id' and post_id = ".$row->ID."");
					  if($thumb != null){
					  	$ext = "." . pathinfo($thumb[0]->guid, PATHINFO_EXTENSION);
					  	$row->featured_image = str_replace($ext, "-219x122" . $ext, $thumb[0]->guid); 
					  }
					  else{
					  	$row->featured_image = null; 
					  }
					}
					else{
						$row->featured_image = $ftd_image[0]->meta_value; 
					}					
				}					
			    return (object)array($posts, $count[0]->count);
			  }
        )
     );
    register_rest_route( 
        'email-builder/v1',
        '/latestposts',
        array(
            'methods' => 'GET',
            'callback' => function ($params ){
				global $wpdb;

				$posts= $wpdb->get_results("select * from ".$params['prefix']."posts where post_type='post' and post_status='publish' order by ID desc limit 10");

			    foreach($posts as $row){ 
					$ftd_image = $wpdb->get_results("SELECT meta_value FROM ".$params['prefix']."postmeta WHERE post_id = ".$row->ID." and meta_key = 'lw_featured_image_url'");
					if($ftd_image == null){
					  $thumb = $wpdb->get_results("SELECT (select guid from ".$params['prefix']."posts where ID = pm.meta_value) as guid  FROM ".$params['prefix']."posts ps inner join  ".$params['prefix']."postmeta pm on ps.ID = pm.post_id where meta_key = '_thumbnail_id' and post_id = ".$row->ID."");
					  if($thumb != null){
					  	$ext = "." . pathinfo($thumb[0]->guid, PATHINFO_EXTENSION);
					  	$row->featured_image = str_replace($ext, "-219x122" . $ext, $thumb[0]->guid); 
					  }
					  else{
					  	$row->featured_image = null; 
					  }
					}
					else{
						$row->featured_image = $ftd_image[0]->meta_value; 
					}					
				}				
			    return (object)array($posts, count($posts));
			  }
        )
     );
    register_rest_route( 
        'email-builder/v1',
        '/latestpostsbysite',
        array(
            'methods' => 'GET',
            'callback' => function ($params ){
				global $wpdb;

				$latest_portfolio= $wpdb->get_results("select * from wp_2_posts where post_type='post' and post_status='publish' order by ID desc limit 2");
				$latest_international= $wpdb->get_results("select * from wp_3_posts where post_type='post' and post_status='publish' order by ID desc limit 2");
				$latest_fundselector= $wpdb->get_results("select * from wp_4_posts where post_type='post' and post_status='publish' order by ID desc limit 2");
				$latest_expertinvestor= $wpdb->get_results("select * from wp_5_posts where post_type='post' and post_status='publish' order by ID desc limit 2");
				if ($wpdb->last_error) {
  					$response = new WP_REST_Response( $wpdb->last_error );
					return $response;
				}
			
			    return (object)array($latest_portfolio, $latest_international, $latest_fundselector, $latest_expertinvestor);
			  }
        )
     );
	 register_rest_route( 
        'email-builder/v1',
        '/postsmostrated',
        array(
            'methods' => 'GET',
            'callback' => function ($params ){
                global $wpdb;	
                $offset = ($params['page'] - 1) * 10;			
                $posts= $wpdb->get_results("select ps.ID, ps.post_name, ps.post_title, ps.post_date, ps.post_excerpt, ps.guid, pm.meta_value from ".$params['prefix']."posts as ps inner join ".$params['prefix']."postmeta as pm on ps.ID = pm.post_id where pm.meta_key = 'lw_read_count' and ps.post_date > NOW() - INTERVAL 30 DAY and post_type='post' and post_status='publish' order by convert(pm.meta_value, unsigned)  DESC LIMIT 10 OFFSET ".$offset);
                $count= $wpdb->get_results("select count(*) as count from ".$params['prefix']."posts as ps inner join ".$params['prefix']."postmeta as pm on ps.ID = pm.post_id where pm.meta_key = 'lw_read_count' and ps.post_date > NOW() - INTERVAL 30 DAY and post_type='post' and post_status='publish' order by convert(pm.meta_value, unsigned)  DESC");

			    foreach($posts as $row){ 
					$ftd_image = $wpdb->get_results("SELECT meta_value FROM ".$params['prefix']."postmeta WHERE post_id = ".$row->ID." and meta_key = 'lw_featured_image_url'");
					if($ftd_image == null){
					  $thumb = $wpdb->get_results("SELECT (select guid from ".$params['prefix']."posts where ID = pm.meta_value) as guid  FROM ".$params['prefix']."posts ps inner join  ".$params['prefix']."postmeta pm on ps.ID = pm.post_id where meta_key = '_thumbnail_id' and post_id = ".$row->ID."");
					  if($thumb != null){
					  	$ext = "." . pathinfo($thumb[0]->guid, PATHINFO_EXTENSION);
					  	$row->featured_image = str_replace($ext, "-219x122" . $ext, $thumb[0]->guid); 
					  }
					  else{
					  	$row->featured_image = null; 
					  }
					}
					else{
						$row->featured_image = $ftd_image[0]->meta_value; 
					}					
				}				
			    return (object)array($posts, $count[0]->count);
			  }
        )
     );
	 register_rest_route( 
        'email-builder/v1',
        '/images',
        array(
            'methods' => 'GET',
            'callback' => function ($params ){
				global $wpdb;
				$offset = ($params['page'] - 1) * 50;	
				$table_name = $params['prefix'].'posts';
				
				$images = $wpdb->get_results("SELECT guid FROM ".$table_name." WHERE post_type = 'Attachment' and post_mime_type in ('image/jpeg','image/gif','image/png') order by ID desc LIMIT 50 OFFSET ".$offset);

                $count = $wpdb->get_results("SELECT count(*) as count FROM ".$table_name." WHERE post_type = 'Attachment' and post_mime_type in ('image/jpeg','image/gif','image/png')");

				if ($wpdb->last_error) {
  					$response = new WP_REST_Response( $wpdb->last_error );
					return $response;
				}				
			    return (object)array($images, $count[0]->count);
			  }
        )
     );
	 register_rest_route( 
        'email-builder/v1',
        '/searchimages',
        array(
            'methods' => 'GET',
            'callback' => function ($params ){
				global $wpdb;
				$table_name = $params['prefix'].'posts';
				
				$images = $wpdb->get_results("SELECT guid FROM ".$table_name." WHERE post_type = 'Attachment' and post_mime_type in ('image/jpeg','image/gif','image/png') and post_name like '%".$params[search]."%'");
				if ($wpdb->last_error) {
  					$response = new WP_REST_Response( $wpdb->last_error );
					return $response;
				}				
			    return $images;
			  }
        )
     );
	 register_rest_route( 
        'email-builder/v1',
        '/static',
        array(
            'methods' => 'GET',
            'callback' => function ($params ){
				global $wpdb;
				$table_name = 'wp_2_email_builder_static';
				$static = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE Type = '". $params['type'] ."' AND Template = '". $params['template'] ."' and Site = '".$params['prefix']."'");
				if ($wpdb->last_error) {
  					$response = new WP_REST_Response( $wpdb->last_error );
					return $response;
				}				
			    return $static[0];
			  }
        )
     );
	 register_rest_route( 
        'email-builder/v1',
        '/statictemplate',
        array(
            'methods' => 'GET',
            'callback' => function ($params ){
				global $wpdb;
				$wpdb->flush();
				$table_name = 'wp_2_email_builder_static';
				if($params['type'] == null){
					$static = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE Template = '". $params['template'] ."' and Site = '".$params['prefix']."'");
				}
				else{
					$static = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE Template = '". $params['template'] ."' AND Type = '".$params['type']."' and Site = '".$params['prefix']."'");
				}
				if ($wpdb->last_error) {
  					$response = new WP_REST_Response( $wpdb->last_error );
					return $response;
				}				
			    return $static;
			  }
        )
     );
	 register_rest_route( 
        'email-builder/v1',
        '/email',
        array(
            'methods' => 'GET',
            'callback' => function ($params ){
				global $wpdb;
				$table_name = 'wp_2_email_builder_emails';
				$emails = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE EmailId = ".$params['emailId']."");
				$email = $emails[0];
				$string = $email->Articles;
				if($string != null && $string != ""){
					$string = preg_replace('/\.$/', '', $string); //Remove dot at end if exists
					$array = explode(',', $string); //split string into array seperated by ', '
					$email->Articles1 = array();
					foreach($array as $value) //loop over values
					{
						$posts= $wpdb->get_results("select *  from ".$params['prefix']."posts where ID = ".$value."");
						$ftd_image = $wpdb->get_results("SELECT meta_value FROM ".$params['prefix']."postmeta WHERE post_id = ".$posts[0]->ID." and meta_key = 'lw_featured_image_url'");
						if($ftd_image == null){
						  $thumb = $wpdb->get_results("SELECT (select guid from ".$params['prefix']."posts where ID = pm.meta_value) as guid  FROM ".$params['prefix']."posts ps inner join  ".$params['prefix']."postmeta pm on ps.ID = pm.post_id where meta_key = '_thumbnail_id' and post_id = ".$posts[0]->ID."");
						  if($thumb != null){
						  	$ext = "." . pathinfo($thumb[0]->guid, PATHINFO_EXTENSION);
					  		$posts[0]->featured_image = str_replace($ext, "-219x122" . $ext, $thumb[0]->guid); 
						  }
						  else{
						  	$posts[0]->featured_image = null; 
						  }
						}
						else{
							$posts[0] = $ftd_image[0]->meta_value; 
						}
						array_push($email->Articles1,$posts[0]);
					}
				}

				//EventArticles
				$string1 = $email->EventArticles;
				if($string1 != null && $string1 != ""){
					$string1 = preg_replace('/\.$/', '', $string1); //Remove dot at end if exists
					$array1 = explode(',', $string1); //split string into array seperated by ', '
					$email->EventArticles1 = array();
					foreach($array1 as $value) //loop over values
					{
						$posts= $wpdb->get_results("SELECT ps.*, pm.meta_value as link FROM ".$params['prefix']."posts ps inner join ".$params['prefix']."postmeta pm on ps.id = pm.post_id where ps.post_type='event' and ID = ".$value." and pm.meta_key = 'lw_event_link'");		

		                $start_date = $wpdb->get_results("SELECT meta_value from ".$params['prefix']."postmeta where meta_key = 'lw_event_start_date' and post_id = ".$posts[0]->ID."");

		                $posts[0]->startdate = $start_date[0]->meta_value;

						array_push($email->EventArticles1,$posts[0]);
					}	
				}
				//EditorArticles
				$string2 = $email->EditorArticles;
				if($string2 != null && $string2 != ""){
					$string2 = preg_replace('/\.$/', '', $string2); //Remove dot at end if exists
					$array2 = explode(',', $string2); //split string into array seperated by ', '
					$email->EditorArticles1 = array();
					foreach($array2 as $value) //loop over values
					{
						$posts= $wpdb->get_results("select *  from ".$params['prefix']."posts where ID = ".$value."");
						array_push($email->EditorArticles1,$posts[0]);
					}		
				}
				//MostViewed Articles
				$string3 = $email->MostViewedArticles;
				if($string3 != null && $string3 != ""){
					$string3 = preg_replace('/\.$/', '', $string3); //Remove dot at end if exists
					$array3 = explode(',', $string3); //split string into array seperated by ', '
					$email->MostViewedArticles1 = array();
					foreach($array3 as $value) //loop over values
					{
						$posts= $wpdb->get_results("select *  from ".$params['prefix']."posts where ID = ".$value."");
						array_push($email->MostViewedArticles1,$posts[0]);
					}		
				}
				//MoreNews Articles
				$string4 = $email->MoreNewsArticles;
				if($string4 != null && $string4 != ""){
					$string4 = preg_replace('/\.$/', '', $string4); //Remove dot at end if exists
					$array4 = explode(',', $string4); //split string into array seperated by ', '
					$email->MoreNewsArticles1 = array();
					foreach($array4 as $value) //loop over values
					{
						$posts= $wpdb->get_results("select *  from ".$params['prefix']."posts where ID = ".$value."");
						array_push($email->MoreNewsArticles1,$posts[0]);
					}		
				}
				//MostRead Articles
				$string5 = $email->MostReadArticles;
				if($string5 != null && $string5 != ""){
					$string5 = preg_replace('/\.$/', '', $string5); //Remove dot at end if exists
					$array5 = explode(',', $string5); //split string into array seperated by ', '
					$email->MostReadArticles1 = array();
					foreach($array5 as $value) //loop over values
					{
						$posts= $wpdb->get_results("select *  from ".$params['prefix']."posts where ID = ".$value."");
						$ftd_image = $wpdb->get_results("SELECT meta_value FROM ".$params['prefix']."postmeta WHERE post_id = ".$value." and meta_key = 'lw_featured_image_url'");
						if($ftd_image == null){
						  $thumb = $wpdb->get_results("SELECT (select guid from ".$params['prefix']."posts where ID = pm.meta_value) as guid  FROM ".$params['prefix']."posts ps inner join  ".$params['prefix']."postmeta pm on ps.ID = pm.post_id where meta_key = '_thumbnail_id' and post_id = ".$value."");
						  if($thumb != null){
						  	$ext = "." . pathinfo($thumb[0]->guid, PATHINFO_EXTENSION);
					  		$posts[0]->featured_image = str_replace($ext, "-219x122" . $ext, $thumb[0]->guid); 
						  }
						  else{
						  	$posts[0]->featured_image = null; 
						  }
						}
						else{
							$posts[0]->featured_image = $ftd_image[0]->meta_value; 
						}
						array_push($email->MostReadArticles1,$posts[0]);
					}		
				}
				//Investment Articles
				$string6 = $email->InvestmentArticles;
				if($string6 != null && $string6 != ""){
					$string6 = preg_replace('/\.$/', '', $string6); //Remove dot at end if exists
					$array6 = explode(',', $string6); //split string into array seperated by ', '
					$email->InvestmentArticles1 = array();
					foreach($array6 as $value) //loop over values
					{
						$posts= $wpdb->get_results("select *  from ".$params['prefix']."posts where ID = ".$value."");
						$ftd_image = $wpdb->get_results("SELECT meta_value FROM ".$params['prefix']."postmeta WHERE post_id = ".$value." and meta_key = 'lw_featured_image_url'");
						if($ftd_image == null){
						  $thumb = $wpdb->get_results("SELECT (select guid from ".$params['prefix']."posts where ID = pm.meta_value) as guid  FROM ".$params['prefix']."posts ps inner join  ".$params['prefix']."postmeta pm on ps.ID = pm.post_id where meta_key = '_thumbnail_id' and post_id = ".$value."");
						  if($thumb != null){
						  	$ext = "." . pathinfo($thumb[0]->guid, PATHINFO_EXTENSION);
					  		$posts[0]->featured_image = str_replace($ext, "-219x122" . $ext, $thumb[0]->guid); 
						  }
						  else{
						  	$posts[0]->featured_image = null; 
						  }
						}
						else{
							$posts[0]->featured_image = $ftd_image[0]->meta_value; 
						}
						array_push($email->InvestmentArticles1,$posts[0]);
					}		
				}
				if ($wpdb->last_error) {
  					$response = new WP_REST_Response( $wpdb->last_error );
					return $response;
				}		

				$email->Content = str_replace('https://', 'http://', $email->Content);		

				foreach ( $email->Articles1 as $key => $value )
				{
					$email->Articles1[$key]->guid = str_replace('http://', 'https://', $value->guid);
				}

			    return $email;
			  }
        )
     );
	 register_rest_route( 
        'email-builder/v1',
        '/removestatic',
        array(
            'methods' => 'POST',
            'callback' => function ($data ){
				$json_result = json_decode($data->get_body(), true);
				$type = $json_result["type"];
				$template = $json_result["template"];
				$site = $json_result["prefix"];
				
				global $wpdb;
				$table_name = 'wp_2_email_builder_static';
				$wpdb->delete( $table_name, array( 'Template' => $template, 'Type' =>  $type, 'Site' => $site) );
				
				if ($wpdb->last_error) {
  					$response = new WP_REST_Response( $wpdb->last_error );
					return $response;
				}
				
				return true;
			  }
     )

   );
	 register_rest_route( 
        'email-builder/v1',
        '/static',
        array(
            'methods' => 'POST',
            'callback' => function ($data ){
				$json_result = json_decode($data->get_body(), true);
				$type = $json_result["type"];
				$template = $json_result["template"];
				$content = $json_result["content"];
				$site = $json_result['prefix'];
				
				global $wpdb;
				$table_name = 'wp_2_email_builder_static';
				$result = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE Type = '".$type."' and Template = '".$template."' and Site = '".$site."'");


				if($wpdb->num_rows > 0) {
					$wpdb->update( 
						$table_name, 
						array( 
							'Content' => $content
						),
						array(
							'Type' => $type, 
							'Template' => $template,
							'Site' => $site
						)
					 );
				 return $result[0]->ContentId;
				}
				
				$wpdb->insert( 
					$table_name, 
					array( 
						'Type' => $type, 
						'Template' => $template,
						'Content' => $content,
						'Site' => $site
					) 
				);
				
				if ($wpdb->last_error) {
  					$response = new WP_REST_Response( $wpdb->last_error );
					return $response;
				}
				
				return $wpdb->insert_id;
			  }
        )
     );

   }

		/*function my_plugin_menu() {
	add_menu_page(__('Email Builder', 'myplugin'),__('Email Builder', 'myplugin'), 'edit_posts','my-plugin-dashboard','my_plugin_dashboard','icon');
	add_submenu_page('my-plugin-dashboard', __('Portfolio Adviser','myplugin'), __('Portfolio Adviser','myplugin'), 'edit_posts', 'my-plugin-dashboard', 'my_plugin_dashboard' );
	add_submenu_page('my-plugin-dashboard', __('International Advisor','myplugin'), __('International Advisor','myplugin'), 'manage_options', 'my-plugin-settings', 'my_plugin_settings' );
	add_submenu_page('my-plugin-dashboard', __('Fund Selector Asia','myplugin'), __('Fund Selector Asia','myplugin'), 'manage_options', 'my-plugin-settings', 'my_plugin_settings' );
	add_submenu_page('my-plugin-dashboard', __('Expert Investor Europe','myplugin'), __('Expert Investor Europe','myplugin'), 'manage_options', 'my-plugin-settings', 'my_plugin_settings' );
	}*/
	public function admin_menu() {
		$title = __( 'Email Builder', $this->plugin_domain );
		$hook_suffix = add_management_page( $title, $title, 'edit_posts', $this->plugin_domain, array(
			$this,
			'load_admin_view'
		) );
		add_action( 'load-' . $hook_suffix, array( $this, 'load_bundle' ) );

	}
	public function load_view( $view ) {
		$path = trailingslashit( $this->views_dir ) . $view;
		if ( file_exists( $path ) ) {
			include $path;
		}
	}
	public function load_admin_view() {
		$this->load_view( 'admin.php' );
			
	}
	public function load_bundle() {
		wp_register_script( 'jQuery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js', null, null, true );
        wp_enqueue_script('jQuery');
		wp_register_script( 'TinyMCE', 'https://tinymce.cachefly.net/4.2/tinymce.min.js', null, null, true );
        wp_enqueue_script('TinyMCE');
		wp_enqueue_style( 'prefix-style', plugins_url('css/main.5d029046.css', __FILE__) );
        wp_enqueue_script( 'plugin-scripts', plugins_url('js/main.0a7924a6.js', __FILE__),array(),  '0.0.1', true );
	}
	
    public function jal_install() {
		
		global $wpdb;

		$table_name = 'wp_2_email_builder_emails';
		
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
			EmailId mediumint(9) NOT NULL AUTO_INCREMENT,
			EmailName VARCHAR(1000) NULL,
			Articles VARCHAR(1000) NULL,
			TemplateName VARCHAR(1000) NULL,
			Content TEXT NULL,
			SendToAdestraOn varchar(1000) NULL,
			PRIMARY KEY  (EmailId)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		
		$static_table_name = 'wp_2_email_builder_static';
		
		$static_sql = "CREATE TABLE $static_table_name (
		  ContentId INT NOT NULL AUTO_INCREMENT,
		  Type VARCHAR(1000) NULL,
		  Template VARCHAR(1000) NULL,
		  Content TEXT NULL,
		  PRIMARY KEY (ContentId))$charset_collate;";
		  
		dbDelta( $static_sql );

		add_option( 'jal_db_version', '1.0' );
    }

}
class XMLRPC_Client {
 
  private $url;
 
  function __construct( $url ) {
    $this->url = $url;
  }
 
  /**
   * Call the XML-RPC method named $method and return the results, or die trying!
   *
   * @param string $method XML-RPC method name
   * @param mixed ... optional variable list of parameters to pass to XML-RPC call
   *
   * @return array result of XML-RPC call
   */
  public function call() {
  
  	ini_set("display_error", 1);
  	error_reporting(E_ALL);
 
    // get arguments
    $params = func_get_args();
    $method = array_shift( $params );
 
    $post = xmlrpc_encode_request( $method, $params , ['encoding' => 'utf-8']);
   

    $post = str_replace("\n", "", $post);
    //$post = str_replace(" ", "", $post);   
    $post = str_replace("\/", "/", $post); 
    $post = str_replace("<?xmlversion=\"1.0\"encoding=\"utf-8\"?>","", $post);
    /*<methodCall><methodName>campaign.setMessage</methodName><params><param><int>2</int></param><param><string>HTML</string></param><param><string>&lt;h1&gt;Hello World&lt;/h1&gt;</string></param></params></methodCall>*/
    //return $post; 

/*    echo $post;
*/
	$headers = array();
	$headers[] = 'X-MicrosoftAjax: Delta=true';
	$headers[] = 'Content-Type:text/xml';
	$headers[] = 'Authorization:Basic bGFzdHdvcmRtZWRpYS5qa2lyazo/P0JhZG4zd3M5MCEh';
    $ch = curl_init();
 
    // set URL and other appropriate options
    curl_setopt( $ch, CURLOPT_URL,            $this->url );
    curl_setopt( $ch, CURLOPT_POST,           true );
    curl_setopt( $ch, CURLOPT_POSTFIELDS,     $post );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
 
    // issue the request
    $response = curl_exec( $ch );
    $response_code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
    $curl_errorno = curl_errno( $ch );
    $curl_error   = curl_error( $ch );
    curl_close( $ch );
 
    // check for curl errors
    if ( $curl_errorno != 0 ) {
      die( "Curl ERROR: {$curl_errorno} - {$curl_error}n" );
    }
 
    // check for server errors
    if ( $response_code != 200 ) {
      die( "ERROR: non-200 response from server: {$response_code} - {$response}n" );
    } 
//    return $response;
//    $response .= 'e>';
    return xmlrpc_decode( $response );
  }
}
register_activation_hook( __FILE__, array('EmailBuilder', 'jal_install') );
new EmailBuilder();
?>