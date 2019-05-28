<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 21-JUL-2018
 * ---------------------------------------------------
 * View Advertisement Page (view_advertisement.php)
 *****************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Initialize page data...
 ************************************/
$strPageName = 'view_advertisement';
$strPageTitle = 'View Advertisement Information';

/************************************
 * Check if page is protected...
 ************************************/
isProtectedPage();

/************************************
 * Initialize data arrays...
 ************************************/
$user = toObject($_SESSION['sys_user']);
$ad = toObject(getAdvertisementData($intAdvertisementID));

/************************************
 * Include the HTML header...
 ************************************/
include ('include/header.php');
?>
    <section class="parallax-window" id="short" data-parallax="scroll" data-image-src="<?php echo BASE_URL_RSB?>img/rv_camp_003.jpg" data-natural-width="1350" data-natural-height="465">
        <div id="subheader">
            <h1>View Advertisement</h1>
        </div>
    </section>
    <div class="container margin_60">
        <div class="row">
            <!-- BEGIN: Ad Content -->
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12">
                <!-- BEGIN: Ad Overview -->
                <div class="job-details-wrapper">
                    <h3>View Advertisement</h3>
                    <p>Use the form below to view the advertisement information. To edit the advertisement, just click on "Edit Advertisement" to be directed to the advertisement edit page.</p>
                    <form id="frmViewAdvertisement" name="frmViewAdvertisement" action="<?php echo BASE_URL_RSB?>edit-advertisement/<?php echo $ad->id?>/<?php echo $ad->property_id?>/" method="post" class="form-light mt-20" role="form">
                        <input id="action" name="action" type="hidden" value="view_advertisement" />
                        <fieldset class="bordered-fieldset">
                        <legend>Advertisement Information</legend>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Property Name</label>
                                    <input disabled readonly id="property_id" name="property_id" type="text" class="form-control" value="<?php echo getPropertyName($ad->property_id)?>" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Advertisement Type</label>
                                    <input disabled readonly id="ad_type" name="ad_type" type="text" class="form-control" value="<?php echo $arrAdTypes[$ad->ad_type]?>" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h3>Advertisement Content</h3>
                                <div class="form-group">
                                    <?php echo (($ad->content == '')?('(none)'):($ad->content))?>
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
                        <!-- END: Advertisement Images -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button id="btnCancel" name="btnCancel" type="button" class="btn btn-danger pull-left" onclick="location.href='<?php echo BASE_URL_RSB?>manage-advertisements/';"><i class="fa fa-close"></i> Cancel</button>
                                    <button id="btnSubmit" name="btnSubmit" type="submit" class="btn btn-primary pull-right">Edit Advertisement <i class="fa fa-pencil"></i></button>
                                </div>
                            </div>
                        </div>
                        </fieldset>
                    </form>
                </div>
                <!-- END: Ad Overview -->
               </div>
              </div>
            </div>
            <!-- END: Ad Content -->
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