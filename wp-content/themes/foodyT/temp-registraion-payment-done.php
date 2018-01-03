<?php
/*
Template Name:Payment Done page
*/
session_start();
get_header();
require_once('paypal-Rest-Api-SDK/vendor/autoload.php');
use PayPal\Api\Agreement;
use PayPal\Api\Payer;
use PayPal\Api\Plan;
use PayPal\Api\ShippingAddress;	
//echo "<pre>";
//print_r($_REQUEST);
//print_r($_FILES);
//print_r($_SESSION['image']);
//$_FILES = $_SESSION['image'];
//print_r($_SESSION['currInfo']);
//get pay price for payment start
/*$photograph = $_REQUEST['photograph'];
$mainprice = $_REQUEST['mainPrice'];
$totalPrice = $_REQUEST['totalPrice'];

if($_REQUEST['photograph']){
     $finalprices = $photograph+$mainprice;
     $finalprice = number_format($finalprices ,2);
}else{
     $finalprices = $mainprice;
     $finalprice = number_format($finalprices ,2);
}
*/
$date = date('Y-m-d', strtotime(' +1 day'));
$finaldate = $date."T9:45:04Z";
$totalPrice = $_REQUEST['totalPrice'];
//get pay price for payment end
global $wpdb;
$userTable = $wpdb->prefix."users";
$restaurant_info_table = $wpdb->prefix."restaurant_infos";
$paymentTable = $wpdb->prefix."payment";
$site_url= site_url();
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
			   //$amount = 59.80;
			   //get final price from resturent table start
			   $result = $wpdb->get_row("SELECT * FROM $restaurant_info_table where user_id = '".$_SESSION['uid']."'");
			   $finalprice = $result->main_price+$result->photographs_by_foodyt_tram_price;
			   $amount = $finalprice;
			   //get final price from resturent table end
			   $vat = get_post_meta( 167, 'vat', true); 
			   $vatAmount = (($amount*$vat)/100);
			   $totalAmount = $vatAmount+$amount;
			   $vatAmount = number_format($vatAmount ,2);
			   $totalAmount = number_format($totalAmount ,2);
			   $pid = $_SESSION['ppid'];
			   $userid = $_SESSION['uid'];
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
						'payment_status' =>'trialing',
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
               unset($_SESSION['pid']);
               unset($_SESSION['planId']);
               unset($_SESSION['uid']);
               unset($_SESSION['userId']);
               unset($_SESSION['currInfo']);
               unset($_SESSION['image']);  
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
    insertData();
	if($_REQUEST['photographs_by_foodyt_tram_price']==0)
	{$planId ="P-8WC471717G3970112XJR74AQ";}//day
	else{$planId ="P-8BE63550WL419980RXGOVNCA";}//month
	$_SESSION['planId'] = $planId;
		// Create new agreement
		$agreement = new Agreement();
		$agreement->setName('Base Agreement')
		  ->setDescription('Basic Agreement for Montly plan, First Month free then ('.$totalPrice.' €)')
		  ->setStartDate('2018-01-03T9:45:04Z');

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
		echo '<script>document.location.href="'.$approvalUrl.'";</script>';
		exit;
   }
/* -----------------------End Paypal Section------------------------- */



