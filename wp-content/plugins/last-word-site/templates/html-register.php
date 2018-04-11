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
$FSAtotalAUM = isset($_POST['FSAtotalAUM'])?$_POST['FSAtotalAUM']:'';
$FSANetWorth = isset($_POST['FSANetWorth'])?$_POST['FSANetWorth']:'';
$FSAratings = isset($_POST['FSAratings'])?$_POST['FSAratings']:'';
$FSAfirm = isset($_POST['FSAfirm'])?$_POST['FSAfirm']:'';

$description  = "Company Name: {$company_name}"."\r\n";
$description .= "Company Type: {$company_type}"."\r\n";
$description .= "Job Role: {$job_role}"."\r\n";
$description .= "Job Level: {$job_level}"."\r\n";

$FSAtick1 = isset($_POST['FSAtick'])?$_POST['FSAtick']:'';
$FSAtick2 = isset($_POST['FSAtick2'])?$_POST['FSAtick2']:'';
if ($FSAtick1 == 'Other') {
	$FSAtick = $FSAtick2;
} else {
	$FSAtick = $FSAtick1;
}

$FSAinstitype1 = isset($_POST['FSAinstitype'])?$_POST['FSAinstitype']:'';
$FSAinstitype2 = isset($_POST['FSAinstitype2'])?$_POST['FSAinstitype2']:'';
if ($FSAinstitype1 == 'Other') {
	$FSAinstitype = $FSAinstitype2;
} else {
	$FSAinstitype = $FSAinstitype1;
}
/**
 * Form submit
 */		
