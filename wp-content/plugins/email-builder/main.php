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

require_once "manage.php";

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

		$this->overwrite_ajax_calls();
	}

	private function overwrite_ajax_calls() {
		global $wpdb;

		$g = isset($_GET) ? $_GET : array();
		$s = isset($_SERVER) ? $_SERVER : array();

		if ( isset( $s['REDIRECT_URL'] ) && $s['REQUEST_METHOD'] == 'GET' ) {
			$url = $s['REDIRECT_URL'];

			if ( $url == '/wp-json/email-builder/v1/static' && isset($g['type']) && isset($g['template']) && isset($g['prefix']) ) {
				
				header("Access-Control-Allow-Origin: *");
				header("Access-Control-Allow-Headers: *");

				$table_name = 'wp_2_email_builder_static';
				$static = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE Type = '". $_GET['type'] ."' AND Template = '". $_GET['template'] ."' and Site = '".$_GET['prefix']."'");
				
				if ($wpdb->last_error) {
					$response = new WP_REST_Response( $wpdb->last_error );
					
					echo $response;
				}				
			    
			    echo json_encode($static[0]);
			    exit();
			
			} else if ( $url == '/wp-json/email-builder/v1/statictemplate' && isset($g['template']) && isset($g['prefix']) ) {
				header("Access-Control-Allow-Origin: *");
				header("Access-Control-Allow-Headers: *");

				$table_name = 'wp_2_email_builder_static';
				
				if (!isset($g['type']) ) {
					$static = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE Template = '". $g['template'] ."' and Site = '".$g['prefix']."'");
				} else {
					$static = $wpdb->get_results($qr = "SELECT * FROM ".$table_name." WHERE Template = '". $g['template'] ."' AND Type = '".$g['type']."' and Site = '".$g['prefix']."'");
				}

				if ($wpdb->last_error) {
  					$response = new WP_REST_Response( $wpdb->last_error );
					
					echo $response;
				}

				if ( empty($static) ) {
					$staticObj = new stdClass();
					$staticObj->Version = 2;	
					$staticObj->Data = '';
					$staticObj->Content = '';
					$staticObj->Template = $g['template'];
					$staticObj->Type = $g['type'];
					$staticObj->Site = $g['prefix'];

					$fragment_type = $g['type'];
			
					if ( strpos( $fragment_type, 'Top_Leaderboard' ) !== false ) {
						$staticObj->Data = '{"image":"https:\/\/lastword.staging.wpengine.com\/wp-content\/uploads\/2017\/11\/banner728x90.gif","image_link":"https:\/\/addyourcustomlinkhere.com","dummy":"","source_code":"<table class=\"device_innerblock mce-item-table\" width=\"728\" align=\"center\"><tbody><tr><td style=\"padding: 10px 10px 10px 10px;\" align=\"center\"><a href=\"{{image_link}}\" target=\"_blank\"> <img src=\"{{image}}\" alt=\"\"> <\/a><\/td><\/tr><\/tbody><\/table>"}';
					} else if ( strpos( $fragment_type, 'Footer_Leaderboard' ) !== false ) {
						$staticObj->Data = '{"image":"https:\/\/lastword.staging.wpengine.com\/wp-content\/uploads\/2017\/11\/banner728x90.gif","image_link":"https:\/\/addyourcustomlinkhere.com","dummy":"","source_code":"<table class=\"device_innerblock mce-item-table\" width=\"728\" align=\"center\"><tbody><tr><td style=\"padding: 10px 10px 10px 10px;\" align=\"center\"><a href=\"{{image_link}}\" target=\"_blank\"> <img src=\"{{image}}\" alt=\"\"> <\/a><\/td><\/tr><\/tbody><\/table>"}';
					} else if ( strpos( $fragment_type, 'Newsletter_Subscribe' ) !== false ) {
						$staticObj->Data = '{"link":"https:\/\/lastword.turtl.co\/story\/5978733d704eae3793d45073","image":"http:\/\/pa-cms-lastwordmedia-com.lastword.staging.wpengine.com\/wp-content\/uploads\/sites\/2\/2017\/08\/PA_alts_guide_macbook_444px.png","button_text":"Click here!","dummy":"","source_code":"<table class=\"subscribe\" style=\"width: 100%;\">\r\n<tbody>\r\n<tr>\r\n<td style=\"padding: 0px 0px 10px 0px; color: #004588; font-size: 14px; font-family: Arial;\"><center><a href=\"{{link}}\"><img src=\"{{image}}\" alt=\"\" width=\"200\" data-width=\"200\" \/><\/a><\/center><\/td>\r\n<\/tr>\r\n<tr>\r\n<td style=\"padding: 6px 0px; font-size: 14px;\" align=\"center\" bgcolor=\"#64a70b\"><strong><span style=\"font-family: Arial;\"><a style=\"text-decoration: none; color: #fff;\" href=\"{{link}}\">{{button_text}}<\/a><\/span><\/strong><\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>"}';
					} else if ( strpos( $fragment_type, 'Digital_Magazine' ) !== false ) {
						$staticObj->Data = '{"image":"http:\/\/pa-cms-lastwordmedia-com.lastword.staging.wpengine.com\/wp-content\/uploads\/sites\/2\/2017\/08\/Coverforweb-272x346-1.gif","link":"http:\/\/magazine.portfolio-adviser.com\/onlinereader\/html5_reader.aspx?issueid=154432","title":"Portfolio Adviser - September 2017","body":"The September issue of Portfolio Adviser magazine is now available to read online. View your digital edition by clicking on the link below, or download the free Portfolio Adviser App through your app store.\r\n<ul>\r\n \t<li>adsadada<\/li>\r\n \t<li>dsada<\/li>\r\n \t<li>dasdasdas<\/li>\r\n<\/ul>\r\n<ol>\r\n \t<li>dwqdqwdqw<\/li>\r\n \t<li>dwqd<\/li>\r\n \t<li>qwdwqdwq<\/li>\r\n<\/ol>","cta":"<a href=\"http:\/\/magazine.portfolio-adviser.com\/onlinereader\/html5_reader.aspx?issueid=154432\">CLICK HERE TO GET YOUR ISSUE<\/a>","dummy":"","source_code":"<table style=\"border-bottom: 1px solid #e5eaee;\" border=\"0\" width=\"100%\"><tbody><tr>\r\n<td class=\"container_sub\" style=\"padding: 20px 10px 14px 0px; vertical-align: top;\" width=\"32%\"><a href=\"{{link}}\" target=\"_blank\" rel=\"noopener\"><img style=\"max-width: 100%;\" title=\"PA September\" src=\"{{image}}\" alt=\"\" \/><\/a><\/td>\r\n<td class=\"container_sub\" style=\"vertical-align: top; padding: 13px 0px 14px;\" width=\"68%\">\r\n<table border=\"0\" width=\"100%\">\r\n<tbody><tr>\r\n<td style=\"padding: 0px 0px 7px;\"><a style=\"font-size: 14px; font-family: Arial, Helvetica, sans-serif; text-decoration: none; color: #64a70b;\" href=\"{{link}}\" target=\"_blank\" rel=\"noopener\">{{title}}<\/a><\/td>\r\n<\/tr><tr>\r\n<td style=\"color: #2c2c2c; font-size: 14px; font-family: Arial, Helvetica, sans-serif; line-height: 20px;\">{{body}}<\/td>\r\n<\/tr><tr>\r\n<td style=\"color: #2c2c2c; font-size: 14px; font-family: Arial, Helvetica, sans-serif; line-height: 17px; padding-top: 23px;\">{{cta}}<\/td>\r\n<\/tr><\/tbody><\/table><\/td><\/tr><\/tbody><\/table>\r\n"}';
					} else if ( strpos( $fragment_type, 'Sponsored_Content_2' ) !== false ) {
						$staticObj->Data = '{"title":"Sponsored article by Fund","image":"http:\/\/pa-cms-lastwordmedia-com.lastword.staging.wpengine.com\/wp-content\/uploads\/sites\/2\/2017\/08\/IMG1225-219x122.jpg","image_link":"https:\/\/addyourcustomlinkhere.com","subtitle":"<a href=\"http:\/\/www.example.com\"><strong>This is a subheading to customise<\/strong><\/a>","excerpt":"Much has been written about adding Christmas trees to peoples gardens and then adding them to bonds to make money on them.","dummy":"","source_code":"<table style=\"border-bottom: 1px solid #e5eaee;\" border=\"0\" width=\"100%\" class=\"mce-item-table\"><tbody><tr><td class=\"container_sub\" style=\"padding: 20px 10px 14px 0px; vertical-align: top;\"><a href=\"{{image_link}}\"><img src=\"{{image}}\" alt=\"\" \/><\/a><\/td><td class=\"container_sub\" style=\"vertical-align: top; padding: 13px 0px 14px;\"><table border=\"0\" width=\"100%\" class=\"mce-item-table\"><tbody><tr><td class=\"anchor_color\" style=\"padding: 0px 0px 7px; color: #4caf50!important; font-size: 14px; font-family: Arial, Helvetica, sans-serif; font-weight: bold;\"><font face=\"Arial, Helvetica, sans-serif;\">{{title}}<\/font><\/td><\/tr><tr><td style=\"padding: 0px 0px 7px; font-family: \'Arial\'; font-size: 15px; font-weight: bold;\">{{subtitle}}<\/td><\/tr><tr><td class=\"container_td\" style=\"color: #2c2c2c!important; font-size: 14px; font-family: Arial, Helvetica, sans-serif; line-height: 20px;\">{{excerpt}}<\/td><\/tr><\/tbody><\/table><\/td><\/tr><\/tbody><\/table>"}';
					} else if ( strpos( $fragment_type, 'Sponsored_Content' ) !== false ) {
						$staticObj->Data = '{"body":"<strong>SPONSORED MESSAGE<\/strong>\r\n\r\n<strong>HERE IS YOUR CUSTOM TITLE<\/strong>\r\n\r\n<strong>This is a sub heading<\/strong>\r\n\r\nAnd here is a link to <a href=\"http:\/\/www.lastwordmedia.com\">click<\/a>\r\n\r\nFor many investors, bonds play a key part in their portfolio \u2013 the attractions being diversification and a source of income. The Fund is unusual in this asset class, because it is only one of a few funds that have a monthly income distribution. Investing primarily in fixed interest securities, flexibility is built in with the investment team taking a strategic view and responding tactically to market conditions. Aiming to generate a high and sustainable income, the fund has a strong track record of performance.\r\n\r\nSign up to our fixed income insight series. We will be delving in to the world of fixed income and exploring themes and topics that better explain the benefits of including this asset class in your portfolio.\r\n\r\n<a href=\"http:\/\/www.example.com\" target=\"_blank\" rel=\"noopener\">Time to take a closer look?<\/a>\r\n\r\nFor professional advisers only. Past performance is not a guide to future performance. The value of an investment and the income from it can fall as well as rise and you may not get back the amount originally <a href=\"http:\/\/www.google.com\">invested<\/a>.","image":"https:\/\/lastword.staging.wpengine.com\/wp-content\/uploads\/2017\/12\/logo-placeholder.png","image_link":"http:\/\/www.matthewsasia.com","dummy":"","source_code":"<table class=\"device_linked\" style=\"border: 1px solid #A1A1A1;\" width=\"728\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td>\r\n<table class=\"static_content linked\" style=\"width: 550px;\" align=\"left\">\r\n<tbody>\r\n<tr>\r\n<td style=\"padding: 14px;\">\r\n<table style=\"width: 100%;\">\r\n<tbody>\r\n<tr>\r\n<td style=\"color: #3b3b3b; font-size: 12px; font-family: Arial, Helvetica, sans-serif; text-align: left;\">{{body}}<\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>\r\n<\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>\r\n<table class=\"linked\" width=\"125\" align=\"right\">\r\n<tbody>\r\n<tr>\r\n<td style=\"padding: 14px; vertical-align: top;\" align=\"right\"><a title=\"Newsletter_Sponsored_Content\" href=\"{{image_link}}\"><img src=\"{{image}}\" alt=\"sponsor\" \/><\/a><\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>\r\n<\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>"}';
					} else if ( strpos( $fragment_type, 'Static_Image_1' ) !== false ) {
						$staticObj->Data = '{"image":"https:\/\/lastword.staging.wpengine.com\/wp-content\/uploads\/2017\/12\/FSA-Web-Banners.jpg","image_link":"https:\/\/addyourcustomlinkhere.com","dummy":"","source_code":"<table width=\"300\">\r\n<tr>\r\n<td>\r\n<a href=\"{{image_link}}\"><img src=\"{{image}}\" \/><\/a>\r\n<\/td>\r\n<\/tr>\r\n<\/table>"}';
					} else if ( strpos( $fragment_type, 'Static_Image_2' ) !== false ) {
						$staticObj->Data = '{"image":"https:\/\/lastword.staging.wpengine.com\/wp-content\/uploads\/2017\/12\/FSA-Web-Banners.jpg","image_link":"https:\/\/addyourcustomlinkhere.com","dummy":"","source_code":"<table width=\"300\">\r\n<tr>\r\n<td>\r\n<a href=\"{{image_link}}\"><img src=\"{{image}}\" \/><\/a>\r\n<\/td>\r\n<\/tr>\r\n<\/table>"}';
					} else if ( strpos( $fragment_type, 'Quotable' ) !== false ) {
						$staticObj->Data = '{"title":"Here is the title","subtitle":"Customise the subtitle","image":"https:\/\/lastword.staging.wpengine.com\/wp-content\/uploads\/2017\/12\/In-case-small.jpg","body":"This is the body","footer":"<a href=\"https:\/\/fundselectorasia.com\/\">A footer link<\/a>","dummy":"","source_code":"<p>\u00a0<\/p>\r\n<table class=\"fund_linked\" style=\"margin: 0px auto;\" border=\"0\" width=\"321\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td class=\"container_td\" style=\"padding: 0px 0px 8px; font-size: 20px; font-weight: normal; line-height: 16px; color: #2c2c2c !important; text-align: left;\"><font face=\"Arial, Helvetica, sans-serif\">{{title}}<\/font><\/td>\r\n<\/tr>\r\n<tr>\r\n<td>\r\n<table style=\"width: 100%; background-color: #f2f3f5;\" border=\"0\">\r\n<tbody>\r\n<tr>\r\n<td style=\"padding-left: 10px;\">\r\n<h3 style=\"text-align: center;\">{{subtitle}}<\/h3>\r\n<\/td>\r\n<\/tr>\r\n<tr>\r\n<td style=\"font-size: 14px; line-height: 20px; padding: 4px 10px; font-style: italic; color: #090909;\">\r\n<div class=\"center tinyimg_caption\" style=\"width: 297px;\">\r\n<div class=\"center tinyimg_caption\" style=\"width: 304px;\"><img src=\"{{image}}\" alt=\"\" \/><\/div>\r\n<\/div>\r\n<\/td>\r\n<\/tr>\r\n<tr>\r\n<td style=\"font-size: 14px; line-height: 20px; padding: 4px 10px; font-style: color: #090909;\">{{body}}<\/td>\r\n<\/tr>\r\n<tr>\r\n<td style=\"font-size: 14px; line-height: 20px; padding: 4px 10px; text-align: right;\">{{footer}}<\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>\r\n<\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>"}';
					}

					$static[] = $staticObj;
				}

				foreach ($static as $staticKey => $staticEntity) {
					if ( isset( $static[$staticKey] ) ) {
						if ( isset($static[$staticKey]->Version) && isset($static[$staticKey]->Data) && $static[$staticKey]->Version == 2 ) {
							$data = json_decode($static[$staticKey]->Data, true);
							$sourceCode = isset($data['source_code']) ? $data['source_code'] : '';

							if ( is_array($data) ) {
								foreach ( $data as $key => $value ) {
									if  ( 	( $key != 'image' ) && 
											( $key != 'left_box_image' ) && 
											( $key != 'right_box_image' ) &&
											strpos( $value, "\n" ) !== false 
										) {
											$value = wpautop($value);
									}

									$sourceCode = str_replace( '{{' . $key . '}}', $value, $sourceCode );
								}
							}

							if ( $g['type'] != 'Newsletter_Subscribe' && $g['type'] != 'Digital_Magazine' ) {
								$colors = array(
									'wp_2_' => '#69b42e',
									'wp_3_' => '#0095db',
									'wp_4_' => '#e40233',
									'wp_5_' => '#f9ae00'
								);

								$sourceCode = str_replace( '<a ', '<a style="color: ' . $colors[ $static[$staticKey]->Site ] . '" ', $sourceCode );
								$sourceCode = str_replace( '#4caf50', $colors[ $static[$staticKey]->Site ], $sourceCode );
							}
							
							$static[$staticKey]->Content = $sourceCode;
						}
					}	
				}

				echo json_encode($static);
			    exit();
			}
		}
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
				$email_subject = isset($json_result["subject"]) ? $json_result["subject"] : "";
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

				if(trim($email_subject) == "") {
					 $error = new WP_Error;
					 $error->add( "500", "The email subject cannot be empty." );
					 return $error;
				}

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

            	global $wpdb;
				$table_name_logs = 'wp_2_email_builder_logs';
				
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

					$name = preg_replace('/[[:^print:]]/', '', $name);
					$description = preg_replace('/[[:^print:]]/', '', $description);

					$wpdb->query("INSERT INTO " . $table_name_logs . " (Ref, Body, CreatedAt) VALUES ('campaign.create', " . addslashes(json_encode($new_campaign)) . "', '" . date('Y-m-d H:i:s') . "')");

				    $subject_line = $subject;
				    $subject_line = parse_special_chars_3($subject_line);

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
				    
					$r1 = $client->call( 'campaign.setAllOptions', $new_campaign['id'], [
																	'subject_line' => $subject_line,
						                                           	'domain' => $domain,
						                                           	'from_prefix' => $from_prefix,
						                                           	'user_from' => 1,
						                                           	'from_name' => $from_name,
						                                           	'from_address' => $from_address,
						                                           	'auto_tracking' => $auto_tracking,
						                                           	'unsub_list' => $unsub_list,
						                                           	'suppress_lists' => $suppress_lists,
						                                           	'user_reply' => 1,
						                                           	'reply_address' => 'subscriptions@lastwordmedia.com',
						                                           	'reply_name' => 'Subscriptions'
					                                           ]);
					
					$wpdb->query("INSERT INTO " . $table_name_logs . " (Ref, Body, CreatedAt) VALUES ('campaign.setAllOptions', '" . addslashes(json_encode($r1)) . "', '" . date('Y-m-d H:i:s') . "')");

					$html_content = $content;
					$html_content = parse_special_chars_2($html_content);

					$r2 = $client->call( 'campaign.setMessage', $new_campaign['id'], 'html' , $html_content);

					$wpdb->query("INSERT INTO " . $table_name_logs . " (Ref, Body, CreatedAt) VALUES ('campaign.setMessage', '" . addslashes(json_encode($r2)) . "', '" . date('Y-m-d H:i:s') . "')");

					//$client->call( 'campaign.setMessage', $new_campaign['id'], 'text' , $html_content);

					$r3 = $client->call( 'campaign.publish', $new_campaign['id']);

					$wpdb->query("INSERT INTO " . $table_name_logs . " (Ref, Body, CreatedAt) VALUES ('campaign.publish', '" . addslashes(json_encode($r3)) . "', '" . date('Y-m-d H:i:s') . "')");

                    //$launch_label = '2016-01-01 daily email';

					//$response = $client->call( 'campaign.launch', $new_campaign['id'], ['launch_label' => $launch_label]);

					$response = 'Ready at: ' . date('Y-m-d H:i:s');

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
            'callback' => function ($params) {
            		$join = '';
            		$where = '';

            		if ( $params['type'] != '1' ) {
						$join = "LEFT JOIN ".$params['prefix']."term_relationships tr ON ".$params['prefix']."posts.ID = tr.object_id 
								INNER JOIN ".$params['prefix']."term_taxonomy tt ON tt.term_taxonomy_id=tr.term_taxonomy_id 
								INNER JOIN ".$params['prefix']."terms t ON t.term_id = tt.term_id ";
	            		
	            		$where = "and t.term_id = ".$params['type']." ";
            		}

					global $wpdb;
					$posts= $wpdb->get_results("
							select * from ".$params['prefix']."posts " . $join . " where 1 = 1 " . $where . "
							and  ".$params['prefix']."posts.post_title like '%".$params['search']."%' 
							and ".$params['prefix']."posts.post_type='post' 
							and ".$params['prefix']."posts.post_status='publish' 
							order by ID desc
							LIMIT 10;
					");
			    foreach($posts as $row){ 
			    	$row->post_title = parse_special_chars($row->post_title);

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
			    	$row->post_title = parse_special_chars($row->post_title);

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
			    	$row->post_title = parse_special_chars($row->post_title);

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
			    	$row->post_title = parse_special_chars($row->post_title);

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
			    	$row->post_title = parse_special_chars($row->post_title);

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

				foreach ( $latest_portfolio as $key => $row ) {
					$latest_portfolio[ $key ]->post_title = parse_special_chars($row->post_title);
				}
				foreach ( $latest_international as $key => $row ) {
					$latest_international[ $key ]->post_title = parse_special_chars($row->post_title);
				}
				foreach ( $latest_fundselector as $key => $row ) {
					$latest_fundselector[ $key ]->post_title = parse_special_chars($row->post_title);
				}
				foreach ( $latest_expertinvestor as $key => $row ) {
					$latest_expertinvestor[ $key ]->post_title = parse_special_chars($row->post_title);
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

                $max = $wpdb->get_var("select option_value from ".$params['prefix']."options where option_name = 'most_read_days'");

              	$start_date = date('Y-m-d', strtotime('-' . ($max-1) . ' days'));

                // $posts = $wpdb->get_results("select ps.ID, ps.post_name, ps.post_title, ps.post_date, ps.post_excerpt, ps.guid, pm.meta_value from ".$params['prefix']."posts as ps inner join ".$params['prefix']."postmeta as pm on ps.ID = pm.post_id where pm.meta_key = 'lw_read_count' and ps.post_date > NOW() - INTERVAL " . $max . " DAY and post_type='post' and post_status='publish' order by convert(pm.meta_value, unsigned) DESC LIMIT 10 OFFSET ".$offset);

                $posts = $wpdb->get_results("select ps.ID, ps.post_name, ps.post_title, ps.post_date, ps.post_excerpt, ps.guid, pm.meta_value from ".$params['prefix']."posts as ps inner join ".$params['prefix']."postmeta as pm on ps.ID = pm.post_id where pm.meta_key = 'lw_read_count' and ps.post_date > '" . $start_date . "' and post_type='post' and post_status='publish' order by convert(pm.meta_value, unsigned) DESC LIMIT 10 OFFSET ".$offset);
                
                $count = $wpdb->get_results("select count(*) as count from ".$params['prefix']."posts as ps inner join ".$params['prefix']."postmeta as pm on ps.ID = pm.post_id where pm.meta_key = 'lw_read_count' and ps.post_date > '" . $start_date . "' and post_type='post' and post_status='publish' order by convert(pm.meta_value, unsigned)  DESC");

			    foreach($posts as $row){ 
			    	$row->post_title = parse_special_chars($row->post_title);

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

			    return (object)array($posts, $count[0]->count, $start_date);
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
						$posts[0]->post_title = parse_special_chars($posts[0]->post_title);

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
						$posts[0]->post_title = parse_special_chars($posts[0]->post_title);

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
						$posts[0]->post_title = parse_special_chars($posts[0]->post_title);

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
        wp_enqueue_script( 'plugin-scripts', plugins_url('js/main.326b3482.js', __FILE__),array(),  '0.0.1', true );
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


function parse_special_chars($str) {
	$str = str_replace('&amp;', '&', $str);
	$str = str_replace('—', '-', $str);
	$str = str_replace("€", "&euro;", $str);

	return $str;
}

function parse_special_chars_2($str) {
	$str = str_replace("€", "&euro;", $str);
	$str = str_replace("£", "&#8356;", $str);

	return $str;
}

function parse_special_chars_3($str) {
	$str = str_replace("€", "&#8364;", $str);
	$str = str_replace("£", "&#8356;", $str);

	return $str;
}
