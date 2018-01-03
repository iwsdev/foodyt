<?php
//  run this URL: http://cmsbox.in/wordpress/foodyT/webservices/restaurant_search.php
include_once 'api.php';
global $wpdb;
$lat = $_REQUEST['lat'];
$log = $_REQUEST['log'];
$wppost = $wpdb->prefix."posts";
$wppostmeta = $wpdb->prefix."postmeta";
$restaurant_info = $wpdb->prefix."restaurant_infos";
if($_REQUEST['restaurantName']){
	$searchName = $_REQUEST['restaurantName'];
	$query = "SELECT  * FROM  $wppost WHERE post_type ='restaurant' AND post_status ='publish' AND post_title LIKE '%$searchName%' ORDER BY $wppost.menu_order ASC";
	$res = $wpdb->get_results($query);
}
else if($_REQUEST['location']){
	$searchName = $_REQUEST['location'];
	// $querystr= "SELECT address,page_id from wp_restaurant_infos ";
	// $res = $wpdb->get_results($querystr);
	// echo "helklo";
	// echo "<pre>";
	// print_r($res);

	$querystr = "SELECT * FROM $wppost
	    LEFT JOIN $wppostmeta v1 ON ($wppost.ID = v1.post_id)
	    WHERE   $wppost.post_status = 'publish' AND $wppost.post_type = 'restaurant' AND v1.meta_value LIKE '%$searchName%' AND v1.meta_key = 'address' ORDER BY $wppost.menu_order ASC";
	$res = $wpdb->get_results($querystr);

}
elseif($_REQUEST['cuisine']){
	$searchName = $_REQUEST['cuisine'];
	$querystr = "SELECT * FROM $wppost
	    LEFT JOIN $wppostmeta v1 ON ($wppost.ID = v1.post_id)
	    WHERE   $wppost.post_status = 'publish' AND $wppost.post_type = 'restaurant' AND v1.meta_value LIKE '%$searchName%' AND v1.meta_key = 'cusine'ORDER BY $wppost.menu_order ASC";
	$res = $wpdb->get_results($querystr);
	

}
else{
	$searchName ='';
    $query = "SELECT  * FROM  $wppost WHERE post_type ='restaurant' AND post_status ='publish' AND post_title LIKE '%$searchName%' ORDER BY $wppost.menu_order ASC";
	$res = $wpdb->get_results($query);
}

$output = array();
foreach( $res as $post ) {

	  

	$latitude = get_post_meta($post->ID,'latitude',true);
	$longitude = get_post_meta($post->ID,'longitude',true);
	$address = get_post_meta($post->ID,'address',true);
	$language = get_post_meta($post->ID,'language_rest',true);
	$cusine = get_post_meta($post->ID,'cusine',true);
	$logoPostId = get_post_meta($post->ID,'logo_image',true);
	$singlePage = get_the_permalink($post->ID);

	$resultLogo = $wpdb->get_row( "SELECT guid FROM $wppost WHERE ID = $logoPostId ",ARRAY_A );
	$logoImg = $resultLogo['guid'];

	$bannerPostId = get_post_meta($post->ID,'banner_image',true);
	$resultBanner = $wpdb->get_row( "SELECT guid FROM $wppost WHERE ID = $bannerPostId",ARRAY_A );
	$bannerImg = $resultBanner['guid'];

	$url = get_the_permalink($post->ID);
	$resultUserId = $wpdb->get_row( "SELECT page_id,user_id FROM $restaurant_info WHERE page_id = $post->ID");
	$searchDetail = get_the_permalink(626);


	$query = "SELECT page_id , (3956 * 2 * ASIN(SQRT( POWER(SIN(( $lat - latitude) *  pi()/180 / 2), 2) +COS( $lat * pi()/180) * COS(latitude * pi()/180) * POWER(SIN(( $log - longitude) * pi()/180 / 2), 2) ))) as distance  
		from $restaurant_info  WHERE page_id = $post->ID 
		order by distance";
	$res = $wpdb->get_results($query);
	
	$distance = $res[0]->distance;
	
	$userId = $resultUserId->user_id;
	$searchDetailUrl = $searchDetail."?id=".$userId;
    $status = get_user_meta($userId,'ja_disable_user',true);
    if($status==0){
    $output[] = array( 'id' => $post->ID,'userId' =>$userId,'detailPageUrl'=> $searchDetailUrl ,'singlePageUrl' => $singlePage , 'title' => $post->post_title,'content' => $post->post_content, 'cusine' => $cusine ,'logoImg' => $logoImg ,'bannerImg' => $bannerImg ,'language' => $language ,'address' => $address,'latitude' =>$latitude, 'longitude' => $longitude,'distance' => $distance,'url' => $url ,'date' => $post->post_date);
		}


}
// echo "<pre>";
// print_r($output);die;
 echo json_encode( $output , JSON_UNESCAPED_SLASHES);
?>