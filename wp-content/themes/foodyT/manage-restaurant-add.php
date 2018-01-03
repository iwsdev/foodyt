<?php
/*
  Template Name:Manage Restaurant Add Product
 */
session_start();
global $wpdb;
$restaurant_info_table = $wpdb->prefix."restaurant_infos";
$menu_categorie_table = $wpdb->prefix."menu_categories";
$menu_detail_table = $wpdb->prefix."menu_details";
$menu_option_table = $wpdb->prefix."menu_options";
$menu_categorie_table = $wpdb->prefix."menu_categories";

$user = wp_get_current_user();
$userId = $user->id;
$resultPageId = $wpdb->get_row("SELECT page_id,language,user_id FROM $restaurant_info_table WHERE user_id = $userId");
$pageId = $resultPageId->page_id;
$lang = $resultPageId->language;
$languageList = explode(',', $lang);
                        

if (isset($_GET['action']) && $_GET['action'] == 'savecategory') {
    if (is_user_logged_in()) {
        $wpdb->insert(
            $menu_categorie_table, array(
            'menu_name' => $_POST['category'],
            'entry_by' => get_current_user_id()
                ), array(
            '%s',
            '%f',
            '%d'
                )
        );
        echo $wpdb->insert_id;
        exit;
    }
}
get_header();

/*Get current language code*/
if($_SESSION['lanCode']){
	$currentlan = $_SESSION['lanCode'];
}else{
	$currentlan ="es";
	}

// start section get All icon of alergen
if (have_rows('alergen_icon', 794)):
    while (have_rows('alergen_icon', 794)) : the_row();
        $title = get_sub_field('icon_name');
        $imgUrl = get_sub_field('icon');
        $src = $imgUrl['url'];
        $iconList[] = array('src' => $src, 'title' => $title);
    endwhile;
endif;
// End section get All icon of alergen

