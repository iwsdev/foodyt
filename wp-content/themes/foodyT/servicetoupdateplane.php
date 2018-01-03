<?php
 $restaurant_info_table = $wpdb->prefix."restaurant_infos";

$blog_location = $_SERVER['DOCUMENT_ROOT'] . "/wordpress/foodyTv2/";
if (!file_exists($blog_location . '/wp-config.php')) {
    if (strpos($_SERVER['PHP_SELF'], 'wp-admin') !== false)
        $path = '';
    else
        $path = 'wp-admin/';
    require_once( $blog_location . '/wp-includes/classes.php');
    require_once( $blog_location . '/wp-includes/user.php');
    require_once( $blog_location . '/wp-includes/functions.php');
    require_once( $blog_location . '/wp-includes/plugin.php');
    wp_die("error message", "WordPress › Error");
}
$wp_did_header = true;
require_once( $blog_location . '/wp-config.php');
global $wpdb;
$query = "SELECT * FROM $restaurant_info_table WHERE user_id=" . get_current_user_id();
$infoArr = $wpdb->get_results($query);
if (isset($_POST['language']) && $_POST['language'] != '') {
    $wpdb->update(
            $restaurant_info_table, array(
        'language_price' => $infoArr[0]->language_price + get_post_meta(167, 'language_price', true), // string
        'language' => $_POST['language'], // string
        'total_price' => $infoArr[0]->language_price + get_post_meta(167, 'language_price', true)// string
            ), array('user_id' => get_current_user_id()), array(
        '%f', // value1
        '%s' // value1
            ), array('%d')
    );
    update_post_meta($infoArr[0]->page_id, 'language_rest', serialize(explode(',', $_POST['language'])));
    update_post_meta($infoArr[0]->page_id, 'language_rest', serialize(explode(',', $_POST['language'])));
    update_post_meta($infoArr[0]->page_id, 'language_rest', serialize(explode(',', $_POST['language'])));
    echo get_post_meta(167, 'language_price', true);
}
