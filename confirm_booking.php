<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 24-OCT-2018
 * ---------------------------------------------------
 * Booking Confirmation Page (confirm_booking.php)
 *****************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Initialize page data...
 ************************************/
$strPageName = 'confirm_booking';
$strPageTitle = 'Booking Confirmation';

/************************************
 * Initialize data arrays...
 ************************************/
$booking = toObject(getBookingData($intBookingID));
$property = toObject(getPropertyData($booking->property_id));

/************************************
 * Confirm the booking...
 ************************************/
if ($booking->id > 0)
{
	confirmBooking($booking->id);
}

/************************************
 * Include the HTML header...
 ************************************/
include ('include/header.php');
?>
    <section class="parallax-window" id="short" data-parallax="scroll" data-image-src="<?php echo BASE_URL_RSB?>img/rv_camp_003.jpg" data-natural-width="1350" data-natural-height="465">
        <div id="subheader">
            <h1>Booking Confirmation</h1>
        </div>
    </section>
    <div class="container margin_60">
      	<h2 class="main_title"><em></em><?php echo $property->property_name?><span><?php echo $booking->name_booking?><br />(<?php echo $booking->dates_booking?>)</span></h2>
    	<div class="row about">
			<div class="col-md-12">
				<h3 class="sub-heading">NOTICE:</h3>
				<p>The booking has been confirmed. You can view the reservation details on the <strong>My Account</strong> page or view the property details by selecting an option below.</p>
			</div>
      	</div>
      	<div class="row">
      		<div class="col-md-6 text-left">
      			<a href="<?php echo BASE_URL_RSB?>my-account/" class="btn btn-md btn-success" title="Go to My Account"><i class="fa fa-cogs fa-right-5"></i> My Account</a>
      		</div>
      		<div class="col-md-6 text-right">
      			<a href="<?php echo BASE_URL_RSB?>details/<?php echo $property->id?>/<?php echo generateSEOURL($property->property_name)?>/" class="btn btn-md btn-primary" title="Go to property detail page"><i class="fa fa-home fa-right-5"></i> Property Details</a>
      		</div>
      	</div>
 		<div class="divider hidden-xs"></div>
    </div>
    <!-- END: Container -->
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