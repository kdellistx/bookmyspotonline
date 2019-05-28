<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 29-JUN-2018
 * ---------------------------------------------------
 * Marketplace Map Page (marketplace_map.php)
 *****************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Initialize page data...
 ************************************/
$strPageName = 'marketplace_map';
$strPageTitle = 'Map of Items For Sale';

/************************************
 * Process search parameters...
 ************************************/
if ($strMarketplaceCategory != '')
{
    $strXMLSearch = serialize(array('property_category' => $strMarketplaceCategory));
}

/************************************
 * Initialize data arrays...
 ************************************/
//$arrMarketplaceItems = generateMarketplaceItems(500, false, false, true);

/************************************
 * Include the HTML header...
 ************************************/
include ('include/header.php');
?>
    <div class="container marketplace-map-container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <form id="check_avail_marketplace_map" name="check_avail_marketplace_map" method="post" action="<?php echo BASE_URL_RSB?>marketplace-map/" class="form-inline" role="form" autocomplete="off" style="margin-bottom:3px;">
                            <input type="hidden" id="action" name="action" value="marketplace_map_search" />
                            <select id="marketplace_category" name="marketplace_category" class="form-control">
                                <option value="">Select Category . . .</option>
                                <?php
                                foreach ($arrMarketplaceCategories as $categories)
                                {
                                    $category = toObject($categories);
                                    ?>
                                    <option value="<?php echo $category->id?>"<?php echo (($strMarketplaceCategory == $category->id)?(' selected="selected"'):(''))?>><?php echo $category->category?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <input type="submit" id="btnSubmit" name="btnSubmit" value="Update" class="btn btn-md btn-danger" />
                        </form>
                    </div>
                    <div class="col-md-8" style="margin-bottom:5px;">
                        <br class="hidden-break" /><br class="hidden-break" /><span class="hidden-space">&nbsp;</span>
                        <h2 class="main_sub_title">Map Of Items For Sale</h2>
                    </div>
                </div>
                <div class="map-responsive img-rounded">
                    <div id="map"></div>
                    <script>
                        var myLatLng = {lat:33.0237921, lng:-96.4637379};
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
                                zoom: 5,
                                center: myLatLng,
                                zoomControl: true,
                                zoomControlOptions: {style: google.maps.ZoomControlStyle.SMALL},
                                scrollwheel: false,
                                gestureHandling: 'greedy'
                            });

                            infoWindow = new google.maps.InfoWindow;

                            // Attempt HTML5 geolocation....
                            if (navigator.geolocation)
                            {
                              navigator.geolocation.getCurrentPosition(function(position)
                              {
                                var pos = {
                                  lat: position.coords.latitude,
                                  lng: position.coords.longitude
                                };

                                infoWindow.setPosition(pos);
                                infoWindow.setContent('You are here.');
                                infoWindow.open(map);
                                map.setCenter(pos);
                              }, function() {
                                handleLocationError(true, infoWindow, map.getCenter());
                              });
                            } else {
                              // Browser doesn't support Geolocation...
                              handleLocationError(false, infoWindow, map.getCenter());
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
                            //initMap(map);
                            initMarketplaceMap(map);
                        }

                        function initMap(map){
                            var infoWindow = new google.maps.InfoWindow;
                            //console.log('<?php echo BASE_URL_RSB?>generate_map_xml.php?lookup=<?php echo $strXMLSearch?>');
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
                                        //infoWindow.close();
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
    <!-- END: Available Destinations-->
<?php
/************************************
 * Include the HTML footer...
 ************************************/
include ('include/footer.php');
?>