/*-------------Start Section To create stripe payment method---------------------- */
if($_REQUEST['payment_method']=='Credit or debit Card'){ //Start Checking Is it is stripe payment or not
$_SESSION['image'] = $_FILES; 
$_SESSION['currInfo'] = $_REQUEST;
	
insertData();
require_once('stripe/init.php');
stripeCredential();
	$token = $_POST['stripeToken']; 
	//$plan='plan1';
	if($_REQUEST['photographs_by_foodyt_tram_price']==0)
	{$plan ="basic30";}
	else{$plan ="photographic30";}
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
				
			 if($customer->subscriptions->data[0]->status!='trialing'){
                          $_SESSION['pid'] = $pid;
                          $_SESSION['userId'] = $userid;
                          $_SESSION['currInfo'] = $_REQUEST;  
                          $_SESSION['image'] = $_FILES;  
						  $redirecturl = site_url().'/create-digital-menu/';
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
           // echo "<pre>";
			//print_r($_SESSION['currInfo']);
			//print_r($_SESSION['image']);
			//echo "<br>pid".$_SESSION['pid'];
			//echo "<br>ppid".$_SESSION['ppid'];
			//echo "<br>uid".$_SESSION['uid'];
			//die;
             
             $redirecturl = site_url().'/create-digital-menu/';
			 echo '<script>document.location.href="'.$redirecturl.'";</script>';
			 exit;
            }
		   if($result!='declined'){
               $res = $wpdb->get_row("SELECT id FROM $paymentTable ORDER BY id DESC LIMIT 1");
                $dbValue = ($res->id+1);
               $year= date('y');
               $dbValue = str_pad($dbValue, 6, "0", STR_PAD_LEFT);
			   $pid = $_SESSION['pid'];
			   $userid = $_SESSION['uid'];
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
			   $vat = get_post_meta( 167, 'vat', true); 
			  	    $wpdb->insert( 
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
			 $days =30;  
			 $start_date = date('Y-m-d h:i:s');
			 $end_date = date('Y-m-d h:i:s', strtotime("+".$days."days"));
             $wpdb->update( 
					$restaurant_info_table, 
					array( 
						'plan' => $start_date,
						'plan' => $plan_id,
						'start_date' => $start_date,
						'end_date' => $end_date
                     ), 
                    array( 'page_id' => $pid ), 
					array( 
						'%s', 
						'%s', 
						'%s', 
						'%s' 	
					),
                 array( '%d' ) 
				);
			   
               unset($_SESSION['pid']);
               unset($_SESSION['uid']);
               unset($_SESSION['userId']);
               unset($_SESSION['currInfo']);
               unset($_SESSION['image']);
			}
          
      }
}//End Checking Is it is stripe payment or not
       
/*--------------Section End To create stripe payment method-------------------------------- */
        
