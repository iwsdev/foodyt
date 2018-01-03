<?php 
require 'config.php';
//P-1WC96861FN730923YWRHEFQI
use PayPal\Api\Agreement;
use PayPal\Api\Payer;
use PayPal\Api\Plan;
use PayPal\Api\ShippingAddress;

// Create new agreement
$agreement = new Agreement();
$agreement->setName('Base Agreement')
  ->setDescription('Basic Agreement')
  ->setStartDate('2019-06-17T9:45:04Z');

// Set plan id
$plan = new Plan();
$plan->setId('P-1WC96861FN730923YWRHEFQI');
$agreement->setPlan($plan);

// Add payer type
$payer = new Payer();
$payer->setPaymentMethod('paypal');
$agreement->setPayer($payer);

// Adding shipping details
$shippingAddress = new ShippingAddress();
$shippingAddress->setLine1('111 First Street')
  ->setCity('Saratoga')
  ->setState('CA')
  ->setPostalCode('95070')
  ->setCountryCode('US');
$agreement->setShippingAddress($shippingAddress);
try {
  // Create agreement
  $agreement = $agreement->create($apiContext);
  echo "<pre>";
  print_r($agreement);
  // Extract approval URL to redirect user
  echo $approvalUrl = $agreement->getApprovalLink();
} catch (PayPal\Exception\PayPalConnectionException $ex) {
  echo $ex->getCode();
  echo $ex->getData();
  die($ex);
} catch (Exception $ex) {
  die($ex);
}
?>
<a href="<?php echo $approvalUrl;?>">URl TO PayPAL </a>
<!--
PayPal\Api\Agreement Object
(
    [_propMap:PayPal\Common\PayPalModel:private] => Array
        (
            [name] => Base Agreement
            [description] => Basic Agreement
            [start_date] => 2019-06-17T9:45:04Z
            [plan] => PayPal\Api\Plan Object
                (
                    [_propMap:PayPal\Common\PayPalModel:private] => Array
                        (
                            [id] => P-1WC96861FN730923YWRHEFQI
                            [state] => ACTIVE
                            [name] => Montly Plan Subscription
                            [description] => Template creation.
                            [type] => FIXED
                            [payment_definitions] => Array
                                (
                                    [0] => PayPal\Api\PaymentDefinition Object
                                        (
                                            [_propMap:PayPal\Common\PayPalModel:private] => Array
                                                (
                                                    [id] => PD-98872878XP8583330WRHEFQI
                                                    [name] => Regular Payments
                                                    [type] => REGULAR
                                                    [frequency] => Month
                                                    [amount] => PayPal\Api\Currency Object
                                                        (
                                                            [_propMap:PayPal\Common\PayPalModel:private] => Array
                                                                (
                                                                    [currency] => EUR
                                                                    [value] => 74.36
                                                                )

                                                        )

                                                    [cycles] => 12
                                                    [charge_models] => Array
                                                        (
                                                        )

                                                    [frequency_interval] => 2
                                                )

                                        )

                                )

                            [merchant_preferences] => PayPal\Api\MerchantPreferences Object
                                (
                                    [_propMap:PayPal\Common\PayPalModel:private] => Array
                                        (
                                            [setup_fee] => PayPal\Api\Currency Object
                                                (
                                                    [_propMap:PayPal\Common\PayPalModel:private] => Array
                                                        (
                                                            [currency] => EUR
                                                            [value] => 1
                                                        )

                                                )

                                            [max_fail_attempts] => 0
                                            [return_url] => http://localhost/payplasdkrest/exe-aggreement.php
                                            [cancel_url] => http://localhost:3000/payplasdkrest/cancel.php
                                            [auto_bill_amount] => YES
                                            [initial_fail_amount_action] => CONTINUE
                                        )

                                )

                        )

                )

            [payer] => PayPal\Api\Payer Object
                (
                    [_propMap:PayPal\Common\PayPalModel:private] => Array
                        (
                            [payment_method] => paypal
                        )

                )

            [shipping_address] => PayPal\Api\ShippingAddress Object
                (
                    [_propMap:PayPal\Common\PayPalModel:private] => Array
                        (
                            [line1] => 111 First Street
                            [city] => Saratoga
                            [state] => CA
                            [postal_code] => 95070
                            [country_code] => US
                        )

                )

            [links] => Array
                (
                    [0] => PayPal\Api\Links Object
                        (
                            [_propMap:PayPal\Common\PayPalModel:private] => Array
                                (
                                    [href] => https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=EC-70F815386D930353S
                                    [rel] => approval_url
                                    [method] => REDIRECT
                                )

                        )

                    [1] => PayPal\Api\Links Object
                        (
                            [_propMap:PayPal\Common\PayPalModel:private] => Array
                                (
                                    [href] => https://api.sandbox.paypal.com/v1/payments/billing-agreements/EC-70F815386D930353S/agreement-execute
                                    [rel] => execute
                                    [method] => POST
                                )

                        )

                )

        )

)
https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=EC-70F815386D930353SURl TO PayPAL 
-->
