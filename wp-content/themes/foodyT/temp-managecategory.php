<?php
/*
  Template Name:Manage Restaurant Category
 */
session_start();
get_header();
global $wpdb;

$restaurant_info_table = $wpdb->prefix."restaurant_infos";
$menu_detail_table = $wpdb->prefix."menu_categories";

if (isset($_REQUEST['menuid']) && $_REQUEST['menuid'] != '' && isset($_REQUEST['action']) && $_REQUEST['action'] === 'delete')
  {
    $wpdb->delete($menu_detail_table, array('parentcatid' => $_REQUEST['menuid']), array('%d'));
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
                <h3><?= $_SESSION['lan']['manage_cat_menu']?></h3>
				
                <a href="<?php echo get_site_url() . '/manage-categories/'; ?>" class="add-dish" style="text-decoration: none">  <?= $_SESSION['lan']['dish_page']['add_category']?></a>
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

								<ul class="easyPaginate myList" id="list">
									<?php
									$query = "SELECT * FROM $menu_detail_table WHERE language ='es' && entry_by=" . get_current_user_id()." ORDER BY cat_order";
									$menuArr = $wpdb->get_results($query);
									?>
									<?php if (count($menuArr) > 0) { ?>
										<?php
										foreach ($menuArr as $menu) {
											//$status = getMenuStatus($wpdb, $menu->status);
											?>
											<li id="<?= $menu->id?>">
												
												<div class="description fullwidth">
													<div class="title">
														<h4><?php echo stripslashes($menu->menu_name) ?></h4>
														<div class="btn">
															<a href="<?php echo esc_url(add_query_arg(array('editmenu'=>$menu->parentcatid,'languageid'=>'es'), site_url() . '/manage-categories')); ?>" class="edit"><?= $_SESSION['lan']['edit']?> </a>
															<a href="javascript:void(0)" class="del deletemenu" menuid="<?php echo $menu->parentcatid ?>"><?= $_SESSION['lan']['remove']?> </a>
														</div>
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
								<ul class="eneasyPaginate myListEn" id="enlist">
									<?php
									$query = "SELECT * FROM $menu_detail_table WHERE language ='en' && entry_by=" . get_current_user_id()." ORDER BY cat_order";
									$menuArr = $wpdb->get_results($query);
									?>
									<?php if (count($menuArr) > 0) { ?>
										<?php
										foreach ($menuArr as $menu) {
											
											?>
											<li id="<?= $menu->id?>">
												
												<div class="description fullwidth">
													<div class="title">
														<h4><?php echo stripslashes($menu->menu_name) ?></h4>
														<div class="btn">
															<a href="<?php echo esc_url(add_query_arg(array('editmenu'=>$menu->parentcatid,'languageid'=>'en'), site_url() . '/manage-categories')); ?>" class="edit"><?= $_SESSION['lan']['edit']?> </a>
															<a href="javascript:void(0)" class="del deletemenu" menuid="<?php echo $menu->parentcatid ?>"><?= $_SESSION['lan']['remove']?> </a>
														</div>
													</div>
									
													
												</div>
											</li>
										<?php } ?>
										<?php
									} else { ?>
										<div class='description'><?= $_SESSION['lan']['not_add_menu']?>..</div>;
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
								<ul class="easyPaginate myListFr" id="frlist">
								<?php
								$query = "SELECT * FROM $menu_detail_table WHERE language ='fr' && entry_by=" . get_current_user_id()." ORDER BY cat_order";
									$menuArr = $wpdb->get_results($query);
									?>
									<?php if (count($menuArr) > 0) { ?>
										<?php
										foreach ($menuArr as $menu) {
											
											?>
											<li id="<?= $menu->id?>">
												
												<div class="description fullwidth">
													<div class="title">
														<h4><?php echo stripslashes($menu->menu_name) ?></h4>
														<div class="btn">
															<a href="<?php echo esc_url(add_query_arg(array('editmenu'=>$menu->parentcatid,'languageid'=>'fr'), site_url() . '/manage-categories')); ?>" class="edit"><?= $_SESSION['lan']['edit']?> </a>
															<a href="javascript:void(0)" class="del deletemenu" menuid="<?php echo $menu->parentcatid ?>"><?= $_SESSION['lan']['remove']?> </a>
														</div>
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
								<ul class="easyPaginate myListIt" id="itlist">
									<?php
									$query = "SELECT * FROM $menu_detail_table WHERE language ='it' && entry_by=" . get_current_user_id()." ORDER BY cat_order";
									$menuArr = $wpdb->get_results($query);
									?>
									<?php if (count($menuArr) > 0) { ?>
										<?php
										foreach ($menuArr as $menu) {
											
											?>
								<li id="<?= $menu->id?>">
												
												<div class="description fullwidth">
													<div class="title">
														<h4><?php echo stripslashes($menu->menu_name) ?></h4>
														<div class="btn">
															<a href="<?php echo esc_url(add_query_arg(array('editmenu'=>$menu->parentcatid,'languageid'=>'it'), site_url() . '/manage-categories')); ?>" class="edit"><?= $_SESSION['lan']['edit']?> </a>
															<a href="javascript:void(0)" class="del deletemenu" menuid="<?php echo $menu->parentcatid ?>"><?= $_SESSION['lan']['remove']?> </a>
														</div>
													</div>
									
													
												</div>
											</li>			
                                                                    
										<?php } ?>
										<?php
									} else { ?>
										<div class='description'><?= $_SESSION['lan']['not_add_menu']?>..</div>;
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
								<ul class="easyPaginate myListJa" id="jalist">
									<?php
									$query = "SELECT * FROM $menu_detail_table WHERE language ='ja' && entry_by=" . get_current_user_id()." ORDER BY cat_order";
									$menuArr = $wpdb->get_results($query);
									?>
									<?php if (count($menuArr) > 0) { ?>
										<?php
										foreach ($menuArr as $menu) {
											
											?>
								<li id="<?= $menu->id?>">
												
												<div class="description fullwidth">
													<div class="title">
														<h4><?php echo stripslashes($menu->menu_name) ?></h4>
														<div class="btn">
															<a href="<?php echo esc_url(add_query_arg(array('editmenu'=>$menu->parentcatid,'languageid'=>'ja'), site_url() . '/manage-categories')); ?>" class="edit"><?= $_SESSION['lan']['edit']?> </a>
															<a href="javascript:void(0)" class="del deletemenu" menuid="<?php echo $menu->parentcatid ?>"><?= $_SESSION['lan']['remove']?> </a>
														</div>
													</div>
									
													
												</div>
											</li>			
                                                                    
										<?php } ?>
										<?php
									} else { ?>
										<div class='description'><?= $_SESSION['lan']['not_add_menu']?>..</div>;
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
				
                       	
            </div>			
        </div>		
    </div>
</section>
<!--</section>-->
<!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.3/jquery.min.js"></script>
 --><script type="text/javascript" src="<?php echo bloginfo('template_url'); ?>/js/jquery.paginate.js"></script>
<script type="text/javascript">
jQuery(document).ready(function()    {
	jQuery('#list').paginate({itemsPerPage: 10});
	jQuery('#enlist').paginate({itemsPerPage: 10});
	jQuery('#frlist').paginate({itemsPerPage: 10});
	jQuery('#itlist').paginate({itemsPerPage: 10});
	jQuery('#jalist').paginate({itemsPerPage: 10});
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
                    url: "<?php echo site_url() . '/manage-category' ?>",
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

 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
$(function(){
   $("#list,#enlist,#frlist,#itlist,#jalist").sortable();//set sorting to all language
  
   //save order into db for spanish
   $( ".myList" ).sortable({
        stop: function( event, ui ) {
             var idArr=$( ".myList" ).sortable( "toArray" );
              jQuery.ajax({
					         type : "post",
					         url : myAjax.ajaxurl,
					         data : {action: "dragDropOrder",orderArr: idArr},
                   success:function(data){
                     }
			        });
         }
    });
  
   //save order into db for English
   $( ".myListEn" ).sortable({
        stop: function( event, ui ) {
             var idArr=$( ".myListEn" ).sortable( "toArray" );
              jQuery.ajax({
					         type : "post",
					         url : myAjax.ajaxurl,
					         data : {action: "dragDropOrder",orderArr: idArr},
                   success:function(data){
                     }
			        });
         }
    });
  
   //save order into db for japniesh
   $( ".myListJa" ).sortable({
        stop: function( event, ui ) {
             var idArr=$( ".myListJa" ).sortable( "toArray" );
              jQuery.ajax({
					         type : "post",
					         url : myAjax.ajaxurl,
					         data : {action: "dragDropOrder",orderArr: idArr},
                   success:function(data){
                     }
			        });
         }
    });
  
  
   //save order into db for Franch
   $( ".myListFr" ).sortable({
        stop: function( event, ui ) {
             var idArr=$( ".myListFr" ).sortable( "toArray" );
              jQuery.ajax({
					         type : "post",
					         url : myAjax.ajaxurl,
					         data : {action: "dragDropOrder",orderArr: idArr},
                   success:function(data){
                     }
			        });
         }
    });
  
     //save order into db for Italian

   $( ".myListIt" ).sortable({
        stop: function( event, ui ) {
             var idArr=$( ".myListIt" ).sortable( "toArray" );
              jQuery.ajax({
					         type : "post",
					         url : myAjax.ajaxurl,
					         data : {action: "dragDropOrder",orderArr: idArr},
                   success:function(data){
                     }
			        });
         }
    });
  
       
});
  </script>
<?php
get_footer();
?>
