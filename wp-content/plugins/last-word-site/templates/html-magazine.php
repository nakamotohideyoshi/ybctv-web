<?php
global $source;

/**
 * Form submit
 */		
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		
		//create variable
		
		$user_id = $_POST['id_user'];
		$receive_magazine = isset($_POST['receive_magazine'])?$_POST['receive_magazine']:'';
		$fees = isset($_POST['fees'])?$_POST['fees']:'';
		$front_commission = isset($_POST['front_commission'])?$_POST['front_commission']:'';
		$trail_commission = isset($_POST['trail_commission'])?$_POST['trail_commission']:'';
		$total_aum = isset($_POST['total_aum'])?$_POST['total_aum']:'';
		$total_business = isset($_POST['total_business'])?$_POST['total_business']:'';
		$total_average = isset($_POST['total_average'])?$_POST['total_average']:'';	
		$domiciled = isset($_POST['domiciled'])?$_POST['domiciled']:'';
		$websites = isset($_POST['websites'])?$_POST['websites']:'';
		$website = 'Portfolio Adviser';
		$address1 = isset($_POST['address1'])?$_POST['address1']:'';
		$address2 = isset($_POST['address2'])?$_POST['address2']:'';
		$address3 = isset($_POST['address3'])?$_POST['address3']:'';
		$city = isset($_POST['city'])?$_POST['city']:'';
		$state = isset($_POST['state'])?$_POST['state']:'';
		$post_code = isset($_POST['post_code'])?$_POST['post_code']:'';
		$country = isset($_POST['country'])?$_POST['country']:'';
		$purchase_date = date('j M Y');

		$websites1 = isset($_POST['websites'])?$_POST['websites']:'';
		$websites = implode($websites1, ', ');
		
		$regularly1 = isset($_POST['regularly'])?$_POST['regularly']:'';
		$regularly = implode($regularly1, ', ');
		
		$platforms1 = isset($_POST['platforms'])?$_POST['platforms']:'';
		$platforms = implode($platforms1, ', ');
		
		$manager_ratings1 = isset($_POST['manager_ratings'])?$_POST['manager_ratings']:'';
		$manager_ratings = implode($manager_ratings1, ', ');
		
		$product_type1 = isset($_POST['product_type'])?$_POST['product_type']:'';
		$product_type = implode($product_type1, ', ');
		
		$wrappers1 = isset($_POST['wrappers'])?$_POST['wrappers']:'';
		$wrappers = implode($wrappers1, ', ');

		$tick1 = isset($_POST['tick'])?$_POST['tick']:'';
		$tick2 = isset($_POST['tick2'])?$_POST['tick2']:'';
		if ($tick1 == 'Other') {
			$tick = $tick2;
		} else {
			$tick = $tick1;
		}

		//IA specific
		$IAfees = isset($_POST['IAfees'])?$_POST['IAfees']:'';
		$IAfront_commission = isset($_POST['IAfront_commission'])?$_POST['IAfront_commission']:'';
		$IAtrail_commission = isset($_POST['IAtrail_commission'])?$_POST['IAtrail_commission']:'';
		$IAtotal_aum = isset($_POST['IAtotal_aum'])?$_POST['IAtotal_aum']:'';	
		$IAtotal_business = isset($_POST['IAtotal_business'])?$_POST['IAtotal_business']:'';
		$IAtotal_average = isset($_POST['IAtotal_average'])?$_POST['IAtotal_average']:'';
		$IAofflb = isset($_POST['IAofflb'])?$_POST['IAofflb']:'';
		$IAperspb = isset($_POST['IAperspb'])?$_POST['IAperspb']:'';
		$IAintlpens = isset($_POST['IAintlpens'])?$_POST['IAintlpens']:'';
		$IAdirfs = isset($_POST['IAdirfs'])?$_POST['IAdirfs']:'';
		$IAtaxtrup = isset($_POST['IAtaxtrup'])?$_POST['IAtaxtrup']:'';
		$IAcashman = isset($_POST['IAcashman'])?$_POST['IAcashman']:'';
		$IAintlprot = isset($_POST['IAintlprot'])?$_POST['IAintlprot']:'';
		$IAintlhealthins = isset($_POST['IAintlhealthins'])?$_POST['IAintlhealthins']:'';
		$IAdomiciled = isset($_POST['IAdomiciled'])?$_POST['IAdomiciled']:'';
		$IAlocof = isset($_POST['IAlocof'])?$_POST['IAlocof']:'';
		$IACexpat = isset($_POST['IACexpat'])?$_POST['IACexpat']:'';
		$IAClocal = isset($_POST['IAClocal'])?$_POST['IAClocal']:'';
		$IACother = isset($_POST['IACother'])?$_POST['IACother']:'';

		$IAtick1 = isset($_POST['IAtick'])?$_POST['IAtick']:'';
		$IAtick2 = isset($_POST['IAtick2'])?$_POST['IAtick2']:'';
		if ($IAtick1 == 'Other') {
			$IAtick = $IAtick2;
		} else {
			$IAtick = $IAtick1;
		}

		$IAregulated1 = isset($_POST['IAregulated'])?$_POST['IAregulated']:'';
		$IAregulated2 = isset($_POST['IAregulated2'])?$_POST['IAregulated2']:'';
		if ($IAregulated1 == 'Other') {
			$IAregulated = $IAregulated2;
		} else {
			$IAregulated = $IAregulated1;
		}

		//multi-selects
		$IAoffshorebonds1 = isset($_POST['IAoffshorebonds1'])?$_POST['IAoffshorebonds1']:'';
		$IAoffshorebonds2 = isset($_POST['IAoffshorebonds2'])?$_POST['IAoffshorebonds2']:'';
		$IAoffshorebonds3 = isset($_POST['IAoffshorebonds3'])?$_POST['IAoffshorebonds3']:'';
		$IAoffshorebonds4 = isset($_POST['IAoffshorebonds4'])?$_POST['IAoffshorebonds4']:'';
		$IAoffshorebonds5 = isset($_POST['IAoffshorebonds5'])?$_POST['IAoffshorebonds5']:'';
		$IAoffshorebonds6 = isset($_POST['IAoffshorebonds6'])?$_POST['IAoffshorebonds6']:'';
		$IAoffshorebonds7 = isset($_POST['IAoffshorebonds7'])?$_POST['IAoffshorebonds7']:'';
		$IAoffshorebonds8 = isset($_POST['IAoffshorebonds8'])?$_POST['IAoffshorebonds8']:'';
		$IAoffshorebonds9 = isset($_POST['IAoffshorebonds9'])?$_POST['IAoffshorebonds9']:'';
		$IAoffshorebonds10 = isset($_POST['IAoffshorebonds10'])?$_POST['IAoffshorebonds10']:'';
		$IAoffshorebonds11 = isset($_POST['IAoffshorebonds11'])?$_POST['IAoffshorebonds11']:'';
		$IAoffshorebonds12 = isset($_POST['IAoffshorebonds12'])?$_POST['IAoffshorebonds12']:'';
		$IAoffshorebonds13 = isset($_POST['IAoffshorebonds13'])?$_POST['IAoffshorebonds13']:'';
		$IAoffshorebonds14 = isset($_POST['IAoffshorebonds14'])?$_POST['IAoffshorebonds14']:'';
		$IAoffshorebonds15 = isset($_POST['IAoffshorebonds15'])?$_POST['IAoffshorebonds15']:'';
		$IAoffshorebonds16 = isset($_POST['IAoffshorebonds16'])?$_POST['IAoffshorebonds16']:'';
		$IAoffshorebonds17 = isset($_POST['IAoffshorebonds17'])?$_POST['IAoffshorebonds17']:'';
		$IAoffshorebonds18 = isset($_POST['IAoffshorebonds18'])?$_POST['IAoffshorebonds18']:'';

		$IAfundratings1 = isset($_POST['IAfundratings1'])?$_POST['IAfundratings1']:'';
		$IAfundratings2 = isset($_POST['IAfundratings2'])?$_POST['IAfundratings2']:'';
		$IAfundratings3 = isset($_POST['IAfundratings3'])?$_POST['IAfundratings3']:'';
		$IAfundratings4 = isset($_POST['IAfundratings4'])?$_POST['IAfundratings4']:'';
		$IAfundratings5 = isset($_POST['IAfundratings5'])?$_POST['IAfundratings5']:'';
		$IAfundratings6 = isset($_POST['IAfundratings6'])?$_POST['IAfundratings6']:'';
		$IAfundratings7 = isset($_POST['IAfundratings7'])?$_POST['IAfundratings7']:'';
		$IAfundratings8 = isset($_POST['IAfundratings8'])?$_POST['IAfundratings8']:'';

		$IAintfincen1 = isset($_POST['IAintfincen1'])?$_POST['IAintfincen1']:'';
		$IAintfincen2 = isset($_POST['IAintfincen2'])?$_POST['IAintfincen2']:'';
		$IAintfincen3 = isset($_POST['IAintfincen3'])?$_POST['IAintfincen3']:'';
		$IAintfincen4 = isset($_POST['IAintfincen4'])?$_POST['IAintfincen4']:'';
		$IAintfincen5 = isset($_POST['IAintfincen5'])?$_POST['IAintfincen5']:'';
		$IAintfincen6 = isset($_POST['IAintfincen6'])?$_POST['IAintfincen6']:'';
		$IAintfincen7 = isset($_POST['IAintfincen7'])?$_POST['IAintfincen7']:'';
		$IAintfincen8 = isset($_POST['IAintfincen8'])?$_POST['IAintfincen8']:'';
		$IAintfincen9 = isset($_POST['IAintfincen9'])?$_POST['IAintfincen9']:'';
		$IAintfincen10 = isset($_POST['IAintfincen10'])?$_POST['IAintfincen10']:'';
		$IAintfincen11 = isset($_POST['IAintfincen11'])?$_POST['IAintfincen11']:'';
		$IAintfincen12 = isset($_POST['IAintfincen12'])?$_POST['IAintfincen12']:'';

		$IAproduct_type1 = isset($_POST['IAproduct_type1'])?$_POST['IAproduct_type1']:'';
		$IAproduct_type2 = isset($_POST['IAproduct_type2'])?$_POST['IAproduct_type2']:'';
		$IAproduct_type3 = isset($_POST['IAproduct_type3'])?$_POST['IAproduct_type3']:'';
		$IAproduct_type4 = isset($_POST['IAproduct_type4'])?$_POST['IAproduct_type4']:'';
		$IAproduct_type5 = isset($_POST['IAproduct_type5'])?$_POST['IAproduct_type5']:'';
		$IAproduct_type6 = isset($_POST['IAproduct_type6'])?$_POST['IAproduct_type6']:'';
		$IAproduct_type7 = isset($_POST['IAproduct_type7'])?$_POST['IAproduct_type7']:'';
		$IAproduct_type8 = isset($_POST['IAproduct_type8'])?$_POST['IAproduct_type8']:'';
		$IAproduct_type9 = isset($_POST['IAproduct_type9'])?$_POST['IAproduct_type9']:'';
		$IAproduct_type10 = isset($_POST['IAproduct_type10'])?$_POST['IAproduct_type10']:'';
		$IAproduct_type11 = isset($_POST['IAproduct_type11'])?$_POST['IAproduct_type11']:'';
		$IAproduct_type12 = isset($_POST['IAproduct_type12'])?$_POST['IAproduct_type12']:'';
		$IAproduct_type13 = isset($_POST['IAproduct_type13'])?$_POST['IAproduct_type13']:'';
		$IAproduct_type14 = isset($_POST['IAproduct_type14'])?$_POST['IAproduct_type14']:'';
		$IAproduct_type15 = isset($_POST['IAproduct_type15'])?$_POST['IAproduct_type15']:'';
		$IAproduct_type16 = isset($_POST['IAproduct_type16'])?$_POST['IAproduct_type16']:'';
		$IAproduct_type17 = isset($_POST['IAproduct_type17'])?$_POST['IAproduct_type17']:'';


		//EI specific
		$EItotal_aum = isset($_POST['EItotal_aum'])?$_POST['EItotal_aum']:'';
		$EI3pfaum = isset($_POST['EI3pfaum'])?$_POST['EI3pfaum']:'';
		$EIfundtypes = isset($_POST['EIfundtypes'])?$_POST['EIfundtypes']:'';

		$EIcomptype1 = isset($_POST['EIcomptype'])?$_POST['EIcomptype']:'';
		$EIcomptype2 = isset($_POST['EIcomptype2'])?$_POST['EIcomptype2']:'';
		if ($EIcomptype1 == 'Other') {
			$EIcomptype = $EIcomptype2;
		} else {
			$EIcomptype = $EIcomptype1;
		}
		

		update_post_meta( $user_id, '_receive_magazine', $receive_magazine);
		update_post_meta( $user_id, '_address1', $address1);
		update_post_meta( $user_id, '_address2', $address2);
		update_post_meta( $user_id, '_address3', $address3);
		update_post_meta( $user_id, '_city', $city);
		update_post_meta( $user_id, '_state', $state);
		update_post_meta( $user_id, '_post_code', $post_code);
		update_post_meta( $user_id, '_country', $country);
		update_post_meta( $user_id, '_tick', $tick);
		update_post_meta( $user_id, '_fees', $fees);
		update_post_meta( $user_id, '_front_commission', $front_commission);
		update_post_meta( $user_id, '_total_aum', $total_aum);
		update_post_meta( $user_id, '_total_business', $total_business);
		update_post_meta( $user_id, '_total_average ', $total_average );
		update_post_meta( $user_id, '_manager_ratings', $manager_ratings);
		update_post_meta( $user_id, '_regularly', $regularly);
		update_post_meta( $user_id, '_platforms', $platforms);
		update_post_meta( $user_id, '_product_type', $product_type);
		update_post_meta( $user_id, '_domiciled', $domiciled);
		update_post_meta( $user_id, '_wrappers', $wrappers);
		update_post_meta( $user_id, '_websites', $websites);
		
		/* send to crm */
		$contactId = get_user_meta( $user_id, '_contactId', true );

		$websiteId = get_current_blog_id();

		switch( $websiteId ){
			case 2:
				$productId = strtolower('25258BCE-8985-E711-80FA-00155DD1690D'); // PA
				$total_aum = $total_aum;
				$tick = $tick;
				$front_commission = $front_commission;
				$trail_commission = $trail_commission;
				$total_business = $total_business;
				$total_average = $total_average;
				$domiciled = $domiciled;
				break;
			case 3:
				$productId = strtolower('B1238BCE-8985-E711-80FA-00155DD1690D'); // IA
				$total_aum = $IAtotal_aum;
				$tick = $IAtick;
				$front_commission = $IAfront_commission;
				$trail_commission = $IAtrail_commission;
				$total_business = $IAtotal_business;
				$total_average = $IAtotal_average;
				$domiciled = $IAdomiciled;
				break;
			case 5:
				$productId = strtolower('F9218BCE-8985-E711-80FA-00155DD1690D'); // EI
				$total_aum = $EItotal_aum;
				break;
			default: 
				$productId = '';
				break;
		}


		
		$args=array(
			'asl_transactiontype' => 'Additional',
			'asl_websiteuid' => $user_id,
			'asl_product' => $productId,
			'asl_magtype1' => $receive_magazine,
			'asl_source1' => '860000006',
			'asl_purchasesource1' => '860000003',
			'asl_website' => $website,
			'asl_startdate' => strtotime(date("Y-m-d H:i:s")),
			'asl_purchasedate' => strtotime(date("Y-m-d H:i:s")),
			'asl_tick' => $tick,
			'asl_fees' => $fees,
			'asl_frontcommission' => $front_commission,
			'asl_trailcommission' => $trail_commission,
			'asl_totalaum' => $total_aum,
			'asl_totalbusiness' => $total_business,
			'asl_totalaverage' => $total_average,
			'asl_managerratings' => $manager_ratings,
			'asl_regularly' => $regularly,
			'asl_platforms' => $platforms,
			'asl_domiciled' => $domiciled,
			'asl_wrappers' => $wrappers,
			'asl_websites' => $websites,
			'asl_receivemagazine' => $receive_magazine,
			'asl_website' => $website,
			'asl_address1_line1' => $address1,
			'asl_address1_line2' => $address2,
			'asl_address1_line3' => $address3,
			'asl_address1_city' => $city,
			'asl_address1_stateorprovince' => $state,
			'asl_address1_postalcode' => $post_code,
			//EI 
			'asl_3rdpartyaum' => $EI3pfaum,
			'asl_fundtypes' => $EIfundtypes,
			//IA
			'asl_offshorelifebondsrevenue' => $IAofflb,
			'asl_personalportfoliobondsrevenue' => $IAperspb,
			'asl_intlpensionsrevenue' => $IAintlpens,
			'asl_directfundsalesrevenue' => $IAdirfs,
			'asl_taxtrustplanningrevenue' => $IAtaxtrup,
			'asl_cashmanagementrevenue' => $IAcashman,
			'asl_intlprotectionrevenue' => $IAintlprot,
			'asl_intlhealthinsurancerevenue' => $IAintlhealthins,
			'asl_clientfees' => $IAfees,
			'asl_localoroffshore' => $IAlocof,
			'asl_clientsexpat' => $IACexpat,
			'asl_clientslocal' => $IAClocal,
			'asl_clientsother' => $IACother,
			'asl_regulatedby' => $IAregulated,
			'asl_nonukdomiciled' => $IAdomiciled,

			'asl_obaig' => $IAoffshorebonds1,
			'asl_obag2rlamondiale' => $IAoffshorebonds2,
			'asl_obaviva' => $IAoffshorebonds3,
			'asl_obaxa' => $IAoffshorebonds4,
			'asl_obcanadalifeintl' => $IAoffshorebonds5,
			'asl_obfriendsprovidentintl' => $IAoffshorebonds6,
			'asl_obgeneraliintl' => $IAoffshorebonds7,
			'asl_obhansard' => $IAoffshorebonds8,
			'asl_obirishlifeintl' => $IAoffshorebonds9,
			'asl_oblegalgeneralintl' => $IAoffshorebonds10,
			'asl_oboldmutualintl' => $IAoffshorebonds11,
			'asl_obprudential' => $IAoffshorebonds12,
			'asl_obrl360' => $IAoffshorebonds13,
			'asl_obroyalskandia' => $IAoffshorebonds14,
			'asl_obstandardlifeintl' => $IAoffshorebonds15,
			'asl_obzurics' => $IAoffshorebonds16,
			'asl_obother' => $IAoffshorebonds17,
			'asl_obothertext' => $IAoffshorebonds17,

			'asl_frmorningstarqual' => $IAfundratings1,
			'asl_frmorningstarquant' => $IAfundratings2,
			'asl_frfecrownquant' => $IAfundratings3,
			'asl_frlipperleaderquant' => $IAfundratings4,
			'asl_frcitywirequant' => $IAfundratings5,
			'asl_frfealphamanagerquant' => $IAfundratings6,
			'asl_frother' => $IAfundratings7,
			'asl_frothertext' => $IAfundratings8,

			'asl_fcjersey' => $IAintfincen1,
			'asl_fcguersney' => $IAintfincen2,
			'asl_fcdublin' => $IAintfincen3,
			'asl_fcisleofman' => $IAintfincen4,
			'asl_fcluxembourg' => $IAintfincen5,
			'asl_fcswitzerland' => $IAintfincen6,
			'asl_fcbermuda' => $IAintfincen7,
			'asl_fcbahamas' => $IAintfincen8,
			'asl_fccaymanislands' => $IAintfincen9,
			'asl_fcbvi' => $IAintfincen10,
			'asl_fcother' => $IAintfincen11,
			'asl_fcothertext' => $IAintfincen12,
			
			'asl_ptequityfunds' => $IAproduct_type1,
			'asl_ptbondfunds' => $IAproduct_type2,
			'asl_ptmultimanagerfundsoffunds' => $IAproduct_type3,
			'asl_ptfundsofhedgefunds' => $IAproduct_type4,
			'asl_ptsinglestrategyhedgefunds' => $IAproduct_type5,
			'asl_pt13030fundsorsimilaralternatives' => $IAproduct_type6,
			'asl_ptprivateequityfunds' => $IAproduct_type7,
			'asl_ptpropertyfunds' => $IAproduct_type8,
			'asl_ptmoneymarketcashfunds' => $IAproduct_type9,
			'asl_ptclosedendedfunds' => $IAproduct_type10,
			'asl_ptstructuredproducts' => $IAproduct_type11,
			'asl_ptetfsetcs' => $IAproduct_type12,
			'asl_ptindextrackingfunds' => $IAproduct_type13,
			'asl_ptmultiassetfunds' => $IAproduct_type14,
			'asl_ptabsolutereturnfunds' => $IAproduct_type15,
			'asl_ptother' => $IAproduct_type16,
			'asl_ptothertext' => $IAproduct_type17
		);

		$magazine_id = dynamic365_create_contact($args);

		$args2=array(
			'asl_transactiontype' => 'Amendment',
			'asl_websiteuid' => $user_id,
			'asl_address1_line1' => $address1,
			'asl_address1_line2' => $address2,
			'asl_address1_line3' => $address3,
			'asl_address1_city' => $city,
			'asl_address1_stateorprovince' => $state,
			'asl_address1_postalcode' => $post_code
		);

		$magazine_id2 = dynamic365_create_contact($args2);
		
		if($magazine_id)
			update_post_meta( $user_id, '_magazine_id', $magazine_id);
		
		$message = "<div class='msg success' style='color: #222;'>Thank you for submitting your magazine request. The next edition will be sent to qualifying subscribers. Please now login.</div>";
		$message .= "<div class='login'>" . do_shortcode('[login-with-ajax redirect="/"]') . "</div>";
		
		//reset variable
		$country = "";
	
		// echo "<script>alert('test')</script>";
	
} ?>
	<div class="msg-wrap">
		<?php echo isset($message)?$message:''; ?>
	</div>
