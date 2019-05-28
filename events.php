<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 15-APR-2018
 * ---------------------------------------------------
 * Events Page (events.php)
 *****************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Initialize page data...
 ************************************/
$strPageName = 'events';
$strPageTitle = 'Events';

/************************************
 * Initialize data arrays...
 ************************************/
$arrEvents = generateEvents(50, false);

/************************************
 * Include the HTML header...
 ************************************/
include ('include/header.php');
?>
    <section class="parallax-window" id="short" data-parallax="scroll" data-image-src="<?php echo BASE_URL_RSB?>img/rv_camp_003.jpg" data-natural-width="1350" data-natural-height="465">
        <div id="subheader">
            <h1>Events</h1>
        </div>
    </section>
    <div class="container margin_60">
        <h2 class="main_title"><em></em>When are you going? <span>Select a date range and browse for events to attend...</span></h2>
        <div class="row">
            <form id="frmEvents" name="frmEvents" action="<?php echo BASE_URL_RSB?>events/" method="post" class="form-light" role="form">
                <input id="action" name="action" type="hidden" value="select_event_dates" />
                <div class="col-md-7 col-md-offset-3">
                    <div class="form-group pull-left">
                        <label>Start Date</label>
                        <input class="startDate1 form-control datepick" type="text" data-field="date" data-startend="start" data-startendelem=".endDate1" id="check_in" name="check_in" placeholder="Start" readonly />
                        <span class="input-icon"><i class="icon-calendar-7"></i></span>
                    </div>
                    <div class="form-group pull-right">
                        <label>End Date</label>
                        <input class="endDate1 form-control datepick" type="text" data-field="date" data-startend="end" data-startendelem=".startDate1" id="check_out" name="check_out" placeholder="End" readonly />
                        <span class="input-icon"><i class="icon-calendar-7"></i></span>
                    </div>
                </div>
            </form>
        </div>
        <div class="row">
            <!-- BEGIN: Event Content -->
            <div class="col-md-8">

                <?php
                foreach ($arrEvents as $events)
                {
                    $event = toObject($events);
                    $property = toObject(getPropertyData($event->property_id));
                    if ($event->event_imaege != '')
                    {
                        $strEventImage = BASE_URL_RSB.'uploads/events/'.$event->event_image;
                    } else {
                        $strEventImage = BASE_URL_RSB.'uploads/events/no_image.jpg';
                    }
                    ?>
                <!-- BEGIN: Event -->
                <div class="row">
                    <div class="room_desc clearfix" onclick="location.href='<?php echo BASE_URL_RSB?>details/<?php echo $property->id?>/<?php echo generateSEOURL($property->property_name)?>/#events';">
                    <div class="col-md-3">
                        <figure><img src="<?php echo $strEventImage?>" alt="events image" class="img-responsive img-rounded" /></figure>
                    </div>
                    <div class="col-md-9 room_list_desc">
                        <h3><?php echo $event->event_name?></h3>
                        <p><?php echo $event->event_description?><br />
                            <?php echo $event->event_address?><br />
                            <?php echo $event->event_city?>, <?php echo $event->event_state?> <?php echo $event->event_zipcode?>
                        </p>
                        <div class="price"><button class="btn btn-danger">VIEW EVENT INFO &#187;</button></div>
                    </div>
                    </div>
                </div>
                <!-- END: Property -->
                    <?php
                    }
                ?>
            </div>
            <!-- END: Property Content -->
            <!-- BEGIN: Sidebar -->
            <div class="col-md-4 sidebar">
                <div class="theiaStickySidebar">
                    <div class="box_style_3">
                        <h3>List An Event</h3>
                        <p>Got an event to list? Add it to your property page by logging in below:</p>
                        <ul style="list-style-type:none;">
                            <li><i class="fa fa-key"></i> <a href="<?php echo BASE_URL_RSB?>login/" title="Login to your account">Account Login</a></li>
                        </ul>
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