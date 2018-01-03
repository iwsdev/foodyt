<?php
// if($dishId){
// get_header('foodydish');
// }else{
// }
get_header('foody');
session_start();
?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
<?php
// $userId = $_REQUEST['id'];
 // echo "<pre>";
 // print_r($_SESSION['catId']);
//echo $_SESSION['catId'];
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
// $json_string = file_get_contents("http://graph.facebook.com/?id=http://cmsbox.in/wordpress/foodyTv2/restaurant/dish/mar-adentro/70.html"); 
// $json = json_decode($json_string, true);
// echo '<pre>'; 
// print_r($json); 
// $fbCount= $json['share']['share_count']; 
// echo '';

$lan = $_REQUEST['lang'];

if($lan=='')
{
    $lan = 'es';
    $category_name = 'Categorías';
}
else if($lan=='es')
$category_name = 'Categorías';
else if($lan=='en')
$category_name = 'Categories';
else if($lan=='fr')
$category_name = 'Catégories';
else if($lan=='it')
$category_name = 'Categorie';
else if($lan=='ja')
$category_name = 'カテゴリ';
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
 foreach ($catList as $catName) {
              $menu_id = $catName->id;
              if (in_array($menu_id, $manuCatId)) {
                $menuCatId = $catName->id; break;
              }
          }
// $menuCatId =29;
  if(isset($_SESSION['catId'])){
    $menuCatId = $_SESSION['catId'];
    // echo "Set session";
  }