if (isset($_POST['submit'])) {
    if (isset($_GET['editmenu']) && is_numeric($_GET['editmenu']))
        {
        
        $menutitle = $_POST['menu'][0]['menuname'];
        $menudesc = $_POST['menu'][0]['description'];
			
        if ($_FILES && isset($_FILES['menuimage']))
            {
			require_once( ABSPATH . 'wp-admin/includes/image.php' );
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
			require_once( ABSPATH . 'wp-admin/includes/media.php' );
            $upload_overrides = array('test_form' => false);
			$attach_id = media_handle_upload('menuimage',0);
            $movefile = wp_handle_upload($_FILES['menuimage'], $upload_overrides);
            $uploadArr = $movefile['url'];
           }
			
        if (!empty($uploadArr))
            {
              $_POST['menu'][0]['description'] = (isset($_POST['menu'][0]['description'])) ? $_POST['menu'][0]['description'] : '';
            $alergen = (count($_POST['menu'][0]['alergen']) > 0) ? implode(',', $_POST['menu'][0]['alergen']) : '';

            $wpdb->update(
                $menu_detail_table, array(
                'menu_cat_id' => $_POST['menu'][0]['categorytype'],
                'name' => $menutitle,
                'attachment' => $uploadArr,
                'description' => $menudesc,
                'price' => $_POST['menu'][0]['prince'],
                'icon_list' => $alergen,
                    ), array(
                'id' => $_GET['editmenu']
                    ), array(
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                    ), array('%d')
            );
        } else {
            $_POST['menu'][0]['description'] = (isset($_POST['menu'][0]['description'])) ? $_POST['menu'][0]['description'] : '';
            $alergen = (count($_POST['menu'][0]['alergen']) > 0) ? implode(',', $_POST['menu'][0]['alergen']) : '';
            $wpdb->update($menu_detail_table, array(
                'menu_cat_id' => $_POST['menu'][0]['categorytype'],
                'name' => $menutitle,
                'description' => $menudesc,
                'price' => $_POST['menu'][0]['prince'],
                'icon_list' => $alergen,
                    ), array(
                'id' => $_GET['editmenu']
                    ), array(
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                    ), array('%d')
            );
            
           
        }
        if (isset($_POST['menu'][0]['option']) && count($_POST['menu'][0]['option']) > 0) {
//            echo '<pre>';
//            print_r($_POST['menu'][0]['option']);
//            exit;
            foreach ($_POST['menu'][0]['option'] as $option) {
                if (isset($option['id'])) {
                    if (!isset($option['title']) && !isset($option['price'])) {
                        $wpdb->delete($menu_option_table, array('id' => $option['id']));
                    } else {
                       
                        $wpdb->update(
                            $menu_option_table, array(
                            'size_title' => $option['title'],
                            'price' => $option['price']
                                ), array('id' => $option['id']), array(
                            '%s',
                            '%s'
                                ), array('%d')
                        );
                    }
                } else {
                    $wpdb->insert(
                        $menu_option_table, array(
                        'size_title' => $option['title'],
                        'price' => $option['price'],
                        'menu_id' => $_GET['editmenu']
                            ), array(
                        '%s',
                        '%s',
                        '%d'
                            )
                    );
                }
            }
        }
    } else {
        
        if ($_FILES && isset($_FILES['menuimage']) && count($_FILES['menuimage']) > 0) {
			
			require_once( ABSPATH . 'wp-admin/includes/image.php' );
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
			require_once( ABSPATH . 'wp-admin/includes/media.php' );
			
            $file_ary = reArrayFiles($_FILES['menuimage']);
            $uploadArr = array();
            foreach ($file_ary as $file) {
                $upload_overrides = array('test_form' => false);
				
				//$attach_id = media_handle_upload($file,0);
                $movefile = wp_handle_upload($file, $upload_overrides);
                $uploadArr[] = $movefile['url'];
            }		
        }
        if (isset($_POST['menu']) && menuformvalidation($_POST['menu'])) {
            $i = 0;
            
           
            foreach ($_POST['menu'] as $value) {
                $value['description'] = (isset($value['description'])) ? $value['description'] : '';
                $alergen = (count($value['alergen']) > 0) ? implode(',', $value['alergen']) : '';
                $optionid = 0;
                
                foreach ($languageList as $valueInfo1)
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
                $queryCat = "SELECT * from $menu_categorie_table where  language = '" .$lang . "' AND parentcatid =" . $value['categorytype'];
                $catIdLang = $wpdb->get_results($queryCat);
                $menuCatId = $catIdLang[0]->id;
                
			          $menunameorg = $value['menuname'];
                $descriptionorg = $value['description'];
                
                $qtitle = str_replace(" ","%20",$menunameorg);
                //$url = "https://www.googleapis.com/language/translate/v2?key=AIzaSyAFadHLoo1Yc6Yvx4ewreqFPdljlkJI8Hk&target=$lang&q=".$qtitle;
                $url = "https://www.googleapis.com/language/translate/v2?key=AIzaSyAFadHLoo1Yc6Yvx4ewreqFPdljlkJI8Hk&source=".$currentlan."&target=".$lang."&q=".$qtitle;
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                $result = curl_exec($curl);
                curl_close($curl);
                $json = json_decode($result, true);
                $title2save =  $json[data][translations][0][translatedText]; 
                
                
                $qdes = str_replace(" ","%20",$descriptionorg);
                //$url = "https://www.googleapis.com/language/translate/v2?key=AIzaSyAFadHLoo1Yc6Yvx4ewreqFPdljlkJI8Hk&target=$lang&q=".$qdes;
                $url = "https://www.googleapis.com/language/translate/v2?key=AIzaSyAFadHLoo1Yc6Yvx4ewreqFPdljlkJI8Hk&source=".$currentlan."&target=".$lang."&q=".$qdes;
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                $result = curl_exec($curl);
                curl_close($curl);
                $json = json_decode($result, true);
                //echo "<pre>";print_r($json);die();
                $description2save =  $json[data][translations][0][translatedText]; 
                 
                /*Check current language code with langauge*/
                if($currentlan==$lang){
                  $title2save =  $menunameorg;
                }else{
                  $title2save =  $title2save;
                }
				
				/*Check current language code with langauge*/
            if($currentlan==$lang){
              $description2save =  $descriptionorg;
            }else{
              $description2save =  $description2save;
            }
                 echo "</br>".$title2save;
                 echo "</br>".$description2save;
                 echo "</br>".$lang;
                 $saved = $wpdb->insert(
                    "ft_menu_details", array(
                    'menu_cat_id' => $menuCatId,
                    'name' =>$title2save,
                    'attachment' => $uploadArr[$i],
                    'description' => $description2save,
                    'price' => $value['prince'],
                    'icon_list' => $alergen,
                    'entry_by' => get_current_user_id(),
                    'language' => $lang
                        ), 
                    array(
                    '%d',
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%d',
                    '%s'
                     )
                );
           

            
            //$i++;
                $menuid = $wpdb->insert_id;
                if (count($value['option']) > 0) {
                    foreach ($value['option'] as $option) {
                        if ($option['title'] == '' || ($option['price'] == '' && $option['price'] == 0)) {
                            
                        } else {
                             
                                $wpdb->insert(
                                    $menu_option_table, array(
                                    'size_title' => $option['title'],
                                    'price' => $option['price'],
                                    'menu_id' => $menuid,
                                    'language' => $lang
                                        ), array(
                                    '%s',
                                    '%s',
                                    '%d',
                                    '%s'
                                        )
                                );
                            
                        }
                    }
                }
             }
             $i++;
            } die;
            $_SESSION['formsuccess'] = 1;
            $_SESSION['formerrormsg'] =  $_SESSION['lan']['dish_page']['dish_succ'];
        } else {
            $_SESSION['formerror'] = 1;
            $_SESSION['formerrormsg'] =  $_SESSION['lan']['dish_page']['form_sub_error'];
        }
    }
    ?>
    <script> window.location = "<?php echo site_url() . '/manage-restaurant-menu' ?>";</script>
    <?php
}
//$language = $_SESSION['lanCode'];
$language = $wpdb->get_row("SELECT language FROM $menu_detail_table WHERE id =".$_GET['editmenu']);
$language = $language->language;
if (isset($_GET['editmenu']))
{
$query = "SELECT * FROM $menu_categorie_table WHERE language='$language' AND entry_by=" . get_current_user_id();
$menu_categories = $wpdb->get_results($query);
}else{
  $query = "SELECT * FROM $menu_categorie_table WHERE language='es' AND entry_by=" . get_current_user_id();
$menu_categories = $wpdb->get_results($query);   
}
 // echo "<pre>";
 // print_r($menu_categories);
