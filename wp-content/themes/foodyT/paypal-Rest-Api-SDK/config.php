<?php 
// Autoload SDK package for composer based installations
require 'vendor/autoload.php';
$api_key = "AR8EuFCqnSGPud60iXfHYLVxV98owQjQV4Ez-MfYrcyPcstRlnF-WWBolTlqQhdd644aefRxR-xtBmXt"; //Your client ID.
$password = "EKP8NHGRh8VNXkps7J0SmHUtWoCdX9Svv5izGXnxLO3L3KlXfRW-Fq8RwjwoP2WMXXgIwPnI-7nu4Ipu"; //	Your secret ID.                                                                                                                

$apiContext = new \PayPal\Rest\ApiContext(
  new \PayPal\Auth\OAuthTokenCredential(
    $api_key,
    $password
  )
);
//echo "<pre>";
//print_r($apiContext);
?>