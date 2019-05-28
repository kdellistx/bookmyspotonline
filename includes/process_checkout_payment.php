<?php
/******************************************************
 * Created by: Randy S. Baker
 * Created on: 18-MAR-2016
 * ----------------------------------------------------
 * Payment Processor (process_checkout_payment.php)
 ******************************************************/

/************************************
 * Initialize the application...
 ************************************/
//require ('application.php');

/************************************
 * Initialize data variables...
 ************************************/
$sess_reg_data = arrayToObject($_SESSION['checkout_data']);
$sess_pmt_data = arrayToObject($_SESSION['checkout_payment_data']);
$sess_cart_data = arrayToObject($_SESSION['cart_data']);

/************************************
 * Initialize the SDK...
 ************************************/
require ('bootstrap.paypal.php');

/************************************
 * Setup the environment...
 ************************************/
use PayPal\Api\Address;
use PayPal\Api\Amount;
use PayPal\Api\CreditCard;
use PayPal\Api\Details;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\Transaction;

/************************************
 * Debugging purposes...
 ************************************/
//showDebug($_SESSION, '_SESSION DATA', true);

/************************************
 * Assemble the payment data...
 ************************************/
if ($sess_cart_data->is_free_shipping == 1)
{
    $intShipping = 0;
} else {
    $intShipping = $sess_cart_data->product_shipping;
}

$addr = new Address();
$addr->setLine1($sess_reg_data->address_1)
    ->setCity($sess_reg_data->city)
    ->setCountryCode('US')
    ->setPostalCode($sess_reg_data->zip)
    ->setState($sess_reg_data->state);

$card = new CreditCard();
$card->setType($sess_pmt_data->cc_type)
    ->setNumber($sess_pmt_data->cc_number)
    ->setExpireMonth($sess_pmt_data->cc_expire_month)
    ->setExpireYear($sess_pmt_data->cc_expire_year)
    ->setCvv2($sess_pmt_data->cc_cvv2)
    ->setFirstName($sess_pmt_data->cc_first_name)
    ->setLastName($sess_pmt_data->cc_last_name)
    ->setBillingAddress($addr);

$fi = new FundingInstrument();
$fi->setCreditCard($card);

$payer = new Payer();
$payer->setPaymentMethod('credit_card')->setFundingInstruments(array($fi));

$itemList = new ItemList();
if (!empty($_SESSION['cart_data']))
{
    $cntItem = 1;
    $intSubTotal = 0;
    foreach ($_SESSION['cart_data'] as $datas)
    {
        $cart = arrayToObject($datas);
        $item_details = new Item();
        $item_details->setName($cart->product_name)
            ->setDescription($cart->product_name.' ('.$cart->product_size.')')
            ->setCurrency('USD')
            ->setQuantity($cart->product_qty)
            ->setTax(0)
            ->setPrice($cart->product_cost);
        $intSubTotal += $cart->product_cost * $cart->product_qty;
        $itemList->addItem($item_details);
    }
}

$intTotal = $intSubTotal + $intShipping;

$details = new Details();
$details->setShipping($intShipping)->setTax(0)->setSubtotal($intSubTotal);

$amount = new Amount();
$amount->setCurrency('USD')->setTotal($intTotal)->setDetails($details);

$transaction = new Transaction();
$transaction->setAmount($amount)->setItemList($itemList)->setDescription("Payment description")->setInvoiceNumber(uniqid());

$payment = new Payment();
$payment->setIntent('sale')->setPayer($payer)->setTransactions(array($transaction));

$request = clone $payment;


/************************************
 * Process the payment...
 ************************************/
try {
    $payment->create($apiContext);
} catch (Exception $ex) {
    //echo 'There was an error processing your request: '.$ex;
    echo '<html><head><title>Payment Processing Error</title></head><body><h1 style="text-align:center;">Payment Error!</h1>';
    echo '<p style="text-align:center;">There was an error processing your payment. Please <a href="'.BASE_URL_RSB.'cart/" title="Edit payment details" style="color:#FF0000;">edit your information</a> and try again.</p>';
    echo '</body></html>';
    exit(1);
}

/************************************
 * Post processing tasks...
 ************************************/
//exit;
//return $payment;
$strPaymentID = $payment->getId();
$strPaymentStatus = $payment->getState();
$strPaymentDate = $payment->getCreateTime();

/************************************
 * Check the payment status...
 ************************************/
if ($strPaymentStatus != 'approved')
{
    displayAlert('There was a problem with your payment.');
    doRedirect(BASE_URL_RSB);
}

/************************************
 * Store the registration data...
 ************************************/
$arrData = $_SESSION['checkout_data'];
$intUserID = addCheckoutUserData($arrData);