if ($_SERVER['REQUEST_METHOD'] === 'POST') {			

		$acticode = generateRandomString();
		
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

			$websiteId = get_current_blog_id();

			switch( $websiteId ){
				case 2: // PA
					$header = "From:noreply@portfolio-adviser.com \r\n"; 
					$mailimage = "http://register.lastwordmedia.com/resource/images/pa_logo.png";
					$sitename = "Portfolio Adviser";
					$sitelink = "www.portfolio-adviser.com";
					break;
				case 3: // IA
					$header = "From:noreply@international-adviser.com \r\n"; 
					$mailimage = "http://register.lastwordmedia.com/resource/images/ia_logo.png";
					$sitename = "International Adviser";
					$sitelink = "www.international-adviser.com";
					break;
				case 4: // FSA
					$newsletterId = strtolower('43238BCE-8985-E711-80FA-00155DD1690D'); // FSA
					$header = "From:noreply@fundselectorasia.com \r\n"; 
					$mailimage = "http://register.lastwordmedia.com/resource/images/fsa_logo.png";
					$sitename = "Fund Selector Asia";
					$sitelink = "www.fundselectorasia.com";
					break;
				case 5: // EI
					$header = "From:noreply@expertinvestoreurope.com \r\n"; 
					$mailimage = "https://ei.cms-lastwordmedia.com/wp-content/themes/lw_expert_inv/images/logo.png";
					$sitename = "Expert Investor";
					$sitelink = "www.expertinvestoreurope.com";
					break;
				default: 
					$header = "From:noreply@lastwordmedia.com \r\n";
					$mailimage = "http://register.lastwordmedia.com/resource/images/pa_logo.png";
					$sitelink = 'www.lastwordmedia.com/';			
					break;
			}

				$siteurl = get_site_url();
				// Send Mail
				$to = $email;
				$subject = "Your activation link";
				if ($websiteId != 4) {
					$mesage = "<div><table style='width: 600px;' border='0' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='width: 600px;' height='10'>&nbsp;</td></tr></tbody></table><table style='width: 600px;' border='0' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='width: 600px;' height='30'><img class='CToWUd a6T' tabindex='0' src='$mailimage' alt='' width='250'/><div class='a6S' dir='ltr' style='opacity: 0.01; left: 594.5px; top: 276px;'>&nbsp;</div></td></tr></tbody></table><table border='0' width='600' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td width='600' height='40'>&nbsp;</td></tr></tbody></table><table border='0' width='600' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td width='600' height='30'><img class='CToWUd' style='border: 1px solid #000;' src='https://ci3.googleusercontent.com/proxy/R36pm0nwR8hkff0lnNLJ3veuHtrUmoYwr3wqjkLpxd2Y5lrfuajmMgooA9l28i4hojbPjOWTc-XM9jZADYDmLfUTximFgf8RPsCJXff8IFSreA=s0-d-e1-ft#http://register.lastwordmedia.com/resource/images/header.gif' alt='' width='600'/></td></tr></tbody></table><table style='height: 604px; width: 600px;' border='0' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='border: 1px solid #aaaaaa; width: 600px;' align='center' valign='middle' bgcolor='#ffffff'><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table style='text-align: center; border-collapse: collapse;' border='0' width='265' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td width='100%' height='40'>&nbsp;</td></tr></tbody></table></td></tr></tbody></table><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table style='text-align: center; border-collapse: collapse;' border='0' width='265' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='text-align: center; font-family: Georgia; font-size: 43px; color: #3d494f; line-height: 48px;' valign='middle' width='100%'><span style='font-family: Georgia; font-weight: normal;'><u></u>Thank you...<u></u></span></td></tr></tbody></table></td></tr></tbody></table><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table style='text-align: center; border-collapse: collapse;' border='0' width='265' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td width='100%' height='45'>&nbsp;</td></tr></tbody></table></td></tr></tbody></table><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table class='m_-8421831432318242686m_4445467294160584565mobile' border='0' width='500' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='background-color: #e1e1e1;' bgcolor='#e1e1e1' width='460'><table class='m_-8421831432318242686m_4445467294160584565full' border='0' width='430' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td width='100%' height='30'>&nbsp;</td></tr><tr><td style='text-align: center; font-family: Georgia; font-size: 30px; color: #3d494f; line-height: 34px;' valign='middle' width='100%'><span style='font-family: Georgia; font-weight: normal;'><u></u>...for registering for the $sitename newsletter.<u></u></span></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table class='m_-8421831432318242686m_4445467294160584565mobile' border='0' width='500' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='background-color: #e1e1e1;' bgcolor='#e1e1e1' width='460'><table class='m_-8421831432318242686m_4445467294160584565full' border='0' width='440' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td width='100%' height='30'>&nbsp;</td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table class='m_-8421831432318242686m_4445467294160584565mobile' border='0' width='500' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='background-color: #e1e1e1;' align='center' bgcolor='#e1e1e1' width='460'><table class='m_-8421831432318242686m_4445467294160584565full' border='0' width='440' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='text-align: left; font-family: Georgia; font-size: 14px; color: #3d494f; line-height: 24px;' align='center' valign='middle' width='100%'><span style='font-family: Georgia; font-weight: normal;'> <u></u> Please click the below link to verify your email address and activate your account. You will then recieve the next $sitename newsletter. <u></u> </span></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table class='m_-8421831432318242686m_4445467294160584565mobile' border='0' width='500' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='background-color: #e1e1e1;' bgcolor='#e1e1e1' width='460'><table class='m_-8421831432318242686m_4445467294160584565full' border='0' width='440' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='text-align: left; font-family: Georgia; font-size: 14px; color: #3d494f; line-height: 24px;' valign='middle' width='100%'><a style='color:#1d3f75' href='$siteurl/activate?acticode=$acticode&userid=$user_id'><p>Email Verify Link</p></a><p>Once you have activated your account you can apply for the $sitename magazine</p></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table class='m_-8421831432318242686m_4445467294160584565mobile' border='0' width='500' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='background-color: #e1e1e1;' bgcolor='#e1e1e1' width='460'><table class='m_-8421831432318242686m_4445467294160584565full' border='0' width='440' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='text-align: center; font-family: Georgia; font-size: 14px; color: #3d494f; line-height: 34px;' valign='middle' width='100%'><span style='font-family: Georgia; font-weight: normal;'> <u></u> <a style='color: #000000;' href='http://$sitelink' target='_blank' rel='noopener'>$sitelink</a> <u></u> </span></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table class='m_-8421831432318242686m_4445467294160584565mobile' border='0' width='500' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='background-color: #e1e1e1;' bgcolor='#e1e1e1' width='265'><table class='m_-8421831432318242686m_4445467294160584565full' border='0' width='240' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td width='100%' height='40'>&nbsp;</td></tr></tbody></table></td></tr></td></tr><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600' ><table class='m_-8421831432318242686m_4445467294160584565mobile' style='width: 496.5px;' border='0' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='width: 502.5px; font-family: Georgia; font-size: 14px; line-height: 24px;' height='50'><p>&nbsp;</p><img class='CToWUd' style='float: right;' src='https://ci4.googleusercontent.com/proxy/wB8ielbN6xVrxavlNAHocxJh97IB1cZNyTc9KUdgwiZ4iY94vxXekfVBl8osgDV5DHQruRdBvtuM-27acURRo5kb9egeBy376Wc7NI5vvd-oUIdTqvkmFWE=s0-d-e1-ft#http://register.lastwordmedia.com/resource/images/LW_Logo_Black.png' alt='' width='130' height='51'/>$sitename is published by Last Word Media Limited, Fleet House, 1st Floor, 59-61 Clerkenwell Road, London, EC1M 5LA, United Kingdom.<p><span style='font-weight: 400; font-family: Georgia; font-size: 14px; line-height: 24px;'></span></p><p><span style='font-weight: 400; font-family: Georgia; font-size: 14px; line-height: 24px;'>Email: subscriptions@lastwordmedia.com </span></p><p><span style='font-family: Georgia; font-size: 14px; line-height: 24px; font-weight: 400;'>Copyright &copy; 2017. All rights reserved. Company Reg. No. 05573633. VAT. No. 872 411 728.</span></p><p><span style='font-weight: 400; font-family: Georgia; font-size: 14px; line-height: 24px;'>Please do not reply to this email. </span></p></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><div>&nbsp;</div><div>&nbsp;</div></div><p>&nbsp;</p>";
				} else {
					$mesage = "<div><table style='width: 600px;' border='0' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='width: 600px;' height='10'>&nbsp;</td></tr></tbody></table><table style='width: 600px;' border='0' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='width: 600px;' height='30'><img class='CToWUd a6T' tabindex='0' src='$mailimage' alt='' width='250'/><div class='a6S' dir='ltr' style='opacity: 0.01; left: 594.5px; top: 276px;'>&nbsp;</div></td></tr></tbody></table><table border='0' width='600' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td width='600' height='40'>&nbsp;</td></tr></tbody></table><table border='0' width='600' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td width='600' height='30'><img class='CToWUd' style='border: 1px solid #000;' src='https://ci3.googleusercontent.com/proxy/R36pm0nwR8hkff0lnNLJ3veuHtrUmoYwr3wqjkLpxd2Y5lrfuajmMgooA9l28i4hojbPjOWTc-XM9jZADYDmLfUTximFgf8RPsCJXff8IFSreA=s0-d-e1-ft#http://register.lastwordmedia.com/resource/images/header.gif' alt='' width='600'/></td></tr></tbody></table><table style='height: 604px; width: 600px;' border='0' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='border: 1px solid #aaaaaa; width: 600px;' align='center' valign='middle' bgcolor='#ffffff'><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table style='text-align: center; border-collapse: collapse;' border='0' width='265' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td width='100%' height='40'>&nbsp;</td></tr></tbody></table></td></tr></tbody></table><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table style='text-align: center; border-collapse: collapse;' border='0' width='265' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='text-align: center; font-family: Georgia; font-size: 43px; color: #3d494f; line-height: 48px;' valign='middle' width='100%'><span style='font-family: Georgia; font-weight: normal;'><u></u>Thank you...<u></u></span></td></tr></tbody></table></td></tr></tbody></table><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table style='text-align: center; border-collapse: collapse;' border='0' width='265' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td width='100%' height='45'>&nbsp;</td></tr></tbody></table></td></tr></tbody></table><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table class='m_-8421831432318242686m_4445467294160584565mobile' border='0' width='500' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='background-color: #e1e1e1;' bgcolor='#e1e1e1' width='460'><table class='m_-8421831432318242686m_4445467294160584565full' border='0' width='430' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td width='100%' height='30'>&nbsp;</td></tr><tr><td style='text-align: center; font-family: Georgia; font-size: 30px; color: #3d494f; line-height: 34px;' valign='middle' width='100%'><span style='font-family: Georgia; font-weight: normal;'><u></u>...for registering for the $sitename newsletter.<u></u></span></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table class='m_-8421831432318242686m_4445467294160584565mobile' border='0' width='500' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='background-color: #e1e1e1;' bgcolor='#e1e1e1' width='460'><table class='m_-8421831432318242686m_4445467294160584565full' border='0' width='440' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td width='100%' height='30'>&nbsp;</td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table class='m_-8421831432318242686m_4445467294160584565mobile' border='0' width='500' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='background-color: #e1e1e1;' align='center' bgcolor='#e1e1e1' width='460'><table class='m_-8421831432318242686m_4445467294160584565full' border='0' width='440' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='text-align: left; font-family: Georgia; font-size: 14px; color: #3d494f; line-height: 24px;' align='center' valign='middle' width='100%'><span style='font-family: Georgia; font-weight: normal;'> <u></u> Please click the below link to verify your email address and activate your account. You will then recieve the next $sitename newsletter. <u></u> </span></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table class='m_-8421831432318242686m_4445467294160584565mobile' border='0' width='500' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='background-color: #e1e1e1;' bgcolor='#e1e1e1' width='460'><table class='m_-8421831432318242686m_4445467294160584565full' border='0' width='440' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='text-align: left; font-family: Georgia; font-size: 14px; color: #3d494f; line-height: 24px;' valign='middle' width='100%'><a style='color:#1d3f75' href='$siteurl/activate?acticode=$acticode&userid=$user_id'><p>Email Verify Link</p></a></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table class='m_-8421831432318242686m_4445467294160584565mobile' border='0' width='500' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='background-color: #e1e1e1;' bgcolor='#e1e1e1' width='460'><table class='m_-8421831432318242686m_4445467294160584565full' border='0' width='440' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='text-align: center; font-family: Georgia; font-size: 14px; color: #3d494f; line-height: 34px;' valign='middle' width='100%'><span style='font-family: Georgia; font-weight: normal;'> <u></u> <a style='color: #000000;' href='http://$sitelink' target='_blank' rel='noopener'>$sitelink</a> <u></u> </span></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table class='m_-8421831432318242686m_4445467294160584565mobile' border='0' width='500' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='background-color: #e1e1e1;' bgcolor='#e1e1e1' width='265'><table class='m_-8421831432318242686m_4445467294160584565full' border='0' width='240' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td width='100%' height='40'>&nbsp;</td></tr></tbody></table></td></tr></td></tr><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table class='m_-8421831432318242686m_4445467294160584565mobile' style='width: 496.5px;' border='0' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='width: 502.5px; font-family: Georgia; font-size: 14px; line-height: 24px;' height='50'><p>&nbsp;</p><img class='CToWUd' style='float: right;' src='https://ci4.googleusercontent.com/proxy/wB8ielbN6xVrxavlNAHocxJh97IB1cZNyTc9KUdgwiZ4iY94vxXekfVBl8osgDV5DHQruRdBvtuM-27acURRo5kb9egeBy376Wc7NI5vvd-oUIdTqvkmFWE=s0-d-e1-ft#http://register.lastwordmedia.com/resource/images/LW_Logo_Black.png' alt='' width='130' height='51'/>$sitename is published by Last Word Media Limited, Fleet House, 1st Floor, 59-61 Clerkenwell Road, London, EC1M 5LA, United Kingdom.<p><span style='font-weight: 400;'></span></p><p><span style='font-weight: 400; font-family: Georgia; font-size: 14px; line-height: 24px;'>Email: subscriptions@lastwordmedia.com </span></p><p><span style='font-weight: 400; font-family: Georgia; font-size: 14px; line-height: 24px;'>Copyright &copy; 2017. All rights reserved. Company Reg. No. 05573633. VAT. No. 872 411 728.</span></p><p><span style='font-weight: 400; font-family: Georgia; font-size: 14px; line-height: 24px;'>Please do not reply to this email. </span></p></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><div>&nbsp;</div><div>&nbsp;</div></div><p>&nbsp;</p>";
				}
				
			}
		
			// $header .= "Cc:afgh@somedomain.com \r\n";
			$header .= "MIME-Version: 1.0\r\n";
			$header .= "Content-type: text/html\r\n";

			$retval = wp_mail($to,$subject,$mesage,$header);
			
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
			add_user_meta( $user_id, '_FSAtotalAum', $FSAtotalAUM);
			add_user_meta( $user_id, '_FSANetWorth', $FSANetWorth);
			add_user_meta( $user_id, '_FSAratings', $FSAratings);
			add_user_meta( $user_id, '_FSAfirm', $FSAfirm);
			add_user_meta( $user_id, '_FSAtick', $FSAtick);
			add_user_meta( $user_id, '_FSAinstitype', $FSAinstitype);

			$message = "<div class='msg success'><p>Thank you for your newsletter registration. You will shortly receive an email from " . $sitename . " that has been sent to <strong>" . $email ."</strong>.";

			if ($websiteId != 4) { 
				$message .= " Click on the activation link within the email to start your newsletter subscription.</p><p>Once you have done this you can apply for the " . $sitename . " Magazine.</p></div>";
			} else {
			 	$message .= "</div>";
			}

			
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

		} else {
						
			$message='';
			foreach( $user_id->errors as $error ){
				foreach( $error as $text ){
					$message .= "<div class='msg error' style='color: #f00;'>{$text}</div>"."\r\n";
				}
		} 
	}

?>

<div class="msg-wrap">
<?php echo isset($message)?$message:''; ?>
</div>

