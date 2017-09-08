<?php
/**
 * The template for displaying search forms in lania
 */
?>
	<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<input type="text" class="field search-query" name="s" id="s" placeholder="<?php esc_attr_e( 'Search...', TEXT_DOMAIN ); ?>" />
		<input type="submit" class="submit" name="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search', TEXT_DOMAIN ); ?>" />
	</form>
