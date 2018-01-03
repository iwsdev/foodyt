<?php
/*
Template Name:offline payment thank you page
*/
session_start();
get_header();
global $wpdb;
$pid = $_REQUEST['pid'];
$photographs_by_foodyt_tram_price = $_REQUEST['photographs_by_foodyt_tram_price'];
$totalPrice = $_REQUEST['totalPrice'];
$restaurant_info_table = $wpdb->prefix."restaurant_infos";
$paymentTable = $wpdb->prefix."payment";
$result = $wpdb->get_row("SELECT user_id FROM $restaurant_info_table where page_id= $pid");
$userid = $result->user_id;
$site_url= site_url();
require_once('paypal-Rest-Api-SDK/vendor/autoload.php');
use PayPal\Api\Agreement;
use PayPal\Api\Payer;
use PayPal\Api\Plan;
use PayPal\Api\ShippingAddress;	
$api_key = "AR8EuFCqnSGPud60iXfHYLVxV98owQjQV4Ez-MfYrcyPcstRlnF-WWBolTlqQhdd644aefRxR-xtBmXt"; //Your client ID.
$password = "EKP8NHGRh8VNXkps7J0SmHUtWoCdX9Svv5izGXnxLO3L3KlXfRW-Fq8RwjwoP2WMXXgIwPnI-7nu4Ipu"; //	Your secret ID.                                                                                                                
$apiContext = new \PayPal\Rest\ApiContext(
  new \PayPal\Auth\OAuthTokenCredential(
    $api_key,
    $password
  )
);
/*-------------Start Section To create paypal payment method---------------------- */
if($_REQUEST['token']){ //Start Checking Is it is stripe payment or not
  $_SESSION['image'] = $_FILES; 
  $_SESSION['currInfo'] = $_REQUEST;
  $token = $_GET['token'];
  $agreement = new \PayPal\Api\Agreement();

		  try {
			// Execute agreement
			  $agreement->execute($token, $apiContext);
			  $agreement=json_decode($agreement);
			   $res = $wpdb->get_row("SELECT id FROM $paymentTable ORDER BY id DESC LIMIT 1");
			   $day =30;
			   $dbValue = ($res->id+1);
               $year= date('y');
               $dbValue = str_pad($dbValue, 5, "0", STR_PAD_LEFT); 
               $invoice_no= $dbValue."-".$year;
			   $currentDate = date("Y-m-d h:i:s"); 
			   $start_date = $currentDate;
			   $expiry_date = date('Y-m-d h:i:s', strtotime("+".$day."days"));
			   $agreement_id = $agreement->id;
			   $paypal_email = $agreement->payer->payer_info->email;
			   $paypal_payer_id = $agreement->payer->payer_info->payer_id;
			   $amount = 59.80;
			   $vat = get_post_meta( 167, 'vat', true); 
			   $vatAmount = (($amount*$vat)/100);
			   $totalAmount = $vatAmount+$amount;
			   $vatAmount = number_format($vatAmount ,2);
			   $totalAmount = number_format($totalAmount ,2);
			   $pid = $_SESSION['pid'];
			   $userid = $_SESSION['userId'];
			   $resPayment = $wpdb->get_row("SELECT paypal_agreement_id FROM $paymentTable where restaurant_id= $pid AND payment_by=2 AND cancel_sub=0 ORDER BY id DESC LIMIT 1");
			   $agreementId = $resPayment->paypal_agreement_id;
			   $wpdb->insert( 
					$paymentTable, 
					array( 
						'restaurant_id' => $pid, 
						'invoice_no' => $invoice_no, 
						'user_id' => $userid, 
				        'paypal_payer_id' => $paypal_payer_id, 
						'paypal_email' => $paypal_email, 
						'paypal_agreement_id' => $agreement_id, 
				        'plan_id' => $_SESSION['planId'],
						'amount' => $amount,
						'vat' => $vat,
						'vat_amount' => $vatAmount,
						'total_amount_with_vat' => $totalAmount,
						'currency' => 'eur',
						'time_interval' => 'month',
						'created_date' => $start_date,
						'start_date' => $start_date,
						'expiry_date' => $expiry_date,
						'payment_status' =>'active',
						'payment_by' => 2
						
					), 
					array( 
						'%d', 
						'%s', 
						'%d', 
						'%s', 
						'%s', 
						'%s', 
						'%s', 
						'%f',
						'%d', 
						'%f', 
						'%f',
						'%s', 
						'%s', 
						'%s', 
						'%s', 
						'%s', 
						'%s',
						'%d'
					) );
			  
			  
			 $days =30;  
			 $start_date = date('Y-m-d h:i:s');
			 $end_date = date('Y-m-d h:i:s', strtotime("+".$days."days"));
			 $photographsVal = $_SESSION['photographic'];
			 $wpdb->update( 
					$restaurant_info_table, 
					   array( 
				 		'monthly_reportPrice' => 1.0,
						'photographs_by_foodyt_tram_price' => $photographsVal,
						'total_price' => $amount,
						'plan' => $_SESSION['planId'],
						'start_date' => $start_date,
						'end_date' => $end_date,
				    'status' => 1 ), 
             array('page_id' => $pid ), 
					   array( 
				        '%f', 
				        '%f', 
				        '%f', 
				        '%s', 
						    '%s', 
						    '%s',
				        '%d'),
             array( '%d' ) 
				     );
			  
			  /* Start section to cancel current subscription if exit there*/
			       
					  if(0){
						    $agreement = new \PayPal\Api\Agreement();        
							$agreement->setId($agreementId);
							$agreementStateDescriptor = new \PayPal\Api\AgreementStateDescriptor();
							$agreementStateDescriptor->setNote("Cancel the agreement");
							try {
								$info = $agreement->cancel($agreementStateDescriptor, $apiContext);
								$cancelAgreementDetails = Agreement::get($agreement->getId(), $apiContext);                
							} catch (Exception $ex) {                  
							}
						  
							$wpdb->update( 
							$paymentTable, 
							array( 
								'cancel_sub' => 1
							 ), 
							array( 'paypal_agreement_id' => $agreementId ), 
							array( 
								'%d' 	
							),
						 array( '%s' ) 
						 );
					 }
			   
			   /* End section to cancel current subscription if exit there*/	
			   
			   unset($_SESSION['pid']);
               unset($_SESSION['userId']);
               unset($_SESSION['photographic']);
               unset($_SESSION['planId']);
               
	  			  } catch (PayPal\Exception\PayPalConnectionException $ex) {
				echo $ex->getCode();
				echo $ex->getData();
				die($ex);
			  } catch (Exception $ex) {
				die($ex);
			  }
	
	  

}

