<?php
//$blog_location = $_SERVER['DOCUMENT_ROOT'];
$blog_location = $_SERVER['DOCUMENT_ROOT']."/wordpress/foodyTv2";
if (!file_exists($blog_location . '/wp-config.php')) {
    if (strpos($_SERVER['PHP_SELF'], 'wp-admin') !== false)
        $path = '';
    else
        $path = 'wp-admin/';
    //require_once( $blog_location . '/wp-includes/classes.php');
    require_once( $blog_location . '/wp-includes/user.php');
    require_once( $blog_location . '/wp-includes/functions.php');
    require_once( $blog_location . '/wp-includes/plugin.php');
    wp_die("error message", "WordPress › Error");
}
$wp_did_header = true;
require_once( $blog_location . '/wp-config.php');