<?php if ( is_wp_error($user_id) || $_SERVER['REQUEST_METHOD'] !== 'POST') { 

$websiteId = get_current_blog_id();

			switch( $websiteId ){
				case 2: // PA
					$header = "From:noreply@portfolio-adviser.com \r\n"; 
					$mailimage = "http://register.lastwordmedia.com/resource/images/pa_logo.png";
					$sitename = 'Portfolio Adviser';
					$privacy = 'http://www.portfolio-adviser.com/privacy-policy';
					break;
				case 3: // IA
					$header = "From:noreply@international-adviser.com \r\n"; 
					$mailimage = "http://register.lastwordmedia.com/resource/images/ia_logo.png";
					$sitename = 'International Adviser';
					$privacy = 'http://www.international-adviser.com/privacy-policy';
					break;
				case 4: // FSA
					$header = "From:noreply@fundselectorasia.com \r\n"; 
					$mailimage = "http://register.lastwordmedia.com/resource/images/fsa_logo.png";
					$sitename = 'Fund Selector Asia';
					$privacy = 'http://www.fundselectorasia.com/privacy-policy';
					break;
				case 5: // EI
					$header = "From:noreply@expertinvestoreurope.com \r\n"; 
					$mailimage = "https://ei.cms-lastwordmedia.com/wp-content/themes/lw_expert_inv/images/logo.png";
					$sitename = 'Expert Investor';
					$privacy = 'http://www.expertinvestoreurope.com/privacy-policy';
					break;
				default: 
					$header = "From:noreply@lastwordmedia.com \r\n";
					$mailimage = "http://register.lastwordmedia.com/resource/images/pa_logo.png";			
					break;
			}
?>


<?php $websiteId = get_current_blog_id(); 
if ($websiteId == 4) { ?>

<form name="register" id="req-magazine" action="" method="post">
<div class="req-magazine">
	<h3 style="display:none;">Progress</h3>
	<section>
	<p>To sign up to the <?php echo $sitename; ?> website and receive daily email news bulletins complete the form below. <?php if ($websiteId != 4) { ?>You can then apply to receive the monthly <?php echo $sitename; ?> magazine by answering some short questions about your role. <?php } else { /**/ } ?></p>

		<p><select name="title" style="width:100%;" required>
				<option value="" selected="selected" disabled>Title*</option>
				<option <?php selected($title, "Mr") ?> value="Mr">Mr</option>
				<option <?php selected($title, "Miss") ?> value="Miss">Miss</option>
				<option <?php selected($title, "Mrs") ?> value="Mrs">Mrs</option>
				<option <?php selected($title, "Ms") ?> value="Ms">Ms</option>
				<option <?php selected($title, "Dr") ?> value="Dr">Dr</option>
				<option <?php selected($title, "Prof") ?> value="Prof">Prof</option>
			</select>
		</p>
		<p><input type="text" name="first_name" title="Please enter your name." id="first_name" pattern="[A-Za-z]{2,}" value="<?php echo $first_name ?>" placeholder="First name*" required /></p>
		<p><input type="text" name="last_name" value="<?php echo $last_name ?>" placeholder="Last name*" required /></p>
		<p><input type="text" name="company_name" value="<?php echo $company_name ?>" placeholder="Company name*" required /></p>
		<p><input type="text" name="job_title" value="<?php echo $job_title ?>" placeholder="Job title*" required /></p>
		<p><select name="country" style="width:100%;" required>
				<option value="">Country*</option>
				<option <?php selected($country, "Afghanistan") ?> value="Afghanistan">Afghanistan</option>
				<option <?php selected($country, "Albania") ?> value="Albania">Albania</option>
				<option <?php selected($country, "Algeria") ?> value="Algeria">Algeria</option>
				<option <?php selected($country, "Angola") ?> value="Angola">Angola</option>
				<option <?php selected($country, "Argentina") ?> value="Argentina">Argentina</option>
				<option <?php selected($country, "Australia") ?> value="Australia">Australia</option>
				<option <?php selected($country, "Austria") ?> value="Austria">Austria</option>
				<option <?php selected($country, "Azerbaijan") ?> value="Azerbaijan">Azerbaijan</option>
				<option <?php selected($country, "Bahamas") ?> value="Bahamas">Bahamas</option>
				<option <?php selected($country, "Bahrain") ?> value="Bahrain">Bahrain</option>
				<option <?php selected($country, "Bangladesh") ?> value="Bangladesh">Bangladesh</option>
				<option <?php selected($country, "Barbados") ?> value="Barbados">Barbados</option>
				<option <?php selected($country, "Belarus") ?> value="Belarus">Belarus</option>
				<option <?php selected($country, "Belgium") ?> value="Belgium">Belgium</option>
				<option <?php selected($country, "Bolivia") ?> value="Bolivia">Bolivia</option>
				<option <?php selected($country, "Bosnia and Herzegovina") ?> value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
				<option <?php selected($country, "Botswana") ?> value="Botswana">Botswana</option>
				<option <?php selected($country, "Brazil") ?> value="Brazil">Brazil</option>
				<option <?php selected($country, "Bulgaria") ?> value="Bulgaria">Bulgaria</option>
				<option <?php selected($country, "Cambodia") ?> value="Cambodia">Cambodia</option>
				<option <?php selected($country, "Cameroon") ?> value="Cameroon">Cameroon</option>
				<option <?php selected($country, "Canada") ?> value="Canada">Canada</option>
				<option <?php selected($country, "Central African Republic") ?> value="Central African Republic">Central African Republic</option>
				<option <?php selected($country, "Chile") ?> value="Chile">Chile</option>
				<option <?php selected($country, "China") ?> value="China">China</option>
				<option <?php selected($country, "Colombia") ?> value="Colombia">Colombia</option>
				<option <?php selected($country, "Costa Rica") ?> value="Costa Rica">Costa Rica</option>
				<option <?php selected($country, "Croatia") ?> value="Croatia">Croatia</option>
				<option <?php selected($country, "Cuba") ?> value="Cuba">Cuba</option>
				<option <?php selected($country, "Cyprus") ?> value="Cyprus">Cyprus</option>
				<option <?php selected($country, "Czech Republic") ?> value="Czech Republic">Czech Republic</option>
				<option <?php selected($country, "Denmark") ?> value="Denmark">Denmark</option>
				<option <?php selected($country, "Ecuador") ?> value="Ecuador">Ecuador</option>
				<option <?php selected($country, "Egypt") ?> value="Egypt">Egypt</option>
				<option <?php selected($country, "El Salvador") ?> value="El Salvador">El Salvador</option>
				<option <?php selected($country, "Estonia") ?> value="Estonia">Estonia</option>
				<option <?php selected($country, "Ethiopia") ?> value="Ethiopia">Ethiopia</option>
				<option <?php selected($country, "Finland") ?> value="Finland">Finland</option>
				<option <?php selected($country, "France") ?> value="France">France</option>
				<option <?php selected($country, "Gambia") ?> value="Gambia">Gambia</option>
				<option <?php selected($country, "Georgia") ?> value="Georgia">Georgia</option>
				<option <?php selected($country, "Germany") ?> value="Germany">Germany</option>
				<option <?php selected($country, "Ghana") ?> value="Ghana">Ghana</option>
				<option <?php selected($country, "Greece") ?> value="Greece">Greece</option>
				<option <?php selected($country, "Greenland") ?> value="Greenland">Greenland</option>
				<option <?php selected($country, "Haiti") ?> value="Haiti">Haiti</option>
				<option <?php selected($country, "Honduras") ?> value="Honduras">Honduras</option>
				<option <?php selected($country, "Hong Kong") ?> value="Hong Kong">Hong Kong</option>
				<option <?php selected($country, "Hungary") ?> value="Hungary">Hungary</option>
				<option <?php selected($country, "Iceland") ?> value="Iceland">Iceland</option>
				<option <?php selected($country, "India") ?> value="India">India</option>
				<option <?php selected($country, "Indonesia") ?> value="Indonesia">Indonesia</option>
				<option <?php selected($country, "Iran") ?> value="Iran">Iran</option>
				<option <?php selected($country, "Ireland") ?> value="Ireland">Ireland</option>
				<option <?php selected($country, "Israel") ?> value="Israel">Israel</option>
				<option <?php selected($country, "Italy") ?> value="Italy">Italy</option>
				<option <?php selected($country, "Ivory Coast") ?> value="Ivory Coast">Ivory Coast</option>
				<option <?php selected($country, "Jamaica") ?> value="Jamaica">Jamaica</option>
				<option <?php selected($country, "Japan") ?> value="Japan">Japan</option>
				<option <?php selected($country, "Jordan") ?> value="Jordan">Jordan</option>
				<option <?php selected($country, "Kazakhstan") ?> value="Kazakhstan">Kazakhstan</option>
				<option <?php selected($country, "Kenya") ?> value="Kenya">Kenya</option>
				<option <?php selected($country, "Kuwait") ?> value="Kuwait">Kuwait</option>
				<option <?php selected($country, "Laos") ?> value="Laos">Laos</option>
				<option <?php selected($country, "Latvia") ?> value="Latvia">Latvia</option>
				<option <?php selected($country, "Lebanon") ?> value="Lebanon">Lebanon</option>
				<option <?php selected($country, "Liberia") ?> value="Liberia">Liberia</option>
				<option <?php selected($country, "Libya") ?> value="Libya">Libya</option>
				<option <?php selected($country, "Liechtenstein") ?> value="Liechtenstein">Liechtenstein</option>
				<option <?php selected($country, "Lithuania") ?> value="Lithuania">Lithuania</option>
				<option <?php selected($country, "Luxembourg") ?> value="Luxembourg">Luxembourg</option>
				<option <?php selected($country, "Macedonia") ?> value="Macedonia">Macedonia</option>
				<option <?php selected($country, "Madagascar") ?> value="Madagascar">Madagascar</option>
				<option <?php selected($country, "Malawi") ?> value="Malawi">Malawi</option>
				<option <?php selected($country, "Malaysia") ?> value="Malaysia">Malaysia</option>
				<option <?php selected($country, "Mali") ?> value="Mali">Mali</option>
				<option <?php selected($country, "Malta") ?> value="Malta">Malta</option>
				<option <?php selected($country, "Mauritius") ?> value="Mauritius">Mauritius</option>
				<option <?php selected($country, "Mexico") ?> value="Mexico">Mexico</option>
				<option <?php selected($country, "Moldova") ?> value="Moldova">Moldova</option>
				<option <?php selected($country, "Mongolia") ?> value="Mongolia">Mongolia</option>
				<option <?php selected($country, "Montenegro") ?> value="Montenegro">Montenegro</option>
				<option <?php selected($country, "Morocco") ?> value="Morocco">Morocco</option>
				<option <?php selected($country, "Mozambique") ?> value="Mozambique">Mozambique</option>
				<option <?php selected($country, "Myanmar") ?> value="Myanmar">Myanmar</option>
				<option <?php selected($country, "Namibia") ?> value="Namibia">Namibia</option>
				<option <?php selected($country, "Nepal") ?> value="Nepal">Nepal</option>
				<option <?php selected($country, "Netherlands") ?> value="Netherlands">Netherlands</option>
				<option <?php selected($country, "New Zealand") ?> value="New Zealand">New Zealand</option>
				<option <?php selected($country, "Nicaragua") ?> value="Nicaragua">Nicaragua</option>
				<option <?php selected($country, "Nigeria") ?> value="Nigeria">Nigeria</option>
				<option <?php selected($country, "Norway") ?> value="Norway">Norway</option>
				<option <?php selected($country, "Oman") ?> value="Oman">Oman</option>
				<option <?php selected($country, "Pakistan") ?> value="Pakistan">Pakistan</option>
				<option <?php selected($country, "Panama") ?> value="Panama">Panama</option>
				<option <?php selected($country, "Papua New Guinea") ?> value="Papua New Guinea">Papua New Guinea</option>
				<option <?php selected($country, "Paraguay") ?> value="Paraguay">Paraguay</option>
				<option <?php selected($country, "Peru") ?> value="Peru">Peru</option>
				<option <?php selected($country, "Philippines") ?> value="Philippines">Philippines</option>
				<option <?php selected($country, "Poland") ?> value="Poland">Poland</option>
				<option <?php selected($country, "Portugal") ?> value="Portugal">Portugal</option>
				<option <?php selected($country, "Qatar") ?> value="Qatar">Qatar</option>
				<option <?php selected($country, "Romania") ?> value="Romania">Romania</option>
				<option <?php selected($country, "Russian Federation") ?> value="Russian Federation">Russian Federation</option>
				<option <?php selected($country, "Rwanda") ?> value="Rwanda">Rwanda</option>
				<option <?php selected($country, "Saudi Arabia") ?> value="Saudi Arabia">Saudi Arabia</option>
				<option <?php selected($country, "Senegal") ?> value="Senegal">Senegal</option>
				<option <?php selected($country, "Serbia") ?> value="Serbia">Serbia</option>
				<option <?php selected($country, "Sierra Leone") ?> value="Sierra Leone">Sierra Leone</option>
				<option <?php selected($country, "Singapore") ?> value="Singapore">Singapore</option>
				<option <?php selected($country, "Slovakia") ?> value="Slovakia">Slovakia</option>
				<option <?php selected($country, "Slovenia") ?> value="Slovenia">Slovenia</option>
				<option <?php selected($country, "South Africa") ?> value="South Africa">South Africa</option>
				<option <?php selected($country, "South Korea") ?> value="South Korea">South Korea</option>
				<option <?php selected($country, "Spain") ?> value="Spain">Spain</option>
				<option <?php selected($country, "Sri Lanka") ?> value="Sri Lanka">Sri Lanka</option>
				<option <?php selected($country, "Sudan") ?> value="Sudan">Sudan</option>
				<option <?php selected($country, "Swaziland") ?> value="Swaziland">Swaziland</option>
				<option <?php selected($country, "Sweden") ?> value="Sweden">Sweden</option>
				<option <?php selected($country, "Switzerland") ?> value="Switzerland">Switzerland</option>
				<option <?php selected($country, "Syria") ?> value="Syria">Syria</option>
				<option <?php selected($country, "Taiwan") ?> value="Taiwan">Taiwan</option>
				<option <?php selected($country, "Tanzania") ?> value="Tanzania">Tanzania</option>
				<option <?php selected($country, "Thailand") ?> value="Thailand">Thailand</option>
				<option <?php selected($country, "Togo") ?> value="Togo">Togo</option>
				<option <?php selected($country, "Trinidad and Tobago") ?> value="Trinidad and Tobago">Trinidad and Tobago</option>
				<option <?php selected($country, "Tunisia") ?> value="Tunisia">Tunisia</option>
				<option <?php selected($country, "Turkey") ?> value="Turkey">Turkey</option>
				<option <?php selected($country, "Uganda") ?> value="Uganda">Uganda</option>
				<option <?php selected($country, "Ukraine") ?> value="Ukraine">Ukraine</option>
				<option <?php selected($country, "United Arab Emirates") ?> value="United Arab Emirates">United Arab Emirates</option>
				<option <?php selected($country, "UK") ?> value="UK">United Kingdom</option>
				<option <?php selected($country, "Uruguay") ?> value="Uruguay">Uruguay</option>
				<option <?php selected($country, "Uzbekistan") ?> value="Uzbekistan">Uzbekistan</option>
				<option <?php selected($country, "Venezuela") ?> value="Venezuela">Venezuela</option>
				<option <?php selected($country, "Vietnam") ?> value="Vietnam">Vietnam</option>
				<option <?php selected($country, "Yemen") ?> value="Yemen">Yemen</option>
				<option <?php selected($country, "Zambia") ?> value="Zambia">Zambia</option>
		</select></p>
		<p><input type="text" name="direct_line" id="direct_line" title="Please add a valid telephone number."  pattern="[0-9\+]{6,}" value="<?php echo $direct_line ?>" placeholder="Direct line*" required /></p>
		<p><select name="company_type" style="width:100%;" required>
				<option value="" selected="selected" disabled>Company type*</option>
				<option <?php selected($company_type, "Asset Management Company") ?> value="Asset Management">Asset Management Company</option>
				<option <?php selected($company_type, "Bank") ?> value="Bank">Bank</option>
				<option <?php selected($company_type, "Discretionary Portfolio Management Company") ?> value="Discretionary portfolio management">Discretionary Portfolio Management Company </option>
				<option <?php selected($company_type, "Wealth Management") ?> value="Wealth Management">Wealth Management</option>
				<option <?php selected($company_type, "Financial Advisor Company") ?> value="Financial Adviser">Financial Advisor Company </option>
				<option <?php selected($company_type, "Independent Financial Advisor") ?> value="Financial Adviser">Independent Financial Advisor</option>
				<option <?php selected($company_type, "Investment Research Company") ?> value="Investment Fund">Investment Research Company</option>
				<option <?php selected($company_type, "International Life Company") ?> value="International Life Company">International Life Company</option>
				<option <?php selected($company_type, "Institution / Pension Company") ?> value="Institutional">Institution / Pension Company</option>
				<option <?php selected($company_type, "Law Firm") ?> value="Law Firm">Law Firm</option>
				<option <?php selected($company_type, "Private Bank") ?> value="Private Bank">Private Bank</option>
				<option <?php selected($company_type, "Trust Company") ?> value="Trust Company">Trust Company</option>
			</select>
		</p>
		<p><select name="job_role" style="width:100%;" required>
				<option value="" selected="selected" disabled>Job role*</option>
				<option <?php selected($job_role, "Independent Financial Advisor") ?> value="Independent Financial Adviser">Independent Financial Advisor</option>
				<option <?php selected($job_role, "Financial Advisor") ?> value="Financial Advisor">Financial Advisor</option>
				<option <?php selected($job_role, "Wealth Manager") ?> value="Wealth Manager">Wealth Manager</option>
				<option <?php selected($job_role, "Multi-Manager") ?> value="Multi-Manager">Multi-Manager</option>
				<option <?php selected($job_role, "Discretionary Portfolio Manager") ?> value="Discretionary Portfolio Manager">Discretionary Portfolio Manager</option>
				<option <?php selected($job_role, "Private Banker") ?> value="Private Banker">Private Banker</option>
				<option <?php selected($job_role, "Accountant") ?> value="Accountant">Accountant</option>
				<option <?php selected($job_role, "Trustee") ?> value="Trustee">Trustee</option>
				<option <?php selected($job_role, "Consulting Actuary") ?> value="Consulting Actuary">Consulting Actuary</option>
				<option <?php selected($job_role, "Investment Researcher/Analyst") ?> value="Investment Researcher/Analyst">Investment Researcher/Analyst</option>
				<option <?php selected($job_role, "Family Office Employee") ?> value="Family Office Employee">Family Office Employee</option>
				<option <?php selected($job_role, "Life Company Employee") ?> value="Life Company Employee">Life Company Employee</option>
				<option <?php selected($job_role, "Private Client Lawyer") ?> value="Private Client Lawyer">Private Client Lawyer</option>
				<option <?php selected($job_role, "Portfolio Manager") ?> value="Portfolio Manager">Portfolio Manager</option>
				<option <?php selected($job_role, "Fund of Funds Manager") ?> value="Fund of Funds Manager">Fund of Funds Manager</option>
				<option <?php selected($job_role, "Distributor") ?> value="Distributor">Distributor</option>
				<option <?php selected($job_role, "Consultant") ?> value="Consultant">Consultant</option>
				<option <?php selected($job_role, "Advisor") ?> value="Advisor">Advisor</option>
				<option <?php selected($job_role, "Fund Selection") ?> value="Fund Selector">Fund Selection</option>
				<option <?php selected($job_role, "Research") ?> value="Research">Research</option>
			</select>
		</p>
		<p><select name="job_level" style="width:100%;" required>
				<option value="" selected="selected" disabled>Job level*</option>
				<option <?php selected($job_level, "Associate") ?> value="Associate">Associate</option>
				<option <?php selected($job_level, "CEO/President/Chairmen") ?> value="CEO/President/Chairmen">CEO/President/Chairmen</option>
				<option <?php selected($job_level, "Consultant") ?> value="Consultant">Consultant</option>
				<option <?php selected($job_level, "Exec Management (EVP/SVP/MD)") ?> value="Exec Management (EVP/SVP/MD)">Exec Management (EVP/SVP/MD)</option>
				<option <?php selected($job_level, "Manager/Supervisor") ?> value="Manager/Supervisor">Manager/Supervisor</option>
				<option <?php selected($job_level, "Other C-Level") ?> value="Other C-Level">Other C-Level</option>
				<option <?php selected($job_level, "Owner/Partner/Proprietor") ?> value="Owner/Partner/Proprietor">Owner/Partner/Proprietor</option>
				<option <?php selected($job_level, "Project Manager") ?> value="Project Manager">Project Manager</option>
				<option <?php selected($job_level, "Secretary/Treasurer") ?> value="Secretary/Treasurer">Secretary/Treasurer</option>
				<option <?php selected($job_level, "Senior Manager/Dept. Head") ?> value="Senior Manager/Dept. Head">Senior Manager/Dept. Head</option>
				<option <?php selected($job_level, "Technical Business Specialist") ?> value="Technical Business Specialist">Technical Business Specialist</option>
				<option <?php selected($job_level, "VP Director") ?> value="VP Director">VP Director</option>
			</select>
		</p>
		<p><input type="email" name="email" value="<?php echo $email ?>" placeholder="Email*" required /></p>
		<p><input type="password" name="password" value="<?php echo $password ?>" placeholder="Password*" required /></p>


		<p class="privacy">Thank you for your details. We take your privacy very seriously and whilst we are providing professional business services, we respect the rights of individuals under data protection law. We abide by the data protection laws of all countries in which we operate. We collect personal data about you to provide you with the services or products you have expressed interest in, to tell you about other products and services we believe may be of interest to you.</p>

		<p><input type="checkbox" name="terms2" required <?php checked( $terms2, 1 ) ?>>
			<span>I accept the <a href="/terms-and-conditions/" target="blank_">Terms and Conditions *</a></span>
		</p>

		<p class="privacy">We also work with carefully selected partners, third parties. These organisations can provide you with relevant information about goods, services or events which we feel will be of interest.</p>

		<p><input type="checkbox" name="terms1" <?php checked( $terms1, 1 ) ?>>
			<span>Please tick this box to receive selected contact from our third parties.</span>
		</p>

		<p class="privacy">To manage your communication preferences, follow the instructions in the footer of future emails you are sent from <?php echo $sitename; ?>.</p>

		<p class="privacy">More information on how we manage personal data and your rights including how to contact us, may be found <a href="<?php echo $privacy; ?>">here</a>.</p>

	</section>
	
	<h3 style="display:none;">Progress 1</h3>
	<section>
		<p><strong>1) Which type of institution do you work for?</strong></p>
		<p><input type="radio" name="FSAinstitype" value="Family Office" required> <label> Family Office </label></p>
		<p><input type="radio" name="FSAinstitype" value="Financial Advisor" required> <label> Financial Advisor </label></p>
		<p><input type="radio" name="FSAinstitype" value="Fund of Funds" required> <label> Fund of Funds </label></p>
		<p><input type="radio" name="FSAinstitype" value="Hedge & PE Fund" required> <label> Hedge & PE Fund </label></p>
		<p><input type="radio" name="FSAinstitype" value="Institutional Investor" required> <label> Institutional Investor </label></p>
		<p><input type="radio" name="FSAinstitype" value="Insurance & Life Company" required> <label> Insurance & Life Company </label></p>
		<p><input type="radio" name="FSAinstitype" value="Private bank" required> <label> Private bank </label></p>
		<p><input type="radio" name="FSAinstitype" value="Retail Bank" required> <label> Retail Bank </label></p>
		<p><input type="radio" name="FSAinstitype" value="Wealth Manager" required> <label> Wealth Manager </label></p>
		<p><input type="radio" name="FSAinstitype" value="Asset Manager" required> <label> Asset Manager </label></p>
		<p><input type="radio" name="FSAinstitype" value="Life Office" required> <label> Life Office </label></p>
		<p><input type="radio" name="FSAinstitype" value="Insurance Firm" required> <label> Insurance Firm </label></p>
		<p><input type="radio" name="FSAinstitype" value="PE / Hedge Fund" required> <label> PE / Hedge Fund </label></p>
		<p><input type="radio" name="FSAinstitype" value="Other" id="other" required> <label> Other </label></p>
		<p><input type="text" name="FSAinstitype2" id="other-value" placeholder="(please specify)" style="display:none"></p>
	</section>	

	<h3 style="display:none;">Progress 2</h3>
	<section>
		<p><strong>2) Are you a: (tick most relevant box)? </strong></p>
		<p><input type="radio" name="FSAtick" value="Independent financial adviser" required> <label> Independent financial adviser </label></p>
		<p><input type="radio" name="FSAtick" value="Discretionary portfolio manager" required> <label> Discretionary portfolio manager </label></p>
		<p><input type="radio" name="FSAtick" value="Private client stockbroker" required> <label> Private client stockbroker </label></p>
		<p><input type="radio" name="FSAtick" value="Private client lawyer" required> <label> Private client lawyer </label></p>
		<p><input type="radio" name="FSAtick" value="Private banker" required> <label> Private banker </label></p>
		<p><input type="radio" name="FSAtick" value="Accountant" required> <label> Accountant </label></p>
		<p><input type="radio" name="FSAtick" value="Trustee" required> <label> Trustee </label></p>
		<p><input type="radio" name="FSAtick" value="Consulting actuary" required> <label> Consulting actuary </label></p>
		<p><input type="radio" name="FSAtick" value="Investment researcher/analyst" required> <label> Investment researcher/analyst </label></p>
		<p><input type="radio" name="FSAtick" value="Life company employee" required> <label> Life company employee </label></p>
		<p><input type="radio" name="FSAtick" value="Other" id="other2" required> <label> Other </label></p>
		<p><input type="text" name="FSAtick2" id="other-value2" placeholder="(please specify)" style="display:none"></p>
	</section>	

	<h3 style="display:none;">Progress 3</h3>
	<section>
		<p><strong>3) What is your company’s total AUM? </strong></p>
		<p><input type="radio" name="FSAtotalAUM" value="Up to $10m" required> <label> Up to $10m </label></p>
		<p><input type="radio" name="FSAtotalAUM" value="from $10m to $100m" required> <label> from $10m to $100m </label></p>
		<p><input type="radio" name="FSAtotalAUM" value="from $100m to $1bn" required> <label> from $100m to $1bn </label></p>
		<p><input type="radio" name="FSAtotalAUM" value="$1bn+" required> <label> $1bn+ </label></p>
		<p><input type="radio" name="FSAtotalAUM" value="Not applicable" required> <label> Not applicable </label></p>
	</section>	

	<h3 style="display:none;">Progress 4</h3>
	<section>
		<p><strong>4) What is the average net worth of your clients: </strong></p>
		<p><input type="radio" name="FSANetWorth" value="Less than $1m" required> <label> Less than $1m </label></p>
		<p><input type="radio" name="FSANetWorth" value="from $1m to $5m" required> <label> from $1m to $5m </label></p>
		<p><input type="radio" name="FSANetWorth" value="from $5m to $10m" required> <label> from $5m to $10m </label></p>
		<p><input type="radio" name="FSANetWorth" value="from $10m to $100" required> <label> from $10m to $100 </label></p>
		<p><input type="radio" name="FSANetWorth" value="$100m+" required> <label> $100m+ </label></p>
		<p><input type="radio" name="FSANetWorth" value="Not applicable" required> <label> Not applicable </label></p>
	</section>	

	<h3 style="display:none;">Progress 5</h3>
	<section>
		<p><strong>5) Which of the following fund ratings do you use? </strong></p>
		<p><input type="radio" name="FSAratings" value="Standard & Poor’s (qual)" required> <label> Standard & Poor’s (qual) </label></p>
		<p><input type="radio" name="FSAratings" value="OBSR (qual)" required> <label> OBSR (qual) </label></p>
		<p><input type="radio" name="FSAratings" value="Morningstar qualitative ratings (qual)" required> <label> Morningstar qualitative ratings (qual) </label></p>
		<p><input type="radio" name="FSAratings" value="Morningstar stars (quants)" required> <label> Morningstar stars (quants) </label></p>
		<p><input type="radio" name="FSAratings" value="Financial Express Crowns (quants)" required> <label> Financial Express Crowns (quants) </label></p>
		<p><input type="radio" name="FSAratings" value="Lipper (quants)" required> <label> Lipper (quants) </label></p>
		<p><input type="radio" name="FSAratings" value="Citywire (quant)" required> <label> Citywire (quant) </label></p>
		<p><input type="radio" name="FSAratings" value="Trustnet Alpha Manager (quants)" required> <label> Trustnet Alpha Manager (quants) </label></p>
		<p><input type="radio" name="FSAratings" value="Not applicable" required> <label> Not applicable </label></p>
	</section>	

	<h3 style="display:none;">Progress 6</h3>
	<section>
		<p><strong>6) Is your firm: </strong></p>
		<p><input type="radio" name="FSAfirm" value="Part of a global firm in Asia" required> <label> Part of a global firm in Asia </label></p>
		<p><input type="radio" name="FSAfirm" value="An Asian firm" required> <label> An Asian firm </label></p>
		<p><input type="radio" name="FSAfirm" value="A firm outside of Asia with plans to set up in Asia" required> <label> A firm outside of Asia with plans to set up in Asia </label></p>		
	</section>