//To get category Name
// echo $menuCatId;
$catName = $wpdb->get_row("SELECT * from $menu_categorie_table where id = ".$menuCatId." AND entry_by =" . $userId);
$dishDetail = "SELECT * from $menu_detail_table where menu_cat_id =" . $menuCatId . " AND entry_by =" . $userId . " AND language = '" . $lan . "' AND  status=2";
$dishDetailList = $wpdb->get_results($dishDetail);
// echo "<pre>";
// print_r($dishDetailList); 


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
     $priceNotRequired=0; 
     if($urlInfo)
     {
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


<header id="header" class="desk">
    <div class="container">
      <div class="logo">
        <a href="#"><img src="<?php echo $logoImg; ?>"/></a>
      </div>      
      <div class="headerRight">
        <div class="headerContact">
          <div class="l-name"><?php echo get_the_title($pageId); ?></div>
          <ul>
            <li><a href="tel:954542446"><?php  echo get_post_meta($pageId, 'mobilenumber', true);?></a></li>
            <li><a href="javascript:void(0)" data-toggle="modal" data-target="#g-map" >
            <?php 
             $add = get_post_meta($pageId, 'address', true);
            $len = strlen($add);
            if($len<=30){
              echo $add;
            }else{
              echo substr($add,0,20)."....";
            }?></a>
            </li>
          </ul>
        </div>
        <div class="text-area">
            <div class="l-name2">
            <?php  $cus = get_post_meta($pageId, 'cusine', true); 
            $cusion= explode(',', $cus);
            $i=1;
            $len = count($cusion);
            foreach($cusion as $val){
              echo $val;
              if($len!=$i)
              echo ", ";
              if($i%4==0){
                echo "</br>";
              }
              $i++;
            }
            ?>
              
            </div>
            <div class="par"><?php the_content();?></div>
        </div>
      </div>
    </div>
</header>

<section id="navbar" class="desk">
    <div class="container">
      <div class="cat">
        <a href="javascript:void(0)" data-toggle="modal" data-target="#category">
        <?php echo $category_name;?></a>
      </div>
      <div class="main-logo">
        <a href="<?php echo site_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/foodyT-logo.png" alt=""/></a>
      </div>
      <div class="lag-switcher">
        <div class="switcher">
          <ul>
          <li class="dropdown">

          

        <?php
                    if($lan=='en'){ ?>
                    <a class="dropdown-toggle " data-toggle="dropdown" href='<?php echo $urlPage."?lang=en"; ?>' onclick='myFunction1("en");'><img src="<?php echo get_template_directory_uri(); ?>/assets/images/english.png" alt=""/> EN <i class="fa fa-caret-down" aria-hidden="true" style="margin-left:7px"></i>
                    </a>
                    <?php }

                    if($lan=='es'){ ?> 
                      <a class="dropdown-toggle " data-toggle="dropdown" href='<?php echo $urlPage."?lang=es"; ?>' onclick='myFunction1("es");'><img src="<?php echo get_template_directory_uri(); ?>/assets/images/espanol.png" alt=""/> ES<i class="fa fa-caret-down" aria-hidden="true" style="margin-left:7px"></i></a>
                      <?php } ?>

                      <?php if ($lan == 'fr') { ?>
                        <a class="dropdown-toggle " data-toggle="dropdown" href='<?php echo $urlPage."?lang=fr"; ?>' onclick='myFunction1("fr");'><img src="<?php echo get_template_directory_uri(); ?>/assets/images/french.png" alt=""/> FR<i class="fa fa-caret-down" aria-hidden="true" style="margin-left:7px"></i></a>
                    <?php } ?>

                     <?php 
                      if ($id==1199 && $lan == 'ja'){ ?>
                          <a class="dropdown-toggle " data-toggle="dropdown" href='<?php echo $urlPage."?lang=ja"; ?>' onclick='myFunction1("ja");'><img src="<?php echo get_template_directory_uri(); ?>/assets/images/china.png" alt=""/> CN<i class="fa fa-caret-down" aria-hidden="true" style="margin-left:7px"></i></a>
                      <?php } 
                       if ($id!=1199 && $lan == 'ja'){ ?>

                            <a class="dropdown-toggle " data-toggle="dropdown" href='<?php echo $urlPage."?lang=ja"; ?>' onclick='myFunction1("ja");'><img src="<?php echo get_template_directory_uri(); ?>/assets/images/japanese.png" alt=""/> JA<i class="fa fa-caret-down" aria-hidden="true" style="margin-left:7px"></i></a>
                        <?php } ?>
                        <?php if ($lan == 'it') { ?>
                               <a class="dropdown-toggle " data-toggle="dropdown" href='<?php echo $urlPage."?lang=it"; ?>' onclick='myFunction1("it");'><img src="<?php echo get_template_directory_uri(); ?>/assets/images/italian.png" alt=""/> IT<i class="fa fa-caret-down" aria-hidden="true" style="margin-left:7px"></i></a>
                        <?php } ?>      
                        

            <ul role="menu" class="dropdown-menu dropdown-light singlePageFlag">

                        <?php
                        // Note: myFunction1() is not used if u want remove u can remove it, being a developer i am not going to remove it because fure it might be needed.. 
                        foreach ($language as $lang) {
                            if ($lang == 'English') {
                                ?>
                                <li><a datahref ='<?php echo $urlPage."?lang=en"; ?>' class="menu-toggler" href='javascript:void(0)' onclick='myFunction1("en");'><img src="<?php echo get_template_directory_uri(); ?>/assets/images/english.png" alt=""/> EN</a></li>
                            <?php } ?>
                            <?php if ($lang == 'Spanish') { ?>
                                <li><a datahref ='<?php echo $urlPage."?lang=es"; ?>' class="menu-toggler" href='javascript:void(0)' onclick='myFunction1("es");'><img src="<?php echo get_template_directory_uri(); ?>/assets/images/espanol.png" alt=""/> ES</a></li>
                            <?php } ?>
                            <?php if ($lang == 'French') { ?>
                                <li><a datahref ='<?php echo $urlPage."?lang=fr"; ?>' class="menu-toggler" href='javascript:void(0)' onclick='myFunction1("fr");'><img src="<?php echo get_template_directory_uri(); ?>/assets/images/french.png" alt=""/> FR</a></li>
                            <?php } ?>
                            <?php if ($lang == 'japanese' && $id==1199) { ?>
                                <li><a datahref ='<?php echo $urlPage."?lang=ja"; ?>' class="menu-toggler" href='javascript:void(0)' onclick='myFunction1("ja");'><img src="<?php echo get_template_directory_uri(); ?>/assets/images/china.png" alt=""/> CN</a></li>
                            <?php }
                            if ($lang == 'japanese' && $id!=1199){?>
                                <li><a datahref ='<?php echo $urlPage."?lang=ja"; ?>' class="menu-toggler" href='javascript:void(0)' onclick='myFunction1("ja");'><img src="<?php echo get_template_directory_uri(); ?>/assets/images/japanese.png" alt=""/> JA</a></li>
                             <?php } ?>
                            <?php if ($lang == 'Italian') { ?>
                                <li><a datahref ='<?php echo $urlPage."?lang=it"; ?>' class="menu-toggler" href='javascript:void(0)' onclick='myFunction1("it");'><img src="<?php echo get_template_directory_uri(); ?>/assets/images/italian.png" alt=""/> IT</a></li>
                            <?php } ?>      
                        <?php } ?>
                    </ul>

          </li>
        </ul>
      </div>
      </div>
    </div>
  </section>
  
<!-- Mobile -->
  <header id="header" class="mobile">
    <div class="container">
      <div class="main-logo">
        <a href="<?php echo site_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/foodyT-logo.png" alt=""/></a>
      </div>

      <div class="lag-switcher">
        <div class="switcher">
          <ul>

          <li class="dropdown">
              <?php
                    if($lan=='en'){ ?>
                    <a class="dropdown-toggle " data-toggle="dropdown" href='<?php echo $urlPage."?lang=en"; ?>' onclick='myFunction1("en");'><img src="<?php echo get_template_directory_uri(); ?>/assets/images/english.png" alt=""/> EN <i class="fa fa-caret-down" aria-hidden="true" style="margin-left:7px"></i>
              </a>
                        <?php }

                        if($lan=='es'){ ?> 
                            <a class="dropdown-toggle " data-toggle="dropdown" href='<?php echo $urlPage."?lang=es"; ?>' onclick='myFunction1("es");'><img src="<?php echo get_template_directory_uri(); ?>/assets/images/espanol.png" alt=""/> ES<i class="fa fa-caret-down" aria-hidden="true" style="margin-left:7px"></i></a>
                            <?php } ?>

                            <?php if ($lan == 'fr') { ?>
                                <a class="dropdown-toggle " data-toggle="dropdown" href='<?php echo $urlPage."?lang=fr"; ?>' onclick='myFunction1("fr");'><img src="<?php echo get_template_directory_uri(); ?>/assets/images/french.png" alt=""/> FR<i class="fa fa-caret-down" aria-hidden="true" style="margin-left:7px"></i></a>
                            <?php } ?>
                            <?php if ($lan == 'ja' && $id==1199) { ?>
                                <a class="dropdown-toggle " data-toggle="dropdown" href='<?php echo $urlPage."?lang=ja"; ?>' onclick='myFunction1("ja");'><img src="<?php echo get_template_directory_uri(); ?>/assets/images/china.png" alt=""/> CN<i class="fa fa-caret-down" aria-hidden="true" style="margin-left:7px"></i></a>
                            <?php }
                            if ($lan == 'ja' && $id!=1199){?>
                              <a class="dropdown-toggle " data-toggle="dropdown" href='<?php echo $urlPage."?lang=ja"; ?>' onclick='myFunction1("ja");'><img src="<?php echo get_template_directory_uri(); ?>/assets/images/japanese.png" alt=""/> JA<i class="fa fa-caret-down" aria-hidden="true" style="margin-left:7px"></i></a>
                              <?php } ?>
                            <?php if ($lan == 'it') { ?>
                               <a class="dropdown-toggle " data-toggle="dropdown" href='<?php echo $urlPage."?lang=it"; ?>' onclick='myFunction1("it");'><img src="<?php echo get_template_directory_uri(); ?>/assets/images/italian.png" alt=""/> IT<i class="fa fa-caret-down" aria-hidden="true" style="margin-left:7px"></i></a>
                        <?php } ?>      
                        

            <ul role="menu" class="dropdown-menu dropdown-light fadeInUpShort singlePageFlag">

                        <?php
                        // Note: myFunction1() is not used if u want remove u can remove it, being a developer i am not going to remove it because fure it might be needed.. 
                        foreach ($language as $lang) {
                            if ($lang == 'English') {
                                ?>
                                <li><a class="menu-toggler" datahref='<?php echo $urlPage."?lang=en"; ?>' onclick='myFunction1("en");'><img src="<?php echo get_template_directory_uri(); ?>/assets/images/english.png" alt=""/> EN</a></li>
                            <?php } ?>
                            <?php if ($lang == 'Spanish') { ?>
                                <li><a class="menu-toggler" datahref='<?php echo $urlPage."?lang=es"; ?>' onclick='myFunction1("es");'><img src="<?php echo get_template_directory_uri(); ?>/assets/images/espanol.png" alt=""/> ES</a></li>
                            <?php } ?>
                            <?php if ($lang == 'French') { ?>
                                <li><a class="menu-toggler" datahref='<?php echo $urlPage."?lang=fr"; ?>' onclick='myFunction1("fr");'><img src="<?php echo get_template_directory_uri(); ?>/assets/images/french.png" alt=""/> FR</a></li>
                            <?php } ?>
                            <?php if ($lang == 'japanese' && $id==1199) { ?>
                                <li><a class="menu-toggler" datahref='<?php echo $urlPage."?lang=ja"; ?>' onclick='myFunction1("ja");'><img src="<?php echo get_template_directory_uri(); ?>/assets/images/china.png" alt=""/> CN</a></li>
                            <?php } 
                            if ($lang == 'japanese' && $id!=1199){?>
                            <li><a class="menu-toggler" datahref='<?php echo $urlPage."?lang=ja"; ?>' onclick='myFunction1("ja");'><img src="<?php echo get_template_directory_uri(); ?>/assets/images/japanese.png" alt=""/> JA</a></li>
                              <?php }?>
                            <?php if ($lang == 'Italian') { ?>
                                <li><a class="menu-toggler" datahref='<?php echo $urlPage."?lang=it"; ?>' onclick='myFunction1("it");'><img src="<?php echo get_template_directory_uri(); ?>/assets/images/italian.png" alt=""/> IT</a></li>
                            <?php } ?>      
                        <?php } ?>
                    </ul>

          </li>
          </ul>
      </div>
      </div>      
      <div class="headerRight">
        <div class="headerContact">         
          <ul>
          	<li><a href="tel:954542446"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/phone.png"></a></li>
            <li><a href="javascript:void(0)" data-toggle="modal" data-target="#g-map"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/map.png"></a></li>            
          </ul>
        </div>        
      </div>
    </div>
</header>


<section id="logo-area" class="mobile">
    <div class="container">
      
      <div class="logo">
        <a href="#"><img src="<?php echo $logoImg; ?>"/></a>        
      </div>
      <div class="l-name"><h3><?php echo get_the_title($pageId); ?></h3></div>
      <div class="clearfix"></div>
      <div class="text-area">
            <div class="l-name2">
            <?php  $cus = get_post_meta($pageId, 'cusine', true); 
            $cusion= explode(',', $cus);
            $i=1;
            $len = count($cusion);
            foreach($cusion as $val){
              echo $val;
              if($len!=$i)
              echo ", ";
              if($i%4==0){
                echo "</br>";
              }
              $i++;
            }
            ?></div>
            <div class="par"><?php the_content();?></div>
        </div>
    
    </div>
  </section>
  
<section id="mobileNav" class="mobile">
  <div class="container">
    <ul>
      <li><a href="javascript:void(0)" data-toggle="modal" data-target="#category"><?php echo $category_name;?></a></li>
      <li><a href="#" class="grid-view"> &nbsp;</a></li>
      <li><a href="#" class="list-view">&nbsp; </a></li>
    </ul>
  </div>
</section>


<!-- Mobile End -->

<section id="entrantes">
  <div class="container">
<!--Start of section whole category with image desktop--> 
<div class="food-gallery grid">
 <?php 
 $j=1 ;
 $i=1;
 foreach ($catList as $catName) {
  $menu_id = $catName->id;
    if (in_array($menu_id, $manuCatId)) { ?>
    <div id="<?php echo $i;?>" style="overflow: hidden;">
      <h2 >
      <?php echo $catName->menu_name;
      $i++;
      ?>
      </h2>
        <ul>
        <?php 
        $query = "SELECT * from $menu_detail_table where menu_cat_id =" . $catName->id . " AND entry_by =" . $userId . " AND language = '" . $lan . "' AND  status=2";
        $menuDetails = $wpdb->get_results($query);
        //dishDetailList
        foreach ($menuDetails as $dishList) {?>
          <li>
            <div class="wrap">
              <figure><img onclick="Viewdish('<?php echo $dishList->id;?>');" src="<?php echo $dishList->attachment;?>"></figure>
              <div class="content"><h3><?php echo $dishList->name;?> </h3></div>
            </div>
            <a href="#" class="ogChange" data-toggle="modal" data-target="#myModal<?= $j;?>" onclick="Viewdish('<?php echo $dishList->id;?>');"></a>
          </li>
          <?php $j++;} ?>
        </ul>
      </div>
<?php }  } ?>
      </div>
  <!--End of section whole category with image desktop-->   
    

  <div class="food-gallery list" >
   <?php 
    $j=1 ;
    $i=30;
    foreach ($catList as $catName) {
    $menu_id = $catName->id;
    if (in_array($menu_id, $manuCatId)) { ?>
   <div id="<?php echo $i;?>" style="overflow: hidden;">
   <h2><?php echo $catName->menu_name;
     $i++;
   ?></h2>
    <ul>
    <?php 
    $query = "SELECT * from $menu_detail_table where menu_cat_id =" . $catName->id . " AND entry_by =" . $userId . " AND language = '" . $lan . "' AND  status=2";
    $menuDetails = $wpdb->get_results($query);
        //dishDetailList
    foreach ($menuDetails as $dishList) {?>
    <li>
    <div class="wrap">
      <figure><img src="<?php echo $dishList->attachment;?>"></figure>
      <div class="content">
        <h3><?php echo $dishList->name;?> </h3>
        <div class="foodlist">
          <ul>
            <?php
             $query = "SELECT * from $menu_options_table where menu_id =" . $dishList->id;
            $dishInfo = $wpdb->get_results($query);
            // echo "<pre>";
            // print_r($dishInfo);
            foreach ($dishInfo as $sizeTitle) { ?>
            <li>
              <span class="name"><?php echo $sizeTitle->size_title; ?></span>
              <?php 
              if($dishList->price){
              //echo '<span class="bullets"></span>';
              echo '<span class="menu_price"><b>';
              echo "€" .$dishList->price ?> </b></span>
              <?php } else{
              echo '<span class="bullets"></span>';
                }?>
<!--               <span class="bullets"></span> 
 -->              <span class="price"><?php
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
            </li>
            <?php } ?>
          </ul>
        </div>
        <div class="cuisine">
          <ul>
            <?php
            if ($dishList->icon_list != '') {
                $iconList = $dishList->icon_list;
                $list = explode(',', $iconList);
                foreach ($list as $iconTitle) {
                    $iconTitle = explode('~', $iconTitle);
                    $icon = $iconTitle[0];
                    $title = $iconTitle[1];
                    echo "<li><a href='javascript:void(0)' data-toggle='tooltip' title='$title' ><img src='$icon' ></a></li>";
                 }
              }
            ?>
          </ul>
        </div>
      </div>              
    </div>
    <a href="#" data-toggle="modal" data-target="#myModal<?php echo $j; ?>" ></a>
  </li>
  <?php $j++; } ?>        
    </ul>
  </div> 
    <?php }  } ?>
  </div> 
  
  
</div>
</div>


 <?php 
 $j=1 ;
 foreach ($catList as $catName) {
  $menu_id = $catName->id;
    if (in_array($menu_id, $manuCatId)) { 
        $query = "SELECT * from $menu_detail_table where menu_cat_id =" . $catName->id . " AND entry_by =" . $userId . " AND language = '" . $lan . "' AND  status=2";
        $menuDetails = $wpdb->get_results($query);
        //dishDetailList
        foreach ($menuDetails as $dishList) {?>

<div id="myModal<?php echo $j; ?>" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      <div class="modal-head">
        <h3><?php echo get_the_title($pageId); ?></h3>
      </div>    
      </div>
      <div class="modal-body">
        <div class="banner">
          <figure><img src="<?php echo $dishList->attachment;?>"></figure>
        </div>

      <?php 
      $urlPage2go =$urlPage."dishid/".$dishList->id;
      $dish_id = $dishList->id;
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
         } else
         {
          $startPercentage=0;
         }
      ?>

    <div class="sharing">
      <div class="left">
        <div class="star-ratings-sprite"><span style="width:<?= $startPercentage?>%" class="star-ratings-sprite-rating"></span></div>
      </div>
      <div class="right">
        <ul>
       
			<?php
			$post_slug =  get_post_field( 'post_name', $pageId );
		  $fbshareUrl = site_url()."/restaurant/dish/".$post_slug."/".$dish_id.".html";
			?>

       <?php 
       if($fblogin==1 || $userid >0)
       {

      ?>
      <?php 
      // echo "<pre>";
      // print_r($dishList);
      //echo "Thumnail".$dishList->attachment; ?>
      <li> <a data-dishid="<?= $dish_id?>" class="fbCount" href="javascript:void(0);" data-layout="button" onclick="window.open('https://www.facebook.com/sharer.php?u=<?php echo $fbshareUrl;?>&summary=<?= $dishList->description; ?>&title=<?=$dishList->name?>&description=<?= $dishList->description; ?>&picture=<?= $dishList->attachment; ?>','ventanacompartir', 'toolbar=0, status=0, width=650, height=450');"> <img src="<?php echo bloginfo('template_url')?>/assets/images/fb.png"></a></li>
    <?php }else{?>
      <li>  <a href="<?php echo htmlspecialchars($loginUrl);?>" target="_blank"><img src="<?php echo bloginfo('template_url')?>/assets/images/fb.png"></a>
 </li>
      <?php }?>

         <li> <a data-dishid="<?= $dish_id?>" class="twitCountId" target="_blank" href="http://twitter.com/intent/tweet?text=<?=$dishList->name?>  &url=<?= $urlPage2go;?>"><img src="<?php echo bloginfo('template_url')?>/assets/images/twitter-icon.png">
          </a></li>
        </ul>
      </div>
    </div>

    <div <?php  if($dishList->price){?> class="food-detail both" <?php } else { ?> class="food-detail" <?php }?>>
     <p>
     <span><?php echo $dishList->name;?></span>

            </p>
      <p class="price"><?php 
           if($dishList->price){
             echo "€".$dishList->price;
           }?>
     </p>
     </div>
      <div class="food-desc">
      <p> <?php echo $dishList->description;?></p>

      <div class="pr">
        <div class="left">
          <ul>
             <?php
             $query = "SELECT * from $menu_options_table where menu_id =" . $dishList->id;
            $dishInfo = $wpdb->get_results($query);
            // echo "<pre>";
            // print_r($dishInfo);
            foreach ($dishInfo as $sizeTitle) { ?>
            <li>
              <span class="name"><?php echo $sizeTitle->size_title; ?></span>
              <span class="bullets"></span>
              <span class="price"><?php
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
            </li>
            <?php } ?>
          </ul>
        </div>
        <div class="right">
        <ul>
            <?php
            if ($dishList->icon_list != '') {
                $iconList = $dishList->icon_list;
                $list = explode(',', $iconList);
                foreach ($list as $iconTitle) {
                  $iconTitle = explode('~', $iconTitle);
                  $icon = $iconTitle[0];
                  $title = $iconTitle[1];
                  echo "<li><a href='javascript:void(0)' data-toggle='tooltip' title='$title' ><img src='$icon' ></a></li>";
                 }
              }
            ?>
          </ul>
        </div>
      </div>
    </div>
    
  <!-- Start Below Write-msg png -->

   <?php   $getReviewAll = $wpdb->get_results("SELECT * FROM $commentTable where dish_id = $dish_id AND comment_approved = 1");?>

    <div class="msg-area">
    <div class='rating_overview'>
        <p style="color:green;display: none;" class='ratingSucess'>Thank you,Your rating submitted successfully.it is under review by admin.</p>
    </div>
       
        <div class="write-icon">
          <a href="javascript:void(0)"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/write-msg.png" alt=""/></a>
        </div>
        
        <form method="post" class="comment_form form">
          <div class="title"><input type="text" placeholder="<?= $_SESSION['lan']['rating_form']['title']?>" name="comment_title" class="comment_title" required="true"></div>
          <div class="msgbox"><textarea class="comment_description" name="comment_description" placeholder="<?= $_SESSION['lan']['rating_form']['ur_review']?>" required="true"></textarea></div>
          <div class="fooBar">
            <div class="left"> <div class="stars">
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
            </div>
            <input type="hidden" name="language_code" value="<?=$lan?>">
            <input type="hidden" name="dish_id" value="<?=$dish_id?>">
            <input type="hidden" name="in_response" value="<?=  get_the_id();?>">


            <?php 
            if($fblogin==1)
            {
            ?>
             <button type='submit' class="btn btn-primary submitbtn"><?= $_SESSION['lan']['rating_form']['send']?> </button>

            <?php }else{?>
            <a href="<?php echo htmlspecialchars($loginUrl);?>" class="btn btn-primary submitbtn"><?= $_SESSION['lan']['Loginwithfacebook'];?></a>
            <?php }?>


          </div>
        </form>
    </div>
    
    <div class="comment-box">
      <ul>
       <?php
         $getReviewAll = $wpdb->get_results("SELECT * FROM $commentTable where dish_id = $dish_id AND comment_approved = 1 ORDER BY created_date DESC");
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
        ?>
        <li>
          <div class="left">
            <figure><img src="<?php echo $imgUrl; ?>"  alt=""/></figure>
            <h3><?php echo $username;?></h3>
          </div>
          <div class="right">
            <div class="title"><?php echo $data->comment_title?>! <span><?php echo $data->created_date?></span></div>
            <div class="like-icon r-content"><span class="rating-static rating-<?php echo $star;?>"></span></div>
            <div class="clearfix"></div>
            <div class="desc"><?php echo $data->comment_content;?>!!</div>
          </div>
        </li>
        <?php } ?>
      </ul>
    </div>
         
      </div>
      
    <div class="modal-footer">
      </div>
    </div>

  </div>
</div>
<?php $j++;} }}?>




