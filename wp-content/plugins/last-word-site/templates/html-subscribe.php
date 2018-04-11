<?php 

$user_id = $_GET['user'];
$blog_id = $_GET['blog'];
$role = 'subscriber';
$blogname = get_bloginfo('name');
$siteurl = network_site_url( '/' );

add_user_to_blog($blog_id, $user_id);

switch( $blog_id ){
		case 2:
			$newsletterId = strtolower('2B258BCE-8985-E711-80FA-00155DD1690D'); // PA
			$sitename = "Portfolio Adviser";
			$sitelink = "www.portfolio-adviser.com";
			break;
		case 3:
			$newsletterId = strtolower('B5238BCE-8985-E711-80FA-00155DD1690D'); // IA
			$sitename = "International Adviser";
			$sitelink = "www.international-adviser.com";
			break;
		case 4:
			$newsletterId = strtolower('43238BCE-8985-E711-80FA-00155DD1690D'); // FSA
			$sitename = "Fund Selector Asia";
			$sitelink = "www.fundselectorasia.com";
			break;
		case 5:
			$newsletterId = strtolower('FD218BCE-8985-E711-80FA-00155DD1690D'); // EI
			$sitename = "Expert Investor";
			$sitelink = "www.expertinvestoreurope.com";
			break;
		default: 
			$newsletterId = '';
			$sitename = 'Last Word Media';
			break;
	}

	$args = array(
		'asl_transactiontype' => 'Additional',
		'asl_websiteuid' => $user_id,
		'asl_product' => $newsletterId,
		'asl_source1' => '860000006',
		'asl_purchasesource1' => '860000003',
		'asl_startdate' => strtotime(date("Y-m-d H:i:s")),
		'asl_purchasedate' => strtotime(date("Y-m-d H:i:s"))
	);

	$newsId = dynamic365_create_contact($args);

	$message = '<p>You have successfuly subscribed to '.$blogname.' website and '.$blogname.' newsletter. ';
	if ($blog_id != 4) {
				$message .= 'You can now request '.$blogname.' magazine or go back to <a href="/your-profile/">your profile.</a></p><hr>';
				$message .="<a href='/magazine-request/?id=" . $curuser . "'><button name='btnmagazine'>Continue to Magazine Request</button></p>";
			} else {
				$message .= 'Go back to <a href="/your-profile/">your profile.</a></p>';
			}
?>
<div id="your_profile_wrap">
	<p><?php echo $message; ?></p>
</div>