/*---------------------  Section Start To insert into custom post and custom post meta  ------------------ */
 function insertData(){
	$exists = email_exists($_REQUEST['email']);
    if($_SESSION['userId']){
           $exists = 0;
           $userid = $_SESSION['userId'];
           $pid = $_SESSION['pid'];
           $email = $_SESSION['email'];
           //wp_delete_post( $postid, $force_delete );
          // $wpdb->delete( $restaurant_info_table, array( 'user_id' => $userid ), array( '%d' ) );
        }

    if($exists){
		//echo $_SESSION['userId'];
    	$setEmailExit =1;

    }else{
	       if(isset($_REQUEST['restaurantName'])){

			  if (isset ($_POST['restaurantName'])) {
					 $title =  $_POST['restaurantName'];
				}
				if (isset ($_POST['restaurantDescription'])) {
					 $content =  $_POST['restaurantDescription'];
				}
				$new_post = array(
				'post_title'	=>	$title,
				'post_content'	=>	$content,
				'post_status'	=>	'publish',           // Choose: publish, preview, future, draft, etc.
				'post_type'	=>	'restaurant'  //'post',page' or use a custom post type if you want to
				);

             $my_post = array(
                  'ID'           => $pid,
                  'post_title'   => $title,
                  'post_content' => $content,
			  );
               
			   
              // Update the post into the database
               if($_SESSION['userId']){
                 wp_update_post( $my_post );
               }else{
			     $pid = wp_insert_post($new_post);
               }
              //SAVE THE POST
               if(!$_SESSION['userId']){
                    if ($_FILES) {
                        $i=0;
                        foreach ($_FILES as $file => $array) {
                         $newupload = insert_attachment($file,$pid);
                         if($i==0)
                         update_post_meta( $pid, 'logo_image', $newupload );
                         else 
                         update_post_meta( $pid, 'banner_image', $newupload );
                         $i++;
                        // $newupload returns the attachment id of the file that
                        // was just uploaded. Do whatever you want with that now.
                        }
                     }
               }else
               {      
                      if (!empty($_FILES['fileupload']['name'])) {
                           $logo=1;
                            foreach ($_FILES as $file => $array) {
                                if($logo==1){
                                     $newupload = insert_attachment($file,$pid);
                                     update_post_meta( $pid, 'logo_image', $newupload );
                                       }
                                     $logo++;
                                    }
                                 }


                      if (!empty($_FILES['bannerImage']['name'])) {
                          $banner=1;
                             foreach ($_FILES as $file => $array) {
                                 if($banner==2){
                                    $newupload1 = insert_attachment($file,$pid);
                                    update_post_meta( $pid, 'banner_image', $newupload1 );
                                     }   $banner++;
                                }
                            }
                 
               }
               if (isset ($_POST['address'])) {
					 $address =  $_POST['address'];
					 update_post_meta( $pid, 'address', $address ); 
				
				}
				if (isset ($_POST['language'])) {
					 $language =  $_POST['language'];
					 $languageData = implode(',', $language);
					 update_post_meta( $pid, 'language_rest', $languageData); 
				
				}
				
				if (isset ($_POST['cuisine'])) {
					 $cuisine =  $_POST['cuisine'];
					 $cuisineData = implode(',', $cuisine);
					 update_post_meta( $pid, 'cusine', $cuisineData ); 
					 
				
				}
				if (isset ($_POST['email'])) {
					 $email =  $_POST['email'];
					 update_post_meta( $pid, 'email', $email ); 
				}
				 $latLong = getLatLong($address);
				 $latitude = $latLong['latitude']?$latLong['latitude']:'Not found';
				 $longitude = $latLong['longitude']?$latLong['longitude']:'Not found';
				 update_post_meta( $pid, 'latitude', $latitude ); 
			     update_post_meta( $pid, 'longitude', $longitude ); 
			
				if (isset ($_POST['mobileNumber'])) {
					 $mobileNumber =  $_POST['mobileNumber'];
					 update_post_meta( $pid, 'mobilenumber', $mobileNumber ); 
				} 
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
				if (isset ($_POST['billingAddress'])) {
					 $billingAddress =  $_POST['billingAddress'];
					 update_post_meta( $pid, 'billing_address', $billingAddress ); 
				
				}
				if (isset ($_POST['city'])) {
					 $city =  $_POST['city'];
					 update_post_meta( $pid, 'city', $city ); 
				
				}
				if (isset ($_POST['state'])) {
					 $state =  $_POST['state'];
					 update_post_meta( $pid, 'state', $state ); 
				
				}
				if (isset ($_POST['postalCode'])) {
					 $postalCode =  $_POST['postalCode'];
					 update_post_meta( $pid, 'postal_code', $postalCode ); 
				
				}
				if (isset ($_POST['totalPrice'])) {
					 $totalPrice =  $_POST['totalPrice'];
					 update_post_meta( $pid, 'total_price', $totalPrice ); 
				}

				if (isset ($_POST['mainPrice'])) {
					 $mainPrice =  $_POST['mainPrice'];
					
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
				 $_SESSION['pid'] = $pid;
				 $_SESSION['ppid'] = $pid;

				
			} 
	}
            if(!$_SESSION['userId']){
			do_action('wp_insert_post', 'wp_insert_post');
            }

/*-----------  Section End To insert into custom post and custom post meta  ----------------------------- */



/*------------------- Start Section To insert into wp_user Table---------------------- */
			 global $wpdb;
		     if(!$_SESSION['userId']){
              if(isset($_REQUEST['restaurantName'])){
               function random_password( $length = 6 ) {
				    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
				    $password = substr( str_shuffle( $chars ), 0, $length );
				    return $password;
				}
				    // $get_user = explode('@', $email);
				    $userName = $email;
				    $date = date("Y-m-d h-i-s");
				    $pass = random_password(6);
				    $password = md5($pass);
				    $userTable = $wpdb->prefix."users";
					$userTable;
					$wpdb->insert( 
					$userTable, 
					array( 
						'user_login' => $userName, 
						'user_pass' => $password,
						'user_nicename' => $userName,
						'user_email' => $email,
						'user_registered' => $date,
						'display_name' => $userName,
						'pass' => $pass
						), 
					array( 
						'%s', 
						'%s', 
						'%s', 
						'%s', 
						'%s', 
						'%s',
						'%s'
					) 
				);
					$userid = $wpdb->insert_id;
					
					$_SESSION['uid'] = $userid;
					
					 update_user_meta( $userid, 'nickname', $userName ); 
					 update_user_meta( $userid, 'ja_disable_user', 1 ); 
					 wp_update_user( array( 'ID' => $userid, 'role' => 'subscriber' ) );
			}
          }
/*--------------------- End Section To insert into wp_user Table---------------------- */

/*----------------- Start Section To insert into wp_resturant Table------------------- */
	   
    
	
       if(!$_SESSION['userId']){
        if(isset($_REQUEST['restaurantName'])){
		 $restaurant_info_table = $wpdb->prefix."restaurant_infos";

                 $wpdb->insert( 
					$restaurant_info_table, 
					array( 
						'user_id' => $userid, 
						'restaurant_name' => $title,
						'address' => $address,
						'language' => $languageData,
						'cuisine' => $cuisineData,
						'mobile_number' => $mobileNumber,
						'card_number' => $cardNumber,
						'card_holder_name' => $cardHolderName,
						'card_holder_lname' => $cardHolderLName,
						'month' => $month,
						'year' => $year,
						'cvv' => $cvv,
						'billing_address' => $billingAddress,
						'city' => $city,
						'state' => $state,
						'postal_code' => $postalCode,
						'main_price' => $mainPrice,
						'monthly_reportPrice' => $monthly_reportPrice,
						'photographs_by_foodyt_tram_price' => $photographs_by_foodyt_tram_price,
						'total_price' => $totalPrice,
						'latitude' => $latitude,
						'longitude' => $longitude,
						'page_id' => $pid
						), 
					array( 
						'%d', 
						'%s', 
						'%s', 
						'%s', 
						'%s', 
						'%s', 
						'%s', 
						'%s', 
					    '%s', 
						'%s', 
						'%s', 
						'%s', 
						'%s', 
						'%s', 
						'%s', 
						'%s', 
						'%f', 
						'%f', 
						'%f', 
						'%f', 
						'%f', 
						'%f', 
						'%d'
					) 
				);
			$_SESSION['userId'] = $userid;
            }	
		}
        else
        {
			 $restaurant_info_table = $wpdb->prefix."restaurant_infos";

             $wpdb->update( 
					$restaurant_info_table, 
					array( 
						'user_id' => $userid, 
						'restaurant_name' => $title,
						'address' => $address,
						'language' => $languageData,
						'cuisine' => $cuisineData,
						'mobile_number' => $mobileNumber,
						'card_number' => $cardNumber,
						'card_holder_name' => $cardHolderName,
						'card_holder_lname' => $cardHolderLName,
						'month' => $month,
						'year' => $year,
						'cvv' => $cvv,
						'billing_address' => $billingAddress,
						'city' => $city,
						'state' => $state,
						'postal_code' => $postalCode,
						'main_price' => $mainPrice,
						'monthly_reportPrice' => $monthly_reportPrice,
						'photographs_by_foodyt_tram_price' => $photographs_by_foodyt_tram_price,
						'total_price' => $totalPrice,
						'latitude' => $latitude,
						'longitude' => $longitude,
						'page_id' => $pid
						), 
                    array( 'user_id' => $userid ), 
					array( 
						'%d', 
						'%s', 
						'%s', 
						'%s', 
						'%s', 
						'%s', 
						'%s', 
						'%s', 
						'%s', 
						'%s', 
						'%s', 
						'%s', 
						'%s', 
						'%s', 
						'%s', 
						'%s', 
						'%f', 
						'%f', 
						'%f', 
						'%f', 
						'%f', 
						'%f', 
						'%d'
					) ,
                 array( '%d' ) 
				);
			$_SESSION['userId'] = $userid;
        }
	 

/*----------------- End Section To insert into wp_resturant Table------------------- */


        
/*----------------- Start Section to send mail to client------------------- */				
 if(isset($_REQUEST['restaurantName'])){
     $site_url= site_url();
	 if($_SESSION['lanCode']=='' || $_SESSION['lanCode']=='es')
			 { 
                $admin_email = get_option( 'admin_email' );
				$to =$email;
				$subjects = "Correo de registro";
				$headers = "From: " . strip_tags($admin_email) . "\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				$messages="<html><body>
				        Estimado $title,
						<p>Se ha registrado satisfactoriamente en Foodyt.</p>

						<p>Su cuenta y detalles están bajo revisión y será notificado una vez que sea aprobada.</p>

						<p style='margin:1px;'>Muchas gracias por confiar en nosotros,</p>
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
								<th style='border: 1px solid gray;width: 47%;'>Usuario: </th>
								<td style='border: 1px solid gray;width: 51%;text-align: center;'>$userName </td>
							</tr>
							<tr>
								<th style='border: 1px solid gray;width: 47%;'>Nombre del Establecimiento: </th> 
								<td style='border: 1px solid gray;width: 51%;text-align: center;'>$title</td>
	                        </tr>
	                        <tr>
								<th style='border: 1px solid gray;width: 47%;'>Descripción del Restaurante: </th> 
								<td style='border: 1px solid gray;width: 51%;text-align: center;'>$content</td>
	                        </tr>
							<tr>
								<th style='border: 1px solid gray;width: 47%;'>Dirección: </th> 
								<td style='border: 1px solid gray;width: 51%;text-align: center;'>$address</td>
	                        </tr>
	                        <tr>
								<th style='border: 1px solid gray;width: 47%;'>Idiomas: </th> 
								<td style='border: 1px solid gray;width: 51%;text-align: center;'>$languageData</td>
	                        </tr>
	                        <tr>
								<th style='border: 1px solid gray;width: 47%;'>Tipo de Cocina: </th> 
								<td style='border: 1px solid gray;width: 51%;text-align: center;'>$cuisineData</td>
	                        </tr>
	                        <tr>
								<th style='border: 1px solid gray;width: 47%;'>Número de Teléfono: </th> 
								<td style='border: 1px solid gray;width: 51%;text-align: center;'>$mobileNumber</td>
	                        </tr>
	                       
	                    </table>

					<p>Por favor, haga <a href='$site_url/wp-admin'>Login</a> en el panel de administración para revisar y aprobar o rechazar al establecimiento.</p>

					<p style='margin:1px;'>Muchas gracias por confiar en nosotros,</p>
						<img id='whiteLogo' style='width: 18%;' src='$site_url/wp-content/themes/foodyT/assets/images/foodyT-logo.png' alt=''>
				 </body>
	 		   </html>	
	          ";
				 mail($to,$subjects,$messages,$headers);
				}
				else
				{
				$admin_email = get_option( 'admin_email' );
				$to =$email;
				$subjects = "Registration mail";
				$headers = "From: " . strip_tags($admin_email) . "\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				$messages="<html><body>
				        Dear $title,
						<p>Your registration is successfull at FoodyT Team.</p>

						<p>Your account & details are under review and you will be notified once they are approved from the admin.</p>

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
					<p>A new  Restaurant has been registered on the website using below details.</p>

					<table style='width: 80%;border: 1px solid gray;border-collapse: collapse;'>
							<tr>
								<th style='border: 1px solid gray;width: 47%;'>User Name: </th>
								<td style='border: 1px solid gray;width: 51%;text-align: center;'>$userName </td>
							</tr>
							<tr>
								<th style='border: 1px solid gray;width: 47%;'>Restaurant Name: </th> 
								<td style='border: 1px solid gray;width: 51%;text-align: center;'>$title</td>
	                        </tr>
	                        <tr>
								<th style='border: 1px solid gray;width: 47%;'>Restaurant Description: </th> 
								<td style='border: 1px solid gray;width: 51%;text-align: center;'>$content</td>
	                        </tr>
							<tr>
								<th style='border: 1px solid gray;width: 47%;'>Address: </th> 
								<td style='border: 1px solid gray;width: 51%;text-align: center;'>$address</td>
	                        </tr>
	                        <tr>
								<th style='border: 1px solid gray;width: 47%;'>Language Add: </th> 
								<td style='border: 1px solid gray;width: 51%;text-align: center;'>$languageData</td>
	                        </tr>
	                        <tr>
								<th style='border: 1px solid gray;width: 47%;'>Cuisine Data: </th> 
								<td style='border: 1px solid gray;width: 51%;text-align: center;'>$cuisineData</td>
	                        </tr>
	                        <tr>
								<th style='border: 1px solid gray;width: 47%;'>Mobile Number: </th> 
								<td style='border: 1px solid gray;width: 51%;text-align: center;'>$mobileNumber</td>
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
		} // Function close of insertData		
	 /*----------------- End Section to send mail to Admin------------------- */

        ?>

<?php
class QRGenerator { 
    protected $size; 
    protected $data; 
    protected $encoding; 
    protected $errorCorrectionLevel; 
    protected $marginInRows; 
    protected $debug; 
     
    public function __construct($data='http://www.phpgang.com',$size='300',$encoding='UTF-8',$errorCorrectionLevel='L',$marginInRows=4,$debug=false) { 
         
        $this->data=urlencode($data); 
        $this->size=($size>100 && $size<800)? $size : 300; 
        $this->encoding=($encoding == 'Shift_JIS' || $encoding == 'ISO-8859-1' || $encoding == 'UTF-8') ? $encoding : 'UTF-8'; 
        $this->errorCorrectionLevel=($errorCorrectionLevel == 'L' || $errorCorrectionLevel == 'M' || $errorCorrectionLevel == 'Q' || $errorCorrectionLevel == 'H') ?  $errorCorrectionLevel : 'L';
        $this->marginInRows=($marginInRows>0 && $marginInRows<10) ? $marginInRows:4; 
        $this->debug = ($debug==true)? true:false;     
    } 
    public function generate(){ 
         
        $QRLink = "https://chart.googleapis.com/chart?cht=qr&chs=".$this->size."x".$this->size.                 
                   "&chl=" . $this->data .  
                   "&choe=" . $this->encoding . 
                   "&chld=" . $this->errorCorrectionLevel . "|" . $this->marginInRows; 
        if ($this->debug) echo   $QRLink;          
        return $QRLink; 
    } 

}
if($_SESSION['ppid']){
$pageId=$_SESSION['ppid'];
	$pid = $pageId;
}
$_REQUEST['id']=$pid;
$pid = $_REQUEST['id'];
$url = get_the_permalink($pid);
$ex2 = new QRGenerator($url,250); 
$content = "<img id='getScanner' src=".$ex2->generate().">"; 
// include("html.inc");  
if($_REQUEST['payment_method']=='Credit or debit Card' || $pageId){
	//unset($_SESSION['ppid']);
?>

   <section id="done-payment" class="done-payment">
	<div class="container">
		<div class="row">

		 <?php
          if($_SESSION['lanCode']=='' || $_SESSION['lanCode']=='es'){ ?>
           <div class="col-md-9 col-sm-8 col-xs-12">
			<h3>¡Enhorabuena!</h3>
				<p>¡En días podrá disfrutar de su Carta Digital en <?php the_permalink($pid); ?>. Le acabamos de enviar un email para completar el registro.</p>
			</div>
           <?php } else{ ?>
         	<div class="col-md-9 col-sm-8 col-xs-12">
				<h3>Congratulations!</h3>
				<p>In 2 days you will be able to enjoy your digital card at <?php the_permalink($pid); ?> We have sent you an email to complete the registration. .</p>
			</div>
         <?php } ?>
			
			
			<div class="col-md-3 col-sm-4 col-xs-12 text-center">
				<figure>
					
				   <?php print_r($content); ?>
				      
				</figure>
				<div class="download-btn">
				<a href="" id='scannerId' target='_blank' download='true'><?= $_SESSION['lan']['download']?></a>

					
				</div>
			<div>
		</div>
	</div>
</section>

 <?php 
	  }

if($setEmailExit==1){ ?>
 <section id="done-payment" class="done-payment">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<p style='color:red;text-align: center;'><?= $_SESSION['lan']['error_registration']['email_exit']?>.</p>
			</div>
		
</section><?php 
}

get_footer();
?>
<script type="text/javascript">
	$(document).ready(function(){
        $('#scannerId').click(function(){
        	var srcInfo = $('#getScanner').attr('src');
        	$('#scannerId').attr('href',srcInfo);
        });
	});
</script>
