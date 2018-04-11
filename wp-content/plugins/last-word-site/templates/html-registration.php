<?php

global $wpdb, $source;

// $query = $wpdb->prepare( 
        // "SELECT max( cast( user_id as UNSIGNED ) ) FROM {$wpdb->usermeta}");
		// $id =  $wpdb->get_var( $query );
		
/**
 * Define variables
 */
$title = isset($_POST['title'])?$_POST['title']:'';
$first_name = isset($_POST['first_name'])?$_POST['first_name']:'';
$last_name = isset($_POST['last_name'])?$_POST['last_name']:'';
$company_name = isset($_POST['company_name'])?$_POST['company_name']:'';
$job_title = isset($_POST['job_title'])?$_POST['job_title']:'';
$country = isset($_POST['country'])?$_POST['country']:'';
$direct_line = isset($_POST['direct_line'])?$_POST['direct_line']:'';
$company_type = isset($_POST['company_type'])?$_POST['company_type']:'';
$job_role = isset($_POST['job_role'])?$_POST['job_role']:'';
$job_level = isset($_POST['job_level'])?$_POST['job_level']:'';
$terms1 = isset($_POST['terms1'])?true:false;
$terms2 = isset($_POST['terms2'])?true:false;

$fullname = $first_name.' '.$last_name;
$email = isset($_POST['email'])?$_POST['email']:'';
$username = $email;
$password = isset($_POST['password'])?$_POST['password']:'';

$description  = "Company Name: {$company_name}"."\r\n";
$description .= "Company Type: {$company_type}"."\r\n";
$description .= "Job Role: {$job_role}"."\r\n";
$description .= "Job Level: {$job_level}"."\r\n";

