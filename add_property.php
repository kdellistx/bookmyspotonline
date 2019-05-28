<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 18-MAY-2018
 * ---------------------------------------------------
 * Add Property Page (add_property.php)
 *****************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Initialize page data...
 ************************************/
$strPageName = 'add_property';
$strPageTitle = 'Add Property Information';

/************************************
 * Check if page is protected...
 ************************************/
isProtectedPage();

/************************************
 * Initialize data arrays...
 ************************************/
if (loggedIn())
{
    $user = toObject($_SESSION['sys_user']);
} else {
    $user = toObject(createGuestUser());
}
$arrProperty = array();
$property = toObject($arrProperty);
$arrCategories = generatePropertyCategories();
$arrProperties = getUserPropertyDataList($user->id, true);
$arrCountries = generateCountries();

/************************************
 * Include the HTML header...
 ************************************/
include ('include/header.php');
?>
    <section class="parallax-window" id="short" data-parallax="scroll" data-image-src="<?php echo BASE_URL_RSB?>img/rv_camp_003.jpg" data-natural-width="1350" data-natural-height="465">
        <div id="subheader">
            <h1>Add Property</h1>
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
                            <h3>Add New Property</h3>
                            <p>Hey, <?php echo $user->first_name?>, use the form below to add a new property. <?php if (loggedIn()) { ?> You can use the menu at the right to make changes to your account, change your password, or perform other tasks.<?php } ?> <?php if (!loggedIn()){?><strong>You must either <a href="<?php echo BASE_URL_RSB?>register/" class="text-primary" title="Click here to create a username and password">create</a> a username and password or be <a href="<?php echo BASE_URL_RSB?>login/" style="color:#FF0000;" title="Click here to login">logged in</a> to save a property.</strong><?php } ?></p>
                            <p style="color:#FF0000;">The "Property Name" field below includes an auto-complete feature. If the property name you're trying to add already shows up and pre-populates the form, there may be another property with your same name. If you would like to claim this property, first select the site name from the list, and then click on the orange <strong>"CLAIM THIS PROPERTY"</strong> button to claim the site. <?php if (!loggedIn()){?><strong>NOTE: You *MUST* be <a href="<?php echo BASE_URL_RSB?>login/" style="color:#FF0000; text-decoration:underline;" title="Click here to login">logged-in</a> to claim a property.</strong><?php } ?></p>
                            <?php
                            if (loggedIn())
                            {
                                ?>
                                <form id="frmAddProperty" name="frmAddProperty" action="<?php echo BASE_URL_RSB?>my-account/" method="post" class="form-light mt-20" enctype="multipart/form-data" role="form">
                                <?php
                            } else {
                                ?>
                                <form id="frmAddProperty" name="frmAddProperty" action="<?php echo BASE_URL_RSB?>" method="post" class="form-light mt-20" enctype="multipart/form-data" role="form">
                                <?php
                            }
                            ?>
                                <input type="hidden" id="action" name="action" value="add_property" />
                                <input type="hidden" id="user_id" name="user_id" value="<?php echo $user->id?>" />
                                <input type="hidden" id="is_claimed" name="is_claimed" value="0" />
                                <input type="hidden" id="property_id" name="property_id" value="0" />
                                <?php
                                if ($user->tz == 1)
                                {
                                    ?>
                                    <input id="is_admin" name="is_admin" type="hidden" value="1" />
                                    <?php
                                }
                                ?>
                                <fieldset class="bordered-fieldset">
                                <?php
                                if (loggedIn())
                                {
                                    ?>
                                    <legend>Property Information <button type="button" id="btnClaimProperty" name="btnClaimProperty" class="btn btn-sm btn-warning pull-right">CLAIM THIS PROPERTY</button></legend>
                                    <?php
                                } else {
                                    ?>
                                    <legend>Property Information</legend>
                                    <?php
                                }
                                ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group ui-widget">
                                            <label>Property Name <a class="linkProperty btn btn-xs btn-info" href="javascript:void(0);" target="_blank" title="View property details" style="display:none;"><i class="fa fa-eye"></i></a> <button type="button" id="btnResetAddProperty" name="btnResetAddProperty" class="btn btn-xs btn-info">RETURN TO ENTRY</button></label>
                                            <input id="property_name" name="property_name" type="text" class="form-control" value="<?php echo $property->property_name?>" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Category</label>
                                            <select id="category_id" name="category_id" class="form-control">
                                                <option value="0"> -- Select-- </option>
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
                                            <label>Country</label>
                                            <select id="property_country" name="property_country" class="form-control">
                                                <option value="254"<?php echo (($property->property_country ==254)?(' selected="selected"'):(''))?>>United States</option>
                                                <option value="43"<?php echo (($property->property_country == 43)?(' selected="selected"'):(''))?>>Canada</option>
                                                <?php
                                                foreach ($arrCountries as $key => $val)
                                                {
                                                    ?>
                                                    <option value="<?php echo $key?>"<?php echo (($property->property_country == $key)?(' selected="selected"'):(''))?>><?php echo $val?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
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
                                            <label>State / Province / Region</label>
                                            <select id="property_state" name="property_state" class="form-control">
                                                <option value="0"> -- Select-- </option>
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
                                            <label>Website (ie: <span style="color:#FF0000;">www.example.com</span>)</label>
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
                <?php
                if (loggedIn())
                {
                    ?>
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
                    <?php
                }
                ?>
                <!-- END: Property Images -->
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        if (loggedIn())
                        {
                            ?>
                            <button id="btnCancel" name="btnCancel" type="button" class="btn btn-danger pull-left" onclick="location.href='<?php echo BASE_URL_RSB?>my-account/';"><i class="fa fa-close"></i> Cancel</button>
                            <button id="btnSubmit" name="btnSubmit" type="submit" class="btn btn-info pull-right"><i class="fa fa-save"></i> Save</button>
                            <?php
                        } else {
                            ?>
                            <button id="btnCancel" name="btnCancel" type="button" class="btn btn-danger pull-left" onclick="location.href='<?php echo BASE_URL_RSB?>';"><i class="fa fa-close"></i> Cancel</button>
                            <button id="btnSubmit" name="btnSubmit" type="button" class="btn btn-warning pull-right" onclick="location.href='<?php echo BASE_URL_RSB?>login/';"><i class="fa fa-ban"></i> Login To Save Property</button>
                            <?php
                        }
                        ?>
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
                    <div class="alert alert-warning" role="alert" style="display:none;">
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