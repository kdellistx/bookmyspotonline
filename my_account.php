<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 13-APR-2018
 * ---------------------------------------------------
 * My Account Page (my_account.php)
 *****************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Initialize page data...
 ************************************/
$strPageName = 'account_landing';
$strPageTitle = 'My Account';

/************************************
 * Check if page is protected...
 ************************************/
isProtectedPage();

/************************************
 * Initialize data arrays...
 ************************************/
$user = toObject($_SESSION['sys_user']);
$arrProperties = getUserPropertyDataList($user->id, false);
$arrMarketplaceItems = getUserMarketplaceDataList($user->id, false);
$arrTrips = generateUserDataListings($user->id, 'trip-planner');
if (!empty($arrProperties))
{
    $arrBookingProperties = array_keys($arrProperties);
    $arrBookings = generateBookings(0, true, $arrBookingProperties);
} else {
    $arrBookings = array();
}
//showDebug($arrBookingProperties, 'property id array', false);
//showDebug($arrBookings, 'booking data array', false);
//showDebug($arrProperties, 'property data array', true);

/************************************
 * Include the HTML header...
 ************************************/
include ('include/header.php');
?>
    <section class="parallax-window" id="short" data-parallax="scroll" data-image-src="<?php echo BASE_URL_RSB?>img/rv_camp_003.jpg" data-natural-width="1350" data-natural-height="465">
        <div id="subheader">
            <h1>My Account</h1>
        </div>
    </section>
    <div class="container margin_60">
        <div class="row">
            <!-- BEGIN: Account Content -->
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12">
                <!-- BEGIN: Account Overview -->
                <div class="job-details-wrapper">
                    <?php
                    /*
                    if (isset($_SESSION['user_property_hash']) && $_SESSION['user_property_hash'] != '')
                    {
                        ?>
                        <p class="text-center"><a href="<?php echo BASE_URL_RSB?>pricing/?property_hash=<?php echo $_SESSION['user_property_hash']?>" class="btn btn-lg btn-danger text-center">CONTINUE YOUR PROPERTY SUBSCRIPTION UPGRADE <i class="fa fa-arrow-right"></i></a></p>
                        <?php
                    }
                    */
                    ?>
                    <h3>Welcome Back!</h3>
                    <p>Welcome back, <?php echo $user->first_name?>. Below is a snapshot of your account. You can use the menu at the right to make changes to your account, such as update your information, change your password, or perform other tasks.</p>
                    <?php
                    if ($user->username == 'guest')
                    {
                        ?>
                        <p style="color:#FF0000; font-weight:bold;">You are using the GUEST account. You have been granted access to the system on a limited basis so that you can take a look around. <a href="<?php echo BASE_URL_RSB?>logoff/" style="color:blue;" title="Register for an account">REGISTER</a> for a member account to unlock site features.</p>
                        <?php
                    }
                    ?>
                    <form id="frmMyAccount" name="frmMyAccount" action="<?php echo BASE_URL_RSB?>edit-account/" method="post" class="form-light mt-20" role="form">
                        <input id="action" name="action" type="hidden" value="edit_account" />
                        <fieldset class="bordered-fieldset">
                        <legend>Account Information</legend>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input id="first_name" name="first_name" type="text" class="form-control" value="<?php echo $user->first_name?>" disabled readonly />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input id="last_name" name="last_name" type="text" class="form-control" value="<?php echo $user->last_name?>" disabled readonly />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input id="email" name="email" type="email" class="form-control" value="<?php echo $user->email?>" disabled readonly />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input id="user_password" name="user_password" type="password" class="form-control" value="<?php echo $user->password?>" disabled readonly />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>City</label>
                                    <input id="city" name="city" type="text" class="form-control" value="<?php echo $user->city?>" disabled readonly />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>State</label>
                                    <select disabled readonly id="state" name="state" class="form-control">
                                        <option value="0">-- Select-- </option>
                                        <?php
                                        foreach ($arrStates as $key => $val)
                                        {
                                            ?>
                                            <option value="<?php echo $key?>"<?php echo (($user->state == $key)?(' selected="selected"'):(''))?>><?php echo $val?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Zipcode</label>
                                    <input id="zipcode" name="zipcode" type="text" class="form-control" value="<?php echo $user->zipcode?>" disabled readonly />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input id="phone" name="phone" type="text" class="form-control" value="<?php echo $user->phone?>" disabled readonly />
                                </div>
                            </div>
                        </div>
                        <button <?php echo ((isGuest())?('disabled'):(''))?> id="btnSubmit" name="btnSubmit" type="submit" class="btn btn-danger pull-right">Edit Account <i class="fa fa-pencil"></i></button>
                        </fieldset>
                    </form>
                </div>
                <!-- END: Account Overview -->
               </div>
              </div>
                <!-- BEGIN: My Properties -->
                <div class="row" style="margin-top:30px;">
                    <div class="col-md-12">
                        <form id="frmManageProperties" name="frmManageProperties" action="<?php echo BASE_URL_RSB?>my-account/" method="post" class="form-light mt-20" role="form">
                            <input id="action" name="action" type="hidden" value="post_new_property_link" />
                            <fieldset class="bordered-fieldset">
                            <legend>My Properties</legend>
                            <table class="table table-hover table-condensed account-data-table">
                              <thead>
                                <tr>
                                  <th>ID</th>
                                  <th>Name</th>
                                  <th>Category</th>
                                  <th>City</th>
                                  <th>Plan</th>
                                  <th>Actions</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                if (count($arrProperties) > 0)
                                {
                                    foreach ($arrProperties as $properties)
                                    {
                                        $property = toObject($properties);
                                        ?>
                                        <tr>
                                          <td><?php echo $property->id?></td>
                                          <td><?php echo $property->property_name?></td>
                                          <td><?php echo getPropertyCategoryName($property->category_id)?></td>
                                          <td><?php echo $property->property_city?>, <?php echo $property->property_state?></td>
                                          <td><?php echo getSubscriptionPlanName($property->subscription_id)?></td>
                                          <td style="white-space:nowrap;">
                                            <button type="button" class="btn btn-xs btn-success" title="View" onclick="window.location='<?php echo BASE_URL_RSB?>view-property/<?php echo $property->id?>/<?php echo urlencode($property->property_name)?>/';"><i class="table-action-button fa fa-eye"></i></button>
                                            <button type="button" class="btn btn-xs btn-warning" title="Edit" onclick="window.location='<?php echo BASE_URL_RSB?>edit-property/<?php echo $property->id?>/<?php echo urlencode($property->property_name)?>/';"><i class="table-action-button fa fa-pencil"></i></button>
                                            <button type="button" class="btn btn-xs btn-danger" title="Remove from your account" onclick="window.location='<?php echo BASE_URL_RSB?>my-account/?action=delete_property_from_account&property_id=<?php echo $property->id?>';"><i class="table-action-button fa fa-trash"></i></button>
                                            <button <?php echo (($property->subscription_id == 4)?(''):('disabled'))?> type="button" class="btn btn-xs btn-primary" title="Add Event" onclick="window.location='<?php echo BASE_URL_RSB?>add-event/?property_id=<?php echo $property->id?>';"><i class="table-action-button fa fa-calendar"></i></button>
                                          </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <tr><td colspan="6" class="text-center">No properties exist.</td></tr>
                                    <?php
                                }
                                ?>
                              </tbody>
                            </table>
                            </fieldset>
                        </form>
                    </div>
                </div>
                <!-- END: My Properties -->
                <!-- BEGIN: My Bookings -->
                <div class="row" style="margin-top:30px;">
                    <div class="col-md-12">
                        <form id="frmManageBookings" name="frmManageBookings" action="<?php echo BASE_URL_RSB?>my-account/" method="post" class="form-light mt-20" role="form">
                            <input id="action" name="action" type="hidden" value="post_new_booking_link" />
                            <fieldset class="bordered-fieldset">
                            <legend>My Bookings</legend>
                            <table class="table table-hover table-condensed account-data-table">
                              <thead>
                                <tr>
                                  <th>ID</th>
                                  <th>Property</th>
                                  <th>Name</th>
                                  <th>Dates</th>
                                  <th>Status</th>
                                  <th>Actions</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                if (count($arrBookings) > 0)
                                {
                                    foreach ($arrBookings as $bookings)
                                    {
                                        $booking = toObject($bookings);
                                        ?>
                                        <tr>
                                          <td><?php echo $booking->id?></td>
                                          <td><?php echo getPropertyName($booking->property_id)?></td>
                                          <td><?php echo $booking->name_booking?></td>
                                          <td><?php echo $booking->dates_booking?></td>
                                          <td><?php echo $arrBookingStatus[$booking->booking_approved]?></td>
                                          <td style="white-space:nowrap;">
                                            <button type="button" class="btn btn-xs btn-success" title="View" onclick="window.location='<?php echo BASE_URL_RSB?>view-property/<?php echo $booking->id?>/<?php echo urlencode($booking->name_booking)?>/';" disabled><i class="table-action-button fa fa-eye"></i></button>
                                            <button type="button" class="btn btn-xs btn-warning" title="Edit" onclick="window.location='<?php echo BASE_URL_RSB?>edit-property/<?php echo $booking->id?>/<?php echo urlencode($booking->email_booking)?>/';" disabled><i class="table-action-button fa fa-pencil"></i></button>
                                            <button type="button" class="btn btn-xs btn-danger" title="Delete" onclick="window.location='<?php echo BASE_URL_RSB?>my-account/?action=delete_booking&booking_id=<?php echo $booking->id?>';" disabled><i class="table-action-button fa fa-trash"></i></button>
                                          </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <tr><td colspan="6" class="text-center">No bookings exist.</td></tr>
                                    <?php
                                }
                                ?>
                              </tbody>
                            </table>
                            </fieldset>
                        </form>
                    </div>
                </div>
                <!-- END: My Bookings -->

                <!-- BEGIN: My Marketplace Items -->
                <div class="row" style="margin-top:30px;">
                    <div class="col-md-12">
                        <form id="frmManageMarketplaceItems" name="frmManageMarketplaceItems" action="<?php echo BASE_URL_RSB?>my-account/" method="post" class="form-light mt-20" role="form">
                            <input id="action" name="action" type="hidden" value="post_new_marketplace_item_link" />
                            <fieldset class="bordered-fieldset">
                            <legend>My Marketplace Items</legend>
                            <table class="table table-hover table-condensed account-data-table">
                              <thead>
                                <tr>
                                  <th>ID</th>
                                  <th>Name</th>
                                  <th>Category</th>
                                  <th>City</th>
                                  <th>Price</th>
                                  <th>Actions</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                if (count($arrMarketplaceItems) > 0)
                                {
                                    foreach ($arrMarketplaceItems as $items)
                                    {
                                        $item = toObject($items);
                                        ?>
                                        <tr>
                                          <td><?php echo $item->id?></td>
                                          <td><?php echo $item->property_name?></td>
                                          <td><?php echo getMarketplaceCategoryName($item->category_id)?></td>
                                          <td><?php echo $item->property_city?>, <?php echo $item->property_state?></td>
                                          <td>$<?php echo number_format($item->property_price, 2)?></td>
                                          <td style="white-space:nowrap;">
                                            <button type="button" class="btn btn-xs btn-success" title="View" onclick="window.location='<?php echo BASE_URL_RSB?>view-marketplace-item/<?php echo $item->id?>/<?php echo urlencode($item->property_name)?>/';"><i class="table-action-button fa fa-eye"></i></button>
                                            <button type="button" class="btn btn-xs btn-warning" title="Edit" onclick="window.location='<?php echo BASE_URL_RSB?>edit-marketplace-item/<?php echo $item->id?>/<?php echo urlencode($item->property_name)?>/';"><i class="table-action-button fa fa-pencil"></i></button>
                                            <button type="button" class="btn btn-xs btn-danger" title="Remove from your account" onclick="window.location='<?php echo BASE_URL_RSB?>my-account/?action=delete_marketplace_item_from_account&marketplace_item_id=<?php echo $item->id?>';"><i class="table-action-button fa fa-trash"></i></button>
                                          </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <tr><td colspan="6" class="text-center">No items exist.</td></tr>
                                    <?php
                                }
                                ?>
                              </tbody>
                            </table>
                            </fieldset>
                        </form>
                    </div>
                </div>
                <!-- END: My Marketplace Items -->
                <!-- BEGIN: My Trip Items -->
                <div class="row" style="margin-top:30px;">
                    <div class="col-md-12">
                        <form id="frmManagePlannedTrips" name="frmManagePlannedTrips" action="<?php echo BASE_URL_RSB?>my-account/" method="post" class="form-light mt-20" role="form">
                            <input id="action" name="action" type="hidden" value="post_new_planned_trip_link" />
                            <fieldset class="bordered-fieldset">
                            <legend>My Planned Trips</legend>
                            <table class="table table-hover table-condensed account-data-table">
                              <thead>
                                <tr>
                                  <th>ID</th>
                                  <th>From</th>
                                  <th>To</th>
                                  <th>Updated</th>
                                  <th>Actions</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                if (count($arrTrips) > 0)
                                {
                                    foreach ($arrTrips as $trips)
                                    {
                                        $trip = toObject($trips);
                                        $tmpLocation = unserialize($trip->data_content);
                                        $trip->trip_begin = $tmpLocation['trip_begin'];
                                        $trip->trip_end = $tmpLocation['trip_end'];
                                        $trip->trip_action = $tmpLocation['trip_action'];
                                        ?>
                                        <tr>
                                          <td><?php echo $trip->id?></td>
                                          <td><?php echo $trip->trip_begin?></td>
                                          <td><?php echo $trip->trip_end?></td>
                                          <td><?php echo date('m-d-Y h:i a', $trip->updated)?></td>
                                          <td style="white-space:nowrap;">
                                            <button type="button" class="btn btn-xs btn-success" title="View" onclick="window.open('<?php echo BASE_URL_RSB?>trip-planner/?action=<?php echo $trip->trip_action?>&trip_begin=<?php echo $trip->trip_begin?>&trip_end=<?php echo $trip->trip_end?>');"><i class="table-action-button fa fa-eye"></i></button>
                                            <button type="button" class="btn btn-xs btn-danger" title="Remove from your account" onclick="window.location='<?php echo BASE_URL_RSB?>my-account/?action=delete_trip_item_from_account&trip_id=<?php echo $trip->id?>';"><i class="table-action-button fa fa-trash"></i></button>
                                          </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <tr><td colspan="5" class="text-center">No planned trips exist.</td></tr>
                                    <?php
                                }
                                ?>
                              </tbody>
                            </table>
                            </fieldset>
                        </form>
                    </div>
                </div>
                <!-- END: My Marketplace Items -->
            </div>
            <!-- END: Account Content -->
            <!-- BEGIN: Sidebar -->
            <div class="col-md-4 sidebar">
                <div class="theiaStickySidebar">
                    <div class="box_style_3">
                        <?php
                        /************************************
                         * Include the account sidebar...
                         ************************************/
                        include ('include/my_account_sidebar.php');
                        ?>
                    </div>
                    <div class="box_style_2 text-center">
                        <a href="<?php echo BASE_URL_RSB?>add-property/" class="btn btn-lg btn-success" title="Click here to add a new property, site, or business"><i class="fa fa-normal fa-home" style="font-size:20px;"></i> Add Property, Site, or Business</a>
                    </div>
                    <div class="box_style_2 text-center">
                        <a href="<?php echo BASE_URL_RSB_WIZARD?>ad/" class="btn btn-lg btn-primary" title="Click here to create an advertisement"><i class="fa fa-normal fa-bullhorn" style="font-size:20px;"></i> Create An Advertisement</a>
                    </div>
                    <div class="box_style_2">
                        <i class="icon_set_1_icon-90"></i>
                        <h4>Need help? Call us!</h4>
                        <a href="tel://2146999132" class="phone">(214) 699-9132</a>
                        <small>Monday to Friday 8:00am - 5:00pm</small>
                    </div>
                </div>
            </div>
            <!-- END: Sidebar -->
        </div>
        <!-- End Row -->
    </div>
    <!-- End container -->
<?php
/************************************
 * Include the HTML footer...
 ************************************/
include ('include/footer.php');
?>