$acticode = generateRandomString();
/**
 * Form submit
 */		
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				
	if(isset($_POST['btnsubmit']) || isset($_POST['btnmagazine'])){
		
		$userdata = array(
			'user_login'  =>  $username,
			'user_pass'   =>  $password,  // When creating an user, `user_pass` is expected.
			'first_name'  =>  $first_name,
			'last_name'  =>  $last_name,
			'user_email'  =>  $email,
			'display_name'  =>  trim($fullname)
		);

		$user_id = wp_insert_user($userdata);
		
		if( ! is_wp_error($user_id) ){

			// Send Mail
			$to = $email;
			$subject = "Last Word Media - Activate your account";

			$message = "<div><div><table border='0' width='900' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td width='600' height='10'>&nbsp;</td></tr></tbody></table><table border='0' width='902' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td width='600' height='30'><img class='CToWUd a6T' tabindex='0' src='https://ci4.googleusercontent.com/proxy/BB4mi8apoo50yX38HRSowH2i9vMeJpAUQun5QCE-G4CvDVPNAJ-GkqiPG1-7e8ndlyZV081UML4gi1vPYE8fIfMU4IYCpbCkZr-TO2CtPUdsGVg=s0-d-e1-ft#http://register.lastwordmedia.com/resource/images/pa_logo.png' alt='' width='400'/><div class='a6S' dir='ltr' style='opacity: 0.01; left: 594.5px; top: 276px;'>&nbsp;</div></td></tr></tbody></table><table border='0' width='900' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td width='600' height='40'>&nbsp;</td></tr></tbody></table><table border='0' width='902' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td width='602' height='30'><img class='CToWUd' src='https://ci3.googleusercontent.com/proxy/R36pm0nwR8hkff0lnNLJ3veuHtrUmoYwr3wqjkLpxd2Y5lrfuajmMgooA9l28i4hojbPjOWTc-XM9jZADYDmLfUTximFgf8RPsCJXff8IFSreA=s0-d-e1-ft#http://register.lastwordmedia.com/resource/images/header.gif' alt='' width='602'/></td></tr></tbody></table></div><table border='0' width='900' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='border: 1px solid #aaaaaa;' align='center' valign='middle' bgcolor='#ffffff' width='600'><div><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table style='text-align: center; border-collapse: collapse;' border='0' width='265' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td width='100%' height='40'>&nbsp;</td></tr></tbody></table></td></tr></tbody></table><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table style='text-align: center; border-collapse: collapse;' border='0' width='265' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='text-align: center; font-family: Georgia; font-size: 43px; color: #3d494f; line-height: 48px;' valign='middle' width='100%'><span style='font-family: Georgia; font-weight: normal;'><u></u>Thank you...<u></u></span></td></tr></tbody></table></td></tr></tbody></table><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table style='text-align: center; border-collapse: collapse;' border='0' width='265' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td width='100%' height='45'>&nbsp;</td></tr></tbody></table></td></tr></tbody></table><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table class='m_-4128639080679022530m_4445467294160584565mobile' border='0' width='500' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='background-color: #e1e1e1;' bgcolor='#e1e1e1' width='460'><table class='m_-4128639080679022530m_4445467294160584565full' border='0' width='430' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td width='100%' height='30'>&nbsp;</td></tr><tr><td style='text-align: center; font-family: Georgia; font-size: 30px; color: #3d494f; line-height: 34px;' valign='middle' width='100%'><span style='font-family: Georgia; font-weight: normal;'><u></u>...for registering for the Portfolio Adviser newsletter.<u></u></span></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table class='m_-4128639080679022530m_4445467294160584565mobile' border='0' width='500' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='background-color: #e1e1e1;' bgcolor='#e1e1e1' width='460'><table class='m_-4128639080679022530m_4445467294160584565full' border='0' width='440' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td width='100%' height='30'>&nbsp;</td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table class='m_-4128639080679022530m_4445467294160584565mobile' border='0' width='500' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='background-color: #e1e1e1;' align='center' bgcolor='#e1e1e1' width='460'><table class='m_-4128639080679022530m_4445467294160584565full' border='0' width='440' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='text-align: left; font-family: Georgia; font-size: 14px; color: #3d494f; line-height: 24px;' align='center' valign='middle' width='100%'><span style='font-family: Georgia; font-weight: normal;'> <u></u> Please click the below link to verify your email address and activate your account. You will then recieve the next Portfolio Adviser newsletter. <u></u> </span></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table class='m_-4128639080679022530m_4445467294160584565mobile' border='0' width='500' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='background-color: #e1e1e1;' bgcolor='#e1e1e1' width='460'><table class='m_-4128639080679022530m_4445467294160584565full' border='0' width='440' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='text-align: left; font-family: Georgia; font-size: 14px; color: #3d494f; line-height: 24px;' valign='middle' width='100%'><span style='font-family: Georgia; font-weight: normal;'> <u></u> <a style='color: #1d3f75;' href='" . get_site_url() . "/activate?acticode=" . $acticode . "&userid=" . $user_id . "'>Email Verify Link</a> <u></u> </span></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table class='m_-4128639080679022530m_4445467294160584565mobile' border='0' width='500' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='background-color: #e1e1e1;' bgcolor='#e1e1e1' width='460'><table class='m_-4128639080679022530m_4445467294160584565full' border='0' width='440' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='text-align: center; font-family: Georgia; font-size: 14px; color: #3d494f; line-height: 34px;' valign='middle' width='100%'><span style='font-family: Georgia; font-weight: normal;'> <u></u> <a style='color: #000000;' href='http://www.portfolio-adviser.com/' target='_blank' rel='noopener' data-saferedirecturl='https://www.google.com/url?hl=en&amp;q=http://www.portfolio-adviser.com/&amp;source=gmail&amp;ust=1506494154976000&amp;usg=AFQjCNG5jlPshzSSN9ul3e8-YemdNhq51Q'>www.portfolio-adviser.com</a> <u></u> </span></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table class='m_-4128639080679022530m_4445467294160584565mobile' border='0' width='500' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='background-color: #e1e1e1;' bgcolor='#e1e1e1' width='265'><table class='m_-4128639080679022530m_4445467294160584565full' border='0' width='240' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td width='100%' height='40'>&nbsp;</td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table class='m_-4128639080679022530m_4445467294160584565mobile' border='0' width='265' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td width='265' height='50'>&nbsp;</td></tr></tbody></table></td></tr></tbody></table></div></td><td valign='bottom' width='300' height='120'><img class='CToWUd' src='https://ci4.googleusercontent.com/proxy/wB8ielbN6xVrxavlNAHocxJh97IB1cZNyTc9KUdgwiZ4iY94vxXekfVBl8osgDV5DHQruRdBvtuM-27acURRo5kb9egeBy376Wc7NI5vvd-oUIdTqvkmFWE=s0-d-e1-ft#http://register.lastwordmedia.com/resource/images/LW_Logo_Black.png' alt='' width='300'/></td></tr></tbody></table><div><table border='0' width='900' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td width='600' height='30'>&nbsp;</td></tr></tbody></table><table border='0' width='900' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td width='600' height='50'>&nbsp;</td></tr><tr><td style='font-size: 1px; line-height: 1px;' width='600' height='1'>&nbsp;</td></tr></tbody></table></div></div><div><table border='0' width='900' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td width='600' height='30'>&nbsp;</td></tr></tbody></table><table border='0' width='900' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td width='600' height='25'>&nbsp;</td></tr><tr><td style='font-family: Georgia; font-size: 14px; line-height: 1px;' width='600' height='1'>Portfolio Adviser is published by Last Word Media Limited, Fleet House, <a href='https://maps.google.com/?q=1st+Floor,+59-61+Clerkenwell+Road,%0D+%0D+%0D+%0D+%0D+%0D+%0D+%0D+%0D+%0D+London,+EC1M+5LA,+United+Kingdom&amp;entry=gmail&amp;source=g'>1st Floor, 59-61 Clerkenwell Road,</a></td></tr></tbody></table><table border='0' width='900' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td width='600' height='15'>&nbsp;</td></tr><tr><td style='font-family: Georgia; font-size: 14px; line-height: 1px;' width='600' height='1'><a href='https://maps.google.com/?q=1st+Floor,+59-61+Clerkenwell+Road,%0D+%0D+%0D+%0D+%0D+%0D+%0D+%0D+%0D+%0D+London,+EC1M+5LA,+United+Kingdom&amp;entry=gmail&amp;source=g'>London, EC1M 5LA, United Kingdom</a>. Email: <a href='mailto:subscriptions@lastwordmedia.com' target='_blank' rel='noopener'>subscriptions@lastwordmedia.co<wbr/>m</a></td></tr></tbody></table><table border='0' width='900' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td width='600' height='30'>&nbsp;</td></tr><tr><td style='font-family: Georgia; font-size: 14px; line-height: 1px;' width='600' height='1'>Copyright &copy; 2017. All rights reserved. Company Reg. No. 05573633. VAT. No. 872 411 728.</td></tr></tbody></table><table border='0' width='900' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td width='600' height='30'>&nbsp;</td></tr><tr><td style='font-family: Georgia; font-size: 14px; line-height: 1px;' width='600' height='1'>Please do not reply to this email.</td></tr></tbody></table><div class='yj6qo'>&nbsp;</div><div class='adL'>&nbsp;</div></div>"

			$header = "From:Lastwordmedia@cms-lastwordmedia.com \r\n";
			// $header .= "Cc:afgh@somedomain.com \r\n";
			$header .= "MIME-Version: 1.0\r\n";
			$header .= "Content-type: text/html\r\n";

			$retval = mail ($to,$subject,$mesage,$header);
			
			/**
			 * Save wp user meta
			*/
			update_user_meta( $user_id, '_title', $title);
			update_user_meta( $user_id, '_job_title', $job_title);
			update_user_meta( $user_id, '_country', $country);
			update_user_meta( $user_id, '_direct_line', $direct_line);			
			update_user_meta( $user_id, '_company_name', $company_name);
			update_user_meta( $user_id, '_company_type', $company_type);
			update_user_meta( $user_id, '_job_role', $job_role);
			update_user_meta( $user_id, '_job_level', $job_level);
			update_user_meta( $user_id, '_description', $description);
			update_user_meta( $user_id, '_terms1', $terms1);
			update_user_meta( $user_id, '_terms2', $terms2);
			add_user_meta( $user_id, '_acticode', $acticode);
			
			$message = "<div class='msg success'>Thank You for registration. Please check your email address - <strong>" . $email ."</strong> for activation link.</div>";
			
			//reset variables
			$title = "";
			$first_name = "";
			$last_name = "";
			$company_name = "";
			$job_title = "";
			$country = "";
			$direct_line = "";
			$company_type = "";
			$job_role = "";
			$job_level = "";
			$terms1 = "";
			$terms2 = "";

			$fullname = "";
			$email = "";
			$username = "";
			$password = "";
			$description  = "";
			
			if(isset($_POST['btnmagazine'])){
				$redirect_url = site_url('/magazine-request/?id='.$user_id);
				wp_safe_redirect($redirect_url);
			?>
				<script>window.location='<?php echo $redirect_url ?>'</script>
			<?php
				die($redirect_url);
			}
		}else{
						
			$message='';
			foreach( $user_id->errors as $error ){
				foreach( $error as $text ){
					$message .= "<div class='msg error'>{$text}</span>"."\r\n";
				}
			}
		} 
	}
}

?>