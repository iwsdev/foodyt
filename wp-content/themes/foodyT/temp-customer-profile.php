<?php
/*
Template Name:Customer Profile
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

$query = "SELECT id,SUM(twitter_count) as twitter_count,SUM(whats_up_count) as whats_up_count,SUM(fb_count) as fb_count
	FROM  $menu_details_table 
	WHERE  language ='".$langId."' AND entry_by = ".$userId;
$totalDishShare = $wpdb->get_results($query);

$query = "SELECT *
	FROM  $menu_details_table 
	WHERE  language ='".$langId."' AND entry_by = ".$userId;
$singleDishShare = $wpdb->get_results($query);
// echo "<pre>";
// print_r($totalDishShare);
?>
<script type="text/javascript">
	
	jQuery(document).ready(function(){

		jQuery('#Country').click(function(){
      
      jQuery("#currenttab").val('Country');
			jQuery('#Countrybox').show();
			jQuery('#Sexbox').hide();
      jQuery('#Agebox').hide();
			jQuery('#Country').css({'background':'#f39500','border':'4px solid #f39500','color':'#fff'});
			jQuery('#Sex').css({'background':'#fff','border':'4px solid #f39500','color':'#f39500'});
      jQuery('#Age').css({'background':'#fff','border':'4px solid #f39500','color':'#f39500'});
		});

		jQuery('#Sex').click(function(){
       jQuery("#currenttab").val('Sex');
			jQuery('#Sexbox').show();
			jQuery('#Countrybox').hide();
      jQuery('#Agebox').hide();
			jQuery('#Sex').css({'background':'#f39500','border':'4px solid #f39500','color':'#fff'});
			jQuery('#Country').css({'background':'#fff','border':'4px solid #f39500','color':'#f39500'});
      jQuery('#Age').css({'background':'#fff','border':'4px solid #f39500','color':'#f39500'});
		});
    
    jQuery('#Age').click(function(){
      jQuery("#currenttab").val('Age');
			jQuery('#Agebox').show();
			jQuery('#Sexbox').hide();
      jQuery('#Countrybox').hide();
			jQuery('#Age').css({'background':'#f39500','border':'4px solid #f39500','color':'#fff'});
			jQuery('#Country').css({'background':'#fff','border':'4px solid #f39500','color':'#f39500'});
      jQuery('#Sex').css({'background':'#fff','border':'4px solid #f39500','color':'#f39500'});
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
                  if($currenttab=="")
                  {
                    $currenttab = 'Country';
                  }
                if($daterange!="")
                {
                  $daterangearr = explode("-",$daterange);
                  $daterange2show =$daterange;
                  
                  $fromdatetxt =$daterangearr[0];
                  $todatetxt =$daterangearr[1];
                  
                  $fromdate = strtotime($fromdatetxt);
                  $todate = strtotime($todatetxt);
                  
                  
                }
                else
                {
                  $startdate = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' -14 day'));
                  
                  $daterange2show = date('j F, Y',strtotime($startdate))." - ".date('j F, Y');$fromdate="";$todate="";
                  
                  $fromdatetxt = date('Y-m-d',strtotime($startdate));
                  $fromdate = strtotime($fromdatetxt);
                  $todate = strtotime('Y-m-d');
                }
                  
                 
		          ?>
            </div>
            
        <div class="col-md-9 col-sm-8 col-xs-12 account-details">
          <h3><?= $_SESSION['lan']['CustomerProfile']?></h3>
              <div class="wrapped">
                
               <form action="<?php echo $actual_link;?>" method="POST" id="frmfilter">
                  <input type="hidden" id="currenttab" name="currenttab" value="<?php echo $currenttab;?>">
                  <input type="hidden" id="daterange" name="daterange" value="">
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
                <?php 
                
                 include('calendar-script.php');
                
                $zonelist = array('-12.00' =>'Kwajalein', '-11.00' =>'Pacific/Midway', '-10.00' =>'Pacific/Honolulu', '-9.00'=>'America/Anchorage', '-8.00' =>'America/Los_Angeles', '-7.00' =>'America/Denver', '-6.00' =>'America/Tegucigalpa' , '-5.00' =>'America/New_York' , '-4.00' =>'America/Halifax','-3.00' =>'America/Argentina/Buenos_Aires' , '-3.00' =>'America/Sao_Paulo' , '-2.00' =>'Atlantic/South_Georgia', '-1.00' =>'Atlantic/Azores', '0' =>'Europe/Dublin', '1.00' =>'Europe/Belgrade', '2.00' =>'Europe/Minsk', '3.00' =>'Asia/Kuwait', '3.30' =>'Asia/Tehran', '4.00' =>'Asia/Muscat', '5.00' =>'Asia/Yekaterinburg', '5.50' =>'Asia/Kolkata', '5.45' =>'Asia/Katmandu', '6.00' =>'Asia/Dhaka', '6.30' =>'Asia/Rangoon', '7.00' =>'Asia/Krasnoyarsk', '8.00' =>'Asia/Singapore', '9.00' =>'Asia/Seoul', '9.30' =>'Australia/Darwin', '10.00' =>'Australia/Canberra' , '11.00' =>'Asia/Magadan', '12.00' =>'Pacific/Fiji', '13.00' =>'Pacific/Tongatapu');
                    $maleuser=0;$femaleuser=0;$age_rangearr="";$timezonearr="";
                
                    $visit_restaurants = 'visit_restaurants_'.$userId;
                    $visit_restaurantsdate = 'visit_restaurants_date'.$userId;
                    
                if($fromdate!="" && $todate!="")
                {
                     $argsuser = array(
                        'meta_query' => array(
                            array(
                                'key' => 'registervia',
                                'value' => 'facebook',
                                'compare' => '='
                            ),
                            array(
                                'key' =>$visit_restaurants,
                                'value' => 'visited',
                                'compare' => '='
                            ),
                         array(
                                'key' =>$visit_restaurantsdate,
                                'value' => array( $fromdate, $todate ),
                                'type' => 'NUMERICAL',
                                'compare' => 'BETWEEN'
                            )
                        )
                    );
                }
                else
                {
                  $argsuser = array(
                        'meta_query' => array(
                            array(
                                'key' => 'registervia',
                                'value' => 'facebook',
                                'compare' => '='
                            ),
                            array(
                                'key' =>$visit_restaurants,
                                'value' => 'visited',
                                'compare' => '='
                            )
                        )
                    );
                }
                    //$usersby = get_users(array('meta_key'=> 'registervia','meta_value'=>'facebook'));
                    $usersby = get_users($argsuser);
                    if(!empty($usersby))
                    {  
                      
                       $i=0;
                       foreach($usersby as $singleuser)
                       {
                         
                         $ID = $singleuser->ID;
                         $user_login = $singleuser->user_login;
                         $gender=get_user_meta($ID,'gender',true);
                         
                         $age_range=get_user_meta($ID,'age_range',true);
                         $timezone=get_user_meta($ID,'timezone',true);
                        
                         $age_rangearr[$i]=$age_range;
                         $timezonearr[$i]=$timezone;
                         
                         if($gender!="")
                         {
                           if($gender=='male')
                           {
                             $maleuser++;
                           }
                           else
                           {
                             $femaleuser++;
                           }
                         }
                         
                        $i++;
                       }
                      
                       $timezonearr_uniq = array_count_values($timezonearr);
                        $final = array(
                          '0_17' => 0,
                          '18_25' => 0,
                          '26_35' => 0,
                          '36_45' => 0,
                          '46_55' => 0,
                          '56_65' => 0,
                          '65' => 0,
                      );
                      
                      if(!empty($age_rangearr))
                    {
                      
                      
                      foreach($age_rangearr as $singleage)
                      {
                        if($singleage <18)
                        {
                          $final['0_17']++;
                        }
                        elseif($singleage >17 && $singleage <=25)
                        {
                          $final['18_25']++;
                        }
                        elseif($singleage >25 && $singleage <=35)
                        {
                          $final['26_35']++;
                        }
                        elseif($singleage >35 && $singleage <=45)
                        {
                          $final['36_45']++;
                        }
                        elseif($singleage >45 && $singleage <=55)
                        {
                          $final['46_55']++;
                        }
                        elseif($singleage >55 && $singleage <=55)
                        {
                          $final['56_65']++;
                        }
                        else
                        {
                          $final['65']++;
                        }
                      }
                      
                    }
                      
                      
                    }
                
                if(!empty($usersby))
                {
                 
                  
                 
                ?>
            
                
                
      
             <?php }?>
                
	              <div class='col-sm-4'>
	              		<button type="button" class='btn btn-primary activeColor' id='Country'><?= $_SESSION['lan']['Country']?></button>
	              </div>
	              <div class='col-sm-4'>
	              		<button type="button" class='btn btn-primary deactiveColor' id='Sex'><?= $_SESSION['lan']['Sex']?></button>
	              </div>
                <div class='col-sm-4'>
	              		<button type="button" class='btn btn-primary deactiveColor' id='Age'><?= $_SESSION['lan']['Age']?></button>
	              </div>
                <?php 
                    
                    
                    
                    if(!empty($usersby))
                    { 
                    ?>
	              <div class='row'>
                  
                  
		              <div class='col-sm-12' id='Countrybox'>
		              	
                    <div class='col-sm-6 datalist ab'>
		              		
		              	<?php 
                      foreach($timezonearr_uniq as $keylabel=>$arrval)
                      {
                        if($keylabel!='0')
                        {
                          $keylabelnum = number_format($keylabel,2);
                        }
                        else
                        {
                          $keylabelnum=$keylabel;
                        }
                        $timezone=$zonelist[$keylabelnum];
                      ?>
                      <p><span class="leftlabel"><?php echo $timezone;?>:</span><span class="leftvalue"><?php echo $arrval;?></span></p> 
                      <?php 
                      }
                      ?>
		              		
			             </div>
		                
			             <div class='col-sm-6 chug'>
							
                           <div id="piechart"></div>
   
			             </div>
			               
			           </div>

                  
                  <div class='col-sm-12' id='Sexbox' style="display:none;">
                    
		              	<div class='col-sm-6 datalist cd'>
							
                      <p><span class="leftlabel maleIcon"><?= $_SESSION['lan']['Male']?>:</span><span class="leftvalue"><?php echo $maleuser;?></span></p> 
                      <p><span class="leftlabel femaleIcon"><?= $_SESSION['lan']['FeMale']?>:</span><span class="leftvalue"><?php echo $femaleuser;?></span></p> 
   
			               </div>  
                    <div class='col-sm-6 chug'>
							
                           <div id="piechart2"></div>
   
			                 </div>
			               
			           </div>
                  
                  
                  <div class='col-sm-12' id='Agebox' style="display:none;">
		              	 
                    <div class='col-sm-6 datalist cd'>
							
                      <?php 
                      foreach($final as $keylabel=>$arrval)
                      {
                         
                         if($keylabel=='65')
                         {
                           $labeltext ='+65';
                         }
                         else
                         {
                           $labeltext = str_replace('_','-',$keylabel);
                         }
                      ?>
                      <p><span class="leftlabel"><?php echo $labeltext;?>:</span><span class="leftvalue"><?php echo $arrval;?></span></p> 
                      <?php 
                      }
                      ?>
   
			                 </div>  
                    <div class='col-sm-6 chug'>
							
                           <div id="piechart3"></div>
   
			                 </div>
			               
			           </div>
                  
			            
	            </div>
                
             <?php }else{?>
                <div class='row'>
                  
                  <div class='col-sm-12' id='Countrybox'><p><?= $_SESSION['lan']['notfound']?></p></div>
                  <div class='col-sm-12' id='Sexbox' style="display:none"><p><?= $_SESSION['lan']['notfound']?></p></div>
                  <div class='col-sm-12' id='Agebox' style="display:none"><p><?= $_SESSION['lan']['notfound']?></p></div>
                  
                </div>
                
             <?php }?>

	          </div>
        </div>

	            
		          
            
     </div>
   </div>
<?php
get_footer(); 
?>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

	<script type="text/javascript">
	  google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart()
      {

        var data = google.visualization.arrayToDataTable([
          ['Country', ' Data'],
          <?php 
          if($timezonearr!="")
          {
          foreach($timezonearr_uniq as $keylabel=>$arrval)
          {
              if($keylabel!='0')
              {
                $keylabelnum = number_format($keylabel,2);
              }
              else
              {
                $keylabelnum=$keylabel;
              }
              $timezone=$zonelist[$keylabelnum];
          ?>
          ['<?php echo $timezone;?>',  <?php echo $arrval;?>],
          <?php } }?>
        ]);

        var options = {
         //title: 'Social Report'
          height:200,
			width:350,
         colors: ['#f39500' , '#f9d69f' , '#67b024','#f39500' , '#f9d69f' , '#67b024','#f39500' , '#f9d69f' , '#67b024','#f39500' , '#f9d69f' , '#67b024'] 


        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
        
        var data2 = google.visualization.arrayToDataTable([
          ['Sex', ' Data'],
          ['<?= $_SESSION['lan']['Male']?>',     <?php echo $maleuser;?>],
          ['<?= $_SESSION['lan']['FeMale']?>',   <?php echo $femaleuser;?>]
        ]);

        var options2 = {
         //title: 'Social Report'
			width:350,
         colors: ['#40634D' , '#E8EBA9'] 
        };
        
        var chart2 = new google.visualization.PieChart(document.getElementById('piechart2'));
        chart2.draw(data2, options2);
        
        var data3 = google.visualization.arrayToDataTable([
          ['Age', ' Data'],
          ['0-17',     <?php echo $final['0_17'];?>],
          ['18-25',   <?php echo $final['18_25'];?>],
          ['26-35',   <?php echo $final['26_35'];?>],
          ['36-45',   <?php echo $final['36_45'];?>],
          ['46-55',   <?php echo $final['46_55'];?>],
          ['56-65',   <?php echo $final['56_65'];?>],
          ['+65',   <?php echo $final[65];?>]
        ]);

        var options3 = {
         //title: 'Social Report'
			width:350,
         colors: ['#40634D' , '#E8EBA9','#40634D' , '#E8EBA9','#40634D' , '#E8EBA9','#40634D'] 
        };
        
        var chart3 = new google.visualization.PieChart(document.getElementById('piechart3'));
        chart3.draw(data3, options3);

        
      }
</script>
