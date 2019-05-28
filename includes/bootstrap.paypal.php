<?php
/******************************************************
 * Created by: Randy S. Baker
 * Created on: 16-MAR-2016
 * ----------------------------------------------------
 * PayPal API Bootstrap (bootstrap.paypal.php)
 ******************************************************/

/************************************
 * Initialize the SDK...
 ************************************/
require (__DIR__.'/PayPal-PHP-SDK/autoload.php');

/************************************
 * Initialize the SDK credentials...
 ************************************/
$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        //'AUTPUum3jfWL-QLsKKcJ3BJ1xJG7oN18_RrNjZJzUxqCj--2W68PPe9e9XeTZ6d-Z_CsTlNRGK41-M60', // ClientID - Mike - Live
        //'EEa9l31rzEkOpuyFBKQcp87EU4WMr7Wc6M1MpAKHX-8X7qLldU_BheQjuXDkdVKjTKfxdcAUbwML9NOE' // ClientSecret - Mike - Live
        'AcHbksnXnOdi5ZmtJUh99bUpj82hdbEBW9soI8eeadw1pefM9g-P5WdoHkbSceUK3MRUCGAVLcWcDcl4', // ClientID - BD - SBX
        'EKjHBGiHqiLiRLogWew_5n-3UZ_VoRxGGnlcz3ragV7tUW8wNqkjVIaXdPrOQgWVMMiwY-sjEZ_MsLxQ' // ClientSecret - BD - SBX
    )
);

/************************************
 * Initialize the SDK logs...
 ************************************/
$apiContext->setConfig(
  array(
  	'mode' => 'live',
    'log.LogEnabled' => true,
    'log.FileName' => SITE_BASEPATH.'data/paypal.log',
    'log.LogLevel' => 'FINE' // ERROR / WARN / FINE
  )
);
?>