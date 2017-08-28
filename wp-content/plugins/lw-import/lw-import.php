<?php
/*
Plugin Name: Last Word Import
Plugin URI: http://www.ybc.tv
Description: Import Content from previous Last Word CMS
Author: yBC
Version: 1.0
Author URI: http://www.ybc.tv
*/

require_once(plugin_dir_path(__FILE__) . 'class.import.php' );
$import = new lw_import();