if($_REQUEST['payment_method']=='Paypal'){ //Start Checking Is it is stripe payment or not
	echo "<h3 style='text-align: center'>Please, Wait We are Redirecting to paypal.......</h3>";
	if($_REQUEST['photographs_by_foodyt_tram_price']==0)
	{$planId ="P-1MD68263W57564811X5NZTAA";}//day P-0NE89188S2750732LX4LAEUI
	else{$planId ="P-1MD68263W57564811X5NZTAA";}//month P-6MG14914PW321364MXK2Q2HI
	$photographs_by_foodyt_tram_price = $_REQUEST['photographs_by_foodyt_tram_price'];
	$_SESSION['planId'] = $planId;
	$_SESSION['pid'] = $pid;
	$_SESSION['userId'] = $userid;
	$_SESSION['photographic'] = $photographs_by_foodyt_tram_price;
  $time = date("h:i:s", strtotime('+1 hour'));
  $day =1;
  $timeze = 'T'.$time.'Z';
  $start_date = date('Y-m-d', strtotime("+".$day."days")); 
  $start_date = $start_date.$timeze;
		// Create new agreement
		$agreement = new Agreement();
		$agreement->setName('Base Agreement')
		  ->setDescription('Basic Agreement for Monthly plan, First Month free then (72.26 €)')
		  ->setStartDate($start_date);

		// Set plan id
		$plan = new Plan();
		$plan->setId($planId);
		$agreement->setPlan($plan);

		// Add payer type
		$payer = new Payer();
		$payer->setPaymentMethod('paypal');
		$agreement->setPayer($payer);

		// Adding shipping details
		$shippingAddress = new ShippingAddress();
		$shippingAddress->setLine1('Calle Leonardo da Vinci')
		  ->setCity('Sevilla')
		  ->setState('Sevilla')
		  ->setPostalCode('95112')
		  ->setCountryCode('ES');
		$agreement->setShippingAddress($shippingAddress);
		try {
		  // Create agreement
		  $agreement = $agreement->create($apiContext);
		  $agreement=json_decode($agreement);
		 // Extract approval URL to redirect user
		  $approvalUrl = $agreement->links[0]->href;
		} catch (PayPal\Exception\PayPalConnectionException $ex) {
		  echo $ex->getCode();
		  echo $ex->getData();
		  die($ex);
		} catch (Exception $ex) {
		  die($ex);
		}
	
	
	     if ($_POST['monthlyReport']!=0) {
					 $monthly_reportPrice =  $_POST['monthlyReport'];
					 $monthly_reportPriceArray = array('Monthly Report');
					 update_post_meta( $pid, 'monthly_report', serialize($monthly_reportPriceArray));
				}
		if ($_POST['photographs_by_foodyt_tram_price']!=0) {
					 $photographs_by_foodyt_tram_price =  $_POST['photographs_by_foodyt_tram_price'];
					 $photographs_byPriceArray = array('Photographs by foodyt tram');
					 update_post_meta( $pid, 'photographs_rest', serialize($photographs_byPriceArray));
				}
		echo '<script>document.location.href="'.$approvalUrl.'";</script>';
		exit;
   }
