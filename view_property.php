<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 10-MAY-2018
 * ---------------------------------------------------
 * View Property Page (view_property.php)
 *****************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Initialize page data...
 ************************************/
$strPageName = 'view_property';
$strPageTitle = 'View Property Information';

/************************************
 * Check if page is protected...
 ************************************/
isProtectedPage();

/************************************
 * Initialize data arrays...
 ************************************/
$user = toObject($_SESSION['sys_user']);
$arrProperty = getPropertyData($intPropertyID);
$property = toObject($arrProperty);
$arrCategories = generatePropertyCategories();
$arrEvents = generatePropertyEvents($property->id);

/************************************
 * Include the HTML header...
 ************************************/
include ('include/header.php');
?>
    <section class="parallax-window" id="short" data-parallax="scroll" data-image-src="<?php echo BASE_URL_RSB?>img/rv_camp_003.jpg" data-natural-width="1350" data-natural-height="465">
        <div id="subheader">
            <h1>View Property</h1>
        </div>
    </section>
    <div class="container margin_60">
        <div class="row">
            <!-- BEGIN: Property Content -->
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN: Property Overview -->
                        <div class="job-details-wrapper">
                            <h3>View Property Details</h3>
                            <p>Hey, <?php echo $user->first_name?>, below is a snapshot of the property. You can use the menu at the right to make changes to your account, such as update your information, change your password, or perform other tasks.</p>
                            <form id="frmViewProperty" name="frmViewProperty" action="<?php echo BASE_URL_RSB?>edit-property/<?php echo $property->id?>/<?php echo urlencode($property->property_name)?>/" method="post" class="form-light mt-20" role="form">
                                <input id="action" name="action" type="hidden" value="edit_property_information" />
                                <fieldset class="bordered-fieldset">
                                <legend>Property Information</legend>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Property Name</label>
                                            <input disabled readonly id="property_name" name="property_name" type="text" class="form-control" value="<?php echo $property->property_name?>" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Category</label>
                                            <select disabled readonly id="category_id" name="category_id" class="form-control">
                                                <option value="0">-- Select-- </option>
                                                <?php
                                                foreach ($arrCategories as $categories)
                                                {
                                                    $category = toObject($categories);
                                                    ?>
                                                    <option value="<?php echo $category->id?>"<?php echo (($property->category_id == $category->id)?(' selected="selected"'):(''))?>><?php echo $category->category?></option>
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
                                            <label>Address</label>
                                            <input disabled readonly id="property_address" name="property_address" type="text" class="form-control" value="<?php echo $property->property_address?>" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>City</label>
                                            <input disabled readonly id="property_city" name="property_city" type="text" class="form-control" value="<?php echo $property->property_city?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>State</label>
                                            <select disabled readonly id="property_state" name="property_state" class="form-control">
                                                <option value="0">-- Select-- </option>
                                                <?php
                                                foreach ($arrStates as $key => $val)
                                                {
                                                    ?>
                                                    <option value="<?php echo $key?>"<?php echo (($property->property_state == $key)?(' selected="selected"'):(''))?>><?php echo $val?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Zipcode</label>
                                            <input disabled readonly id="property_zipcode" name="property_zipcode" type="text" class="form-control" value="<?php echo $property->property_zipcode?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Phone</label>
                                            <input disabled readonly id="property_phone" name="property_phone" type="text" class="form-control" value="<?php echo $property->property_phone?>" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Website</label>
                                            <input disabled readonly id="property_website" name="property_website" type="text" class="form-control" value="<?php echo $property->property_website?>"  />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Rental Rate</label>
                                            <input disabled readonly id="property_price" name="property_price" type="text" class="form-control" value="<?php echo number_format($property->property_price, 2)?>" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Subscription Plan</label>
                                            <input id="subcription_id" name="subcription_id" type="text" class="form-control" value="<?php echo getSubscriptionPlanName($property->subscription_id)?>" disabled readonly />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Notes</label>
                                            <textarea disabled readonly id="property_notes" name="property_notes" class="form-control" rows="2"><?php echo $property->property_notes?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <!-- ORIGINAL FORM BUTTONS-->
                        </div>
                        <!-- END: Property Overview -->
                    </div>
                </div>
                <!-- BEGIN: Property Highlights -->
                <div class="row">
                    <div class="col-md-12">
                        <h3>Property Highlights</h3>
                        <div class="form-group">
                            <?php echo (($property->property_highlight == '')?('(none)'):($property->property_highlight))?>
                        </div>
                    </div>
                </div>
                <!-- END: Property Highlights -->
                <!-- BEGIN: Property Description -->
                <div class="row">
                    <div class="col-md-12">
                        <h3>Property Description</h3>
                        <div class="form-group">
                            <?php echo (($property->property_description == '')?('(none)'):($property->property_description))?>
                        </div>
                    </div>
                </div>
                <!-- END: Property Description -->
                <!-- BEGIN: Property Images -->
                <div class="row" style="margin-bottom:25px;">
                    <div class="col-md-12">
                        <h3>Property Images</h3>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-2">
                                    <a data-fancybox="gallery" href="<?php echo PROPERTY_IMAGE_PATH.(($property->image_main != '')?($property->image_main):('no_image.jpg'))?>"><img src="<?php echo PROPERTY_IMAGE_PATH.(($property->image_main != '')?($property->image_main):('no_image.jpg'))?>" class="img-responsive img-rounded preview-thumbnail" alt="image" /></a>
                                    <br />
                                    Main Image
                                </div>
                                <div class="col-md-2">
                                    <a data-fancybox="gallery" href="<?php echo PROPERTY_IMAGE_PATH.(($property->image_1 != '')?($property->image_1):('no_image.jpg'))?>"><img src="<?php echo PROPERTY_IMAGE_PATH.(($property->image_1 != '')?($property->image_1):('no_image.jpg'))?>" class="img-responsive img-rounded preview-thumbnail" alt="image" /></a>
                                    <br />
                                    Image 1
                                </div>
                                <div class="col-md-2">
                                    <a data-fancybox="gallery" href="<?php echo PROPERTY_IMAGE_PATH.(($property->image_2 != '')?($property->image_2):('no_image.jpg'))?>"><img src="<?php echo PROPERTY_IMAGE_PATH.(($property->image_2 != '')?($property->image_2):('no_image.jpg'))?>" class="img-responsive img-rounded preview-thumbnail" alt="image" /></a>
                                    <br />
                                    Image 2
                                </div>
                                <div class="col-md-2">
                                    <a data-fancybox="gallery" href="<?php echo PROPERTY_IMAGE_PATH.(($property->image_3 != '')?($property->image_3):('no_image.jpg'))?>"><img src="<?php echo PROPERTY_IMAGE_PATH.(($property->image_3 != '')?($property->image_3):('no_image.jpg'))?>" class="img-responsive img-rounded preview-thumbnail" alt="image" /></a>
                                    <br />
                                    Image 3
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Property Images -->
                <div class="row">
                    <div class="col-md-12 text-center">
                        <?php
                        if (loggedIn())
                        {
                            ?>
                            <button id="btnCancel" name="btnCancel" type="button" class="btn btn-danger pull-left" onclick="location.href='<?php echo BASE_URL_RSB?>my-account/';"><i class="fa fa-close"></i> Cancel</button>
                            <button id="btnAddEvent" name="btnAddEvent" type="button" class="btn btn-warning" onclick="location.href='<?php echo BASE_URL_RSB?>add-event/?property_id=<?php echo $property->id?>';"><i class="fa fa-calendar"></i> Add Event</button>
                            <button id="btnSubmit" name="btnSubmit" type="submit" class="btn btn-info pull-right"><i class="fa fa-pencil"></i> Edit Property</button>
                            <?php
                        } else {
                            ?>
                            <button id="btnCancel" name="btnCancel" type="button" class="btn btn-danger pull-left" onclick="location.href='<?php echo BASE_URL_RSB?>';"><i class="fa fa-close"></i> Cancel</button>
                            <button id="btnSubmit" name="btnSubmit" type="submit" class="btn btn-success pull-right"><i class="fa fa-dollar"></i> Upgrade Property</button>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                    </fieldset>
                </form>
                <!-- BEGIN: My Events -->
                <div class="row" style="margin-top:30px;">
                    <!-- Data Table -->
                    <div class="col-md-12">
                        <form id="frmManageEvents" name="frmManageEvents" action="<?php echo BASE_URL_RSB?>my-account/" method="post" class="form-light mt-20" role="form">
                            <input id="action" name="action" type="hidden" value="post_new_property_link" />
                            <fieldset class="bordered-fieldset">
                            <legend>Property Events</legend>
                            <table class="table table-hover table-condensed account-data-table">
                              <thead>
                                <tr>
                                  <th>ID</th>
                                  <th>Name</th>
                                  <th>City</th>
                                  <th>State</th>
                                  <th>Zipcode</th>
                                  <th>Actions</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                if (count($arrEvents) > 0)
                                {
                                    foreach ($arrEvents as $events)
                                    {
                                        $event = toObject($events);
                                        ?>
                                        <tr>
                                          <td><?php echo $event->id?></td>
                                          <td><?php echo $event->event_name?></td>
                                          <td><?php echo $event->event_city?></td>
                                          <td><?php echo $event->event_state?></td>
                                          <td><?php echo $event->event_zipcode?></td>
                                          <td style="white-space:nowrap;">
                                            <button type="button" class="btn btn-xs btn-success" title="View" onclick="window.location='<?php echo BASE_URL_RSB?>view-event/<?php echo $event->id?>/<?php echo urlencode($event->event_name)?>/';"><i class="table-action-button fa fa-eye"></i></button>
                                            <button disabled type="button" class="btn btn-xs btn-danger" title="Delete" onclick="window.location='<?php echo BASE_URL_RSB?>my-account/?action=delete_event&event_id=<?php echo $event->id?>';"><i class="table-action-button fa fa-trash"></i></button>
                                          </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <tr><td colspan="6">No events exist.</td></tr>
                                    <?php
                                }
                                ?>
                              </tbody>
                            </table>
                            </fieldset>
                        </form>
                    </div>
                    <!-- END: Data Table -->
                </div>
                <!-- END: My Events -->
            </div>
            <!-- END: Property Content -->
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
                    <!-- BEGIN: Upgrade Subscription -->
                    <div class="alert alert-warning" role="alert">
                        <strong><a href="<?php echo BASE_URL_RSB?>pricing/?property_hash=<?php echo $property->property_hash?>" title="Upgrade your subscription for additional features"><span class="red">UPGRADE</span></a></strong> this property subscription plan.
                    </div>
                    <!-- END: Upgrade Subscription -->
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