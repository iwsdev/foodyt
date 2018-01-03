<?php
/*
Template Name:Social Network Template
*/
get_header();

$languageContent = getArrayOfContent();
$langId = $_SESSION['lanCode'];
if($langId=='')
  $langId = 'es';
$_SESSION['lan'] = $languageContent[$langId];	
global $wpdb;
$menu_details_table = $wpdb->prefix."menu_details";
$viewdish_table = $wpdb->prefix."socialshare";
$user = wp_get_current_user();
$userId = $user->id;


// echo "<pre>";
// print_r($totalDishShare);
?>
<script type="text/javascript">
	
	jQuery(document).ready(function(){

		jQuery('#totalShare').click(function(){
			jQuery("#currenttab").val('totalShare');
			jQuery('#perDishShareBox').hide();
			jQuery('#totalShareBox').show();
			jQuery('#totalShare').css({'background':'#f39500','border':'4px solid #f39500','color':'#fff'});
			jQuery('#perDishShare').css({'background':'#fff','border':'4px solid #f39500','color':'#f39500'});
		});

		jQuery('#perDishShare').click(function(){
			jQuery("#currenttab").val('perDishShare');
			jQuery('#perDishShareBox').show();
			jQuery('#totalShareBox').hide();
			jQuery('#perDishShare').css({'background':'#f39500','border':'4px solid #f39500','color':'#fff'});
			jQuery('#totalShare').css({'background':'#fff','border':'4px solid #f39500','color':'#f39500'});
		});

	});
	</script>

	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

	
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
                    $currenttab = 'totalShare';
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
                  
			          if($orderbycnt!="")
                  {
                    $orderbyquery=" ORDER BY twitter_count $orderbycnt, fb_count $orderbycnt , whats_up_count $orderbycnt";
                    
                  }
                  else
                  {
                    $orderbyquery="";
                  }
                  $strquery = "AND date(Addedon) between date('$fromdate') and date('$todate')";	
			   

			$query = "SELECT * FROM  $menu_details_table WHERE  language ='".$langId."' AND entry_by='$userId' $orderbyquery";
			$singleDishShare = $wpdb->get_results($query);
				
		       ?>
            </div>
            
        <div class="col-md-9 col-sm-8 col-xs-12 account-details">
          <h3><?= $_SESSION['lan']['SocialNetwork']?> </h3>
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
				  <script>
                  
                   setTimeout(function(){ 
                     var currenttab = jQuery("#currenttab").val();
                  console.log(currenttab);
                     jQuery("#"+currenttab).trigger( "click" );
                   }, 100);
                   
                </script>
				 
	              <div class='col-sm-2'>
	              		<button type="button" class='btn btn-primary activeColor' id='totalShare'><?= $_SESSION['lan']['Total']?></button>
	              </div>
	              <div class='col-sm-4'>
	              		<button type="button" class='btn btn-primary deactiveColor' id='perDishShare'><?= $_SESSION['lan']['PerDishfood']?></button>
	              </div>
	              <div class='row'>
		              <div class='col-sm-12' id='totalShareBox'>
		              	  <div class='col-sm-2'>
		              		<div class='socialIconAccount'>
		              			<img src="<?php echo bloginfo('template_url') ?>/assets/images/whatsup.svg">
		              			<p id="whatsappcount"></p>
		              		</div>
		              		<div class='socialIconAccount'>
		              			<img src="<?php echo bloginfo('template_url') ?>/assets/images/fb.svg">
		              			<p id="facebookcount"></p>
		              		</div>
		              		<div class='socialIconAccount'>
		              			<img src="<?php echo bloginfo('template_url') ?>/assets/images/twit.svg">
		              			<p id="twittercount"></p>
		              		</div>
			             </div>
		                 <div class='col-sm-4'>
		                 </div>
			             <div class='col-sm-6'>
							
                           <div id="piechart" class="chartGraph"></div>
   
			             </div>
			               
			           </div>

			            <div class='col-sm-12' id="perDishShareBox" style="display:none;">
		              	    <div class='col-sm-10 dishFood'>
		              	    <div class='padding10'><?= $_SESSION['lan']['dishname']?></div>
		              		<?php 
		              		$urlBase = get_template_directory_uri();
		              		 $what = '<img src='.$urlBase.'/assets/images/whatsup.svg>';
		              		 $fb = '<img  src='.$urlBase.'/assets/images/fb.svg>';
		              		 $twit = '<img  src='.$urlBase.'/assets/images/twit.svg>';
						     
						     $facebookshare=0;$twittershare=0; $whatsappshare=0;
								
		                    foreach($singleDishShare as $dish)
							{
		              			
								$facebookshare_sing  = Socialsharecount('facebook',$dish->id,$strquery);
								$twittershare_sing  = Socialsharecount('twitter',$dish->id,$strquery);
								$whatsappshare_sing  = Socialsharecount('whatsapp',$dish->id,$strquery);
								
								$facebookshare = $facebookshare +$facebookshare_sing;
								$twittershare = $twittershare +$twittershare_sing;
								$whatsappshare = $whatsappshare +$whatsappshare_sing;
								
								echo "<div class='wpm'><p style='float:left;width:45%;'>".$dish->name."</p>";
		              			echo "<div class='wp'><div class='list'>
		              				".$what." <span>".$whatsappshare_sing."</span></div> <div class='list'> ".$fb." <span> ".$facebookshare_sing." </span></div> <div class='list'>".$twit."<span>".$twittershare_sing."</span></div> 
		              			     </div></div>";

		              		}
		              		?>
								<script>
									document.getElementById("whatsappcount").innerHTML =<?php echo $whatsappshare;?>;
									document.getElementById("facebookcount").innerHTML = <?php echo $facebookshare;?>;
									document.getElementById("twittercount").innerHTML = <?php echo $twittershare;?>;
								</script>
                          <script type="text/javascript">
	  google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Social Share', ' per Dish'],
          ['<?= $_SESSION['lan']['WhatsApp']?>',     <?php echo $whatsappshare;?>],
          ['<?= $_SESSION['lan']['Facebook']?>',   <?php echo $facebookshare;?>],
          ['<?= $_SESSION['lan']['Twitter']?>',  <?php echo $twittershare;?>]
        ]);

        var options = {
         //title: 'Social Report'
		height:200,	
			width:350,
         colors: ['#f39500' , '#f9d69f' , '#67b024'] 


        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
</script>
			                </div>
			                <div class='col-sm-2 visitor'>
			              		 <select name="orderby" id="orderby" onchange="ChangeOrder();">
                      <option value=""><?= $_SESSION['lan']['Valuations']?></option>
                     <option value="ASC" <?php if($orderbycnt=='ASC'){ echo 'selected';}?>><?= $_SESSION['lan']['ASC']?></option>
                     <option value="DESC" <?php if($orderbycnt=='DESC'){ echo 'selected';}?>><?= $_SESSION['lan']['DESC']?></option>
                   </select>
			                </div>
			           </div>
	            </div>

	          </div>
        </div>

	            <?php 
				   include('calendar-script.php');
				  ?>
		          
            
     </div>
   </div>
<?php
get_footer(); 
?>
