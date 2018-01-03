<?php
//http://cmsbox.in/wordpress/lait/webservices/help.php
include_once 'api.php';
$args = array( 
    'post_type' => 'post', 
    'cat' => 4 ,
    'post_status' => 'publish', 
    'nopaging' => true 
);
$query = new WP_Query( $args ); // $query is the WP_Query Object
$posts = $query->get_posts();   // $posts contains the post objects

$output = array();
foreach( $posts as $post ) {    // Pluck the id and title attributes
    $output[] = array( 'id' => $post->ID, 'title' => $post->post_title, 'content' => $post->post_content );
}
echo  json_encode( $output,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
?>