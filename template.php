<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 13-APR-2018
 * ---------------------------------------------------
 * Template Page (template.php)
 *****************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Initialize page data...
 ************************************/
$strPageName = 'template';
$strPageTitle = 'Template';

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
            <h1>Template</h1>
        </div>
    </section>
    <!-- End SubHeader -->
    
    <div class="container margin_60">
      <h2 class="main_title"><em></em>Template <span>Page</span></h2>
        <p class="lead styled">My Place On Wheels provides convenient access to finding that perfect place to stay while on the road. A leading destination for discovering, exploring, and booking RV parks, cabins, bed &amp; breakfasts, and other rental options, the site guides many visitors in planning their road trip and outdoor adventures each year. From family, group, and individual travel guides, to camping, hiking, fishing, and other activity tips, MyPlaceOnWheels.com is the go-to resource for trip planning abroad.</p>
    	<div class="row about">
                <div class="col-md-5 col-sm-6 col-md-offset-1">
                   <h3>Beautiful views...</h3>
                   <p id="startLat"></p>
                   <p id="startLon"></p>
                    <p>Esse dicit accusam duo an. Modus simul ei nec. Sea et explicari pertinacia, <strong>cu vitae bonorum</strong> vocibus nec, corpora signiferumque no vim. Ad principes scriptorem duo, te omnium gubergren eam, et eam ancillae appareat dissentiet. Quando tantas animal vis ut, mandamus voluptatum duo ne, ne odio vidit commodo has.</p>
                </div>
                <div class="col-md-4 col-sm-6 col-md-offset-1">
                <img src="<?php echo BASE_URL_RSB?>img/about_1.jpg" alt="" class="img-responsive img-rounded styled" /> 
                </div>
      </div><!-- End row -->
 		<div class="divider hidden-xs"></div>
<script>
window.onload = function() {
  var startPos;
  var geoSuccess = function(position) {
    startPos = position;
    document.getElementById('startLat').innerHTML = startPos.coords.latitude;
    document.getElementById('startLon').innerHTML = startPos.coords.longitude;
  };
  navigator.geolocation.getCurrentPosition(geoSuccess);
};
</script>

<script>
/*
window.onload = function(){}
	var options = {
	    enableHighAccuracy: true,
	    timeout: 5000,
	    maximumAge: 3600000
	};
	
	var startPos;
	var geoSuccess = function(position){
	    startPos = position;
	    document.getElementById('location_latitude').value = startPos.coords.latitude;
	    document.getElementById('location_longitude').value = startPos.coords.longitude;
	    console.log('Finishing GEO...');
	};
	console.log('Starting GEO...');
	navigator.geolocation.getCurrentPosition(geoSuccess);
};
*/
</script>
       
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