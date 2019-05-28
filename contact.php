<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 13-APR-2018
 * ---------------------------------------------------
 * Contact Page (contact.php)
 *****************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Initialize page data...
 ************************************/
$strPageName = 'contact';
$strPageTitle = 'Contact Us';

/************************************
 * Include the HTML header...
 ************************************/
include ('include/header.php');
?>
    <!-- SubHeader  -->
    <section class="parallax-window" id="short" data-parallax="scroll" data-image-src="<?php echo BASE_URL_RSB?>img/rv_camp_003.jpg" data-natural-width="1350" data-natural-height="465">
        <div id="subheader">
            <h1>Contact Us</h1>
        </div><!-- End subheader -->
    </section><!-- End section -->
    <!-- End SubHeader -->
    <div class="container margin_60_35">
    <h2 class="main_title"><em></em>Welcome to Book My Spot Online <span>Premier Lodging Resources While On The Road</span></h2>
    	<div class="row add_top_20">
        <div class="col-md-4">
            	<div class="box_style_1">
                <div class="box_contact">
                    <i class="icon_set_1_icon-41"></i>
                    <h4>Address</h4>
                    <p>PO Box 338<br />McKinney, TX 75070<br /><a href="tel://2146999132">(214) 699-9132 </a><br /><a href="mailto:info@bookmyspotonline.com">info@bookmyspotonline.com</a></p>
                    </div>
                    <div class="box_contact">
            	<i class="icon_set_1_icon-37"></i>
                <h4>Get directions</h4>
                <form action="http://maps.google.com/maps" method="get" target="_blank">
                	<div class="form-group">
					   <input type="text" name="saddr" placeholder="Enter your starting point" class="form-control" />
					   <input type="hidden" name="daddr" value="McKinney, TX 75070" />
                    </div>
                    <div class="form-group">
					   <button class="btn_1" type="submit" value="Get Directions">Get Directions</button>
                    </div>
                </form>
                </div>
            </div>
            </div>   
        	<div class="col-md-7 col-md-offset-1">
            <div id="message-contact"></div>
				<form id="frmContact" name="frmContact" method="post" action="<?php echo BASE_URL_RSB?>" id="contactform" role="form">
                    <input type="hidden" id="action" name="action" value="do_contact" />
					<div class="row">
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label>First Name</label>
								<input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" />
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label>Last Name</label>
								<input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" />
							</div>
						</div>
					</div>
					<!-- End row -->
					<div class="row">
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label>Email</label>
								<input type="email" id="email" name="email" class="form-control" placeholder="Email" />
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label>Phone</label>
								<input type="text" id="phone" name="phone" class="form-control" placeholder="Phone Number" />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Message</label>
								<textarea id="comments" name="comments" class="form-control" placeholder="Enter your message..." style="height:150px;"></textarea>
							</div>
						</div>
					</div>
					<div class="row add_bottom_30">
						<div class="col-md-6">
                        	<div class="form-group">
                                <input type="submit" id="submit-contact" class="btn_1" value="Submit" />
                            </div>
						</div>
					</div>
				</form>               
            </div><!-- End col-md-8 -->    
        </div><!-- End row -->
    </div><!-- End Container -->
<?php
/************************************
 * Include the HTML footer...
 ************************************/
include ('include/footer.php');
?>