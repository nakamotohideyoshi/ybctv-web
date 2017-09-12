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
				$emails = $wpdb->get_results("SELECT EmailId, EmailName, SendToAdestraOn FROM ".$table_name." ORDER BY EmailId DESC  LIMIT 5 OFFSET ".$params['offset']."");
				if ($wpdb->last_error) {
  					$response = new WP_REST_Response( $wpdb->last_error );
					return $response;
				}		
			    return (object)array($emails, $no_rows);
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
				$email_articles = $json_result["articles"];
				$event_articles = $json_result["eventArticles"];
				$editor_articles = $json_result["editorArticles"];
				$template_name = $json_result["template"];
				$email_content = $json_result['content'];
				$has_topleaderboard = $json_result['hasTopLeaderboard'];
				$has_footerleaderboard = $json_result['hasFooterLeaderboard'];
				$has_newslettersubscribe = $json_result['hasNewsletterSubscribe'];
				$has_sponseredcontent = $json_result['hasSponsoredContent'];
				
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
					array( 
						'EmailName' => $email_name, 
						'Articles' => $email_articles,
						'EventArticles' => $event_articles,
						'EditorArticles' => $editor_articles,
						'TemplateName' => $template_name,
						'Content' => $email_content,
						'HasTopLeaderboard' => $has_topleaderboard,
						'HasFooterLeaderboard' => $has_footerleaderboard,
						'HasNewsletterSubscribe' => $has_newslettersubscribe,
						'HasSponseredContent' => $has_sponseredcontent
					) 
				);
				
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
				$template_name = $json_result["template"];
				$email_content = $json_result['content'];
				$has_topleaderboard = $json_result['hasTopLeaderboard'];
				$has_footerleaderboard = $json_result['hasFooterLeaderboard'];
				$has_newslettersubscribe = $json_result['hasNewsletterSubscribe'];
				$has_sponseredcontent = $json_result['hasSponsoredContent'];
				
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
						'TemplateName' => $template_name,
						'Content' => $email_content,
						'HasTopLeaderboard' => $has_topleaderboard,
						'HasFooterLeaderboard' => $has_footerleaderboard,
						'HasNewsletterSubscribe' => $has_newslettersubscribe,
						'HasSponseredContent' => $has_sponseredcontent
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
            'callback' => function ($params ){
				
				try{
					$account = 'lastwordmedia';
					$username = 'jkirk';
					$password = "!.~_DvWz:y`;6f~s";
					$headers = array();
					$headers[] = 'X-MicrosoftAjax: Delta=true';
					$headers[] = 'Content-Type:text/xml';
					$headers[] = 'Authorization:Basic bGFzdHdvcmRtZWRpYS5qa2lyazohLn5fRHZXejp5YDs2Zn5z';
					
					$input_xml = '<methodCall><methodName>campaign.setMessage</methodName><params><param><int>2</int></param><param><string>HTML</string></param><param><string>&lt;h1&gt;Hello World&lt;/h1&gt;</string></param></params></methodCall>';
										
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL,"https://app.adestra.com/api/xmlrpc");
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
					curl_setopt($ch, CURLOPT_POSTFIELDS,$input_xml);
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					$server_output = curl_exec ($ch);
					curl_close ($ch);
					return $server_output;
					
					
				/*	$account = 'lastwordmedia';
					$username = 'jkirk';
					$password = "!.~_DvWz:y`;6f~s";
					$campaign_id=2;
					$type='HTML';
					$content='<h1>Hello World</h1>';

					require_once('xmlrpc.inc');//First inlcude XMLRPC client library


					//Calling Adestra API with our credentials
					$xmlrpc= new xmlrpc_client("https://app.adestra.com/api/xmlrpc");
					$xmlrpc->setCredentials($account.$username,$password);
					$xmlrpc->setDebug(2);
					$xmlrpc->request_charset_encoding="UTF-8";


					$msg = new xmlrpcmsg(
										"campaign.set",
										array(
											//Set user id
											new xmlrpcval($campaign_id, "int"),
											new xmlrpcval($type, "string"),
											new xmlrpcval($content, "string")
										)

									);
					$response = $xmlrpc->send($msg);//Send request, and get the response
					*/
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
				$table_terms = $wpdb->prefix."terms" ;
				$table_term_taxonomy = $wpdb->prefix."term_taxonomy" ;
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
				$table_terms = $wpdb->prefix."terms" ;
				$table_term_taxonomy = $wpdb->prefix."term_taxonomy" ;
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

/*function title_like_posts_where( $where, &$wp_query ) {
    global $wpdb;
    if ( $post_title_like = $wp_query->get( 'post_title_like' ) ) {
        $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( $wpdb->esc_like( $post_title_like ) ) . '%\'';
    }
    return $where;
}
if($params['type'] > 1){
	$args = array(
		  'taxonomy' => 'type',
		  'field' => 'id',
		  'post_title_like' => $params['search'],
		  'terms' => $params['type'], // Where term_id of Term 1 is "1".
		  'include_children' => false
      );
}
else{
	$args = array(
		  'taxonomy' => 'type',
		  'post_title_like' => $params['search'],
		  'include_children' => false
      );
}*/

/*add_filter( 'posts_where', 'title_like_posts_where', 10, 2 );*/
global $wpdb;
$posts= $wpdb->get_results("select * from wp_2_posts LEFT JOIN wp_2_term_relationships tr ON wp_2_posts.ID = tr.object_id INNER JOIN wp_2_term_taxonomy tt ON tt.term_taxonomy_id=tr.term_taxonomy_id INNER JOIN wp_2_terms t ON t.term_id = tt.term_id where t.term_id = ".$params['type']." and  wp_2_posts.post_title like '%".$params['search']."%';");
/*$my_query = new WP_Query($args);*/
			    foreach($posts as $row){ 
					$ftd_image = $wpdb->get_results("SELECT meta_value FROM wp_2_postmeta WHERE post_id = ".$row->ID." and meta_key = 'lw_featured_image_url'");
					if($ftd_image == null){
					  if(has_post_thumbnail( $row->ID )){
						$image = wp_get_attachment_image_src(get_post_thumbnail_id($row->ID ),"full");
						$row->featured_image = $image[0]; 
					  }
					}
					else{
						$row->featured_image = $ftd_image[0]->meta_value; 
					}					
				}
/*remove_filter( 'posts_where', 'title_like_posts_where', 10, 2 );*/
			    return (object)array($posts, count($posts));
			  }
        )
     );
    register_rest_route( 
        'email-builder/v1',
        '/posts',
        array(
            'methods' => 'GET',
            'callback' => function ($params ){
				$args = array(
					'posts_per_page' => 10,
					'cat' => $params['categoryId'],
					'paged'=>$params['page']
				);

			    $my_query = new WP_Query( $args ); 

				global $wpdb;

				
			    foreach($my_query->posts as $row){ 
					$ftd_image = $wpdb->get_results("SELECT meta_value FROM wp_2_postmeta WHERE post_id = ".$row->ID." and meta_key = 'lw_featured_image_url'");
					if($ftd_image == null){
					  if(has_post_thumbnail( $row->ID )){
						$image = wp_get_attachment_image_src(get_post_thumbnail_id($row->ID ),"full");
						$row->featured_image = $image[0]; 
					  }
					}
					else{
						$row->featured_image = $ftd_image[0]->meta_value; 
					}					
				}				
			    return (object)array($my_query->posts, $my_query->found_posts);
			  }
        )
     );
	 register_rest_route( 
        'email-builder/v1',
        '/postsmostrated',
        array(
            'methods' => 'GET',
            'callback' => function ($params ){
				$args = array(
					'posts_per_page' => 10,
					'order'     => 'DESC',
					'orderby' => 'meta_value',
					'meta_key' => 'lw_read_count',
					'paged'=>$params['page']
				);

			    $my_query = new WP_Query( $args ); 
                global $wpdb;				
			    foreach($my_query->posts as $row){ 
					$ftd_image = $wpdb->get_results("SELECT meta_value FROM wp_2_postmeta WHERE post_id = ".$row->ID." and meta_key = 'lw_featured_image_url'");
					if($ftd_image == null){
					  if(has_post_thumbnail( $row->ID )){
						$image = wp_get_attachment_image_src(get_post_thumbnail_id($row->ID ),"full");
						$row->featured_image = $image[0]; 
					  }
					}
					else{
						$row->featured_image = $ftd_image[0]->meta_value; 
					}
				}				
			    return (object)array($my_query->posts, $my_query->found_posts);
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
				$table_name = 'wp_2_posts';
				
				$images = $wpdb->get_results("SELECT guid FROM ".$table_name." WHERE post_type = 'Attachment' and post_mime_type in ('image/jpeg','image/gif','image/png')");
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
        '/searchimages',
        array(
            'methods' => 'GET',
            'callback' => function ($params ){
				global $wpdb;
				$table_name = 'wp_2_posts';
				
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
				$static = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE Type = '". $params['type'] ."' AND Template = '". $params['template'] ."'");
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
					$static = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE Template = '". $params['template'] ."'");
				}
				else{
					$static = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE Template = '". $params['template'] ."' AND Type = '".$params['type']."'");
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
						$post = get_post( $value );
						$ftd_image = $wpdb->get_results("SELECT meta_value FROM wp_2_postmeta WHERE post_id = ".$post->ID." and meta_key = 'lw_featured_image_url'");
						if($ftd_image == null){
						  if(has_post_thumbnail( $post->ID )){
							$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID ),"full");
							$post->featured_image = $image[0]; 
						  }
						}
						else{
							$post->featured_image = $ftd_image[0]->meta_value; 
						}
						array_push($email->Articles1,$post);
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
						array_push($email->EventArticles1,get_post( $value ));
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
						array_push($email->EditorArticles1,get_post( $value ));
					}		
				}
				if ($wpdb->last_error) {
  					$response = new WP_REST_Response( $wpdb->last_error );
					return $response;
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
				
				global $wpdb;
				$table_name = 'wp_2_email_builder_static';
				$wpdb->delete( $table_name, array( 'Template' => $template, 'Type' =>  $type) );
				
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
				
				global $wpdb;
				$table_name = 'wp_2_email_builder_static';
				$result = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE Type = '".$type."' and Template = '".$template."'");


				if($wpdb->num_rows > 0) {
					$wpdb->update( 
						$table_name, 
						array( 
							'Content' => $content
						),
						array(
							'Type' => $type, 
							'Template' => $template,
						)
					 );
				 return $result[0]->ContentId;
				}
				
				$wpdb->insert( 
					$table_name, 
					array( 
						'Type' => $type, 
						'Template' => $template,
						'Content' => $content
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
		wp_enqueue_style( 'font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', null, null, true );
        wp_enqueue_style('font-awesome');
		wp_register_script( 'jQuery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js', null, null, true );
        wp_enqueue_script('jQuery');
		wp_register_script( 'TinyMCE', 'https://tinymce.cachefly.net/4.2/tinymce.min.js', null, null, true );
        wp_enqueue_script('TinyMCE');
		wp_enqueue_style( 'prefix-style', plugins_url('css/main.4714b6ec.css', __FILE__) );
        wp_enqueue_script( 'plugin-scripts', plugins_url('js/main.ba8eb9d0.js', __FILE__),array(),  '0.0.1', true );

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

register_activation_hook( __FILE__, array('EmailBuilder', 'jal_install') );
new EmailBuilder();
?>