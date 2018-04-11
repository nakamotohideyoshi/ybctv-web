<?php

global $wpdb, $source;

// $query = $wpdb->prepare(
        // "SELECT max( cast( user_id as UNSIGNED ) ) FROM {$wpdb->usermeta}");
		// $id =  $wpdb->get_var( $query );

/**
 * Define variables
 */
$acticode = isset($_GET['acticode'])?$_GET['acticode']:'';
$curuser = isset($_GET['userid'])?$_GET['userid']:'';

$userinfo = get_userdata($curuser);
$first_name = $userinfo->first_name;
$last_name = $userinfo->last_name;
$email = $userinfo->user_email;

$acticodecheck = get_user_meta($curuser, '_acticode', true);
$title = get_user_meta($curuser, '_title', true);
$job_title = get_user_meta($curuser, '_job_title', true);
$job_level = get_user_meta($curuser, '_job_level', true);
$country = get_user_meta($curuser, '_country', true);
$direct_line = get_user_meta($curuser, '_direct_line', true);
$terms1 = get_user_meta($curuser, '_terms1', true);
$terms2 = get_user_meta($curuser, '_terms2', true);
$company_name =	get_user_meta( $curuser, '_company_name', true);
$company_type =	get_user_meta( $curuser, '_company_type', true);
$job_role =	get_user_meta( $curuser, '_job_role', true);
$FSAtotalAUM = get_user_meta( $curuser, '_FSAtotalAum', true);
$FSANetWorth = get_user_meta( $curuser, '_FSANetWorth', true);
$FSAratings = get_user_meta( $curuser, '_FSAratings', true);
$FSAfirm = get_user_meta( $curuser, '_FSAfirm', true);
$FSAtick = get_user_meta( $curuser, '_FSAtick', true);
$FSAinstitype =	get_user_meta( $curuser, '_FSAinstitype', true);

$websiteId = get_current_blog_id();

switch( $websiteId ){
		case 2:
			$newsletterId = strtolower('2B258BCE-8985-E711-80FA-00155DD1690D'); // PA
			$header = "From:noreply@portfolio-adviser.com \r\n"; // PA
			$mailimage = "http://register.lastwordmedia.com/resource/images/pa_logo.png";
			$sitename = "Portfolio Adviser";
			$sitelink = "www.portfolio-adviser.com";
			break;
		case 3:
			$newsletterId = strtolower('B5238BCE-8985-E711-80FA-00155DD1690D'); // IA
			$header = "From:noreply@international-adviser.com \r\n"; // IA
			$mailimage = "http://register.lastwordmedia.com/resource/images/ia_logo.png";
			$sitename = "International Adviser";
			$sitelink = "www.international-adviser.com";
			break;
		case 4:
			$newsletterId = strtolower('43238BCE-8985-E711-80FA-00155DD1690D'); // FSA
			$header = "From:noreply@fundselectorasia.com \r\n"; // FSA
			$mailimage = "http://register.lastwordmedia.com/resource/images/fsa_logo.png";
			$sitename = "Fund Selector Asia";
			$sitelink = "www.fundselectorasia.com";
			break;
		case 5:
			$newsletterId = strtolower('FD218BCE-8985-E711-80FA-00155DD1690D'); // EI
			$header = "From:noreply@expertinvestoreurope.com \r\n"; // EI
			$mailimage = "https://ei.cms-lastwordmedia.com/wp-content/themes/lw_expert_inv/images/logo.png";
			$sitename = "Expert Investor";
			$sitelink = "www.expertinvestoreurope.com";
			break;
		default: 
			$newsletterId = '';
			$header = "From:noreply@lastwordmedia.com \r\n";
			$mailimage = "https://ci4.googleusercontent.com/proxy/BB4mi8apoo50yX38HRSowH2i9vMeJpAUQun5QCE-G4CvDVPNAJ-GkqiPG1-7e8ndlyZV081UML4gi1vPYE8fIfMU4IYCpbCkZr-TO2CtPUdsGVg=s0-d-e1-ft#http://register.lastwordmedia.com/resource/images/pa_logo.png";
			$sitename = 'Last Word Media';
			break;
	}

// check activation code and email verification

