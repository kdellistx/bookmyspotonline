<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 01-JUN-2018
 * ---------------------------------------------------
 * For Sale Page (for_sale_list.php)
 *****************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Initialize page data...
 ************************************/
$strPageName = 'for_sale_list';
$strPageTitle = 'For Sale';

/************************************
 * Process search parameters...
 ************************************/
if ($strMarketplaceCategory != '')
{
    $arrSearchData = array('property_category' => $strMarketplaceCategory);
} else {
    $arrSearchData = array();
}

/************************************
 * Initialize data arrays...
 ************************************/
$arrMarketplaceItems = generateMarketplaceItems(500, false, false, false, $arrSearchData);

/************************************
 * Include the HTML header...
 ************************************/
include ('include/header.php');
?>
    <section class="parallax-window" id="short" data-parallax="scroll" data-image-src="<?php echo BASE_URL_RSB?>img/rv_camp_003.jpg" data-natural-width="1350" data-natural-height="465">
        <div id="subheader">
            <h1>Items For Sale</h1>
        </div>
    </section>
    <div class="container margin_60">
        <p class="lead styled">Items below are listed for sale. If you would like to purchase an item or asset, fill out the form below and the seller will be notified. If you would like to list your item, property, or other asset for sale, log into your account and click "<strong>Sell an Item</strong>". If you have any questions, please feel free to contact us.</p>
    	<h2 class="main_title"><span>Select a category...</span></h2>
        <div class="row">
            <form id="frmForSale" name="frmForSale" action="<?php echo BASE_URL_RSB?>for-sale/" method="post" class="form-light mt-20" role="form">
                <input id="action" name="action" type="hidden" value="select_marketplace_category" />
                <div class="col-md-4 col-md-offset-4">
                    <div class="form-group">
                        <select id="marketplace_category" name="marketplace_category" class="form-control">
                            <option value="">Select . . .</option>
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
                    </div>
                </div>
            </form>
        </div>
        <div class="row">
            <!-- BEGIN: Marketplace Content -->
            <div class="col-md-8">
                <?php
                foreach ($arrMarketplaceItems as $items)
                {
                    $item = toObject($items);
                    if ($item->image_main != '')
                    {
                        $strItemImage = BASE_URL_RSB.'uploads/marketplace/'.$item->image_main;
                    } else {
                        $strItemImage = BASE_URL_RSB.'uploads/marketplace/no_image.jpg';
                    }

                    if ($item->property_price > 0)
                    {
                    	$strPrice = '<strong>$'.number_format($item->property_price, 2).'</strong> <small>';
                    } else {
                    	$strPrice = 'Please <strong>CALL</strong> for rates<small>';
                    }
                ?>
                <!-- BEGIN: Marketplace Item -->
                <div class="row">
                    <div class="room_desc clearfix">
                    <div class="col-md-7">
                        <figure><img src="<?php echo $strItemImage?>" alt="marketplace item image" class="img-responsive img-rounded" onclick="location.href='<?php echo BASE_URL_RSB?>marketplace-item-details/<?php echo $item->id?>/<?php echo generateSEOURL($item->property_name)?>/';" style="cursor:hand; cursor:pointer;" /></figure>
                    </div>
                    <div class="col-md-5 room_list_desc">
                        <h3 class="destination-h3" title="View Details" onclick="location.href='<?php echo BASE_URL_RSB?>marketplace-item-details/<?php echo $item->id?>/<?php echo generateSEOURL($item->property_name)?>/';"><?php echo $item->property_name?></h3>
                        <p><?php echo $item->property_highlight?><br />
                            <?php echo $item->property_address?><br />
                            <?php echo $item->property_city?>, <?php echo $item->property_state?> <?php echo $item->property_zipcode?><br />
                            <?php echo $item->property_phone?>
                        </p>
                        <div class="price"><?php echo $strPrice .' '. getMarketplaceCategoryName($item->category_id)?><br /></small></div>
                        <div class="view-on-main-map">
                            <button type="button" class="btn btn-md btn-danger btn-view-result-map-marketplace" data-category="<?php echo $item->category_id?>">VIEW ON MAP</button>
                        </div>
                    </div>
                    </div>
                </div>
                <!-- END: MarketPlace Item -->
                    <?php
                    }
                ?>
            </div>
            <!-- END: Marketplace Content -->
            <!-- BEGIN: Sidebar -->
            <div class="col-md-4 sidebar">
                <div class="theiaStickySidebar">
                    <div class="box_style_3 text-center">
                        <h3>Got something to sell?</h3>
                        <button type="button" class="btn btn-lg btn-success" onclick="location.href='<?php echo BASE_URL_RSB?>my-account/';">SPECIAL: List 90 Days For $25</button>
                    </div>
                    <div class="box_style_2">
                        <img src="<?php echo BASE_URL_RSB?>banners/banner_300x600_southwest.png" class="img-responsive sidebar-banners" style="margin:0px auto;" alt="banner" />
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
        <!-- END: Row -->
	</div>
	<!-- END: Container -->
<?php
/************************************
 * Include the HTML footer...
 ************************************/
include ('include/footer.php');
?>