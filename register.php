<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 13-APR-2018
 * ---------------------------------------------------
 * Register Page (register.php)
 *****************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Initialize page data...
 ************************************/
$strPageName = 'register';
$strPageTitle = 'Account Registration';

/************************************
 * Include the HTML header...
 ************************************/
include ('include/header.php');
?>
    <section class="parallax-window" id="short" data-parallax="scroll" data-image-src="<?php echo BASE_URL_RSB?>img/rv_camp_003.jpg" data-natural-width="1350" data-natural-height="465">
        <div id="subheader">
            <h1>Account Registration</h1>
        </div>
    </section>
    <div class="container margin_60">
      <h2 class="main_title"><em></em>Account registration <span>Enter a valid email address and create a new password below.</span></h2>
        <p class="lead styled">&nbsp;</p>
    	<div class="row about">
                <div class="col-md-6">
                	<div class="basic-login">
	                   <form id="frmRegisterUser" name="frmRegisterUser" action="<?php echo BASE_URL_RSB?>my-account/" method="post" class="form-light mt-20" role="form">
							<input id="action" name="action" type="hidden" value="do_register_user" />
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Email Address</label>
										<input id="email" name="email" type="email" class="form-control" placeholder="Email Address" value="<?php echo $objUser->email?>" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Password</label>
										<input id="password" name="password" type="password" class="form-control" value="<?php echo $objUser->password?>" />
									</div>
								</div>
							</div>
							<div class="row" style="display:none;">
								<div class="col-md-6">
									<div class="form-group">
										<label>First Name</label>
										<input id="first_name" name="first_name" type="text" class="form-control" value="<?php echo $objUser->first_name?>" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Last Name</label>
										<input id="last_name" name="last_name" type="text" class="form-control" value="<?php echo $objUser->last_name?>" />
									</div>
								</div>
							</div>
							<div class="row" style="display:none;">
								<div class="col-md-12">
									<div class="form-group">
										<label>Address</label>
										<input id="address_1" name="address_1" type="text" class="form-control" value="<?php echo $objUser->address_1?>" />
									</div>
								</div>
							</div>
							<div class="row" style="display:none;">
								<div class="col-md-6">
									<div class="form-group">
										<label>City</label>
										<input id="city" name="city" type="text" class="form-control" value="<?php echo $objUser->city?>" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>State</label>
										<select id="state" name="state" class="form-control">
										<?php
										foreach ($arrStates as $key => $val)
										{
											?>
											<option value="<?php echo $key?>"<?php echo (($objUser->state == $key)?(' selected="selected"'):(''))?>><?php echo $val?></option>
											<?php
										}
										?>
									</select>
									</div>
								</div>
							</div>
							<div class="row" style="display:none;">
								<div class="col-md-6">
									<div class="form-group">
										<label>Zipcode</label>
										<input id="zipcode" name="zipcode" type="text" class="form-control" value="<?php echo $objUser->zip?>" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Phone</label>
										<input id="phone" name="phone" type="text" class="form-control" value="<?php echo $objUser->phone?>" />
									</div>
								</div>
							</div>
							<div class="row" style="display:none;">
								<div class="col-md-6">
									<div class="form-group">
										<label>Account Type</label>
										<select id="account_type" name="account_type" class="form-control">
										<?php
										foreach ($arrAccountTypes as $key => $val)
										{
											?>
											<option value="<?php echo $key?>"<?php echo (($key == 1)?(' selected="selected"'):(''))?>><?php echo $val?></option>
											<?php
										}
										?>
									</select>
									</div>
								</div>
								<div class="col-md-6">
								</div>
							</div>
							<div class="form-group">
								<div class="checkbox">
									<label>
										<input id="chkTOS" name="chkTOS" type="checkbox" value="1" /> I agree to the <a href="<?php echo BASE_URL_RSB?>terms-of-service/" target="_blank" title="View our Terms of Service">Terms of Service</a>
									</label>
								</div>
							</div>
							<button id="btnSubmit" name="btnSubmit" type="submit" class="btn btn-danger pull-right">Create Account</button>
							<p><br/></p>
						</form>
					</div>
                </div>
                <div class="col-md-6 social-login text-center">
					<img src="<?php echo BASE_URL_RSB?>img/signup.png" class="img-responsive text-center" style="margin:0px auto; max-width:350px;" />
					<div class="clearfix"></div>
					<div class="not-member">
						<p>Already a member? <a href="<?php echo BASE_URL_RSB?>login/">Login here</a></p>
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