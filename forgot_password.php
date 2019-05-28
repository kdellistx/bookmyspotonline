<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 13-APR-2018
 * ---------------------------------------------------
 * Login Page (login.php)
 *****************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Initialize page data...
 ************************************/
$strPageName = 'forgot_password';
$strPageTitle = 'Recover Password';

/************************************
 * Initialize data arrays...
 ************************************/
//$arrProducts = generateProductList(12, true);
//showDebug($arrProducts, 'products data array', true);

/************************************
 * Include the HTML header...
 ************************************/
include ('include/header.php');
?>
    <section class="parallax-window" id="short" data-parallax="scroll" data-image-src="<?php echo BASE_URL_RSB?>img/rv_camp_003.jpg" data-natural-width="1350" data-natural-height="465">
        <div id="subheader">
            <h1>Password Recovery</h1>
        </div>
    </section>
    <div class="container margin_60">
      <h2 class="main_title"><em></em>Password Recovery <span>Please use the form below to recover your account password</span></h2>
        <p class="lead styled">&nbsp;</p>
    	<div class="row about">
            <div class="col-md-6 col-md-offset-3">
            	<div class="basic-login">
                   <form id="frmRecoverPassword" name="frmRecoverPassword" action="<?php echo BASE_URL_RSB?>login/" method="post" role="form">
						<input id="action" name="action" type="hidden" value="do_recover_password" />
						<div class="form-group">
        				 	<label for="email"><i class="icon-envelope"></i> <b>Enter Your Email</b></label>
							<input class="form-control" id="email" name="email" type="text" placeholder="" />
						</div>
						<div class="form-group">
							<button type="button" name="btnCancel" class="btn btn-danger pull-left" onclick="location.href='<?php echo BASE_URL_RSB?>login/';"><i class="fa fa-close"></i> Cancel</button>
							<button type="submit" name="btnSubmit" class="btn btn-success pull-right"><i class="fa fa-envelope"></i> Send Password</button>
							<div class="clearfix"></div>
						</div>
					</form>
				</div>
            </div>
      	</div>
 		<div class="divider hidden-xs"></div>
    </div>
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