<?php 
require 'config.php';
//P-26654909WL760792MWQ6EMLY
use PayPal\Api\Agreement;
use PayPal\Api\Payer;
use PayPal\Api\Plan;
use PayPal\Api\ShippingAddress;
if (1) {
  $token = $_GET['token'];
  $agreement = new \PayPal\Api\Agreement();

  try {
    // Execute agreement
    $agreement->execute($token, $apiContext);
	echo "<pre>";
  print_r($agreement);
  } catch (PayPal\Exception\PayPalConnectionException $ex) {
    echo $ex->getCode();
    echo $ex->getData();
    die($ex);
  } catch (Exception $ex) {
    die($ex);
  }
} 
else 
{
    echo "user canceled agreement";
}
?>
<!--
PayPal\Api\Agreement Object
(
    [_propMap:PayPal\Common\PayPalModel:private] => Array
        (
            [id] => I-4T2XTGNFSWT9
            [state] => Active
            [description] => Basic Agreement
            [payer] => PayPal\Api\Payer Object
                (
                    [_propMap:PayPal\Common\PayPalModel:private] => Array
                        (
                            [payment_method] => paypal
                            [status] => verified
                            [payer_info] => PayPal\Api\PayerInfo Object
                                (
                                    [_propMap:PayPal\Common\PayPalModel:private] => Array
                                        (
                                            [email] => hargovindkanyal1382-buyer@gmail.com
                                            [first_name] => test
                                            [last_name] => buyer
                                            [payer_id] => 7J8N6T5B4Z6VY
                                            [shipping_address] => PayPal\Api\ShippingAddress Object
                                                (
                                                    [_propMap:PayPal\Common\PayPalModel:private] => Array
                                                        (
                                                            [recipient_name] => test buyer
                                                            [line1] => 111 First Street
                                                            [city] => Saratoga
                                                            [state] => CA
                                                            [postal_code] => 95070
                                                            [country_code] => US
                                                        )

                                                )

                                        )

                                )

                        )

                )

            [plan] => PayPal\Api\Plan Object
                (
                    [_propMap:PayPal\Common\PayPalModel:private] => Array
                        (
                            [payment_definitions] => Array
                                (
                                    [0] => PayPal\Api\PaymentDefinition Object
                                        (
                                            [_propMap:PayPal\Common\PayPalModel:private] => Array
                                                (
                                                    [type] => REGULAR
                                                    [frequency] => Month
                                                    [amount] => PayPal\Api\Currency Object
                                                        (
                                                            [_propMap:PayPal\Common\PayPalModel:private] => Array
                                                                (
                                                                    [value] => 74.36
                                                                )

                                                        )

                                                    [cycles] => 12
                                                    [charge_models] => Array
                                                        (
                                                            [0] => PayPal\Api\ChargeModel Object
                                                                (
                                                                    [_propMap:PayPal\Common\PayPalModel:private] => Array
                                                                        (
                                                                            [type] => TAX
                                                                            [amount] => PayPal\Api\Currency Object
                                                                                (
                                                                                    [_propMap:PayPal\Common\PayPalModel:private] => Array
                                                                                        (
                                                                                            [value] => 0.00
                                                                                        )

                                                                                )

                                                                        )

                                                                )

                                                            [1] => PayPal\Api\ChargeModel Object
                                                                (
                                                                    [_propMap:PayPal\Common\PayPalModel:private] => Array
                                                                        (
                                                                            [type] => SHIPPING
                                                                            [amount] => PayPal\Api\Currency Object
                                                                                (
                                                                                    [_propMap:PayPal\Common\PayPalModel:private] => Array
                                                                                        (
                                                                                            [value] => 0.00
                                                                                        )

                                                                                )

                                                                        )

                                                                )

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
                                                            [value] => 1.00
                                                        )

                                                )

                                            [max_fail_attempts] => 0
                                            [auto_bill_amount] => YES
                                        )

                                )

                            [links] => Array
                                (
                                )

                            [currency_code] => EUR
                        )

                )

            [links] => Array
                (
                    [0] => PayPal\Api\Links Object
                        (
                            [_propMap:PayPal\Common\PayPalModel:private] => Array
                                (
                                    [href] => https://api.sandbox.paypal.com/v1/payments/billing-agreements/I-4T2XTGNFSWT9
                                    [rel] => self
                                    [method] => GET
                                )

                        )

                )

            [start_date] => 2019-06-17T07:00:00Z
            [shipping_address] => PayPal\Api\Address Object
                (
                    [_propMap:PayPal\Common\PayPalModel:private] => Array
                        (
                            [recipient_name] => test buyer
                            [line1] => 111 First Street
                            [city] => Saratoga
                            [state] => CA
                            [postal_code] => 95070
                            [country_code] => US
                        )

                )

            [agreement_details] => PayPal\Api\AgreementDetails Object
                (
                    [_propMap:PayPal\Common\PayPalModel:private] => Array
                        (
                            [outstanding_balance] => PayPal\Api\Currency Object
                                (
                                    [_propMap:PayPal\Common\PayPalModel:private] => Array
                                        (
                                            [value] => 0.00
                                        )

                                )

                            [cycles_remaining] => 12
                            [cycles_completed] => 0
                            [next_billing_date] => 2019-06-17T10:00:00Z
                            [last_payment_date] => 2017-11-13T08:27:06Z
                            [last_payment_amount] => PayPal\Api\Currency Object
                                (
                                    [_propMap:PayPal\Common\PayPalModel:private] => Array
                                        (
                                            [value] => 1.00
                                        )

                                )

                            [final_payment_date] => 2021-04-17T10:00:00Z
                            [failed_payment_count] => 0
                        )

                )

        )

)
-->