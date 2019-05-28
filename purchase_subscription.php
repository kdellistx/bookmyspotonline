<?php
/********************************************************
 * Created by: Randy S. Baker
 * Created on: 17-MAY-2018
 * ------------------------------------------------------
 * Purchase Subscription Page (purchase_subscription.php)
 ********************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Initialize page data...
 ************************************/
$strPageName = 'purchase_subscription';
$strPageTitle = 'Purchase Subscription';

/************************************
 * Check if page is protected...
 ************************************/
isProtectedPage();

/************************************
 * Initialize data arrays...
 ************************************/
$user = toObject($_SESSION['sys_user']);

/************************************
 * Check if property ID is set...
 ************************************/
if (isset($strPropertyHash) && $strPropertyHash != '')
{
    $intID = getPropertyIDFromHash($strPropertyHash);
    $property = toObject(getPropertyData($intID));
    $subscription = toObject(getSubscriptionData($intSubscriptionID));
    $_SESSION['property_id'] = $intID;
    $_SESSION['subscription_id'] = $intSubscriptionID;
}

/************************************
 * Clear any stored property hash...
 ************************************/
if (isset($_SESSION['user_property_hash']) && $_SESSION['user_property_hash'] != '')
{
    unset($_SESSION['user_property_hash']);
}

/************************************
 * Include the HTML header...
 ************************************/
include ('include/header.php');
?>
    <section class="parallax-window" id="short" data-parallax="scroll" data-image-src="<?php echo BASE_URL_RSB?>img/rv_camp_003.jpg" data-natural-width="1350" data-natural-height="465">
        <div id="subheader">
            <h1>Subscription Purchase</h1>
        </div>
    </section>
    <div class="container margin_60">
		<h2 class="main_title"><em></em>Purchase <span>Your Subscription</span></h2>
        <p class="lead styled">Verify the information below and then click "Pay Now" in order to purchase your subscription.</p>
    	<div class="row">
			<div class="col-md-12">
				<h3>Your Information</h3>
				<p><?php echo $user->first_name?> <?php echo $user->last_name?></p>
				<h3>Property Information</h3>
				<p><?php echo $property->property_name?><br /><?php echo $property->property_address?><br /><?php echo $property->property_city?>, <?php echo $property->property_state?> <?php echo $property->property_zipcode?></p>
				<h3>Subscription Information</h3>
				<p><?php echo $subscription->description?> - $<?php echo number_format($subscription->price, 2)?></p>
				<p class="text-center"><a href="<?php echo BASE_URL_RSB?>checkout-handoff/?property_id=<?php echo $intID?>&subscription_id=<?php echo $intSubscriptionID?>" class="btn btn-lg btn-success">Pay Now</a></p>
			</div>
		</div>
		<!-- End row -->
 		<div class="divider hidden-xs"></div>
    </div>
    <!-- END: container -->
<?php
/************************************
 * Include the HTML footer...
 ************************************/
include ('include/footer.php');
?>