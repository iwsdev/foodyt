<?php
/*
Plugin Name: Cuisine List
Plugin URI: http://webnexus.in
Description: An Example of Simple Plugin.
Version: 0.1
Author: jai singh
Author URI:
License:
*/
//global $charset_collate;
//require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

function add_theme_menu_item()
{
	add_menu_page("Cuisine List", "Cuisine List", "administrator", "cuisine", "admin_showlisting", null, 99);
    //add_submenu_page( "theme-panel", 'Cuisine List', 'Cuisine List', 1, 'cuisine', 'admin_showlisting');
}
add_action("admin_menu", "add_theme_menu_item");
function admin_showlisting(){
	$getType=$_GET['actions'];
	if(isset($getType) && $getType=="add"){
		include 'addcuision.php';
	} else if(isset($getType) && $getType=="update") {
		include 'updatecuision.php';
	} else if(isset($getType) && $getType=="deletedata") {
		global $wpdb;
		$cuisineTable = $wpdb->prefix."cuisine";
		$id = $_GET['deleteId'];
		$deletequery="delete from $cuisineTable where id = $id";
		$wpdb->query($deletequery);
        echo "<script>
			document.location.href='options-general.php?page=cuisine';
			</script>";
	} else{
		include 'cuisineList.php';
	}
}

?>
