<?php
/******************************************************
 * Created by: Randy S. Baker
 * Created on: 01-MAY-2016
 * ----------------------------------------------------
 * Payment Script (process_recurring_payment.php)
 ******************************************************/

/************************************
 * Initialize the PayPal SDK...
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
 * Initialize data variables...
 ************************************/
$isDiscount = false;
$strDueDate = date('m-d-Y', strtotime(date('Y-m-d') . ' -1 month'));
$arrQueue = generateRecurringPaymentList($strDueDate);

/************************************
 * Iterate through the queue...
 ************************************/
if (!empty($arrQueue))
{
    foreach ($arrQueue as $queues)
    {
        $queue = arrayToObject($queues);
        $intUserID = $queue->user_id;
        $intPlanID = getUserPlan($queue->user_id);

        /************************************
         * Calculate plan costs...
         ************************************/
        if (isset($intPlanID) && $intPlanID != '')
        {
            switch ($intPlanID)
            {
                case 2:
                    $strPlan = 'Workout';
                    $strPlanCost = 6.99;
                    $strPlanInitiationCost = 0.00;
                    $strCostFrequency = '/month';
                    $strTotal = $strPlanCost + $strPlanInitiationCost;
                    break;
                case 3:
                    $strPlan = 'Nutrition';
                    $strPlanCost = 50.00;
                    $strPlanInitiationCost = 0.00;
                    $strPlanCostMembers = 25.00;
                    $strCostFrequency = 'each';
                    $strTotal = $strPlanCost + $strPlanInitiationCost;
                    break;
                case 4:
                    $strPlan = 'Complete';
                    $strPlanCost = 19.99;
                    $strPlanInitiationCost = 0.00;
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
            exit(1);
        }

        /************************************
         * Assemble the payment data...
         ************************************/
        $card = new CreditCard();
        $card->setType($queue->cc_type)
            ->setNumber($queue->cc_number)
            ->setExpireMonth($queue->cc_expire_month)
            ->setExpireYear($queue->cc_expire_year)
            ->setCvv2($queue->cc_cvv2)
            ->setFirstName($queue->cc_first_name)
            ->setLastName($queue->cc_last_name);

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
        //showDebug($request, 'sdk array', true);

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
        $strPaymentID = $payment->getId();
        $strPaymentStatus = $payment->getState();
        $strPaymentDate = $payment->getCreateTime();

        /************************************
         * Check the payment status...
         ************************************/
        if ($strPaymentStatus != 'approved')
        {
            echo 'There was a problem with your payment.'.CRLF;
        }

        /************************************
         * Update the payment data...
         ************************************/
        $strDatePaid = date('m-d-Y');
        updateUserPaymentData($queue->id, $strDatePaid);

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
    }
} else {
    echo 'Nothing to process...'.CRLF;
}
?>