<?php
session_start();
//  run this URL: http://cmsbox.in/wordpress/foodyT/webservices/cuisineList.php
include_once 'api.php';
global $wpdb;
$cuisine = $wpdb->prefix."cuisine";
if($_SESSION['lanCode']=='' || $_SESSION['lanCode']=='es')
    { 
     $query = "SELECT cuisine_name_es as cuisine_name  FROM  $cuisine";
	}
	else
	{
     $query = "SELECT cuisine_name FROM  $cuisine";
	}
$res = $wpdb->get_results($query);
echo json_encode( $res ,  JSON_UNESCAPED_UNICODE);
?>