<?php
if ( isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] !== 'POST' ) {

	$websiteId = get_current_blog_id();

		switch( $websiteId ){
			case 2: // PA
				$sitename = 'Portfolio Adviser';
				$sitelink = 'http://www.portfolio-adviser.com/';
				break;
			case 3: // IA
				$sitename = 'International Adviser';
				$sitelink = 'http://www.international-adviser.com/';
				break;
			case 4: // FSA
				$sitename = 'Fund Selector Asia';
				$sitelink = 'http://www.fundselectorasia.com/';
				break;
			case 5: // EI
				$sitename = 'Expert Investor';
				$sitelink = 'http://www.expertinvestoreurope.com/';
				break;
			default: 
				$sitename = 'Last Word Media';
				$sitelink = 'http://www.lastwordmedia.com/';			
				break;
		}
?>


<form id="req-magazine" name="req-magazine" method="post" action="">
	
	<input type="hidden" name="id_user" value="<?php echo $_GET['id']; ?>">
	<div class="req-magazine">

		<h3 style="display:none;">Progress</h3>
		<section>
			<p><strong>Magazine subscription</strong></p>
			<p>To apply to receive a monthly copy of <?php echo $sitename; ?>, complete the form below.</p>
			<p><strong>How would you like to receive the magazine?</strong></p>
			<p><input type="radio" name="receive_magazine" value="digital"> <label> Digital version </label></p>
			<?php if ($websiteId == 3) {
				//
				} else { ?>
			<p><input type="radio" name="receive_magazine" value="printed and digital"> <label> Printed and Digital version </label></p>
			<p>We regret that we are unable to send <?php echo $sitename; ?> to<?php if($websiteId != 5) { ?> non-UK <?php } else { ?> non-European <?php } ?>addresses. If you are located outside of the<?php if($websiteId != 5) { ?> UK <?php } else { ?> Europe <?php } ?>you will receive the digital edition only.</p>
			<?php } ?>
			<p>* Mandatory fields</p>
			<p><input type="text" name="address1" required placeholder="Address line 1*" class="required"></p>
			<p><input type="text" name="address2" placeholder="Address line 2"></p>
			<p><input type="text" name="address3" placeholder="Address line 3"></p>
			<p><input type="text" name="city" placeholder="City*" required></p>
			<p><input type="text" name="state" placeholder="State"></p>
			<p><input type="text" name="post_code" placeholder="Post/Zip code*" required></p>
			<?php
				$user_id = $_GET['id'];
				$country = get_user_meta( $user_id, '_country', true );
			?>
			<p><select name="country" style="border: 1px solid #ddd;" required>

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
				</select>
			</p>
		</section>
<?php $websiteId = get_current_blog_id(); 
	if ($websiteId == 2) { ?>
		<h3 style="display:none;">Progress 1</h3>
		<section>
			<p><strong>1) Are you a: (tick most relevant box)</strong></p>
			<p><input type="radio" name="tick" value="Wealth manager" required> <label> Wealth manager </label></p>
			<p><input type="radio" name="tick" value="Wealth adviser" required> <label> Wealth adviser </label></p>
			<p><input type="radio" name="tick" value="Multi-manager" required> <label> Multi-manager </label></p>
			<p><input type="radio" name="tick" value="Discretionary portfolio manager" required> <label> Discretionary portfolio manager </label></p>
			<p><input type="radio" name="tick" value="Private client stockbroker" required> <label> Private client stockbroker </label></p>
			<p><input type="radio" name="tick" value="Solicitor investment manager" required> <label> Solicitor investment manager </label></p>
			<p><input type="radio" name="tick" value="Private banker" required> <label> Private banker </label></p>
			<p><input type="radio" name="tick" value="Accountant" required> <label> Accountant </label></p>
			<p><input type="radio" name="tick" value="Trustee" required> <label> Trustee </label></p>
			<p><input type="radio" name="tick" value="Consulting actuary" required> <label> Consulting actuary </label></p>
			<p><input type="radio" name="tick" value="Investment researcher/analyst" required> <label> Investment researcher/analyst </label></p>
			<p><input type="radio" name="tick" value="Family office employee" required> <label> Family office employee </label></p>
			<p><input type="radio" name="tick" value="Life company employee" required> <label> Life company employee </label></p>
			<p><input type="radio" name="tick" value="Independent financial adviser" required> <label> Independent financial adviser </label></p>
			<p><input type="radio" name="tick" value="Other" id="other" required> <label> Other </label></p>
			<p><input type="text" name="tick2" id="other-value" placeholder="(please specify)" style="display:none"></p>
		</section>	

		<h3 style="display:none;">Progress 2</h3>
		<section>	
			<p><strong>2) Roughly what % of your revenue comes from Client fees</strong></p>
			<p><input type="radio" name="fees" value="1-25" required> <label> 1-25% </label></p>
			<p><input type="radio" name="fees" value="26-50" required> <label> 26-50% </label></p>
			<p><input type="radio" name="fees" value="51-75" required> <label> 51-75% </label></p>
			<p><input type="radio" name="fees" value="76-100" required> <label> 76-100% </label></p>
			<p><input type="radio" name="fees" value="Not applicable" required> <label> Not applicable </label></p>

			<p><strong>Up-front commission</strong></p>
			<p><input type="radio" name="front_commission" value="1-25" required> <label> 1-25% </label></p>
			<p><input type="radio" name="front_commission" value="26-50" required> <label> 26-50% </label></p>
			<p><input type="radio" name="front_commission" value="51-75" required> <label> 51-75% </label></p>
			<p><input type="radio" name="front_commission" value="76-100" required> <label> 76-100% </label></p>
			<p><input type="radio" name="front_commission" value="Not applicable" required> <label> Not applicable </label></p>
			
			<p><strong>Trail commission</strong></p>
			<p><input type="radio" name="trail_commission" value="1-25" required> <label> 1-25% </label></p>
			<p><input type="radio" name="trail_commission" value="26-50" required> <label> 26-50% </label></p>
			<p><input type="radio" name="trail_commission" value="51-75" required> <label> 51-75% </label></p>
			<p><input type="radio" name="trail_commission" value="76-100" required> <label> 76-100% </label></p>
			<p><input type="radio" name="trail_commission" value="Not applicable" required> <label> Not applicable </label></p>
		</section>		

		<h3 style="display:none;">Progress 3</h3>
		<section>	
			<p><strong>3) What is your company’s total AUM?</strong></p>
			<p><input type="radio" name="total_aum" value="Up to £10m" required> <label> Up to £10m </label></p>
			<p><input type="radio" name="total_aum" value="from £10m to £100m" required> <label> from £10m to £100m </label></p>
			<p><input type="radio" name="total_aum" value="from £100m to £1bn" required> <label> from £100m to £1bn </label></p>
			<p><input type="radio" name="total_aum" value="£1bn+" required> <label> £1bn+ </label></p>
			<p><input type="radio" name="total_aum" value="Not applicable" required> <label> Not applicable </label></p>
		</section>	

		<h3 style="display:none;">Progress 4</h3>
		<section>
			<p><strong>4) Approximately how much business do you personally write each year:</strong></p>
			<p><input type="radio" name="total_business" value="Up to £1m" required> <label> Up to £1m </label></p>
			<p><input type="radio" name="total_business" value="from £1m to £10m" required> <label> from £1m to £10m </label></p>
			<p><input type="radio" name="total_business" value="from £10m to £100m" required> <label> from £10m to £100m </label></p>
			<p><input type="radio" name="total_business" value="£100m+" required> <label> £100m+ </label></p>
			<p><input type="radio" name="total_business" value="Not applicable" required> <label> Not applicable </label></p>
		</section>	

		<h3 style="display:none;">Progress 5</h3>
		<section>
			<p><strong>5) What is the average net worth of your clients:</strong></p>
			<p><input type="radio" name="total_average" value="Less than £1m" required> <label> Less than £1m </label></p>
			<p><input type="radio" name="total_average" value="from £1m to £10m" required> <label> from £1m to £10m </label></p>
			<p><input type="radio" name="total_average" value="from £10m to £100m" required> <label> from £10m to £100m </label></p>
			<p><input type="radio" name="total_average" value="£100m+" required> <label> £100m+ </label></p>
			<p><input type="radio" name="total_average" value="Not applicable" required> <label> Not applicable </label></p>
		</section>

		<h3 style="display:none;">Progress 6</h3>
		<section>
			<p><strong>6) Do you use the fund/manager ratings from any of the following?</strong></p>
			<p><input type="checkbox" name="manager_ratings[]" value="Rayner Spencer Mills Research (qual)"> <label> Rayner Spencer Mills Research (qual) </label></p>
			<p><input type="checkbox" name="manager_ratings[]" value="Square Mile (qual)" required> <label> Square Mile (qual) </label></p>
			<p><input type="checkbox" name="manager_ratings[]" value="Morningstar Star (quant)" required> <label> Morningstar Star (quant) </label></p>
			<p><input type="checkbox" name="manager_ratings[]" value="Morningstar OBSR (qual)" required> <label> Morningstar OBSR (qual) </label></p>
			<p><input type="checkbox" name="manager_ratings[]" value="FE Crown (quant)" required> <label> FE Crown (quant) </label></p>
			<p><input type="checkbox" name="manager_ratings[]" value="Lipper Leader (quant)" required> <label> Lipper Leader (quant) </label></p>
			<p><input type="checkbox" name="manager_ratings[]" value="Citywire (quant)" required> <label> Citywire (quant) </label></p>
			<p><input type="checkbox" name="manager_ratings[]" value="FE Alpha Manager (quant)" required> <label> FE Alpha Manager (quant) </label></p>
			<p><input type="checkbox" name="manager_ratings[]" value="FundCalibre Elite (qual)" required> <label> FundCalibre Elite (qual) </label></p>
			<p><input type="checkbox" name="manager_ratings[]" value="Other" id="other2" required> <label> Other </label></p>
			<p><input type="text" name="manager_ratings[]" id="other2-value" placeholder="(please state)" style="display:none"></p>
		</section>	

		<h3 style="display:none;">Progress 7</h3>
		<section>
			<p><strong>7) Do you regularly use fund data from any of the following?</strong></p>
			<p><input type="checkbox" name="regularly[]" value="Morningstar" required> <label> Morningstar </label></p>
			<p><input type="checkbox" name="regularly[]" value="Lipper" required> <label> Lipper </label></p>
			<p><input type="checkbox" name="regularly[]" value="Financial Express Analytics" required> <label> Financial Express Analytics </label></p>
			<p><input type="checkbox" name="regularly[]" value="Funds Library" required> <label> Funds Library </label></p>
			<p><input type="checkbox" name="regularly[]" value="Bloomberg" required> <label> Bloomberg </label></p>
			<p><input type="checkbox" name="regularly[]" value="Not applicable" required> <label> Not applicable </label></p>
		</section>	

		<h3 style="display:none;">Progress 8</h3>
		<section>
			<p><strong>8) Which platforms do you use?</strong></p>
			<p><input type="checkbox" name="platforms[]" value="Old Mutual Wealth" required> <label> Old Mutual Wealth </label></p>
			<p><input type="checkbox" name="platforms[]" value="Fidelity FundsNetwork" required> <label> Fidelity FundsNetwork </label></p>
			<p><input type="checkbox" name="platforms[]" value="CoFunds" required> <label> CoFunds </label></p>
			<p><input type="checkbox" name="platforms[]" value="Standard Life" required> <label> Standard Life </label></p>
			<p><input type="checkbox" name="platforms[]" value="Transact" required> <label> Transact </label></p>
			<p><input type="checkbox" name="platforms[]" value="Santander – James Hay" required> <label> Santander – James Hay </label></p>
			<p><input type="checkbox" name="platforms[]" value="Ascentric" required> <label> Ascentric </label></p>
			<p><input type="checkbox" name="platforms[]" value="7IM" required> <label> 7IM </label></p>
			<p><input type="checkbox" name="platforms[]" value="Nucleus" required> <label> Nucleus </label></p>
			<p><input type="checkbox" name="platforms[]" value="Lifetime" required> <label> Lifetime </label></p>
			<p><input type="checkbox" name="platforms[]" value="Elevate" required> <label> Elevate </label></p>
			<p><input type="checkbox" name="platforms[]" value="Not applicable" required> <label> Not applicable </label></p>
		</section>	

		<h3 style="display:none;">Progress 9</h3>
		<section>
			<p><strong>9) Which of these product types do you regularly advise your clients to use? (please tick as many boxes as appropriate)</strong></p>
			<p><input type="checkbox" name="product_type[]" value="Equity funds" required> <label> Equity funds </label></p>
			<p><input type="checkbox" name="product_type[]" value="Bond funds" required> <label> Bond funds </label></p>
			<p><input type="checkbox" name="product_type[]" value="Multi-manager funds" required> <label> Multi-manager funds </label></p>
			<p><input type="checkbox" name="product_type[]" value="Multi-asset funds" required> <label> Multi-asset funds </label></p>
			<p><input type="checkbox" name="product_type[]" value="Funds of hedge funds" required> <label> Funds of hedge funds </label></p>
			<p><input type="checkbox" name="product_type[]" value="Single strategy hedge funds" required> <label> Single strategy hedge funds </label></p>
			<p><input type="checkbox" name="product_type[]" value="Absolute return funds" required> <label> Absolute return funds </label></p>
			<p><input type="checkbox" name="product_type[]" value="130/30 funds or similar" required> <label> 130/30 funds or similar </label></p>
			<p><input type="checkbox" name="product_type[]" value="Private equity funds" required> <label> Private equity funds </label></p>
			<p><input type="checkbox" name="product_type[]" value="Property funds" required> <label> Property funds </label></p>
			<p><input type="checkbox" name="product_type[]" value="Money market / cash funds" required> <label> Money market / cash funds </label></p>
			<p><input type="checkbox" name="product_type[]" value="Closed-ended funds / investment trusts" required> <label> Closed-ended funds / investment trusts </label></p>
			<p><input type="checkbox" name="product_type[]" value="Structured products" required> <label> Structured products </label></p>
			<p><input type="checkbox" name="product_type[]" value="ETFs/ETCs" required> <label> ETFs/ETCs </label></p>
			<p><input type="checkbox" name="product_type[]" value="Index-tracking funds" required> <label> Index-tracking funds </label></p>
			<p><input type="checkbox" name="product_type[]" value="Other" id="other3" required> <label> Other </label></p>
			<p><input type="text" name="product_type[]" id="other3-value" placeholder="(please specify)" style="display:none"></p>
		</section>

		<h3 style="display:none;">Progress 10</h3>
		<section>
			<p><strong>10) Do you regularly use non-UK-domiciled funds?</strong></p>
			<p><input type="radio" name="domiciled" value="Yes" required> <label> Yes </label></p>
			<p><input type="radio" name="domiciled" value="No" required> <label> No </label></p>
			<p><input type="radio" name="domiciled" value="Not applicable" required> <label> Not applicable </label></p>
		</section>	

		<h3 style="display:none;">Progress 11</h3>
		<section>
			<p><strong>11) Which of these wrappers are important to your business?</strong></p>
			<p><input type="checkbox" name="wrappers[]" value="SIPPs" required> <label> SIPPs </label></p>
			<p><input type="checkbox" name="wrappers[]" value="Pensions" required> <label> Pensions </label></p>
			<p><input type="checkbox" name="wrappers[]" value="ISAs" required> <label> ISAs </label></p>
			<p><input type="checkbox" name="wrappers[]" value="Onshore Bonds" required> <label> Onshore Bonds </label></p>
			<p><input type="checkbox" name="wrappers[]" value="Offshore Bonds" required> <label> Offshore Bonds </label></p>
			<p><input type="checkbox" name="wrappers[]" value="Trusts" required> <label> Trusts </label></p>
			<p><input type="checkbox" name="wrappers[]" value="Not applicable" required> <label> Not applicable </label></p>
		</section>	

		<h3 style="display:none;">Progress 12</h3>
		<section>
			<p><strong>12) Which websites do you use on a regular basis? (please tick as many boxes as appropriate)</strong></p>
			<p><input type="checkbox" name="websites[]" value="portfolio-adviser.com" required> <label> portfolio-adviser.com </label></p>
			<p><input type="checkbox" name="websites[]" value="international-adviser.com" required> <label> international-adviser.com </label></p>
			<p><input type="checkbox" name="websites[]" value="ifaonline.co.uk" required> <label> ifaonline.co.uk </label></p>
			<p><input type="checkbox" name="websites[]" value="ft.com" required> <label> ft.com </label></p>
			<p><input type="checkbox" name="websites[]" value="ftadviser.com" required> <label> ftadviser.com </label></p>
			<p><input type="checkbox" name="websites[]" value="moneymarketing.co.uk" required> <label> moneymarketing.co.uk </label></p>
			<p><input type="checkbox" name="websites[]" value="citywire.co.uk" required> <label> citywire.co.uk </label></p>
			<p><input type="checkbox" name="websites[]" value="fundweb.co.uk" required> <label> fundweb.co.uk </label></p>
			<p><input type="checkbox" name="websites[]" value="investmentweek.co.uk" required> <label> investmentweek.co.uk </label></p>
			
			<!-- <p><input type="submit" name="btnsubmit" value="Submit"></p> -->
		</section>	
