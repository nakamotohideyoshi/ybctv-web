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
		'Image' => 'image',
		'Link' => 'text',
		'Title' => 'text',
		'Body' => 'editor',
		'CTA' => 'editor'
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
		'Left Box Title' => 'text',
		'Left Box Subtitle' => 'text',
		'Left Box Body' => 'text',
		'Left Box Image' => 'image',
		'Left Box Image Link' => 'text',

		'Right Box Title' => 'text',
		'Right Box Body' => 'text',
		'Right Box Image' => 'image',
		'Right Box Image Link' => 'text'
	)
);

if ( $static != null && isset( $static->Data ) ) {
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
		<?php include('email-builder-editor-tpl-form-fields.php'); ?>

		<div class="col">
			<div class="formfield">
				<label>Preview</label>
				
				<div class="preview-box"></div>
			</div>
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
