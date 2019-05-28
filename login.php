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
$strPageName = 'login';
$strPageTitle = 'Account Login';

/************************************
 * Initialize data arrays...
 ************************************/

/************************************
 * Include the HTML header...
 ************************************/
include ('include/header.php');
?>
    <section class="parallax-window" id="short" data-parallax="scroll" data-image-src="<?php echo BASE_URL_RSB?>img/rv_camp_003.jpg" data-natural-width="1350" data-natural-height="465">
        <div id="subheader">
            <h1>Account Login</h1>
        </div>
    </section>
    <div class="container margin_60">
      <h2 class="main_title"><em></em>Account Login <span>Please use the form below to login to your account</span></h2>
        <p class="lead styled"><strong>GUESTS:</strong> You can use the following to login as a guest: <strong>guest@bookmyspotonline.com</strong> password: <strong>guest</strong></p>
    	<div class="row about">
                <div class="col-md-6">
                	<div class="basic-login">
	                   <form id="frmUserLogin" name="frmUserLogin" action="<?php echo BASE_URL_RSB?>my-account/" method="post" role="form">
							<input id="action" name="action" type="hidden" value="do_login" />
							<div class="form-group">
		    				 	<label for="email"><i class="icon-user"></i> <b>Email</b></label>
								<input class="form-control" id="email" name="email" type="text" placeholder="" />
							</div>
							<div class="form-group">
		    				 	<label for="password"><i class="icon-lock"></i> <b>Password</b></label>
								<input class="form-control" id="password" name="password" type="password" placeholder="" />
							</div>
							<div class="form-group" style="margin-left:20px;">
								<label class="checkbox">
									<input type="checkbox" name="chRememberMe" id="chkRememberMe" /> Remember me
								</label>
								<a href="<?php echo BASE_URL_RSB?>forgot-password/" class="forgot-password">Forgot password?</a>
								<button type="submit" name="btnSubmit" class="btn btn-danger pull-right">Login</button>
								<div class="clearfix"></div>
							</div>
						</form>
					</div>
                </div>
                <div class="col-md-6 social-login">
					<img src="<?php echo BASE_URL_RSB?>img/account-login.png" class="img-responsive" style="max-width:350px;" />
					<div class="clearfix"></div>
					<div class="not-member">
						<p>Not a member? <a href="<?php echo BASE_URL_RSB?>register/">Register here</a></p>
					</div>
                </div>
      </div><!-- End row -->
 		<div class="divider hidden-xs"></div>
    </div><!-- End container -->
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