<?php } else if ($websiteId == 3) { ?>
		<h3 style="display:none;">Progress 1</h3>
		<section>
			<p><strong>1) Who are you regulated by? (please tick) </strong></p>
			<p><input type="radio" name="IAregulated" value="FCA" required> <label> FCA </label></p>
			<p><input type="radio" name="IAregulated" value="Wealth adviser" required> <label> Not regulated </label></p>
			<p><input type="radio" name="IAregulated" value="Other" id="other" required> <label> Other </label></p>
			<p><input type="text" name="IAregulated2" id="other-value" placeholder="(please specify)" style="display:none"></p>
		</section>	
		
		<h3 style="display:none;">Progress 2</h3>
		<section>
			<p><strong>2) Which describes your job role best? (tick most relevant)</strong></p>
			<p><input type="radio" name="IAtick" value="Independent financial adviser" required> <label> Independent financial adviser </label></p>
			<p><input type="radio" name="IAtick" value="Discretionary portfolio manager" required> <label> Discretionary portfolio manager </label></p>
			<p><input type="radio" name="IAtick" value="Wealth manager" required> <label> Wealth manager </label></p>
			<p><input type="radio" name="IAtick" value="Life company employee" required> <label> Life company employee </label></p>
			<p><input type="radio" name="IAtick" value="Private client stockbroker" required> <label> Private client stockbroker </label></p>
			<p><input type="radio" name="IAtick" value="Private client lawyer" required> <label> Private client lawyer </label></p>
			<p><input type="radio" name="IAtick" value="Private banker" required> <label> Private banker </label></p>
			<p><input type="radio" name="IAtick" value="Accountant" required> <label> Accountant </label></p>
			<p><input type="radio" name="IAtick" value="Trustee" required> <label> Trustee </label></p>
			<p><input type="radio" name="IAtick" value="Consulting actuary" required> <label> Consulting actuary </label></p>
			<p><input type="radio" name="IAtick" value="Investment researcher/analyst" required> <label> Investment researcher/analyst </label></p>
			<p><input type="radio" name="IAtick" value="Other" id="other7" required> <label> Other </label></p>
			<p><input type="text" name="IAtick2" id="other-value7" placeholder="(please specify)" style="display:none"></p>
		</section>	

		<h3 style="display:none;">Progress 3</h3>
		<section>	
			<p><strong>3) Roughly what % of your revenue comes from:</strong></p>
			<p><strong>Client fees</strong></p>
			<p><input type="radio" name="IAfees" value="0" required> <label> 0% </label></p>
			<p><input type="radio" name="IAfees" value="1-25" required> <label> 1-25% </label></p>
			<p><input type="radio" name="IAfees" value="26-50" required> <label> 26-50% </label></p>
			<p><input type="radio" name="IAfees" value="51-75" required> <label> 51-75% </label></p>
			<p><input type="radio" name="IAfees" value="76-100" required> <label> 76-100% </label></p>
			<p><input type="radio" name="IAfees" value="Not applicable" required> <label> Not applicable </label></p>

			<p><strong>Up-front commission</strong></p>
			<p><input type="radio" name="IAfront_commission" value="0" required> <label> 0% </label></p>
			<p><input type="radio" name="IAfront_commission" value="1-25" required> <label> 1-25% </label></p>
			<p><input type="radio" name="IAfront_commission" value="26-50" required> <label> 26-50% </label></p>
			<p><input type="radio" name="IAfront_commission" value="51-75" required> <label> 51-75% </label></p>
			<p><input type="radio" name="IAfront_commission" value="76-100" required> <label> 76-100% </label></p>
			<p><input type="radio" name="IAfront_commission" value="Not applicable" required> <label> Not applicable </label></p>
			
			<p><strong>Trail commission</strong></p>
			<p><input type="radio" name="IAtrail_commission" value="0" required> <label> 0% </label></p>
			<p><input type="radio" name="IAtrail_commission" value="1-25" required> <label> 1-25% </label></p>
			<p><input type="radio" name="IAtrail_commission" value="26-50" required> <label> 26-50% </label></p>
			<p><input type="radio" name="IAtrail_commission" value="51-75" required> <label> 51-75% </label></p>
			<p><input type="radio" name="IAtrail_commission" value="76-100" required> <label> 76-100% </label></p>
			<p><input type="radio" name="IAtrail_commission" value="Not applicable" required> <label> Not applicable </label></p>
		</section>		

		<h3 style="display:none;">Progress 4</h3>
		<section>	
			<p><strong>4) What is your company’s total AUM?</strong></p>
			<p><input type="radio" name="IAtotal_aum" value="Up to £10m" required> <label> Up to £10m </label></p>
			<p><input type="radio" name="IAtotal_aum" value="from £10m to £100m" required> <label> from £10m to £100m </label></p>
			<p><input type="radio" name="IAtotal_aum" value="from £100m to £1bn" required> <label> from £100m to £1bn </label></p>
			<p><input type="radio" name="IAtotal_aum" value="£1bn+" required> <label> £1bn+ </label></p>
			<p><input type="radio" name="IAtotal_aum" value="Not applicable" required> <label> Not applicable </label></p>
		</section>	

		<h3 style="display:none;">Progress 5</h3>
		<section>
			<p><strong>5) Approximately how much cross-border/offshore business do you write:</strong></p>
			<p><input type="radio" name="IAtotal_business" value="up to $500,000" required> <label> up to $500,000 </label></p>
			<p><input type="radio" name="IAtotal_business" value="from $500,000 to $1m" required> <label> from $500,000 to $1m </label></p>
			<p><input type="radio" name="IAtotal_business" value="Up to $1m to $10m" required> <label> Up to $1m to $10m </label></p>
			<p><input type="radio" name="IAtotal_business" value="from $10m to $100m+" required> <label> from $10m to $100m+ </label></p>
			<p><input type="radio" name="IAtotal_business" value="Not applicable" required> <label> Not applicable </label></p>
		</section>	

		<h3 style="display:none;">Progress 6</h3>
		<section>
			<p><strong>6) What is the average net worth of your clients:</strong></p>
			<p><input type="radio" name="IAtotal_average" value="Less than £1m" required> <label> Less than £1m </label></p>
			<p><input type="radio" name="IAtotal_average" value="from £1m to £10m" required> <label> from £1m to £10m </label></p>
			<p><input type="radio" name="IAtotal_average" value="from £10m to £100m" required> <label> from £10m to £100m </label></p>
			<p><input type="radio" name="IAtotal_average" value="£100m+" required> <label> £100m+ </label></p>
			<p><input type="radio" name="IAtotal_average" value="Not applicable" required> <label> Not applicable </label></p>
		</section>

		<h3 style="display:none;">Progress 7</h3>
		<section>
			<p><strong>7) If you use offshore bonds, which of the following companies’ products do you use?</strong></p>
			<p><input type="checkbox" name="IAoffshorebonds1" value="AIG"> <label> AIG </label></p>
			<p><input type="checkbox" name="IAoffshorebonds2" value="AG2R La Mondiale"> <label> AG2R La Mondiale </label></p>
			<p><input type="checkbox" name="IAoffshorebonds3" value="Aviva"> <label> Aviva </label></p>
			<p><input type="checkbox" name="IAoffshorebonds4" value="AXA"> <label> AXA </label></p>
			<p><input type="checkbox" name="IAoffshorebonds5" value="Canada Life Intl"> <label> Canada Life Intl </label></p>
			<p><input type="checkbox" name="IAoffshorebonds6" value="Friends Provident Intl"> <label> Friends Provident Intl </label></p>
			<p><input type="checkbox" name="IAoffshorebonds7" value="Generali Intl"> <label> Generali Intl </label></p>
			<p><input type="checkbox" name="IAoffshorebonds8" value="Hansard"> <label> Hansard </label></p>
			<p><input type="checkbox" name="IAoffshorebonds9" value="Irish Life intl"> <label> Irish Life intl </label></p>
			<p><input type="checkbox" name="IAoffshorebonds10" value="Legal & General Intl"> <label> Legal & General Intl </label></p>
			<p><input type="checkbox" name="IAoffshorebonds11" value="Old Mutual Intl"> <label> Old Mutual Intl </label></p>
			<p><input type="checkbox" name="IAoffshorebonds12" value="Prudential"> <label> Prudential </label></p>
			<p><input type="checkbox" name="IAoffshorebonds13" value="RL360"> <label> RL360 </label></p>
			<p><input type="checkbox" name="IAoffshorebonds14" value="Royal Skandia"> <label> Royal Skandia </label></p>
			<p><input type="checkbox" name="IAoffshorebonds15" value="Standard Life Intl"> <label> Standard Life Intl </label></p>
			<p><input type="checkbox" name="IAoffshorebonds16" value="Zurich"> <label> Zurich </label></p>
			<p><input type="checkbox" name="IAoffshorebonds17" value="Other" id="other2"> <label> Other </label></p>
			<p><input type="text" name="IAoffshorebonds18" id="other2-value" placeholder="(please state)" style="display:none"></p>
		</section>	

		<h3 style="display:none;">Progress 8</h3>
		<section>	
			<p><strong>8) Roughly what % of your revenue comes from:</strong></p>
			<p><strong>Offshore life bonds</strong></p>
			<p><input type="radio" name="IAofflb" value="0" required> <label> 0% </label></p>
			<p><input type="radio" name="IAofflb" value="1-25" required> <label> 1-25% </label></p>
			<p><input type="radio" name="IAofflb" value="26-50" required> <label> 26-50% </label></p>
			<p><input type="radio" name="IAofflb" value="51-75" required> <label> 51-75% </label></p>
			<p><input type="radio" name="IAofflb" value="76-100" required> <label> 76-100% </label></p>
			<p><input type="radio" name="IAofflb" value="Not applicable" required> <label> Not applicable </label></p>

			<p><strong>Personal portfolio bonds</strong></p>
			<p><input type="radio" name="IAperspb" value="0" required> <label> 0% </label></p>
			<p><input type="radio" name="IAperspb" value="1-25" required> <label> 1-25% </label></p>
			<p><input type="radio" name="IAperspb" value="26-50" required> <label> 26-50% </label></p>
			<p><input type="radio" name="IAperspb" value="51-75" required> <label> 51-75% </label></p>
			<p><input type="radio" name="IAperspb" value="76-100" required> <label> 76-100% </label></p>
			<p><input type="radio" name="IAperspb" value="Not applicable" required> <label> Not applicable </label></p>
			
			<p><strong>Int’l pensions</strong></p>
			<p><input type="radio" name="IAintlpens" value="0" required> <label> 0% </label></p>
			<p><input type="radio" name="IAintlpens" value="1-25" required> <label> 1-25% </label></p>
			<p><input type="radio" name="IAintlpens" value="26-50" required> <label> 26-50% </label></p>
			<p><input type="radio" name="IAintlpens" value="51-75" required> <label> 51-75% </label></p>
			<p><input type="radio" name="IAintlpens" value="76-100" required> <label> 76-100% </label></p>
			<p><input type="radio" name="IAintlpens" value="Not applicable" required> <label> Not applicable </label></p>

			<p><strong>Direct fund sales</strong></p>
			<p><input type="radio" name="IAdirfs" value="0" required> <label> 0% </label></p>
			<p><input type="radio" name="IAdirfs" value="1-25" required> <label> 1-25% </label></p>
			<p><input type="radio" name="IAdirfs" value="26-50" required> <label> 26-50% </label></p>
			<p><input type="radio" name="IAdirfs" value="51-75" required> <label> 51-75% </label></p>
			<p><input type="radio" name="IAdirfs" value="76-100" required> <label> 76-100% </label></p>
			<p><input type="radio" name="IAdirfs" value="Not applicable" required> <label> Not applicable </label></p>

			<p><strong>Tax/trust planning</strong></p>
			<p><input type="radio" name="IAtaxtrup" value="0" required> <label> 0% </label></p>
			<p><input type="radio" name="IAtaxtrup" value="1-25" required> <label> 1-25% </label></p>
			<p><input type="radio" name="IAtaxtrup" value="26-50" required> <label> 26-50% </label></p>
			<p><input type="radio" name="IAtaxtrup" value="51-75" required> <label> 51-75% </label></p>
			<p><input type="radio" name="IAtaxtrup" value="76-100" required> <label> 76-100% </label></p>
			<p><input type="radio" name="IAtaxtrup" value="Not applicable" required> <label> Not applicable </label></p>

			<p><strong>Cash management</strong></p>
			<p><input type="radio" name="IAcashman" value="0" required> <label> 0% </label></p>
			<p><input type="radio" name="IAcashman" value="1-25" required> <label> 1-25% </label></p>
			<p><input type="radio" name="IAcashman" value="26-50" required> <label> 26-50% </label></p>
			<p><input type="radio" name="IAcashman" value="51-75" required> <label> 51-75% </label></p>
			<p><input type="radio" name="IAcashman" value="76-100" required> <label> 76-100% </label></p>
			<p><input type="radio" name="IAcashman" value="Not applicable" required> <label> Not applicable </label></p>

			<p><strong>Int’l protection</strong></p>
			<p><input type="radio" name="IAintlprot" value="0" required> <label> 0% </label></p>
			<p><input type="radio" name="IAintlprot" value="1-25" required> <label> 1-25% </label></p>
			<p><input type="radio" name="IAintlprot" value="26-50" required> <label> 26-50% </label></p>
			<p><input type="radio" name="IAintlprot" value="51-75" required> <label> 51-75% </label></p>
			<p><input type="radio" name="IAintlprot" value="76-100" required> <label> 76-100% </label></p>
			<p><input type="radio" name="IAintlprot" value="Not applicable" required> <label> Not applicable </label></p>

			<p><strong>Int’l health insurance</strong></p>
			<p><input type="radio" name="IAintlhealthins" value="0" required> <label> 0% </label></p>
			<p><input type="radio" name="IAintlhealthins" value="1-25" required> <label> 1-25% </label></p>
			<p><input type="radio" name="IAintlhealthins" value="26-50" required> <label> 26-50% </label></p>
			<p><input type="radio" name="IAintlhealthins" value="51-75" required> <label> 51-75% </label></p>
			<p><input type="radio" name="IAintlhealthins" value="76-100" required> <label> 76-100% </label></p>
			<p><input type="radio" name="IAintlhealthins" value="Not applicable" required> <label> Not applicable </label></p>
		</section>		

		<h3 style="display:none;">Progress 9</h3>
		<section>
			<p><strong>9) Which of the following fund ratings do you use?</strong></p>
			<p><input type="checkbox" name="IAfundratings1" value="Morningstar (qual)"> <label> Morningstar (qual) </label></p>
			<p><input type="checkbox" name="IAfundratings2" value="Morningstar (quant)"> <label> Morningstar (quant) </label></p>
			<p><input type="checkbox" name="IAfundratings3" value="FE Crown (quant)"> <label> FE Crown (quant) </label></p>
			<p><input type="checkbox" name="IAfundratings4" value="Lipper Leader (quant)"> <label> Lipper Leader (quant) </label></p>
			<p><input type="checkbox" name="IAfundratings5" value="Citywire (quant)"> <label> Citywire (quant) </label></p>
			<p><input type="checkbox" name="IAfundratings6" value="FE Alpha Manager (quant)"> <label> FE Alpha Manager (quant) </label></p>
			<p><input type="checkbox" name="IAfundratings7" value="Other" id="other4"> <label> Other </label></p>
			<p><input type="text" name="IAfundratings8" id="other4-value" placeholder="(please state)" style="display:none"></p>
		</section>	

		<h3 style="display:none;">Progress 10</h3>
		<section>
			<p><strong>10) Which international financial centres do you use for your clients?</strong></p>
			<p><input type="checkbox" name="IAintfincen1" value="Jersey"> <label> Jersey </label></p>
			<p><input type="checkbox" name="IAintfincen2" value="Guernsey"> <label> Guernsey </label></p>
			<p><input type="checkbox" name="IAintfincen3" value="Dublin"> <label> Dublin </label></p>
			<p><input type="checkbox" name="IAintfincen4" value="Isle of Man"> <label> Isle of Man </label></p>
			<p><input type="checkbox" name="IAintfincen5" value="Luxembourg"> <label> Luxembourg </label></p>
			<p><input type="checkbox" name="IAintfincen6" value="Switzerland"> <label> Switzerland </label></p>
			<p><input type="checkbox" name="IAintfincen7" value="Bermuda"> <label> Bermuda </label></p>
			<p><input type="checkbox" name="IAintfincen8" value="Bahamas"> <label> Bahamas </label></p>
			<p><input type="checkbox" name="IAintfincen9" value="Cayman Islands"> <label> Cayman Islands </label></p>
			<p><input type="checkbox" name="IAintfincen10" value="BVI"> <label> BVI </label></p>
			<p><input type="checkbox" name="IAintfincen11" value="Other" id="other5"> <label> Other </label></p>
			<p><input type="text" name="IAintfincen12" id="other5-value" placeholder="(please state)" style="display:none"></p>
		</section>	

		<h3 style="display:none;">Progress 11</h3>
		<section>
			<p><strong>11) Which of these product types do you regularly advise your clients to use? (please tick as many boxes as appropriate)</strong></p>
			<p><input type="checkbox" name="IAproduct_type1" value="Equity funds"> <label> Equity funds </label></p>
			<p><input type="checkbox" name="IAproduct_type2" value="Bond funds"> <label> Bond funds </label></p>
			<p><input type="checkbox" name="IAproduct_type3" value="Multi-manager / funds of funds"> <label> Multi-manager / funds of funds </label></p>
			<p><input type="checkbox" name="IAproduct_type4" value="Funds of hedge funds"> <label> Funds of hedge funds </label></p>
			<p><input type="checkbox" name="IAproduct_type5" value="Single strategy hedge funds"> <label> Single strategy hedge funds </label></p>
			<p><input type="checkbox" name="IAproduct_type6" value="130/30 funds or similar alternatives"> <label> 130/30 funds or similar alternatives</label></p>
			<p><input type="checkbox" name="IAproduct_type7" value="Private equity funds"> <label> Private equity funds </label></p>
			<p><input type="checkbox" name="IAproduct_type8" value="Property funds"> <label> Property funds </label></p>
			<p><input type="checkbox" name="IAproduct_type9" value="Money market / cash funds"> <label> Money market / cash funds </label></p>
			<p><input type="checkbox" name="IAproduct_type10" value="Closed-ended funds / investment trusts"> <label> Closed-ended funds / investment trusts </label></p>
			<p><input type="checkbox" name="IAproduct_type11" value="Structured products"> <label> Structured products </label></p>
			<p><input type="checkbox" name="IAproduct_type12" value="ETFs/ETCs"> <label> ETFs/ETCs </label></p>
			<p><input type="checkbox" name="IAproduct_type13" value="Index-tracking funds"> <label> Index-tracking funds </label></p>
			<p><input type="checkbox" name="IAproduct_type14" value="Multi-asset funds"> <label> Multi-asset funds </label></p>
			<p><input type="checkbox" name="IAproduct_type15" value="Absolute return funds"> <label> Absolute return funds </label></p>
			<p><input type="checkbox" name="IAproduct_type16" value="Other" id="other3"> <label> Other </label></p>
			<p><input type="text" name="IAproduct_type17" id="other3-value" placeholder="(please specify)" style="display:none"></p>
		</section>

		<h3 style="display:none;">Progress 12</h3>
		<section>
			<p><strong>12) For your UK clients do you regularly use non-UK domiciled funds with distributor status?</strong></p>
			<p><input type="radio" name="IAdomiciled" value="Yes" required> <label> Yes </label></p>
			<p><input type="radio" name="IAdomiciled" value="No" required> <label> No </label></p>
			<p><input type="radio" name="IAdomiciled" value="Not applicable" required> <label> Not applicable </label></p>
		</section>	

		<h3 style="display:none;">Progress 13</h3>
		<section>
			<p><strong>13) In general, do you prefer to use local products or cross-border/offshore products?</strong></p>
			<p><input type="radio" name="IAlocof" value="Local" required> <label> Local </label></p>
			<p><input type="radio" name="IAlocof" value="Offshore" required> <label> Offshore </label></p>
			<p><input type="radio" name="IAlocof" value="Not applicable" required> <label> Not applicable </label></p>
		</section>	

		<h3 style="display:none;">Progress 14</h3>
		<section>
			<p><strong>14) What percentage of your clients are:</strong></p>
			<p><strong>Expatriates</strong></p>
			<p><input type="radio" name="IACexpat" value="0" required> <label> 0% </label></p>
			<p><input type="radio" name="IACexpat" value="1-25" required> <label> 1-25% </label></p>
			<p><input type="radio" name="IACexpat" value="26-50" required> <label> 26-50% </label></p>
			<p><input type="radio" name="IACexpat" value="51-75" required> <label> 51-75% </label></p>
			<p><input type="radio" name="IACexpat" value="76-100" required> <label> 76-100% </label></p>
			<p><input type="radio" name="IACexpat" value="Not applicable" required> <label> Not applicable </label></p>

			<p><strong>Local</strong></p>
			<p><input type="radio" name="IAClocal" value="0" required> <label> 0% </label></p>
			<p><input type="radio" name="IAClocal" value="1-25" required> <label> 1-25% </label></p>
			<p><input type="radio" name="IAClocal" value="26-50" required> <label> 26-50% </label></p>
			<p><input type="radio" name="IAClocal" value="51-75" required> <label> 51-75% </label></p>
			<p><input type="radio" name="IAClocal" value="76-100" required> <label> 76-100% </label></p>
			<p><input type="radio" name="IAClocal" value="Not applicable" required> <label> Not applicable </label></p>

			<p><strong>Other</strong></p>
			<p><input type="radio" name="IACother" value="0" required> <label> 0% </label></p>
			<p><input type="radio" name="IACother" value="1-25" required> <label> 1-25% </label></p>
			<p><input type="radio" name="IACother" value="26-50" required> <label> 26-50% </label></p>
			<p><input type="radio" name="IACother" value="51-75" required> <label> 51-75% </label></p>
			<p><input type="radio" name="IACother" value="76-100" required> <label> 76-100% </label></p>
			<p><input type="radio" name="IACother" value="Not applicable" required> <label> Not applicable </label></p>
			
			<!-- <p><input type="submit" name="btnsubmit" value="Submit"></p> -->
		</section>	