$menu_details = array();
if (isset($_GET['editmenu']) && is_numeric($_GET['editmenu'])) {
    $query = "SELECT * FROM $menu_detail_table WHERE id=" . $_GET['editmenu'];
    $menu_details = $wpdb->get_results($query);
    $query = "SELECT * FROM $menu_option_table WHERE menu_id=" . $menu_details[0]->id;
    $menu_details_option = $wpdb->get_results($query);
    $menu_details[0]->options = $menu_details_option;
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
               
                    <h3><?= $_SESSION['lan']['add_dish']?></h3>
                    
                            
                <div class="wrapped">
                    <div class="cat" style="display:none;">
                        <h4><?= $_SESSION['lan']['dish_page']['categories']?> </h4>
                        <div class="frmSearch">
                            <input type="text" id="search-box" placeholder="<?= $_SESSION['lan']['dish_page']['cat_menu']?>" />
                            <a href="#" class="add_cat_icon" data-toggle="modal" data-target="#myModal"></a>
                            <div id="suggesstion-box"></div>
                        </div>
                    </div>
                    <?php //echo "<pre>";
                    //print_r($menu_categories);
                    //print_r($menu_details);
                    ?>
                    <div class="food_section">
                        <div style='float: left;width: 100%;'>
                        <h3 style="width: 270px;display: inline-block;" class="dishCreate"><?= $_SESSION['lan']['dish_page']['dish']?>
                            <?php if (count($menu_details) == 0) { ?>
                                <a  href="javascript:void(0)" class="add_food_icon" id="addmenu"></a>
                            <?php } ?>
                        </h3>
                         <?php if (count($menu_details) == 0) { ?>
                         <h3 style="display: inline-block;" class='manageCat'><a href="<?php echo get_the_permalink(1158) ?>"><?= $_SESSION['lan']['dish_page']['manageCat']?></a></h3>
                            <?php } ?> 
                         </div>

                        <form method="post" enctype="multipart/form-data" id="dishform" onsubmit="return validationCheck()">
                            <div id="mydishform">
                                <div class="wrapped wrappedinner">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a href="javascript:void(0)" class="close-thisform pull-right" style="text-decoration: none"><strong>&times;</strong></a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="category"><?= $_SESSION['lan']['dish_page']['category']?>*</label>
                                    <select name="menu[0][categorytype]" class="themenuoption">
                                        <?php if (count($menu_categories) > 0) { ?>
                                            <option value=''><?= $_SESSION['lan']['dish_page']['select_cat']?></option>
                                            <?php foreach ($menu_categories as $menu_category) { 
                                                        /*Langaue convert for title from api start*/
                                                       $qcategory = $menu_category->menu_name;
                                                        
                                                        //$title = $menu->name;
                                                         /* $qtitle = str_replace(" ","%20",$qcategory);
                                                        $url = "https://www.googleapis.com/language/translate/v2?key=AIzaSyAFadHLoo1Yc6Yvx4ewreqFPdljlkJI8Hk&target=".$lanid."&q=".$qtitle;
                                                        $curl = curl_init();
                                                        curl_setopt($curl, CURLOPT_URL, $url);
                                                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                                                        $result = curl_exec($curl);
                                                        curl_close($curl);
                                                        $json = json_decode($result, true);
                                                        $qcategoryname =  $json[data][translations][0][translatedText]; */
                                                        
                                                        /*Langaue convert from api end*/
                                                            ?>
                                                            <option value="<?php echo $menu_category->id; ?>" <?php echo (isset($menu_details) && !empty($menu_details) && count($menu_details) > 0 && isset($menu_details[0]) && !empty($menu_details[0]->menu_cat_id) && $menu_details[0]->menu_cat_id == $menu_category->id) ? 'selected="selected"' : '' ?>><?php echo ucfirst($qcategory); ?></option>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                    <option value=''><?= $_SESSION['lan']['dish_page']['no_option_avila']?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name"><?= $_SESSION['lan']['dish_page']['dish_name']?>*</label>
                                                <input type="text" class="form-control dish_name" id="name" name="menu[0][menuname]" value="<?php echo (isset($menu_details) && !empty($menu_details) && count($menu_details) > 0 && isset($menu_details[0]) && !empty($menu_details[0]->name)) ? $menu_details[0]->name : '' ?>">
                                            </div>
                                        </div>                              
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <?php if (isset($menu_details) && !empty($menu_details) && count($menu_details) > 0 && isset($menu_details[0]) && !empty($menu_details[0]->attachment)) { ?>
                                                <img class="" style="max-width:100%" src="<?php echo $menu_details[0]->attachment ?>" alt=""/>
                                            <?php } else { ?>
                                                <img class="" style="max-width:100%" src="<?php echo get_template_directory_uri(); ?>/assets/images/<?= $_SESSION['lan']['dish_page']['img_prev']?>" alt=""/>
                                            <?php } ?>
                                        </div>
                                        <div class="col-md-10">
                                            <?php if (isset($menu_details) && !empty($menu_details) && count($menu_details) > 0 && isset($menu_details[0]) && !empty($menu_details[0]->attachment)) { ?>
                                                <input type="file" class="form-control imgInp" value="<?php echo $menu_details[0]->attachment ?>" name="menuimage">
                                            <?php } else { ?>
                                                <input type="file" class="form-control imgInp" name="menuimage[]">
                                            <?php } ?>
                                            <span><?= $_SESSION['lan']['dish_page']['note']?></span>
                                        </div>  
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label><?= $_SESSION['lan']['dish_page']['short_des']?></label>
                                            <textarea class="s_description" name="menu[0][description]"><?php echo (isset($menu_details) && !empty($menu_details) && count($menu_details) > 0 && isset($menu_details[0]) && !empty($menu_details[0]->description)) ? $menu_details[0]->description : '' ?></textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="price"><?= $_SESSION['lan']['dish_page']['price']?></label>
                                                <input type="text" class="form-control priceFiled" id="price" name="menu[0][prince]" value="<?php echo (isset($menu_details) && !empty($menu_details) && count($menu_details) > 0 && isset($menu_details[0]) && !empty($menu_details[0]->price)) ? $menu_details[0]->price : '' ?>" step="any">
                                            </div>
                                            <div class="form-group size-optional">
                                                <label for="size"><?= $_SESSION['lan']['dish_page']['size_optional']?></label>
                                                <span><?= $_SESSION['lan']['dish_page']['u_can_create']?></span>
                                                <table border="0" cellpadding="2" cellspacing="0">
                                                    <tr>
                                                        <th width="45">&nbsp;</th>
                                                        <th width="197"><?= $_SESSION['lan']['dish_page']['title_size']?></th>
                                                        <th width="150"><?= $_SESSION['lan']['dish_page']['price']?> </th>
                                                        <th width="45">&nbsp;</th>
                                                    </tr>
                                                    <?php
                                                    if (isset($menu_details) && !empty($menu_details) && count($menu_details) > 0 && isset($menu_details[0]) && !empty($menu_details[0]->options) && count($menu_details[0]->options) > 0) {
                                                        $optcount = 0;
                                                        foreach ($menu_details[0]->options as $options) {
                                                            ?>
                                                            <input type="hidden" name="menu[0][option][<?php echo $optcount ?>][id]" value="<?php echo $options->id ?>"/>
                                                            <tr>
                                                                <td><img src="<?php echo get_template_directory_uri(); ?>/assets/images/list-icon.png" /></td>
                                                                <td><input type="text" class="s_title" name="menu[0][option][<?php echo $optcount ?>][title]" value="<?php echo $options->size_title ?>"></td>
                                                                <td><input type="text" class="s_price" name="menu[0][option][<?php echo $optcount ?>][price]" value="<?php echo ($options->size_title != '') ? $options->price : '' ?>" step="any"></td>
                                                                <td><a href="javascript:void(0)" class="remove removerows">x</a></td>
                                                            </tr>
                                                            <?php
                                                            $optcount++;
                                                        }
                                                    } else {
                                                        ?>
                                                        <tr>
                                                            <td><img src="<?php echo get_template_directory_uri(); ?>/assets/images/list-icon.png" /></td>
                                                            <td><input type="text" class="s_title" name="menu[0][option][0][title]"></td>
                                                            <td><input type="text" class="s_price" name="menu[0][option][0][price]" step="any"></td>
                                                            <td><a href="javascript:void(0)" class="remove removerows">x</a></td>
                                                        </tr>
                                                    <?php } ?>
                                                </table>
                                                <button type="button" class="add_another addrows" formno="0"><?= $_SESSION['lan']['dish_page']['add_another']?></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="alerIcon">
                                                <label><?= $_SESSION['lan']['dish_page']['allergen']?></label>
                                                <?php
                                                $listIcon = $menu_details[0]->icon_list;
                                                $listIcon = explode(',', $listIcon);
                                                foreach ($iconList as $list) {
                                                    $title = $list['title'];
                                                    $src = $list['src'];
                                                    $scrTitle = $src . "~" . $title;
                                                    // $title=$title[$i++];
                                                    if (in_array($scrTitle, $listIcon)) {
                                                        echo "<img src='$src' title='$title'><input type='checkbox' name='menu[0][alergen][]' checked  value='$scrTitle'>";
                                                    } else {
                                                        echo "<img src='$src' title='$title'><input type='checkbox' name='menu[0][alergen][]' value='$scrTitle'>";
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input name="submit" type="submit" value="<?= $_SESSION['lan']['dish_page']['sub_dish']?>" id="submitdish" />
                        </form>
                    </div>
                </div>          
            </div>          
        </div>      
    </div>
</section>
<script>
    $(document).ready(function () {
        var i = 1;
        $('#addmenu').click(function () {
            $('#mydishform').prepend(makehtml(i));
            i++;
            formaddedalert();
        });
        var j = <?php echo (isset($menu_details) && !empty($menu_details) && count($menu_details) > 0 && isset($menu_details[0]) && !empty($menu_details[0]->options) && count($menu_details[0]->options) > 0) ? count($menu_details[0]->options) + 1 : 1 ?>;
        $('body').on('click', '.addrows', function () {
            $(this).parent('div').children('table').children('tbody').append(rowhtml(j, $(this).attr('formno')));
            j++;
        });
        $('body').on('click', '.removerows', function () {
            $(this).parent('td').parent('tr').remove();
        });
        function makehtml(i) {
            var htmlstr = '<div class="wrapped wrappedinner">';
            htmlstr += '<div class="row">';
            htmlstr += '<div class="col-md-12"><a href="javascript:void(0)" class="close-thisform pull-right" style="text-decoration: none"><strong>&times;</strong></a></div>';
            htmlstr += '<div class="col-md-6">';
            htmlstr += '<div class="form-group">';
            htmlstr += '<label for="category"><?= $_SESSION['lan']['dish_page']['category']?>*</label>';
            htmlstr += '<select name="menu[' + i + '][categorytype]" class="themenuoption">';
<?php if (count($menu_categories) > 0) { ?>
                htmlstr += '<option><?= $_SESSION['lan']['dish_page']['select_cat']?></option>';
    <?php foreach ($menu_categories as $menu_category) { ?>
                    htmlstr += '<option value = "<?php echo $menu_category->id; ?>" ><?php echo ucfirst($menu_category->menu_name); ?> </option>';
    <?php } ?>
<?php } else { ?>
                htmlstr += '<option><?= $_SESSION['lan']['dish_page']['no_option_avila']?></option>';
<?php } ?>
            htmlstr += '</select>';
            htmlstr += '</div>';
            htmlstr += '</div>';
            htmlstr += '<div class="col-md-6">';
            htmlstr += '<div class="form-group">';
            htmlstr += '<label for="name"><?= $_SESSION['lan']['dish_page']['dish_name']?>*</label>';
            htmlstr += '<input type="text" class="form-control dish_name" id="name" name="menu[' + i + '][menuname]">';
            htmlstr += '</div>';
            htmlstr += '</div>';
            htmlstr += '</div>';
           htmlstr += '<div class="row">';

            htmlstr += '<div class="col-md-2">';
            htmlstr += '<img class="" style="max-width:100%" src="http://cmsbox.in/wordpress/foodyT/wp-content/themes/foodyT/assets/images/no-image-available-es.png" alt="">';
            htmlstr += '</div>';
            htmlstr += '<div class="col-md-10">';
            htmlstr += '<input type="file" class="form-control imgInp" name="menuimage[]">';
            htmlstr += '<span><?= $_SESSION['lan']['dish_page']['note']?></span>';
            htmlstr += '</div>';
            htmlstr += '</div>';
            htmlstr += '<div class="row">';
            htmlstr += '<div class="col-md-6">';
            htmlstr += '<label><?= $_SESSION['lan']['dish_page']['short_des']?>*</label>';
            htmlstr += '<textarea class="s_description" name="menu[' + i + '][description]"></textarea>';
            htmlstr += '</div>';
            htmlstr += '<div class="col-md-6">';
            htmlstr += '<div class="form-group">';
            htmlstr += '<label for="price"><?= $_SESSION['lan']['dish_page']['price']?></label>';
            htmlstr += '<input type="text" class="form-control priceFiled" id="price" name="menu[' + i + '][prince]" step="any">';
            htmlstr += '</div>';
            htmlstr += '<div class="form-group size-optional">';
            htmlstr += '<label for="size"><?= $_SESSION['lan']['dish_page']['size_optional']?></label>';
            htmlstr += '<span><?= $_SESSION['lan']['dish_page']['u_can_create']?>.</span>';
            htmlstr += '<table border="0" cellpadding="0" cellspacing="0">';
            htmlstr += '<tr>';
            htmlstr += '<th width="45">&nbsp;</th>';
            htmlstr += '<th width="197"><?= $_SESSION['lan']['dish_page']['title_size']?></th>';
            htmlstr += '<th width="150"><?= $_SESSION['lan']['dish_page']['price']?></th>';
            htmlstr += '<th width="45">&nbsp;</th>';
            htmlstr += '</tr>';
            htmlstr += '<tr>';
            htmlstr += '<td><img src="<?php echo get_template_directory_uri(); ?>/assets/images/list-icon.png" /></td>';
            htmlstr += '<td><input type="text" class="s_title" name="menu[' + i + '][option][0][title]"></td>';
            htmlstr += '<td><input type="text" class="s_price" name="menu[' + i + '][option][0][price]" step="any"></td>';
            htmlstr += '<td><a href="javascript:void(0)" class="remove removerows">x</a></td>';
            htmlstr += '</tr>';
            htmlstr += '</table>';
            htmlstr += '<button type="button" class="add_another addrows" formno="' + i + '"><?= $_SESSION['lan']['dish_page']['add_another']?></button>';
            htmlstr += '</div>';
            htmlstr += '</div>';
            htmlstr += '</div>';
            htmlstr += '<div class="row">';
            htmlstr += '<div class="col-md-6">';
            htmlstr += '<div class="alerIcon"><label><?= $_SESSION['lan']['dish_page']['allergen']?></label>' + iconlisthtml(i, '<?php echo json_encode($iconList) ?>');
            htmlstr += '</div>';
            htmlstr += '</div>';
            htmlstr += '</div>';
            htmlstr += '</div>';
            return htmlstr;
        }

        function iconlisthtml(inc, myarray) {
            myarray = $.parseJSON(myarray);
            var thehtml = '';
            $.each(myarray, function (k, v) {

                thehtml += '<img src="' + v.src + '"><input type="checkbox" name="menu[' + inc + '][alergen][]" value="' + v.src + '~' + v.title + '">';
            });
            return thehtml;
        }

        function rowhtml(i, fn) {
            var htmlstr = '<tr>';
            htmlstr += '<td><img src="<?php echo get_template_directory_uri(); ?>/assets/images/list-icon.png" /></td>';
            htmlstr += '<td><input type="text" class="s_title" name="menu[' + fn + '][option][' + i + '][title]"></td>';
            htmlstr += '<td><input type="text" class="s_price" name="menu[' + fn + '][option][' + i + '][price]" step="any"></td>';
            htmlstr += '<td><a href="javascript:void(0)" class="remove removerows">x</a></td>';
            htmlstr += '</tr>';
            return htmlstr;
        }
        // AJAX call for autocomplete 
        $("#search-box").keyup(function () {
            if ($.trim($(this).val()) != '') {
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url() ?>/webservices/getmenucategories.php",
                    data: 'keyword=' + $(this).val(),
                    beforeSend: function () {
                        $("#search-box").css("background", "#FFF url(<?php echo get_template_directory_uri(); ?>/loaderIcon.gif) no-repeat 165px");
                    },
                    success: function (data) {
                        $("#suggesstion-box").show();
                        $("#suggesstion-box").html(data);
                        $("#search-box").css("background", "#FFF");
                    }
                });
            } else {
                $("#suggesstion-box").hide();
            }
        });
         $(".imgInp").change(function () {
            readURL(this, $(this).parent('div').parent('div').find('img'));
        });
        $('body').on('change','.imgInp',function () {
            readURL(this, $(this).parent('div').parent('div').find('img'));
        });
        $('.savecategory').click(function () {
            if ($.trim($('#category-input').val()) != '') {
                $.post('<?php echo site_url() ?>/manage-restaurant?action=savecategory', {category: $('#category-input').val()}, function () {
                }).done(function (id) {
                    selectCategoryMenu($('#category-input').val(), id);
                    alert("<?= $_SESSION['lan']['dish_page']['success']?>");
                }).fail(function () {
                    alert("error");
                }).always(function () {
//                    alert("finished");
                });
            }
        });
        $('body').on('click', '.close-thisform', function () {
            if (confirm('Are you sure to remove this form?')) {
                $(this).parent('div').parent('div').parent('div').remove();
            }
        });
    });

//To select country name
    function selectCategoryMenu(val, id) {
        $("#search-box").val(val);
        $("#suggesstion-box").hide();
        $('.themenuoption option').each(function () {
            if ($(this).val() == id)
                $(this).remove();
            if ($(this).text() == 'No option available')
                $(this).remove();
        });
        $('.themenuoption').append($('<option>', {
            value: id,
            text: val
        }));
        $.post("<?php echo site_url() ?>/webservices/addcategory.php", {category: val, user_id:<?php echo get_current_user_id(); ?>}, function () {

        })
    }

    function readURL(input, $this) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $this.attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    function formaddedalert() {
        var thehtml = '<div id="addformalert" class="alert alert-success" role="alert"><strong><?= $_SESSION['lan']['dish_page']['success']?>: </strong> <?= $_SESSION['lan']['dish_page']['dish_form_added']?>.</div>';
        $('.food_section').prepend(thehtml);
        $('#addformalert').fadeOut(4000, function () {
            $('#addformalert').remove();
        });
    }
</script>
<script>
<?php if (!isset($_GET['editmenu'])) { ?>
        function validationCheck() {
            if (validateinputSelect() && validateinputText() && validatefile() /*&& validateTextArea()*/ && validateinputMainPrice()) {
                if (validateinputTitlePricedddk())
                    return true;
                else
                    return false;
            } else {
                return false;
            }
        }
<?php } else { ?>
        function validationCheck() {
            if (validateinputSelect() && validateinputText() /*&& validateTextArea()*/ && validateinputMainPrice()) {
                if (validateinputTitlePricedddk())
                    return true;
                else
                    return false;
            } else {
                return false;
            }
        }

<?php } ?>
    function validateinputText() {
        var returnme = true;
        var settoOBJ = '';
        $('#dishform .dish_name').each(function () {
            if (!$(this).hasClass('s_title')) {
                $(this).css('border-color', '#c7c7c7');
                if ($.trim($(this).val()) == '') {
                    $(this).css('border-color', 'red');
                    returnme = false;
                    settoOBJ = (settoOBJ == '') ? $(this) : settoOBJ;
                }
            }
        });
        if (settoOBJ != '')
            $('html, body').animate({
                scrollTop: settoOBJ.offset().top - 150
            }, 200);
        return returnme;
    }
<?php if (!isset($_GET['editmenu'])) { ?>
        function validatefile() {
            var returnme = true;
            var settoOBJ = '';
            $('#dishform .dish_name').each(function () {
                $(this).parent('div').children('span').eq(1).remove();
                if ($.trim($(this).val()) == '') {
                    $(this).parent('div').append('<span class="alert alert-danger"><?= $_SESSION['lan']['dish_page']['img_req']?></span>');
                    returnme = false;
                    settoOBJ = (settoOBJ == '') ? $(this) : settoOBJ;
                }
            });
            if (settoOBJ != '')
                $('html, body').animate({
                    scrollTop: settoOBJ.offset().top - 150
                }, 200);
            return returnme;
        }
<?php } ?>
    function validateTextArea() {
        var returnme = true;
        var settoOBJ = '';
        $('#dishform textarea').each(function () {
            $(this).css('border-color', '#c7c7c7');
            if ($.trim($(this).val()) == '') {
                $(this).css('border-color', 'red');
                returnme = false;
                settoOBJ = (settoOBJ == '') ? $(this) : settoOBJ;
            }
        });
        if (settoOBJ != '')
            $('html, body').animate({
                scrollTop: settoOBJ.offset().top - 150
            }, 200);
        return returnme;
    }
    function validateinputSelect() {
        var returnme = true;
        var settoOBJ = '';
        $('#dishform select').each(function () {
            $(this).css('border-color', '#c7c7c7');

            if ($.trim($(this).val()) == '') {
                $(this).css('border-color', 'red');
                returnme = false;
                settoOBJ = (settoOBJ == '') ? $(this) : settoOBJ;
            }
        });
        if (settoOBJ != '')
            $('html, body').animate({
                scrollTop: settoOBJ.offset().top - 150
            }, 200);
        return returnme;
    }
    function validateinputTitlePrice() {
        var returnme = true;
        var settoOBJ = '';
        $('.s_title').each(function () {
            $(this).css('border-color', '#c7c7c7');
            $(this).parent('td').next('td').children('input').css('border-color', '#c7c7c7');
            if ($.trim($(this).val()) == '') {
                $(this).css('border-color', 'red');
                returnme = false;
                settoOBJ = (settoOBJ == '') ? $(this) : settoOBJ;
            }
            if ($.trim($(this).parent('td').next('td').children('input').val()) == '') {
                $(this).parent('td').next('td').children('input').css('border-color', 'red');
                returnme = false;
                settoOBJ = (settoOBJ == '') ? $(this) : settoOBJ;
            }
        });
        if (settoOBJ != '')
            $('html, body').animate({
                scrollTop: settoOBJ.offset().top - 150
            }, 200);
        return returnme;
    }
    function validateinputMainPrice() {
        var returnme = true;
        var settoOBJ = '';
        $('#dishform .priceFiled').each(function () {
            if (!$(this).hasClass('s_price')) {
                $(this).css('border-color', '#c7c7c7');
                if ($.trim($(this).val()) == '' && !validateinputTitlePriced()) {
                    $(this).css('border-color', 'red');
                    returnme = false;
                    settoOBJ = (settoOBJ == '') ? $(this) : settoOBJ;
                } else if ($.trim($(this).val()) == '' && !validateinputTitlePriceddd()) {
                    $(this).css('border-color', '#c7c7c7');
                    returnme = false;
                    settoOBJ = (settoOBJ == '') ? $(this) : settoOBJ;
                }
            }
        });
        if (!returnme && validateinputTitlePriced()) {
            returnme = validateinputTitlePrice();
        } else {
            if (settoOBJ != '')
                $('html, body').animate({
                    scrollTop: settoOBJ.offset().top - 100
                }, 200);
        }
        return returnme;
    }

    function validateinputTitlePriced() {
        var returnme = false;
        $('.s_title').each(function () {
            if ($.trim($(this).val()) != '') {
                returnme = true;
            }
            if ($.trim($(this).parent('td').next('td').children('input').val()) != '' && returnme) {
                returnme = true;
            }
        });
        return returnme;
    }
    function validateinputTitlePriceddd() {
        var returnme = true;
        $('.s_title').each(function () {
            if ($.trim($(this).parent('td').next('td').children('input').val()) == '' && $.trim($(this).val()) != '') {
                returnme = false;
            }
        });
        return returnme;
    }
    function validateinputTitlePricedddk() {
        var returnme = true;
        var settoOBJ = '';
        $('.s_title').each(function () {
            var mainprice = $(this).parent('td').parent('tr').parent('tbody').parent('table').parent('div').prev('div').children('input').val();
            $(this).parent('td').next('td').children('input').css('border-color', '#c7c7c7');
            $(this).css('border-color', '#c7c7c7');
            if ($.trim($(this).parent('td').next('td').children('input').val()) == '' && $.trim($(this).val()) != '' && ($.trim(mainprice) != '' || $.trim(mainprice) == '')) {
                returnme = false;
                $(this).parent('td').next('td').children('input').css('border-color', 'red');
                settoOBJ = (settoOBJ == '') ? $(this).parent('td').next('td').children('input') : settoOBJ;
            } else if ($.trim($(this).parent('td').next('td').children('input').val()) != '' && $.trim($(this).val()) == '' && ($.trim(mainprice) != '' || $.trim(mainprice) == '')) {
                returnme = false;
                $(this).css('border-color', 'red');
                settoOBJ = (settoOBJ == '') ? $(this) : settoOBJ;
            }
        });
        if (settoOBJ != '')
            $('html, body').animate({
                scrollTop: settoOBJ.offset().top - 100
            }, 200);
        return returnme;
    }
</script>
<?php if (is_user_logged_in()) { ?>
    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?= $_SESSION['lan']['dish_page']['add_category']?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="category-input"><?= $_SESSION['lan']['dish_page']['category']?>:</label>
                        <input type="text" class="form-control" id="category-input">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default savecategory" data-dismiss="modal"><?= $_SESSION['lan']['dish_page']['saveandclose']?></button>
                </div>
            </div>

        </div>
    </div>
<?php } ?>
<?php get_footer();
?>
