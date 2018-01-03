<?php
header('Content-Type: application/json');
$json = file_get_contents('php://input'); 
$request = json_decode($json, true);
mail("jaisingh.iws@gmail.com","My Output","Test.$request");

?>