/* -----------------------End Paypal Section------------------------- */




/*-------------Start Section To create stripe payment method---------------------- */
if($_REQUEST['payment_method']=='Credit or debit Card'){ //Start Checking Is it is stripe payment or not
require_once('stripe/init.php');
stripeCredential();
	$token = $_POST['stripeToken']; 
	//$plan='plan1';
	if($_REQUEST['photographs_by_foodyt_tram_price']==0)
	{$plan ="basic30daypaid";}
	else{$plan ="photographic30daypaid";}
	//$plan='one';
	$email=$_REQUEST['email'];
	$vat = get_post_meta( 167, 'vat', true);
	if(isset($_POST['stripeToken'])){
			try{
			$customer = \Stripe\Customer::create(array(
								"description" => "New customer Created.",
								"source" => $token,
								"plan" => $plan, 
								"email" => $email,
								"tax_percent" => $vat
							  ));
				//trialing
		
				
			 if($customer->subscriptions->data[0]->status!='active'){
                          $_SESSION['pid'] = $pid;
                          $_SESSION['userId'] = $userid;
                          $_SESSION['currInfo'] = $_REQUEST;  
						  $redirecturl = site_url().'/offline-payment/?rsId='.$pid;
						  echo '<script>document.location.href="'.$redirecturl.'";</script>';
						  exit;
					 }
				  if ($customer->sources->data[0]->address_zip_check == "fail") {
					throw new Exception("zip_check_invalid");
				  } else if ($customer->sources->data[0]->address_line1_check == "fail") {
					throw new Exception("address_check_invalid");
				  } else if ($customer->sources->data[0]->cvc_check == "fail") {
					throw new Exception("cvc_check_invalid");
				  }
				  $result = "success";
			}
			catch(Stripe_CardError $e) {      
                  $error = $e->getMessage();
				  $result = "declined";
			} 
		    catch (Stripe_InvalidRequestError $e) {
				  $error = $e->getMessage();
				  $result = "declined";     
			} 
		    catch (Stripe_AuthenticationError $e) {
				  $error = $e->getMessage();
				  $result = "declined";
			} 
		   catch (Stripe_ApiConnectionError $e) {
				  $error = $e->getMessage();
				  $result = "declined";
			}
		   catch (Stripe_Error $e) {
				  $error = $e->getMessage();
				  $result = "declined";
				}
		   catch (Exception $e) {
				  $error = $e->getMessage();
				  if ($e->getMessage() == "zip_check_invalid") {
					$result = "declined";
				  } else if ($e->getMessage() == "address_check_invalid") {
					$result = "declined";
				  } else if ($e->getMessage() == "cvc_check_invalid") {
					$result = "declined";
				  } else {
					$result = "declined";
				  }     
			}
				
            $_SESSION['error'] = $error;
            if($result=='declined'){
				$_SESSION['pid'] = $pid;
				$_SESSION['userId'] = $userid;
				$_SESSION['currInfo'] = $_REQUEST; 
				$redirecturl = site_url().'/offline-payment/?rsId='.$pid;
			    echo '<script>document.location.href="'.$redirecturl.'";</script>';
			    exit;
            }
		   if($result!='declined'){
			  
			   
               $res = $wpdb->get_row("SELECT id FROM $paymentTable ORDER BY id DESC LIMIT 1");
               $dbValue = ($res->id+1);
               $year= date('y');
               $dbValue = str_pad($dbValue, 6, "0", STR_PAD_LEFT);
			   $invoice_no= $dbValue."-".$year;
			   $customer_id = $customer->subscriptions->data[0]->customer;
			   $subscription_id = $customer->subscriptions->data[0]->id;
			   $plan_id = $customer->subscriptions->data[0]->plan->id;
			   $amount = $customer->subscriptions->data[0]->plan->amount;
			   $interval = $customer->subscriptions->data[0]->plan->interval;
			   $currency = $customer->subscriptions->data[0]->plan->currency;
			   $created_date = $customer->subscriptions->data[0]->created;
			   $start_date = $customer->subscriptions->data[0]->current_period_start;
			   $expiry_date = $customer->subscriptions->data[0]->current_period_end;
			   $status = $customer->subscriptions->data[0]->status;
			   $created_date = date('Y-m-d h:i:s',$created_date);
			   $start_date = date('Y-m-d h:i:s',$start_date);
			   $expiry_date = date('Y-m-d h:i:s',$expiry_date);
               $amount = $amount/100;
			   $vat = get_post_meta( 167, 'vat', true); 
			   $vatAmount = (($amount*$vat)/100);
			   $totalAmount = $vatAmount+$amount;
			   $vatAmount = number_format($vatAmount ,2);
			   $totalAmount = number_format($totalAmount ,2);
			   update_post_meta( $pid, 'plan_type', $plan_id); 
			   	if (isset ($_POST['credit_card_number'])) {
					 $cardNumber =  $_POST['credit_card_number'];
					 $cardNumber = "PND".base64_encode($_POST['credit_card_number']);
					 update_post_meta( $pid, 'card_number', $cardNumber ); 
				}
				if (isset ($_POST['credit_card_fname'])) {
					 $cardHolderName =  $_POST['credit_card_fname'];
					 update_post_meta( $pid, 'card_holder_name', $cardHolderName ); 
				
				}
			   if (isset ($_POST['credit_card_lname'])) {
					 $cardHolderLName =  $_POST['credit_card_lname'];
					 update_post_meta( $pid, 'card_holder_lname', $cardHolderLName ); 
				
				}
			   
				if (isset ($_POST['exp_month'])) {
					 $month =  $_POST['exp_month'];
					 update_post_meta( $pid, 'month', $month ); 
				
				}
				if (isset ($_POST['exp_year'])) {
					 $year =  $_POST['exp_year'];
					 update_post_meta( $pid, 'year', $year ); 
				
				}
				if (isset ($_POST['cvc'])) {
					 $cvv =  $_POST['cvc'];
					 $cvv = "PND".base64_encode($_POST['cvc']);
					 update_post_meta( $pid, 'cvv', $cvv ); 
				
				}
				
                if ($_POST['monthlyReport']!=0) {
					 $monthly_reportPrice =  $_POST['monthlyReport'];
					 $monthly_reportPriceArray = array('Monthly Report');
					 update_post_meta( $pid, 'monthly_report', serialize($monthly_reportPriceArray));
				}
				if ($_POST['photographs_by_foodyt_tram_price']!=0) {
					 $photographs_by_foodyt_tram_price =  $_POST['photographs_by_foodyt_tram_price'];
					 $photographs_byPriceArray = array('Photographs by foodyt tram');
					 update_post_meta( $pid, 'photographs_rest', serialize($photographs_byPriceArray));
				}
			    update_post_meta( $pid, 'plan_type', $plan_id);
			   
			    $resPayment = $wpdb->get_row("SELECT subscription_id FROM $paymentTable where restaurant_id= $pid AND payment_by=1 AND cancel_sub=0 ORDER BY id DESC LIMIT 1");
				  $cancel_subId = $resPayment->subscription_id;
			  
			  	   $success = $wpdb->insert( 
					$paymentTable, 
					array( 
						'restaurant_id' => $pid, 
						'invoice_no' => $invoice_no, 
						'user_id' => $userid, 
						'customer_id' => $customer_id,
						'subscription_id' => $subscription_id,
						'plan_id' => $plan_id,
						'amount' => $amount,
						'vat' => $vat,
						'vat_amount' => $vatAmount,
						'total_amount_with_vat' => $totalAmount,
						'currency' => $currency,
						'time_interval' => $interval,
						'created_date' => $created_date,
						'start_date' => $start_date,
						'expiry_date' => $expiry_date,
						'payment_status' => $status,
						'payment_by' => 1	
					), 
					array( 
						'%d', 
						'%s', 
						'%d', 
						'%s', 
						'%s', 
						'%s', 
						'%f', 
						'%d', 
						'%f', 
						'%f', 
						'%s', 
						'%s', 
						'%s', 
						'%s', 
						'%s', 
						'%s',
						'%d'
					) );
			   
			   
			    /* Start section to cancel current subscription if exit there*/
			   if($success){
					if($resPayment){
						$subscription = \Stripe\Subscription::retrieve($cancel_subId);
						$subscription->cancel();
						  $wpdb->update( 
							$paymentTable, 
							array( 
								'cancel_sub' => 1
							 ), 
							array( 'subscription_id' => $cancel_subId ), 
							array( 
								'%d' 	
							),
						 array( '%s' ) 
						 );
					 }
			   }
			   /* End section to cancel current subscription if exit there*/
			 $days =30;  
			 $start_date = date('Y-m-d h:i:s');
			 $end_date = date('Y-m-d h:i:s', strtotime("+".$days."days"));
			 $wpdb->update( 
					$restaurant_info_table, 
					array( 
				 		'monthly_reportPrice' => 1.0,
						'photographs_by_foodyt_tram_price' => $photographs_by_foodyt_tram_price,
						'total_price' => $totalPrice,
				        'card_number' => $cardNumber,
						'card_holder_name' => $cardHolderName,
						'card_holder_lname' => $cardHolderLName,
						'month' => $month,
						'year' => $year,
						'cvv' => $cvv,
						'plan' => $plan_id,
						'start_date' => $start_date,
						'end_date' => $end_date,
				        'status' => 1
                     ), 
                    array('page_id' => $pid ), 
					array( 
				        '%f', 
				        '%f', 
				        '%f', 
				        '%s', 
						'%s', 
						'%s', 
						'%s', 
						'%s', 
						'%s', 
						'%s', 
						'%s', 
						'%s' ,
				        '%d'
					),
                 array( '%d' ) 
				);
			   
			   unset($_SESSION['pid']);
               unset($_SESSION['userId']);
               unset($_SESSION['userId']);
               unset($_SESSION['currInfo']);
			   
			}
          
      }
}//End Checking Is it is stripe payment or not
       
