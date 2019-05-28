<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 31-MAY-2018
 * ---------------------------------------------------
 * Trip Planner Page (trip_planner.php)
 *****************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Initialize page data...
 ************************************/
$strPageName = 'trip_planner';
$strPageTitle = 'Trip Planner';

/************************************
 * Initialize data arrays...
 ************************************/
if (isset($arrDirectionData) && !empty($arrDirectionData))
{
	$arrRouteData = $arrDirectionMarkerData['legs'];
	$strRouteTime = $arrDirectionMarkerData['routes']['0']->legs['0']->duration->text;
	$strRouteDistance = $arrDirectionMarkerData['routes']['0']->legs['0']->distance->text;
	$strStart = urlencode(sanitizeData($arrDirectionData['trip_begin'], ',', ' '));
	$strStop = urlencode(sanitizeData($arrDirectionData['trip_end'], ',', ' '));
	$isAutoStart = true;
} else {
	$arrRouteData = array();
	$strStart = '';
	$strStop = '';
	$isAutoStart = false;
}
//showDebug($arrDirectionMarkerData['routes']['0']->legs['0']->distance, 'route geo data', true);

/************************************
 * Check for category map filters...
 ************************************/
if (is_array($arrCategoryFilters) && !empty($arrCategoryFilters))
{
    $arrFilterKeys = array_values($arrCategoryFilters);
} else {
    $arrFilterKeys = array();
}

//showDebug($arrCategoryFilters, 'category map filters', false);
//showDebug($arrFilterKeys, 'category map filters - names', true);

/************************************
 * Include the HTML header...
 ************************************/