</div>
</form>

<script>
	var form = jQuery("#req-magazine");
	form.validate({
		errorPlacement: function errorPlacement(error, element) { 
		if (element.attr("type") == "checkbox" || element.attr("type") == "radio") {
			element.before(error); 
		} else {
			element.after(error); 
		}

		},
		rules: {
			confirm: {
				equalTo: "#password"
			},
			first_name: {
				minlength: 2
				    },
			direct_line: {
				digits: true			
			}
		},
		messages: {
		    first_name: {
		      required: "Please enter your name.",
		      minlenght: "Please enter your name."
		    },
		    direct_line: {
		    	required: "Please add a valid telephone number",
				digits: "Please add a valid telephone number"			
			}
	  	}
	});

	form.children("div.req-magazine").steps({
		headerTag: "h3",
		bodyTag: "section",
		transitionEffect: "none",
		onStepChanging: function (event, currentIndex, newIndex)
		{
			form.validate().settings.ignore = ":disabled,:hidden";
			return form.valid();
		},
		onStepChanged: function (event, currentIndex, priorIndex)
		{
			jQuery(window).scrollTop(0);
		},
		onFinishing: function (event, currentIndex)
		{
			form.validate().settings.ignore = ":disabled";
			return form.valid();
		},
		onFinished: function (event, currentIndex)
		{
			document.getElementById("req-magazine").submit();
			// alert("Submitted!");
			// return form.valid();
		}
	});
	
	jQuery(document).ready(function(){
		jQuery('input[type="radio"]').click(function() {
		   if(jQuery(this).attr('id') == 'other') {
				jQuery('#other-value').show();           
		   }

		   else {
				jQuery('#other-value').hide();   
		   }
		});

		jQuery('input[type="radio"]').click(function() {
		   if(jQuery(this).attr('id') == 'other2') {
				jQuery('#other-value2').show();           
		   }

		   else {
				jQuery('#other-value2').hide();   
		   }
		});
		
	});
