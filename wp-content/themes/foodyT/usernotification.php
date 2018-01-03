<?php
global $wpdb;
$restaurant_info_table = $wpdb->prefix."restaurant_infos";
$current_user = wp_get_current_user();
$now = time(); // or your date as well
$your_date = strtotime($current_user->user_registered);
$datediff = $now - $your_date;
$res = $wpdb->get_row('SELECT * FROM ' .$restaurant_info_table.' WHERE user_id ='.$current_user->ID,ARRAY_A);

//echo $res['end_date']."</br>";
 $endDate = strtotime($res['end_date']);
 $datediff = $endDate-$now;
 //$status = $getStatus[0]['status'];
 $day = floor($datediff / (60 * 60 * 24));

$free_plan = get_post_meta($res['page_id'],'free_plan',true);
//echo "<pre>";
//print_r($free_plan);
$planType = $free_plan[0];//To get is it free plan or paid plan
if($planType!='free') {
	if ($day <=7){
		$days=1;
		$date = date($endDate, strtotime("+".$days."days"));
		$date = date('Y-m-d',$date);
	    ?>
	    <div class="alert alert-danger">
	      
	        <strong><?= $_SESSION['lan']['notification'][0]?>: </strong>: <?php echo 'Your next payment date will be '.$date.". it will be deducted automaticaly from your Account."?>
	    </div>
	<?php } 
 }
?>


