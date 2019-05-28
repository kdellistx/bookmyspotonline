<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 23-AUG-2018
 * ---------------------------------------------------
 * View Joke & Trivia Page (view_joke.php)
 *****************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Initialize page data...
 ************************************/
$strPageName = 'view_joke';
$strPageTitle = 'View Joke &amp; Trivia Information';

/************************************
 * Check if page is protected...
 ************************************/
isProtectedPage();

/************************************
 * Initialize data arrays...
 ************************************/
$user = toObject($_SESSION['sys_user']);
$item = toObject(getJokeData($intJokeID));

/************************************
 * Include the HTML header...
 ************************************/
include ('include/header.php');
?>
    <section class="parallax-window" id="short" data-parallax="scroll" data-image-src="<?php echo BASE_URL_RSB?>img/rv_camp_003.jpg" data-natural-width="1350" data-natural-height="465">
        <div id="subheader">
            <h1>View Joke or Trivia Item</h1>
        </div>
    </section>
    <div class="container margin_60">
        <div class="row">
            <!-- BEGIN: Joke Content -->
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12">
                <!-- BEGIN: Joke Overview -->
                <div class="job-details-wrapper">
                    <h3>View Joke or Trivia Item</h3>
                    <p>Use the form below to view the joke or trivia information. To edit the item, just click on "Edit Item" to be directed to the item's edit page.</p>
                    <form id="frmViewJoke" name="frmViewJoke" action="<?php echo BASE_URL_RSB?>edit-joke-trivia/<?php echo $item->id?>/<?php echo urlencode($item->content_name)?>/" method="post" class="form-light mt-20" role="form">
                        <input id="action" name="action" type="hidden" value="view_joke" />
                        <fieldset class="bordered-fieldset">
                        <legend>Item Information</legend>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Item Name</label>
                                    <input disabled readonly id="content_name" name="content_name" type="text" class="form-control" value="<?php echo $item->content_name?>" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Item Type</label>
                                    <input disabled readonly id="content_type" name="content_type" type="text" class="form-control" value="<?php echo $arrJokeTypes[$item->content_type]?>" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h3>Item Content</h3>
                                <div class="form-group">
                                    <?php echo (($item->content_data == '')?('(none)'):($item->content_data))?>
                                </div>
                            </div>
                        </div>
                        <!-- BEGIN: Joke Images -->
                        <div class="row" style="margin-bottom:25px;">
                            <div class="col-md-12">
                                <h3>Current Item Images</h3>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <img src="<?php echo JOKE_IMAGE_PATH.(($content->image_main != '')?($content->image_main):('no_image.jpg'))?>" class="img-responsive img-rounded preview-thumbnail" alt="image" />
                                            <br />
                                            <a href="javascript:void(0);" class="btn btn-xs btn-danger" title="Delete"><i class="fa fa-close"></i></a> Main Image
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END: Joke Images -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button id="btnCancel" name="btnCancel" type="button" class="btn btn-danger pull-left" onclick="location.href='<?php echo BASE_URL_RSB?>manage-jokes-and-trivia/';"><i class="fa fa-close"></i> Cancel</button>
                                    <button id="btnSubmit" name="btnSubmit" type="submit" class="btn btn-info pull-right"><i class="fa fa-pencil"></i> Edit Item</button>
                                </div>
                            </div>
                        </div>
                        </fieldset>
                    </form>
                </div>
                <!-- END: Joke Overview -->
               </div>
              </div>
            </div>
            <!-- END: Joke Content -->
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