/*--------------Section End To create stripe payment method-------------------------------- */
        

/*------------------- Start Section To insert into user meta table Table---------------------- */
			  update_user_meta( $userid, 'ja_disable_user', 0 ); 		
/*--------------------- End Section To insert into user meta table Table---------------------- */
      
/*----------------- Start Section to send mail to client------------------- */				
 if(isset($_REQUEST['payment_method'])){
			if($_SESSION['lanCode']=='' || $_SESSION['lanCode']=='es')
			 { 
				$title = get_the_title( $pid ); 
                $admin_email = get_option( 'admin_email' );
				$to =$email;
				$subjects = "Correo de registro";
				$headers = "From: " . strip_tags($admin_email) . "\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				$messages="<html><body>
				        Estimado $title,
						<p>Su pago se ha realizado con éxito. Puede descargar sus facturas en su panel de administración.</p>
                       	<p style='margin:1px;'>Atentamente,</p>
						<img id='whiteLogo' style='width: 18%;' src='$site_url/wp-content/themes/foodyT/assets/images/foodyT-logo.png' alt=''>
	
	 		   </body>
	 		   </html>	
	          ";
				mail($to,$subjects,$messages,$headers);

                $admin_email = get_option( 'admin_email' );
				$to =$admin_email;
				$subjects = "Correo de registro";
				$headers = "From: " . strip_tags($email) . "\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				$messages="<html><body>
				     Estimado Administrador,
					<p>Un nuevo Restaurante se ha registrado en la web con los siguientes detalles.</p>

					<table style='width: 80%;border: 1px solid gray;border-collapse: collapse;'>
							
							<tr>
								<th style='border: 1px solid gray;width: 47%;'>Nombre del Restaurante: </th> 
								<td style='border: 1px solid gray;width: 51%;text-align: center;'>$title</td>
	                        </tr>
	                        <tr>
								<th style='border: 1px solid gray;width: 47%;'>Plan suscrito: </th> 
								<td style='border: 1px solid gray;width: 51%;text-align: center;'>$plan_id</td>
	                        </tr>
							<tr>
								<th style='border: 1px solid gray;width: 47%;'>Plan de Cuota: </th> 
								<td style='border: 1px solid gray;width: 51%;text-align: center;'>$amount €</td>
	                        </tr>
	                        <tr>
								<th style='border: 1px solid gray;width: 47%;'>IVA: </th> 
								<td style='border: 1px solid gray;width: 51%;text-align: center;'>$vat%</td>
	                        </tr>
	                        <tr>
								<th style='border: 1px solid gray;width: 47%;'>Total importe: </th> 
								<td style='border: 1px solid gray;width: 51%;text-align: center;'>$totalAmount €</td>
	                        </tr>
	                      
	                       
	                    </table>
	                    </table>

					<p>Por favor, haga <a href='$site_url/wp-admin'>Login</a> en el panel de administración para revisar y aprobar o rechazar al establecimiento.</p>

					<p style='margin:1px;'>Atentamente,</p>
						<img id='whiteLogo' style='width: 18%;' src='$site_url/wp-content/themes/foodyT/assets/images/foodyT-logo.png' alt=''>
				 </body>
	 		   </html>	
	          ";
				 mail($to,$subjects,$messages,$headers);
				}
				else
				{
				$title = get_the_title( $pid ); 
				$admin_email = get_option( 'admin_email' );
				$to =$email;
				$subjects = "Registration mail";
				$headers = "From: " . strip_tags($admin_email) . "\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				$messages="<html><body>
				        Dear $title,
						<p>Your payment was successful with us. You can download the invoice from your restaurant panel after login.</p>
                        <p style='margin:1px;'>Best Regards,</p>
						<img id='whiteLogo' style='width: 18%;' src='$site_url/wp-content/themes/foodyT/assets/images/foodyT-logo.png' alt=''>
	
	 		   </body>
	 		   </html>	
	          ";
				 mail($to,$subjects,$messages,$headers);

                $admin_email = get_option( 'admin_email' );
				$to =$admin_email;
				$subjects = "Registration mail:";
				$headers = "From: " . strip_tags($email) . "\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				$messages="<html><body>
				    Dear admin,
					<p>Following Restaurant has completed the offline payment - details are mentioned below:</p>

					<table style='width: 80%;border: 1px solid gray;border-collapse: collapse;'>
							
							<tr>
								<th style='border: 1px solid gray;width: 47%;'>Restaurant Name: </th> 
								<td style='border: 1px solid gray;width: 51%;text-align: center;'>$title</td>
	                        </tr>
	                        <tr>
								<th style='border: 1px solid gray;width: 47%;'>Plan Subscribed: </th> 
								<td style='border: 1px solid gray;width: 51%;text-align: center;'>$plan_id</td>
	                        </tr>
							<tr>
								<th style='border: 1px solid gray;width: 47%;'>Plan Fee: </th> 
								<td style='border: 1px solid gray;width: 51%;text-align: center;'>$amount €</td>
	                        </tr>
	                        <tr>
								<th style='border: 1px solid gray;width: 47%;'>VAT: </th> 
								<td style='border: 1px solid gray;width: 51%;text-align: center;'>$vat%</td>
	                        </tr>
	                        <tr>
								<th style='border: 1px solid gray;width: 47%;'>Total Amount: </th> 
								<td style='border: 1px solid gray;width: 51%;text-align: center;'>$totalAmount €</td>
	                        </tr>
	                        
	                       
	                    </table>

					<p>Please <a href='$site_url/wp-admin'>Login</a> to admin panel for review and take appropriate action of Approving OR Rejecting the Restaurant.</p>

					<p style='margin:1px;'>Best Regards,</p>
						<img id='whiteLogo' style='width: 18%;' src='$site_url/wp-content/themes/foodyT/assets/images/foodyT-logo.png' alt=''>
				 </body>
	 		   </html>	
	          ";
				 mail($to,$subjects,$messages,$headers);
					}
				}
	 /*----------------- End Section to send mail to Admin------------------- */

        ?>

<?php

// include("html.inc");  
if($_REQUEST['payment_method']=='Credit or debit Card' || $_REQUEST['token']){
	//unset($_SESSION['ppid']);
?>
   <section id="done-payment" class="done-payment">
	<div class="container">
		<div class="row">

		 <?php
          if($_SESSION['lanCode']=='' || $_SESSION['lanCode']=='es'){ ?>
           <div class="col-md-9 col-sm-8 col-xs-12">
				<p>Enhorabuena, pago se realizó con éxito! Por favir, acceda a su panel para aprovechar su carta digital.</p>
			</div>
           <?php } else{ ?>
         	<div class="col-md-9 col-sm-8 col-xs-12">
				<p> Congratulations, your payment was successful. Please Login to your account and use the features hasslefree.</p>
			</div>
         <?php } ?>
			
		</div>
	</div>
</section>

 <?php   }
get_footer();
?>

