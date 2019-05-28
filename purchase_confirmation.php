<?php
/********************************************************
 * Created by: Randy S. Baker
 * Created on: 20-MAY-2018
 * ------------------------------------------------------
 * Purchase Confirmation Page (purchase_confirmation.php)
 ********************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Initialize page data...
 ************************************/
$strPageName = 'purchase_confirmation';
$strPageTitle = 'Purchase Confirmation';

/************************************
 * Check if page is protected...
 ************************************/
isProtectedPage();

/************************************
 * Get the Transaction...
 ************************************/
$savedCheckoutId = getCheckoutId();
$returnedTransactionId = $_REQUEST['transactionId'];
$savedOrderTotal = getOrderTotal($_SESSION['checkout_data']['order']);
$subscription = toObject(getSubscriptionData($_SESSION['subscription_id']));

/************************************
 * Initialize the data arrays...
 ************************************/
$arrSave = array();
$user = toObject($_SESSION['sys_user']);
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
} else {
  $arrSave['payment_status'] = 'false';
  exit;
}

/************************************
 * Store the transaction data...
 ************************************/
storeTransactionDetails($arrSave);
updatePropertySubscription( $_SESSION['property_id'], $subscription->id);

/************************************
 * Cleanup the data arrays...
 ************************************/
unset($_SESSION['checkout_id']);
unset($_SESSION['checkout_data']);
unset($_SESSION['subscription_id']);

/************************************
 * Include the HTML header...
 ************************************/
include ('include/header.php');
?>
    <section class="parallax-window" id="short" data-parallax="scroll" data-image-src="<?php echo BASE_URL_RSB?>img/rv_camp_003.jpg" data-natural-width="1350" data-natural-height="465">
        <div id="subheader">
            <h1>Purchase Confirmation</h1>
        </div>
    </section>
    <div class="container margin_60">
		<h2 class="main_title"><em></em>Purchase <span>Confirmation</span></h2>
        <p class="lead styled">Your purchase is complete. You can now return to your account by clicking the button below.</p>
    	<div class="row">
			<div class="col-md-12">
				<p class="text-center"><a href="<?php echo BASE_URL_RSB?>my-account/" class="btn btn-lg btn-warning">RETURN TO ACCOUNT</a></p>
			</div>
		</div>
		<!-- End row -->
 		<div class="divider hidden-xs"></div>
    </div>
    <!-- End container -->
    <div class="grid">
		<ul class="magnific-gallery" style="margin-bottom:-5px;">
				<li>
					<figure>
						<img src="<?php echo BASE_URL_RSB?>img/gallery/landmark_arch.jpg" alt="" />
						<figcaption>
						<div class="caption-content">
							<a href="<?php echo BASE_URL_RSB?>img/gallery/landmark_arch.jpg" title="Landmarks & Sight-Seeing">
								<i class="icon_set_1_icon-32"></i>
								<p>Landmarks &amp; Sight-Seeing</p>
							</a>
						</div>
						</figcaption>
					</figure>
				</li>
				<li>
					<figure>
						<img src="<?php echo BASE_URL_RSB?>img/gallery/shopping_001.jpg" alt="" />
						<figcaption>
						<div class="caption-content">
							<a href="<?php echo BASE_URL_RSB?>img/gallery/shopping_001.jpg" title="PShopping">
								<i class="icon_set_1_icon-32"></i>
								<p>Shopping</p>
							</a>
						</div>
						</figcaption>
					</figure>
				</li>
				<li>
					<figure>
						<img src="<?php echo BASE_URL_RSB?>img/gallery/restaurant_001.jpg" alt="" />
						<figcaption>
						<div class="caption-content">
							<a href="<?php echo BASE_URL_RSB?>img/gallery/restaurant_001.jpg" title="Restaurants & Dining">
								<i class="icon_set_1_icon-32"></i>
								<p>Restaurants &amp; Dining</p>
							</a>
						</div>
						</figcaption>
					</figure>
				</li>
				<li>
					<figure>
						<img src="<?php echo BASE_URL_RSB?>img/gallery/rv_camp_006.jpg" alt="" />
						<figcaption>
						<div class="caption-content">
							<a href="<?php echo BASE_URL_RSB?>img/gallery/rv_camp_006.jpg" title="RV Parks & Camps">
								<i class="icon_set_1_icon-32"></i>
								<p>RV Parks &amp; Camps</p>
							</a>
						</div>
						</figcaption>
					</figure>
				</li>
			</ul>
		</div>
<?php
/************************************
 * Include the HTML footer...
 ************************************/
include ('include/footer.php');
?>