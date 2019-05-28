<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 01-JUN-2018
 * ---------------------------------------------------
 * Marketplace Details Page (market_item_details.php)
 *****************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Initialize data arrays...
 ************************************/
$arrMarketplaceItem = getMarketplaceData($intMarketplaceItemID);
$item = toObject($arrMarketplaceItem);
if ($item->property_price > 0)
{
    $strPrice = '<strong>$'.number_format($item->property_price, 2).'</strong>';
} else {
    $strPrice = '<strong>CALL</strong>';
}
$owner = toObject(getUserData($item->user_id));
$arrSinglePropertyData[0] = $item->id;
$strPropertyIDSearch = serialize($arrSinglePropertyData);

/************************************
 * Initialize page data...
 ************************************/
$strPageName = 'marketplace_item_details';
$strPageTitle = $item->property_name;

/************************************
 * Include the HTML header...
 ************************************/
include ('include/header.php');
?>
	<div class="carousel_in">
    <!--
      <div><img src="<?php echo BASE_URL_RSB?>img/rv_camp_001.jpg" alt="image" /><div class="caption"><h3>Item Photos</h3></div></div>
      <div><img src="<?php echo BASE_URL_RSB?>img/rv_camp_002.jpg" alt="image" /><div class="caption"><h3>Item Photos</h3></div></div>
      <div><img src="<?php echo BASE_URL_RSB?>img/rv_camp_003.jpg" alt="image" /><div class="caption"><h3>Item Photos</h3></div></div>
      <div><img src="<?php echo BASE_URL_RSB?>img/rv_camp_005.jpg" alt="image" /><div class="caption"><h3>Item Photos</h3></div></div>
      <div><img src="<?php echo BASE_URL_RSB?>img/rv_camp_006.jpg" alt="image" /><div class="caption"><h3>Item Photos</h3></div></div>
    -->
    </div>
    <h1 class="main_title_in orange"><?php echo $item->property_name?></h1>
    <!-- BEGIN: Alert Box -->
    <?php
    if ($item->user_id != 0)
    {
        ?>
        <div class="container" style="display:none;">
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="text-center" style="text-transform:uppercase;"><strong>Got something to sell?</strong></h4>
                        <p class="text-center">If you would like to list your item for sale, click the button below. You'll need to either create an account or login to your existing account first.</p>
                        <p class="text-center"><a href="<?php echo BASE_URL_RSB.$strClaimURL?>" class="btn btn-md btn-warning" title="Claim this business">SELL MY ITEM</a></p>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
    <!-- END: Alert Box -->
    <div class="container add_bottom_60">
        <div class="row">
        	<div class="col-md-8">
                <div class="row">
                    <div class="col-md-12">
                        <button onclick="location.href='<?php echo BASE_URL_RSB?>for-sale/';" class="btn btn-danger"><i class="fa fa-arrow-left"></i> BACK</button>
                        <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalSendPageInfo" data-page-url="<?php echo BASE_URL_RSB?>marketplace-item-details/<?php echo $item->id?>/<?php echo generateSEOURL($item->property_name)?>/" title="Send this page to family and friends"><i class="fa fa-envelope"></i> SEND TO FRIENDS</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <h3>Details</h3>
                    </div>
                    <div class="col-md-9">
                        <h4><strong>Address</strong></h4>
                        <p><i class="fa fa-home"></i> <?php echo $item->property_address?>
                            <?php echo $item->property_city?>, <?php echo $item->property_state?> <?php echo $item->property_zipcode?><br />
                            <i class="fa fa-phone"></i> <?php echo $item->property_phone?><br />
                            <i class="fa fa-globe"></i> <?php echo (($item->property_website != '')?('<a href="http://'.$item->property_website.'" target="_blank">'.$item->property_website.'</a>'):(''))?>
                        </p>
                        <h4><strong>Description</strong></h4>
                        <div style="width:100%;">
                            <?php echo (($item->property_description != '')?($item->property_description):('No description available...'))?>
                        </div>
                        <div class="divider-thin hidden-xs"></div>
                        <h4><strong>Highlights</strong></h4>
                        <div style="width:100%;">
                            <?php echo (($item->property_highlight != '')?($item->property_highlight):('No highlight available...'))?>
                        </div>
                        <div class="divider-thin hidden-xs"></div>
                        <h4><strong>List Price</strong></h4>
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <td><?php echo $strPrice?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- END: col-md-9  -->
                </div>
                <!-- END: row  -->
                <!-- BEGIN: Marketplace Item Images -->
                <div class="row" style="margin-bottom:25px;">
                    <div class="col-md-12">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-2">
                                    <a data-fancybox="gallery" href="<?php echo MARKETPLACE_IMAGE_PATH.(($item->image_main != '')?($item->image_main):('no_image.jpg'))?>"><img src="<?php echo MARKETPLACE_IMAGE_PATH.(($item->image_main != '')?($item->image_main):('no_image.jpg'))?>" class="img-responsive img-rounded preview-thumbnail" alt="image" /></a>
                                </div>
                                <div class="col-md-2">
                                    <a data-fancybox="gallery" href="<?php echo MARKETPLACE_IMAGE_PATH.(($item->image_1 != '')?($item->image_1):('no_image.jpg'))?>"><img src="<?php echo MARKETPLACE_IMAGE_PATH.(($item->image_1 != '')?($item->image_1):('no_image.jpg'))?>" class="img-responsive img-rounded preview-thumbnail" alt="image" /></a>
                                </div>
                                <div class="col-md-2">
                                    <a data-fancybox="gallery" href="<?php echo MARKETPLACE_IMAGE_PATH.(($item->image_2 != '')?($item->image_2):('no_image.jpg'))?>"><img src="<?php echo MARKETPLACE_IMAGE_PATH.(($item->image_2 != '')?($item->image_2):('no_image.jpg'))?>" class="img-responsive img-rounded preview-thumbnail" alt="image" /></a>
                                </div>
                                <div class="col-md-2">
                                    <a data-fancybox="gallery" href="<?php echo MARKETPLACE_IMAGE_PATH.(($item->image_3 != '')?($item->image_3):('no_image.jpg'))?>"><img src="<?php echo MARKETPLACE_IMAGE_PATH.(($item->image_3 != '')?($item->image_3):('no_image.jpg'))?>" class="img-responsive img-rounded preview-thumbnail" alt="image" /></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                
                <hr />
                <!-- END: Marketplace Item Images -->
                <!-- BEGIN: Marketplace Map -->
                <div class="row" style="margin-bottom:25px;">
                    <div class="col-md-12">
                        <div class="container">
                            <div class="row">
                                <div class="map-responsive img-rounded">
                                    <div id="map"></div>
                                    <script>
                                        var myLatLng = {lat:<?php echo $item->property_latitude?>, lng:<?php echo $item->property_longitude?>};
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
                                            //initMap(map);
                                            initMarketplaceMap(map);
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
                <hr />
                <!-- END: Marketplace Map -->
            </div>
            <!-- END: col -->
            <div class="col-md-4" id="sidebar">
                <div class="theiaStickySidebar">
                    <div class="box_style_1">
                        <div id="message-booking"></div>
                        <form id="frmContactSeller" name="frmContactSeller" method="post" action="<?php echo BASE_URL_RSB?>marketplace-item-details/<?php echo $item->id?>/<?php echo generateSEOURL($item->property_name)?>/" role="form" autocomplete="off" >
                            <input type="hidden" id="email_subject" name="email_subject" value="<?php echo $item->property_name?>" />
                            <input type="hidden" id="owner_email" name="owner_email" value="<?php echo $owner->email?>" />
                            <input type="hidden" id="action" name="action" value="contact_seller" />
           				    <div class="row">
                                <div class="col-md-12 col-sm-6">
                                    <div class="form-group">
                                	   <label>Name</label>
                            	 		<input type="text" class="form-control" id="full_name" name="full_name" placeholder="First and Last Name" />
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                	 	<input type="email" class="form-control" id="email_address" name="email_address" placeholder="Email Address" />
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label>Comments</label>
                                        <textarea id="comments" name="comments" class="form-control" placeholder="Comments" style="height:100px;"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <input type="submit" id="btnSubmit" name="btnSubmit" value="Contact Seller" class="btn_full" />
                                    </div>
                                </div>
                            </div>
                        </form>
                        <hr />
                        <a href="<?php echo BASE_URL_RSB?>contact/" class="btn_outline">or Contact Us</a>
                        <a href="tel://2146999132" id="phone_2"><i class="icon_set_1_icon-91"></i>(214) 699-9132</a>
                    </div>
                    <!-- END: box_style -->
                    <!-- BEGIN: Banner -->
                    <div class="box_style_2">
                        <img src="<?php echo BASE_URL_RSB?>banners/banner_300x600_geico.png" class="img-responsive sidebar-banners" style="margin:0px auto;" alt="banner" />
                    </div>
                    <!-- END: Banner -->
                </div>
                <!-- END: theiaStickySidebar -->
                <div class="clearfix"></div>
            </div>
            <!-- END: col -->
        </div>
        <!-- END: row -->
    </div>
    <!-- END: container -->
<?php
/************************************
 * Include the HTML footer...
 ************************************/
include ('include/footer.php');
?>