include ('include/header.php');
?>
    <section class="parallax-window" id="short" data-parallax="scroll" data-image-src="<?php echo BASE_URL_RSB?>img/rv_camp_003.jpg" data-natural-width="1350" data-natural-height="465">
        <div id="subheader">
            <h1>Trip Planner</h1>
        </div>
    </section>
    <div class="container margin_60" style="margin-top:0px; padding-top:0px;">
      	<h2 class="main_title" style="margin-top:0px; padding-top:0px;"><em></em>Trip <span>Planner</span></h2>
        <center><button class="btn btn-sm btn-success" data-toggle="modal" data-target="#modalSendPageInfo" data-page-url="<?php echo BASE_URL_RSB?>trip-planner/" title="Send this page to family and friends"><i class="fa fa-envelope"></i> SEND TO FRIENDS</button></center>
        <p class="lead styled">Plan your trip by entering information below. You will need to enter a starting point and a destination. Once the route has been selected, properties along the way will appear on the map. You can also select which categories to display on the map. <br /><span style="color:#FF0000; font-size:1em;"><strong>NOTE:</strong> The "start" and "end" input fields must be in the form of "<strong>City, ST</strong>" (ie Boston, MA).</span></p>
        <div class="row">
            <div class="col-md-12">
                <div class="top-header-button-extra">
                    <a class="btn btn-md btn-primary" href="<?php echo BASE_URL_RSB?>register/" role="button">Click here to register for free. You can save trips,<br class="hidden-break" /> add sites, and share pictures with your friends.</a>
                </div>
            </div>
        </div>
    	<!-- BEGIN: Trip Planner Form -->
    	<div class="row">
            <div class="col-md-12" style="margin-top:10px;">
                <form id="frmTripPlanner" name="frmTripPlanner" class="form-inline" method="post" action="<?php echo BASE_URL_RSB?>trip-planner/" role="form">
                <input type="hidden" id="action" name="action" value="do_trip_planner" />
                <input type="hidden" id="selected_categories" name="selected_categories" value="" />
                    <div class="trip-planner-form-container text-center">
    					<div class="form-group" style="padding-right:10px;">
    						<label for="trip_begin">Start </label>
    						<input type="text" class="form-control" id="trip_begin" name="trip_begin" value="<?php echo $arrDirectionData['trip_begin']?>" />
    					</div>
    					<div class="form-group">
    						<label for="trip_end">End </label>
    						<input type="text" class="form-control" id="trip_end" name="trip_end" value="<?php echo $arrDirectionData['trip_end']?>" />
    					</div>
    					<button type="button" id="btnSubmitTripPlanner" name="btnSubmit" class="btn btn-success">Map Route</button>
    				</div>
                </form>
            </div>
      	</div>
      	<!-- END: Trip Planner Form -->
        <!-- BEGIN: Category Selection -->
        <div class="row">
            <div class="col-md-12" style="margin-top:-10px;">
                <p class="text-center red" style="padding:2px; margin:1px;"><strong>You must select the categories you want to see on your route, otherwise you will not see any places along your route.</strong></p>
                <form id="frmDirectionMapOptions" name="frmDirectionMapOptions" action="#" method="post" class="form-inline" style="margin-left:20px; margin-bottom:10px;" role="form">
                <?php
                foreach ($arrPropertyCategories as $categories)
                {
                    $category = toObject($categories);
                    ?>
                    <div class="checkbox auto-width" style="margin-right:30px;">
                        <label>
                            <input type="checkbox" id="chk__<?php echo $category->category_slug?>" name="chk__<?php echo $category->category_slug?>" data-map-filter="<?php echo $category->id?>" value="<?php echo $category->category?>" class="map-filter-object map-form-control pull-left" <?php echo ((in_array($category->category, $arrFilterKeys))?('checked'):(''))?> /> <?php echo $category->category?>
                        </label>
                     </div>
                    <?php
                }
                ?>
                </form>
            </div>
        </div>
        <!-- END: Category Selection -->
      	<!-- BEGIN: Map (row) -->
      	<div class="row">
      		<div class="col-md-12">
                <input type="hidden" id="location_latitude" name="location_latitude" value="33.0237921" />
                <input type="hidden" id="location_longitude" name="location_longitude" value="-96.4637379" />
                <div class="map-responsive img-rounded">
                    <div id="map"></div>
                    <!-- BEGIN: Map Directions -->
                    <script>
                    	var map;
                        var infoWindow;
                    	var myLocation;
                        var tmpLat;
                        var tmpLon;
                        var mapMarkers = [];
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

                        var iconBase = '<?php echo BASE_URL_RSB?>google_map_markers/categories/';
                        var icons = {
                            store: {
                                icon: iconBase + 'bank.png'
                            },
                            antique_store: {
                                icon: iconBase + 'museum_crafts.png'
                            },
                            landmark: {
                                icon: iconBase + 'landmark.png'
                            },
                            bar: {
                                icon: iconBase + 'bar.png'
                            },
                            house: {
                                icon: iconBase + 'house.png'
                            },
                            church: {
                                icon: iconBase + 'church-2.png'
                            },
                            museum: {
                                icon: iconBase + 'museum_art.png'
                            },
                            airport: {
                                icon: iconBase + 'air_fixwing.png'
                            },
                            pet: {
                                icon: iconBase + 'pets.png'
                            },
                            event_venue: {
                                icon: iconBase + 'party-2.png'
                            },
                            golf: {
                                icon: iconBase + 'golfing.png'
                            },
                            restaurant: {
                                icon: iconBase + 'restaurant.png'
                            },
                            rv: {
                                icon: iconBase + 'camping-2.png'
                            },
                            park: {
                                icon: iconBase + 'picnic-2.png'
                            },
                            help: {
                                icon: iconBase + 'information.png'
                            },
                            cemetary: {
                                icon: iconBase + 'cemetary.png'
                            },
                            hospital: {
                                icon: iconBase + 'hospital-building.png'
                            },
                            boat: {
                                icon: iconBase + 'boat.png'
                            },
                            post_office: {
                                icon: iconBase + 'postal.png'
                            },
                            coffee: {
                                icon: iconBase + 'coffee.png'
                            },
                            hotel: {
                                icon: iconBase + 'hotel_0star.png'
                            },
                            theatre: {
                                icon: iconBase + 'theater.png'
                            },
                            liquor: {
                                icon: iconBase + 'liquor.png'
                            },
                            art_gallery: {
                                icon: iconBase + 'artgallery.png'
                            },
                            zoo: {
                                icon: iconBase + 'zoo.png'
                            },
							laundromat: {
                                icon: iconBase + 'laundromat.png'
                            }
                        };

                        var options = {
                            enableHighAccuracy: true,
                            timeout: 5000,
                            maximumAge: 3600000
                        };

                        function sleep(milliseconds)
                        {
                            var start = new Date().getTime();
                            for (var i = 0; i < 1e7; i++)
                            {
                                if ((new Date().getTime() - start) > milliseconds)
                                {
                                    break;
                                }
                            }
                        }

                        function showMyLocation(position){
                            console.log('LOCATION IN FUNCTION: ' + position.coords.latitude + ', ' + position.coords.longitude)
                            $('#location_latitude').val(position.coords.latitude);
                            $('#location_longitude').val(position.coords.longitude);
                            //alert('Your position is ' + position.coords.latitude + ', ' + position.coords.longitude);
                        }

                        function noLocationAvailable(error){
                            //alert('No location information available. Error code: ' + error.code);
                        }

                      	function initialize(){
                      		map = new google.maps.Map(document.getElementById('map'), {
				          		zoom: 6,
				          		center: myLocation,
				          		zoomControl: true,
				          		zoomControlOptions: {style: google.maps.ZoomControlStyle.SMALL},
				          		scrollwheel: false,
                                gestureHandling: 'cooperative'
				        	});

                            // Initialize the HTML geolocation...
                            if (navigator.geolocation)
                            {
                                navigator.geolocation.getCurrentPosition(function(position){
                                    var myLocation = {
                                        lat: position.coords.latitude,
                                        lng: position.coords.longitude
                                    };

                                    var iconMyLocation = {
                                        url: '<?php echo BASE_URL_RSB?>google_map_markers/blue_map_marker.png',
                                        scaledSize: new google.maps.Size(20, 32),
                                        origin: new google.maps.Point(0,0),
                                        anchor: new google.maps.Point(0, 0)
                                    };

                                    var marker = new google.maps.Marker({
                                        map: map,
                                        position: myLocation,
                                        zIndex: google.maps.Marker.MAX_ZINDEX + 5,
                                        icon: iconMyLocation
                                    });
                                    map.setCenter(myLocation);
                                }, function(){
                                    handleLocationError(true, infoWindow, map.getCenter());
                                });
                            } else {
                                handleLocationError(false, infoWindow, map.getCenter());
                            }

                            function handleLocationError(browserHasGeolocation, infoWindow, pos){
                                //infoWindow.setPosition(pos);
                                //infoWindow.setContent(browserHasGeolocation ? 'Error: The Geolocation service failed.' : 'Error: Your browser doesn\'t support geolocation.');
                                //infoWindow.open(map);
                            }

				        	<?php
				        	if ($isAutoStart === true)
				        	{
				        		?>
				        		initMap(map);
				        		initMapProperties(map);
				        		<?php
				        	}
				        	?>

				        	// Enable mouse wheel scrolling after map click...
                            google.maps.event.addListener(map, 'click', function(event){
                                this.setOptions({scrollwheel:true});
                            });

                            // Disable mouse wheel scrolling after mouse out...
                            google.maps.event.addListener(map, 'mouseout', function(event){
                                this.setOptions({scrollwheel:false});  
                            });
                      	}

				      	function initMap(map){
				        	var directionsService = new google.maps.DirectionsService;
				        	var directionsDisplay = new google.maps.DirectionsRenderer;
                            infoWindow = new google.maps.InfoWindow;
				        	directionsDisplay.setMap(map);
				        	<?php
				        	if ($isAutoStart === true)
				        	{
				        		?>
				        		calculateAndDisplayRoute(directionsService, directionsDisplay);
				        		<?php
				        	}
				        	?>
				      	}

				      	function calculateAndDisplayRoute(directionsService, directionsDisplay){
				        	directionsService.route({
				          		origin: '<?php echo $strStart?>',
				          		destination: '<?php echo $strStop?>',
				          		travelMode: 'DRIVING'
				        	}, function(response, status){
				          		if (status === 'OK')
				          		{
				            		directionsDisplay.setDirections(response);
				          		} else {
				            		//alert('Directions request failed due to ' + status);
				          		}
				        	});
				      	};
				    	// END: Map Directions...
				    	// BEGIN: Map Properties...
	                    function initMapProperties(map){
	                    	infoWindow = new google.maps.InfoWindow;
	                    	//console.log('<?php echo BASE_URL_RSB?>generate_map_xml.php?lookup=<?php echo $strXMLSearch?>&property_id_search=<?php echo $strPropertyIDSearch?>');
	                    	downloadUrl('<?php echo BASE_URL_RSB?>generate_map_xml.php?lookup=<?php echo $strXMLSearch?>&property_id_search=<?php echo $strPropertyIDSearch?>', function(data) {
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
                                    var text = document.createElement('text');
                                    text.textContent = name;
                                    infowincontent.appendChild(text);
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
                                    //var icon = customLabel[type] || {};
                                    var marker = new google.maps.Marker({
                                        map: map,
                                        position: point,
                                        //label: icon.label,
                                        zIndex: google.maps.Marker.MAX_ZINDEX + 1,
                                        //icon: '<?php echo BASE_URL_RSB?>google_map_markers/blue_MarkerP.png',
                                        icon: icons[type].icon
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
                                        setTimeout(function(){
                                            infoWindow.close();
                                        }, 5000);
                                    });
	                        	});
	                      	});
						}

					function initMapPropertyListings(map){
                            infoWindow = new google.maps.InfoWindow;
                            startLat = parseFloat($('#location_latitude').val());
                            startLon = parseFloat($('#location_longitude').val());
                            downloadUrl('<?php echo BASE_URL_RSB?>generate_map_xml.php?lookup=<?php echo $strXMLSearch?>&geoLatitude=' + startLat + '&geoLongitude='+startLon, function(data){
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
                                    var text = document.createElement('text');
                                    text.textContent = name;
                                    infowincontent.appendChild(text);
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
                                        setTimeout(function(){
                                            infoWindow.close();
                                        }, 5000);
                                    });
                            });
                        });
                    }

                    /**************************************
                     * Update Google map content...
                     **************************************/
                    function updateMapContent(category)
                    {
                      console.log(strURL+'generate_map_xml.php?category_lookup='+category);
                      downloadUrl(strURL+'generate_map_xml.php?category_lookup='+category, function(data){
                        var xml = data.responseXML;
                        var markers = xml.documentElement.getElementsByTagName('marker');
                        Array.prototype.forEach.call(markers, function(markerElem){
                            var id = markerElem.getAttribute('id');
                            var cat = markerElem.getAttribute('cat');
                            var cat_id = markerElem.getAttribute('cat_id');
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
                            var text = document.createElement('text');
                            text.textContent = name;
                            infowincontent.appendChild(text);
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
                                //label: icon.label,
                                icon: icons[type].icon,
                                marker_category: cat,
                                marker_category_id: cat_id
                            });
                            mapMarkers.push(marker);
                            marker.addListener('click', function(){
                                infoWindow.setContent(infowincontent);
                                infoWindow.open(map, marker);
                            });
                            marker.addListener('mouseover', function(){
                                infoWindow.setContent(infowincontent);
                                infoWindow.open(map, marker);
                            });
                            marker.addListener('mouseout', function(){
                                setTimeout(function(){
                                    infoWindow.close();
                                }, 3000);
                            });
                        });
                      });
                    }

                    /**************************************
                     * Check if filter has been clicked...
                     **************************************/
                    $(document).ready(function(){
                        $('.map-filter-object').on('click', function(){
                            var filter_id = $(this).attr('data-map-filter');
                            if ($(this).is(':checked'))
                            {
                                updateMapContent(filter_id);
                            } else {
                                hideMapMarker(filter_id);
                            }
                        });
                    });

                    /**************************************
                     * Display markers on map...
                     **************************************/
                    function showMapMarker(category)
                    {
                      for (var i=0; i < gmarkers.length; i++)
                      {
                        if (gmarkers[i].mycategory == category)
                        {
                          gmarkers[i].setVisible(true);
                        }
                      }
                    }

                    /**************************************
                     * Hide markers on map...
                     **************************************/
                    function hideMapMarker(category)
                    {
                        for (var i=0; i < mapMarkers.length; i++)
                        {
                            if (mapMarkers[i].marker_category_id == category)
                            {
                                mapMarkers[i].setVisible(false);
                            }
                        }
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
                  <!-- END: Map Properties -->
                </div>
      		</div>
      	</div>
      	<!-- END: Map (row) -->
 		<!-- BEGIN: Route Details -->
 		<div class="row">
 			<div class="col-md-12 shadowed-box img-rounded">
 				<h1 class="main_title"><em></em>Route Details</h1>
 				<div class="row" style="margin-top:25px;">
 					<div class="col-md-2">
 						<strong>Total Distance:</strong> <?php echo $strRouteDistance?>
 					</div>
 					<div class="col-md-3">
 						<strong>Total Time:</strong> <?php echo $strRouteTime?>
 					</div>
 				</div>
 				<table class="table table-hover table-condensed account-data-table" style="margin-top:25px;">
                 	<thead>
	                    <tr>
	                      <th>Time</th>
	                      <th>Distance</th>
	                      <th>Details</th>
	                    </tr>
	                  </thead>
	                  <tbody>
	                    <?php
	                    if (count($arrRouteData) > 0)
	                    {
	                        foreach ($arrRouteData as $routes)
	                        {
	                            ?>
	                            <tr>
	                              <td><?php echo $routes->duration->text?></td>
	                              <td><?php echo $routes->distance->text?></td>
	                              <td><?php echo $routes->html_instructions?></td>
	                            </tr>
	                            <?php
	                        }
	                    } else {
	                        ?>
	                        <tr><td colspan="3">No routes exist.</td></tr>
	                        <?php
	                    }
	                    ?>
	                </tbody>
	             </table>
 			</div>
 		</div>
 		<!-- END: Route Details -->
 		<!-- BEGIN: Action BUttons -->
 		<div class="row">
 			<div class="col-md-12 text-center">
 				<?php
 				if ($isAutoStart === true)
 				{
 					?>
 					<button type="button" class="btn btn-lg btn-success" style="margin-top:25px; margin-right:25px;" onclick="window.print();"><i class="fa fa-print"></i> Print This Information</button>
					<?php
                    if (loggedIn() && isset($_SESSION['current_trip_planner']))
                    {
                        ?>
                        <button type="button" id="btn-save-trip-data" class="btn btn-lg btn-danger" data-start="<?php echo urlencode($arrDirectionData['trip_begin'])?>" data-end="<?php echo urlencode($arrDirectionData['trip_end'])?>" style="margin-top:25px;"><i class="fa fa-save"></i> Save Trip Informastion</button>
                        <?php
                    } else {
                        ?>
                        <p class="medium-font" style="margin-top:20px;">Would you like to save your trip route or edit it later?  If so, <a href="<?php echo BASE_URL_RSB?>register/"><strong>create an account</strong></a> with a username and password.</p>
                        <?php
                    }
 				}
 				?>
 			</div>
 		</div>
 		<!-- END: Action Buttons Details -->
 		<div class="divider-thin hidden-xs"></div>
	</div>
	<!-- END: container -->
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