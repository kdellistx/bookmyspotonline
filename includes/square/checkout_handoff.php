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
 * Set the order information...
 ************************************/
$intUserID = 1;
$intPropertyID = 2;
$intSubscriptionID = 2;

/************************************
 * Process the checkout handoff...
 ************************************/
$orderArray = generateOrderData($intUserID, $intPropertyID, $intSubscriptionID);
initApiClient();
$checkoutClient = new \SquareConnect\Api\CheckoutApi();

try {
  // Send the order array to Square Checkout...
  $apiResponse = $checkoutClient->createCheckout($GLOBALS['LOCATION_ID'], $orderArray);

  // Grab the redirect URL and checkout ID sent back...
  $checkoutUrl = $apiResponse['checkout']['checkout_page_url'];
  $checkoutID = $apiResponse['checkout']['id'];

  // HELPER FUNCTION: save the checkoutID so it can be used to confirm the transaction after payment processing...
  saveCheckoutId($orderArray, $checkoutID);
} catch (Exception $e) {
  echo "The SquareConnect\Configuration object threw an exception while calling CheckoutApi->createCheckout: ", $e->getMessage(), PHP_EOL;
  exit();
}

// Redirect the customer to Square Checkout...
//@header("Location: {$checkoutUrl}");
?>