<?php
/*********************************************************
 * Created by: Randy S. Baker
 * Created on: 20-MAY-2018
 * -------------------------------------------------------
 * Square Test Script (charge.php)
 *********************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/////////////////////// BEGIN: SQUARE ///////////////////////////
/************************************
 * Set the order information...
 ************************************/
$intUserID = 1;
$intPropertyID = 2;
$intSubscriptionID = 2;

/************************************
 * Generate the order data array...
 ************************************/
$arrOrder = generateOrderData($intUserID, $intPropertyID, $intSubscriptionID);
showDebug($arrOrder, 'order data array', false);

/************************************
 * Process the API call...
 ************************************/
initApiClient();
$checkoutClient = new \SquareConnect\Api\CheckoutApi();
try {
  // Send the order array to Square Checkout...
  $apiResponse = $checkoutClient->createCheckout($GLOBALS['LOCATION_ID'], $arrOrder);
  $checkoutUrl = $apiResponse['checkout']['checkout_page_url'];
  $checkoutID = $apiResponse['checkout']['id'];
  saveCheckoutId($arrOrder['order']['reference_id'], $checkoutID);
} catch (Exception $e) {
  echo 'The SquareConnect\Configuration object threw an exception while calling CheckoutApi->createCheckout: ', $e->getMessage(), PHP_EOL;
  exit();
}
showDebug($apiResponse, 'checkout response object', false);
showDebug($checkoutID, 'checkout id', false);

// Redirect the customer to Square Checkout...
//@header("Location: {$checkoutUrl}");
breakpoint();

/////////////////////// END: SQUARE ///////////////////////////
/////////////////////// BEGIN: STRIPE ///////////////////////////
/************************************
 * Process the payment...
 ************************************/
/*
$token  = $_POST['stripeToken'];
$email  = $_POST['stripeEmail'];
$customer = \Stripe\Customer::create(array(
	'email' => $email,
	'source'  => $token
));

$charge = \Stripe\Charge::create(array(
	'customer' => $customer->id,
	'amount'   => 500,
	'currency' => 'usd'
));
*/

/************************************
 * Display the outpput...
 ************************************/
//echo '<h1>Successfully charged $5.00!</h1>';
//saveToLog(json_encode($_POST), 'stripe.txt');
//showDebug($_POST, '_post data array', false);

/************************************
 * Parse the data...
 ************************************/
$strData = '{
    "id": "ch_1CRXZkJJXvEzpoquRUS1rVse",
    "object": "charge",
    "amount": 3000,
    "amount_refunded": 0,
    "application": null,
    "application_fee": null,
    "balance_transaction": "txn_1CRXZlJJXvEzpoquXrAufBH8",
    "captured": true,
    "created": 1526269336,
    "currency": "usd",
    "customer": "cus_CrG5JElyByy1LT",
    "description": "2 Deer for $30.00",
    "destination": null,
    "dispute": null,
    "failure_code": null,
    "failure_message": null,
    "fraud_details": [],
    "invoice": null,
    "livemode": false,
    "metadata": [],
    "on_behalf_of": null,
    "order": null,
    "outcome": {
        "network_status": "approved_by_network",
        "reason": null,
        "risk_level": "normal",
        "seller_message": "Payment complete.",
        "type": "authorized"
    },
    "paid": true,
    "receipt_email": "network.server.143@gmail.com",
    "receipt_number": null,
    "refunded": false,
    "refunds": {
        "object": "list",
        "data": [],
        "has_more": false,
        "total_count": 0,
        "url": "\/v1\/charges\/ch_1CRXZkJJXvEzpoquRUS1rVse\/refunds"
    },
    "review": null,
    "shipping": null,
    "source": {
        "id": "card_1CRXZgJJXvEzpoquXGc7g5E6",
        "object": "card",
        "address_city": null,
        "address_country": null,
        "address_line1": null,
        "address_line1_check": null,
        "address_line2": null,
        "address_state": null,
        "address_zip": null,
        "address_zip_check": null,
        "brand": "Visa",
        "country": "US",
        "customer": "cus_CrG5JElyByy1LT",
        "cvc_check": "pass",
        "dynamic_last4": null,
        "exp_month": 9,
        "exp_year": 2018,
        "fingerprint": "sn1NeVxMoMwoUQJO",
        "funding": "credit",
        "last4": "4242",
        "metadata": [],
        "name": "network.server.143@gmail.com",
        "tokenization_method": null
    },
    "source_transfer": null,
    "statement_descriptor": null,
    "status": "succeeded",
    "transfer_group": null
}';

$arrChargeData = json_decode($strData);
showDebug($arrChargeData, 'charge object', false);

/************************************
 * Get the package data...
  ************************************/
$package_id = 2;
$package = toObject(getPackageData($package_id));
$strPackageDescription = $package->package_name .' for $' . number_format($package->package_price, 2);

/************************************
 * Store the transaction data...
 ************************************/
$user_id = 1;
$arrTransactionData = array();
$arrTransactionData['user_id'] = $user_id;
$arrTransactionData['package_id'] = $package_id;
$arrTransactionData['package_name'] = $strPackageDescription;
$arrTransactionData['package_credits'] = $package->package_tokens;
$arrTransactionData['payment_id'] = $arrChargeData->id;
$arrTransactionData['transaction_id'] = $arrChargeData->balance_transaction;
$arrTransactionData['amount'] = number_format(($arrChargeData->amount / 100), 2);
$arrTransactionData['payment_status'] = $arrChargeData->status;
//$arrTransactionData['payload'] = serialize($arrChargeData);
showDebug($arrTransactionData, 'transaction data', false);
addStripeTransactionData($arrTransactionData);

/************************************
 * Store the user data...
  ************************************/
$arrUserData = array();
$arrUserData['user_id'] = $user_id;
$arrUserData['credits'] = $package->package_tokens;
showDebug($arrUserData, 'user data', false);
addUserCredits($arrUserData);
/////////////////////// END: STRIPE ///////////////////////////

/************************************
 * Kill the script...
 ************************************/
breakpoint();
?>