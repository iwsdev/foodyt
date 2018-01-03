<?php
/*
  Template Name:Manage Restaurant page
 */
session_start();
get_header();
global $wpdb;
$menu_details_table = $wpdb->prefix."menu_details";
$restaurant_info_table = $wpdb->prefix."restaurant_infos";
$menu_detail_table = $wpdb->prefix."menu_details";

if (isset($_REQUEST['menuid']) && $_REQUEST['menuid'] != '' && isset($_REQUEST['action']) && $_REQUEST['action'] === 'delete') {
    $wpdb->delete($menu_details_table, array('id' => $_REQUEST['menuid']), array('%d'));
    exit;
}
?>
<style>
    .controls {margin-top:15px;}
    .controls a{
        padding:5px 7px;
        border:1px solid #c2c2c2    ;
        margin:2px;
        color:black;
        text-decoration:none; 
        cursor:pointer;
    }
    .controls a:hover, .controls a.active{
        background:#f39500;
        color:#fff !important;
    }
	.tab-pane{padding:25px 0}
</style>
<section id="my-account" class="manageResturant">
    <div class="container">
        <?php include 'usernotification.php'; ?>
        <div class="row">
            <div class="col-md-3 col-sm-4 col-xs-12 account-menu">
         <h3><?= $_SESSION['lan']['my_account']?></h3>
		 
		 <div class="serach-ham">Filter :  <a class="toggleSearch1" href="#" style="display: inline-block;"><span></span> <span></span> <span></span></a></div>
		 
		 
          <?php
          if($_SESSION['lanCode']=='' || $_SESSION['lanCode']=='es'){  wp_nav_menu(array('theme_location'=>'sidebar-menu'));}
          else{
              wp_nav_menu(array('theme_location'=>'sidebar-menu-english'));
          }
          ?>
            </div>
            <div class="col-md-9 col-sm-8 col-xs-12 account-details">
                <?php
                if (isset($_SESSION['formerror']) && $_SESSION['formerror']) {
                    ?>
                    <div class="alert alert-danger" role="alert">
                        <strong>Oh Error!</strong> <?php echo $_SESSION['formerrormsg'] ?>
                    </div>
                    <?php
                    unset($_SESSION['formerror']);
                    unset($_SESSION['formerrormsg']);
                }
                ?>
                <?php
                if (isset($_SESSION['formsuccess']) && $_SESSION['formsuccess']) {
                    ?>
                    <div class="alert alert-success" role="alert">
                        <strong>Success: </strong> <?php echo $_SESSION['formerrormsg'] ?>
                    </div>
                    <?php
                    unset($_SESSION['formsuccess']);
                    unset($_SESSION['formerrormsg']);
                }
                ?>
                <?php
						$user = wp_get_current_user();
						$userId = $user->id;
						$resultPageId = $wpdb->get_row("SELECT page_id,user_id,language FROM $restaurant_info_table WHERE user_id = $userId");
					    $pageId = $resultPageId->page_id;
						$lang = $resultPageId->language;
						$language = explode(",",$lang);
						?>
                <h3><?= $_SESSION['lan']['manage_res_menu']?></h3>
				<a target="_blank" href="<?php echo get_the_permalink($pageId);?>" class="preview-dish"> <?= $_SESSION['lan']['preview']?></a>
                <a href="<?php echo get_site_url() . '/manage-restaurant'; ?>" class="add-dish" style="text-decoration: none">  <?= $_SESSION['lan']['add_dish']?></a>
				<div class="flag-icons-switcher">
					<div id="exTab2" class="container">	
						<?php
						$user = wp_get_current_user();
						$userId = $user->id;
						$resultPageId = $wpdb->get_row("SELECT page_id,user_id,language FROM $restaurant_info_table WHERE user_id = $userId");
						$lang = $resultPageId->language;
						$language = explode(",",$lang);
						?>
						<ul class="nav nav-tabs">
							<?php
							foreach ($language as $lang) {
								if ($lang == 'Spanish') { ?>
									<li class="active"><a href='#1' data-toggle="tab"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/espanol-flag.jpg" alt="Spanish"/> <span> <?= $_SESSION['lan']['languageList'][0]?></span></a></li>
								<?php } ?>
								<?php if ($lang == 'English') { ?>
									<li><a href='#2' data-toggle="tab"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/english-flag.jpg" alt="English"/> <span><?= $_SESSION['lan']['languageList'][1]?></span></a></li>
								<?php } ?>
								<?php if ($lang == 'French') { ?>
									<li><a href='#3' data-toggle="tab"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/french-flag.jpg" alt="French"/> <span><?= $_SESSION['lan']['languageList'][2]?></span></a></li>
								<?php } ?>
								<?php if ($lang == 'Italian') { ?>
									<li><a href='#4' data-toggle="tab"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/italian-flag.jpg" alt="Italian"/> <span><?= $_SESSION['lan']['languageList'][3]?></span></a></li>
								<?php } ?>
								<?php if ($lang == 'japanese') { ?>
									<li><a href='#5' data-toggle="tab"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/japanese-flag.jpg" alt="Japanese"/> <span><?= $_SESSION['lan']['languageList'][4]?></span></a></li>
								<?php } ?>
							<?php } ?>
						</ul>
						
						<div class="tab-content ">
						<div class="tab-pane active" id="1">
							<div class="menu" id="controlllist">
								<ul class="easyPaginate" id="list">
									<?php
									$query = "SELECT * FROM $menu_detail_table WHERE language ='es' && entry_by=" . get_current_user_id();
									$menuArr = $wpdb->get_results($query);
									?>
									<?php if (count($menuArr) > 0) { ?>
										<?php
										foreach ($menuArr as $menu) {
											$status = getMenuStatus($wpdb, $menu->status);
											?>
											<li>
												<figure><img src="<?php echo $menu->attachment ?>" alt="" /></figure>
												<div class="description">
													<div class="title">
														<h4><?php 
															if($status=='In Review')
															$st = $_SESSION['lan']['review'];
														elseif ($status=='Approved')
															$st = $_SESSION['lan']['approve'];
														elseif ($status=='Rejected')
															$st = $_SESSION['lan']['reject'];
														
														/*Langaue convert for title from api start*/
														$title = $menu->name;
                                                                                                                
                                                                                                                
                                                                                                                
                                                                                                                
                                                                                                                
														/* $qtitle = str_replace(" ","%20",$title);
														$url = "https://www.googleapis.com/language/translate/v2?key=AIzaSyAFadHLoo1Yc6Yvx4ewreqFPdljlkJI8Hk&target=es&q=".$qtitle;
														$curl = curl_init();
														curl_setopt($curl, CURLOPT_URL, $url);
														curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
														$result = curl_exec($curl);
														curl_close($curl);
														$json = json_decode($result, true);
														$title =  $json[data][translations][0][translatedText]; */
                                                                                                                
                                                                                                                $description = $menu->description;
                                                                                                                
                                                                                                                /* $qdes = str_replace(" ","%20",$des);
                                                                                                                $url = "https://www.googleapis.com/language/translate/v2?key=AIzaSyAFadHLoo1Yc6Yvx4ewreqFPdljlkJI8Hk&target=es&q=".$qdes;
                                                                                                                $curl = curl_init();
                                                                                                                curl_setopt($curl, CURLOPT_URL, $url);
                                                                                                                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                                                                                                                $result = curl_exec($curl);
                                                                                                                curl_close($curl);
                                                                                                                $json = json_decode($result, true);
                                                                                                                //echo "<pre>";print_r($json);die();
                                                                                                                $description =  $json[data][translations][0][translatedText]; */
                                                                                                                
                                                                                                                
                                                                                                              /*   $wpdb->update( 
													$menu_detail_table, 
													array( 
														'name' => $title,	// string
														'description' => $description	// integer (number) 
													), 
													array( 'id' => $menu->id), 
													array( 
														'%s',	// value1
														'%s'	// value2
													), 
													array( '%d' ) 
													);  */
                                                                                                                
                                                                                                                
														/*Langaue convert from api end*/ 
														echo $title;
														//echo $menu->name;
														?> 
														<span class="in-review">(<?php echo $st ?>)</span></h4>
														<div class="btn">
															<a href="<?php echo esc_url(add_query_arg('editmenu', $menu->id, site_url() . '/manage-restaurant')); ?>" class="edit"><?= $_SESSION['lan']['edit']?> </a>
															<a href="javascript:void(0)" class="del deletemenu" menuid="<?php echo $menu->id ?>"><?= $_SESSION['lan']['remove']?> </a>
														</div>
													</div>
													<p><?php 
													/*Langaue convert for description from api start*/
													
													
													/*Langaue convert from api end*/
													//echo $description;
													/*Update language in db start*/
                                                                                                        
													 
													/*Update language in db end*/
													echo $description;?></p>
													<div class="iconss">
														<?php
														if ($menu->icon_list != '') {
															$iconList = $menu->icon_list;
															$list = explode(',', $iconList);
															foreach ($list as $iconTitle) {
																$iconTitle = explode('~', $iconTitle);
																$icon = $iconTitle[0];
																$title = $iconTitle[1];
																echo "<figure><img src='$icon' title='$title'></figure>";
															}
														}
														?>
													</div>
												</div>
											</li>
										<?php } ?>
										<?php
									} else { ?>
										<div class='description'><?= $_SESSION['lan']['not_add_menu']?>..</div>
									<?php }
									?>
									</ul>
									<div class="controls pull-right" id="list-pagination" style="display:none">
										<a id="list-previous" href="#"><?= $_SESSION['lan']['prev']?></a> 
										<a id="list-next" href="#"><?= $_SESSION['lan']['next']?></a> 
									</div>
								</div>	
							</div>
							<div class="tab-pane" id="2">
								<div class="menu" id="encontrolllist">
								<ul class="eneasyPaginate" id="enlist">
									<?php
									$query = "SELECT * FROM $menu_detail_table WHERE language ='en' && entry_by=" . get_current_user_id();
									$menuArr = $wpdb->get_results($query);
									?>
									<?php if (count($menuArr) > 0) { ?>
										<?php
										foreach ($menuArr as $menu) {
											$status = getMenuStatus($wpdb, $menu->status);
											?>
											<li>
												<figure><img src="<?php echo $menu->attachment ?>" alt="" /></figure>
												<div class="description">
													<div class="title">
														<h4><?php 
															if($status=='In Review')
															$st = $_SESSION['lan']['review'];
														elseif ($status=='Approved')
															$st = $_SESSION['lan']['approve'];
														elseif ($status=='Rejected')
															$st = $_SESSION['lan']['reject'];
														/*Langaue convert for title from api start*/
														$title = $menu->name;
														/*$qtitle = str_replace(" ","%20",$title);
														$url = "https://www.googleapis.com/language/translate/v2?key=AIzaSyAFadHLoo1Yc6Yvx4ewreqFPdljlkJI8Hk&target=en&q=".$qtitle;
														$curl = curl_init();
														curl_setopt($curl, CURLOPT_URL, $url);
														curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
														$result = curl_exec($curl);
														curl_close($curl);
														$json = json_decode($result, true);
														$title =  $json[data][translations][0][translatedText]; */
														/*Langaue convert from api end*/
														echo $title;
														//echo $menu->name ?> 
														<span class="in-review">(<?php echo $st ?>)</span></h4>
														<div class="btn">
															<a href="<?php echo esc_url(add_query_arg('editmenu', $menu->id, site_url() . '/manage-restaurant')); ?>" class="edit"><?= $_SESSION['lan']['edit']?></a>
															<a href="javascript:void(0)" class="del deletemenu" menuid="<?php echo $menu->id ?>"><?= $_SESSION['lan']['remove']?></a>
														</div>
													</div>
													<p><?php 
													/*Langaue convert for description from api start*/
													$description = $menu->description;
													/* $qdes = str_replace(" ","%20",$des);
													$url = "https://www.googleapis.com/language/translate/v2?key=AIzaSyAFadHLoo1Yc6Yvx4ewreqFPdljlkJI8Hk&target=en&q=".$qdes;
													$curl = curl_init();
													curl_setopt($curl, CURLOPT_URL, $url);
													curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
													$result = curl_exec($curl);
													curl_close($curl);
													$json = json_decode($result, true);
													//echo "<pre>";print_r($json);die();
													$description =  $json[data][translations][0][translatedText]; */
													/*Langaue convert from api end*/ 
													echo $description;
													/*Update language in db start*/
													/* $wpdb->update( 
													$menu_detail_table, 
													array( 
														'name' => $title,	// string
														'description' => $description	// integer (number) 
													), 
													array( 'id' => $menu->id), 
													array( 
														'%s',	// value1
														'%s'	// value2
													), 
													array( '%d' ) 
													); */
													/*Update language in db end*/
													//echo $menu->description ?></p>
													<div class="iconss">
														<?php
														if ($menu->icon_list != '') {
															$iconList = $menu->icon_list;
															$list = explode(',', $iconList);
															foreach ($list as $iconTitle) {
																$iconTitle = explode('~', $iconTitle);
																$icon = $iconTitle[0];
																$title = $iconTitle[1];
																echo "<figure><img src='$icon' title='$title'></figure>";
															}
														}
														?>
													</div>
												</div>
											</li>
										<?php } ?>
										<?php
									} else { ?>
										<div class='description'><?= $_SESSION['lan']['not_add_menu']?>..</div>
									<?php }
									?>
									</ul>
									<div class="controls pull-right" id="enlist-pagination" style="display:none">
										<a id="enlist-previous" href="#"><?= $_SESSION['lan']['prev']?></a> 
										<a id="enlist-next" href="#"><?= $_SESSION['lan']['next']?></a> 
									</div>
								</div>	
							</div>
							<div class="tab-pane" id="3">
								<div class="menu" id="frcontrolllist">
								<ul class="easyPaginate" id="frlist">
								<?php
								$query = "SELECT * FROM $menu_detail_table WHERE language ='fr' && entry_by=" . get_current_user_id();
									$menuArr = $wpdb->get_results($query);
									?>
									<?php if (count($menuArr) > 0) { ?>
										<?php
										foreach ($menuArr as $menu) {
											$status = getMenuStatus($wpdb, $menu->status);
											?>
											<li>
												<figure><img src="<?php echo $menu->attachment ?>" alt="" /></figure>
												<div class="description">
													<div class="title">
													<h4><?php 
															if($status=='In Review')
															$st = $_SESSION['lan']['review'];
														elseif ($status=='Approved')
															$st = $_SESSION['lan']['approve'];
														elseif ($status=='Rejected')
															$st = $_SESSION['lan']['reject'];
														/*Langaue convert for title from api start*/
														$title = $menu->name;
														/* $qtitle = str_replace(" ","%20",$title);
														$url = "https://www.googleapis.com/language/translate/v2?key=AIzaSyAFadHLoo1Yc6Yvx4ewreqFPdljlkJI8Hk&target=fr&q=".$qtitle;
														$curl = curl_init();
														curl_setopt($curl, CURLOPT_URL, $url);
														curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
														$result = curl_exec($curl);
														curl_close($curl);
														$json = json_decode($result, true);
														$title =  $json[data][translations][0][translatedText]; */
														/*Langaue convert from api end*/
														echo $title;
														//echo $menu->name ?> 
														<span class="in-review">(<?php echo $st ?>)</span></h4>
														<div class="btn">
															<a href="<?php echo esc_url(add_query_arg('editmenu', $menu->id, site_url() . '/manage-restaurant')); ?>" class="edit"><?= $_SESSION['lan']['edit']?></a>
															<a href="javascript:void(0)" class="del deletemenu" menuid="<?php echo $menu->id ?>"><?= $_SESSION['lan']['remove']?></a>
														</div>
													</div>
													<p><?php 
													/*Langaue convert for description from api start*/
													$description = $menu->description;
													/* $qdes = str_replace(" ","%20",$des);
													$url = "https://www.googleapis.com/language/translate/v2?key=AIzaSyAFadHLoo1Yc6Yvx4ewreqFPdljlkJI8Hk&target=fr&q=".$qdes;
													$curl = curl_init();
													curl_setopt($curl, CURLOPT_URL, $url);
													curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
													$result = curl_exec($curl);
													curl_close($curl);
													$json = json_decode($result, true);
													//echo "<pre>";print_r($json);die();
													$description =  $json[data][translations][0][translatedText]; */
													/*Langaue convert from api end*/
													echo $description;
													/*Update language in db start*/
													/* $wpdb->update( 
													$menu_detail_table, 
													array( 
														'name' => $title,	// string
														'description' => $description	// integer (number) 
													), 
													array( 'id' => $menu->id), 
													array( 
														'%s',	// value1
														'%s'	// value2
													), 
													array( '%d' ) 
													); */
													/*Update language in db end*/
													//echo $menu->description ?></p>
													<div class="iconss">
														<?php
														if ($menu->icon_list != '') {
															$iconList = $menu->icon_list;
															$list = explode(',', $iconList);
															foreach ($list as $iconTitle) {
																$iconTitle = explode('~', $iconTitle);
																$icon = $iconTitle[0];
																$title = $iconTitle[1];
																echo "<figure><img src='$icon' title='$title'></figure>";
															}
														}
														?>
													</div>
												</div>
											</li>
										<?php } ?>
										<?php
									} else { ?>
										<div class='description'><?= $_SESSION['lan']['not_add_menu']?>..</div>
									<?php }
									?>
									</ul>
									<div class="controls pull-right" id="frlist-pagination" style="display:none">
										<a id="frlist-previous" href="#"><?= $_SESSION['lan']['prev']?></a> 
										<a id="frlist-next" href="#"><?= $_SESSION['lan']['next']?></a> 
									</div>
								</div>	
							</div>
							<div class="tab-pane" id="4">
								<div class="menu" id="itcontrolllist">
								<ul class="easyPaginate" id="itlist">
									<?php
									$query = "SELECT * FROM $menu_detail_table WHERE language ='it' && entry_by=" . get_current_user_id();
									$menuArr = $wpdb->get_results($query);
									?>
									<?php if (count($menuArr) > 0) { ?>
										<?php
										foreach ($menuArr as $menu) {
											$status = getMenuStatus($wpdb, $menu->status);
											?>
											<li>
												<figure><img src="<?php echo $menu->attachment ?>" alt="" /></figure>
												<div class="description">
													<div class="title">
														<h4><?php 
															if($status=='In Review')
															$st = $_SESSION['lan']['review'];
														elseif ($status=='Approved')
															$st = $_SESSION['lan']['approve'];
														elseif ($status=='Rejected')
															$st = $_SESSION['lan']['reject'];
														/*Langaue convert for title from api start*/
														$title = $menu->name;
														/* $qtitle = str_replace(" ","%20",$title);
														$url = "https://www.googleapis.com/language/translate/v2?key=AIzaSyAFadHLoo1Yc6Yvx4ewreqFPdljlkJI8Hk&target=it&q=".$qtitle;
														$curl = curl_init();
														curl_setopt($curl, CURLOPT_URL, $url);
														curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
														$result = curl_exec($curl);
														curl_close($curl);
														$json = json_decode($result, true);
														$title =  $json[data][translations][0][translatedText]; */
														/*Langaue convert from api end*/
														echo $title;
														//echo $menu->name ?> 
														<span class="in-review">(<?php echo $st ?>)</span></h4>
														<div class="btn">
															<a href="<?php echo esc_url(add_query_arg('editmenu', $menu->id, site_url() . '/manage-restaurant')); ?>" class="edit"><?= $_SESSION['lan']['edit']?></a>
															<a href="javascript:void(0)" class="del deletemenu" menuid="<?php echo $menu->id ?>"><?= $_SESSION['lan']['remove']?></a>
														</div>
													</div>
													<p><?php 
													/*Langaue convert for description from api start*/
													$description = $menu->description;
													/* $qdes = str_replace(" ","%20",$des);
													$url = "https://www.googleapis.com/language/translate/v2?key=AIzaSyAFadHLoo1Yc6Yvx4ewreqFPdljlkJI8Hk&target=it&q=".$qdes;
													$curl = curl_init();
													curl_setopt($curl, CURLOPT_URL, $url);
													curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
													$result = curl_exec($curl);
													curl_close($curl);
													$json = json_decode($result, true);
													//echo "<pre>";print_r($json);die();
													$description =  $json[data][translations][0][translatedText]; */
													/*Langaue convert from api end*/
													echo $description;
													/*Update language in db start*/
													/* $wpdb->update( 
													$menu_detail_table, 
													array( 
														'name' => $title,	// string
														'description' => $description	// integer (number) 
													), 
													array( 'id' => $menu->id), 
													array( 
														'%s',	// value1
														'%s'	// value2
													), 
													array( '%d' ) 
													); */
													/*Update language in db end*/
													//echo $menu->description ?></p>
													<div class="iconss">
														<?php
														if ($menu->icon_list != '') {
															$iconList = $menu->icon_list;
															$list = explode(',', $iconList);
															foreach ($list as $iconTitle) {
																$iconTitle = explode('~', $iconTitle);
																$icon = $iconTitle[0];
																$title = $iconTitle[1];
																echo "<figure><img src='$icon' title='$title'></figure>";
															}
														}
														?>
													</div>
												</div>
											</li>
										<?php } ?>
										<?php
									} else { ?>
										<div class='description'><?= $_SESSION['lan']['not_add_menu']?>..</div>
									<?php }
									?>
									</ul>
									<div class="controls pull-right" id="itlist-pagination" style="display:none">
										<a id="itlist-previous" href="#"><?= $_SESSION['lan']['prev']?></a> 
										<a id="itlist-next" href="#"><?= $_SESSION['lan']['next']?></a> 
									</div>
								</div>	
							</div>
							<div class="tab-pane" id="5">
								<div class="menu" id="jacontrolllist">
								<ul class="easyPaginate" id="jalist">
									<?php
									$query = "SELECT * FROM $menu_detail_table WHERE language ='ja' && entry_by=" . get_current_user_id();
									$menuArr = $wpdb->get_results($query);
									?>
									<?php if (count($menuArr) > 0) { ?>
										<?php
										foreach ($menuArr as $menu) {
											$status = getMenuStatus($wpdb, $menu->status);
											?>
											<li>
												<figure><img src="<?php echo $menu->attachment ?>" alt="" /></figure>
												<div class="description">
													<div class="title">
														<h4><?php 
															if($status=='In Review')
															$st = $_SESSION['lan']['review'];
														elseif ($status=='Approved')
															$st = $_SESSION['lan']['approve'];
														elseif ($status=='Rejected')
															$st = $_SESSION['lan']['reject'];
														/*Langaue convert for title from api start*/
														$title = $menu->name;
														/* $qtitle = str_replace(" ","%20",$title);
														$url = "https://www.googleapis.com/language/translate/v2?key=AIzaSyAFadHLoo1Yc6Yvx4ewreqFPdljlkJI8Hk&target=ja&q=".$qtitle;
														$curl = curl_init();
														curl_setopt($curl, CURLOPT_URL, $url);
														curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
														$result = curl_exec($curl);
														curl_close($curl);
														$json = json_decode($result, true);
														$title =  $json[data][translations][0][translatedText]; */
														/*Langaue convert from api end*/
														echo $title;
														//echo $menu->name ?> 
														<span class="in-review">(<?php echo $st ?>)</span></h4>
														<div class="btn">
															<a href="<?php echo esc_url(add_query_arg('editmenu', $menu->id, site_url() . '/manage-restaurant')); ?>" class="edit"><?= $_SESSION['lan']['edit']?></a>
															<a href="javascript:void(0)" class="del deletemenu" menuid="<?php echo $menu->id ?>"><?= $_SESSION['lan']['remove']?></a>
														</div>
													</div>
													<p><?php 
													/*Langaue convert for description from api start*/
													$description = $menu->description;
													/* $qdes = str_replace(" ","%20",$des);
													$url = "https://www.googleapis.com/language/translate/v2?key=AIzaSyAFadHLoo1Yc6Yvx4ewreqFPdljlkJI8Hk&target=ja&q=".$qdes;
													$curl = curl_init();
													curl_setopt($curl, CURLOPT_URL, $url);
													curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
													$result = curl_exec($curl);
													curl_close($curl);
													$json = json_decode($result, true);
													//echo "<pre>";print_r($json);die();
													$description =  $json[data][translations][0][translatedText]; */
													/*Langaue convert from api end*/
													echo $description;
													/*Update language in db start*/
													/* $wpdb->update( 
													$menu_detail_table, 
													array( 
														'name' => $title,	// string
														'description' => $description	// integer (number) 
													), 
													array( 'id' => $menu->id), 
													array( 
														'%s',	// value1
														'%s'	// value2
													), 
													array( '%d' ) 
													); */
													/*Update language in db end*/
													//echo $menu->description ?></p>
													<div class="iconss">
														<?php
														if ($menu->icon_list != '') {
															$iconList = $menu->icon_list;
															$list = explode(',', $iconList);
															foreach ($list as $iconTitle) {
																$iconTitle = explode('~', $iconTitle);
																$icon = $iconTitle[0];
																$title = $iconTitle[1];
																echo "<figure><img src='$icon' title='$title'></figure>";
															}
														}
														?>
													</div>
												</div>
											</li>
										<?php } ?>
										<?php
									} else { ?>
										<div class='description'><?= $_SESSION['lan']['not_add_menu']?>..</div>
									<?php }
									?>
									</ul>
									<div class="controls pull-right" id="jalist-pagination" style="display:none">
										<a id="jalist-previous" href="#"><?= $_SESSION['lan']['prev']?></a> 
										<a id="jalist-next" href="#"><?= $_SESSION['lan']['next']?></a> 
									</div>
								</div>	
							</div>
						</div>
					 </div>
					</div>
				<!--
                <div class="menu" id="controlllist">
                    <ul class="easyPaginate" id="list">
                        <?php /*if (count($menuArr) > 0) { ?>
                            <?php
                            foreach ($menuArr as $menu) {
                                $status = getMenuStatus($wpdb, $menu->status);
                                ?>
                                <li>
                                    <figure><img src="<?php echo $menu->attachment ?>" alt="" /></figure>
                                    <div class="description">
                                        <div class="title">
                                            <h4><?php echo $menu->name ?> <span class="in-review">(<?php echo $status ?>)</span></h4>
                                            <div class="btn">
                                                <a href="<?php echo esc_url(add_query_arg('editmenu', $menu->id, site_url() . '/manage-restaurant')); ?>" class="edit">Edit</a>
                                                <a href="javascript:void(0)" class="del deletemenu" menuid="<?php echo $menu->id ?>">Delete</a>
                                            </div>
                                        </div>
                                        <p><?php echo $menu->description ?></p>
                                        <div class="iconss">
                                            <?php
                                            if ($menu->icon_list != '') {
                                                $iconList = $menu->icon_list;
                                                $list = explode(',', $iconList);
                                                foreach ($list as $iconTitle) {
                                                    $iconTitle = explode('~', $iconTitle);
                                                    $icon = $iconTitle[0];
                                                    $title = $iconTitle[1];
                                                    echo "<figure><img src='$icon' title='$title'></figure>";
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>
                            <?php
                        } else {
                            echo "<div class='description'>You have not added any menu!..</div>";
                        }*/
                        ?>
                        <li>
                            <figure><img src="<?php //echo get_template_directory_uri(); ?>/assets/images/product.png" alt="" /></figure>
                            <div class="description">
                                <div class="title">
                                    <h4>OH Mexico! <span class="in-review">(In Review)</span></h4>
                                    <div class="btn">
                                        <a href="#" class="edit">Edit</a>
                                        <a href="#" class="del">Delete</a>
                                    </div>
                                </div>

                                <p>Av.San Francisco Javier 5,Sevilla Lorem ipsum dolor sit amet, consectetuer doloret adipiscing elit. Aenean commodo ligula eget dolor. </p>
                            </div>
                        </li>
                                                <li>
                                                    <figure><img src="<?php // echo get_template_directory_uri();                                                                                  ?>/assets/images/product.png" alt="" /></figure>
                                                    <div class="description">
                                                        <div class="title">
                                                            <h4>OH Mexico! <span class="approved">(approved)</span></h4>
                                                            <div class="btn">
                                                                <a href="#" class="edit">Edit</a>
                                                                <a href="#" class="del">Delete</a>
                                                            </div>
                                                        </div>
                        
                                                        <p>Av.San Francisco Javier 5,Sevilla Lorem ipsum dolor sit amet, consectetuer doloret adipiscing elit. Aenean commodo ligula eget dolor. </p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <figure><img src="<?php // echo get_template_directory_uri();                                                                                  ?>/assets/images/product.png" alt="" /></figure>
                                                    <div class="description">
                                                        <div class="title">
                                                            <h4>OH Mexico! <span class="rejected">(Rejected)</span></h4>
                                                            <div class="btn">
                                                                <a href="#" class="edit">Edit</a>
                                                                <a href="#" class="del">Delete</a>
                                                            </div>
                                                        </div>
                        
                                                        <p>Av.San Francisco Javier 5,Sevilla Lorem ipsum dolor sit amet, consectetuer doloret adipiscing elit. Aenean commodo ligula eget dolor. </p>
                                                    </div>
                                                </li>
                    </ul>-->
                    <script>
						//pagination for spanish tab
                        /*$(document).ready(function () {

                            var show_per_page = 1;
                            var number_of_items = $('#list').children('li').length;
                            var number_of_pages = Math.ceil(number_of_items / show_per_page);

                            $('#controlllist').append('<div class="controls pull-right"></div><input id=current_page type=hidden><input id=show_per_page type=hidden>');
                            $('#current_page').val(0);
                            $('#show_per_page').val(show_per_page);

                            var navigation_html = '<a class="prev" onclick="previous()">Prev</a>';
                            var current_link = 0;
                            while (number_of_pages > current_link) {
                                navigation_html += '<a class="page" onclick="go_to_page(' + current_link + ')" longdesc="' + current_link + '">' + (current_link + 1) + '</a>';
                                current_link++;
                            }
                            navigation_html += '<a class="next" onclick="next()">Next</a>';

                            $('.controls').html(navigation_html);
                            $('.controls .page:first').addClass('active');

                            $('#list').children().css('display', 'none');
                            $('#list').children().slice(0, show_per_page).css('display', 'block');

                        });



                        function go_to_page(page_num) {
                            var show_per_page = parseInt($('#show_per_page').val(), 0);

                            start_from = page_num * show_per_page;

                            end_on = start_from + show_per_page;

                            $('#list').children().css('display', 'none').slice(start_from, end_on).css('display', 'block');

                            $('.page[longdesc=' + page_num + ']').addClass('active').siblings('.active').removeClass('active');

                            $('#current_page').val(page_num);
                        }



                        function previous() {

                            new_page = parseInt($('#current_page').val(), 0) - 1;
                            //if there is an item before the current active link run the function
                            if ($('.active').prev('.page').length == true) {
                                go_to_page(new_page);
                            }

                        }

                        function next() {
                            new_page = parseInt($('#current_page').val(), 0) + 1;
                            //if there is an item after the current active link run the function
                            if ($('.active').next('.page').length == true) {
                                go_to_page(new_page);
                            }

                        }*/
                       	
                    </script>                		
            </div>			
        </div>		
    </div>
