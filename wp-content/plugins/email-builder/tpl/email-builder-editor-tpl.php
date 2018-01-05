<?php 

include('email-builder-editor-tpl-php.php');

$fragment_site = $_GET['site'];
$fragment_template = $_GET['template'];
$fragment_type = $_GET['type'];

$data = array(
	'title' => '',
	'image' => '',
	'image_link' => '',
	'subtitle' => '',
	'excerpt' => '',
	'source_code' => ''
);

$config = array(
	'Digital_Magazine' => array(
		'Link' => 'text',
		'Image' => 'image',
		'Button Text' => 'text'
	),
	'Digital_Magazine_2' => array(
		'Image' => 'image',
		'Link' => 'text',
		'Title' => 'text',
		'Body' => 'editor',
		'CTA' => 'editor'
	),
	'Newsletter_Subscribe' => array(
		'Link' => 'text',
		'Image' => 'image',
		'Button Text' => 'text'
	),
	'Top_Leaderboard' => array(
		'Image' => 'image',
		'Image Link' => 'text'
	),
	'Footer_Leaderboard' => array(
		'Image' => 'image',
		'Image Link' => 'text'
	),
	'Static_Image_1' => array(
		'Image' => 'image',
		'Image Link' => 'text'
	),
	'Static_Image_2' => array(
		'Image' => 'image',
		'Image Link' => 'text'
	),
	'Sponsored_Content' => array(
		'Body' => 'editor',
		'Image' => 'image',
		'Image Link' => 'text'
	),
	'Sponsored_Content_2' => array(
		'Title' => 'text',
		'Image' => 'image',
		'Image Link' => 'text',
		'Subtitle' => 'editor',
		'Excerpt' => 'editor'
	),
	'Quotable' => array(
		'Title' => 'text',
		'Subtitle' => 'text',
		'Image' => 'image',
		'Body' => 'editor',
		'Footer' => 'editor'
	),
	'Asset_Class' => array(
		'Title' => 'text',
		'Boxes Count' => 'select:2,4,6',
		
		'Left Box Title' => 'text',
		'Left Box Subtitle' => 'text',
		'Left Box Body' => 'text',
		'Left Box Image' => 'image',
		'Left Box Image Link' => 'text',
		'Left Box Color' => 'select:white,gray',

		'Right Box Title' => 'text',
		'Right Box Subtitle' => 'text',
		'Right Box Body' => 'text',
		'Right Box Image' => 'image',
		'Right Box Image Link' => 'text',
		'Right Box Color' => 'select:white,gray',

		'Left Box Title 3' => 'text',
		'Left Box Subtitle 3' => 'text',
		'Left Box Body 3' => 'text',
		'Left Box Image 3' => 'image',
		'Left Box Image Link 3' => 'text',
		'Left Box Color 3' => 'select:white,gray',

		'Right Box Title 4' => 'text',
		'Right Box Subtitle 4' => 'text',
		'Right Box Body 4' => 'text',
		'Right Box Image 4' => 'image',
		'Right Box Image Link 4' => 'text',
		'Right Box Color 4' => 'select:white,gray',

		'Left Box Title 5' => 'text',
		'Left Box Subtitle 5' => 'text',
		'Left Box Body 5' => 'text',
		'Left Box Image 5' => 'image',
		'Left Box Image Link 5' => 'text',
		'Left Box Color 5' => 'select:white,gray',

		'Right Box Title 6' => 'text',
		'Right Box Subtitle 6' => 'text',
		'Right Box Body 6' => 'text',
		'Right Box Image 6' => 'image',
		'Right Box Image Link 6' => 'text',
		'Right Box Color 6' => 'select:white,gray'
	)
);

if ( $static == null ) {
	$static = new stdClass();
}
if ( !isset( $static->Version ) ) {
	$static->Version = '';	
}
if ( !isset( $static->Data ) ) {
	$static->Data = '';	
}

