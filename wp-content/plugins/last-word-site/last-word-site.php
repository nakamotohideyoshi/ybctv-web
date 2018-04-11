<?php
/*
Plugin Name: LastWord Site
Description: Shortcodes list: [lw_register]
Version: 1.0
Author: IDM
*/

/**
 * Define constants
 */
define( 'LASTWORD_PATH', plugin_dir_path(__FILE__) );
define( 'LASTWORD_URL', plugins_url( '/', __FILE__ ) );
define( 'INTEGRATION_DYNAMIC_DIR', dirname( plugin_dir_path(__FILE__) ) . '/integration-dynamics' );

//functions
include "functions.php";

//hooks
include "hooks.php";

//shortcodes
include "shortcodes.php";

//Cookie
//include "cookie.php";
?>
