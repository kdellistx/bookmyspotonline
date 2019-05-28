<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 15-DEC-2018
 * ---------------------------------------------------
 * Wizard: Ads Page (index.php)
 *****************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('../../includes/application.php');

/************************************
 * Initialize page data...
 ************************************/
$strPageName = 'wizard_ads';
$strPageTitle = 'Wizard - Create Your Ad';

/************************************
 * Initialize data arrays...
 ************************************/
if (loggedIn())
{
    $user = toObject($_SESSION['sys_user']);
    $arrProperties = getUserPropertyDataList($user->id, false);
} else {
    $user = toObject(createGuestUser());
    $arrProperties = array();
}

/************************************
 * Include the HTML header...
 ************************************/
include ('../include/wizard_header.php');
?>
<form id="frmAddAdvertisementWizard" name="frmAddAdvertisementWizard" action="<?php echo BASE_URL_RSB?>my-account/" method="post" class="form-light mt-20" enctype="multipart/form-data" role="form">
<input id="action" name="action" type="hidden" value="add_advertisement_wizard" />
<input id="user_id" name="user_id" type="hidden" value="<?php echo $user->id?>" />
<div class="container wizard-ad">
    <div class="row">
        <div class="col-md-3 wizard-ad-left">
            <img src="<?php echo BASE_URL_RSB_WIZARD?>assets/images/ad_icon_001.png" alt="icon" />
            <h3>Welcome</h3>
            <p>You are just moments away from creating your advertising campaign!</p>
        </div>
        <div class="col-md-9 wizard-ad-right">
            <ul class="nav nav-tabs nav-justified" id="tab-wizard-ad" role="tablist">
                <li class="nav-item"><a class="nav-link active" id="start-tab" data-toggle="tab" href="#start" role="tab" aria-controls="start" aria-selected="true">Start</a></li>
                <?php
                if (loggedIn())
                {
                    ?>
                    <li class="nav-item"><a class="nav-link" id="business-tab" data-toggle="tab" href="#business" role="tab" aria-controls="business" aria-selected="false">Business</a></li>
                    <li class="nav-item"><a class="nav-link" id="images-tab" data-toggle="tab" href="#images" role="tab" aria-controls="images" aria-selected="false">Content</a></li>
                    <li class="nav-item"><a class="nav-link" id="review-tab" data-toggle="tab" href="#review" role="tab" aria-controls="review" aria-selected="false">Review</a></li>
                    <?php
                }
                ?>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="start" role="tabpanel" aria-labelledby="start-tab">
                    <?php
                    if (loggedIn())
                    {
                        ?>
                        <h3 class="wizard-ad-heading">Create An Advertising Campaign</h3>
                        <?php
                    } else {
                        ?>
                        <h3 class="wizard-ad-heading">You must login or create an account</h3>
                        <?php
                    }
                    ?>
                    <?php
                    if (loggedIn())
                    {
                        ?>
                        <div class="row wizard-ad-form">
                            <div class="col-md-12 text-left">
                                <p>You must have at least one business attached to your account in order to create an advertisement for it. This can be done by either adding a property or claiming an existing one.</p>
                                <hr class="divider-thin" \>
                            </div>
                            <div class="col-md-6 hide-on-small">
                                <div class="form-group">
                                    <p class="form-control-static text-right">Name your campaign:</p>
                                </div>
                                <div class="form-group">
                                    <p class="form-control-static text-right">Advertisement Layout:</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" id="ad_name" name="ad_name" class="form-control" placeholder="Campaign Name" value="" />
                                </div>
                                <div class="form-group">
                                <select id="ad_type" name="ad_type" class="form-control">
                                    <?php
                                    foreach ($arrAdTypes as $key => $val)
                                    {
                                        ?>
                                        <option value="<?php echo $key?>"><?php echo $val?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                                <button type="button" id="btn-wizard-ad-continue-start" name="btn-wizard-ad-continue-start" class="btn-wizard-ad">Continue <i class="fa fa-arrow-right fa-left-5"></i></button>
                            </div>
                        </div>
                        <?php
                    } else {
                        ?>
                        <div class="row wizard-ad-form">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button type="button" id="btn-wizard-ad-login" name="btn-wizard-ad-login" class="btn btn-lg btn-primary btn-wizard-ad-large"><i class="fa fa-lock"></i> Login</button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button type="button" id="btn-wizard-ad-register" name="btn-wizard-ad-register" class="btn btn-lg btn-primary btn-wizard-ad-large"><i class="fa fa-user-plus"></i> Register</button>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <div class="tab-pane fade show" id="business" role="tabpanel" aria-labelledby="business-tab">
                    <h3  class="wizard-ad-heading">Select A Business</h3>
                    <div class="row wizard-ad-form">
                        <div class="col-md-12 text-left">
                            <p>If you don't see a business in the drop-down list below, you may need to add one to your account. Clcik the "Add New Business" button to add one to your account.</p>
                            <button type="button" id="btn-wizard-ad-add-property" name="btn-wizard-ad-add-property" class="btn btn-sm btn-primary"><i class="fa fa-plus fa-right-5"></i> Add New Business</button>
                            <hr class="divider-thin" \>
                        </div>
                        <div class="col-md-6 hide-on-small">
                            <div class="form-group">
                                <p class="form-control-static text-right">Select your business:</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <select id="property_id" name="property_id" class="form-control">
                                    <option value="0">-- Select Business -- </option>
                                    <?php
                                    if (!empty($arrProperties))
                                    {
                                        foreach ($arrProperties as $properties)
                                        {
                                            $property = toObject($properties);
                                            ?>
                                            <option value="<?php echo $property->id?>"><?php echo $property->property_name?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <button type="button" id="btn-wizard-ad-continue-business" name="btn-wizard-ad-continue-business" class="btn-wizard-ad">Continue <i class="fa fa-arrow-right fa-left-5"></i></button>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show" id="images" role="tabpanel" aria-labelledby="images-tab">
                    <h3  class="wizard-ad-heading">Add Content &amp; Images To Your Ad</h3>
                    <div class="row wizard-ad-form">
                        <div class="col-md-12 text-left">
                            <p>Add text and images to your advertisement by filling out the form below.</p>
                            <hr class="divider-thin" \>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group hide-on-small">
                                <p class="form-control-static text-right">Select an image for the ad:</p>
                            </div>
                            <div class="form-group hide-on-small">
                                <p class="form-control-static text-right">Enter some content for the ad:</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="file" class="form-control-file" id="image_main" name="image_main[]" />
                            </div>
                            <div class="form-group">
                                <textarea id="content" name="content" class="form-control" rows="3" placeholder="Enter text content..."></textarea>
                            </div>
                            <button type="button" id="btn-wizard-ad-continue-images" name="btn-wizard-ad-continue-images" class="btn-wizard-ad">Continue <i class="fa fa-arrow-right fa-left-5"></i></button>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show" id="review" role="tabpanel" aria-labelledby="review-tab">
                    <h3  class="wizard-ad-heading">Review Ad Campaign Details</h3>
                    <div class="row wizard-ad-form">
                        <div class="col-md-6">
                            <div class="form-group">
                                <p class="form-control-static text-right"><strong>Name:</strong><br/><span id="data-ad-name"></span></p>
                            </div>
                            <div class="form-group">
                                <p class="form-control-static text-right"><strong>Type:</strong><br/><span id="data-ad-type"></span></p>
                            </div>
                            <div class="form-group">
                                <p class="form-control-static text-right"><strong>Business:</strong><br/><span id="data-property-id"></span></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <p class="form-control-static text-right"><strong>Image:</strong><br/><span id="data-image-main"></span></p>
                            </div>
                            <div class="form-group">
                                <p class="form-control-static text-right"><strong>Content:</strong><br/><span id="data-content"></span></p>
                            </div>
                            <button type="button" id="btn-wizard-ad-stop-review" name="btn-wizard-ad-stop-review" class="btn-wizard-ad">Save <i class="fa fa-save fa-left-5"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<?php
/************************************
 * Include the HTML footer...
 ************************************/
include ('../include/wizard_footer.php');
?>