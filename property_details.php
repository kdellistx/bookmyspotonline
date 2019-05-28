<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 14-APR-2018
 * ---------------------------------------------------
 * Property Details Page (property_details.php)
 *****************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Initialize data arrays...
 ************************************/
$arrProperty = getPropertyData($intPropertyID);
$property = toObject($arrProperty);
$category = toObject(getPropertyCategoryData($property->category_id));
$arrEvents = generatePropertyEvents($property->id);
$arrReviews = generateReviews($property->id);
$arrSinglePropertyData[0] = $property->id;
$strPropertyIDSearch = serialize($arrSinglePropertyData);
$arrSkyscrapers = generateAdvertisements(0, false, 10);
$arrBookings = generateBookings($property->id, false);
$arrBookingDates = array();
$arrBookedDates = array();
if (!empty($arrBookings))
{
    foreach ($arrBookings as $bookings)
    {
        $booking = toObject($bookings);
        $arrBookingDates[] = $booking->dates_booking;
    }
    $arrBookedDates = generateDatesInRange($arrBookingDates);
}
//showDebug($arrBookings, 'booking dates array', false);
//showDebug($arrBookedDates, 'booked dates array', true);

/************************************
 * Additional data definitions...
 ************************************/
if (loggedIn())
{
    $strClaimURL = 'my-account/?action=claim_property&property_id='.$property->id;
} else {
    $strClaimURL = 'my-account/';
}

/************************************
 * Initialize page data...
 ************************************/
$strPageName = 'property_details';
$strPageTitle = $property->property_name;

/************************************
 * Include the HTML header...
 ************************************/
