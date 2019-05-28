<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 03-APR-2018
 * ---------------------------------------------------
 * Home Page (index.php)
 *****************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Initialize page data...
 ************************************/
$strPageName = 'home';
$strPageTitle = 'Home';

/************************************
 * Process search parameters...
 ************************************/
if ($strPropertyCategory != '')
{
    $strXMLSearch = serialize(array('property_category' => $strPropertyCategory));
}

/************************************
 * Check for multiple categories...
 ************************************/
if (isset($strXMLSearch))
{
    $arrTemp = unserialize($strXMLSearch);
    if (is_array($arrTemp['property_category']) && !empty($arrTemp['property_category']))
    {
        $arrCategorySelect = $arrTemp['property_category'];
    }
}

/************************************
 * Initialize data arrays...
 ************************************/
$arrProperties = generatePropertes(25, false, false, true);
$arrPropertiesDDL = getUserPropertyDataList(1, true);
$arrTrivia = generateJokes(false, 1, 25);
$arrBanners = generateAdvertisements(2, false, 10);
$arrSkyscrapers = generateAdvertisements(0, false, 10);

/************************************
 * Include the HTML header...
 ************************************/
include ('include/header.php');
?>
    <!-- BEGIN: Header Map -->
    <div class="parallax-window" id="booking-header" data-parallax="scroll" data-image-src="<?php echo BASE_URL_RSB . $arrSliderImages[$intSlider]?>" data-natural-width="1400" data-natural-height="550">
        <div id="subheader_home">
            <div class="container push-top-55">
                <!--BEGIN: Camopground / RV Park Search Parallax (body) -->
                <div class="row row-custom">
                    <div class="col-md-12 home-body-campground-parallax">
                        <div class="header-help-text-body-wrapper">
                            <div class="header-help-text-body-campground text-center">
                                Book a Camprground or RV Park
                            </div>
                        </div>
                        <form id="frmHomeBookRVPark" name="frmHomeBookRVPark" method="post" action="<?php echo BASE_URL_RSB?>reservation-destinations/" role="form" autocomplete="off">
                            <input type="hidden" id="action" name="action" value="home_rv_park_search" />
                            <div id="group_1">
                                <div id="container_1">
                                    <label>Place Name</label>
                                    <input id="campground_name_search" name="campground_name_search" type="text" class="form-control" placeholder="&#xf002;" value="" title="Search for a campground" />
                                </div>
                            </div>
                            <div id="group_2">
                                <div id="container_2">
                                    <label>City</label>
                                    <input type="text" class="form-control" name="property_city" id="property_city" placeholder="City" value="<?php echo (($strPropertyCity != '')?($strPropertyCity):(''))?>" />
                                </div>
                                <div id="container_3">
                                    <label>State</label>
                                    <select id="property_state" name="property_state" class="form-control">
                                        <option value="">Select . . .</option>
                                        <?php
                                        foreach ($arrStates as $key => $val)
                                        {
                                            ?>
                                            <option value="<?php echo $key?>"<?php echo (($strPropertyState == $key)?(' selected="selected"'):(''))?>><?php echo $val?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div id="container_4">
                                    <label>Zipcode</label>
                                    <input type="text" class="form-control" name="property_zipcode" id="property_zipcode" placeholder="Zipcode" value="<?php echo (($strPropertyZipcode != '')?($strPropertyZipcode):(''))?>" />
                                </div>
                            </div>
                            <div class="form-action-wrapper-booking">
                                <div id="container_5_booking_body" style="padding-left:10px; padding-right:15px;">
                                    <input type="button" id="btnReset" name="btnReset" value="Reset" class="btn_1 pull-left" onclick="location.href='<?php echo BASE_URL_RSB?>';" />
                                    <input type="submit" id="btnSubmit" name="btnSubmit" value="Search" class="btn_1 pull-right" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!--END: Campground / RV Park Search Parallax (body) -->
                <div class="row">
                    <div class="col-md-12">
                        <input type="hidden" id="location_latitude" name="location_latitude" value="33.0237921" />
                        <input type="hidden" id="location_longitude" name="location_longitude" value="-96.4637379" />
                        <div class="img-rounded">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="map" class="img-rounded"></div>
                                    <div id="legend"></div>
                                </div>
                            </div>
                            <script>
                                var map;
                                var marker;
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

                                function showMyLocation(position)
                                {
                                    $('#location_latitude').val(position.coords.latitude);
                                    $('#location_longitude').val(position.coords.longitude);
                                }

                                function noLocationAvailable(error)
                                {
                                    //alert('No location information available. Error code: ' + error.code);
                                }

                                function iPhoneVersion()
                                {
                                    var iHeight = window.screen.height;
                                    var iWidth = window.screen.width;
                                    if (iWidth === 320 && iHeight === 480)
                                    {
                                        return '4';
                                    } else if (iWidth === 375 && iHeight === 667) {
                                        return '6';
                                    } else if (iWidth === 414 && iHeight === 736) {
                                        return '6+';
                                    } else if (iWidth === 320 && iHeight === 568) {
                                        return '5';
                                    } else if (iHeight <= 480) {
                                        return '2-3';
                                    }
                                    return 'none';
                                }

                                function isIphone()
                                {
                                    return !!navigator.userAgent.match(/iPhone/i);
                                }

                                function initialize()
                                {
                                    map = new google.maps.Map(document.getElementById('map'), {
                                        zoom: 9,
                                        center: myLocation,
                                        zoomControl: true,
                                        zoomControlOptions: {style: google.maps.ZoomControlStyle.SMALL},
                                        scrollwheel: false,
                                        gestureHandling: 'cooperative'
                                    });
                                        
                                    // Initialize the HTML geolocation service...
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

                                    function handleLocationError(browserHasGeolocation, infoWindow, pos)
                                    {
                                        // Do something...
                                    }

                                    // Enable mouse wheel scrolling after map click...
                                    google.maps.event.addListener(map, 'click', function(event){
                                        this.setOptions({scrollwheel:true});
                                    });

                                    // Disable mouse wheel scrolling after mouse out...
                                    google.maps.event.addListener(map, 'mouseout', function(event){
                                        this.setOptions({scrollwheel:false});  
                                    });

                                    // Initialize the map layers...
                                    if (isIphone())
                                    {
                                        initMap(map);
                                    } else {
                                        initMap(map);
                                    }
                                    updateMapContent(24);

                                    // Initialze the map legend...
                                    var legend = document.getElementById('legend');
                                    var l_div = document.createElement('div');
                                    var legendAdData = '';
                                    <?php
                                    if (is_array($arrSkyscrapers) && !empty($arrSkyscrapers))
                                    {
                                        $cntAdSky = 0;
                                        ?>
                                            legendAdData += '<div id="carousel-advertisements-skyscraper" class="carousel slide" data-ride="carousel" "data-interval="60000"><div class="carousel-inner" style="border-radius:0px;" role="listbox">';
                                                    <?php
                                                    foreach ($arrSkyscrapers as $skyscrapers)
                                                    {
                                                        $skyscraper = toObject($skyscrapers);
                                                        $strPropertyName = getPropertyName($skyscraper->property_id);
                                                        ?>
                                                            ad_navigate = ' onclick="location.href=\'<?php echo BASE_URL_RSB?>details/<?php echo $skyscraper->property_id?>/<?php echo generateSEOURL($strPropertyName)?>/\';"';
                                                            legendAdData += '<div class="item <?php echo (($cntAdSky == 0)?('active'):(''))?>"><img src="<?php echo AD_IMAGE_PATH.(($skyscraper->image_main != '')?($skyscraper->image_main):('no_image.jpg'))?>" class="img-responsive map-sidebar-banner" style="border-radius:0px;" alt="image" '+ad_navigate+' /></div>';
                                                        <?php
                                                        $cntAdSky++;
                                                        }
                                                        ?>
                                                legendAdData += '</div></div>';
                                        <?php
                                        }
                                    ?>
                                    l_div.innerHTML = '<button type="button" id="btnCloseLegend" name="btnCloseLegend" class="btn btn-sx btn-danger" style="float:right; position:absolute; right:0px; top:0px; z-index:9999;" title="close" onclick="hideLegend(' +"'"+ 'legend' +"'" +', this)"><i class="fa fa-close"></i></button>' + legendAdData;
                                    legend.appendChild(l_div);
                                    map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend);
                                }

                                function hideLegend(id, btn)
                                {
                                    var el = document.getElementById(id);
                                    var btn = document.getElementById(btn.id);
                                    el.style.display = 'none';
                                }

                                function initMap(map)
                                {
                                    tmpLat = parseFloat($('#location_latitude').val());
                                    tmpLon = parseFloat($('#location_longitude').val());
                                    var startLat = tmpLat;
                                    var startLon = tmpLon;
                                    infoWindow = new google.maps.InfoWindow;
                                }

                            function initMarketplaceMap(map)
                            {
                                infoWindow = new google.maps.InfoWindow;
                                downloadUrl('<?php echo BASE_URL_RSB?>generate_marketplace_map_xml.php?lookup=<?php echo $strXMLSearch?>', function(data){
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
                                        var icon_image = '<?php echo BASE_URL_RSB?>markers/money.png';
                                        var marker = new google.maps.Marker({
                                            map: map,
                                            position: point,
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
                              //console.log(strURL+'generate_map_xml.php?category_lookup='+category);
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
                                    infowincontent.setAttribute('class', 'info-window');
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
                                    a.setAttribute('class', 'info-window-link');
                                    infowincontent.appendChild(a);
                                    var icon = customLabel[type] || {};
                                    var marker = new google.maps.Marker({
                                        map: map,
                                        position: point,
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
                                        }, 5000);
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

                            function handleLocationError(browserHasGeolocation, infoWindow, pos)
                            {
                                infoWindow.setPosition(pos);
                                infoWindow.setContent(browserHasGeolocation ? 'Error: The geolocation service failed.' : 'Error: Your browser doesn\'t support geolocation.');
                                infoWindow.open(map);
                            }

                            /**************************************
                             * Google Maps download function...
                             **************************************/
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

                            function doNothing(){}
                          </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Header Map -->
    <!-- BEGIN: Traveler CTA -->
    <div class="container push-top-25">
        <div class="row">
            <div class="col-md-12 top-header-button-wrapper text-center">
                <div class="top-header-button">
                    <a class="btn btn-success btn-md" href="<?php echo BASE_URL_RSB?>register/" role="button">Travelers click here to register for free. You can <br class="hidden-break" />save trips, add sites, send messages &amp; pictures<br class="hidden-break" /> to friends.</a>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Traveler CTA -->
    <!-- BEGIN: Trip Planner Form -->
    <div class="container margin_20_35">
        <div class="row">
            <div class="col-md-12">
                <h1 class="main_title text-center"><em></em>Trip Planner</h1>
                <form id="frmTripPlanner" name="frmTripPlanner" class="form-inline" method="post" action="<?php echo BASE_URL_RSB?>trip-planner/" role="form">
                    <input type="hidden" id="action" name="action" value="do_trip_planner" />
                    <div class="trip-planner-form-container text-center">
                        <div class="form-group" style="padding-right:10px;">
                            <label for="trip_begin" class="fa-right-5">Start </label>
                            <input type="text" class="form-control" id="trip_begin" name="trip_begin" placeholder="City, ST" value="" />
                        </div>
                        <div class="form-group">
                            <label for="trip_end" class="fa-right-5">End </label>
                            <input type="text" class="form-control" id="trip_end" name="trip_end" placeholder="City, ST" value="" />
                        </div>
                        <button type="submit" id="btnSubmit" name="btnSubmit" class="btn btn-primary">Map Route</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END: Trip Planner Form -->
        <!-- BEGIN: Map Filters -->
        <div class="row">
            <div class="col-md-12 text-center" style="margin-bottom:-10px; margin-top:0px;">
                <p class="lead-styled red" style="font-size:1.5em;">Which business categories do you want to see on your route?</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form id="frmMapOptions" name="frmMapOptions" action="#" method="post" class="form-inline" style="margin-left:20px; margin-bottom:10px;" role="form">
                <?php
                foreach ($arrPropertyCategories as $categories)
                {
                    $category = toObject($categories);
                    $strFilterChecked = (($category->id == 24) ? ('checked="checked"') : (''));
                    ?>
                    <div class="checkbox auto-width" style="margin-right:30px;">
                        <label>
                            <input type="checkbox" <?php echo $strFilterChecked?> id="chk__<?php echo $category->category_slug?>" name="chk__<?php echo $category->category_slug?>" data-map-filter="<?php echo $category->id?>" value="<?php echo $category->category?>" class="map-filter-object map-form-control pull-left" /> <?php echo $category->category?>
                        </label>
                     </div>
                    <?php
                }
                ?>
                </form>
            </div>
        </div>
    </div>
    <!-- END: Map Filters -->
    <!-- BEGIN: Welcome Hero -->
    <div class="container margin_20_35" style="margin-bottom:-15px; display:none;">
        <h1 class="main_title">Welcome to Book My Spot Online</h1>
        <p class="lead styled">Book My Spot Online provides convenient access to finding that perfect place to stay while on the road. A leading destination for discovering, exploring, and booking RV parks, cabins, bed &amp; breakfasts, and other rental options, the site guides visitors in planning their road trip and outdoor adventures. From family, group, and individual travel guides, to camping, hiking, fishing, and other activity trips, BookMySpotOnline.com is the go-to resource for wherever you're going.</p>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="top-header-button-extra-home">
                    <a class="btn btn-danger btn-md" href="<?php echo BASE_URL_RSB?>add-property/" target="_blank" role="button">Business Owners Click Here To Add Your Site - <br class="hidden-break" />Basic Listing Is FREE!</a>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Welcome Hero -->
    <!-- BEGIN: Jokes and Trivia -->
    <?php
    if (is_array($arrTrivia) && !empty($arrTrivia))
    {
        ?>
        <div class="container margin_20_35">
            <div class="row">
                <div class="col-md-12">
                    <div class="jumbotron">
                        <h1 class="green">Here's a Little Trivia...</h1>
                        <?php
                        foreach ($arrTrivia as $trivias)
                        {
                            $trivia = toObject($trivias);
                            ?>
                            <h3 class="orange"><?php echo $trivia->content_name?></h3>
                            <p><?php echo $trivia->content_data?></p>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
    <!-- END: Jokes and Trivia -->
    <!-- BEGIN: Advertisements -->
    <?php
    if (is_array($arrBanners) && !empty($arrBanners))
    {
        $cntAd = 0;
        ?>
        <div class="container margin_20_35">
            <div class="row">
                <div class="col-md-12">
                    <div class="jumbotron">
                        <h1 class="green">Advertisement</h1>
                        <div id="carousel-advertisements" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators" style="display:none;">
                                <li data-target="#carousel-advertisements" data-slide-to="0" class="active"></li>
                                <li data-target="#carousel-advertisements" data-slide-to="1"></li>
                                <li data-target="#carousel-advertisements" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner" role="listbox">
                        <?php
                        foreach ($arrBanners as $banners)
                        {
                            $banner = toObject($banners);
                            ?>
                                <div class="item <?php echo (($cntAd == 0)?('active'):(''))?>">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h3 class="orange text-right"><a href="<?php echo BASE_URL_RSB?>details/<?php echo $banner->property_id?>/<?php echo generateSEOURL(getPropertyName($banner->property_id))?>/" class="orange" title="View business details"><?php echo getPropertyName($banner->property_id)?></a></h3>
                                            <p class="text-right"><?php echo $banner->content?></p>
                                        </div>
                                        <div class="col-md-6">
                                            <img src="<?php echo AD_IMAGE_PATH.(($banner->image_main != '')?($banner->image_main):('no_image.jpg'))?>" class="img-responsive img-rounded medium-preview-thumbnail" alt="image" />
                                        </div>
                                    </div>
                                </div>
                            <?php
                            $cntAd++;
                            }
                            ?>
                            </div>
                            <a class="left carousel-control" href="#carousel-advertisements" role="button" data-slide="prev" style="display:none;"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span><span class="sr-only">Previous</span></a>
                            <a class="right carousel-control" href="#carousel-advertisements" role="button" data-slide="next" style="display:none;"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span><span class="sr-only">Next</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
    <!-- END: Advertisements -->
    <!-- BEGIN: Property Owners -->
    <div class="container margin_20_35" style="display:none;">
        <div class="row">
            <div class="col-md-12">
                <div class="jumbotron">
                    <h1 class="orange">Business Owners Add Your Site...</h1>
                    <p>In order to add your own site, you will first need to <a href="<?php echo BASE_URL_RSB?>register/" title="Click here to register" class="text-primary">create an account</a> or <a href="<?php echo BASE_URL_RSB?>login/" title="Click here to login" style="color:#ed5434;">log in</a> to your existing one. we have different subscription plans available. After you signup you will have the option to add the subscription plan that fits your needs.</p>
                    <div class="text-center">
                        <button type="button" class="btn btn-danger btn-lg" onclick="window.open('<?php echo BASE_URL_RSB?>add-property/');" >Business Owners Click Here<br class="hidden-break" /> To Add Your Site<br class="hidden-break" /> - Basic Listing Is FREE!</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Property Owners -->
    <!-- BEGIN: Create Advertisement -->
    <div class="container margin_20_35">
        <div class="row">
            <div class="col-md-12">
                <div class="jumbotron">
                    <h1 class="text-primary">Business Owners Advertise Your Site...</h1>
                    <p>In order to create an advertisement for your site, you will first need to <a href="<?php echo BASE_URL_RSB?>register/" title="Click here to register" class="text-primary">create an account</a> or <a href="<?php echo BASE_URL_RSB?>login/" title="Click here to login" style="color:#ed5434;">log in</a> to your existing one. We have different advertising subscription plans available. After you signup you will have the option to add or claim your business so that you can create an advertisement for it.</p>
                    <div class="text-center">
                        <button type="button" class="btn btn-primary btn-lg" onclick="window.open('<?php echo BASE_URL_RSB_WIZARD?>ad/');" >Business Owners Click Here<br class="hidden-break" /> To Advertise Your Site<br class="hidden-break" /> - Plans start at $20.00 per year!</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Create Advertisement -->
    <!-- BEGIN: Van Life -->
    <h1 class="main_title"><em></em>Enjoying Van Life or Van Camping?</h1>
    <div class="container margin_20_35">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div id="carousel-van-camping" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carousel-van-camping" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-van-camping" data-slide-to="1"></li>
                        <li data-target="#carousel-van-camping" data-slide-to="2"></li>
                        <li data-target="#carousel-van-camping" data-slide-to="3"></li>
                        <li data-target="#carousel-van-camping" data-slide-to="4"></li>
                        <li data-target="#carousel-van-camping" data-slide-to="5"></li>
                        <li data-target="#carousel-van-camping" data-slide-to="6"></li>
                        <li data-target="#carousel-van-camping" data-slide-to="7"></li>
                        <li data-target="#carousel-van-camping" data-slide-to="8"></li>
                        <li data-target="#carousel-van-camping" data-slide-to="9"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="item active">
                            <img src="<?php echo BASE_URL_RSB?>img/van-camping/camping_van_001.jpg" alt="image" />
                            <div class="carousel-caption">
                                <h2>Camping Van</h2>
                            </div>
                        </div>
                        <div class="item">
                            <img src="<?php echo BASE_URL_RSB?>img/van-camping/camping_van_002.jpg" alt="image" />
                            <div class="carousel-caption">
                                <h2>Camping Van</h2>
                            </div>
                        </div>
                        <div class="item">
                            <img src="<?php echo BASE_URL_RSB?>img/van-camping/camping_van_003.jpg" alt="image" />
                            <div class="carousel-caption">
                                <h2>Camping Van</h2>
                            </div>
                        </div>
                        <div class="item">
                            <img src="<?php echo BASE_URL_RSB?>img/van-camping/camping_van_004.jpg" alt="image" />
                            <div class="carousel-caption">
                                <h2>Camping Van</h2>
                            </div>
                        </div>
                        <div class="item">
                            <img src="<?php echo BASE_URL_RSB?>img/van-camping/camping_van_005.jpg" alt="image" />
                            <div class="carousel-caption">
                                <h2>Camping Van</h2>
                            </div>
                        </div>
                        <div class="item">
                            <img src="<?php echo BASE_URL_RSB?>img/van-camping/camping_van_006.jpg" alt="image" />
                            <div class="carousel-caption">
                                <h2>Camping Van</h2>
                            </div>
                        </div>
                        <div class="item">
                            <img src="<?php echo BASE_URL_RSB?>img/van-camping/camping_van_007.jpg" alt="image" />
                            <div class="carousel-caption">
                                <h2>Camping Van</h2>
                            </div>
                        </div>
                        <div class="item">
                            <img src="<?php echo BASE_URL_RSB?>img/van-camping/camping_van_008.jpg" alt="image" />
                            <div class="carousel-caption">
                                <h2>Camping Van</h2>
                            </div>
                        </div>
                        <div class="item">
                            <img src="<?php echo BASE_URL_RSB?>img/van-camping/camping_van_009.jpg" alt="image" />
                            <div class="carousel-caption">
                                <h2>Camping Van</h2>
                            </div>
                        </div>
                        <div class="item">
                            <img src="<?php echo BASE_URL_RSB?>img/van-camping/camping_van_010.jpg" alt="image" />
                            <div class="carousel-caption">
                                <h2>Camping Van</h2>
                            </div>
                        </div>
                    </div>
                    <a class="left carousel-control" href="#carousel-van-camping" data-slide="prev"><i class="fa fa-chevron-left"></i></a>
                    <a class="right carousel-control" href="#carousel-van-camping" data-slide="next"><i class="fa fa-chevron-right"></i></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center" style="margin-top:15px;">
                <button type="button" class="btn btn-primary btn-lg"><i class="fa fa-share-alt"></i> Click Here To Share Your<br class="hidden-break" /> Adventures With Fellow Travelers</button>
            </div>
        </div>
    </div>
    <!-- END: Van Life -->
    <!--BEGIN: Property Search Parallax (body) -->
    <h1 class="main_title" style="margin-top:25px;"><em></em>Find A Property Or Location</h1>
    <div class="row row-custom">
        <div class="col-md-12 home-body-parallax">
            <div class="header-help-text-body-wrapper">
                <div class="header-help-text-body text-center">
                    Find a specific business, attraction, or location by selecting the boxes below
                </div>
            </div>
            <form id="check_avail_home_body" name="check_avail_home_body" method="post" action="<?php echo BASE_URL_RSB?>" role="form" autocomplete="off">
                <input type="hidden" id="action" name="action" value="home_header_search" />
                <div id="group_1">
                    <div id="container_1">
                        <label>Business Name</label>
                        <input id="property_name_search" name="property_name_search" type="text" class="form-control" placeholder="&#xf002;" value="" title="Search for a business" />
                    </div>
                </div>
                <div id="group_1">
                    <div id="container_1">
                        <label>Business Type</label>
                        <select id="property_category" name="property_category" class="form-control">
                            <option value="">Select . . .</option>
                            <?php
                            foreach ($arrPropertyCategories as $categories)
                            {
                                $category = toObject($categories);
                                ?>
                                <option value="<?php echo $category->id?>"<?php echo (($strPropertyCategory == $category->id)?(' selected="selected"'):(''))?>><?php echo $category->category?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div id="group_2">
                    <div id="container_2">
                        <label>City</label>
                        <input type="text" class="form-control" name="property_city" id="property_city" placeholder="City" value="<?php echo (($strPropertyCity != '')?($strPropertyCity):(''))?>" />
                    </div>
                    <div id="container_3">
                        <label>State</label>
                        <select id="property_state" name="property_state" class="form-control">
                            <option value="">Select . . .</option>
                            <?php
                            foreach ($arrStates as $key => $val)
                            {
                                ?>
                                <option value="<?php echo $key?>"<?php echo (($strPropertyState == $key)?(' selected="selected"'):(''))?>><?php echo $val?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div id="container_4">
                        <label>Zipcode</label>
                        <input type="text" class="form-control" name="property_zipcode" id="property_zipcode" placeholder="Zipcode" value="<?php echo (($strPropertyZipcode != '')?($strPropertyZipcode):(''))?>" />
                    </div>
                </div>
                <div class="form-action-wrapper-booking">
                    <div id="container_5_booking_body" style="padding-left:10px; padding-right:15px;">
                        <input type="button" id="btnReset" name="btnReset" value="Reset" class="btn_1 pull-left" onclick="location.href='<?php echo BASE_URL_RSB?>';" />
                        <input type="submit" id="btnSubmit" name="btnSubmit" value="Search" class="btn_1 pull-right" />
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--END: Property Search Parallax (body)  -->
    <!-- BEGIN: Guest Users -->
    <div class="container margin_20_35" style="display:none;">
        <div class="row">
            <div class="col-md-12">
                <p class="lead styled" style="border:2px dotted #FF0000; padding:10px !important;"><strong>GUESTS:</strong> You can use the following to <a href="<?php echo BASE_URL_RSB?>login/" title="Login" class="orange">login</a> as a guest: <strong>guest@bookmyspotonline.com</strong> password: <strong>guest</strong></p>
            </div>
        </div>
    </div>
    <!-- END: Guest Users -->
    <!-- BEGIN: Featured Destinations -->
    <h1 class="main_title" style="display:none;"><em></em>Featured Destinations</h1>
    <div class="container_styled_1" style="display:none;">
        <div class="container margin_60">
            <div class="row">
                <div class="col-md-5 col-md-offset-1">
                    <figure class="room_pic"><a href="<?php echo BASE_URL_RSB?>details/672/bennetts-rv-ranch/"><img src="<?php echo BASE_URL_RSB?>uploads/properties/property-672-image1.jpg" alt="" class="img-responsive img-rounded" /></a><span class="wow zoomIn" data-wow-delay="0.2s"><sup>$</sup>CALL<small>Per night</small></span></figure>
                </div>
                <div class="col-md-4 col-md-offset-1">
                    <div class="room_desc_home">
                        <h3>Bennetts RV Ranch</h3>
                        <p>Relax under a shady oak tree while our full service RV dealership makes your needed repairs without interrupting your camping fun. Our clubhouse is great for rallies and family reunions. Visit historic Granbury and enjoy.</p>
                        <ul>
                            <li>
                            <div class="tooltip_styled tooltip-effect-4">
                                <span class="tooltip-item"><i class="fa fa-plug"></i></span>
                                <div class="tooltip-content">
                                    Electric Hookup
                                </div>
                            </div>
                            </li>
                            <li>
                            <div class="tooltip_styled tooltip-effect-4">
                                <span class="tooltip-item"><i class="fa fa-shower"></i></span>
                                <div class="tooltip-content">
                                    Shower
                                </div>
                            </div>
                            </li>
                            <li>
                            <div class="tooltip_styled tooltip-effect-4">
                                <span class="tooltip-item"><i class="fa fa-tv"></i></span>
                                <div class="tooltip-content">
                                    Cable TV
                                </div>
                            </div>
                            </li>
                        </ul>
                        <a href="<?php echo BASE_URL_RSB?>details/672/bennetts-rv-ranch/" class="btn_1_outline">Read more</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container margin_60" style="display:none;">
        <div class="row">
            <div class="col-md-5 col-md-offset-1 col-md-push-5">
                <figure class="room_pic left"><a href="<?php echo BASE_URL_RSB?>details/1056/mount-olivet-cemetery/"><img src="<?php echo BASE_URL_RSB?>uploads/properties/property-1056-cemetery_image2.jpeg" alt="" class="img-responsive img-rounded" /></a></figure>
            </div>
            <div class="col-md-4 col-md-offset-1 col-md-pull-6">
                <div class="room_desc_home">
                    <h3>Mount Olivet Cemetery</h3>
                    <p>Also known as "Garden of Memories". Infant section of hundreds of small graves.</p>
                    <a href="<?php echo BASE_URL_RSB?>details/1056/mount-olivet-cemetery/" class="btn_1_outline">Read more</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container_styled_1" style="display:none;">
        <div class="container margin_60">
            <div class="row">
                <div class="col-md-5 col-md-offset-1">
                    <figure class="room_pic"><a href="<?php echo BASE_URL_RSB?>marketplace-item-details/3/fleetwood-jamboree-sport/"><img src="<?php echo BASE_URL_RSB?>uploads/marketplace/marketplace-3-image1.jpeg" alt="" class="img-responsive img-rounded" style="" /></a><span class="wow zoomIn" style="font-size:1.2em; height:50px; padding-top:15px;" data-wow-delay="0.2s"><sup>$</sup>58,000</span></figure>
                </div>
                <div class="col-md-4 col-md-offset-1">
                    <div class="room_desc_home">
                        <h3 class="orange">Fleetwood Jamboree Sport</h3>
                        <p>2008 4 X 4 Fleetwood Jamboree Sport Diesel. Excellent condition with only 20,000 miles. Slide out, for extra comfort.</p>
                        <a href="<?php echo BASE_URL_RSB?>marketplace-item-details/3/fleetwood-jamboree-sport/" class="btn_1_outline">Read more</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="promo_full">
    <div class="promo_full_wp">
        <div>
            <h3>What Visitors Say<span>Hear what people are saying about recent stays...</span></h3>
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="carousel_testimonials">
                            <div>
                                <div class="box_overlay">
                                    <div class="pic">
                                        <figure><img src="<?php echo BASE_URL_RSB?>img/kelly_e.jpg" alt="" class="img-circle"></figure>
                                        <h4>Kelley E.<small>12 May 2018</small></h4>
                                    </div>
                                    <div class="comment">
                                        "Loved the ease of planning the perfect trip! We stopped at many landmarks and attractions along our route that we didn't even know about or anticipate seeing."
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="box_overlay">
                                    <div class="pic">
                                        <figure><img src="<?php echo BASE_URL_RSB?>img/john_r.jpg" alt="" class="img-circle"></figure>
                                        <h4>John R.<small>21 May 2018</small></h4>
                                    </div>
                                    <div class="comment">
                                        "I took my wife up to Colorado for the weekend and we found a few new wineries and distilleries to check out along the way. The trip planner came in pretty handy!"
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="box_overlay">
                                    <div class="pic">
                                        <figure><img src="<?php echo BASE_URL_RSB?>img/michael_h.jpg" alt="" class="img-circle"></figure>
                                        <h4>Michael H.<small>29 May 2018</small></h4>
                                    </div>
                                    <div class="comment">
                                        "We used the Trip Planner for our Memorial Day family drive. We found some really great places to stay at and the kids loved learning about some of the local history in the area."
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
    <div id="dtBox"></div>
<?php
/************************************
 * Include the HTML footer...
 ************************************/
include ('include/footer.php');
?>