<?php

if ( !isset( $_GET['site'] ) || !isset( $_GET['template'] ) || !isset( $_GET['type'] ) )
{
	echo '<script type="text/javascript"> window.location.href = "/wp-admin/tools.php?page=email-builder"; </script>';
	die();
}
	
global $wpdb;

$table_name = 'wp_2_email_builder_static';

if ( $_SERVER['REQUEST_METHOD'] == 'POST' )
{
	if ( isset( $_GET['site'] ) && isset( $_GET['template'] ) && isset( $_GET['type'] ) )
	{
		$d = array();
		
		foreach ( $_POST as $key => $value )
		{
			if ( strpos( $key, 'data_' ) !== false )
			{
				$d[ str_replace('data_', '', $key) ] = stripslashes($value);	
			}
		}

		$d = json_encode($d);

		$static = $wpdb->get_row("SELECT * FROM ".$table_name." WHERE Type = '". $_GET['type'] ."' AND Template = '". $_GET['template'] ."' and Site = '".$_GET['site']."'");

		if ( $static != null) 
		{
			$r = $wpdb->query( 
				$qr = $wpdb->prepare( 
						" UPDATE $table_name SET Data = %s, Version = 2 WHERE Type = %s AND Template = %s AND Site = %s ",
				        $d, $_GET['type'], $_GET['template'], $_GET['site']
			        )
			);
		}
		else
		{
			$r = $wpdb->query( 
				$qr = $wpdb->prepare(  
						" INSERT INTO $table_name (Type, Template, Site, Data, Version) VALUES (%s, %s, %s, %s, 2) ",
				        $_GET['type'], $_GET['template'], $_GET['site'], $d
			        )
			);
		}
	}
}

$static = $wpdb->get_row("SELECT * FROM ".$table_name." WHERE Type = '". $_GET['type'] ."' AND Template = '". $_GET['template'] ."' and Site = '".$_GET['site']."'");
