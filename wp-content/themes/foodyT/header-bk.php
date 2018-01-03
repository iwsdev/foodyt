<?php
$id = get_the_id();
$current_user = wp_get_current_user();
$userID = $current_user->ID; 
if(is_user_logged_in() &&  $userID!=1){
   if($id==168 || $id==167 || $id==341){ //payment done and login page
   	$url = get_the_permalink(224);
   	wp_redirect($url);
      }
   }else
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

?><!DOCTYPE html>

<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/fonts/font.css">

<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/bootstrap1.min.css">
<link href="https://fonts.googleapis.com/css?family=Oswald:300,400,700" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet">
  
 
  <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script> -->
  
  
  
  
   <!--  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->

 
<script type="text/javascript" src="<?php echo bloginfo('template_url'); ?>/js/jquery.min.js"></script>
  <script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="<?php echo bloginfo('template_url'); ?>/js/jquery-ui.min.js"></script>
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

</head>
<body <?php body_class(); ?>>
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
<style type="text/css">#menu-item-374 a{border-bottom: 3px solid #f39400;
padding-bottom: 5px;}</style>
<?php }

	
?>

<!-- <a href="<?php //echo wp_logout_url("login/"); ?>">Logout</a>
 --><div id="page" class="site">
	

	<header id="masthead" class="site-header" role="banner">
			<div class="container">

			<?php 
			
			if(is_user_logged_in()){  
					if($userID!=1){
	                ?><!-- <p class="w_admin" style="float: right;padding-top: 22px;"><a  class="myAccount"href="<?php //echo get_the_permalink(224); ?>">My Account </a></p>  -->
	                <style type="text/css">
	                	.myAccount{display:block;}
	                </style>
	            <?php }
		            else{?>
		            	 <style type="text/css">
		                	.myAccount{display:none;}
		                </style>
		           <?php 	}

		           } else{?>
		            <style type="text/css">
		                	.myAccount{display:none;}
		                </style>
		           <?php	} ?> 


             <?php   if ( is_front_page() || $pageId==168  || $pageId==341) { ?>

                <a  href="<?php echo site_url(); ?>"><img id="whiteLogo" src="<?php echo get_template_directory_uri(); ?>/assets/images/logoWhite.png" alt="" /></a> 
                <input type="hidden" name="" id="blackLogoHidden" value="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png">

                <?php	} else {?>
				<a  href="<?php echo site_url(); ?>"><img id="blackLogo" src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="" /></a>
				
				<?php } ?>
				  <input type="hidden" name="" id="whiteLogoHidden" value="<?php echo get_template_directory_uri(); ?>/assets/images/logoWhite.png">
				<a class="toggleMenu" href="#"><span></span> <span></span> <span></span></a>	
				
				<div class="switcher">
					<ul>
						<li><a class="lang" href='http://cmsbox.in/wordpress/foodyT/#googtrans(es|en)'><img src="http://cmsbox.in/wordpress/foodyT/wp-content/themes/foodyT/assets/images/english-flag.jpg"></a></li>
						<li><a class="lang" href='http://cmsbox.in/wordpress/foodyT/#googtrans(en|es)'><img src="http://cmsbox.in/wordpress/foodyT/wp-content/themes/foodyT/assets/images/espanol-flag.jpg"></a></li>
					</ul>
				</div>
				<nav id="nav">
				
					<?php
						wp_nav_menu(array('theme_location'=>'primary', 'menu_class'=>'primary-menu', 'menu_id'=>'primary_menu'));
						?>
				</nav>
				<?php //echo do_shortcode('[prisna-google-website-translator]'); ?>
				
			</div>
	</header>

	
	<div class="site-content-contain">
		<div id="content" class="site-content">