</script>

<style>
	form#req-magazine .steps{
		display: none;
	}
	form#req-magazine .actions ul{
		display: inline-flex;
		list-style-type: none;
	}
	form#req-magazine .actions ul li{
		display: block;
		list-style-type: none;
		margin-left: 0;
		margin-right: 10px;
	}
	
	form#req-magazine .actions ul li a{
		border: 1px solid #ccc;
		padding: 10px 20px;
	}

	form#req-magazine .actions ul li a:hover{
		color: #fff;
		background: #e40233;
	}
	
	form#req-magazine .actions ul li.disabled {
		display: none;
	}
	
	form#req-magazine label.error {
		display: block;
		margin-top: 10px;
		color: #f00;
	}

	form#req-magazine input.error {
		border: 2px solid #f00;
	}

	form[name="register"] input[type="radio"], form[name="register"] input[type="checkbox"]{
    	width: unset!important;
    }

   form[name="register"] {
	  margin-top: 30px!important;
  	  width: 70%!important;
	}

	form[name="register"] select,form[name="register"] input {
	  margin-bottom: 10px!important;
	  width: 100%!important;
	  border: 1px solid rgba(0, 0, 0, 0.1)!important;
	  background-color: #fff;
	  font-weight: normal;
	  font-size: 100%;
	}

	form[name="register"] input {
	  padding: 10px!important;
	}

	form[name="register"] input::placeholder {
	  opacity: 1!important;
	  color: #000000!important;
	}

	form[name="register"] input:focus::placeholder {
	  opacity: 0.3!important;
	}

	form[name="register"] input[type="checkbox"],form[name="register"] input[type="submit"] {
	  width: auto!important;
	}

	form[name="register"] input[type="submit"] {
	  padding: 10px 20px!important;
	}
	
	li.disabled {
		display: none;
	}