if ( $static != null && isset( $static->Data ) ) {
	if ( trim($static->Data) == '' ) {
		if ( strpos( $fragment_type, 'Top_Leaderboard' ) !== false ) {
			$static->Data = '{"image":"https:\/\/lastword.staging.wpengine.com\/wp-content\/uploads\/2017\/11\/banner728x90.gif","image_link":"https:\/\/addyourcustomlinkhere.com","dummy":"","source_code":"<table class=\"device_innerblock mce-item-table\" width=\"728\" align=\"center\"><tbody><tr><td style=\"padding: 10px 10px 10px 10px;\" align=\"center\"><a href=\"{{image_link}}\" target=\"_blank\"> <img src=\"{{image}}\" alt=\"\"> <\/a><\/td><\/tr><\/tbody><\/table>"}';
		} else if ( strpos( $fragment_type, 'Footer_Leaderboard' ) !== false ) {
			$static->Data = '{"image":"https:\/\/lastword.staging.wpengine.com\/wp-content\/uploads\/2017\/11\/banner728x90.gif","image_link":"https:\/\/addyourcustomlinkhere.com","dummy":"","source_code":"<table class=\"device_innerblock mce-item-table\" width=\"728\" align=\"center\"><tbody><tr><td style=\"padding: 10px 10px 10px 10px;\" align=\"center\"><a href=\"{{image_link}}\" target=\"_blank\"> <img src=\"{{image}}\" alt=\"\"> <\/a><\/td><\/tr><\/tbody><\/table>"}';
		} else if ( strpos( $fragment_type, 'Newsletter_Subscribe' ) !== false ) {
			$static->Data = '{"link":"https:\/\/lastword.turtl.co\/story\/5978733d704eae3793d45073","image":"http:\/\/pa-cms-lastwordmedia-com.lastword.staging.wpengine.com\/wp-content\/uploads\/sites\/2\/2017\/08\/PA_alts_guide_macbook_444px.png","button_text":"Click here!","dummy":"","source_code":"<table class=\"subscribe\" style=\"width: 100%;\">\r\n<tbody>\r\n<tr>\r\n<td style=\"padding: 0px 0px 10px 0px; color: #004588; font-size: 14px; font-family: Arial;\"><center><a href=\"{{link}}\"><img src=\"{{image}}\" alt=\"\" width=\"200\" data-width=\"200\" \/><\/a><\/center><\/td>\r\n<\/tr>\r\n<tr>\r\n<td style=\"padding: 6px 0px; font-size: 14px;\" align=\"center\" bgcolor=\"#64a70b\"><strong><span style=\"font-family: Arial;\"><a style=\"text-decoration: none; color: #fff;\" href=\"{{link}}\">{{button_text}}<\/a><\/span><\/strong><\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>"}';
		} else if ( strpos( $fragment_type, 'Digital_Magazine' ) !== false ) {
			$static->Data = '{"image":"http:\/\/pa-cms-lastwordmedia-com.lastword.staging.wpengine.com\/wp-content\/uploads\/sites\/2\/2017\/08\/Coverforweb-272x346-1.gif","link":"http:\/\/magazine.portfolio-adviser.com\/onlinereader\/html5_reader.aspx?issueid=154432","title":"Portfolio Adviser - September 2017","body":"The September issue of Portfolio Adviser magazine is now available to read online. View your digital edition by clicking on the link below, or download the free Portfolio Adviser App through your app store.\r\n<ul>\r\n \t<li>adsadada<\/li>\r\n \t<li>dsada<\/li>\r\n \t<li>dasdasdas<\/li>\r\n<\/ul>\r\n<ol>\r\n \t<li>dwqdqwdqw<\/li>\r\n \t<li>dwqd<\/li>\r\n \t<li>qwdwqdwq<\/li>\r\n<\/ol>","cta":"<a href=\"http:\/\/magazine.portfolio-adviser.com\/onlinereader\/html5_reader.aspx?issueid=154432\">CLICK HERE TO GET YOUR ISSUE<\/a>","dummy":"","source_code":"<table style=\"border-bottom: 1px solid #e5eaee;\" border=\"0\" width=\"100%\"><tbody><tr>\r\n<td class=\"container_sub\" style=\"padding: 20px 10px 14px 0px; vertical-align: top;\" width=\"32%\"><a href=\"{{link}}\" target=\"_blank\" rel=\"noopener\"><img style=\"max-width: 100%;\" title=\"PA September\" src=\"{{image}}\" alt=\"\" \/><\/a><\/td>\r\n<td class=\"container_sub\" style=\"vertical-align: top; padding: 13px 0px 14px;\" width=\"68%\">\r\n<table border=\"0\" width=\"100%\">\r\n<tbody><tr>\r\n<td style=\"padding: 0px 0px 7px;\"><a style=\"font-size: 14px; font-family: Arial, Helvetica, sans-serif; text-decoration: none; color: #64a70b;\" href=\"{{link}}\" target=\"_blank\" rel=\"noopener\">{{title}}<\/a><\/td>\r\n<\/tr><tr>\r\n<td style=\"color: #2c2c2c; font-size: 14px; font-family: Arial, Helvetica, sans-serif; line-height: 20px;\">{{body}}<\/td>\r\n<\/tr><tr>\r\n<td style=\"color: #2c2c2c; font-size: 14px; font-family: Arial, Helvetica, sans-serif; line-height: 17px; padding-top: 23px;\">{{cta}}<\/td>\r\n<\/tr><\/tbody><\/table><\/td><\/tr><\/tbody><\/table>\r\n"}';
		} else if ( strpos( $fragment_type, 'Sponsored_Content_2' ) !== false ) {
			$static->Data = '{"title":"Sponsored article by Fund","image":"http:\/\/pa-cms-lastwordmedia-com.lastword.staging.wpengine.com\/wp-content\/uploads\/sites\/2\/2017\/08\/IMG1225-219x122.jpg","image_link":"https:\/\/addyourcustomlinkhere.com","subtitle":"<a href=\"http:\/\/www.example.com\"><strong>This is a subheading to customise<\/strong><\/a>","excerpt":"Much has been written about adding Christmas trees to peoples gardens and then adding them to bonds to make money on them.","dummy":"","source_code":"<table style=\"border-bottom: 1px solid #e5eaee;\" border=\"0\" width=\"100%\" class=\"mce-item-table\"><tbody><tr><td class=\"container_sub\" style=\"padding: 20px 10px 14px 0px; vertical-align: top;\"><a href=\"{{image_link}}\"><img src=\"{{image}}\" alt=\"\" \/><\/a><\/td><td class=\"container_sub\" style=\"vertical-align: top; padding: 13px 0px 14px;\"><table border=\"0\" width=\"100%\" class=\"mce-item-table\"><tbody><tr><td class=\"anchor_color\" style=\"padding: 0px 0px 7px; color: #4caf50!important; font-size: 14px; font-family: Arial, Helvetica, sans-serif; font-weight: bold;\"><font face=\"Arial, Helvetica, sans-serif;\">{{title}}<\/font><\/td><\/tr><tr><td style=\"padding: 0px 0px 7px; font-family: \'Arial\'; font-size: 15px; font-weight: bold;\">{{subtitle}}<\/td><\/tr><tr><td class=\"container_td\" style=\"color: #2c2c2c!important; font-size: 14px; font-family: Arial, Helvetica, sans-serif; line-height: 20px;\">{{excerpt}}<\/td><\/tr><\/tbody><\/table><\/td><\/tr><\/tbody><\/table>"}';
		} else if ( strpos( $fragment_type, 'Sponsored_Content' ) !== false ) {
			$static->Data = '{"body":"<strong>SPONSORED MESSAGE<\/strong>\r\n\r\n<strong>HERE IS YOUR CUSTOM TITLE<\/strong>\r\n\r\n<strong>This is a sub heading<\/strong>\r\n\r\nAnd here is a link to <a href=\"http:\/\/www.lastwordmedia.com\">click<\/a>\r\n\r\nFor many investors, bonds play a key part in their portfolio &ndash; the attractions being diversification and a source of income. The Fund is unusual in this asset class, because it is only one of a few funds that have a monthly income distribution. Investing primarily in fixed interest securities, flexibility is built in with the investment team taking a strategic view and responding tactically to market conditions. Aiming to generate a high and sustainable income, the fund has a strong track record of performance.\r\n\r\nSign up to our fixed income insight series. We will be delving in to the world of fixed income and exploring themes and topics that better explain the benefits of including this asset class in your portfolio.\r\n\r\n<a href=\"http:\/\/www.example.com\" target=\"_blank\" rel=\"noopener\">Time to take a closer look?<\/a>\r\n\r\nFor professional advisers only. Past performance is not a guide to future performance. The value of an investment and the income from it can fall as well as rise and you may not get back the amount originally <a href=\"http:\/\/www.google.com\">invested<\/a>.","image":"https:\/\/lastword.staging.wpengine.com\/wp-content\/uploads\/2017\/12\/logo-placeholder.png","image_link":"http:\/\/www.matthewsasia.com","dummy":"","source_code":"<table class=\"device_linked\" style=\"border: 1px solid #A1A1A1;\" width=\"728\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td>\r\n<table class=\"static_content linked\" style=\"width: 550px;\" align=\"left\">\r\n<tbody>\r\n<tr>\r\n<td style=\"padding: 14px;\">\r\n<table style=\"width: 100%;\">\r\n<tbody>\r\n<tr>\r\n<td style=\"color: #3b3b3b; font-size: 12px; font-family: Arial, Helvetica, sans-serif; text-align: left;\">{{body}}<\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>\r\n<\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>\r\n<table class=\"linked\" width=\"125\" align=\"right\">\r\n<tbody>\r\n<tr>\r\n<td style=\"padding: 14px; vertical-align: top;\" align=\"right\"><a title=\"Newsletter_Sponsored_Content\" href=\"{{image_link}}\"><img src=\"{{image}}\" alt=\"sponsor\" \/><\/a><\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>\r\n<\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>"}';
		} else if ( strpos( $fragment_type, 'Static_Image_1' ) !== false ) {
			$static->Data = '{"image":"https:\/\/lastword.staging.wpengine.com\/wp-content\/uploads\/2017\/12\/FSA-Web-Banners.jpg","image_link":"https:\/\/addyourcustomlinkhere.com","dummy":"","source_code":"<table width=\"300\">\r\n<tr>\r\n<td>\r\n<a href=\"{{image_link}}\"><img src=\"{{image}}\" \/><\/a>\r\n<\/td>\r\n<\/tr>\r\n<\/table>"}';
		} else if ( strpos( $fragment_type, 'Static_Image_2' ) !== false ) {
			$static->Data = '{"image":"https:\/\/lastword.staging.wpengine.com\/wp-content\/uploads\/2017\/12\/FSA-Web-Banners.jpg","image_link":"https:\/\/addyourcustomlinkhere.com","dummy":"","source_code":"<table width=\"300\">\r\n<tr>\r\n<td>\r\n<a href=\"{{image_link}}\"><img src=\"{{image}}\" \/><\/a>\r\n<\/td>\r\n<\/tr>\r\n<\/table>"}';
		} else if ( strpos( $fragment_type, 'Quotable' ) !== false ) {
			$static->Data = '{"title":"Here is the title","subtitle":"Customise the subtitle","image":"https:\/\/lastword.staging.wpengine.com\/wp-content\/uploads\/2017\/12\/In-case-small.jpg","body":"This is the body","footer":"<a href=\"https:\/\/fundselectorasia.com\/\">A footer link<\/a>","dummy":"","source_code":"<p>\u00a0<\/p>\r\n<table class=\"fund_linked\" style=\"margin: 0px auto;\" border=\"0\" width=\"321\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td class=\"container_td\" style=\"padding: 0px 0px 8px; font-size: 20px; font-weight: normal; line-height: 16px; color: #2c2c2c !important; text-align: left;\"><font face=\"Arial, Helvetica, sans-serif\">{{title}}<\/font><\/td>\r\n<\/tr>\r\n<tr>\r\n<td>\r\n<table style=\"width: 100%; background-color: #f2f3f5;\" border=\"0\">\r\n<tbody>\r\n<tr>\r\n<td style=\"padding-left: 10px;\">\r\n<h3 style=\"text-align: center;\">{{subtitle}}<\/h3>\r\n<\/td>\r\n<\/tr>\r\n<tr>\r\n<td style=\"font-size: 14px; line-height: 20px; padding: 4px 10px; font-style: italic; color: #090909;\">\r\n<div class=\"center tinyimg_caption\" style=\"width: 297px;\">\r\n<div class=\"center tinyimg_caption\" style=\"width: 304px;\"><img src=\"{{image}}\" alt=\"\" \/><\/div>\r\n<\/div>\r\n<\/td>\r\n<\/tr>\r\n<tr>\r\n<td style=\"font-size: 14px; line-height: 20px; padding: 4px 10px; font-style: color: #090909;\">{{body}}<\/td>\r\n<\/tr>\r\n<tr>\r\n<td style=\"font-size: 14px; line-height: 20px; padding: 4px 10px; text-align: right;\">{{footer}}<\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>\r\n<\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>"}';
		}
	}

	$dbData = json_decode($static->Data, true);

	if ( is_array( $dbData ) ) {
		foreach ( $dbData as $key => $value ) {
			$data[ $key ] = $value;
		}
	}
}