$verified = get_user_meta( $curuser, 'lw_email_verified', true);
$verify = true;

if ($verified != true) {

	if ($acticode == $acticodecheck) {

		if( ! is_wp_error($curuser) ){				

			/**
			 * Create contact on CRM
			*/

			update_user_meta( $curuser, 'lw_email_verified', $verify);

			$args=array(
				'asl_transactiontype' => 'New',
				'asl_websiteuid' => $curuser,
				'asl_title1' => $title,
				'asl_firstname' => $first_name,
				'asl_lastname' =>  $last_name,
				'asl_email' => $email,
				'asl_jobtitle' => $job_title,
				'asl_u11joblevel1' => $job_level,
				'asl_country' => $country,
				'asl_telephone1' => $direct_line,
				'asl_accept3pc' => $terms1,
				'asl_acceptterms' => $terms2,
				'asl_company' => $company_name,
				'asl_companytype' => $company_type,
				'asl_jobrole' => $job_role
			);

			$contactId = dynamic365_create_contact($args);

			$args2=array(
				'asl_transactiontype' => 'Additional',
				'asl_websiteuid' => $curuser,
				'asl_product' => $newsletterId,
				'asl_source1' => '860000006',
				'asl_purchasesource1' => '860000003',
				'asl_startdate' => strtotime(date("Y-m-d H:i:s")),
				'asl_purchasedate' => strtotime(date("Y-m-d H:i:s")),
				'asl_fsafirmtype' => $FSAfirm,
				'asl_tick' => $FSAtick,
				'asl_totalaum' => $FSAtotalAUM,
				'asl_networth' => $FSANetWorth,
				'asl_fundratings' => $FSAratings
			);
			$newsId = dynamic365_create_contact($args2);

			//update_user_meta( $curuser, '_contactId', $contactId);

			if ($websiteId != 4) {
				$message = "<div class='msg success'>Your account is activated. Thank you for registration. Please now sign in or continue to Magazine Request.</div>";
				
			} else {
				$message = "<div class='msg success'>Your account is activated. Thank you for registration. Please now sign in.</div>";
			}

			$message .= "<div class='login'>" . do_shortcode('[login-with-ajax redirect="/"]'). "</div>";
			if ($websiteId != 4) {
				$message .="<a href='/magazine-request/?id=" . $curuser . "'><button name='btnmagazine'>Continue to Magazine Request</button></p>";
			}

			$to = $email;
			$subject = "Last Word Media Registration";

			if ($websiteId != 4) {
				$mesage = "<div><table style='width: 600px;' border='0' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='width: 600px;' height='10'>&nbsp;</td></tr></tbody></table><table style='width: 600px;' border='0' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='width: 600px;' height='30'><img class='CToWUd a6T' tabindex='0' src='$mailimage' alt='' width='250' /><div class='a6S' dir='ltr' style='opacity: 0.01; left: 594.5px; top: 276px;'>&nbsp;</div></td></tr></tbody></table><table border='0' width='600' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td width='600' height='40'>&nbsp;</td></tr></tbody></table><table border='0' width='600' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td width='600' height='30'><img style='border: 1px solid #000;' class='CToWUd' src='https://ci3.googleusercontent.com/proxy/R36pm0nwR8hkff0lnNLJ3veuHtrUmoYwr3wqjkLpxd2Y5lrfuajmMgooA9l28i4hojbPjOWTc-XM9jZADYDmLfUTximFgf8RPsCJXff8IFSreA=s0-d-e1-ft#http://register.lastwordmedia.com/resource/images/header.gif' alt='' width='600' /></td></tr></tbody></table><table style='height: 604px; width: 600px;' border='0' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='border: 1px solid #aaaaaa; width: 600px;' align='center' valign='middle' bgcolor='#ffffff'><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table style='text-align: center; border-collapse: collapse;' border='0' width='265' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td width='100%' height='40'>&nbsp;</td></tr></tbody></table></td></tr></tbody></table><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table style='text-align: center; border-collapse: collapse;' border='0' width='265' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='text-align: center; font-family: Georgia; font-size: 43px; color: #3d494f; line-height: 48px;' valign='middle' width='100%'><span style='font-family: Georgia; font-weight: normal;'><u></u>Thank you...<u></u></span></td></tr></tbody></table></td></tr></tbody></table><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table style='text-align: center; border-collapse: collapse;' border='0' width='265' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td width='100%' height='45'>&nbsp;</td></tr></tbody></table></td></tr></tbody></table><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table class='m_-8421831432318242686m_4445467294160584565mobile' border='0' width='500' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='background-color: #e1e1e1;' bgcolor='#e1e1e1' width='460'><table class='m_-8421831432318242686m_4445467294160584565full' border='0' width='430' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td width='100%' height='30'>&nbsp;</td></tr><tr><td style='text-align: center; font-family: Georgia; font-size: 30px; color: #3d494f; line-height: 34px;' valign='middle' width='100%'><span style='font-family: Georgia; font-weight: normal;'><u></u>...for registering for the $sitename newsletter.<u></u></span></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table class='m_-8421831432318242686m_4445467294160584565mobile' border='0' width='500' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='background-color: #e1e1e1;' bgcolor='#e1e1e1' width='460'><table class='m_-8421831432318242686m_4445467294160584565full' border='0' width='440' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td width='100%' height='30'>&nbsp;</td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table class='m_-8421831432318242686m_4445467294160584565mobile' border='0' width='500' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='background-color: #e1e1e1;' align='center' bgcolor='#e1e1e1' width='460'><table class='m_-8421831432318242686m_4445467294160584565full' border='0' width='440' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='text-align: left; font-family: Georgia; font-size: 14px; color: #3d494f; line-height: 24px;' align='center' valign='middle' width='100%'><span style='font-family: Georgia; font-weight: normal;'> <u></u> $sitename is for profesional investment specialists, DFM's and Wealth Managers. If you are eligible, you will receive the next published issue of the magazine.</span></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table class='m_-8421831432318242686m_4445467294160584565mobile' border='0' width='500' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='background-color: #e1e1e1;' bgcolor='#e1e1e1' width='460'><table class='m_-8421831432318242686m_4445467294160584565full' border='0' width='440' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='text-align: left; font-family: Georgia; font-size: 14px; color: #3d494f; line-height: 24px;' valign='middle' width='100%'><p>If the criteria are not met, you can continue to enjoy news, views and analysis by registering for dailiy email alerts, or visiting</p></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table class='m_-8421831432318242686m_4445467294160584565mobile' border='0' width='500' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='background-color: #e1e1e1;' bgcolor='#e1e1e1' width='460'><table class='m_-8421831432318242686m_4445467294160584565full' border='0' width='440' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='text-align: center; font-family: Georgia; font-size: 14px; color: #3d494f; line-height: 34px;' valign='middle' width='100%'><span style='font-family: Georgia; font-weight: normal;'> <u></u> <a style='color: #000000;' href='http://$sitelink' target='_blank' rel='noopener' >$sitelink</a> <u></u> </span></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table class='m_-8421831432318242686m_4445467294160584565mobile' border='0' width='500' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='background-color: #e1e1e1;' bgcolor='#e1e1e1' width='265'><table class='m_-8421831432318242686m_4445467294160584565full' border='0' width='240' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td width='100%' height='40'>&nbsp;</td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table class='m_-8421831432318242686m_4445467294160584565mobile' style='width: 496.5px;' border='0' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='width: 502.5px; font-family: Georgia; font-size: 14px; line-height: 24px;' height='50'><p>&nbsp;</p> <img class='CToWUd' style='float: right;' src='https://ci4.googleusercontent.com/proxy/wB8ielbN6xVrxavlNAHocxJh97IB1cZNyTc9KUdgwiZ4iY94vxXekfVBl8osgDV5DHQruRdBvtuM-27acURRo5kb9egeBy376Wc7NI5vvd-oUIdTqvkmFWE=s0-d-e1-ft#http://register.lastwordmedia.com/resource/images/LW_Logo_Black.png' alt='' width='130' height='51' />$sitename is published by Last Word Media Limited, Fleet House, 1st Floor, 59-61 Clerkenwell Road, London, EC1M 5LA, United Kingdom.<p><span style='font-weight: 400; font-family: Georgia; font-size: 14px; line-height: 24px;'></span></p><p><span style='font-weight: 400; font-family: Georgia; font-size: 14px; line-height: 24px;'>Email: subscriptions@lastwordmedia.com</span></p><p><span style='font-weight: 400; font-family: Georgia; font-size: 14px; line-height: 24px;'>Copyright &copy; 2017. All rights reserved. Company Reg. No. 05573633. VAT. No. 872 411 728.</span></p><p><span style='font-weight: 400; font-family: Georgia; font-size: 14px; line-height: 24px;'>Please do not reply to this email. </span></p></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><div>&nbsp;</div><div>&nbsp;</div></div>";
			} else {
				$mesage = "<div><table style='width: 600px;' border='0' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='width: 600px;' height='10'>&nbsp;</td></tr></tbody></table><table style='width: 600px;' border='0' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='width: 600px;' height='30'><img class='CToWUd a6T' tabindex='0' src='$mailimage' alt='' width='250' /><div class='a6S' dir='ltr' style='opacity: 0.01; left: 594.5px; top: 276px;'>&nbsp;</div></td></tr></tbody></table><table border='0' width='600' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td width='600' height='40'>&nbsp;</td></tr></tbody></table><table border='0' width='600' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td width='600' height='30'><img style='border: 1px solid #000;' class='CToWUd' src='https://ci3.googleusercontent.com/proxy/R36pm0nwR8hkff0lnNLJ3veuHtrUmoYwr3wqjkLpxd2Y5lrfuajmMgooA9l28i4hojbPjOWTc-XM9jZADYDmLfUTximFgf8RPsCJXff8IFSreA=s0-d-e1-ft#http://register.lastwordmedia.com/resource/images/header.gif' alt='' width='600' /></td></tr></tbody></table><table style='height: 604px; width: 600px;' border='0' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='border: 1px solid #aaaaaa; width: 600px;' align='center' valign='middle' bgcolor='#ffffff'><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table style='text-align: center; border-collapse: collapse;' border='0' width='265' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td width='100%' height='40'>&nbsp;</td></tr></tbody></table></td></tr></tbody></table><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table style='text-align: center; border-collapse: collapse;' border='0' width='265' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='text-align: center; font-family: Georgia; font-size: 43px; color: #3d494f; line-height: 48px;' valign='middle' width='100%'><span style='font-family: Georgia; font-weight: normal;'><u></u>Thank you...<u></u></span></td></tr></tbody></table></td></tr></tbody></table><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table style='text-align: center; border-collapse: collapse;' border='0' width='265' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td width='100%' height='45'>&nbsp;</td></tr></tbody></table></td></tr></tbody></table><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table class='m_-8421831432318242686m_4445467294160584565mobile' border='0' width='500' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='background-color: #e1e1e1;' bgcolor='#e1e1e1' width='460'><table class='m_-8421831432318242686m_4445467294160584565full' border='0' width='430' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td width='100%' height='30'>&nbsp;</td></tr><tr><td style='text-align: center; font-family: Georgia; font-size: 30px; color: #3d494f; line-height: 34px;' valign='middle' width='100%'><span style='font-family: Georgia; font-weight: normal;'><u></u>...for registering for the $sitename newsletter.<u></u></span></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table class='m_-8421831432318242686m_4445467294160584565mobile' border='0' width='500' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='background-color: #e1e1e1;' bgcolor='#e1e1e1' width='460'><table class='m_-8421831432318242686m_4445467294160584565full' border='0' width='440' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td width='100%' height='30'>&nbsp;</td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table class='m_-8421831432318242686m_4445467294160584565mobile' border='0' width='500' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='background-color: #e1e1e1;' align='center' bgcolor='#e1e1e1' width='460'><table class='m_-8421831432318242686m_4445467294160584565full' border='0' width='440' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='text-align: left; font-family: Georgia; font-size: 14px; color: #3d494f; line-height: 24px;' align='center' valign='middle' width='100%'><span style='font-family: Georgia; font-weight: normal;'> <u></u> $sitename is for profesional investment specialists, DFM's and Wealth Managers.</span></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table class='m_-8421831432318242686m_4445467294160584565mobile' border='0' width='500' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='background-color: #e1e1e1;' bgcolor='#e1e1e1' width='460'><table class='m_-8421831432318242686m_4445467294160584565full' border='0' width='440' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='text-align: left; font-family: Georgia; font-size: 14px; color: #3d494f; line-height: 24px;' valign='middle' width='100%'><p>You can continue to enjoy news, views and analysis by registering for dailiy email alerts, or visiting</p></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table class='m_-8421831432318242686m_4445467294160584565mobile' border='0' width='500' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='background-color: #e1e1e1;' bgcolor='#e1e1e1' width='460'><table class='m_-8421831432318242686m_4445467294160584565full' border='0' width='440' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='text-align: center; font-family: Georgia; font-size: 14px; color: #3d494f; line-height: 34px;' valign='middle' width='100%'><span style='font-family: Georgia; font-weight: normal;'> <u></u> <a style='color: #000000;' href='http://$sitelink' target='_blank' rel='noopener' >$sitelink</a> <u></u> </span></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table class='m_-8421831432318242686m_4445467294160584565mobile' border='0' width='500' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='background-color: #e1e1e1;' bgcolor='#e1e1e1' width='265'><table class='m_-8421831432318242686m_4445467294160584565full' border='0' width='240' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td width='100%' height='40'>&nbsp;</td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><table style='background-color: #ffffff;' border='0' width='600' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffffff'><tbody><tr><td align='center' valign='middle' width='600'><table class='m_-8421831432318242686m_4445467294160584565mobile' style='width: 496.5px;' border='0' cellspacing='0' cellpadding='0' align='center'><tbody><tr><td style='width: 502.5px; font-family: Georgia; font-size: 14px; line-height: 24px;' height='50'><p>&nbsp;</p> <img class='CToWUd' style='float: right;' src='https://ci4.googleusercontent.com/proxy/wB8ielbN6xVrxavlNAHocxJh97IB1cZNyTc9KUdgwiZ4iY94vxXekfVBl8osgDV5DHQruRdBvtuM-27acURRo5kb9egeBy376Wc7NI5vvd-oUIdTqvkmFWE=s0-d-e1-ft#http://register.lastwordmedia.com/resource/images/LW_Logo_Black.png' alt='' width='130' height='51' />$sitename is published by Last Word Media Limited, Fleet House, 1st Floor, 59-61 Clerkenwell Road, London, EC1M 5LA, United Kingdom.<p><span style='font-weight: 400; font-family: Georgia; font-size: 14px; line-height: 24px;'></span></p><p><span style='font-weight: 400;'>Email: subscriptions@lastwordmedia.com</span></p><p><span style='font-weight: 400; font-family: Georgia; font-size: 14px; line-height: 24px;'>Copyright &copy; 2017. All rights reserved. Company Reg. No. 05573633. VAT. No. 872 411 728.</span></p><p><span style='font-weight: 400; font-family: Georgia; font-size: 14px; line-height: 24px;'>Please do not reply to this email. </span></p></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><div>&nbsp;</div><div>&nbsp;</div></div>";
			}

			
			

			
			// $header .= "Cc:afgh@somedomain.com \r\n";
			$header .= "MIME-Version: 1.0\r\n";
			$header .= "Content-type: text/html\r\n";

			$retval = wp_mail($to,$subject,$mesage,$header);

			} else {
				$message='ERROR: ';
				foreach( $user_id->errors as $error ){
					foreach( $error as $text ){
						$message .= "<span class='msg error' style='color: #f00;'>{$text}</span>"."\r\n";
					}
				}
			}
		}
	} else {
		$message = "<div class='msg warning'>Your account is already activated. Please now sign in or continue to Magazine Request.</div>";
		$message .= "<div class='login'>" . do_shortcode('[login-with-ajax redirect="/"]'). "</div>";
		if ($websiteId != 4) {
				$message .="<a href='/magazine-request/?id=" . $curuser . "'><button name='btnmagazine'>Continue to Magazine Request</button></p>";
			}
	}
	 
?>
	<div class="msg-wrap">
	<?php echo isset($message)?$message:''; ?>
	</div>



