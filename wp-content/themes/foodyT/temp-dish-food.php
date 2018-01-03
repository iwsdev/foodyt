<?php
/*
Template Name:Dish Food Template
*/
get_header();
$languageContent = getArrayOfContent();
$langId = $_SESSION['lanCode'];
if($langId=='')
  $langId = 'es';
$_SESSION['lan'] = $languageContent[$langId];	
global $wpdb;
$menu_details_table = $wpdb->prefix."menu_details";
$viewdish_table = $wpdb->prefix."viewdish";
$comment_table = $wpdb->prefix."comments";
$user = wp_get_current_user();
$userId = $user->id;


// echo "<pre>";
// print_r($totalRating);
?>

<script type="text/javascript">
	
	jQuery(document).ready(function(){

		jQuery('#Visits').click(function(){
      jQuery("#currenttab").val('Visits');
			jQuery('#dishRating').hide();
			jQuery('#dishRatingMob').hide();
			jQuery('#dishCount').show();
			jQuery('#dishCountMob').show();
			jQuery('#Visits').css({'background':'#f39500','border':'4px solid #f39500','color':'#fff'});
			jQuery('#Valuations').css({'background':'#fff','border':'4px solid #f39500','color':'#f39500'});
		});

		jQuery('#Valuations').click(function(){
      jQuery("#currenttab").val('Valuations');
			jQuery('#dishRating').show();
			jQuery('#dishRatingMob').show();
			jQuery('#dishCount').hide();
			jQuery('#dishCountMob').hide();
			jQuery('#Valuations').css({'background':'#f39500','border':'4px solid #f39500','color':'#fff'});
			jQuery('#Visits').css({'background':'#fff','border':'4px solid #f39500','color':'#f39500'});
		});

	});
</script>

