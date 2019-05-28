<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 20-MAY-2018
 * ---------------------------------------------------
 * View Event Page (view_event.php)
 *****************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Initialize page data...
 ************************************/
$strPageName = 'view_event';
$strPageTitle = 'View Event Information';

/************************************
 * Check if page is protected...
 ************************************/
isProtectedPage();

/************************************
 * Initialize data arrays...
 ************************************/
$user = toObject($_SESSION['sys_user']);
$event = toObject(getEventData($intEventID));

/************************************
 * Include the HTML header...
 ************************************/
include ('include/header.php');
?>
    <section class="parallax-window" id="short" data-parallax="scroll" data-image-src="<?php echo BASE_URL_RSB?>img/rv_camp_003.jpg" data-natural-width="1350" data-natural-height="465">
        <div id="subheader">
            <h1>View Event</h1>
        </div>
    </section>
    <div class="container margin_60">
        <div class="row">
            <!-- BEGIN: Event Content -->
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12">
                <!-- BEGIN: Event Overview -->
                <div class="job-details-wrapper">
                    <h3>View Event</h3>
                    <p>Use the form below to view the event information. To edit the event, just click on "Edit Event" to be directed to the event edit page.</p>
                    <form id="frmEViewvent" name="frmEViewvent" action="<?php echo BASE_URL_RSB?>edit-event/<?php echo $event->id?>/<?php echo urlencode($event->event_name)?>/" method="post" class="form-light mt-20" role="form">
                        <input id="action" name="action" type="hidden" value="view_event" />
                        <fieldset class="bordered-fieldset">
                        <legend>Event Information</legend>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Event Name</label>
                                    <input disabled readonly id="event_name" name="event_name" type="text" class="form-control" value="<?php echo $event->event_name?>" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Property Name</label>
                                    <input disabled readonly id="property_id" name="property_id" type="text" class="form-control" value="<?php echo getPropertyName($event->property_id)?>" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Start Date</label>
                                    <input disabled readonly id="start_date" name="start_date" type="text" class="form-control" value="<?php echo date('m-d-Y h:i a', $event->event_start_date)?>" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>End Date</label>
                                    <input disabled readonly id="end_date" name="end_date" type="text" class="form-control" value="<?php echo date('m-d-Y h:i a', $event->event_end_date)?>" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Address</label>
                                    <input disabled readonly id="event_address" name="event_address" type="text" class="form-control" value="<?php echo $event->event_address?>" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>City</label>
                                    <input disabled readonly id="event_city" name="event_city" type="text" class="form-control" value="<?php echo $event->event_city?>" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>State</label>
                                    <select disabled readonly id="event_state" name="event_state" class="form-control">
                                        <option value="0">-- Select-- </option>
                                        <?php
                                        foreach ($arrStates as $key => $val)
                                        {
                                            ?>
                                            <option value="<?php echo $key?>"<?php echo (($event->event_state == $key)?(' selected="selected"'):(''))?>><?php echo $val?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Zipcode</label>
                                    <input disabled readonly id="event_zipcode" name="event_zipcode" type="text" class="form-control" value="<?php echo $event->event_zipcode?>"  />
                                </div>
                            </div>
                        </div>
                        <!-- BEGIN: Event Description -->
                        <div class="row">
                            <div class="col-md-12">
                                <h3>Event Description</h3>
                                <div class="form-group">
                                    <?php echo (($event->event_description == '')?('(none)'):($event->event_description))?>
                                </div>
                            </div>
                        </div>
                        <!-- END: Event Description -->
                        <div class="row" style="margin-bottom:25px;">
                            <div class="col-md-12">
                                <h3>Event Image</h3>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <img src="<?php echo EVENT_IMAGE_PATH.(($event->event_image != '')?($event->event_image):('no_image_available.jpg'))?>" class="img-responsive img-rounded preview-thumbnail" alt="image" />
                                            <br />
                                            <a href="#" class="btn btn-xs btn-danger" title="Delete"><i class="fa fa-close"></i></a> Event Image
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button id="btnCancel" name="btnCancel" type="button" class="btn btn-danger pull-left" onclick="location.href='<?php echo BASE_URL_RSB?>my-account/';"><i class="fa fa-close"></i> Cancel</button>
                                    <button id="btnSubmit" name="btnSubmit" type="submit" class="btn btn-info pull-right"><i class="fa fa-pencil"></i> Edit Event</button>
                                </div>
                            </div>
                        </div>
                        </fieldset>
                    </form>
                </div>
                <!-- END: Event Overview -->
               </div>
              </div>
            </div>
            <!-- END: Event Content -->
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