<?php
/*
  Template Name:Manage category Actions
 */
session_start();
global $wpdb;
 $restaurant_info_table = $wpdb->prefix."restaurant_infos";
 $menu_categorie_table = $wpdb->prefix."menu_categories";
 $menu_detail_table = $wpdb->prefix."menu_categories";
 $menu_option_table = $wpdb->prefix."menu_options";
 $menu_categorie_table = $wpdb->prefix."menu_categories";




$user = wp_get_current_user();
$userId = $user->id;
$resultPageId = $wpdb->get_row("SELECT page_id,language,user_id FROM $restaurant_info_table WHERE user_id = $userId");
$pageId = $resultPageId->page_id;
$lang = $resultPageId->language;
$languageList = explode(',', $lang);
                        


get_header();

/*Get current language code*/
if($_SESSION['lanCode']){
	$currentlan = $_SESSION['lanCode'];
}else{
	$currentlan ="es";
	}
if (isset($_POST['submit']))
    {
      
        if (isset($_GET['editmenu']) && is_numeric($_GET['editmenu']))
        {
            ## update 
              $parentcatid=  $_GET['editmenu'];
              $categoryname = $_REQUEST['categoryname'];
              $language = $_GET['languageid'];
                if($language=='')
                {
                    $language = 'es';
                }
              $wpdb->query("UPDATE $menu_categorie_table SET menu_name='$categoryname' WHERE parentcatid='$parentcatid' AND language='$language'");
        }
        else
        {
            ## add 
            $parentcatid = 0;$i=0;
            foreach($languageList as $valueInfo1)
            {
                
                if($valueInfo1=='Spanish')
                 $lang ='es';
                else if($valueInfo1=='English')
                $lang ='en';
                else if($valueInfo1=='French')
                $lang ='fr';
                else if($valueInfo1=='Italian')
                 $lang ='it';
                else if($valueInfo1=='japanese')
                $lang ='ja';
                
                $categoryname = $_REQUEST['categoryname'];
                $qtitle = str_replace(" ","%20",$categoryname);
                //$url = "https://www.googleapis.com/language/translate/v2?key=AIzaSyAFadHLoo1Yc6Yvx4ewreqFPdljlkJI8Hk&target=".$lang."&q=".$qtitle;
                $url = "https://www.googleapis.com/language/translate/v2?key=AIzaSyAFadHLoo1Yc6Yvx4ewreqFPdljlkJI8Hk&source=".$currentlan."&target=".$lang."&q=".$qtitle;
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                $result = curl_exec($curl);
                curl_close($curl);
                $json = json_decode($result, true);
                /*Check current language code with langauge*/
                if($currentlan==$lang){
					$qcategoryname =  $categoryname;
				}else{
					$qcategoryname =  $json[data][translations][0][translatedText];
				}
                
                $wpdb->insert($menu_categorie_table, array(
                    'menu_name' =>$qcategoryname,
                    'entry_by' => $userId,
                    'parentcatid' => $parentcatid,
                    'language'=>$lang
                ));
              
              if($parentcatid==0)
              {
                  $parentcatid=   $wpdb->insert_id;
                  $wpdb->query("UPDATE $menu_categorie_table SET parentcatid='$parentcatid' WHERE id=$parentcatid");
              }
              
                
               $i++;
                
            }
            
        }?>

 <script> window.location = "<?php echo site_url() . '/manage-category/' ?>";</script>

    <?php 
    
              }
  
$menu_details = array();
$categoryname="";
if (isset($_GET['editmenu']) && is_numeric($_GET['editmenu']))
    {
      
      
       $language = $_GET['languageid'];
       if($language=='')
       {
           $language = 'es';
       }
       $query = "SELECT * FROM $menu_detail_table WHERE language='$language' AND parentcatid=" . $_GET['editmenu'];
       $menu_details = $wpdb->get_results($query);
       if(!empty($menu_details))
       {
           $categoryname = $menu_details[0]->menu_name;
       }
}
?>

<section id="my-account" class="manageResturantmenu">
    <div class="container">
        <?php include 'usernotification.php'; ?>
        <div class="row">
            <div class="col-md-3 col-sm-4 col-sx-12 account-menu">
          <h3><?= $_SESSION['lan']['my_account']?></h3>
          <?php
          if($_SESSION['lanCode']=='' || $_SESSION['lanCode']=='es'){  wp_nav_menu(array('theme_location'=>'sidebar-menu'));}
          else{
              wp_nav_menu(array('theme_location'=>'sidebar-menu-english'));
          }
          ?>
            </div>
            <div class="col-md-9 col-sm-8 col-xs-12 account-details add-cat">
               
                    <h3><?= $_SESSION['lan']['dish_page']['add_category']?></h3>
                    
                            
                <div class="wrapped">
                    
                    <div class="food_section">
                        
                        <form method="post" enctype="multipart/form-data" id="dishform" onsubmit="return validationCheck()">
                            <div id="mydishform">
                                <div class="wrapped wrappedinner">
                                    
                                    <div class="row">
                                        
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name"><?= $_SESSION['lan']['dish_page']['category']?>*</label>
                                                <input type="text" class="form-control" id="name" name="categoryname" value="<?php echo $categoryname;?>">
                                            </div>
                                        </div>                              
                                    </div>
                                    
                                    
                                    
                                </div>
                            </div>
                            <input name="submit" type="submit" value="<?= $_SESSION['lan']['dish_page']['submitbtn']?>" id="submitdish" />
                        </form>
                    </div>
                </div>          
            </div>          
        </div>      
    </div>
</section>


<?php get_footer();
?>
