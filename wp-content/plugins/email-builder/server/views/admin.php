<?php echo '<div id="root"></div>'; ?>
<?php $current_user = wp_get_current_user(); ?>

<script type="text/javascript">
	window.EmailBuilderEditor = {
		'Id': <?php echo isset($current_user->ID) ? $current_user->ID : 0; ?>, 
		'DisplayName': '<?php echo isset($current_user->display_name) ? addslashes($current_user->display_name) : ''; ?>'
	};
</script>
