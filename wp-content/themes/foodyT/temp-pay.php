<?php
/*
Template Name:pay stripe
*/

global $wpdb;
$paymentTable = $wpdb->prefix."payment";
$restaurant_info_table = $wpdb->prefix."restaurant_infos";
require_once('stripe/init.php');
stripeCredential();
	
  $input = @file_get_contents("php://input");
  $event_json = json_decode($input);
  http_response_code(200); // PHP 5.4 or greater
  //if(1)
  if(!empty($event_json))
      {
        $event_id = $event_json->id;
        //$event_id = 'evt_1BLs3uEKQWHBOIZmeRo9vB90';
        $event = \Stripe\Event::retrieve($event_id);
        $event=explode("Stripe\Event JSON:",$event);
        $event= json_decode($event[1]);
      
           /* $admin_email = 'FoodyT <foodyT@gmail.com>';
            $subjects = "Stripe Payment jai";
            $headers = "From: " . strip_tags($admin_email) . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
            $messages="<html><body>
                Dear  v2kapilshrma,
                <p>$event Happy mode On here.</p>
                <p style='margin:1px;'>Best Regards,</p>
                <img id='whiteLogo' src='http://cmsbox.in/wordpress/foodyTv2/wp-content/themes/foodyT/assets/images/logo.png' alt=''>
               </body>
             </html>	
                ";
             mail('jaisingh.iws@gmail.com',$subjects,$messages,$headers); */
        $sub_id=$event->data->object->lines->data[0]->id;  
        $plan_id=$event->data->object->lines->data[0]->plan->id;  
        $amount=$event->data->object->lines->data[0]->plan->amount;
        $proration=$event->data->object->lines->data[0]->proration;
        $interval=$event->data->object->lines->data[0]->plan->interval;
        $trial_period_days=$event->data->object->lines->data[0]->plan->trial_period_days;
        $currency=$event->data->object->lines->data[0]->plan->currency;
        $createdDate=$event->data->object->lines->data[0]->plan->created;
        $start=$event->data->object->lines->data[0]->period->start;
        
        $created_date = date('Y-m-d',$createdDate);
        $start_date = date('Y-m-d',$start);
        $end=$event->data->object->lines->data[0]->period->end;
        $expiry_date = date('Y-m-d',$end);
        $customerjson = \Stripe\Customer::retrieve( $event->data->object->customer);
        $customerjson1 = explode('Stripe\Customer JSON:',$customerjson);  
        $customer= json_decode($customerjson1[1]);
        $customer_id=$customer->id;
        $email=$customer->email;
        $amount = $amount/100;
        if($event->type=='invoice.payment_succeeded' && $proration==0)
        {
          
          // Invoice details
              try 
              { 
              $invocedetails_json = Stripe\Invoice::retrieve( $event->data->object->id);
              $invocedetails=explode("Stripe\Invoice JSON:",$invocedetails_json);
              $invocedetails= json_decode($invocedetails[1]);
              }
              catch (Exception $e)
              { //while an error has occured
              echo "==> Error: ".$e->getMessage();
              } 
            $getInfo = $wpdb->get_row("SELECT * from $paymentTable where customer_id='$customer_id' ORDER BY id DESC");
            $resId = $getInfo->restaurant_id;
            $userId = $getInfo->user_id;
            $count = $getInfo->count_entry;
            $created_date = $getInfo->created_date;
            $created_time = strtotime($created_date);
            $created_day = date('d',$created_time);
            $currentDay = date('d');
            $res = $wpdb->get_row("SELECT id FROM $paymentTable ORDER BY id DESC LIMIT 1");
            $dbValue = ($res->id+1);
            $year= date('y');
            $dbValue = str_pad($dbValue, 6, "0", STR_PAD_LEFT); 
            $invoice_no= $dbValue."-".$year;
            if($count==2){
                    $wpdb->insert( 
                    $paymentTable, 
                    array( 
                      'restaurant_id' => $resId,
                      'invoice_no' => $invoice_no, 
                      'user_id' => $userId, 
                      'customer_id' => $customer_id,
                      'subscription_id' => $sub_id,
                      'plan_id' => $plan_id,
                      'amount' => $amount,
                      'currency' => $currency,
                      'time_interval' => $interval,
                      'start_date' => $start_date,
                      'expiry_date' => $expiry_date,
                      'payment_status' => 'active',
                      'payment_by' => 1,
                      'count_entry' => 2,
                      'by_cronfile' => 1
                    ), 
                    array( 
                      '%d', 
                      '%s', 
                      '%d', 
                      '%s', 
                      '%s', 
                      '%s', 
                      '%f', 
                      '%s', 
                      '%s', 
                      '%s', 
                      '%s', 
                      '%s',
                      '%d',
                      '%d',
                      '%d'
                    ) );
			 
                    $start_date = date('Y-m-d h:i:s');
                    $end_date = date('Y-m-d h:i:s', strtotime("+".$trial_period_days."days"));
                    $wpdb->update( 
                    $restaurant_info_table, 
                    array( 
                      'plan' => $plan_id,
                      'start_date' => $start_date,
                      'end_date' => $end_date
                      ), 
                    array( 'page_id' => $resId ), 
                    array( 
                      '%s', 
                      '%s', 
                      '%s' 	
                    ),
                    array( '%d' ) 
                  );
			   
              $admin_email = 'FoodyT <foodyT@gmail.com>'; 
              $subjects = "Stripe Payment Successfull";
              $headers = "From: " . strip_tags($admin_email) . "\r\n";
              $headers .= "MIME-Version: 1.0\r\n";
              $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
              $messages="<html><body>
                  Dear $email,
                  <p>v1 Your payment has successfully done recurring after one day. </p>
                  <p style='margin:1px;'>Best Regards,</p>
                  <img id='whiteLogo' src='http://cmsbox.in/wordpress/foodyTv2/wp-content/themes/foodyT/assets/images/logo.png' alt=''>
                 </body>
               </html>	
                  ";
               mail('jaisingh2189@gmail.com',$subjects,$messages,$headers);  
                   }
                else{
                     $wpdb->update( 
                     $paymentTable, 
                     array( 
                      'count_entry' => 2, 
                       ), 
                     array('customer_id' => $customer_id ), 
                     array( 
                      '%d'
                     ),
                    array( '%s' ) 
                  );

                 }
        }
        else if($event->type=='invoice.payment_failed')
        {
          $admin_email = 'FoodyT <foodyT@gmail.com>';
          $subjects = "Stripe Payment Fail";
          $headers = "From: " . strip_tags($admin_email) . "\r\n";
          $headers .= "MIME-Version: 1.0\r\n";
          $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
          $messages="<html><body>
              Dear $email,
              <p>v2 Your Recurring payment has been failed.</p>
              <p style='margin:1px;'>Best Regards,</p>
              <img id='whiteLogo' src='http://cmsbox.in/wordpress/foodyTv2/wp-content/themes/foodyT/assets/images/logo.png' alt=''>
             </body>
           </html>	
              ";
          $getInfo = $wpdb->get_row("SELECT * from $paymentTable where customer_id='$customer_id'");
          $resId = $getInfo->restaurant_id;
          $wpdb->update( 
					$restaurant_info_table, 
					array( 
						'status' => 0, 
          ), 
          array( 'page_id' => $resId ), 
					array( 
						'%d'
          ),
          array( '%d' ) 
				);
         mail($email,$subjects,$messages,$headers);  

        }
   }
?>
