<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 21-JUL-2018
 * ---------------------------------------------------
 * Edit Advertisement Page (edit_advertisement.php)
 *****************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Initialize page data...
 ************************************/
$strPageName = 'edit_advertisement';
$strPageTitle = 'Edit Advertisement Information';

/************************************
 * Check if page is protected...
 ************************************/
isProtectedPage();

/************************************
 * Initialize data arrays...
 ************************************/
$user = toObject($_SESSION['sys_user']);
$ad = toObject(getAdvertisementData($intAdvertisementID));
$arrProperties = generatePropertes(3500);

/************************************
 * Include the HTML header...
 ************************************/
include ('include/header.php');
?>
    <section class="parallax-window" id="short" data-parallax="scroll" data-image-src="<?php echo BASE_URL_RSB?>img/rv_camp_003.jpg" data-natural-width="1350" data-natural-height="465">
        <div id="subheader">
            <h1>Edit Advertisement</h1>
        </div>
    </section>
    <div class="container margin_60">
        <div class="row">
            <!-- BEGIN: Advertisement Content -->
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12">
                <!-- BEGIN: Advertisement Overview -->
                <div class="job-details-wrapper">
                    <h3>Update Advertisement</h3>
                    <p>Use the form below to edit the advertisement information. When you are done, be sure to click "Update Advertisement" to save the changes.</p>
                    <form id="frmEditAdvertisement" name="frmEditAdvertisement" action="<?php echo BASE_URL_RSB?>view-advertisement/<?php echo $ad->id?>/<?php echo $ad->property_id?>/" method="post" class="form-light mt-20" enctype="multipart/form-data" role="form">
                        <input id="id" name="id" type="hidden" value="<?php echo $ad->id?>" />
                        <input id="action" name="action" type="hidden" value="save_advertisement" />
                        <fieldset class="bordered-fieldset">
                        <legend>Advertisement Information</legend>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Property Name</label>
                                    <select id="property_id" name="property_id" class="form-control">
                                        <option value="0">-- Select-- </option>
                                        <?php
                                        if (!empty($arrProperties))
                                        {
                                            foreach ($arrProperties as $properties)
                                            {
                                                $property = toObject($properties);
                                                ?>
                                                <option value="<?php echo $property->id?>"<?php echo (($ad->property_id == $property->id)?(' selected="selected"'):('')) ?>><?php echo $property->property_name?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Advertisement Type</label>
                                    <select id="ad_type" name="ad_type" class="form-control">
                                        <?php
                                        foreach ($arrAdTypes as $key => $val)
                                        {
                                            ?>
                                            <option value="<?php echo $key?>"<?php echo (($ad->ad_type == $key)?(' selected="selected"'):('')) ?>><?php echo $val?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h3>Advertisement Description</h3>
                                <div class="form-group">
                                    <textarea id="content" name="content" class="form-control" rows="4"><?php echo $ad->content?></textarea>
                                </div>
                            </div>
                        </div>
                        <!-- BEGIN: Advertisement Images -->
                        <div class="row" style="margin-bottom:25px;">
                            <div class="col-md-12">
                                <h3>Current Advertisement Images</h3>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <img src="<?php echo AD_IMAGE_PATH.(($ad->image_main != '')?($ad->image_main):('no_image.jpg'))?>" class="img-responsive img-rounded preview-thumbnail" alt="image" />
                                            <br />
                                            <a href="javascript:void(0);" class="btn btn-xs btn-danger" title="Delete"><i class="fa fa-close"></i></a> Main Image
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:25px;">
                            <div class="col-md-12">
                                <h3>Edit Advertisement Images</h3>
                                <div class="form-group">
                                    <label for="image_main">Main Image</label>
                                    <input type="file" class="form-control-file" id="image_main" name="image_main[]" />
                                </div>
                            </div>
                        </div>
                        <!-- END: Advertisement Images -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button id="btnCancel" name="btnCancel" type="button" class="btn btn-danger pull-left" onclick="location.href='<?php echo BASE_URL_RSB?>view-advertisement/<?php echo $ad->id?>/<?php echo $ad->property_id?>/';"><i class="fa fa-close"></i> Cancel</button>
                                    <button id="btnSubmit" name="btnSubmit" type="submit" class="btn btn-primary pull-right">Update Advertisement <i class="fa fa-save"></i></button>
                                </div>
                            </div>
                        </div>
                        </fieldset>
                    </form>
                </div>
                <!-- END: Advertisement Overview -->
               </div>
              </div>
            </div>
            <!-- END: Advertisement Content -->
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