<?php } else if ($websiteId == 5) { ?>
	
	<h3 style="display:none;">Progress 1</h3>
	<section>
		<p><strong>1) Is your company a: (tick most relevant box only)</strong></p>
		<p><input type="radio" name="EIcomptype" value="Bank" required> <label> Bank </label></p>
		<p><input type="radio" name="EIcomptype" value="Private bank" required> <label> Private bank </label></p>
		<p><input type="radio" name="EIcomptype" value="Wealth Manager" required> <label> Wealth Manager </label></p>
		<p><input type="radio" name="EIcomptype" value="Wealth advisor" required> <label> Wealth advisor </label></p>
		<p><input type="radio" name="EIcomptype" value="Pension fund" required> <label> Pension fund </label></p>
		<p><input type="radio" name="EIcomptype" value="Insurance Company" required> <label> Insurance Company </label></p>
		<p><input type="radio" name="EIcomptype" value="Family Office" required> <label> Family Office </label></p>
		<p><input type="radio" name="EIcomptype" value="Investment research company" required> <label> Investment research company </label></p>
		<p><input type="radio" name="EIcomptype" value="Fund of Funds" required> <label> Fund of Funds </label></p>
		<p><input type="radio" name="EIcomptype" value="Independent financial adviser" required> <label> Independent financial adviser </label></p>
		<p><input type="radio" name="EIcomptype" value="Other" id="other" required> <label> Other </label></p>
		<p><input type="text" name="EIcomptype2" id="other-value" placeholder="(please specify)" style="display:none"></p>
	</section>	
	
	<h3 style="display:none;">Progress 2</h3>
	<section>	
		<p><strong>2) What is your company’s total AUM?</strong></p>
		<p><input type="radio" name="EItotal_aum" value="Up to €100m" required> <label> Up to €100m </label></p>
		<p><input type="radio" name="EItotal_aum" value="from €100m to €500m" required> <label> from €100m to €500m </label></p>
		<p><input type="radio" name="EItotal_aum" value="from €500m to €1bn" required> <label> from €500m to €1bn </label></p>
		<p><input type="radio" name="EItotal_aum" value="€1bn+" required> <label> €1bn+ </label></p>
		<p><input type="radio" name="EItotal_aum" value="Not applicable" required> <label> Not applicable </label></p>
	</section>	

	<h3 style="display:none;">Progress 3</h3>
	<section>	
		<p><strong>3) How much of your AUM is in 3rd party funds?</strong></p>
		<p><input type="radio" name="EI3pfaum" value="0-20%" required> <label> 0-20% </label></p>
		<p><input type="radio" name="EI3pfaum" value="20-40%" required> <label> 20-40% </label></p>
		<p><input type="radio" name="EI3pfaum" value="40-60%" required> <label> 40-60% </label></p>
		<p><input type="radio" name="EI3pfaum" value="60-80%" required> <label> 60-80% </label></p>
		<p><input type="radio" name="EI3pfaum" value="80-100%" required> <label> 80-100% </label></p>
	</section>	
	
	<h3 style="display:none;">Progress 4</h3>
		<section>
			<p><strong>4) What fund types do you use?</strong></p>
			<p><input type="radio" name="EIfundtypes" value="SICAV" required> <label> SICAV </label></p>
			<p><input type="radio" name="EIfundtypes" value="UCITS" required> <label> UCITS </label></p>
		</section>	


