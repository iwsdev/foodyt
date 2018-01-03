<?php 
include('../wp-config.php');
$dishId = $_REQUEST['id'];
$slugname = $_REQUEST['slugname'];
global $wpdb;
$menu_detail_table = $wpdb->prefix."menu_details";
$qu = "SELECT * from $menu_detail_table where id =$dishId";  
$data = $wpdb->get_row($qu);

$menuname = $data->name;
$attachment = $data->attachment;
$description = $data->description;

$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$arrurl = explode('/',$actual_link);

$redirecturl = site_url('/').$slugname;



?>
<!DOCTYPE html>
<html lang="en-US" prefix="og: http://ogp.me/ns#" class="no-js no-svg">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="alternate" href="http://cmsbox.in/wordpress/foodyT/" hreflang="es-es" />
<link rel="alternate" href="http://cmsbox.in/wordpress/foodyT/" hreflang="en-us" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<title><?php echo $menuname;?></title>

<!-- This site is optimized with the Yoast SEO plugin v4.6 - https://yoast.com/wordpress/plugins/seo/ -->
<link rel="canonical" href="http://cmsbox.in/wordpress/foodyTv2/dish.php" />
<meta property="og:locale" content="en_US" />
<meta property="og:type" content="article" />
<meta property="og:title" content="<?php echo $menuname;?>"/>
<meta property="og:description" content="<?php echo $description;?>" />
<meta property="og:url" content="http://cmsbox.in/wordpress/foodyTv2/dish.php" />
<meta property="og:image" content="<?php echo $attachment;?>" />
<meta property="og:site_name" content="Foodytv2" />
<meta name="twitter:card" content="<?php echo $description;?>" />
<meta name="twitter:description" content="<?php echo $description;?>" />
<meta name="twitter:title" content="<?php echo $menuname;?>" />
<meta name="twitter:image" content="<?php echo $attachment;?>" />
<!-- / Yoast SEO plugin. -->

<meta property="fb:app_id" content="430423034007644" />
</head>
<body class="restaurant-template-default single single-restaurant postid-920 has-header-image colors-light" >

  <!-- <a href="">Logout</a>-->
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



  
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>

<script>
    jQuery(document).ready(function () {
		jQuery.post('http://cmsbox.in/wordpress/foodyTv2?ga_action=googleanalytics_get_script', {action: 'googleanalytics_get_script'}, function(response) {
			var F = new Function ( response );
			return( F() );
		});
    });
</script>
	<script type='text/javascript' src='http://cmsbox.in/wordpress/foodyTv2/wp-content/plugins/contact-form-7/includes/js/jquery.form.min.js?ver=3.51.0-2014.06.20'></script>
<script type='text/javascript'>
/* <![CDATA[ */
var _wpcf7 = {"recaptcha":{"messages":{"empty":"Please verify that you are not a robot."}}};
/* ]]> */
</script>
<script type='text/javascript' src='http://cmsbox.in/wordpress/foodyTv2/wp-content/plugins/contact-form-7/includes/js/scripts.js?ver=4.7'></script>
<script type='text/javascript'>
/* <![CDATA[ */
var twentyseventeenScreenReaderText = {"quote":"<svg class=\"icon icon-quote-Customer Profileright\" aria-hidden=\"true\" role=\"img\"> <use href=\"#icon-quote-Customer Profileright\" xlink:href=\"#icon-quote-Customer Profileright\"><\/use> <\/svg>"};
/* ]]> */
</script>
<script type='text/javascript' src='http://cmsbox.in/wordpress/foodyTv2/wp-content/themes/foodyT/assets/js/skip-link-focus-fix.js?ver=1.0'></script>
<script type='text/javascript' src='http://cmsbox.in/wordpress/foodyTv2/wp-content/themes/foodyT/assets/js/global.js?ver=1.0'></script>
<script type='text/javascript' src='http://cmsbox.in/wordpress/foodyTv2/wp-content/themes/foodyT/assets/js/jquery.scrollTo.js?ver=2.1.2'></script>
<script type='text/javascript' src='http://cmsbox.in/wordpress/foodyTv2/wp-includes/js/wp-embed.min.js?ver=4.7.5'></script>


	
</body>
</html>
<?php 
	if($redirecturl)
	{
		echo '<script>document.location.href="'.$redirecturl.'";</script>';
		exit;
	}
?>
