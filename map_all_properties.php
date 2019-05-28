<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 21-JUL-2018
 * ---------------------------------------------------
 * Map - All Properties Page (map_all_properties.php)
 *****************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Initialize page data...
 ************************************/
$strPageName = 'map_all_properties';
$strPageTitle = 'View All Properties';

/************************************
 * Initialize data arrays...
 ************************************/
$strXMLSearch = '';

/************************************
 * Include the HTML header...
 ************************************/
include ('include/header.php');
showAlert('This map will take a few minutes to load. Please stand by....');
?>
    <div class="container margin_20_35" style="margin-bottom:-15px;">
    
    </div>
    <div class="container" style="margin-bottom:15px;">
        <div class="row">
            <div class="col-md-12">
                <input type="hidden" id="location_latitude" name="location_latitude" value="33.0237921" />
                <input type="hidden" id="location_longitude" name="location_longitude" value="-96.4637379" />
                <div class="map-responsive img-rounded">
                    <div id="map"></div>
                    <script>
                        var map;
                        var myLocation;
                        var tmpLat;
                        var tmpLon;
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
                            alert('No location information available. Error code: ' + error.code);
                        }

                        $.geolocation.get({win:showMyLocation, fail:noLocationAvailable});
                        //sleep(1000);
                        //var myLocation = {lat:33.0237921, lng:-96.4637379};
                        tmpLat = parseFloat($('#location_latitude').val());
                        tmpLon = parseFloat($('#location_longitude').val());
                        myLocation = {lat:tmpLat, lng:tmpLon};

                        function initialize(){
                            var map = new google.maps.Map(document.getElementById('map'), {
                                zoom: 5,
                                center: myLocation,
                                zoomControl: true,
                                zoomControlOptions: {style: google.maps.ZoomControlStyle.SMALL},
                                scrollwheel: false,
                                gestureHandling: 'cooperative'
                            });

                            var marker = new google.maps.Marker({
                                map: map,
                                position: myLocation,
                                zIndex: google.maps.Marker.MAX_ZINDEX + 1,
                                icon: '<?php echo BASE_URL_RSB?>google_map_markers/blue_dot_marker_small.png'
                            });
                            map.setCenter(myLocation);

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
                            initMarketplaceMap(map);
                        }

                        function initMap(map){
                            $.geolocation.get({win:showMyLocation, fail:noLocationAvailable});
                            tmpLat = parseFloat($('#location_latitude').val());
                            tmpLon = parseFloat($('#location_longitude').val());
                            var startLat = tmpLat;
                            var startLon = tmpLon;
                            console.log('Starting after geo-location...');
                            var infoWindow = new google.maps.InfoWindow;
                            //console.log('<?php echo BASE_URL_RSB?>generate_map_xml.php?lookup=<?php echo $strXMLSearch?>');
                            //downloadUrl('<?php echo BASE_URL_RSB?>generate_map_xml.php?lookup=<?php echo $strXMLSearch?>&geoLatitude=' + startLat + '&geoLongitude='+startLon, function(data){
                                downloadUrl('<?php echo BASE_URL_RSB?>generate_map_xml.php?lookup=<?php echo $strXMLSearch?>', function(data){
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
                                        infoWindow.close();
                                    });
                            });
                        });
                    }

                    function initMarketplaceMap(map){
                            var infoWindow = new google.maps.InfoWindow;
                            //console.log('<?php echo BASE_URL_RSB?>generate_marketplace_map_xml.php?lookup=<?php echo $strXMLSearch?>');
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
                                        infoWindow.close();
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
    <!-- END: Available Destinations-->
    <div id="dtBox"></div><!-- End datepicker -->
<?php
/************************************
 * Include the HTML footer...
 ************************************/
include ('include/footer.php');
?>