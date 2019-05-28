<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 02-JUN-2018
 * ---------------------------------------------------
 * Edit Item Page (edit_marketplace_item.php)
 *****************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Initialize page data...
 ************************************/
$strPageName = 'edit_marketplace_item';
$strPageTitle = 'Edit Marketplace Listing Information';

/************************************
 * Check if page is protected...
 ************************************/
isProtectedPage();

/************************************
 * Initialize data arrays...
 ************************************/
$user = toObject($_SESSION['sys_user']);
$arrMarketplaceItem = getMarketplaceData($intMarketplaceItemID);
$item = toObject($arrMarketplaceItem);
$arrCategories = generateMarketplaceCategories();

/************************************
 * Include the HTML header...
 ************************************/
include ('include/header.php');
?>
    <section class="parallax-window" id="short" data-parallax="scroll" data-image-src="<?php echo BASE_URL_RSB?>img/rv_camp_003.jpg" data-natural-width="1350" data-natural-height="465">
        <div id="subheader">
            <h1>Edit Marketplace Listing</h1>
        </div>
    </section>
    <div class="container margin_60">
        <div class="row">
            <!-- BEGIN: Marketplace Content -->
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN: Marketplace Item Overview -->
                        <div class="job-details-wrapper">
                            <h3>Edit Listing Details</h3>
                            <p>Hey, <?php echo $user->first_name?>, use the form below to make updates to your marketplace listing. You can use the menu at the right to make changes to your account, such as update your information, change your password, or perform other tasks.</p>
                            <form id="frmSaveMarketplaceItem" name="frmSaveMarketplaceItem" action="<?php echo BASE_URL_RSB?>view-marketplace-item/<?php echo $item->id?>/<?php echo urlencode($item->property_name)?>/" method="post" class="form-light mt-20" enctype="multipart/form-data" role="form">
                                <input id="action" name="action" type="hidden" value="save_marketplace_item" />
                                <input id="id" name="id" type="hidden" value="<?php echo $item->id?>" />
                                <fieldset class="bordered-fieldset">
                                <legend>Listing Information</legend>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Listing Name</label>
                                            <input id="property_name" name="property_name" type="text" class="form-control" value="<?php echo $item->property_name?>" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Category</label>
                                            <select id="category_id" name="category_id" class="form-control">
                                                <option value="0">-- Select-- </option>
                                                <?php
                                                foreach ($arrCategories as $categories)
                                                {
                                                    $category = toObject($categories);
                                                    ?>
                                                    <option value="<?php echo $category->id?>"<?php echo (($item->category_id == $category->id)?(' selected="selected"'):(''))?>><?php echo $category->category?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input id="property_address" name="property_address" type="text" class="form-control" value="<?php echo $item->property_address?>" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>City</label>
                                            <input id="property_city" name="property_city" type="text" class="form-control" value="<?php echo $item->property_city?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>State</label>
                                            <select id="property_state" name="property_state" class="form-control">
                                                <option value="0">-- Select-- </option>
                                                <?php
                                                foreach ($arrStates as $key => $val)
                                                {
                                                    ?>
                                                    <option value="<?php echo $key?>"<?php echo (($item->property_state == $key)?(' selected="selected"'):(''))?>><?php echo $val?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Zipcode</label>
                                            <input id="property_zipcode" name="property_zipcode" type="text" class="form-control" value="<?php echo $item->property_zipcode?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Phone</label>
                                            <input id="property_phone" name="property_phone" type="text" class="form-control" value="<?php echo $item->property_phone?>" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Website</label>
                                            <input id="property_website" name="property_website" type="text" class="form-control" value="<?php echo $item->property_website?>"  />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>List Price</label>
                                            <input id="property_price" name="property_price" type="text" class="form-control" value="<?php echo $item->property_price?>" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <!-- Empty Column-->
                                    </div>
                                </div>
                                <div class="row" style="display:none;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Notes</label>
                                            <textarea id="property_notes" name="property_notes" class="form-control" rows="2"><?php echo $item->property_notes?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <!-- ORIGINAL FORM BUTTONS-->
                        </div>
                        <!-- END: Marketplace Item Overview -->
                    </div>
                </div>
                <!-- BEGIN: Marketplace Item Highlights -->
                <div class="row" style="display:none;">
                    <div class="col-md-12">
                        <h3>Listing Highlights</h3>
                        <div class="form-group">
                            <textarea id="property_highlight_summernote" name="property_highlight" class="form-control" rows="4"><?php echo $item->property_highlight?></textarea>
                        </div>
                    </div>
                </div>
                <!-- END: Marketplace Item Highlights -->
                <!-- BEGIN: Marketplace Item Description -->
                <div class="row">
                    <div class="col-md-12">
                        <h3>Listing Description</h3>
                        <div class="form-group">
                            <textarea id="property_description_summernote" name="property_description" class="form-control" rows="4"><?php echo $item->property_description?></textarea>
                        </div>
                    </div>
                </div>
                <!-- END: Markertplace Item Description -->
                <!-- BEGIN: Marketplace Item Images -->
                <div class="row" style="margin-bottom:25px;">
                    <div class="col-md-12">
                        <h3>Current Listing Images</h3>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-2">
                                    <img src="<?php echo MARKETPLACE_IMAGE_PATH.(($item->image_main != '')?($item->image_main):('no_image.jpg'))?>" class="img-responsive img-rounded preview-thumbnail" alt="image" />
                                    <br />
                                    <a href="#" class="btn btn-xs btn-danger" title="Delete"><i class="fa fa-close"></i></a> Main Image
                                </div>
                                <div class="col-md-2">
                                    <img src="<?php echo MARKETPLACE_IMAGE_PATH.(($item->image_1 != '')?($item->image_1):('no_image.jpg'))?>" class="img-responsive img-rounded preview-thumbnail" alt="image" />
                                    <br />
                                    <a href="#" class="btn btn-xs btn-danger" title="Delete"><i class="fa fa-close"></i></a> Image 1
                                </div>
                                <div class="col-md-2">
                                    <img src="<?php echo MARKETPLACE_IMAGE_PATH.(($item->image_2 != '')?($item->image_2):('no_image.jpg'))?>" class="img-responsive img-rounded preview-thumbnail" alt="image" />
                                    <br />
                                    <a href="#" class="btn btn-xs btn-danger" title="Delete"><i class="fa fa-close"></i></a> Image 2
                                </div>
                                <div class="col-md-2">
                                    <img src="<?php echo MARKETPLACE_IMAGE_PATH.(($item->image_3 != '')?($item->image_2):('no_image.jpg'))?>" class="img-responsive img-rounded preview-thumbnail" alt="image" />
                                    <br />
                                    <a href="#" class="btn btn-xs btn-danger" title="Delete"><i class="fa fa-close"></i></a> Image 3
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-bottom:25px;">
                    <div class="col-md-12">
                        <h3>Edit Item Images</h3>
                        <div class="form-group">
                            <label for="image_main">Main Image</label>
                            <input type="file" class="form-control-file" id="image_main" name="image_main[]" />
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-bottom:25px;">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="image_1">Image #1</label>
                            <input type="file" class="form-control-file" id="image_1" name="image_1[]" />
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-bottom:25px;">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="image_2">Image #2</label>
                            <input type="file" class="form-control-file" id="image_2" name="image_2[]" />
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-bottom:25px;">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="image_3">Image #3</label>
                            <input type="file" class="form-control-file" id="image_3" name="image_3[]" />
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-bottom:25px;">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="image_3">Image #4</label>
                            <input type="file" class="form-control-file" id="image_4" name="image_4[]" />
                        </div>
                    </div>
                </div>
                <!-- END: Marketplace Item Images -->
                <div class="row" style="margin-bottom:10px;">
                    <div class="col-md-12">
                        <button id="btnCancel" name="btnCancel" type="button" class="btn btn-danger pull-left" onclick="location.href='<?php echo BASE_URL_RSB?>view-marketplace-item/<?php echo $item->id?>/<?php echo urlencode($item->property_name)?>/';"><i class="fa fa-close"></i> Cancel</button>
                        <button id="btnSubmit" name="btnSubmit" type="submit" class="btn btn-info pull-right"><i class="fa fa-save"></i> Save</button>
                    </div>
                </div>
                    </fieldset>
                </form>
            </div>
            <!-- END: Property Content -->
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