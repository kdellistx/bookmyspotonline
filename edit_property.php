<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 10-MAY-2018
 * ---------------------------------------------------
 * Edit Property Page (edit_property.php)
 *****************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Initialize page data...
 ************************************/
$strPageName = 'edit_property';
$strPageTitle = 'Edit Property Information';

/************************************
 * Check if page is protected...
 ************************************/
isProtectedPage();

/************************************
 * Initialize data arrays...
 ************************************/
$user = toObject($_SESSION['sys_user']);
$arrProperty = getPropertyData($intPropertyID);
$property = toObject($arrProperty);
$arrCategories = generatePropertyCategories();

/************************************
 * Include the HTML header...
 ************************************/
include ('include/header.php');
?>
    <section class="parallax-window" id="short" data-parallax="scroll" data-image-src="<?php echo BASE_URL_RSB?>img/rv_camp_003.jpg" data-natural-width="1350" data-natural-height="465">
        <div id="subheader">
            <h1>Edit Property</h1>
        </div>
    </section>
    <div class="container margin_60">
        <div class="row">
            <!-- BEGIN: Property Content -->
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN: Property Overview -->
                        <div class="job-details-wrapper">
                            <h3>Edit Property Details</h3>
                            <p>Hey, <?php echo $user->first_name?>, below is a snapshot of the property. You can use the menu at the right to make changes to your account, such as update your information, change your password, or perform other tasks.</p>
                            <form id="frmSaveProperty" name="frmSaveProperty" action="<?php echo BASE_URL_RSB?>view-property/<?php echo $property->id?>/<?php echo urlencode($property->property_name)?>/" method="post" class="form-light mt-20" enctype="multipart/form-data" role="form">
                                <input id="action" name="action" type="hidden" value="save_property" />
                                <input id="id" name="id" type="hidden" value="<?php echo $property->id?>" />
                                <fieldset class="bordered-fieldset">
                                <legend>Property Information</legend>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Property Name</label>
                                            <input id="property_name" name="property_name" type="text" class="form-control" value="<?php echo $property->property_name?>" />
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
                                                    <option value="<?php echo $category->id?>"<?php echo (($property->category_id == $category->id)?(' selected="selected"'):(''))?>><?php echo $category->category?></option>
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
                                            <input id="property_address" name="property_address" type="text" class="form-control" value="<?php echo $property->property_address?>" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>City</label>
                                            <input id="property_city" name="property_city" type="text" class="form-control" value="<?php echo $property->property_city?>" />
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
                                                    <option value="<?php echo $key?>"<?php echo (($property->property_state == $key)?(' selected="selected"'):(''))?>><?php echo $val?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Zipcode</label>
                                            <input id="property_zipcode" name="property_zipcode" type="text" class="form-control" value="<?php echo $property->property_zipcode?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Phone</label>
                                            <input id="property_phone" name="property_phone" type="text" class="form-control" value="<?php echo $property->property_phone?>" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Website</label>
                                            <input id="property_website" name="property_website" type="text" class="form-control" value="<?php echo $property->property_website?>"  />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Rental Rate</label>
                                            <input id="property_price" name="property_price" type="text" class="form-control" value="<?php echo number_format($property->property_price, 2)?>" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Subscription Plan</label>
                                            <input id="subcription_id" name="subcription_id" type="text" class="form-control" value="<?php echo getSubscriptionPlanName($property->subscription_id)?>" disabled readonly />
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="display:none;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Notes</label>
                                            <textarea id="property_notes" name="property_notes" class="form-control" rows="2"><?php echo $property->property_notes?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <!-- ORIGINAL FORM BUTTONS-->
                        </div>
                        <!-- END: Property Overview -->
                    </div>
                </div>
                <!-- BEGIN: Property Highlights -->
                <div class="row" style="display:none;">
                    <div class="col-md-12">
                        <h3>Property Highlights</h3>
                        <div class="form-group">
                            <textarea id="property_highlight_summernote" name="property_highlight" class="form-control" rows="4"><?php echo $property->property_highlight?></textarea>
                        </div>
                    </div>
                </div>
                <!-- END: Property Highlights -->
                <!-- BEGIN: Property Description -->
                <div class="row">
                    <div class="col-md-12">
                        <h3>Property Description</h3>
                        <div class="form-group">
                            <textarea id="property_description_summernote" name="property_description" class="form-control" rows="4"><?php echo $property->property_description?></textarea>
                        </div>
                    </div>
                </div>
                <!-- END: Property Description -->
                <!-- BEGIN: Property Images -->
                <div class="row" style="margin-bottom:25px;">
                    <div class="col-md-12">
                        <h3>Current Property Images</h3>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-2">
                                    <img src="<?php echo PROPERTY_IMAGE_PATH.(($property->image_main != '')?($property->image_main):('no_image.jpg'))?>" class="img-responsive img-rounded preview-thumbnail" alt="image" />
                                    <br />
                                    <a href="#" class="btn btn-xs btn-danger" title="Delete"><i class="fa fa-close"></i></a> Main Image
                                </div>
                                <div class="col-md-2">
                                    <img src="<?php echo PROPERTY_IMAGE_PATH.(($property->image_1 != '')?($property->image_1):('no_image.jpg'))?>" class="img-responsive img-rounded preview-thumbnail" alt="image" />
                                    <br />
                                    <a href="#" class="btn btn-xs btn-danger" title="Delete"><i class="fa fa-close"></i></a> Image 1
                                </div>
                                <div class="col-md-2">
                                    <img src="<?php echo PROPERTY_IMAGE_PATH.(($property->image_2 != '')?($property->image_2):('no_image.jpg'))?>" class="img-responsive img-rounded preview-thumbnail" alt="image" />
                                    <br />
                                    <a href="#" class="btn btn-xs btn-danger" title="Delete"><i class="fa fa-close"></i></a> Image 2
                                </div>
                                <div class="col-md-2">
                                    <img src="<?php echo PROPERTY_IMAGE_PATH.(($property->image_3 != '')?($property->image_3):('no_image.jpg'))?>" class="img-responsive img-rounded preview-thumbnail" alt="image" />
                                    <br />
                                    <a href="#" class="btn btn-xs btn-danger" title="Delete"><i class="fa fa-close"></i></a> Image 3
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-bottom:25px;">
                    <div class="col-md-12">
                        <h3>Edit Property Images</h3>
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
                <!-- END: Property Images -->
                <div class="row" style="margin-bottom:10px;">
                    <div class="col-md-12">
                        <button id="btnCancel" name="btnCancel" type="button" class="btn btn-danger pull-left" onclick="location.href='<?php echo BASE_URL_RSB?>view-property/<?php echo $property->id?>/<?php echo urlencode($property->property_name)?>/';"><i class="fa fa-close"></i> Cancel</button>
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
                    <!-- BEGIN: Upgrade Subscription -->
                    <div class="alert alert-warning" role="alert">
                        <strong><a href="<?php echo BASE_URL_RSB?>pricing/?property_hash=<?php echo $property->property_hash?>" title="Upgrade your subscription for additional features"><span class="red">UPGRADE</span></a></strong> this property subscription plan.
                    </div>
                    <!-- END: Upgrade Subscription -->
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