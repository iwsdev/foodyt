<?php
/*
Plugin Name: Invoice Payment Detail
Plugin URI: http://webnexus.in
Description: An Example of Simple Plugin.
Version: 0.1
Author: jai singh
Author URI:
License:
*/

global $charset_collate;
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');


add_action('admin_menu', 'my_users_menu');
function my_users_menu() {
add_users_page("View Visitors", "Invoice Details", 'read', "userinvoice", "userInvoiceGenerate");
}
function userInvoiceGenerate(){
	$getType=$_GET['actions'];
	if(isset($getType) && $getType=="view"){
		include 'view.php';
	} else if(isset($getType) && $getType=="update") {
		include 'updatepost.php';
	} else if(isset($getType) && $getType=="deletedata") {
		global $wpdb;
		$deletequery="delete from wp_userfile_upload where id='$_GET[deleteId]'";
		mysql_query($deletequery) or die(mysql_error());
		header("location: users.php?page=userinvoice");
	} else{
		include 'joblist.php';
	}
}?>