<div id="category" class="modal fade" role="dialog">
  <div class="modal-dialog popcat">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h3><?php echo $category_name;?></h3>
       </div>
      <div class="modal-body">
      <ul class='catMenu'>
       <?php
         $i = 1;
         $k = 30;
         foreach ($catList as $catName)
         {
          $menu_id = $catName->id;
          if (in_array($menu_id, $manuCatId)) 
          {
           echo "<li class='desktopCat'><a href='javascript:void(0)' data-catid='$menu_id' idname=$i>  " . $catName->menu_name . "</a></li>";
           echo "<li class='mobileCat'><a href='javascript:void(0)' data-catid='$menu_id' idname=$k>  " . $catName->menu_name . "</a></li>";
                    $i++;
                    $k++;
          }
         }?>
        </ul> 
      </div>    
    <div class="modal-footer">
       
      </div>
    </div>

  </div>
</div>




<div id="g-map" class="modal fade" role="dialog">
  <div class="modal-dialog g-map">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>   
      </div>
      <div class="modal-body">
      <?php $add = get_post_meta($pageId, 'address', true);?>
      <iframe src="https://www.google.com/maps?q=<?php echo $add; ?>&output=embed" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
      </div>    
    <div class="modal-footer">
       
      </div>
    </div>

  </div>