include ('include/header.php');
?>
	<div class="carousel_in"></div>
    <h1 class="main_title_in orange"><?php echo $property->property_name?></h1>
    <div class="container add_bottom_60">
        <div class="row">
        	<div class="col-md-8">
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-danger pull-left" onclick="location.href='<?php echo BASE_URL_RSB?>';"><i class="fa fa-arrow-left"></i> BACK</button> 
                        <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalSendPageInfo" data-page-url="<?php echo BASE_URL_RSB?>details/<?php echo $property->id?>/<?php echo generateSEOURL($property->property_name)?>/" title="Send this page to family and friends"><i class="fa fa-envelope"></i> SEND TO FRIENDS</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        
                    </div>
                    <div class="col-md-9">
                        <h4 class="property-category-subheading"><?php echo getPropertyCategoryName($property->category_id)?></h4>
                    </div>
                </div>
              <div class="row">
                <div class="col-md-3">
                    <h3 style="padding-top:0px; margin-top:0px;">Description</h3>
                </div>
                <div class="col-md-9">
                    <p><p><i class="fa fa-home"></i> <?php echo $property->property_address?>
                        <?php echo $property->property_city?>, <?php echo $property->property_state?> <?php echo $property->property_zipcode?><br />
                        <?php
                        if ($property->property_phone != '')
                        {
                            ?>
                            <i class="fa fa-phone"></i> <?php echo $property->property_phone?><br />
                            <?php
                        }
                        ?>
                        <?php echo (($property->property_website != '')?('<i class="fa fa-globe"></i>  <a href="http://'.$property->property_website.'" target="_blank">'.$property->property_website.'</a>'):(''))?>
                        <?php
                        if ($category->is_bookable == 1)
                        {
                            if ($property->property_website == '')
                            {
                                ?>
                                <i class="fa fa-hotel"></i> <strong>Call for reservations</strong>
                                <?php
                            }
                        }
                        ?>
                    </p>
                    <h4>Property Highlights</h4>
                    <p><?php echo (($property->property_highlight != '')?($property->property_highlight):('No information available...'))?></p>
                    <h4>Property Details</h4>
                    <p><?php echo (($property->property_description != '')?($property->property_description):('No information available...'))?></p>
                    <div class="row" style="display:none;">
                        <div class="col-md-4 col-sm-4">
                    	 <ul class="list_ok">
                                <li>Coffee machine</li>
                                <li>Wifi</li>
                                <li>Microwave</li>
                                <li>Oven</li>
                            </ul>
                    </div>
                    <div class="col-md-4 col-sm-4">
                    	 <ul class="list_ok">
                                <li>Fridge</li>
                                <li>Hairdryer</li>
                                <li>Towels</li>
                                <li>Toiletries</li>
                            </ul>
                    </div>
                    <div class="col-md-4 col-sm-4">
                    	 <ul class="list_ok">
                                <li>DVD player</li>
                                <li>Air-conditioning</li>
                                <li>Tv</li>
                                <li>Freezer</li>
                            </ul>
                    </div>
                    </div><!-- End row  -->
                    <h4 style="display:none;">Rates</h4>
                     <!-- start pricing table -->
                        <table class="table table-striped" style="display:none;">
                        <tbody>
                        <tr>
                            <td>Daily</td>
                            <td>CALL</td>
                        </tr>
                        <tr>
                            <td>Weekend</td>
                            <td>CALL</td>
                        </tr>
                        <tr>
                            <td>Prime Season</td>
                            <td>CALL</td>
                        </tr>
                        </tbody>
                    </table>
                <!-- BEGIN: Alert Box -->
                <?php
                if ($property->user_id == 0)
                {
                    ?>
                    <div class="row show-on-small" style="display:none;">
                        <div class="col-md-12">
                            <div class="alert alert-warning alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="text-center" style="text-transform:uppercase;"><strong>Is this your business?</strong></h4>
                                <p class="text-center">If this is your business, you can claim it and manage the property listing. Click the button below to claim this business now. You'll need to either create an account or login to your existing account in order to manage this property.</p>
                                <p class="text-center"><a href="<?php echo BASE_URL_RSB.$strClaimURL?>" class="btn btn-md btn-warning" title="Claim this business">CLAIM THIS BUSINESS</a></p>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <!-- END: Alert Box -->
                </div>
                <!-- End col-md-9  -->
            </div>
            <!-- End row  -->
            <hr />
            <!-- BEGIN: Event Calendar -->
            <div class="row">
                <div class="col-md-3">
                    <h3 id="events">Events</h3>
                </div>
                <div class="col-md-9">
                    <?php
                    if (!empty($arrEvents))
                    {
                        foreach ($arrEvents as $events)
                        {
                            $event = toObject($events);
                            ?>
                            <!-- BEGIN: Event Strip -->
                            <div class="review_strip_single">
                                <img src="<?php echo BASE_URL_RSB?>img/calendar-icon.png" alt="" class="calendar-icon" />
                                <small style="font-style:normal;"><?php echo date('m-d-Y h:i a', $event->event_start_date)?> / <?php echo date('m-d-Y h:ia', $event->event_end_date)?></small>
                                <h4><?php echo $event->event_name?></h4>
                                <p><?php echo $event->event_description?></p>
                            </div>
                            <!-- END: Event Strip -->
                        <?php
                        }
                    } else {
                        ?>
                        <!-- BEGIN: Event Strip -->
                        <div class="review_strip_single">
                            <img src="<?php echo BASE_URL_RSB?>img/calendar-icon.png" alt="" class="calendar-icon" />
                            <h4>&nbsp;</h4>
                            <p>No events exist for this property.</p>
                        </div>
                        <!-- END: Event Strip -->
                        <?php
                    }
                    ?>
                </div>
            </div>
            <!-- END: Event Calendar -->
          	<hr />
            <!-- BEGIN: Images -->
            <div class="row">
                <div class="col-md-3">
                    <h3 id="events">Images</h3>
                </div>
                <div class="col-md-9">
                    <div class="col-md-2" style="margin-bottom:5px;">
                        <a data-fancybox="gallery" href="<?php echo PROPERTY_IMAGE_PATH.(($property->image_main != '')?($property->image_main):('no_image.jpg'))?>"><img src="<?php echo PROPERTY_IMAGE_PATH.(($property->image_main != '')?($property->image_main):('no_image.jpg'))?>" class="img-responsive img-rounded preview-thumbnail" alt="image" /></a>
                    </div>
                    <div class="col-md-2" style="margin-bottom:5px;">
                        <a data-fancybox="gallery" href="<?php echo PROPERTY_IMAGE_PATH.(($property->image_1 != '')?($property->image_1):('no_image.jpg'))?>"><img src="<?php echo PROPERTY_IMAGE_PATH.(($property->image_1 != '')?($property->image_1):('no_image.jpg'))?>" class="img-responsive img-rounded preview-thumbnail" alt="image" /></a>
                    </div>
                    <div class="col-md-2" style="margin-bottom:5px;">
                        <a data-fancybox="gallery" href="<?php echo PROPERTY_IMAGE_PATH.(($property->image_2 != '')?($property->image_2):('no_image.jpg'))?>"><img src="<?php echo PROPERTY_IMAGE_PATH.(($property->image_2 != '')?($property->image_2):('no_image.jpg'))?>" class="img-responsive img-rounded preview-thumbnail" alt="image" /></a>
                    </div>
                    <div class="col-md-2" style="margin-bottom:5px;">
                        <a data-fancybox="gallery" href="<?php echo PROPERTY_IMAGE_PATH.(($property->image_3 != '')?($property->image_3):('no_image.jpg'))?>"><img src="<?php echo PROPERTY_IMAGE_PATH.(($property->image_3 != '')?($property->image_3):('no_image.jpg'))?>" class="img-responsive img-rounded preview-thumbnail" alt="image" /></a>
                    </div>
                    <div class="col-md-2" style="margin-bottom:5px;">
                        <a data-fancybox="gallery" href="<?php echo PROPERTY_IMAGE_PATH.(($property->image_4 != '')?($property->image_4):('no_image.jpg'))?>"><img src="<?php echo PROPERTY_IMAGE_PATH.(($property->image_4 != '')?($property->image_4):('no_image.jpg'))?>" class="img-responsive img-rounded preview-thumbnail" alt="image" /></a>
                    </div>
                </div>
            </div>
            <!-- END: Images -->
            <hr />
            <div class="row">
                <div class="col-md-3">
                    <h3>Reviews</h3>
                    <a href="#" class="btn_1 add_bottom_15" data-toggle="modal" data-target="#myReview">Leave a Review</a>
                </div>
                <div class="col-md-9">
                    <?php
                    if (count($arrReviews) > 0)
                    {
                        $cntReviews = count($arrReviews);
                        $avgReviews = '7.5';
                        ?>
                        <div id="score_detail"><span><?php echo $avgReviews?></span>Good <small>(based on <?php echo $cntReviews?> reviews)</small></div>
                        <div class="row" id="rating_summary">
                            <div class="col-md-6">
                                <ul>
                                    <li>Location
                                        <div class="rating">
                                            <i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star-empty"></i><i class="icon-star-empty"></i>
                                        </div>
                                    </li>
                                    <li>Comfort
                                    <div class="rating">
                                            <i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star-empty"></i>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul>
                                    <li>Price
                                    <div class="rating">
                                            <i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star-empty"></i><i class="icon-star-empty"></i>
                                        </div>
                                    </li>
                                    <li>Quality
                                    <div class="rating">
                                            <i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star-empty"></i>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                    </div>
                    <!-- END: Row -->
                    <hr />
                        <?php
                    }

                    if (count($arrReviews) > 0)
                    {
                        foreach ($arrReviews as $reviews)
                        {
                            $review = toObject($reviews);
                            ?>
                            <!-- BEGIN: Review Item -->
                            <div class="review_strip_single">
                                <img src="<?php echo BASE_URL_RSB?>img/review_avatar.png" alt="" class="img-circle img-responsive" />
                                <small><?php echo date('d F Y', $review->updated)?></small>
                                <h4><?php echo $review->first_name?> <?php echo $review->last_name?></h4>
                                <p><?php echo $review->comments?></p>
                                <div class="rating">
                                    <i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star-empty"></i><i class="icon-star-empty"></i>
                                </div>
                            </div>
                            <!-- END: Review Item -->
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
            <hr />
            <!-- BEGIN: Property Map -->
            <div class="row" style="margin-bottom:25px;">
                <div class="col-md-12">
                    <div class="container">
                        <div class="row">
							<div class="col-md-8">
								<div class="map-responsive img-rounded">
									<div id="map"></div>
									<script>
										var myLatLng = {lat:<?php echo $property->property_latitude?>, lng:<?php echo $property->property_longitude?>};
										var customLabel = {
												restaurant: {
													label:'R'
												},
												bar: {
													label:'B'
												},
												landmark: {
													label:'L'
												},
												rv: {
													label:'RV'
												},
												church: {
													label:'C'
												},
												store: {
													label:'S'
												},
												sale: {
													label:'$$'
												},
											};

										function initialize(){
											var map = new google.maps.Map(document.getElementById('map'), {
												zoom: 7,
												center: myLatLng,
												zoomControl: true,
												zoomControlOptions: {style: google.maps.ZoomControlStyle.SMALL},
												scrollwheel: false,
												gestureHandling: 'greedy'
											});

											infoWindow = new google.maps.InfoWindow;

											// Enable mouse wheel scrolling after map click...
											google.maps.event.addListener(map, 'click', function(event){
												this.setOptions({scrollwheel:true});
											});

											// Disable mouse wheel scrolling after mouse out...
											google.maps.event.addListener(map, 'mouseout', function(event){
												this.setOptions({scrollwheel:false});  
											});

											// Initialize the map layers...
											initMap(map);
											//initMarketplaceMap(map);
										}

										function initMap(map){
											var infoWindow = new google.maps.InfoWindow;
											//console.log('<?php echo BASE_URL_RSB?>generate_map_xml.php?lookup=<?php echo $strXMLSearch?>&property_id_search=<?php echo $strPropertyIDSearch?>');
											downloadUrl('<?php echo BASE_URL_RSB?>generate_map_xml.php?lookup=<?php echo $strXMLSearch?>&property_id_search=<?php echo $strPropertyIDSearch?>', function(data){
												var xml = data.responseXML;
												var markers = xml.documentElement.getElementsByTagName('marker');
												Array.prototype.forEach.call(markers, function(markerElem){
													var id = markerElem.getAttribute('id');
													var name = markerElem.getAttribute('name');
													var address = markerElem.getAttribute('address');
													var city = markerElem.getAttribute('city');
													var state = markerElem.getAttribute('state');
													var zipcode = markerElem.getAttribute('zipcode');
													var property_url = markerElem.getAttribute('url');
													var type = markerElem.getAttribute('type');
													var point = new google.maps.LatLng(
														parseFloat(markerElem.getAttribute('lat')),
														parseFloat(markerElem.getAttribute('lng')));
													var infowincontent = document.createElement('div');
													var strong = document.createElement('strong');
													strong.textContent = name;
													infowincontent.appendChild(strong);
													infowincontent.appendChild(document.createElement('br'));
													var text = document.createElement('text');
													text.textContent = address;
													infowincontent.appendChild(text);
													infowincontent.appendChild(document.createElement('br'));
													var text = document.createElement('text');
													text.textContent = city + ',' + state + ' ' + zipcode;
													infowincontent.appendChild(text);
													infowincontent.appendChild(document.createElement('br'));
													var a = document.createElement('a');
													var linkText = document.createTextNode('VIEW MORE INFO...');
													a.appendChild(linkText);
													a.title = 'View property page';
													a.href = property_url;
													a.target = '_blank';
													infowincontent.appendChild(a);
													var icon = customLabel[type] || {};
													var marker = new google.maps.Marker({
														map: map,
														position: point,
														label: icon.label
													});
													marker.addListener('click', function(){
														infoWindow.setContent(infowincontent);
														infoWindow.open(map, marker);
													});
													marker.addListener('mouseover', function(){
														infoWindow.setContent(infowincontent);
														infoWindow.open(map, marker);
													});
													marker.addListener('mouseout', function(){
														//infoWindow.close();
													});
											});
										});
									}

									function initMarketplaceMap(map){
											var infoWindow = new google.maps.InfoWindow;
											//console.log('<?php echo BASE_URL_RSB?>generate_marketplace_map_xml.php?lookup=<?php echo $strXMLSearch?>&property_id_search=<?php echo $strPropertyIDSearch?>');
											downloadUrl('<?php echo BASE_URL_RSB?>generate_marketplace_map_xml.php?lookup=<?php echo $strXMLSearch?>&property_id_search=<?php echo $strPropertyIDSearch?>', function(data){
												var xml = data.responseXML;
												var markers = xml.documentElement.getElementsByTagName('marker');
												Array.prototype.forEach.call(markers, function(markerElem){
													var id = markerElem.getAttribute('id');
													var name = markerElem.getAttribute('name');
													var address = markerElem.getAttribute('address');
													var city = markerElem.getAttribute('city');
													var state = markerElem.getAttribute('state');
													var zipcode = markerElem.getAttribute('zipcode');
													var property_url = markerElem.getAttribute('url');
													var type = markerElem.getAttribute('type');
													var point = new google.maps.LatLng(
														parseFloat(markerElem.getAttribute('lat')),
														parseFloat(markerElem.getAttribute('lng')));
													var infowincontent = document.createElement('div');
													var strong = document.createElement('strong');
													strong.textContent = name;
													infowincontent.appendChild(strong);
													infowincontent.appendChild(document.createElement('br'));
													var text = document.createElement('text');
													text.textContent = address;
													infowincontent.appendChild(text);
													infowincontent.appendChild(document.createElement('br'));
													var text = document.createElement('text');
													text.textContent = city + ',' + state + ' ' + zipcode;
													infowincontent.appendChild(text);
													infowincontent.appendChild(document.createElement('br'));
													var a = document.createElement('a');
													var linkText = document.createTextNode('VIEW MORE INFO...');
													a.appendChild(linkText);
													a.title = 'View property page';
													a.href = property_url;
													a.target = '_blank';
													infowincontent.appendChild(a);
													var icon = customLabel[type] || {};
													var icon_image = '<?php echo BASE_URL_RSB?>markers/money.png';
													var marker = new google.maps.Marker({
														map: map,
														position: point,
														//label: icon.label,
														icon: icon_image
													});
													marker.addListener('click', function(){
														infoWindow.setContent(infowincontent);
														infoWindow.open(map, marker);
													});
													marker.addListener('mouseover', function(){
														infoWindow.setContent(infowincontent);
														infoWindow.open(map, marker);
													});
													marker.addListener('mouseout', function(){
														//infoWindow.close();
													});
											});
										});
									}

									function downloadUrl(url, callback)
									{
										var request = window.ActiveXObject ? new ActiveXObject('Microsoft.XMLHTTP') : new XMLHttpRequest;
										request.onreadystatechange = function()
										{
											if (request.readyState == 4)
											{
												request.onreadystatechange = doNothing;
												callback(request, request.status);
											}
										};
										request.open('GET', url, true);
										request.send(null);
									}

									function handleLocationError(browserHasGeolocation, infoWindow, pos)
									{
										infoWindow.setPosition(pos);
										infoWindow.setContent(browserHasGeolocation ? 'Error: The Geolocation service failed.' : 'Error: Your browser doesn\'t support geolocation.');
										infoWindow.open(map);
									}

									function doNothing(){}
								  </script>
								</div>
							</div>
                        </div>
                    </div>
                </div>
            </div>                
            <hr />
            <!-- END: Property Map -->
            <?php
            if ($category->is_bookable == 1)
            {
                ?>
                <div class="row">
                    <div class="col-md-3">
                        <h3>Policies</h3>
                    </div>
                    <div class="col-md-9">
                    <ul id="policies">
                        <li><i class="icon_set_1_icon-83"></i><h5>Check-in and check-out</h5>
                            <p>Our check-in / check-out times vary by season, but normally our check-in time is 10:00am and check-out time is 3:00pm.</p>
                        </li>
                        <li><i class="icon_set_1_icon-54"></i><h5>Cancellation</h5>
                            <p>You must cancel your reservation at least five days prior to the date of your visit, or you may be subjected to a cancellation fee.</p>
                        </li>
                        <li><i class="icon_set_1_icon-47"></i><h5>Smoking</h5>
                            <p>Smoking is allowed only in the designated smoking areas. Smoking inside property facilities is strictly prohibte.</p>
                        </li>
                        <li><i class="icon_set_1_icon-35"></i><h5>Payments</h5>
                            <p>Payments are due at the time of your reservation. Special arrangements may be allowed on a case-by-case basis.</p>
                        </li>
                        <li><i class="icon_set_1_icon-13"></i><h5>Disabled Accommodations</h5>
                            <p>We strive to offer accomodations for those witha disabled status. If you require special services, please call us to let us know.</p>
                        </li>                    
                        </ul>
                    </div>
                </div>
                <?php 
            }
            ?>
            </div>
            <!-- END: Column -->
            <div class="col-md-4" id="sidebar">
            <div class="theiaStickySidebar">
                <!-- BEGIN: Alert Box -->
                <?php
                if ($property->user_id == 0)
                {
                    ?>
                    <div class="box_style_1">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-warning alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="text-center" style="text-transform:uppercase;"><strong>Is this your business?</strong></h4>
                                    <p class="text-center">If this is your business, you can claim it and manage the property listing. Click the button below to claim this business now. You'll need to either create an account or login to your existing account in order to manage this property.</p>
                                    <p class="text-center"><a href="<?php echo BASE_URL_RSB.$strClaimURL?>" class="btn btn-md btn-warning" title="Claim this business">CLAIM THIS BUSINESS</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <!-- END: Alert Box -->
                <!-- BEGIN: Banner -->
                <div class="box_style_2">
                    <?php
                    if (is_array($arrSkyscrapers) && !empty($arrSkyscrapers))
                    {
                        $cntAdSky = 0;
                        ?>
                            <div id="carousel-advertisements-skyscraper" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner" role="listbox">
                                    <?php
                                    foreach ($arrSkyscrapers as $skyscrapers)
                                    {
                                        $skyscraper = toObject($skyscrapers);
                                        ?>
                                            <div class="item <?php echo (($cntAdSky == 0)?('active'):(''))?>">
                                                <img src="<?php echo AD_IMAGE_PATH.(($skyscraper->image_main != '')?($skyscraper->image_main):('no_image.jpg'))?>" class="img-responsive sidebar-banners" style="margin:0px auto;" alt="banner" />
                                            </div>
                                        <?php
                                        $cntAdSky++;
                                        }
                                        ?>
                                </div>
                            </div>
                        <?php
                        }
                    ?>
                </div>
                <!-- END: Banner -->
                <div class="box_style_2 text-center">
                    <a href="<?php echo BASE_URL_RSB_WIZARD?>ad/" class="btn btn-lg btn-primary" title="Click here to create an advertisement"><i class="fa fa-normal fa-bullhorn" style="font-size:20px;"></i> Create An Advertisement</a>
                </div>
            	<div class="box_style_1">
                    <div id="message-booking"></div>
                    <?php
                    if ($category->is_bookable == 1 && $property->user_id > 0)
                    {
                    ?>
                    <form id="check_available" name="check_avail" action="<?php echo BASE_URL_RSB?>details/<?php echo $property->id?>/<?php echo generateSEOURL($property->property_name)?>/" method="post" role="form">
                        <input type="hidden" id="redirect_url" name="redirect_url" value="<?php echo BASE_URL_RSB?>details/<?php echo $property->id?>/<?php echo generateSEOURL($property->property_name)?>/" />
                        <input type="hidden" id="property_id" name="property_id" value="<?php echo $property->id?>" />
                        <input type="hidden" id="action" name="action" value="add_booking" />
                    	<div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label>Requested Dates</label>
                                    <input class="form-control" type="text" id="dates_booking" name="dates_booking" placeholder="Requested Dates" />
                                    <span class="input-icon"><i class="icon-calendar-7"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        	<div class="col-md-6 col-sm-6 col-xs-6">
                            	<div class="form-group">
                                <label>Adults</label>
                            	   <div class="qty-buttons">
                                        <input type="button" id="adultsMinus" name="adults" class="qtyminus" value="-" />
                                        <input type="text" id="adults" name="adults" class="qty form-control" value="" placeholder="0" />
                                        <input type="button" id="adultsPlus" name="adults" class="qtyplus" value="+" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                            	<div class="form-group">
                                <label>Children</label>
                            	    <div class="qty-buttons">
                                        <input type="button" id="childrenMinus" name="children" class="qtyminus" value="-" />
                                        <input type="text" id="children" name="children" class="qty form-control" value="" placeholder="0" />
                                        <input type="button" id="childrenPlus" name="children" class="qtyplus" value="+" />
                                    </div>
                               </div>
                            </div>
                        </div>
           				<div class="row">
                            <div class="col-md-12 col-sm-12">
                               <div class="form-group">
                            	   <label>Name</label>
                        	 		<input type="text" id="name_booking" name="name_booking" class="form-control" placeholder="First and Last Name" />
                               </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label>Email</label>
                            	 	<input type="text" id="email_booking" name="email_booking" class="form-control" placeholder="Email Address" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label>Comments</label>
                                    <textarea id="notes" name="notes" class="form-control" placeholder="Reservation comments..."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <input type="submit" id="btnSubmitBooking" name="btnSubmitBooking" class="btn_full" value="Book Now" />
                                </div>
                            </div>
                        </div>
                    </form>
                    <hr />
                        <?php
                    }
                    ?>
                    <a href="#0" class="btn_outline">Contact Us</a>
                    <a href="tel://2146999132" id="phone_2"><i class="icon_set_1_icon-91"></i>(214) 699-9132</a>
                </div>
                <!-- END: box_style -->
            </div>
            <!-- END theiaStickySidebar -->
            </div>
            <!-- END: Column -->
        </div>
        <!-- END: Row -->
    </div>
    <!-- END: Container -->
    <div id="dtBox"></div>
    <!-- END: datepicker -->
<!-- BEGIN: Modal Review -->
<div class="modal fade" id="myReview" tabindex="-1" role="dialog" aria-labelledby="myReviewLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 id="myReviewLabel" class="modal-title" style="font-weight:500;">Enter your review...</h4>
            </div>
            <div class="modal-body">
                <div id="message-review">
                </div>
                <form id="frmReview" name="frmReview" action="<?php echo BASE_URL_RSB?>details/<?php echo $property->id?>/<?php echo generateSEOURL($property->property_name)?>/" method="post" role="form">
                    <input type="hidden" id="property_id" name="property_id" value="<?php echo $property->id?>" />
                    <input type="hidden" id="action" name="action" value="add_review" />
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" id="first_name" name="first_name" class="form-control" placeholder="First Name" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Last Name" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="email" id="email_address" name="email_address" class="form-control" placeholder="Email Address" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" id="author_city" name="author_city" class="form-control" placeholder="Where are you from? (City, ST)" />
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Location</label>
                                <select id="review_location" name="review_location" class="form-control">
                                    <option value="0">Please select...</option>
                                    <option value="1">Low</option>
                                    <option value="2">Sufficient</option>
                                    <option value="3">Good</option>
                                    <option value="4">Excellent</option>
                                    <option value="5">Super</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Comfort</label>
                                <select id="review_comfort" name="review_comfort" class="form-control">
                                    <option value="0">Please select...</option>
                                    <option value="1">Low</option>
                                    <option value="2">Sufficient</option>
                                    <option value="3">Good</option>
                                    <option value="4">Excellent</option>
                                    <option value="5">Super</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Price</label>
                                <select id="review_price" name="review_price" class="form-control">
                                    <option value="0">Please select...</option>
                                    <option value="1">Low</option>
                                    <option value="2">Sufficient</option>
                                    <option value="3">Good</option>
                                    <option value="4">Excellent</option>
                                    <option value="5">Super</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Quality</label>
                                <select id="review_quality" name="review_quality" class="form-control">
                                    <option value="0">Please select...</option>
                                    <option value="1">Low</option>
                                    <option value="2">Sufficient</option>
                                    <option value="3">Good</option>
                                    <option value="4">Excellent</option>
                                    <option value="5">Super</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea id="comments" name="comments" class="form-control" style="min-height:100px;" placeholder="Enter your review..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" id="btnSumbitReview" name="btnSubmitReview" class="btn btn-md btn-danger pull-right">SUBMIT</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END: Modal Review -->
<!-- BEGIN: Booking Scripts -->
<script src="<?php echo BASE_URL_RSB?>js/fecha.js"></script>
<script src="<?php echo BASE_URL_RSB?>js/hotel-datepicker.js"></script>
<script type="text/javascript">
/**************************************
 * Initialize booking date picker...
 **************************************/
$(document).ready(function () {
  var date1 = new Date();
  var date2 = new Date();
  var date3 = new Date();
  var date4 = new Date();
  var date5 = new Date();
  var date6 = new Date();
  date1.setDate(date1.getDate() + 3);
  date2.setDate(date2.getDate() + 6);
  date3.setDate(date3.getDate() + 7);
  date4.setDate(date4.getDate() + 8);
  date5.setDate(date5.getDate() + 11);
  date6.setDate(date6.getDate() + 21);
  var booking_dates = new HotelDatepicker(document.getElementById('dates_booking'), {
    <?php
    if (!empty($arrBookedDates))
    {
        ?>
        disabledDates: [
        <?php
        foreach ($arrBookedDates as $key => $val)
        {
            ?>
            '<?php echo $val?>',
            <?php
        }
        ?>
        ]
        <?php
    }
    ?>
  });
});
</script>
<!-- END: Booking Scripts -->
<?php
/************************************
 * Include the HTML footer...
 ************************************/
include ('include/footer.php');
?>