/************************************
 * Store the payment data...
 ************************************/
$arrPaymentData = $_SESSION['checkout_payment_data'];
$arrPaymentData['user_id'] = $intUserID;
$arrPaymentData['date_last_paid'] = date('m-d-Y');
addCheckoutUserPaymentData($arrPaymentData);

/************************************
 * Store the transaction data...
 ************************************/
$arrTransactionData = array();
$arrTransactionData['user_id'] = $intUserID;
$arrTransactionData['payment_id'] = $strPaymentID;
$arrTransactionData['payment_status'] = $strPaymentStatus;
$arrTransactionData['amount'] = $intTotal;
$arrTransactionData['payload'] = serialize($_SESSION['cart_data']);
addCheckoutUserTransactionData($arrTransactionData);

/************************************
 * Email the transaction data...
 ************************************/
$intSubTotal = 0;
$arrData = array();
$arrData['from_email'] = FROM_EMAIL;
$arrData['from_name'] = FROM_NAME;
$arrData['email_to'] = TO_EMAIL;
$arrData['subject'] = 'New order from your website: '. $sess_reg_data->first_name .' '. $sess_reg_data->last_name;
$arrData['txtDate'] = date('r');
$body  = "<html><body>\n"; 
$body .= "<p style='font-family:Arial, Helvetica, sans-serif; font-size:12px;'>Hey team,<br />Someone just purchased an item from your website. Here are the details:</p>\n";
$body .= "<p style='font-family:Arial, Helvetica, sans-serif; font-size:12px;'>\n";
$body .= "<table style='width:700px; border:2px solid #000000;'>\n";
$body .= "<tr><td colspan='2' style='background-color:#AAAAAA; color:#FFFFFF; font-weight:bold; textalign:center; padding-right:5px;'>ONLINE PURCHASE DETAILS</td></tr>\n";
$body .= "<tr><td style='font-weight:bold; text-align:right; padding-right:5px; vertical-align:top; width:125px;'>Name:</td><td style='padding-left:5px; text-align:left;'>".$sess_reg_data->first_name.' '.$sess_reg_data->last_name."</td></tr>";
$body .= "<tr><td style='font-weight:bold; text-align:right; padding-right:5px; vertical-align:top; width:125px;'>Address:</td><td style='padding-left:5px; text-align:left;'>".$sess_reg_data->address_1."</td></tr>";
$body .= "<tr><td style='font-weight:bold; text-align:right; padding-right:5px; vertical-align:top; width:125px;'>&nbsp;</td><td style='padding-left:5px; text-align:left;'>".$sess_reg_data->city.', '.$sess_reg_data->state.' '.$sess_reg_data->zip."</td></tr>";
$body .= "<tr><td style='font-weight:bold; text-align:right; padding-right:5px; vertical-align:top; width:125px;'>Phone:</td><td style='padding-left:5px; text-align:left;'>".$sess_reg_data->phone."</td></tr>";
$body .= "<tr><td style='font-weight:bold; text-align:right; padding-right:5px; vertical-align:top; width:125px;'>Email:</td><td style='padding-left:5px; text-align:left;'>".$sess_reg_data->email."</td></tr>";
foreach ($_SESSION['cart_data'] as $datas)
{
    $intSubTotal += $cart->product_cost * $cart->product_qty;
    $body .= "<tr><td style='font-weight:bold; text-align:right; padding-right:5px; vertical-align:top; width:125px;'>Item:</td><td style='padding-left:5px; text-align:left;'>";
    $cart = arrayToObject($datas);
    $body .= $cart->product_qty .'  '. $cart->product_name .' ('. $cart->product_size.')  @  $'. number_format($cart->product_cost, 2) .' each';
    $body .= "</td></tr>";
}
$body .= "<tr><td style='font-weight:bold; text-align:right; padding-right:5px; vertical-align:top; width:125px;'>TOTAL:</td><td style='padding-left:5px; text-align:left;'>$".number_format($intSubTotal, 2)."</td></tr>";
$body .= "</p>\n";
$body .= "</body><html>\n";
$arrData['body'] = $body;
sendShortMessage($arrData);

/************************************
 * Miscellaneous debugging...
 ************************************/
//showDebug($payment, 'payment object', true);
//echo 'Create Payment Using Credit Card<br />';
//echo 'Payment: '. $strPaymentID.'<br />';
//echo 'State: '. $strPaymentStatus.'<br />';
//echo 'Created: '. $strPaymentDate.'<br />';
//showDebug($_SESSION, '_SESSION DATA', true);

// Payment Statuses: [state]
//created; approved; failed; canceled; expired; pending
//"create_time": "2013-01-31T04:12:02Z
?>