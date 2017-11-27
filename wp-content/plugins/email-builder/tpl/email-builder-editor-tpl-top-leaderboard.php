<div class="col">
	<?php $image = isset($data['image']) ? $data['image']: ''; ?>
	<div class="formfield upload <?php echo $image != '' ? 'active' : ''; ?>">
		<label>Image</label>
		
		<button type="button" class="button add-image-button">Add Image</button>
		<button type="button" class="button update-image-button">Update Image</button>
		<button type="button" class="button remove-image-button">Remove Image</button>
		<br/><br/>
		<input type="hidden" name="data_image" value="<?php echo $image; ?>" />
		<img src="<?php echo $image; ?>" />
	</div>

	<div class="formfield">
		<label>Image Link</label>
		<input type="text" class="input" name="data_image_link" value="<?php echo isset($data['image_link']) ? $data['image_link']: ''; ?>" />	
	</div>

	<div class="formfield" style="display: none;">
		<label>Subtitle</label>
		<?php wp_editor( isset($data['subtitle']) ? ($data['subtitle']) : '', 'data_subtitle', array() ); ?>
	</div>
</div>
