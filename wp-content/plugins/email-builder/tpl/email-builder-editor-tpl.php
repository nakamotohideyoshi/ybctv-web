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
		<?php if ( strpos( trim($fragment_type), 'Top_Leaderboard' ) !== false ): ?>
			<?php include('email-builder-editor-tpl-top-leaderboard.php'); ?>
		<?php else: ?>
			<?php include('email-builder-editor-tpl-sponsored-content2.php'); ?>
		<?php endif; ?>

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
