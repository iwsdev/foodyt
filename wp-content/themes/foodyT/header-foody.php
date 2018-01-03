<?php
session_start();
$languageContent = getArrayOfContent();
$langId = $_SESSION['lanCode'];
if($langId=='')
  $langId = 'es';
$_SESSION['lan'] = $languageContent[$langId];
$id = get_the_id();
$current_user = wp_get_current_user();
$userID = $current_user->ID; 
if(is_user_logged_in() &&  $userID!=1)
{
   if($id==168 || $id==167 || $id==341)
   { //payment done and login page
    $url = get_the_permalink(224);
    wp_redirect($url);
   }
   }
   else
   {
    if($id==224 || $id==246 || $id==227 || $id==244 || $id ==222){ 
    $url = get_the_permalink(168);
    wp_redirect($url);
      
    }
   }



/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>



<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="alternate" href="http://cmsbox.in/wordpress/foodyT/" hreflang="es-es" />
<link rel="alternate" href="http://cmsbox.in/wordpress/foodyT/" hreflang="en-us" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/fonts/font.css">
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/bootstrap1.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/comment.css" />
<link href="https://fonts.googleapis.com/css?family=Oswald:300,400,700" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet">
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script> --> 
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
<script type="text/javascript" src="<?php echo bloginfo('template_url'); ?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo bloginfo('template_url'); ?>/js/jquery-ui.min.js"></script>
<script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo bloginfo('template_url'); ?>/js/jquery.multiselect.js"></script> 
<script type="text/javascript" src="<?php echo bloginfo('template_url'); ?>/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo bloginfo('template_url'); ?>/js/jquery.mask.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo bloginfo('template_url'); ?>/jquery.multiselect.css" />
<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/ui-lightness/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="<?php echo bloginfo('template_url'); ?>/css/jquery.multiselect.css" />
<link rel="stylesheet" type="text/css" href="<?php echo bloginfo('template_url'); ?>/css/jquery-ui.css" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/bootstrap1.min.css">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php wp_head(); ?>
<link href="<?php bloginfo('template_url'); ?>/assets/css/jquery.mmenu.all.css" rel="stylesheet">
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.mmenu.min.all.js"></script>
<!--  <?php $title =  get_the_title();
  $content =  get_the_content();
  ?>
  <meta property="og:url"           content="http://cmsbox.in/wordpress/foodyTv2/mar-adentro" />
  <meta property="og:type"          content="website" />
  <meta property="og:title"         content="<?php echo $title;?>" />
  <meta property="og:description"   content="<?php echo $content;?>" />
  <meta property="og:image"         content="http://cmsbox.in/wordpress/foodyTv2/wp-content/themes/foodyT/testjai.png" /> -->
<meta property="fb:app_id" content="430423034007644" />
</head>
<body <?php body_class(); ?> >
<?php// echo do_shortcode('[prisna-google-website-translator]'); ?>
<?php
$pageId = get_the_id();
if(is_user_logged_in()){
?>
<style type="text/css">
  .logout{display: block;}
  .login{display: none;}
</style>
  <?php }else{?>
<style type="text/css">
  .logout{display: none;}
  .login{display: block;}
</style>
  <?php }
if($pageId==167){?>
<style type="text/css">#menu-item-374 a{border-bottom: 3px solid #f39400;padding-bottom: 5px;}</style>
<?php } ?>
<!-- <a href="<?php //echo wp_logout_url("login/"); ?>">Logout</a>-->
<div id="page" class="site">


<div class="site-content-contain">
   <div id="content" class="site-content">

  <!-- Your share button code -->
  <script type="text/javascript">
    
    var docheight = $('.Do').height();
//alert(docheight);
    // $(window).scroll(function(){
    //    var top= $(window).scrollTop();
    //  $('span').text(top);
    //  $('#he_text').css("width",top +"px");
    //  if(top>=(docheight))
    //   {
    // //alert("hello");
    //  $('.header_hide').css("display","none");
    //   }
    // else
    // {
    // $('.header_hide').css("display","block");
    // }
    // });
   // var he = $("#mobileNav").height();
   // var he1 = $("#mobileNav").innerHeight();
   // var he2 = $("#mobileNav").outerHeight();

  $(window).scroll(function() {
   
     if ($(this).scrollTop() > 225){  
        $('#mobileNav').addClass("fixed");
          }
   else{
      $('#mobileNav').removeClass("fixed");
      }
     });

  $(window).scroll(function() {
   
     if ($(this).scrollTop() > 195){  
        $('#navbar').addClass("fixed");
          }
   else{
      $('#navbar').removeClass("fixed");
      }
     });
  </script>



  
