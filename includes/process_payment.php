<?php
/******************************************************
 * Created by: Randy S. Baker
 * Created on: 16-MAR-2016
 * ----------------------------------------------------
 * Payment Processing Script (process_payment.php)
 ******************************************************/

/************************************
 * Initialize the application...
 ************************************/
//require ('application.php');

/************************************
 * Initialize data variables...
 ************************************/
$sess_reg_data = arrayToObject($_SESSION['registration_data']);
$sess_pmt_data = arrayToObject($_SESSION['payment_data']);
// Discount code...
if (isset($sess_reg_data->discount_code) && $sess_reg_data->discount_code != '')
{
    $strDiscountCode = $sess_reg_data->discount_code;
} else {
    $strDiscountCode = '';
}

// Referral code...
if ($sess_pmt_data->referral_code != '')
{
    $isDiscount = true;
} else {
    $isDiscount = false;
}

// Can't double-apply discounts...
if ($strDiscountCode == 'KNOCK49')
{
    $isDiscount = false;
}

if (isset($sess_reg_data->account_type) && $sess_reg_data->account_type != '')
{
    switch ($sess_reg_data->account_type)
    {
        case 2:
            $strPlan = 'Workout';
            if ($isDiscount === true)
            {
                $strPlanCost = 6.99 - round(6.99 * .1, 2);
                $strPlanInitiationCost = 49.99 - round(49.99 * .1, 2);
            } else {
                $strPlanCost = 6.99;
                if ($strDiscountCode == 'KNOCK49')
                {
                    $strPlanInitiationCost = 0.00;
                } else {
                    $strPlanInitiationCost = 49.99;
                }
            }
            $strCostFrequency = '/month';
            $strTotal = $strPlanCost + $strPlanInitiationCost;
            break;
        case 3:
            $strPlan = 'Nutrition';
            if ($isDiscount === true)
            {
                $strPlanCost = 50.00 - round(50.00 * .1, 2);
                $strPlanInitiationCost = 0 - round(0 * .1, 2);
            } else {
                $strPlanCost = 50.00;
                $strPlanInitiationCost = 0.00;
            }
            $strPlanCostMembers = 25.00;
            $strCostFrequency = 'each';
            $strTotal = $strPlanCost + $strPlanInitiationCost;
            break;
        case 4:
            $strPlan = 'Complete';
            if ($isDiscount === true)
            {
                $strPlanCost = 19.99 - round(19.99 * .1, 2);
                $strPlanInitiationCost = 49.99 - round(49.99 * .1, 2);
            } else {
                $strPlanCost = 19.99;
                if ($strDiscountCode == 'KNOCK49')
                {
                    $strPlanInitiationCost = 0.00;
                } else {
                    $strPlanInitiationCost = 49.99;
                }
            }
            $strCostFrequency = '/month';
            $strTotal = $strPlanCost + $strPlanInitiationCost;
            break;
        default:
            $strPlan = 'Member';
            $strPlanCost = 0.00;
            $strPlanInitiationCost = 0.00;
            $strCostFrequency = '';
            $strTotal = $strPlanCost + $strPlanInitiationCost;
            break;
    }
} else {
    //doRedirect(BASE_URL_RSB);
}

/************************************
 * Initialize the SDK...
 ************************************/
require ('bootstrap.paypal.php');

/************************************
 * Setup the environment...
 ************************************/
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
$card = new CreditCard();
$card->setType($sess_pmt_data->cc_type)
    ->setNumber($sess_pmt_data->cc_number)
    ->setExpireMonth($sess_pmt_data->cc_expire_month)
    ->setExpireYear($sess_pmt_data->cc_expire_year)
    ->setCvv2($sess_pmt_data->cc_cvv2)
    ->setFirstName($sess_pmt_data->cc_first_name)
    ->setLastName($sess_pmt_data->cc_last_name);

$fi = new FundingInstrument();
$fi->setCreditCard($card);

$payer = new Payer();
$payer->setPaymentMethod('credit_card')->setFundingInstruments(array($fi));

$item1 = new Item();
$item1->setName($strPlan.' Plan')
    ->setDescription($strPlan.' Plan')
    ->setCurrency('USD')
    ->setQuantity(1)
    ->setTax(0)
    ->setPrice($strPlanCost);
$item2 = new Item();
$item2->setName('Initiation Fee')
    ->setDescription('Initiation Fee')
    ->setCurrency('USD')
    ->setQuantity(1)
    ->setTax(0)
    ->setPrice($strPlanInitiationCost);

$itemList = new ItemList();
$itemList->setItems(array($item1, $item2));

$details = new Details();
$details->setShipping(0)->setTax(0)->setSubtotal($strTotal);

$amount = new Amount();
$amount->setCurrency('USD')->setTotal($strTotal)->setDetails($details);

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
    echo '<p style="text-align:center;">There was an error processing your payment. Please <a href="'.BASE_URL_RSB.'payment-step-1/?plan='.strtolower($strPlan).'" title="Edit payment details" style="color:#FF0000;">edit your information</a> and try again.</p>';
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
$arrData = $_SESSION['registration_data'];
$intUserID = addUserData($arrData);

/************************************
 * Store the payment data...
 ************************************/
$arrPaymentData = $_SESSION['payment_data'];
$arrPaymentData['user_id'] = $intUserID;
$arrPaymentData['date_last_paid'] = date('m-d-Y');
addUserPaymentData($arrPaymentData);

/************************************
 * Store the transaction data...
 ************************************/
$arrTransactionData = array();
$arrTransactionData['user_id'] = $intUserID;
$arrTransactionData['payment_id'] = $strPaymentID;
$arrTransactionData['payment_status'] = $strPaymentStatus;
$arrTransactionData['amount'] = $strTotal;
addUserTransactionData($arrTransactionData);

/************************************
 * Update the paid status...
 ************************************/
updatePaidStatus($intUserID, 1);

/************************************
 * Update the member status...
 ************************************/
updateMemberStatus($intUserID, 1);

/************************************
 * Miscellaneous debugging...
 ************************************/
//echo 'Create Payment Using Credit Card<br />';
//echo 'Payment: '. $strPaymentID.'<br />';
//echo 'State: '. $strPaymentStatus.'<br />';
//echo 'Created: '. $strPaymentDate.'<br />';
//showDebug($_SESSION, '_SESSION DATA', true);

// Payment Statuses: [state]
//created; approved; failed; canceled; expired; pending
//"create_time": "2013-01-31T04:12:02Z
?>