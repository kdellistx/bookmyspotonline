<?php
/*********************************************************
 * Created by: Randy S. Baker
 * Created on: 20-MAY-2018
 * -------------------------------------------------------
 * Square Checkout Handoff (checkout_handoff.php)
 *********************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Initialize data arrays...
 ************************************/
$user = toObject($_SESSION['sys_user']);

/************************************
 * Set the order information...
 ************************************/
$intUserID = $user->id;
$intPropertyID = $intPropertyID;
$intSubscriptionID = $intSubscriptionID;

/************************************
 * Process the checkout handoff...
 ************************************/
$orderArray = generateOrderData($intUserID, $intPropertyID, $intSubscriptionID);
initApiClient();
$checkoutClient = new \SquareConnect\Api\CheckoutApi();
try {
  $apiResponse = $checkoutClient->createCheckout($GLOBALS['LOCATION_ID'], $orderArray);
  $checkoutUrl = $apiResponse['checkout']['checkout_page_url'];
  $checkoutID = $apiResponse['checkout']['id'];
  saveCheckoutId($orderArray, $checkoutID);
} catch (Exception $e) {
  echo "The SquareConnect\Configuration object threw an exception while calling CheckoutApi->createCheckout: ", $e->getMessage(), PHP_EOL;
  exit();
}

/************************************
 * Redirect to Square Checkout...
 ************************************/
@header("Location: {$checkoutUrl}");
?>