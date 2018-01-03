<?php
get_header('foody');
session_start();
?>

<style>
.modal{font-family: 'pangramregular'!important;}
.comment_form{ 
    border: 5px solid #55AE40;
    color: black;
    width: 80%;
    margin: 0 auto;
    border-radius: 10px;
    clear:both;
}
.comment_description{width:100%!important; border-left: none;
    border-top: none;border-bottom: 5px solid #55AE40;padding-left: 5px;
    border-right: none;}
.comment_title{width:100%!important;    border-left: none;
    border-top: none;border-bottom: 5px solid #55AE40;padding-left: 5px;
    border-right: none;}
.social_icon{text-align:center;padding-top: 10px;}
.rating_overview{width: 80%;
    overflow: hidden;
    padding-top: 10px;
    padding-bottom: 10px;
    margin: 0 auto;
}
.ratingNumaric p{float: right;
    clear: both;}
.my_row{    display: inline-block;  width: 100%;}
   .comment_form .stars{float: left;}
   .comment_form .submitbtn{float:right;background-color: #55AE40!important; color:#fff; border:0; margin-right:5px;}
   .rating_overview .progress{height: 17px!important;
    margin-bottom: 11px!important;}
    .rating_overview .progress-bar{background-color: #6bae20!important;}
    .removePadding{padding:0px!important;}
.listOfComment{ 
     width: 80%;
    margin: 0 auto;
    clear: both;}
.modal-footer{border-top:none!important;}
.rating-static {
  width: 150px;
  height: 30px;
  display: block;
  background: url('<?php echo bloginfo('template_url')?>/starmix.png') 0 0 no-repeat;
}
.rating-50 { background-position: 0 0; }
.rating-40 { background-position: -34px 0; } 
.rating-30 { background-position: -63px 0; }
.rating-20 { background-position: -94px 0; }
.rating-10 { background-position: -124px 0; }
.rating-0 { background-position: -153px 0; }
 
.rating-5  { background-position: -48px -16px; }
.rating-15 { background-position: -36px -16px; }
.rating-25 { background-position: -24px -16px; }
.rating-35 { background-position: -12px -16px; }
.rating-45 { background-position: 0 -16px; }

.star-ratings-sprite {
  background: url("<?php echo bloginfo('template_url')?>/foodtTstarLogo.png") repeat-x;
  font-size: 0;
  height: 23px;
  line-height: 0;
  overflow: hidden;
  text-indent: -999em;
  width: 141px;
  margin: 0 auto;
}
  .star-ratings-sprite-rating {
  background: url("<?php echo bloginfo('template_url')?>/foodtTstarLogo.png") repeat-x;
    background-position: 0 100%;
    float: left;
    height: 23px;
    display:block;
  
}

.active{text-decoration: underline;}
    #masthead{display:none}
    .modal-dialog {
        top: 9px!important;
    }
    .site-content{padding-top:0}
    .sticky .logo img{display: block!important;}
    .breadcrumbColor{color: #e98f02;}
    @media only screen and (max-width: 500px) {
    .imgLogo {
        display: block!important;
    }
}
.mainDishImg{ cursor:pointer;}

#myModal1 .modal-body{overflow:hidden;}
.listOfComment{margin-top:25px;}
.listOfComment .listItem{float:left; width:100%; padding-bottom:15px;}
.listOfComment .listItem .l-img{float:left;width:100px; text-align:center; margin-right:20px}
.listOfComment .listItem .l-img figure{width:70px; height:70px; border-radius:50%; overflow:hidden; border:1px solid #696969;padding:0; margin:0 auto 10px}
.listOfComment .listItem .l-img figure img{max-width:100%; height:100%;}
.listOfComment .listItem .r-content{float:left;width:calc(100% - 120px)}
.listOfComment .listItem .l-img figure p{margin-top:15px; font-size:15px; color:#000;}
.listOfComment .listItem .l-img figure p span{dislay:block}
.rating_overview{    overflow: hidden;}
.my_row{display: inline-block;  width: 50%; text-align:left;}
.wrap-p{float:left; width:100%;}
.l-img p{ word-break: break-all;}

</style>
<?php
// $userId = $_REQUEST['id'];
global $wpdb;
 $userTable = $wpdb->prefix."users";
 $restaurant_info_table = $wpdb->prefix."restaurant_infos";
 $posttable = $wpdb->prefix."posts";
 $cuisinetable = $wpdb->prefix."cuisine";
 $menu_detail_table = $wpdb->prefix."menu_details";
 $menu_categorie_table = $wpdb->prefix."menu_categories";
 $menu_options_table = $wpdb->prefix."menu_options";
 $postmeta_table = $wpdb->prefix."postmeta";
  $commentTable = $wpdb->prefix."comments";

// Usage:


$lan = $_REQUEST['lang'];
if($lan=='')
{
    $lan = 'es';
}
$url = $_SERVER['REQUEST_URI'];
$arrayUrl = explode('/', $url);
$pos = count($arrayUrl);
$slugName = $arrayUrl[$pos - 2];
if ($post = get_page_by_path($slugName, OBJECT, 'restaurant'))
 $id = $post->ID;
else
    $id = 0;
 $urlPage = get_the_permalink($id);
 $userIdInfo = $wpdb->get_row("SELECT page_id,user_id,hide_price FROM $restaurant_info_table WHERE page_id = $id");
 $hidePrice = $userIdInfo->hide_price;
 $user_id = $userIdInfo->user_id;
      
  $visit_restaurants = 'visit_restaurants_'.$user_id;
  $visit_restaurantsdate = 'visit_restaurants_date'.$user_id;
  $visiteddate = strtotime(date('Y-m-d'));
     
      
 /* facebook login code */
      
 $facebook_access_token=$_SESSION['facebook_access_token'];
$userid=get_current_user_id();
if($facebook_access_token=="" && $userid==0)
{
/*code for facebook */
require 'Facebook/autoload.php';
$fb = new Facebook\Facebook([
  'app_id' => '110274476284526', // Replace {app-id} with your app id
  'app_secret' => '96b2a2fbc2a56d2a20e1c41a9710f1c9',
  'default_graph_version' => 'v2.9',
  ]);

$helper = $fb->getRedirectLoginHelper();
$permissions = ['email']; // Optional permissions
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$loginUrl = $helper->getLoginUrl($actual_link, $permissions);

try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

if (isset($accessToken))
{
  // Logged in!
  $_SESSION['facebook_access_token'] = (string) $accessToken;
  // Now you can redirect to another page and use the
  // access token from $_SESSION['facebook_access_token']
} elseif ($helper->getError()) {
  // The user denied the request
  exit;
}
$fblogin =1;
if (!$accessToken)
{
    $fblogin =0;
}
else
{
   try
   {
      // Returns a `Facebook\FacebookResponse` object
      $response = $fb->get('/me?fields=id,name,first_name,last_name,email,gender,birthday,age_range,hometown,locale,location,timezone,website,about', $accessToken);
      //$response = $fb->get('/me?fields=id,name,first_name,last_name,email,gender,birthday', 'EAABkS0b8mm4BAObC62VMTzyJprQQZAyLEJivfxpylqrOY089gOOHKMnkaOgzQmXAQesmGnsPCFKERvRbqu6REj5RBjz6iQmsamDEGl6ZB4C3ROrrbpqCsUqfZAsOU1J2I8T5Hu0A1dlLAmukotqHOXC2n5QxZCR3OrMOddefpUFeIywsZBtkO');
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
    }
    $fblogin =1;
    $user = $response->getGraphUser();
    if(!empty($user))
    {
        $name=$user['name'];
        $email=$user['email'];
        if($email!="")
        {
            $user_login = $email;
        }
        else
        {
             $user_login = str_replace(' ', '', $name);
        }
        $user_pass= 123456;
        $first_name=$user['first_name'];
        $last_name=$user['last_name'];
        $gender=$user['gender'];
        $age_range=$user['age_range']['min'];
        $locale=$user['locale'];
        $timezone=$user['timezone'];
        
        $today = date('Y-m-d H:i:s');
        
        $userdata = array(
        'user_login'  => $user_login,
        'user_pass'    =>  $user_pass,
        'user_nicename'   =>$name,
        'user_email'   =>  $email,
        'user_url'   =>  NULL,
        'user_registered'   =>$today,
        'user_status'   =>  1,
        'display_name'   =>  $name,
       );
        $userexist = get_user_by('login', $user_login);
        if(empty($userexist ))
        {
            
            $insertuser_id = wp_insert_user( $userdata ) ;

            if($insertuser_id >0)
            {
                
                update_user_meta($insertuser_id, 'first_name', $first_name);
                update_user_meta($insertuser_id, 'last_name', $last_name);
                update_user_meta($insertuser_id, 'gender', $gender);
                update_user_meta($insertuser_id, 'age_range', $age_range);
                update_user_meta($insertuser_id, 'locale', $locale);
                update_user_meta($insertuser_id, 'timezone', $timezone);
                update_user_meta($insertuser_id, 'registervia', 'facebook');
                update_user_meta($insertuser_id, $visit_restaurants, 'visited');
                update_user_meta($insertuser_id, $visit_restaurantsdate, $visiteddate);
                $_SESSION['insertuser_id'] = $insertuser_id;
            }
        }
        else
        {
           $insertuser_id = $userexist->ID;
           if($insertuser_id >0)
            {
                update_user_meta($insertuser_id, 'first_name', $first_name);
                update_user_meta($insertuser_id, 'last_name', $last_name);
                update_user_meta($insertuser_id, 'gender', $gender);
                update_user_meta($insertuser_id, 'age_range', $age_range);
                update_user_meta($insertuser_id, 'locale', $locale);
                update_user_meta($insertuser_id, 'timezone', $timezone);
                update_user_meta($insertuser_id, $visit_restaurants, 'visited');
                
                $visiteddate=get_user_meta($insertuser_id,$visit_restaurantsdate,true);
                if($visiteddate=="")
                {
                   
                    update_user_meta($insertuser_id, $visit_restaurantsdate, $visiteddate); 
                }
                
                $_SESSION['insertuser_id'] = $insertuser_id;
            }
        }
        
        
    }
    
     
}
}
else
{
    $fblogin =1;
}
      
// $userIdInfo1 = $wpdb->get_results("SELECT id,card_number,cvv FROM $restaurant_info_table");
// foreach ($userIdInfo1 as $value) {
//   // echo $value->card_number;
//    //echo $value->cvv."</br>";
//    $card_number = "PND".base64_encode($value->card_number);
//    $cvv = "PND".base64_encode($value->cvv);
//    $wpdb->update( 
//     $restaurant_info_table, 
//     array( 
//         'card_number' => $card_number,  // string
//         'cvv' => $cvv   // integer (number) 
//     ), 
//     array( 'id' =>  $value->id), 
//     array( 
//         '%s',   // value1
//         '%s'    // value2
//     ), 
//     array( '%d' ) 
// );

// }


//$userIdInfo2 = $wpdb->get_results("SELECT meta_id,meta_value FROM $postmeta_table where meta_key='card_number'");
//foreach ($userIdInfo2 as $value) {

   //$card_number = "PND".base64_encode($value->card_number);
//    $cvv = "PND".base64_encode($value->meta_value);
//    $wpdb->update( 
//     $postmeta_table, 
//     array( 
//         'meta_value' => $cvv   // integer (number) 
//     ), 
//     array( 'meta_id' =>  $value->meta_id), 
//     array( 
//         '%s',   // value1
//     ), 
//     array( '%d' ) 
// );
  


//     $card_number = "PND".base64_encode($value->meta_value);
//    $wpdb->update( 
//     $postmeta_table, 
//     array( 
//         'meta_value' => $card_number   // integer (number) 
//     ), 
//     array( 'meta_id' =>  $value->meta_id), 
//     array( 
//         '%s',   // value1
//     ), 
//     array( '%d' ) 
// );

//}



$userId = $userIdInfo->user_id;
 $qu = "SELECT * from $menu_detail_table where entry_by =" . $userId . " AND language = '" . $lan . "' AND status=2";
$data = $wpdb->get_results($qu);
// echo "<pre>";
//  print_r($data);
$manuCatId = array();
foreach ($data as $data) {
    $manuCatId[] = $data->menu_cat_id;
}
 // print_r($manuCatId);die;
$catList = $wpdb->get_results("SELECT * from $menu_categorie_table where entry_by =" . $userId);

$resultPageId = $wpdb->get_row("SELECT page_id,user_id FROM $restaurant_info_table WHERE user_id = $userId");
$pageId = $resultPageId->page_id;
$restaurant_id = $resultPageId->page_id;
$logoPostId = get_post_meta($pageId, 'logo_image', true);
$resultLogo = $wpdb->get_row("SELECT guid FROM $posttable WHERE ID = $logoPostId ", ARRAY_A);
$logoImg = $resultLogo['guid'];
$bannerPostId = get_post_meta($pageId, 'banner_image', true);
$resultBanner = $wpdb->get_row("SELECT guid FROM $posttable WHERE ID = $bannerPostId", ARRAY_A);
$bannerImg = $resultBanner['guid'];

/*get langauge code from pageid start*/
$resultPageIds = $wpdb->get_row("SELECT page_id,user_id,language FROM $restaurant_info_table WHERE user_id = $userId");
$lang = $resultPageIds->language;
$language = explode(",",$lang);
/*get langauge code from pageid end*/
//$language = get_post_meta($pageId, 'language_rest', true);
//is_array($language) ? $language : $language = unserialize($language);
?>

<section id="top">
      <div class="container">
        <div class="row strip">
            <div class="col-md-4 col-sm-12 col-xs-12 text-left"><span class=" light-orange"><?php echo get_the_title($pageId); ?></span></div>
            <div class="col-md-2 col-sm-12 col-xs-12 text-middle"><span class=" light-orange"><?php  echo get_post_meta($pageId, 'mobilenumber', true);?></span></div>
            <div class="col-md-6 col-sm-12 col-xs-12 text-right"><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo get_post_meta($pageId, 'address', true); ?></div>
        </div>
    </div>
</section>
<section id="s_detail_header">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-8 logo">
                <a href="#" class="logo">
                <img style="width:15%;display: none;" src="<?php echo $logoImg; ?>" alt="" class='imgLogo'/>
                </a>
            </div>
            <div class="col-md-8 col-sm-8 col-xs-4" >
                <a class="toggledMenu" href="#menu"><span></span> <span></span> <span></span></a>
                <div id="menu">
                    <ul class="lang-switcher">
                        <?php
                        // Note: myFunction1() is not used if u want remove u can remove it, being a developer i am not going to remove it because fure it might be needed.. 
                        foreach ($language as $lang) {
                            if ($lang == 'English') {
                                ?>
                                <li Class="lang en"><a href='<?php echo $urlPage."?lang=en"; ?>' onclick='myFunction1("en");'><img src="<?php echo get_template_directory_uri(); ?>/assets/images/english-flag.jpg" alt=""/> <span <?php if($lan=='en'){ echo'class="active"';} ?>>English</span></a></li>
                            <?php } ?>
                            <?php if ($lang == 'Spanish') { ?>
                                <li class="lang es "><a href='<?php echo $urlPage."?lang=es"; ?>' onclick='myFunction1("es");'><img src="<?php echo get_template_directory_uri(); ?>/assets/images/espanol-flag.jpg" alt=""/> <span <?php if($lan=='es'){ echo'class="active"';} ?>>Spanish</span></a></li>
                            <?php } ?>
                            <?php if ($lang == 'French') { ?>
                                <li class="lang fr"><a href='<?php echo $urlPage."?lang=fr"; ?>' onclick='myFunction1("fr");'><img src="<?php echo get_template_directory_uri(); ?>/assets/images/french-flag.jpg" alt=""/> <span <?php if($lan=='fr'){ echo'class="active"';} ?>>French</span></a></li>
                            <?php } ?>
                            <?php if ($lang == 'japanese') { ?>
                                <li class="lang ja"><a href='<?php echo $urlPage."?lang=ja"; ?>' onclick='myFunction1("ja");'><img src="<?php echo get_template_directory_uri(); ?>/assets/images/japanese-flag.jpg" alt=""/> <span <?php if($lan=='ja'){ echo'class="active"';} ?>>Japanese</span></a></li>
                            <?php } ?>
                            <?php if ($lang == 'Italian') { ?>
                                <li class="lang it"><a href='<?php echo $urlPage."?lang=it"; ?>' onclick='myFunction1("it");'><img src="<?php echo get_template_directory_uri(); ?>/assets/images/italian-flag.jpg" alt=""/> <span <?php if($lan=='it'){ echo'class="active"';} ?>>Italian</span></a></li>
                            <?php } ?>      
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
</section>  
<section id="sBanner" style="background-repeat: no-repeat!important;background:url(<?php echo $bannerImg; ?>">
    <h1 class="withtopbar">
        <span class="ppb_title_first">Digital</span>Menu
    </h1>
</section>
<section id="searchList" class="searchList">
    <div class="container">
       
   <?php  
      $prevUrl = wp_get_referer();
      $urlInfo = '';
      $urlarr = explode("/",$prevUrl);
      if(in_array('search-result', $urlarr)) {
         $_SESSION['preUrl'] = $prevUrl;
         $urlInfo = $_SESSION['preUrl'];
      }else
      {
            if($prevUrl!=''){
              unset($_SESSION['preUrl']); 
               $urlInfo ='';
            }
            else{
             $urlInfo = $_SESSION['preUrl'];
      }
            
      }
    ?>
     <?php $priceNotRequired=0; 
     if($urlInfo)
     {
      ?> <!-- To check url if it is search then it will show otherwise no bredcrum display-->
        <p> <a class='breadcrumbColor' href="<?php echo site_url();?>"><i class="fa fa-home" aria-hidden="true"></i></a> >
       <a class='breadcrumbColor' href="<?= $urlInfo;?>">Search Result</a> > <?=  get_the_title();?></p> 
     <?php  
             if($hidePrice==1)
             { 
                $priceNotRequired =1;
             }
         $pagetype = 'search';
        }
        else
        {
            $pagetype = 'other';
        }
        
       ## add the data for visitor
       
        $tablename=$wpdb->prefix.'visitor';
        $ipAddress = $_SERVER['REMOTE_ADDR'];
        if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER))
        {
            $ipAddress = array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
        }
        if ( is_user_logged_in() )
        {
             $visitorid =get_current_user_id();
        }
        else
        {
           $insertuser_id = $_SESSION['insertuser_id'];
            if($insertuser_id >0)
            {
                $visitorid =$insertuser_id;
            }
            else
            {
                $visitorid =0;
            }
            
        }
        $Addedon = date('Y-m-d H:i:s');
        $datavisitor=array('ip' =>$ipAddress,'visitor_id' =>$visitorid,'pagetype' =>$pagetype,'referer' =>$urlInfo,'user_id'=> $user_id,'Addedon' =>$Addedon);
        $wpdb->insert( $tablename, $datavisitor);
        
       ## end of visitor code
     ?>

        <ul class='catMenu'>
            <?php
            $i = 1;
            // echo "<pre>";
            // print_r($catList);
            foreach ($catList as $catName) {
                $menu_id = $catName->id;
                if (in_array($menu_id, $manuCatId)) {

                    echo "<li><a href='javascript:void(0)'  idname=$i>" . $catName->menu_name . "</a></li>";
                    $i++;
                }
            }
            ?>
        </ul>   
    </div>
    <div class="container swidth">  
        <!-- Repeat Row --> 
        <?php
        $i = 1;
        $j=1;
        foreach ($catList as $catName) {
          $menu_id = $catName->id;
            if (in_array($menu_id, $manuCatId)) {
                ?>
                <div class="row signature-dishes" id='<?php echo $i++; ?>'>
                    <div class="col-md-12 dish">
                        <h2 ><?php echo  $catName->menu_name; ?></h2>
                        <ul>
                            <?php
                            $query = "SELECT * from $menu_detail_table where menu_cat_id =" . $catName->id . " AND entry_by =" . $userId . " AND language = '" . $lan . "' AND  status=2";
                            $menuDetails = $wpdb->get_results($query);
                             // echo "<pre>";
                             // print_r($menuDetails);

                            
                            foreach ($menuDetails as $menuDetail)
                            {

  //echo $singlePageUrl = get_the_permalink();
  // $json_string = file_get_contents("http://graph.facebook.com/?id=".$singlePageUrl."dishid/".$menuDetail->id);
  //  $json_string = file_get_contents("http://graph.facebook.com/?id=http://cmsbox.in/wordpress/foodyTv2/mar-adentro/dishid/53");
  //   $json = json_decode($json_string, true);
  //   echo '<pre>';
  //   print_r($json);
  //   $fbCount= $json['share']['share_count'];
  //   echo '</pre>';
  //   $wpdb->update( 
  //   $menu_detail_table, 
  //   array( 
  //       'fb_count' => $fbCount   // integer (number) 
  //   ), 
  //   array( 'id' =>  $menuDetail->id), 
  //   array( 
  //       '%d',   // value1
  //   ), 
  //   array( '%d' ) 
  // );
  


                              //$urlPage2go =$urlPage."?dishid=".$menuDetail->id;
                                $urlPage2go =$urlPage."dishid/".$menuDetail->id;
                                $dish_id = $menuDetail->id; 
                                $getReviewAllRate = $wpdb->get_results("SELECT * FROM $commentTable where dish_id = $dish_id AND comment_approved = 1");
    
      
                                   $count=0;
                                   $sum=0;
                                   foreach ($getReviewAllRate as  $dataInfo) {
                                    $sum =$sum + $dataInfo->rating;
                                    $count++;
                                     # code...
                                   }
                                   $count = $count*5;
                                   if($count>0){
                                   $startPercentage = (100*$sum)/$count;
                                   } else{$startPercentage=0;}
                                
                                ?>
                                <li id='position<?= $j;?>'>

                                <div id="myModal<?= $j;?>" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                  <div class="comment_form" style="border:none;">

                                     <!-- <span class="rating-static rating-30"></span> -->
                                     <div class="star-ratings-sprite"><span style="width:<?= $startPercentage?>%" class="star-ratings-sprite-rating"></span></div>

                                    </div>
                                            <button type="button" style='float:right;' class="btn btn-default" data-dismiss="modal"> Close</button>
                                        </div>
                                        <div class="modal-body">
                                            <img class="showimage img-responsive" src="" />
                                        <div class='social_icon'>

                                        <a data-dishid="<?= $dish_id?>" class="whatsCount" data-text="<?=$menuDetail->name?> " data-desc="  <?= $menuDetail->description; ?>" data-link="<?= $urlPage2go;?>#position<?= $i-1;?>" data-img="<?= $menuDetail->attachment; ?>" class="whatsapp w3_whatsapp_btn w3_whatsapp_btn_large"><img src="<?php echo bloginfo('template_url')?>/assets/images/whatsup.png"></a>
                                
                                            <?php 
									         if($fblogin==1 || $userid >0)
											 {
											?>
											<a data-dishid="<?= $dish_id?>" class="fbCount" href="javascript:void(0);" data-layout="button" onclick="window.open('https://www.facebook.com/sharer.php?u=<?= $urlPage2go;?>&summary=MySummary&title=<?=$menuDetail->name?>&description=<?= $menuDetail->description; ?>&picture=<?= $menuDetail->attachment; ?>','ventanacompartir', 'toolbar=0, status=0, width=650, height=450');"> <img src="<?php echo bloginfo('template_url')?>/assets/images/fb.png"></a>
                                            <?php }else{?>
											<a href="<?php echo htmlspecialchars($loginUrl);?>" target="_blank"><img src="<?php echo bloginfo('template_url')?>/assets/images/fb.png"></a>
											<?php }?>
                                        
                                            <a data-dishid="<?= $dish_id?>" class="twitCountId" target="_blank" href="http://twitter.com/intent/tweet?text=<?=$menuDetail->name?>  &url=<?= $urlPage2go;?>"><img src="<?php echo bloginfo('template_url')?>/assets/images/twit.png"></a>

                                              
                                        </div> 
             
       <?php
        
       $getCommentInfoRatingFive = $wpdb->get_results("SELECT dish_id,comment_approved FROM $commentTable where dish_id = $dish_id AND comment_approved = 1 AND rating=5");

       $getCommentInfoRatingFour = $wpdb->get_results("SELECT dish_id,comment_approved FROM $commentTable where dish_id = $dish_id AND comment_approved = 1 AND rating=4");
       $getCommentInfoRatingThree = $wpdb->get_results("SELECT dish_id,comment_approved FROM $commentTable where dish_id = $dish_id AND comment_approved = 1 AND rating=3");
       $getCommentInfoRatingTwo = $wpdb->get_results("SELECT dish_id,comment_approved FROM $commentTable where dish_id = $dish_id AND comment_approved = 1 AND rating=2");
       $getCommentInfoRatingOne = $wpdb->get_results("SELECT dish_id,comment_approved FROM $commentTable where dish_id = $dish_id AND comment_approved = 1 AND rating=1");

        $getReviewAll = $wpdb->get_results("SELECT * FROM $commentTable where dish_id = $dish_id AND comment_approved = 1");
        
       
       $rating5= count($getCommentInfoRatingFive);
       $rating4= count($getCommentInfoRatingFour);
       $rating3= count($getCommentInfoRatingThree);
       $rating2= count($getCommentInfoRatingTwo);
       $rating1= count($getCommentInfoRatingOne);
       $totalCount = $rating1+$rating2+$rating3+$rating4+$rating5;
       if($totalCount>0){
       $rating5Per = (100*$rating5)/$totalCount;
       $rating4Per = (100*$rating4)/$totalCount;
       $rating3Per = (100*$rating3)/$totalCount;
       $rating2Per = (100*$rating2)/$totalCount;
       $rating1Per = (100*$rating1)/$totalCount;}else{
        $rating5Per=0;
        $rating4Per=0;
        $rating3Per=0;
        $rating2Per=0;
        $rating1Per=0;
       }
       ?>
         <div>                                   
        <div class='rating_overview'>
        <p style="color:green;display: none;" class='ratingSucess'>Thank you,Your rating submitted successfully.it is under review by admin.</p>
            <p> <b> <?= $_SESSION['lan']['rating_form']['overview']?>
 (<?= $totalCount;?>)</b> </p>
            <p><?= $_SESSION['lan']['rating_form']['dinner_review']?></p>
            <div class='col-sm-12 removePadding'>
                <div class='col-sm-4 col-xs-4 removePadding'>
                  <p><?= $_SESSION['lan']['rating_form']['excellent']?></p>
                  <p><?= $_SESSION['lan']['rating_form']['very_good']?></p>
                  <p><?= $_SESSION['lan']['rating_form']['average']?></p>
                  <p><?= $_SESSION['lan']['rating_form']['poor']?></p>
                  <p><?= $_SESSION['lan']['rating_form']['terrible']?></p>
                </div>
                <div class='col-sm-6 col-xs-6'>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="<?=$rating5Per;?>" aria-valuemin="0" aria-valuemax="100" style="width:<?=$rating5Per;?>%">
                          <span class="sr-only"><?=$rating5Per;?>% Complete</span>
                        </div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="<?=$rating4Per;?>" aria-valuemin="0" aria-valuemax="100" style="width:<?=$rating4Per;?>%">
                          <span class="sr-only"><?=$rating4Per;?>% Complete</span>
                        </div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="<?=$rating3Per;?>" aria-valuemin="0" aria-valuemax="100" style="width:<?=$rating3Per;?>%">
                          <span class="sr-only"><?=$rating3Per;?>% Complete</span>
                        </div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="<?=$rating2Per;?>" aria-valuemin="0" aria-valuemax="100" style="width:<?=$rating2Per;?>%">
                          <span class="sr-only"><?=$rating2Per;?>% Complete</span>
                        </div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="<?=$rating1Per;?>" aria-valuemin="0" aria-valuemax="100" style="width:<?=$rating1Per;?>%">
                          <span class="sr-only"><?=$rating1Per;?>% Complete</span>
                        </div>
                    </div>
                </div>
                <div class='col-sm-2 col-xs-2 ratingNumaric'>
                    <p><?=$rating5;?></p>
                    <p><?=$rating4;?></p>
                    <p><?=$rating3;?></p>
                    <p><?=$rating2;?></p>
                    <p><?=$rating1;?></p>
                </div>
            </div>
           
        </div>
		</div>
		<div >
        <form  method="post" class="comment_form">
          <input type="text" name="comment_title" placeholder="<?= $_SESSION['lan']['rating_form']['title']?>..." style="width: 100%!important;" class="comment_title" required="true">  
          <textarea name="comment_description" placeholder="<?= $_SESSION['lan']['rating_form']['ur_review']?>" class="comment_description" required="true"></textarea>
           <div class="my_row">
            <div class="stars">
            </div>
            </div>
            <div class="my_row">
            <div class="stars">
                <input type="radio" name="star" class="star-1" id="star-1<?= $j?>" value="1" required/>
                <label class="star-1" for="star-1<?= $j?>">1</label>
                <input type="radio" name="star" class="star-2" id="star-2<?= $j?>" value="2" required/>
                <label class="star-2" for="star-2<?= $j?>">2</label>
                <input type="radio" name="star" class="star-3" id="star-3<?= $j?>" value="3" required/>
                <label class="star-3" for="star-3<?= $j?>">3</label>
                <input type="radio" name="star" class="star-4" id="star-4<?= $j?>" value="4" required/>
                <label class="star-4" for="star-4<?= $j?>">4</label>
                <input type="radio" name="star" class="star-5" id="star-5<?= $j?>" value="5"  required/>
                <label class="star-5" for="star-5<?= $j?>">5</label>
                <span></span>
            </div>
            <input type="hidden" name="language_code" value="<?=$lan?>">
            <input type="hidden" name="dish_id" value="<?=$dish_id?>">
            <input type="hidden" name="in_response" value="<?=  get_the_id();?>">
            </div>
            <?php 
              if($fblogin==1)
              {
            ?>
            <button type='submit' class="btn btn-primary submitbtn"><?= $_SESSION['lan']['rating_form']['send']?> </button>
            <?php }else{?>
            <a href="<?php echo htmlspecialchars($loginUrl);?>" class="btn btn-primary submitbtn"><?= $_SESSION['lan']['Loginwithfacebook'];?></a>
            <?php }?>

        </form>


        <div class='listOfComment'>
            <?php
             foreach ($getReviewAll as $data)
             {
                 
                 
                    $star = $data->rating;
                    $star = $star*10;
                    $user_id = $data->user_id;
                    if($user_id==0 || $user_id=="")
                    {
                        $imgUrl = get_template_directory_uri()."/assets/images/avtar.png";
                        $username = "Anonymous User";
                    }
                    else
                    {
                       $imgUrl = esc_url( get_avatar_url( $user_id ) );
                       $username = $data->comment_author;
                    }
					
					echo '<div class="listItem">';
					echo '<div class="l-img"><figure><img src="'.$imgUrl.'"/></figure><p>'.$username.'</p></div>';
                     echo '<div class="r-content"><span class="rating-static rating-'.$star.'"></span>';echo "<h3>".$data->comment_title."</h3>";
                     echo "<p class='commentListDesc'>".$data->comment_content."</p></div>";
					 echo '</div>';
                }
             ?>
         </div>
		</div>
                        </div>
                        <div class="modal-footer">
                        </div>
                     </div>
                  </div>
               </div>
                                   




                                    <div class="figure">
                                     <img  class='mainDishImg' data-toggle="modal" data-target="#myModal<?= $j;?>"src="<?php echo $menuDetail->attachment; ?>" alt="" onclick="Viewdish('<?php echo $dish_id;?>');"/>
                                    </div>
                                    <?php $j++;?>
                                    <div class="desc">
                                        <h5 class="menu_post">
                                            <span class="menu_title"><?php echo $menuDetail->name; ?> </span>

                                            <span class="menu_dots image"></span>
                                            <span class="menu_price <?=$menuDetail->price ?>"> <?php
                                                if ($menuDetail->price != '0') {
                                                    if($priceNotRequired==0){ //To test is need to show price
                                                      $isInt = intval($menuDetail->price);
                                                      if($isInt==0){ //To test is need to show Doller
                                                        echo $menuDetail->price;
                                                      }else{
                                                        echo "€" . $menuDetail->price;
                                                       }
                                                      }
                                                    }
                                                ?></span>
                                        </h5>
                                        <div class="post_detail menu_excerpt"> <?php echo $menuDetail->description; ?>
                                        </div>
                                        <br class="clear">
                                        <ul>
                                            <?php
                             $query = "SELECT * from $menu_options_table where menu_id =" . $menuDetail->id;
                                            $dishInfo = $wpdb->get_results($query);
                                            //echo "<pre>";
                                            //print_r($menuDetails);
                                            foreach ($dishInfo as $sizeTitle) {
                                                ?>
                                                <h5 class="menu_post size image">
                                                    <span class="menu_title size"><?php echo $sizeTitle->size_title; ?></span>
                                                    <span class="menu_dots image size"></span>
                                                    <span class="menu_price size"><?php
                                                     if ($sizeTitle->price){
                                                          if($priceNotRequired==0){

                                                            //To test is need to show price
                                                        $isInt = intval($sizeTitle->price);
                                                          if($isInt==0)
                                                          {
                                                           //To test is need to show Doller
                                                            echo $sizeTitle->price;
                                                          }
                                                          else
                                                          {
                                                            echo "€" . $sizeTitle->price;
                                                           }
                                                           
                                                    
                                                       }
                                                   
                                                   }
                                                        ?></span>
                                                </h5>
                                            <?php } ?>
                                            <div class='Ticon'>
                                                <?php
                                                if ($menuDetail->icon_list != '') {
                                                    $iconList = $menuDetail->icon_list;
                                                    $list = explode(',', $iconList);
                                                    foreach ($list as $iconTitle) {
                                                        $iconTitle = explode('~', $iconTitle);
                                                        $icon = $iconTitle[0];
                                                        $title = $iconTitle[1];
                                                        echo "<a href='javascript:void(0)' data-toggle='tooltip' title='$title' ><figure><img src='$icon' ></a></figure>";
                                                    }
                                                }
                                                ?>
                                            </div>  
                                    </div>
                                </li>
                            <?php } ?>
                            
                        </ul>
                    </div>
                </div>
                <!-- Repeat Row End -->
                <?php
            }
        }
        ?>
        <?php if($id==920){ echo "<span style='font-family: Lato; font-size: 13px; font-weight: bolder; margin-left:77px;'>En terraza, incremento del 10% sobre el precio</span>";}?>
    </div>
</section>

    <script type="text/javascript">

            jQuery(document).ready(function() {

                jQuery(document).on("click",'.whatsapp',function() {

            if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {

                    var text = jQuery(this).attr("data-text");
                    var url = jQuery(this).attr("data-link");
                    var desc = jQuery(this).attr("data-desc");
                    var img = jQuery(this).attr("data-img");
                    var message = encodeURIComponent(text)+" "+encodeURIComponent(desc)+"  - "+encodeURIComponent(img);
                    var whatsapp_url = "whatsapp://send?text="+message;
                    window.location.href= whatsapp_url;
            } else {
                alert("Please share this article in mobile device");
                exit();
            }

                });
            });
            </script>

<script>
var tooljs = $.noConflict();
    tooljs(document).ready(function () {
    listCookies();
        function listCookies() {
            var theCookies = document.cookie.split(';');
            theCookies = theCookies[0].split('/');
            theCookies = theCookies[theCookies.length - 1];
            $('.lang').each(function () {
                if ($(this).hasClass(theCookies)) {
                    $(this).addClass('activelang');
                } else {
                    $(this).removeClass('activelang');
                }
            });
        }
        
    });
    
    
 tooljs(document).ready(function(){
tooljs('[data-toggle="tooltip"]').tooltip({
    placement : 'top'
});
});
    </script>
<?php
get_footer();
//echo $iconList;
?>
