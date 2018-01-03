<?php
 /*header('Content-Type: application/json');
 $json = file_get_contents('php://input'); 
 $request = json_decode($json, true);
 $agreementId = $request['resource']['billing_agreement_id'];
 $amount = $request['resource']['amount']['total'];
 $currency = $request['resource']['amount']['currency'];
 $eventType = $request['event_type'];*/
	/*if($eventType =="PAYMENT.SALE.PENDING" || $eventType=="PAYMENT.SALE.COMPLETED"){	
		mail("iwsdevelopers@gmail.com","My payment"," agreementId $agreementId REcurring $json");
		mail("iwsdevelopers@gmail.com","My payment"," Amount $amount Currency $currency");
	}else{
	mail("iwsdevelopers@gmail.com","My Normal","$json");
	}*/
?>
<?php
$eventType="PAYMENT.SALE.COMPLETED";
$agreementId = "I-CWAGWSUAT0EF";
if($eventType=="PAYMENT.SALE.COMPLETED"){
	
	//$con=mysqli_connect('localhost','myfoodyt','PPq72rhE','foodyt');
	$con=mysqli_connect('localhost','cmsboxco_foodyt','iws123#','cmsboxco_foodyt_db');
	$sql_ad="select * from ft_payment where paypal_agreement_id='".$agreementId."'";
	$query_ad=mysqli_query($con,$sql_ad);
	$row = mysqli_fetch_array($query_ad);	
	//echo "<pre>";print_r($row);
	
	$invoice_no = $row['invoice_no'];
	$restaurant_id = $row['restaurant_id'];
	$user_id = $row['user_id'];
	$paypal_payer_id = $row['paypal_payer_id'];
	$paypal_email = $row['paypal_email'];
	$paypal_agreement_id = $row['paypal_agreement_id'];
	$plan_id = $row['plan_id'];
	$amount = $row['amount'];
	$vat = $row['vat'];
	$vat_amount = $row['vat_amount'];
	$total_amount_with_vat = $row['total_amount_with_vat'];
	$currency = $row['currency'];
	$time_interval = $row['time_interval'];
	$created_date = date('Y-m-d');
	$start_date = date('Y-m-d');
	$expiry_date = date('Y-m-d', strtotime(' +30 day'));
	$payment_status = "activate";
	$cancel_sub = 0;
	$payment_by = 2;
	$count_entry = 1;
	$by_cronfile = 1;
	
	//update payment 
	$sql = "INSERT INTO ft_payment (invoice_no, restaurant_id, user_id,paypal_payer_id,paypal_email,paypal_agreement_id,plan_id,amount,vat,vat_amount,total_amount_with_vat,currency,time_interval,created_date,start_date,expiry_date,payment_status,cancel_sub,payment_by,count_entry,by_cronfile)VALUES ('".$invoice_no."','".$restaurant_id."','".$user_id."','".$paypal_payer_id."','".$paypal_email."','".$paypal_agreement_id."','".$plan_id."','".$amount."','".$vat."','".$vat_amount."','".$total_amount_with_vat."','".$currency."','".$time_interval."','".$created_date."','".$start_date."','".$expiry_date."','".$payment_status."','".$cancel_sub."','".$payment_by."','".$count_entry."','".$by_cronfile."')";
	$result_insert=mysqli_query($con,$sql);
	if($result_insert)
	{		
		mail("iwsdevelopers@gmail.com","FoodyT Payment Success","$json");
	}
	//update resturent 
	$rest_sql = "UPDATE ft_restaurant_infos ". "SET start_date = '".$start_date."', end_date = '".$expiry_date."' ". "WHERE  user_id = $user_id";	
	$result_update=mysqli_query($con,$rest_sql);
	if($result_update)
	{		
		mail("iwsdevelopers@gmail.com","FoodyT resturent expire day updated","$json");
	}
			
}
?>
