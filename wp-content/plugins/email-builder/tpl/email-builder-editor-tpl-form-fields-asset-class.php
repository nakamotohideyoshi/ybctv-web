<?php global $email_builder_editor_config; ?>

<?php if ( isset($email_builder_editor_config) && !is_null($email_builder_editor_config) && is_array($email_builder_editor_config) ): ?>
	<?php foreach ( $email_builder_editor_config as $title => $type ): ?>
		<?php $key = strtolower(str_replace(' ', '_', $title)); ?>
		<?php if ( in_array( $key, array( 'title', 'boxes_count' ) ) ): ?>
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
			<?php elseif ( strpos($type, 'select') !== false ): ?>
				<?php $vals = explode(',', substr($type, strpos($type, ':') + 1 )); ?>
				<div class="formfield">
					<label><?php echo $title; ?></label>
					<select name="<?php echo $dataKey; ?>">
						<?php foreach($vals as $v): ?>
							<option value="<?php echo $v; ?>" <?php echo $v == (isset($data[$key]) ? $data[$key]: '') ? 'selected="selected"' : ''; ?> ><?php echo $v; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			<?php endif; ?>
		<?php endif; ?>
	<?php endforeach; ?>
<?php endif; ?>

<div class="col bordered">
	<?php if ( isset($email_builder_editor_config) && !is_null($email_builder_editor_config) && is_array($email_builder_editor_config) ): ?>
		<?php foreach ( $email_builder_editor_config as $title => $type ): ?>
			<?php $key = strtolower(str_replace(' ', '_', $title)); ?>
			<?php if ( in_array( $key, array( 'left_box_title', 'left_box_subtitle', 'left_box_body', 'left_box_image', 'left_box_image_link', 'left_box_color' ) ) ): ?>
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
				<?php elseif ( strpos($type, 'select') !== false ): ?>
					<?php $vals = explode(',', substr($type, strpos($type, ':') + 1 )); ?>
					<div class="formfield">
						<label><?php echo $title; ?></label>
						<select name="<?php echo $dataKey; ?>">
							<?php foreach($vals as $v): ?>
								<option value="<?php echo $v; ?>" <?php echo $v == (isset($data[$key]) ? $data[$key]: '') ? 'selected="selected"' : ''; ?> ><?php echo $v; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		<?php endforeach; ?>
	<?php endif; ?>
</div>

<div class="col bordered">
	<?php if ( isset($email_builder_editor_config) && !is_null($email_builder_editor_config) && is_array($email_builder_editor_config) ): ?>
		<?php foreach ( $email_builder_editor_config as $title => $type ): ?>
			<?php $key = strtolower(str_replace(' ', '_', $title)); ?>
			<?php if ( in_array( $key, array( 'right_box_title', 'right_box_body', 'right_box_image', 'right_box_image_link', 'right_box_color' ) ) ): ?>
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
				<?php elseif ( strpos($type, 'select') !== false ): ?>
					<?php $vals = explode(',', substr($type, strpos($type, ':') + 1 )); ?>
					<div class="formfield">
						<label><?php echo $title; ?></label>
						<select name="<?php echo $dataKey; ?>">
							<?php foreach($vals as $v): ?>
								<option value="<?php echo $v; ?>" <?php echo $v == (isset($data[$key]) ? $data[$key]: '') ? 'selected="selected"' : ''; ?> ><?php echo $v; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		<?php endforeach; ?>
	<?php endif; ?>
</div>

<div class="col bordered">
	<?php if ( isset($email_builder_editor_config) && !is_null($email_builder_editor_config) && is_array($email_builder_editor_config) ): ?>
		<?php foreach ( $email_builder_editor_config as $title => $type ): ?>
			<?php $key = strtolower(str_replace(' ', '_', $title)); ?>
			<?php if ( in_array( $key, array( 'left_box_title_3', 'left_box_subtitle_3', 'left_box_body_3', 'left_box_image_3', 'left_box_image_link_3', 'left_box_color_3' ) ) ): ?>
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
				<?php elseif ( strpos($type, 'select') !== false ): ?>
					<?php $vals = explode(',', substr($type, strpos($type, ':') + 1 )); ?>
					<div class="formfield">
						<label><?php echo $title; ?></label>
						<select name="<?php echo $dataKey; ?>">
							<?php foreach($vals as $v): ?>
								<option value="<?php echo $v; ?>" <?php echo $v == (isset($data[$key]) ? $data[$key]: '') ? 'selected="selected"' : ''; ?> ><?php echo $v; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		<?php endforeach; ?>
	<?php endif; ?>
