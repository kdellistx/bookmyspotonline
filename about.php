<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 13-APR-2018
 * ---------------------------------------------------
 * About Us Page (about.php)
 *****************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Initialize page data...
 ************************************/
$strPageName = 'about';
$strPageTitle = 'About Us';

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
    <!-- SubHeader -->
    <section class="parallax-window" id="short" data-parallax="scroll" data-image-src="<?php echo BASE_URL_RSB?>img/rv_camp_003.jpg" data-natural-width="1350" data-natural-height="465">
        <div id="subheader">
            <h1>About Us</h1>
        </div>
    </section>
    <!-- End SubHeader -->
    
    <div class="container margin_60">
      <h2 class="main_title"><em></em>Welcome to My Place On Wheels <span>Premier Lodging Resources While On The Road</span></h2>
        <p class="lead styled">My Place On Wheels provides convenient access to finding that perfect place to stay while on the road. A leading destination for discovering, exploring, and booking RV parks, cabins, bed &amp; breakfasts, and other rental options, the site guides many visitors in planning their road trip and outdoor adventures each year. From family, group, and individual travel guides, to camping, hiking, fishing, and other activity tips, MyPlaceOnWheels.com is the go-to resource for trip planning abroad.</p>
    	<div class="row about">
                <div class="col-md-5 col-sm-6 col-md-offset-1">
                   <h3>Beautiful views...</h3>
                    <p>Esse dicit accusam duo an. Modus simul ei nec. Sea et explicari pertinacia, <strong>cu vitae bonorum</strong> vocibus nec, corpora signiferumque no vim. Ad principes scriptorem duo, te omnium gubergren eam, et eam ancillae appareat dissentiet. Quando tantas animal vis ut, mandamus voluptatum duo ne, ne odio vidit commodo has.</p>
                </div>
                <div class="col-md-4 col-sm-6 col-md-offset-1">
                <img src="<?php echo BASE_URL_RSB?>img/about_1.jpg" alt="" class="img-responsive img-rounded styled" /> 
                </div>
      </div><!-- End row -->
 		<div class="divider hidden-xs"></div>
       <div class="row about" >
            <div class="col-md-5 col-sm-6 col-md-offset-1 col-md-push-5">
                 <h3>Historical landmarks...</h3>
                 <p>Esse dicit accusam duo an. Modus simul ei nec. Sea et explicari pertinacia, <strong>cu vitae bonorum</strong> vocibus nec, corpora signiferumque no vim. Ad principes scriptorem duo, te omnium gubergren eam, et eam ancillae appareat dissentiet. Quando tantas animal vis ut, mandamus voluptatum duo ne, ne odio vidit commodo has.</p>
            </div>
            <div class="col-md-4 col-sm-6 col-md-offset-1 col-md-pull-6">
               <img src="<?php echo BASE_URL_RSB?>img/landmark_002.jpg" alt="" class="img-responsive img-rounded styled" /> 
            </div>
        </div><!-- End row -->
      <div class="divider hidden-xs"></div>
        <div class="row about">
                <div class="col-md-5 col-sm-6 col-md-offset-1">
                   <h3>Relax and enjoy...</h3>
                    <p>Esse dicit accusam duo an. Modus simul ei nec. Sea et explicari pertinacia, <strong>cu vitae bonorum</strong> vocibus nec, corpora signiferumque no vim. Ad principes scriptorem duo, te omnium gubergren eam, et eam ancillae appareat dissentiet. Quando tantas animal vis ut, mandamus voluptatum duo ne, ne odio vidit commodo has.</p>
                </div>
                <div class="col-md-4 col-sm-6 col-md-offset-1">
                <img src="<?php echo BASE_URL_RSB?>img/rv_camp_002.jpg" alt="" class="img-responsive img-rounded styled" /> 
                </div>
      </div><!-- End row -->
    </div><!-- End container -->
    
    <div class="container_styled_1">
    	<div class="container margin_60">
        <h3 class="main_title">Things To Look For<span>Look for the amentities and features while on the road...</span></h3>
        	<div class="row">
            	<div class="col-md-4 col-sm-4">
                	<div class="box_feat">
                    	<i class="icon_set_1_icon-8"></i>
                        <h4>Patios &amp; Gardens</h4>
                        <p>Locations that offer a patio, garden, or any other serene are will help you unwind, and relax from along journey or hectic day.</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                <div class="box_feat">
                    	<i class="icon_set_1_icon-27"></i>
                        <h4>Parking</h4>
                        <p>Make sure that the location you select has ample parking and has some type of security measures in place.</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                <div class="box_feat">
                    	<i class="icon_set_2_icon-111"></i>
                        <h4>Showers &amp; Bathing</h4>
                        <p>Although your RV / mobile home may have adequate facilities, it's important to always have aback-up plan, just in case.</p>
                    </div>
                </div>
            </div><!-- End row -->
            <div class="row">
            	<div class="col-md-4 col-sm-4">
                	<div class="box_feat">
                    	<i class="icon_set_1_icon-22"></i>
                        <h4>Pet Friendly</h4>
                        <p>Most places are pet friendly, but it is wise to check in advance, just to be sure.</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                <div class="box_feat">
                    	<i class="icon_set_2_icon-103"></i>
                        <h4>Laundry Services</h4>
                        <p>On-site laundry facilities or at least a nearby location will help you 'stay fresh'.</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                <div class="box_feat">
                    	<i class="icon_set_1_icon-86"></i>
                        <h4>WIFI &amp; Internet Service</h4>
                        <p>Many locations offer some sort of WIFI or internet connectivity so that you can stay in touch when you're away from home.</p>
                    </div>
                </div>
            </div><!-- End row -->
        </div><!-- End container -->
    </div><!-- End container_styled_1 -->
    
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