<?php } ?>
	</div>
</form>
<?php
}
?>
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
		   if(jQuery(this).attr('id') == 'other7') {
				jQuery('#other-value7').show();           
		   }

		   else {
				jQuery('#other-value7').hide();   
		   }
		});

		jQuery('#other').change(function(){
			if(this.prop("checked", true))
				jQuery('#other-value').show();
			else
				jQuery('#other-value').hide();

		});
		
		jQuery('#other2').change(function(){
			if(this.checked)
				jQuery('#other2-value').show();
			else
				jQuery('#other2-value').hide();

		});
		jQuery('#other3').change(function(){
			if(this.checked)
				jQuery('#other3-value').show();
			else
				jQuery('#other3-value').hide();

		});
		jQuery('#other4').change(function(){
			if(this.checked)
				jQuery('#other4-value').show();
			else
				jQuery('#other4-value').hide();

		});
		jQuery('#other5').change(function(){
			if(this.checked)
				jQuery('#other5-value').show();
			else
				jQuery('#other5-value').hide();

		});
		jQuery('#other6').change(function(){
			if(this.checked)
				jQuery('#other6-value').show();
			else
				jQuery('#other6-value').hide();

		});
		jQuery('#other7').change(function(){
			if(this.checked)
				jQuery('#other7-value').show();
			else
				jQuery('#other7-value').hide();

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
	}

	form#req-magazine label.error {
		display: block;
		margin-top: 10px;
		color: #f00;
	}

	form#req-magazine input.error {
		border: 2px solid #f00;
	}

	form#req-magazine select {
	    background-color: #ffffff;
	    color: #000;
	    padding: 8px 10px 8px;
	    vertical-align: bottom;
	    height: 40px;
	    font-size: 100%;
	    font-weight: normal;
	}

</style>