</div>


<script>
  $(document).ready(function(){
    $('.msg-area .write-icon a').click(function(){
      $('.msg-area form').slideToggle();
    });
    
    $('a.grid-view').click(function(){
      $('.food-gallery.grid').show();
      $('.food-gallery.list').hide();
    });
    
    $('a.list-view').click(function(){
      $('.food-gallery.list').show();
      $('.food-gallery.grid').hide();
    });
  });
</script>

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


<?php
get_footer();
//echo $iconList;
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
  width: 250px;
  height: 44px;
  display: block;
  background: url('<?php echo bloginfo('template_url')?>/starmix.png') 0 0 no-repeat;
}
.rating-50 { background-position: 3px 0; }
.rating-40 { background-position: -50px 0 } 
.rating-30 { background-position: -93px 0; }
.rating-20 { background-position: -143px 0; }
.rating-10 { background-position: -193px 0; }
.rating-0 { background-position: -241px 0; }
 
.rating-5  { background-position: -48px -16px; }
.rating-15 { background-position: -36px -16px; }
.rating-25 { background-position: -24px -16px; }
.rating-35 { background-position: -12px -16px; }
.rating-45 { background-position: 0 -16px; }

.star-ratings-sprite {
  background: url("<?php echo bloginfo('template_url')?>/foodtTstarLogo.png") repeat-x;
  font-size: 0;
  height: 44px;
  line-height: 0;
  overflow: hidden;
  text-indent: -999em;
  width: 220px;
  margin: 0 auto;
}
  .star-ratings-sprite-rating {
  background: url("<?php echo bloginfo('template_url')?>/foodtTstarLogo.png") repeat-x;
    background-position: 0 100%;
    float: left;
    height: 43px;
    display:block;
  
}

.active{text-decoration: underline;}
    #masthead{display:none}
    .modal-dialog {
        top: 9px!important;
    }
   /* .site-content{padding-top:0}*/
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
.l-img p,.left h3{ word-break: break-all;}
.submitbtn{
  background: #00af87;
    border: 0;
    padding: 5px 10px;
    border-radius: 7px;
    color: #fff;
    font-weight: bold;
    font-family: 'Raleway', sans-serif;
    font-size: 16px;
    float: right;
    margin-right: 15px;
    margin-top: 5px;
}
.comment-box .right .desc {word-wrap: break-word;}
</style>