</section>
<!--</section>-->
<!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.3/jquery.min.js"></script>
 --><script type="text/javascript" src="<?php echo bloginfo('template_url'); ?>/js/jquery.paginate.js"></script>
<script type="text/javascript">
jQuery(document).ready(function()    {
	jQuery('#list').paginate({itemsPerPage: 5});
	jQuery('#enlist').paginate({itemsPerPage: 5});
	jQuery('#frlist').paginate({itemsPerPage: 5});
	jQuery('#itlist').paginate({itemsPerPage: 5});
	jQuery('#jalist').paginate({itemsPerPage: 5});
	jQuery.getJSON('data.json', function(data) {
		var items = [];
		jQuery.each(data.items, function(i, item) {
			items.push('<li>' + item + '</li>');
		});
	});
});
</script>
<script>
    $(document).ready(function () {
        $('.deletemenu').click(function () {
            var $this = $(this);
            if (confirm('Are you sure to delete menu?')) {
                $.ajax({
                    url: "<?php echo site_url() . '/manage-restaurant-menu' ?>",
                    type: "get", //send it through get method
                    data: {
                        menuid: $this.attr('menuid'),
                        action: 'delete'
                    },
                    success: function (response) {
                        location.reload();
                    },
                    error: function (xhr) {
                        //Do Something to handle error
                    }
                });
            }
        });
    });
</script>
<?php
get_footer();
?>
