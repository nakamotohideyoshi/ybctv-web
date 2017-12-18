<?php global $email_builder_editor_config; ?>

<div class="col">
	<?php if ( isset($email_builder_editor_config) && !is_null($email_builder_editor_config) && is_array($email_builder_editor_config) ): ?>
		<?php foreach ( $email_builder_editor_config as $title => $type ): ?>
			<?php $key = strtolower(str_replace(' ', '_', $title)); ?>
			<?php $dataKey = 'data_' . $key; ?>

			<?php if (  $type == 'image'  ): ?>
				<?php $image = isset($data[$key]) ? $data[$key]: ''; ?>
				<div class="formfield upload <?php echo $image != '' ? 'active' : ''; ?>">
					<label><?php echo $title; ?></label>
					
					<button type="button" class="button add-image-button">Add Image</button>
					<button type="button" class="button update-image-button">Update Image</button>
					<button type="button" class="button remove-image-button">Remove Image</button>
					<br/><br/>
					<input type="hidden" name="<?php echo $dataKey; ?>" value="<?php echo $image; ?>" />
					<img src="<?php echo $image; ?>" />
				</div>
			<?php elseif ( $type == 'text' ): ?>
				<div class="formfield">
					<label><?php echo $title; ?></label>
					<input type="text" class="input" name="<?php echo $dataKey; ?>" value="<?php echo isset($data[$key]) ? $data[$key]: ''; ?>" />	
				</div>
			<?php elseif ( $type == 'editor' ): ?>
				<div class="formfield">
					<label><?php echo $title; ?></label>
					<?php wp_editor( isset($data[$key]) ? ($data[$key]) : '', $dataKey, array() ); ?>
				</div>
			<?php endif; ?>

		<?php endforeach; ?>

		<div class="formfield" style="display: none;">
			<?php wp_editor( '', 'data_dummy', array() ); ?>
		</div>
	<?php endif; ?>
</div>