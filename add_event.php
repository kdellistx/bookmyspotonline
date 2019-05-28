<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 20-MAY-2018
 * ---------------------------------------------------
 * Add Event Page (add_event.php)
 *****************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Initialize page data...
 ************************************/
$strPageName = 'add_event';
$strPageTitle = 'Add Event Information';

/************************************
 * Check if page is protected...
 ************************************/
isProtectedPage();

/************************************
 * Initialize data arrays...
 ************************************/
$user = toObject($_SESSION['sys_user']);
$arrProperties = generatePropertes();

/************************************
 * Include the HTML header...
 ************************************/
include ('include/header.php');
?>
    <section class="parallax-window" id="short" data-parallax="scroll" data-image-src="<?php echo BASE_URL_RSB?>img/rv_camp_003.jpg" data-natural-width="1350" data-natural-height="465">
        <div id="subheader">
            <h1>Add Event</h1>
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
                    <h3>Add Event</h3>
                    <p>Use the form below to add the event information. When you are done, be sure to click "Save Event" to save the changes.</p>
                    <form id="frmEditEvent" name="frmEditEvent" action="<?php echo BASE_URL_RSB?>my-account/" method="post" class="form-light mt-20" enctype="multipart/form-data" role="form">
                        <input id="action" name="action" type="hidden" value="add_event" />
                        <input id="user_id" name="user_id" type="hidden" value="<?php echo $user->id?>" />
                        <fieldset class="bordered-fieldset">
                        <legend>Event Information</legend>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Event Name</label>
                                    <input id="event_name" name="event_name" type="text" class="form-control" value="<?php echo $event->event_name?>" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Property Name</label>
                                    <select <?php echo (($user->tz == 1)?(''):('disabled readonly'))?> id="property_id" name="property_id" class="form-control">
                                        <option value="0">-- Select-- </option>
                                        <?php
                                        if (!empty($arrProperties))
                                        {
                                            foreach ($arrProperties as $properties)
                                            {
                                                $property = toObject($properties);
                                                ?>
                                                <option value="<?php echo $property->id?>"<?php echo (($intPropertyID == $property->id)?(' selected="selected"'):('')) ?>><?php echo $property->property_name?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Start Date</label>
                                    <input class="startDate1 start_date form-control datepick" type="text" data-field="datetime" data-startend="start" data-startendelem=".start_date" id="check_in" name="start_date" placeholder="Start Date" value="" />
                                    <span class="input-icon"><i class="icon-calendar-7"></i></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>End Date</label>
                                    <input class="endDate1 end_date form-control datepick" type="text" data-field="datetime" data-startend="end" data-startendelem=".end_date" id="check_out" name="end_date" placeholder="End Date" value="" />
                                    <span class="input-icon"><i class="icon-calendar-7"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Address</label>
                                    <input id="event_address" name="event_address" type="text" class="form-control" value="" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>City</label>
                                    <input id="event_city" name="event_city" type="text" class="form-control" value="" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>State</label>
                                    <select id="event_state" name="event_state" class="form-control">
                                        <option value="0">-- Select-- </option>
                                        <?php
                                        foreach ($arrStates as $key => $val)
                                        {
                                            ?>
                                            <option value="<?php echo $key?>"><?php echo $val?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Zipcode</label>
                                    <input id="event_zipcode" name="event_zipcode" type="text" class="form-control" value=""  />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h3>Event Description</h3>
                                <div class="form-group">
                                    <textarea id="event_description_summernote" name="event_description" class="form-control" rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:25px;">
                            <div class="col-md-12">
                                <h3>Add Event Image</h3>
                                <div class="form-group">
                                    <label for="image_main">Main Image</label>
                                    <input type="file" class="form-control-file" id="event_image" name="event_image[]" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button id="btnCancel" name="btnCancel" type="button" class="btn btn-danger pull-left" onclick="location.href='<?php echo BASE_URL_RSB?>my-account/';"><i class="fa fa-close"></i> Cancel</button>
                                    <button id="btnSubmit" name="btnSubmit" type="submit" class="btn btn-info pull-right"><i class="fa fa-save"></i> Save Event</button>
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