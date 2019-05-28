<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 23-AUG-2018
 * ---------------------------------------------------
 * Edit Joke & Trivia Page (edit_joke.php)
 *****************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Initialize page data...
 ************************************/
$strPageName = 'edit_joke';
$strPageTitle = 'Edit Joke &amp; Trivia Information';

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
            <h1>Edit Joke or Trivia Item</h1>
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
                    <h3>Update Joke or Trivia Item</h3>
                    <p>Use the form below to edit the item's information. When you are done, be sure to click "Update Item" to save the changes.</p>
                    <form id="frmEditJoke" name="frmEditJoke" action="<?php echo BASE_URL_RSB?>view-joke-trivia/<?php echo $item->id?>/<?php echo urlencode($item->content_name)?>/" method="post" class="form-light mt-20" enctype="multipart/form-data" role="form">
                        <input id="id" name="id" type="hidden" value="<?php echo $item->id?>" />
                        <input id="action" name="action" type="hidden" value="save_joke" />
                        <fieldset class="bordered-fieldset">
                        <legend>Item Information</legend>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Item Name</label>
                                    <input id="content_name" name="content_name" type="text" class="form-control" value="<?php echo $item->content_name?>" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Item Type</label>
                                    <select id="content_type" name="content_type" class="form-control">
                                        <?php
                                        foreach ($arrJokeTypes as $key => $val)
                                        {
                                            ?>
                                            <option value="<?php echo $key?>"<?php echo (($item->content_type == $key)?(' selected="selected"'):('')) ?>><?php echo $val?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h3>Item Description</h3>
                                <div class="form-group">
                                    <textarea id="content_data" name="content_data" class="form-control" rows="4"><?php echo $item->content_data?></textarea>
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
                                            <img src="<?php echo JOKE_IMAGE_PATH.(($item->image_main != '')?($item->image_main):('no_image.jpg'))?>" class="img-responsive img-rounded preview-thumbnail" alt="image" />
                                            <br />
                                            <a href="javascript:void(0);" class="btn btn-xs btn-danger" title="Delete"><i class="fa fa-close"></i></a> Main Image
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:25px;">
                            <div class="col-md-12">
                                <h3>Edit Joke Images</h3>
                                <div class="form-group">
                                    <label for="image_main">Main Image</label>
                                    <input type="file" class="form-control-file" id="image_main" name="image_main[]" />
                                </div>
                            </div>
                        </div>
                        <!-- END: Joke Images -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button id="btnCancel" name="btnCancel" type="button" class="btn btn-danger pull-left" onclick="location.href='<?php echo BASE_URL_RSB?>view-joke-trivia/<?php echo $item->id?>/<?php echo urlencode($item->content_name)?>/';"><i class="fa fa-close"></i> Cancel</button>
                                    <button id="btnSubmit" name="btnSubmit" type="submit" class="btn btn-info pull-right"><i class="fa fa-save"></i> Update Item</button>                                    
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
        <!-- END: Row -->
    </div>
    <!-- END: Container -->
<?php
/************************************
 * Include the HTML footer...
 ************************************/
include ('include/footer.php');
?>