?>

<script type="text/javascript">
	var fragment = {
		'site': '<?php echo $fragment_site; ?>',
		'template': '<?php echo $fragment_template; ?>',
		'type': '<?php echo $fragment_type; ?>'
	};
</script>

<?php
include('email-builder-editor-tpl-css.php');
include('email-builder-editor-tpl-js.php');
?>

<h3 style="text-transform: uppercase; line-height: 2;">
	Template: <?php echo str_replace('_', ' ', $fragment_site); ?><br/>
	Fragment Type: <?php echo str_replace('_', ' ', $fragment_type); ?>
</h3>

<form action="" class="form" method="post">
	<input type="hidden" name="site" value="<?php echo $fragment_site; ?>" />
	<input type="hidden" name="template" value="<?php echo $fragment_template; ?>" />
	<input type="hidden" name="type" value="<?php echo $fragment_type; ?>" />

	<div class="cols">
		<?php $fragment_type_normalized = str_replace(array('_a','_b','_c','_d','_e','_f'), '', $fragment_type); ?>
		<?php $fragment_type_normalized = str_replace(array('_1a','_1b','_1c','_1d','_1e','_1f'), '_1', $fragment_type_normalized); ?>
		<?php $fragment_type_normalized = str_replace(array('_2a','_2b','_2c','_2d','_2e','_2f'), '_2', $fragment_type_normalized); ?>
		<?php $GLOBALS['email_builder_editor_config'] = $config[ $fragment_type_normalized ]; ?>

		<?php if ( $fragment_type_normalized == 'Asset_Class' ): ?>
			<?php include('email-builder-editor-tpl-form-fields-asset-class.php'); ?>
		<?php else: ?>
			<?php include('email-builder-editor-tpl-form-fields.php'); ?>
		<?php endif; ?>

		<div class="col" style="clear: both; width: 100%;">
			<div class="formfield">
				<label>Preview</label>
				
				<div class="preview-box" style="overflow: auto;"></div>
			</div>
			<?php if ( isset($static->Version) && $static->Version != 2 ): ?>
				<div class="formfied">
					<strong>Warning - Read this before editing this static the first time.</strong>
					<br/>
					This preview is of the current legacy static fragment created with the version 1 static editor. The legacy static fragment will remain draggable until you create/save a new static fragment in this new editor.  You will not be able to access/use the legacy static fragment created with the old editor after you save a new version here.
					<br/><br/>
				</div>
			<?php endif; ?>
			<div class="formfield">
				<input type="submit" value="Save and Refresh Preview" class="button button-primary button-large" />
				<button type="button" class="button button-large close-window">Close</button>
			</div>
		</div>
	</div>
	<div class="formfield triggerable">
		<hr/>
		<div class="triggerable-button">
			<button type="button" class="show button button-large">Show Source Code</button>
			&nbsp;
			<button type="button" class="hide button button-large">Hide Source Code</button>
		</div>
		<div class="triggerable-content">
			<label>Source code</label>
			<textarea name="data_source_code"><?php echo isset($data['source_code']) ? $data['source_code']: ''; ?></textarea>
		</div>
		<hr/>
	</div>
</div>