</style>

<?php } else { ?>
<p>To sign up to the <?php echo $sitename; ?> website and receive daily email news bulletins complete the form below. <?php if ($websiteId != 4) { ?>You can then apply to receive the<?php if ($websiteId == 5) { ?> quarterly <?php } else { ?> monthly <?php } ?><?php echo $sitename; ?><?php if ($websiteId == 3) { ?> regional digital<?php } ?> magazine by answering some short questions about your role. <?php if ($websiteId == 2) { ?> Magazine subscriptions are available free to active financial advisers who qualify.<?php }} else { /**/ } ?></p>

<form name="register" action="" id="registerform" method="post">
<p><select name="title" style="width:100%;" required>
		<option value="" selected="selected" disabled>Title*</option>
		<option <?php selected($title, "Mr") ?> value="Mr">Mr</option>
		<option <?php selected($title, "Miss") ?> value="Miss">Miss</option>
		<option <?php selected($title, "Mrs") ?> value="Mrs">Mrs</option>
		<option <?php selected($title, "Ms") ?> value="Ms">Ms</option>
		<option <?php selected($title, "Dr") ?> value="Dr">Dr</option>
		<option <?php selected($title, "Prof") ?> value="Prof">Prof</option>
	</select>
</p>
<p><input type="text" name="first_name" pattern="[A-Za-z]{2,}" title="Please enter your name." value="<?php echo $first_name ?>" placeholder="First name*" required /></p>
<p><input type="text" name="last_name" value="<?php echo $last_name ?>" placeholder="Last name*" required /></p>
<p><input type="text" name="company_name" value="<?php echo $company_name ?>" placeholder="Company name*" required /></p>
<p><input type="text" name="job_title" value="<?php echo $job_title ?>" placeholder="Job title*" required /></p>
<p><select name="country" style="width:100%;" required>
		<option value="">Country*</option>
		<option <?php selected($country, "Afghanistan") ?> value="Afghanistan">Afghanistan</option>
		<option <?php selected($country, "Albania") ?> value="Albania">Albania</option>
		<option <?php selected($country, "Algeria") ?> value="Algeria">Algeria</option>
		<option <?php selected($country, "Angola") ?> value="Angola">Angola</option>
		<option <?php selected($country, "Argentina") ?> value="Argentina">Argentina</option>
		<option <?php selected($country, "Australia") ?> value="Australia">Australia</option>
		<option <?php selected($country, "Austria") ?> value="Austria">Austria</option>
		<option <?php selected($country, "Azerbaijan") ?> value="Azerbaijan">Azerbaijan</option>
		<option <?php selected($country, "Bahamas") ?> value="Bahamas">Bahamas</option>
		<option <?php selected($country, "Bahrain") ?> value="Bahrain">Bahrain</option>
		<option <?php selected($country, "Bangladesh") ?> value="Bangladesh">Bangladesh</option>
		<option <?php selected($country, "Barbados") ?> value="Barbados">Barbados</option>
		<option <?php selected($country, "Belarus") ?> value="Belarus">Belarus</option>
		<option <?php selected($country, "Belgium") ?> value="Belgium">Belgium</option>
		<option <?php selected($country, "Bolivia") ?> value="Bolivia">Bolivia</option>
		<option <?php selected($country, "Bosnia and Herzegovina") ?> value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
		<option <?php selected($country, "Botswana") ?> value="Botswana">Botswana</option>
		<option <?php selected($country, "Brazil") ?> value="Brazil">Brazil</option>
		<option <?php selected($country, "Bulgaria") ?> value="Bulgaria">Bulgaria</option>
		<option <?php selected($country, "Cambodia") ?> value="Cambodia">Cambodia</option>
		<option <?php selected($country, "Cameroon") ?> value="Cameroon">Cameroon</option>
		<option <?php selected($country, "Canada") ?> value="Canada">Canada</option>
		<option <?php selected($country, "Central African Republic") ?> value="Central African Republic">Central African Republic</option>
		<option <?php selected($country, "Chile") ?> value="Chile">Chile</option>
		<option <?php selected($country, "China") ?> value="China">China</option>
		<option <?php selected($country, "Colombia") ?> value="Colombia">Colombia</option>
		<option <?php selected($country, "Costa Rica") ?> value="Costa Rica">Costa Rica</option>
		<option <?php selected($country, "Croatia") ?> value="Croatia">Croatia</option>
		<option <?php selected($country, "Cuba") ?> value="Cuba">Cuba</option>
		<option <?php selected($country, "Cyprus") ?> value="Cyprus">Cyprus</option>
		<option <?php selected($country, "Czech Republic") ?> value="Czech Republic">Czech Republic</option>
		<option <?php selected($country, "Denmark") ?> value="Denmark">Denmark</option>
		<option <?php selected($country, "Ecuador") ?> value="Ecuador">Ecuador</option>
		<option <?php selected($country, "Egypt") ?> value="Egypt">Egypt</option>
		<option <?php selected($country, "El Salvador") ?> value="El Salvador">El Salvador</option>
		<option <?php selected($country, "Estonia") ?> value="Estonia">Estonia</option>
		<option <?php selected($country, "Ethiopia") ?> value="Ethiopia">Ethiopia</option>
		<option <?php selected($country, "Finland") ?> value="Finland">Finland</option>
		<option <?php selected($country, "France") ?> value="France">France</option>
		<option <?php selected($country, "Gambia") ?> value="Gambia">Gambia</option>
		<option <?php selected($country, "Georgia") ?> value="Georgia">Georgia</option>
		<option <?php selected($country, "Germany") ?> value="Germany">Germany</option>
		<option <?php selected($country, "Ghana") ?> value="Ghana">Ghana</option>
		<option <?php selected($country, "Greece") ?> value="Greece">Greece</option>
		<option <?php selected($country, "Greenland") ?> value="Greenland">Greenland</option>
		<option <?php selected($country, "Haiti") ?> value="Haiti">Haiti</option>
		<option <?php selected($country, "Honduras") ?> value="Honduras">Honduras</option>
		<option <?php selected($country, "Hong Kong") ?> value="Hong Kong">Hong Kong</option>
		<option <?php selected($country, "Hungary") ?> value="Hungary">Hungary</option>
		<option <?php selected($country, "Iceland") ?> value="Iceland">Iceland</option>
		<option <?php selected($country, "India") ?> value="India">India</option>
		<option <?php selected($country, "Indonesia") ?> value="Indonesia">Indonesia</option>
		<option <?php selected($country, "Iran") ?> value="Iran">Iran</option>
		<option <?php selected($country, "Ireland") ?> value="Ireland">Ireland</option>
		<option <?php selected($country, "Israel") ?> value="Israel">Israel</option>
		<option <?php selected($country, "Italy") ?> value="Italy">Italy</option>
		<option <?php selected($country, "Ivory Coast") ?> value="Ivory Coast">Ivory Coast</option>
		<option <?php selected($country, "Jamaica") ?> value="Jamaica">Jamaica</option>
		<option <?php selected($country, "Japan") ?> value="Japan">Japan</option>
		<option <?php selected($country, "Jordan") ?> value="Jordan">Jordan</option>
		<option <?php selected($country, "Kazakhstan") ?> value="Kazakhstan">Kazakhstan</option>
		<option <?php selected($country, "Kenya") ?> value="Kenya">Kenya</option>
		<option <?php selected($country, "Kuwait") ?> value="Kuwait">Kuwait</option>
		<option <?php selected($country, "Laos") ?> value="Laos">Laos</option>
		<option <?php selected($country, "Latvia") ?> value="Latvia">Latvia</option>
		<option <?php selected($country, "Lebanon") ?> value="Lebanon">Lebanon</option>
		<option <?php selected($country, "Liberia") ?> value="Liberia">Liberia</option>
		<option <?php selected($country, "Libya") ?> value="Libya">Libya</option>
		<option <?php selected($country, "Liechtenstein") ?> value="Liechtenstein">Liechtenstein</option>
		<option <?php selected($country, "Lithuania") ?> value="Lithuania">Lithuania</option>
		<option <?php selected($country, "Luxembourg") ?> value="Luxembourg">Luxembourg</option>
		<option <?php selected($country, "Macedonia") ?> value="Macedonia">Macedonia</option>
		<option <?php selected($country, "Madagascar") ?> value="Madagascar">Madagascar</option>
		<option <?php selected($country, "Malawi") ?> value="Malawi">Malawi</option>
		<option <?php selected($country, "Malaysia") ?> value="Malaysia">Malaysia</option>
		<option <?php selected($country, "Mali") ?> value="Mali">Mali</option>
		<option <?php selected($country, "Malta") ?> value="Malta">Malta</option>
		<option <?php selected($country, "Mauritius") ?> value="Mauritius">Mauritius</option>
		<option <?php selected($country, "Mexico") ?> value="Mexico">Mexico</option>
		<option <?php selected($country, "Moldova") ?> value="Moldova">Moldova</option>
		<option <?php selected($country, "Mongolia") ?> value="Mongolia">Mongolia</option>
		<option <?php selected($country, "Montenegro") ?> value="Montenegro">Montenegro</option>
		<option <?php selected($country, "Morocco") ?> value="Morocco">Morocco</option>
		<option <?php selected($country, "Mozambique") ?> value="Mozambique">Mozambique</option>
		<option <?php selected($country, "Myanmar") ?> value="Myanmar">Myanmar</option>
		<option <?php selected($country, "Namibia") ?> value="Namibia">Namibia</option>
		<option <?php selected($country, "Nepal") ?> value="Nepal">Nepal</option>
		<option <?php selected($country, "Netherlands") ?> value="Netherlands">Netherlands</option>
		<option <?php selected($country, "New Zealand") ?> value="New Zealand">New Zealand</option>
		<option <?php selected($country, "Nicaragua") ?> value="Nicaragua">Nicaragua</option>
		<option <?php selected($country, "Nigeria") ?> value="Nigeria">Nigeria</option>
		<option <?php selected($country, "Norway") ?> value="Norway">Norway</option>
		<option <?php selected($country, "Oman") ?> value="Oman">Oman</option>
		<option <?php selected($country, "Pakistan") ?> value="Pakistan">Pakistan</option>
		<option <?php selected($country, "Panama") ?> value="Panama">Panama</option>
		<option <?php selected($country, "Papua New Guinea") ?> value="Papua New Guinea">Papua New Guinea</option>
		<option <?php selected($country, "Paraguay") ?> value="Paraguay">Paraguay</option>
		<option <?php selected($country, "Peru") ?> value="Peru">Peru</option>
		<option <?php selected($country, "Philippines") ?> value="Philippines">Philippines</option>
		<option <?php selected($country, "Poland") ?> value="Poland">Poland</option>
		<option <?php selected($country, "Portugal") ?> value="Portugal">Portugal</option>
		<option <?php selected($country, "Qatar") ?> value="Qatar">Qatar</option>
		<option <?php selected($country, "Romania") ?> value="Romania">Romania</option>
		<option <?php selected($country, "Russian Federation") ?> value="Russian Federation">Russian Federation</option>
		<option <?php selected($country, "Rwanda") ?> value="Rwanda">Rwanda</option>
		<option <?php selected($country, "Saudi Arabia") ?> value="Saudi Arabia">Saudi Arabia</option>
		<option <?php selected($country, "Senegal") ?> value="Senegal">Senegal</option>
		<option <?php selected($country, "Serbia") ?> value="Serbia">Serbia</option>
		<option <?php selected($country, "Sierra Leone") ?> value="Sierra Leone">Sierra Leone</option>
		<option <?php selected($country, "Singapore") ?> value="Singapore">Singapore</option>
		<option <?php selected($country, "Slovakia") ?> value="Slovakia">Slovakia</option>
		<option <?php selected($country, "Slovenia") ?> value="Slovenia">Slovenia</option>
		<option <?php selected($country, "South Africa") ?> value="South Africa">South Africa</option>
		<option <?php selected($country, "South Korea") ?> value="South Korea">South Korea</option>
		<option <?php selected($country, "Spain") ?> value="Spain">Spain</option>
		<option <?php selected($country, "Sri Lanka") ?> value="Sri Lanka">Sri Lanka</option>
		<option <?php selected($country, "Sudan") ?> value="Sudan">Sudan</option>
		<option <?php selected($country, "Swaziland") ?> value="Swaziland">Swaziland</option>
		<option <?php selected($country, "Sweden") ?> value="Sweden">Sweden</option>
		<option <?php selected($country, "Switzerland") ?> value="Switzerland">Switzerland</option>
		<option <?php selected($country, "Syria") ?> value="Syria">Syria</option>
		<option <?php selected($country, "Taiwan") ?> value="Taiwan">Taiwan</option>
		<option <?php selected($country, "Tanzania") ?> value="Tanzania">Tanzania</option>
		<option <?php selected($country, "Thailand") ?> value="Thailand">Thailand</option>
		<option <?php selected($country, "Togo") ?> value="Togo">Togo</option>
		<option <?php selected($country, "Trinidad and Tobago") ?> value="Trinidad and Tobago">Trinidad and Tobago</option>
		<option <?php selected($country, "Tunisia") ?> value="Tunisia">Tunisia</option>
		<option <?php selected($country, "Turkey") ?> value="Turkey">Turkey</option>
		<option <?php selected($country, "Uganda") ?> value="Uganda">Uganda</option>
		<option <?php selected($country, "Ukraine") ?> value="Ukraine">Ukraine</option>
		<option <?php selected($country, "United Arab Emirates") ?> value="United Arab Emirates">United Arab Emirates</option>
		<option <?php selected($country, "UK") ?> value="UK">United Kingdom</option>
		<option <?php selected($country, "Uruguay") ?> value="Uruguay">Uruguay</option>
		<option <?php selected($country, "Uzbekistan") ?> value="Uzbekistan">Uzbekistan</option>
		<option <?php selected($country, "Venezuela") ?> value="Venezuela">Venezuela</option>
		<option <?php selected($country, "Vietnam") ?> value="Vietnam">Vietnam</option>
		<option <?php selected($country, "Yemen") ?> value="Yemen">Yemen</option>
		<option <?php selected($country, "Zambia") ?> value="Zambia">Zambia</option>
</select></p>
<p><input type="text" name="direct_line" pattern="[0-9\+]{6,}" title="Please add a valid telephone number." value="<?php echo $direct_line ?>" placeholder="Direct line*" required /></p>
<p><select name="company_type" style="width:100%;" required>
		<option value="" selected="selected" disabled>Company type*</option>
		<option <?php selected($company_type, "Asset Management Company") ?> value="Asset Management">Asset Management Company</option>
		<option <?php selected($company_type, "Bank") ?> value="Bank">Bank</option>
		<option <?php selected($company_type, "Discretionary Portfolio Management Company") ?> value="Discretionary portfolio management">Discretionary Portfolio Management Company </option>
		<option <?php selected($company_type, "Wealth Management") ?> value="Wealth Management">Wealth Management</option>
		<option <?php selected($company_type, "Financial Advisor Company") ?> value="Financial Adviser">Financial Advisor Company </option>
		<option <?php selected($company_type, "Independent Financial Advisor") ?> value="Financial Adviser">Independent Financial Advisor</option>
		<option <?php selected($company_type, "Investment Research Company") ?> value="Investment Fund">Investment Research Company</option>
		<option <?php selected($company_type, "International Life Company") ?> value="International Life Company">International Life Company</option>
		<option <?php selected($company_type, "Institution / Pension Company") ?> value="Institutional">Institution / Pension Company</option>
		<option <?php selected($company_type, "Law Firm") ?> value="Law Firm">Law Firm</option>
		<option <?php selected($company_type, "Private Bank") ?> value="Private Bank">Private Bank</option>
		<option <?php selected($company_type, "Trust Company") ?> value="Trust Company">Trust Company</option>
	</select>
</p>
<p><select name="job_role" style="width:100%;" required>
		<option value="" selected="selected" disabled>Job role*</option>
		<option <?php selected($job_role, "Independent Financial Advisor") ?> value="Independent Financial Adviser">Independent Financial Advisor</option>
		<option <?php selected($job_role, "Financial Advisor") ?> value="Financial Advisor">Financial Advisor</option>
		<option <?php selected($job_role, "Wealth Manager") ?> value="Wealth Manager">Wealth Manager</option>
		<option <?php selected($job_role, "Multi-Manager") ?> value="Multi-Manager">Multi-Manager</option>
		<option <?php selected($job_role, "Discretionary Portfolio Manager") ?> value="Discretionary Portfolio Manager">Discretionary Portfolio Manager</option>
		<option <?php selected($job_role, "Private Banker") ?> value="Private Banker">Private Banker</option>
		<option <?php selected($job_role, "Accountant") ?> value="Accountant">Accountant</option>
		<option <?php selected($job_role, "Trustee") ?> value="Trustee">Trustee</option>
		<option <?php selected($job_role, "Consulting Actuary") ?> value="Consulting Actuary">Consulting Actuary</option>
		<option <?php selected($job_role, "Investment Researcher/Analyst") ?> value="Investment Researcher/Analyst">Investment Researcher/Analyst</option>
		<option <?php selected($job_role, "Family Office Employee") ?> value="Family Office Employee">Family Office Employee</option>
		<option <?php selected($job_role, "Life Company Employee") ?> value="Life Company Employee">Life Company Employee</option>
		<option <?php selected($job_role, "Private Client Lawyer") ?> value="Private Client Lawyer">Private Client Lawyer</option>
		<option <?php selected($job_role, "Portfolio Manager") ?> value="Portfolio Manager">Portfolio Manager</option>
		<option <?php selected($job_role, "Fund of Funds Manager") ?> value="Fund of Funds Manager">Fund of Funds Manager</option>
		<option <?php selected($job_role, "Distributor") ?> value="Distributor">Distributor</option>
		<option <?php selected($job_role, "Consultant") ?> value="Consultant">Consultant</option>
		<option <?php selected($job_role, "Advisor") ?> value="Advisor">Advisor</option>
		<option <?php selected($job_role, "Fund Selection") ?> value="Fund Selector">Fund Selection</option>
		<option <?php selected($job_role, "Research") ?> value="Research">Research</option>
	</select>
</p>
<p><select name="job_level" style="width:100%;" required>
		<option value="" selected="selected" disabled>Job level*</option>
		<option <?php selected($job_level, "Associate") ?> value="Associate">Associate</option>
		<option <?php selected($job_level, "CEO/President/Chairmen") ?> value="CEO/President/Chairmen">CEO/President/Chairmen</option>
		<option <?php selected($job_level, "Consultant") ?> value="Consultant">Consultant</option>
		<option <?php selected($job_level, "Exec Management (EVP/SVP/MD)") ?> value="Exec Management (EVP/SVP/MD)">Exec Management (EVP/SVP/MD)</option>
		<option <?php selected($job_level, "Manager/Supervisor") ?> value="Manager/Supervisor">Manager/Supervisor</option>
		<option <?php selected($job_level, "Other C-Level") ?> value="Other C-Level">Other C-Level</option>
		<option <?php selected($job_level, "Owner/Partner/Proprietor") ?> value="Owner/Partner/Proprietor">Owner/Partner/Proprietor</option>
		<option <?php selected($job_level, "Project Manager") ?> value="Project Manager">Project Manager</option>
		<option <?php selected($job_level, "Secretary/Treasurer") ?> value="Secretary/Treasurer">Secretary/Treasurer</option>
		<option <?php selected($job_level, "Senior Manager/Dept. Head") ?> value="Senior Manager/Dept. Head">Senior Manager/Dept. Head</option>
		<option <?php selected($job_level, "Technical Business Specialist") ?> value="Technical Business Specialist">Technical Business Specialist</option>
		<option <?php selected($job_level, "VP Director") ?> value="VP Director">VP Director</option>
	</select>
</p>
<p><input type="email" name="email" value="<?php echo $email ?>" placeholder="Email*" required /></p>
<p><input type="password" name="password" value="<?php echo $password ?>" placeholder="Password*" required /></p>

<p class="privacy">Thank you for your details. We take your privacy very seriously and whilst we are providing professional business services, we respect the rights of individuals under data protection law. We abide by the data protection laws of all countries in which we operate. We collect personal data about you to provide you with the services or products you have expressed interest in, to tell you about other products and services we believe may be of interest to you.</p>

<p><input type="checkbox" name="terms2" required <?php checked( $terms2, 1 ) ?>>
	<span>I accept the <a href="/terms-and-conditions/" target="blank_">Terms and Conditions *</a></span>
</p>

<p class="privacy">We also work with carefully selected partners, third parties. These organisations can provide you with relevant information about goods, services or events which we feel will be of interest.</p>

<p><input type="checkbox" name="terms1" <?php checked( $terms1, 1 ) ?>>
	<span>Please tick this box to receive selected contact from our third parties.</span>
</p>

<p class="privacy">To manage your communication preferences, follow the instructions in the footer of future emails you are sent from <?php echo $sitename; ?>.</p>

<p class="privacy">More information on how we manage personal data and your rights including how to contact us, may be found <a href="<?php echo $privacy; ?>">here</a>.</p>

<p><input type="submit" name="btnsubmit" value="Submit"></p>
</form>
<h5><strong>Magazine request</strong></h5>

<p>To apply to receive the <?php echo $sitename; ?> magazine, click the link in the registration email you will be shortly sent and follow the instructions.</p>
<?php } ?>

