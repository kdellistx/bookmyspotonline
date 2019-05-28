<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 13-APR-2018
 * ---------------------------------------------------
 * Destinations Page (destinations.php)
 *****************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Process search parameters...
 ************************************/
if ($strPropertyCategory != '')
{
    $arrSearchData = array('property_category' => $strPropertyCategory);
} else {
    $arrSearchData = array();
}

/************************************
 * Initialize data arrays...
 ************************************/
$arrProperties = generatePropertes(250, false, false, false, $arrSearchData);
$arrSkyscrapers = generateAdvertisements(0, false, 10);

/************************************
 * Initialize page data...
 ************************************/
$strPageName = 'destinations';
$strPageTitle = 'Destinations';

/************************************
 * Include the HTML header...
 ************************************/
include ('include/header.php');
?>
    <section class="parallax-window" id="short" data-parallax="scroll" data-image-src="<?php echo BASE_URL_RSB?>img/rv_camp_003.jpg" data-natural-width="1350" data-natural-height="465">
        <div id="subheader">
            <h1>Destinations</h1>
        </div>
    </section>
    <div class="container margin_60">
        <h2 class="main_title">Where are you going? <span>Select a category and browse for places to go...</span></h2>
        <div class="row">
            <form id="frmDestination" name="frmDestination" action="<?php echo BASE_URL_RSB?>destinations/" method="post" class="form-light mt-20" role="form">
                <input id="action" name="action" type="hidden" value="select_destination_category" />
                <div class="col-md-4 col-md-offset-4">
                    <div class="form-group">
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
            </form>
        </div>
        <div class="row">
            <!-- BEGIN: Property Content -->
            <div class="col-md-8">
                <?php
                foreach ($arrProperties as $properties)
                {
                    $property = toObject($properties);
                    if ($property->image_main != '')
                    {
                        $strPropertyImage = BASE_URL_RSB.'uploads/properties/'.$property->image_main;
                    } else {
                        $strPropertyImage = BASE_URL_RSB.'uploads/properties/no_image.jpg';
                    }
                    ?>
                <!-- BEGIN: Property -->
                <div class="row">
                    <div class="room_desc clearfix">
                    <div class="col-md-7">
                        <figure><img src="<?php echo $strPropertyImage?>" alt="property image" class="img-responsive img-rounded" /></figure>
                    </div>
                    <div class="col-md-5 room_list_desc">
                        <h3 class="destination-h3" title="View Details" onclick="location.href='<?php echo BASE_URL_RSB?>details/<?php echo $property->id?>/<?php echo generateSEOURL($property->property_name)?>/';"><?php echo $property->property_name?></h3>
                        <p><?php echo $property->property_highlight?><br />
                            <?php echo $property->property_address?><br />
                            <?php echo $property->property_city?>, <?php echo $property->property_state?> <?php echo $property->property_zipcode?><br />
                            <?php echo $property->property_phone?>
                        </p>
                        <ul style="display:none;">
                            <li>
                            <div class="tooltip_styled tooltip-effect-4">
                                <span class="tooltip-item"><i class="icon_set_2_icon-104"></i></span>
                                    <div class="tooltip-content">King size bed</div>
                              </div>
                              </li>
                            <li>
                            <div class="tooltip_styled tooltip-effect-4">
                                <span class="tooltip-item"><i class="icon_set_2_icon-118"></i></span>
                                    <div class="tooltip-content">Shower</div>
                              </div>
                              </li>
                            <li>
                            <div class="tooltip_styled tooltip-effect-4">
                                <span class="tooltip-item"><i class="icon_set_2_icon-116"></i></span>
                                    <div class="tooltip-content">Plasma TV</div>
                              </div>
                              </li>
                        </ul>
                        <div class="price">
                            <strong><?php echo getPropertyCategoryName($property->category_id)?></strong>
                        </div>
                        <div class="view-on-main-map">
                            <button type="button" class="btn btn-md btn-danger btn-view-result-map" data-category="<?php echo $strPropertyCategory?>">VIEW RESULTS ON MAP</button>
                        </div>
                    </div>
                    </div>
                </div>
                <!-- END: Property -->
                    <?php
                    }
                ?>
            </div>
            <!-- END: Property Content -->
            <!-- BEGIN: Sidebar -->
            <div class="col-md-4 sidebar">
                <div class="theiaStickySidebar">
                    <div class="box_style_3" style="display:none;">
                        <h3>General Facilities</h3>
                        <ul>
                            <li><i class="icon_set_1_icon-86"></i>Free WIFI</li>
                            <li><i class="icon_set_2_icon-103"></i>Laundry Services</li>
                            <li><i class="icon_set_2_icon-110"></i>Swimming Pool</li>
                            <li><i class="icon_set_1_icon-58"></i>Restaurant</li>
                            <li><i class="icon_set_1_icon-27"></i>Parking</li>
                        </ul>
                    </div>
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
                    <div class="box_style_2 text-center">
                        <a href="<?php echo BASE_URL_RSB_WIZARD?>ad/" class="btn btn-lg btn-primary" title="Click here to create an advertisement"><i class="fa fa-normal fa-bullhorn" style="font-size:20px;"></i> Create An Advertisement</a>
                    </div>
                    <div class="box_style_2">
                        <i class="icon_set_1_icon-90"></i>
                        <h4>Need help? Call us!</h4>
                        <a href="tel://2146999132" class="phone">(214) 699-9132</a>
                        <small>Monday to Friday 8:00am - 5:00pm</small>
                    </div>
                </div>
            </div>
            <!-- END: Sidebar -->
        </div>
        <!-- End Row -->
    </div>
    <!-- End container -->
<?php
/************************************
 * Include the HTML footer...
 ************************************/
include ('include/footer.php');
?>