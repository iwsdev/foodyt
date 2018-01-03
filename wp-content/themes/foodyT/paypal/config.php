<?php

  //start session in all pages
  if (session_status() == PHP_SESSION_NONE) { session_start(); } //PHP >= 5.4.0
  //if(session_id() == '') { session_start(); } //uncomment this line if PHP < 5.4.0 and comment out line above

	// sandbox or live
	define('PPL_MODE', 'sandbox');

	if(PPL_MODE=='sandbox'){
		
	    define('PPL_API_USER','hargovindkanyal1382-facilitator_api1.gmail.com');
		define('PPL_API_PASSWORD', '49PS4Q3F59SC7RY3');
		define('PPL_API_SIGNATURE', 'AFcWxV21C7fd0v3bYYYRCpSSRl31AJra5o0Rzur7G5lyKuJP9z1XTOnZ');
	}
	else{
		
		define('PPL_API_USER', 'somepaypal_api.yahoo.co.uk');
		define('PPL_API_PASSWORD', '123456789');
		define('PPL_API_SIGNATURE', 'opupouopupo987kkkhkixlksjewNyJ2pEq.Gufar');
	}
	
	define('PPL_LANG', 'EN');
	
	define('PPL_LOGO_IMG', 'https://www.sandbox.paypal.com/en_GB/i/logo/paypal_logo.gif');
	
	define('PPL_RETURN_URL', 'http://cmsbox.in/wordpress/foodyTv2/thank-you');
	define('PPL_CANCEL_URL', 'http://cmsbox.in/wordpress/foodyTv2/create-digital-menu/');

	define('PPL_CURRENCY_CODE', 'EUR');