</div>

<div class="col bordered">
	<?php if ( isset($email_builder_editor_config) && !is_null($email_builder_editor_config) && is_array($email_builder_editor_config) ): ?>
		<?php foreach ( $email_builder_editor_config as $title => $type ): ?>
			<?php $key = strtolower(str_replace(' ', '_', $title)); ?>
			<?php if ( in_array( $key, array( 'right_box_title_4', 'right_box_body_4', 'right_box_image_4', 'right_box_image_link_4', 'right_box_color_4' ) ) ): ?>
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
				<?php elseif ( strpos($type, 'select') !== false ): ?>
					<?php $vals = explode(',', substr($type, strpos($type, ':') + 1 )); ?>
					<div class="formfield">
						<label><?php echo $title; ?></label>
						<select name="<?php echo $dataKey; ?>">
							<?php foreach($vals as $v): ?>
								<option value="<?php echo $v; ?>" <?php echo $v == (isset($data[$key]) ? $data[$key]: '') ? 'selected="selected"' : ''; ?> ><?php echo $v; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		<?php endforeach; ?>
	<?php endif; ?>
</div>

<div class="col bordered">
	<?php if ( isset($email_builder_editor_config) && !is_null($email_builder_editor_config) && is_array($email_builder_editor_config) ): ?>
		<?php foreach ( $email_builder_editor_config as $title => $type ): ?>
			<?php $key = strtolower(str_replace(' ', '_', $title)); ?>
			<?php if ( in_array( $key, array( 'left_box_title_5', 'left_box_subtitle_5', 'left_box_body_5', 'left_box_image_5', 'left_box_image_link_5', 'left_box_color_5' ) ) ): ?>
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
				<?php elseif ( strpos($type, 'select') !== false ): ?>
					<?php $vals = explode(',', substr($type, strpos($type, ':') + 1 )); ?>
					<div class="formfield">
						<label><?php echo $title; ?></label>
						<select name="<?php echo $dataKey; ?>">
							<?php foreach($vals as $v): ?>
								<option value="<?php echo $v; ?>" <?php echo $v == (isset($data[$key]) ? $data[$key]: '') ? 'selected="selected"' : ''; ?> ><?php echo $v; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		<?php endforeach; ?>
	<?php endif; ?>
</div>

<div class="col bordered">
	<?php if ( isset($email_builder_editor_config) && !is_null($email_builder_editor_config) && is_array($email_builder_editor_config) ): ?>
		<?php foreach ( $email_builder_editor_config as $title => $type ): ?>
			<?php $key = strtolower(str_replace(' ', '_', $title)); ?>
			<?php if ( in_array( $key, array( 'right_box_title_6', 'right_box_body_6', 'right_box_image_6', 'right_box_image_link_6', 'right_box_color_6' ) ) ): ?>
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
				<?php elseif ( strpos($type, 'select') !== false ): ?>
					<?php $vals = explode(',', substr($type, strpos($type, ':') + 1 )); ?>
					<div class="formfield">
						<label><?php echo $title; ?></label>
						<select name="<?php echo $dataKey; ?>">
							<?php foreach($vals as $v): ?>
								<option value="<?php echo $v; ?>" <?php echo $v == (isset($data[$key]) ? $data[$key]: '') ? 'selected="selected"' : ''; ?> ><?php echo $v; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		<?php endforeach; ?>
	<?php endif; ?>
</div>

<div class="formfield" style="display: none;">
	<?php wp_editor( '', 'data_dummy', array() ); ?>
</div>