<section id="my-account" class="manageplan">
    <div class="container">
  
        <p class='cancelSus' style='color:green;display: none;text-align:center;'><?= $_SESSION['lan']['cancel_sub_msg']?>.</p>
        <p class='cancelSus' style='color:green;display: none;text-align:center;'><?= $_SESSION['lan']['u_will_logout']?>...</p>
        <?php include 'usernotification.php'; ?>
        <div class="row">
            <div class="col-md-3 col-sm-4 col-xs-12 account-menu">
                <h3><?= $_SESSION['lan']['my_account']?></h3>
               
		         <?php
		          if($_SESSION['lanCode']=='' || $_SESSION['lanCode']=='es'){  wp_nav_menu(array('theme_location'=>'sidebar-report-menu'));}
		          else{
		              wp_nav_menu(array('theme_location'=>'sidebar-report-menu-english'));
		          }
                  
                  $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

                  $daterange = $_REQUEST['daterange'];
                  $currenttab = $_REQUEST['currenttab'];
                  $orderbycnt = $_REQUEST['orderbycnt'];
                  if($currenttab=="")
                  {
                    $currenttab = 'Visits';
                  }
                if($daterange!="")
                {
                  $daterangearr = explode("-",$daterange);
                  $daterange2show =$daterange;
                  
                  $fromdatetxt =$daterangearr[0];
                  $todatetxt =$daterangearr[1];
                  
                  $fromdate = date('Y-m-d',strtotime($fromdatetxt));
                  $todate = date('Y-m-d',strtotime($todatetxt));
                  
                  
                }
                else
                {
                  $startdate = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' -14 day'));
                  $daterange2show = date('j F, Y',strtotime($startdate))." - ".date('j F, Y');$fromdate="";$todate="";
                  $fromdatetxt = date('Y-m-d',strtotime($startdate));
                 
                  
                  
                  $fromdate = date('Y-m-d',strtotime($fromdatetxt));
                  $todate = date('Y-m-d');
                }
                
                  $strquery = "AND date(vd.Addedon) between date('$fromdate') and date('$todate')";
                  $strquery2 = "AND date(comment.comment_date) between date('$fromdate') and date('$todate')";
                  if($orderbycnt!="")
                  {
                    $orderbyquery=" ORDER BY numberOfView $orderbycnt";
                    $orderbyquery2=" ORDER BY ratingCount $orderbycnt";
                  }
                  else
                  {
                    $orderbyquery="";$orderbyquery2="";
                  }
                  $query = "SELECT COUNT(vd.dishid) AS numberOfView,md.id,md.name
                  FROM  $menu_details_table md
                  LEFT JOIN  $viewdish_table vd 
                              ON 
                              md.id = vd.dishid $strquery
                  WHERE  language ='".$langId."' AND md.entry_by = ".$userId."
                  GROUP BY md.id $orderbyquery";
                $totalDish = $wpdb->get_results($query);

                $query = "SELECT COUNT(*) AS ratingCount,sum(comment.rating) AS ratingAdd,md.id,md.name
                  FROM  $menu_details_table md
                  LEFT JOIN  $comment_table comment 
                              ON 
                              md.id = comment.dish_id $strquery2
                  WHERE  language ='".$langId."' AND md.entry_by = ".$userId."
                  GROUP BY md.id $orderbyquery2";
                $totalRating = $wpdb->get_results($query);
                
		          ?>
            </div>
            
        <div class="col-md-9 col-sm-8 col-xs-12 account-details">
          <h3><?= $_SESSION['lan']['DishFood']?></h3>
              <div class="wrapped">
                 <form action="<?php echo $actual_link;?>" method="POST" id="frmfilter">
                  <input type="hidden" id="currenttab" name="currenttab" value="<?php echo $currenttab;?>">
                  <input type="hidden" id="daterange" name="daterange" value="">
                  <input type="hidden" id="orderbycnt" name="orderbycnt" value="">
                  <div class="input-group input-daterange pull-right" style="margin: 0 0 20px 0;">


                   <div id="date-range">
                    <div id="date-range-field">
                      <span><?php echo $daterange2show;?></span>
                      <a href="#">&#9660;</a>
                    </div>
                    <div id="datepicker-calendar"></div>
                  </div>
                  <button type="button" class="btn btn-success" onclick="Filterdata();"><?= $_SESSION['lan']['Filter']?></button>
                 </div>
                </form>
	             <div class="row" style="float:left; width:100%;"> 
					 <div class='col-sm-4'>
	              		<button type="button" class='btn btn-primary activeColor' id='Visits'><?= $_SESSION['lan']['Visits']?></button>
	              </div>
	              <div class='col-sm-4'>
	              		<button type="button" class='btn btn-primary deactiveColor' id='Valuations'><?= $_SESSION['lan']['Valuations']?></button>
	              </div>
				  
                  <div class='col-md-4' style="text-align:right">
                   <select name="orderby" id="orderby" onchange="ChangeOrder();">
                      <option value=""><?= $_SESSION['lan']['Valuations']?></option>
                     <option value="ASC" <?php if($orderbycnt=='ASC'){ echo 'selected';}?>><?= $_SESSION['lan']['ASC']?></option>
                     <option value="DESC" <?php if($orderbycnt=='DESC'){ echo 'selected';}?>><?= $_SESSION['lan']['DESC']?></option>
                   </select>
	              </div>
				 </div>
                
               <script>
                  
                   setTimeout(function(){ 
                     var currenttab = jQuery("#currenttab").val();
                  console.log(currenttab);
                     jQuery("#"+currenttab).trigger( "click" );
                   }, 100);
                   
                </script>
				<?php  include('calendar-script.php');  ?>
	              <div class='row desk'>
		              <div class='col-sm-12' id='dishCount'>
		              	    <div class='col-sm-8 dishFood'>
								<ul>
								<li class='hd-heading'><div class="heads"><?= $_SESSION['lan']['dishname']?></div><div class="heads1"><?= $_SESSION['lan']['Visitor']?></div></li>
								<?php 
						  
							  
								 foreach($totalDish as $dish){
									//echo "<p>""</p>";

								
								echo "<li>";
									echo "<div class='p_name'>".$dish->name."</div>";
									echo "<div class='visitor'>".$dish->numberOfView."</div>";
								echo "</li>";
								}
								
								?>
								</ul>			                </div>
			               
							 
			           </div>

			            <div class='col-sm-12' id="dishRating" style="display:none;">
		              	     <div class='col-sm-8 dishFood'>
							<ul>
							<li class='hd-heading'><div class="heads"><?= $_SESSION['lan']['dishname']?></div><div class="heads1"><?= $_SESSION['lan']['Valuations']?></div></li>
		              	   
		              		<?php foreach($totalRating as $dish){
		              			
									echo "<li>";
										echo "<div class='p_name'>".$dish->name."</div>";
										echo "<div class='visitor'>"; 
										$count = $dish->ratingCount*5;
										   if($count>0){
										   $startPercentage = (100*$dish->ratingAdd)/$count;
										   } else{$startPercentage=0;}
											echo "<div class='star-ratings-sprite-myaccount'><span style='width:".$startPercentage."%' class='star-ratings-sprite-rating-myaccount'></span></div>";
										echo "</div>";
									echo "</li>";	
		              		}
		              		?>
							</ul>
			                </div>
			           </div>
	            </div>
				
				
				
				
				<div class='row mobile'>
		              <div class='col-sm-12' id='dishCountMob'>
		              	    <div class='col-sm-4 dishFood'>
								<ul>
								<li class='hd-heading'><div class="heads"><?= $_SESSION['lan']['dishname']?></div><div class="heads1"><?= $_SESSION['lan']['Visitor']?></div></li>
								<?php 
						  
							  
								 foreach($totalDish as $dish){
									//echo "<p>""</p>";

								
								echo "<li>";
									echo "<div class='p_name'>".$dish->name."</div>";
									echo "<div class='visitor'>".$dish->numberOfView."</div>";
								echo "</li>";
								}
								
								?>
								</ul>
			                </div>
			      
							 
			           </div>

			            <div class='col-sm-12' id="dishRatingMob" style="display:none;">
		              	    <div class='col-sm-4 dishFood'>
							<ul>
							<li class='hd-heading'><div class="heads"><?= $_SESSION['lan']['dishname']?></div><div class="heads1"><?= $_SESSION['lan']['Valuations']?></div></li>
		              	   
		              		<?php foreach($totalRating as $dish){
		              			
									echo "<li>";
										echo "<div class='p_name'>".$dish->name."</div>";
										echo "<div class='visitor'>"; 
										$count = $dish->ratingCount*5;
										   if($count>0){
										   $startPercentage = (100*$dish->ratingAdd)/$count;
										   } else{$startPercentage=0;}
											echo "<div class='star-ratings-sprite-myaccount'><span style='width:".$startPercentage."%' class='star-ratings-sprite-rating-myaccount'></span></div>";
										echo "</div>";
									echo "</li>";	
		              		}
		              		?>
							</ul>
			                </div>
			              
			           </div>
	            </div>
				

	          </div>
        </div>

	            
		          
            
     </div>
   </div>
<?php
get_footer(); 
?>

