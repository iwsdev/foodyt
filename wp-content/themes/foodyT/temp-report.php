<?php
/*
Template Name:vistToMenu or Report
*/
get_header();

global $wpdb;
$restaurant_info_table = $wpdb->prefix."restaurant_infos";
$visitor_table = $wpdb->prefix."visitor";
$user = wp_get_current_user();
$userId = $user->id;
?> 
<script type="text/javascript">
	
	jQuery(document).ready(function(){

		jQuery('#Country').click(function(){
      
      jQuery("#currenttab").val('Country');
			jQuery('#Countrybox').show();
			jQuery('#Countrybox2').show();
			jQuery('#Sexbox').hide();
			jQuery('#Sexbox2').hide();
      jQuery('#Agebox').hide();
      jQuery('#Agebox2').hide();
			jQuery('#Country').css({'background':'#f39500','border':'4px solid #f39500','color':'#fff'});
			jQuery('#Sex').css({'background':'#fff','border':'4px solid #f39500','color':'#f39500'});
      jQuery('#Age').css({'background':'#fff','border':'4px solid #f39500','color':'#f39500'});
		});

		jQuery('#Sex').click(function(){
       jQuery("#currenttab").val('Sex');
			jQuery('#Sexbox').show();
			jQuery('#Sexbox2').show();
			jQuery('#Countrybox').hide();
			jQuery('#Countrybox2').hide();
      jQuery('#Agebox').hide();
      jQuery('#Agebox2').hide();
			jQuery('#Sex').css({'background':'#f39500','border':'4px solid #f39500','color':'#fff'});
			jQuery('#Country').css({'background':'#fff','border':'4px solid #f39500','color':'#f39500'});
      jQuery('#Age').css({'background':'#fff','border':'4px solid #f39500','color':'#f39500'});
		});
    
    jQuery('#Age').click(function(){
      jQuery("#currenttab").val('Age');
			jQuery('#Agebox').show();
			jQuery('#Agebox2').show();
			jQuery('#Sexbox').hide();
			jQuery('#Sexbox2').hide();
      jQuery('#Countrybox').hide();
      jQuery('#Countrybox2').hide();
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
                  
                  $placeholder=array('January','February','March','April','May','June','July','August','September','October','November','December');
				  $replaceby = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');	
				
                  $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                  $daterange = $_REQUEST['daterange'];
                  $currenttab = $_REQUEST['currenttab'];
                  if($currenttab=="")
                  {
                    $currenttab = 'Country';
                  }
					
                if($daterange!="")
                {
                 	
				  $daterandtexten = str_replace($replaceby,$placeholder,$daterange);
				  $daterangearr = explode("-",$daterandtexten);
                  $daterange2show =$daterange;
                  
					
					
					
                 $fromdatetxt =$daterangearr[0];
                  $todatetxt =$daterangearr[1];
                  
					
					
                 $fromdate = date('Y-m-d',strtotime($fromdatetxt));
                 $todate = date('Y-m-d',strtotime($todatetxt));
                  
                  
                }
                else
                {
                  $startdate = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' -14 day'));
                  
                  $daterange2show = date('j F, Y',strtotime($startdate))." - ".date('j F, Y');
					$fromdate="";
					$todate="";
                  
                  $fromdatetxt = date('Y-m-d',strtotime($startdate));
                 
                  $fromdate = date('Y-m-d',strtotime($fromdatetxt));
                  $todate = date('Y-m-d');
                }
                
					
                 $dayarray=GetDays($fromdate, $todate); 
		          ?>
            </div>
            
        <div class="col-md-9 col-sm-8 col-xs-12 account-details">
          <h3><?= $_SESSION['lan']['CustomerProfile']?></h3>
              <div class="wrapped">
                
               <form action="<?php echo $actual_link;?>" method="POST" id="frmfilter">
                  <input type="hidden" id="currenttab" name="currenttab" value="<?php echo $currenttab;?>">
                  <input type="hidden" id="daterange" name="daterange" value="">
                  <div class="input-group input-daterange pull-right" style="margin: 0 0 20px 0;">

					<?php 
					   $lan = $_SESSION['lanCode'];
					   if($lan=='' || $lan=='es')
                        {
						 $daterange2show = str_replace($placeholder,$replaceby,$daterange2show);
							
						}
					  ?>
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
$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                  $daterange = $_REQUEST['daterange'];
                if($daterange!="")
                {
                  //$daterangearr = explode("-",$daterange);
                 // $daterange2show =$daterange;
					
				  $daterandtexten = str_replace($replaceby,$placeholder,$daterange);
				  $daterangearr = explode("-",$daterandtexten);
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
               
                $dayarray=GetDays($fromdate, $todate);
                
                    
				$strquery = "AND date(Addedon) between date('$fromdate') and date('$todate')";	
                      
			    $query = "SELECT * FROM $visitor_table WHERE user_id='$userId' $strquery";
				$totalVistor = $wpdb->get_results($query);
                      
                $query = "SELECT distinct ip FROM $visitor_table WHERE user_id='$userId' $strquery";
				$totaluser1 = $wpdb->get_results($query);

				$query = "SELECT * FROM $visitor_table WHERE pagetype='search' AND user_id='$userId' $strquery";
				$bysearch = $wpdb->get_results($query); 
                      
                $query = "SELECT distinct ip FROM $visitor_table WHERE user_id='$userId' AND pagetype='search' $strquery";
				$bysearch1 = $wpdb->get_results($query);

				$query = "SELECT * FROM $visitor_table WHERE pagetype='other' AND user_id='$userId' $strquery";
				$by_qr_url = $wpdb->get_results($query);
                      
                $query = "SELECT distinct ip FROM $visitor_table WHERE user_id='$userId' AND pagetype='other' $strquery";
				$by_qr_url1 = $wpdb->get_results($query);

				$totalVistor = count($totalVistor);
				$totalVistor_user = count($totaluser1);
                      
				$bysearch = count($bysearch);
				$bysearch_user = count($bysearch1);
                      
				$by_qr_url = count($by_qr_url);
				$by_qr_url_user = count($by_qr_url1);
                      
                include('calendar-script.php');
                
                ?>
            
               <div class='row' style="margin-bottom:0px;">
                 <div class='col-sm-12' id='Countrybox2' >
					 <?php if($totalVistor==0)
							{
							echo "No data available....";
							}?>
                    <div id="piechart"  class="chartGraph <?php if($totalVistor==0){echo "hideChart";}?>" ></div>
                       
                  </div>
               </div>
               <div class='row' style="margin-bottom:0px;">
                 <div class='col-sm-12' id='Sexbox2'  style="display:none;width:100%;">
					  <?php if($bysearch==0)
							{
							echo "No data available....";
							}
					        ?>
                    <div  id="piechart2" class="chartGraph <?php if($bysearch==0){echo "hideChart";}?>" style="width:100%;"></div>
                       
                  </div>
                  </div>
                <div class='row' style="margin-bottom:0px;">
                 <div class='col-sm-12' id='Agebox2'  style="display:none;width:100%;">
					  <?php 
					 if($by_qr_url==0)
							{
							echo "No data available....";
							}
					        ?>
                    <div id="piechart3" class="chartGraph <?php if($by_qr_url==0){echo "hideChart";}?>" style="width:100%;"></div>
                   
                  </div>
                  </div>
      
            
                
	             
               
	              <div class='row' style="padding-top:10px;">
                  
                      
                       <div class='col-sm-4'>
	              		<button type="button" class='btn btn-primary activeColor fffff' id='Country'><?= $_SESSION['lan']['TOTAL']?></button>
	              </div>
	              <div class='col-sm-4'>
	              		<button type="button" class='btn btn-primary deactiveColor' id='Sex'><?= $_SESSION['lan']['BySearchEngine']?></button>
	              </div>
                <div class='col-sm-4'>
	              		<button type="button" class='btn btn-primary deactiveColor' id='Age'><?= $_SESSION['lan']['ByQRURL']?></button>
	              </div>
                      
		              <div class='col-sm-12' id='Countrybox'>
		              	
                         <div class='col-sm-4 datalist dl'>
		              		
		              	        <p class="numberOfVisitor"> <?= $_SESSION['lan']['Sessions']?></p>
                                <div class='searchCountSinglePage'><?php echo $totalVistor; ?></div>
                                
                             
		              		
			             </div>
		                
			             <div class='col-sm-4 datalist dl'>
							
                           <p class="numberOfVisitor"> <?= $_SESSION['lan']['Users']?></p>
                                <div class='searchCountSinglePage'><?php echo $totalVistor_user; ?></div>
   
			             </div>
			               
			           </div>

                  
                  <div class='col-sm-12' id='Sexbox' style="display:none;">
                    
		              	<div class='col-sm-4 datalist dl'>
							
                                 <p class="numberOfVisitor"> <?= $_SESSION['lan']['Sessions']?></p>
                                <div class='searchCountSinglePage'><?php echo $bysearch; ?></div>
                               
   
			               </div>  
                    <div class='col-sm-4 datalist dl'>
							
                            <p class="numberOfVisitor"> <?= $_SESSION['lan']['Users']?></p>
                                <div class='searchCountSinglePage'><?php echo $bysearch_user; ?></div>
   
			                 </div>
			               
			           </div>
                  
                  
                  <div class='col-sm-12' id='Agebox' style="display:none;">
		              	 
                    <div class='col-sm-4 datalist dl'>
							
                                <p class="numberOfVisitor"> <?= $_SESSION['lan']['Sessions']?></p>
                                <div class='searchCountSinglePage'><?php echo $by_qr_url; ?></div>
                                
   
			                 </div>  
                    <div class='col-sm-4 datalist dl'>
							
                        <p class="numberOfVisitor"> <?= $_SESSION['lan']['Users']?></p>
                         <div class='searchCountSinglePage'><?php echo $by_qr_url_user; ?></div>   
                        
   
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
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
				 <script type="text/javascript">
	  google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart()
      {
         var data1 = new google.visualization.arrayToDataTable([
          ['<?php echo $datemonth;?>', '<?= $_SESSION['lan']['Sessions']?>','<?= $_SESSION['lan']['Users']?>'],
          <?php 
         
          $data1Vaxis=array();
          array_push($data1Vaxis,0);
           foreach($dayarray as $key=>$singledate)
           {
               $date2show = date('j',strtotime($singledate));
               $datemonth = date('F, Y',strtotime($singledate));
               
                $singledatefil = date('Y-m-d',strtotime($singledate));
               
                $strquery_srch = "AND date(Addedon)='$singledatefil'";	
               
                $query = "SELECT * FROM $visitor_table WHERE user_id='$userId' $strquery_srch";
				        $totalVistor = $wpdb->get_results($query);
                      
                $query = "SELECT distinct ip FROM $visitor_table WHERE user_id='$userId' $strquery_srch";
				        $totaluser1 = $wpdb->get_results($query);
               
               
                $totalVistor = count($totalVistor);
				        $totalVistor_user = count($totaluser1);
			           
                if (!in_array($totalVistor,$data1Vaxis))  
                {
                   array_push($data1Vaxis,$totalVistor);
                }
			   
					   $lan = $_SESSION['lanCode'];
					   if($lan=='' || $lan=='es')
            {
						    $datemonth = str_replace($placeholder,$replaceby,$datemonth);
						}
			    
          ?>
          ['<?php echo $date2show;?>',  <?php echo $totalVistor;?>,<?php echo $totalVistor_user;?>],
        <?php
       
         }

         $datacount1 = count($data1Vaxis);
         
          if($datacount1 >=8)
         {
            $datacount1_show = 8;
         }
         else
         {
           
           $datacount1_show = $datacount1;
           $maxvalx= max($data1Vaxis);
           if($maxvalx <=8)
           {
              $datacount1_show = $maxvalx;
           }
           else
           {
             $datacount1_show = 8;
           }

         }

         ?>
        ]);

       
        var options1 = {
          title: '',
		      width:806,
		      height:200,
          hAxis: {title: '<?php echo $datemonth;?>',titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0,format: '0' , gridlines: { count: '<?php echo $datacount1_show;?>' }},
          chartArea: {left:30} 

		      
        };
          
          
        var data2 = new google.visualization.arrayToDataTable([
          ['<?php echo $datemonth;?>', '<?= $_SESSION['lan']['Sessions']?>','<?= $_SESSION['lan']['Users']?>'],
          <?php 

           $data2Vaxis=array();
           array_push($data2Vaxis,0);

           foreach($dayarray as $key=>$singledate)
           {
               $date2show = date('j',strtotime($singledate));
               $datemonth = date('F, Y',strtotime($singledate));
               
                $singledatefil = date('Y-m-d',strtotime($singledate));
               
                $strquery_srch = "AND date(Addedon)='$singledatefil'";	
               
                $query = "SELECT * FROM $visitor_table WHERE user_id='$userId' AND pagetype='search' $strquery_srch";
				$totalVistor = $wpdb->get_results($query);
                      
                $query = "SELECT distinct ip FROM $visitor_table WHERE user_id='$userId' AND pagetype='search' $strquery_srch";
				$totaluser1 = $wpdb->get_results($query);
               
               
                $totalVistor = count($totalVistor);
				        $totalVistor_user = count($totaluser1);

                if (!in_array($totalVistor,$data2Vaxis))  
                {
                   array_push($data2Vaxis,$totalVistor);
                }


			     $lan = $_SESSION['lanCode'];
					   if($lan=='' || $lan=='es')
                        {
						    $datemonth = str_replace($placeholder,$replaceby,$datemonth);

						}  $lan = $_SESSION['lanCode'];
					   if($lan=='' || $lan=='es')
                        {
						   $datemonth = str_replace($placeholder,$replaceby,$datemonth);
						}
			   
			    
          ?>
          ['<?php echo $date2show;?>',  <?php echo $totalVistor;?>,<?php echo $totalVistor_user;?>],
        <?php 
         }

         $datacount2 = count($data2Vaxis);
          if($datacount2 >=8)
         {
            $datacount2_show = 8;
         }
         else
         {
           
           $datacount2_show = $datacount2;
           $maxvalx= max($data2Vaxis);
           if($maxvalx <=8)
           {
              $datacount2_show = $maxvalx;
           }
           else
           {
             $datacount2_show = 8;
           }

         }
      ?>
        ]);

        var options2 = {
          title: '',
		  width:806,
		  height:200,
          hAxis: {title: '<?php echo $datemonth;?>',  titleTextStyle: {color: '#333'}},
		      vAxis: {minValue: 0,format: '0' , gridlines: { count: '<?php echo $datacount2_show;?>' }},
		      chartArea: {left:30} 
        };
          
        var data3 = new google.visualization.arrayToDataTable([
          ['<?php echo $datemonth;?>', '<?= $_SESSION['lan']['Sessions']?>','<?= $_SESSION['lan']['Users']?>'],
          <?php 

          $data3Vaxis=array();
          array_push($data3Vaxis,0);
         
           foreach($dayarray as $key=>$singledate)
           {
               $date2show = date('j',strtotime($singledate));
               $datemonth = date('F, Y',strtotime($singledate));
               
                $singledatefil = date('Y-m-d',strtotime($singledate));
               
                $strquery_srch = "AND date(Addedon)='$singledatefil'";	
               
                $query = "SELECT * FROM $visitor_table WHERE user_id='$userId' AND pagetype='other' $strquery_srch";
				$totalVistor = $wpdb->get_results($query);
                      
                $query = "SELECT distinct ip FROM $visitor_table WHERE user_id='$userId' AND pagetype='other' $strquery_srch";
				$totaluser1 = $wpdb->get_results($query);
               
               
                $totalVistor = count($totalVistor);
				       $totalVistor_user = count($totaluser1);



               if (!in_array($totalVistor,$data3Vaxis))  
                {
                   array_push($data3Vaxis,$totalVistor);
                }

			     $lan = $_SESSION['lanCode'];
					   if($lan=='' || $lan=='es')
              {
						    $datemonth = str_replace($placeholder,$replaceby,$datemonth);
						  }
			    
          ?>
          ['<?php echo $date2show;?>',  <?php echo $totalVistor;?>,<?php echo $totalVistor_user;?>],
        <?php 
       
          }

        $datacount3 = count($data3Vaxis);
         if($datacount3 >=8)
         {
            $datacount3_show = 8;
         }
         else
         {
           
           $datacount3_show = $datacount3;
           $maxvalx= max($data3Vaxis);
           if($maxvalx <=8)
           {
              $datacount3_show = $maxvalx;
           }
           else
           {
             $datacount3_show = 8;
           }

         }
      ?>
        ]);

        var options3 = {
          title: '',
		  width:806,
		  height:200,
          hAxis: {title: '<?php echo $datemonth;?>',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0,format: '0' , gridlines: { count: '<?php echo $datacount3_show;?>' }},
		      chartArea: {left:30} 

        };

        var chart1 = new google.visualization.AreaChart(document.getElementById('piechart'));
        chart1.draw(data1, options1);
          
        var chart2 = new google.visualization.AreaChart(document.getElementById('piechart2'));
        chart2.draw(data2, options2);
        
        var chart3 = new google.visualization.AreaChart(document.getElementById('piechart3'));
        chart3.draw(data3, options3);
          
      }
</script>
	<style>
		#Countrybox2,#Sexbox2,#Agebox2{    text-align: center;
    padding-bottom: 12px;
    font-size: 18px;}
		.hideChart{display:none;}
	</style>