<script>
	var form2 = jQuery("#registerform");
	form2.validate({
		errorPlacement: function errorPlacement(error, element) { 
		if (element.attr("type") == "checkbox" || element.attr("type") == "radio") {
			element.before(error); 
		} else {
			element.after(error); 
		}

		},
		rules: {
			first_name: {
				minlength: 2
				    },
			direct_line: {
				digits: true			
			}
		},
		messages: {
		    first_name: {
		      required: "This field is required.",
		      minlenght: "Please enter your name."
		    },
		    direct_line: {
		    	required: "This field is required.",
				digits: "Please add a valid telephone number"			
			}
	  	}
	});

</script>


<?php if ($websiteId == 5) { ?>
<style>
	form[name="register"] input[type="submit"]:hover {
		background-color: #f9ae00;
	}
</style>
<?php } ?>
<style>
	p.privacy {
		font-size: 14px;
	}

	form .error-message {
		color: #f00;
	}

	form[name="register"] input[type="radio"], form[name="register"] input[type="checkbox"]{
    	width: unset!important;
    }

   form[name="register"] {
	  margin-top: 30px!important;
  	  width: 70%!important;
	}

	form[name="register"] select,form[name="register"] input {
	  margin-bottom: 10px!important;
	  width: 100%!important;
	  border: 1px solid rgba(0, 0, 0, 0.1)!important;
	  background-color: #fff;
	  font-weight: normal;
	  font-size: 100%;
	}

	form[name="register"] input {
	  padding: 10px!important;
	}

	form[name="register"] input::placeholder {
	  opacity: 1!important;
	  color: #000000!important;
	}

	form[name="register"] input:focus::placeholder {
	  opacity: 0.3!important;
	}

	form[name="register"] input[type="checkbox"],form[name="register"] input[type="submit"] {
	  width: auto!important;
	}

	form[name="register"] input[type="submit"] {
	  padding: 10px 20px!important;
	}

	form#registerform label.error {
		display: block;
		margin-top: 10px;
		color: #f00;
	}

	form#registerform input.error {
		border: 2px solid #f00;
	}

</style>
<?php } ?>