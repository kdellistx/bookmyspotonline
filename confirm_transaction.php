<?php
/*********************************************************
 * Created by: Randy S. Baker
 * Created on: 27-MAY-2018
 * -------------------------------------------------------
 * Square Confirm Transaction (confirm_transaction.php)
 *********************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Get the Transaction ID and data...
 ************************************/
$returnedTransactionId = $_REQUEST['transactionId'];
$savedCheckoutId = getCheckoutId();
$savedOrderTotal = getOrderTotal($_SESSION['checkout_data']['order']);

/************************************
 * Initialize the data arrays...
 ************************************/
$user = toObject($_SESSION['sys_user']);
$subscription = toObject(getSubscriptionData($_SESSION['subscription_id']));
$arrSave = array();
$arrSave['user_id'] = $user->id;
$arrSave['property_id'] = $_SESSION['property_id'];
$arrSave['subscription_id'] = $subscription->id;
$arrSave['subscription_name'] = $subscription->plan;
$arrSave['subscription_level'] = $subscription->level;
$arrSave['payment_id'] = $savedCheckoutId;
$arrSave['transaction_id'] = $returnedTransactionId;
$arrSave['amount'] = number_format(($savedOrderTotal / 100), 2);

/************************************
 * Initialize the API client...
 ************************************/
initApiClient();

/************************************
 * Initialize the transaction API...
 ************************************/
$transactionsClient = new \SquareConnect\Api\TransactionsApi();

/************************************
 * Get the transaction details...
 ************************************/
try {
  $apiResponse = $transactionsClient->retrieveTransaction($GLOBALS['LOCATION_ID'], $returnedTransactionId);
  showDebug($apiResponse, 'transaction api response', false);
} catch (Exception $e) {
  echo 'The SquareConnect\Configuration object threw an exception while calling TransactionApi->retrieveTransaction: ', $e->getMessage(), PHP_EOL;
  exit;
}

/************************************
 * Verify the order information...
 ************************************/
$validTransaction = verifyTransaction($_GET, $apiResponse, $savedCheckoutId, $savedOrderTotal);
if ($validTransaction)
{
  $arrSave['payment_status'] = 'success';
  showDebug($_SESSION['checkout_data'], 'checkout data array', false);
  showDebug($_SESSION, '_session data array', false);
  /* add code to print the order confirmation or redirect to an existing confirmation page */
} else {
  /* add code to print an error message and provide contact information for follow-up */
  $arrSave['payment_status'] = 'false';
  exit;
}
showDebug($arrSave, 'save data array', false);
storeTransactionDetails($arrSave);
updatePropertySubscription( $_SESSION['property_id'], $subscription->id);
breakpoint();
?>