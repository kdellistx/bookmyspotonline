<?php
/**************************************************************
 * Created by: Randy S. Baker
 * Created on: 18-MAY-2018
 * ------------------------------------------------------------
 * Master Marketplcae Items Page (master_marketplace_items.php)
 **************************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Initialize page data...
 ************************************/
$strPageName = 'master_marketplace_items';
$strPageTitle = 'Admin Area - For Sale Items';

/************************************
 * Check if page is protected...
 ************************************/
isProtectedPage();

/************************************
 * Initialize data arrays...
 ************************************/
$user = toObject($_SESSION['sys_user']);
$arrMarketplaceItems = getUserMarketplaceDataList($user->id, true);
//showDebug($arrMarketplaceItems, 'marketplace items', true);

/************************************
 * Include the HTML header...
 ************************************/
include ('include/header.php');
?>
    <section class="parallax-window" id="short" data-parallax="scroll" data-image-src="<?php echo BASE_URL_RSB?>img/rv_camp_003.jpg" data-natural-width="1350" data-natural-height="465">
        <div id="subheader">
            <h1>Admin Area</h1>
        </div>
    </section>
    <div class="container margin_60">
        <div class="row">
            <!-- BEGIN: Account Content -->
            <div class="col-md-8">
                <!-- BEGIN: All Marketplace Items -->
                <div class="row" style="margin-top:30px;">
                    <!-- Data Table -->
                    <div class="col-md-12">
                        <form id="frmManageMarketplace" name="frmManageMarketplace" action="<?php echo BASE_URL_RSB?>my-account/" method="post" class="form-light mt-20" role="form">
                            <input id="action" name="action" type="hidden" value="post_new_marketplace_item_link" />
                            <fieldset class="bordered-fieldset">
                            <legend>All Items For Sale</legend>
                            <table class="table table-hover table-condensed account-data-table">
                              <thead>
                                <tr>
                                  <th>Name</th>
                                  <th>Category</th>
                                  <th>City</th>
                                  <th>Price</th>
                                  <th>Actions</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                if (count($arrMarketplaceItems) > 0)
                                {
                                    foreach ($arrMarketplaceItems as $items)
                                    {
                                        $item = toObject($items);
                                        ?>
                                        <tr>
                                          <td><?php echo $item->property_name?></td>
                                          <td><?php echo getMarketplaceCategoryName($item->category_id)?></td>
                                          <td><?php echo $item->property_city?></td>
                                          <td>$<?php echo number_format($item->property_price, 2)?></td>
                                          <td style="white-space:nowrap;">
                                            <button type="button" class="btn btn-xs btn-success" title="View" onclick="window.location='<?php echo BASE_URL_RSB?>view-marketplace-item/<?php echo $item->id?>/<?php echo urlencode($item->property_name)?>/';"><i class="table-action-button fa fa-eye"></i></button>
                                            <button type="button" class="btn btn-xs btn-warning" title="Edit" onclick="window.location='<?php echo BASE_URL_RSB?>edit-marketplace-item/<?php echo $item->id?>/<?php echo urlencode($item->property_name)?>/';"><i class="table-action-button fa fa-pencil"></i></button>
                                            <button type="button" class="btn btn-xs btn-danger" title="Remove from your account" onclick="window.location='<?php echo BASE_URL_RSB?>my-account/?action=delete_marketplace_item_from_account&marketplace_item_id=<?php echo $item->id?>';"><i class="table-action-button fa fa-trash"></i></button>
                                          </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <tr><td colspan="5">No items exist.</td></tr>
                                    <?php
                                }
                                ?>
                              </tbody>
                            </table>
                            </fieldset>
                        </form>
                    </div><!-- /Data Table -->
                </div><!-- /Row -->
            </div>
            <!-- END: Account Content -->
            <!-- BEGIN: Sidebar -->
            <div class="col-md-4 sidebar">
                <div class="theiaStickySidebar">
                    <div class="box_style_3">
                        <?php
                        /************************************
                         * Include the account sidebar...
                         ************************************/
                        include ('include/my_account_sidebar.php');
                        ?>
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