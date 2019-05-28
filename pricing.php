<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 10-MAY-2018
 * ---------------------------------------------------
 * Pricing Page (pricing.php)
 *****************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Initialize page data...
 ************************************/
$strPageName = 'pricing';
$strPageTitle = 'Subscription Plans';

/************************************
 * Initialize data arrays...
 ************************************/
$arrPlans = generateSubscriptionPlans();

/************************************
 * Check if property ID is set...
 ************************************/
if (isset($strPropertyHash) && $strPropertyHash != '')
{
    $intID = getPropertyIDFromHash($strPropertyHash);
    $property = toObject(getPropertyData($intID));
    $_SESSION['user_property_hash'] = $strPropertyHash;
    $isPropertySelected = true;
} else {
    $isPropertySelected = false;
}

/************************************
 * Include the HTML header...
 ************************************/
include ('include/header.php');
?>
    <section class="parallax-window" id="short" data-parallax="scroll" data-image-src="<?php echo BASE_URL_RSB?>img/rv_camp_003.jpg" data-natural-width="1350" data-natural-height="465">
        <div id="subheader">
            <h1>Subscription Plans</h1>
        </div>
    </section>
    <div class="container margin_60" style="margin-top:0px; padding-top:0px;">
		<h2 class="main_title"><em></em>Subscription Plans <span>Select the plan that best fits your needs</span></h2>
		<p class="lead styled" style="margin-top:0px; margin-bottom:5px;"><strong>You will need to already be <a href="<?php echo BASE_URL_RSB?>login/" style="color:#FF0000;" title="Login">logged into your account</a> in order to select a property to upgrade the subscription plan.</strong></p>
		
        <!-- BEGIN: Property Selection Alert -->
        <?php
        if (loggedIn() && !$isPropertySelected)
        {
            ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>PLEASE NOTE: </strong> It appears that you are logged in, but you have not selected a property to upgrade. Please select one from your account first.
            </div>
            <?php
        }
        ?>
        <!-- END: Property Selection Alert -->

        <!-- BEGIN: Pricing Table -->
		<div class="row">
			<!-- BEGIN: Item -->
            <div class="col-md-3 text-center">
                <div class="panel panel-success panel-pricing">
                    <div class="panel-heading">
                        <i class="fa fa-gift"></i>
                        <h3><strong>FREE</strong></h3>
                    </div>
                    <div class="panel-body text-center">
                        <p><strong>$0 / Year</strong></p>
                    </div>
                    <ul class="list-group text-center">
                        <li class="list-group-item"><i class="fa fa-check"></i> Name</li>
                        <li class="list-group-item"><i class="fa fa-check"></i> Address</li>
                        <li class="list-group-item"><i class="fa fa-check"></i> Phone Number</li>
                        <li class="list-group-item"><i class="fa fa-check"></i> Business Reviews</li>
                        <li class="list-group-item"><i class="fa fa-check"></i> Business Description</li>
                    </ul>
                    <div class="panel-footer">
                        <?php
                        if (loggedIn())
                        {
                            if ($property->subscription_id == 1)
                            {
                                ?>
                                <a class="btn btn-lg btn-block btn-success" href="javascript:void(0);" disabled>ALREADY SUBSCRIBED</a>
                                <?php
                            } else {
                                ?>
                                <a class="btn btn-lg btn-block btn-success" href="<?php echo BASE_URL_RSB . ((isset($strPropertyHash) && $strPropertyHash != '')?('purchase-subscription/'.$property->property_hash.'/1/'):('my-account/'))?>">SUBSCRIBE NOW!</a>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <!-- END: Item -->
            <!-- BEGIN: Item -->
            <div class="col-md-3 text-center">
                <div class="panel panel-danger panel-pricing">
                    <div class="panel-heading">
                        <i class="fa fa-trophy"></i>
                        <h3><strong>Gold</strong></h3>
                    </div>
                    <div class="panel-body text-center">
                        <p><strong>$49 / Year</strong></p>
                    </div>
                    <ul class="list-group text-center">
                        <li class="list-group-item"><i class="fa fa-check"></i> Free Plan +</li>
                        <li class="list-group-item"><i class="fa fa-check"></i> Email Address</li>
                        <li class="list-group-item"><i class="fa fa-check"></i> Bold Heading</li>
                        <li class="list-group-item"><i class="fa fa-check"></i> Hours / Specials</li>
                        <li class="list-group-item"><i class="fa fa-check"></i> Company Logo or One Photo </li>
                    </ul>
                    <div class="panel-footer">
                        <?php
                        if (loggedIn())
                        {
                            if ($property->subscription_id == 3)
                            {
                                ?>
                                <a class="btn btn-lg btn-block btn-danger" href="javascript:void(0);" disabled>ALREADY SUBSCRIBED</a>
                                <?php
                            } else {
                                ?>
                                <a class="btn btn-lg btn-block btn-danger" href="<?php echo BASE_URL_RSB . ((isset($strPropertyHash) && $strPropertyHash != '')?('purchase-subscription/'.$property->property_hash.'/3/'):('my-account/'))?>">SUBSCRIBE NOW!</a>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <!-- END: Item -->
            <!-- BEGIN: Item -->
            <div class="col-md-3 text-center">
                <div class="panel panel-primary panel-pricing">
                    <div class="panel-heading">
                        <i class="fa fa-diamond"></i>
                        <h3 class="white"><strong>Platinum</strong></h3>
                    </div>
                    <div class="panel-body text-center">
                        <p><strong>$99 / Year</strong></p>
                    </div>
                    <ul class="list-group text-center">
                        <li class="list-group-item"><i class="fa fa-check"></i> Gold Plan +</li>
                        <li class="list-group-item"><i class="fa fa-check"></i> Website URL</li>
                        <li class="list-group-item"><i class="fa fa-check"></i> Large Bold Heading</li>
                        <li class="list-group-item"><i class="fa fa-check"></i> Up To Five Photos</li>
                        <li class="list-group-item"><i class="fa fa-check"></i> Events / Booking / etc.</li>
                    </ul>
                    <div class="panel-footer">
                        <?php
                        if (loggedIn())
                        {
                            if ($property->subscription_id == 4)
                            {
                                ?>
                                <a class="btn btn-lg btn-block btn-primary" href="javascript:void(0);" disabled>ALREADY SUBSCRIBED</a>
                                <?php
                            } else {
                                ?>
                                <a class="btn btn-lg btn-block btn-primary" href="<?php echo BASE_URL_RSB . ((isset($strPropertyHash) && $strPropertyHash != '')?('purchase-subscription/'.$property->property_hash.'/4/'):('my-account/'))?>">SUBSCRIBE NOW!</a>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <!-- END: Item -->
            <!-- BEGIN: Item -->
            <div class="col-md-3 text-center">
                <div class="panel panel-warning panel-pricing">
                    <div class="panel-heading">
                        <i class="fa fa-bookmark"></i>
                        <h3 class="black"><strong>Banner Ads</strong></h3>
                    </div>
                    <div class="panel-body text-center">
                        <p><strong>$20 / Month</strong></p>
                    </div>
                    <ul class="list-group text-center">
                        <li class="list-group-item"><i class="fa fa-check"></i> Map Ads</li>
                        <li class="list-group-item"><i class="fa fa-check"></i> Sidebar Ads</li>
                        <li class="list-group-item"><i class="fa fa-check"></i> Great Exposure</li>
                        <li class="list-group-item"><i class="fa fa-check"></i> Increases Business Views</li>
                        <li class="list-group-item"><i class="fa fa-check"></i> Different Ad Types Available</li>
                    </ul>
                    <div class="panel-footer">
                        <?php
                        if (loggedIn())
                        {
                            ?>
                            <a class="btn btn-lg btn-block btn-warning" href="<?php echo BASE_URL_RSB . ((isset($strPropertyHash) && $strPropertyHash != '')?('my-account/'):('my-account/'))?>">SUBSCRIBE NOW!</a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <!-- END: Item -->
		</div>
		<!-- END: Pricing Table -->
        <div class="row">
            <div class="col-md-12 text-center">
                <a href="<?php echo BASE_URL_RSB?>" class="btn btn-lg btn-warning">STAY WITH CURRENT PLAN</a>
            </div>
        </div>
		<div class="divider hidden-xs"></div>
	</div>
	<!-- END: Container -->
<?php
/************************************
 * Include the HTML footer...
 ************************************/
include ('include/footer.php');
?>