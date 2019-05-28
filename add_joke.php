<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 23-AUG-2018
 * ---------------------------------------------------
 * Add Joke & Trivia Page (add_joke.php)
 *****************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Initialize page data...
 ************************************/
$strPageName = 'add_joke';
$strPageTitle = 'Add Joke or Trivia Item';

/************************************
 * Check if page is protected...
 ************************************/
isProtectedPage();

/************************************
 * Initialize data arrays...
 ************************************/
$user = toObject($_SESSION['sys_user']);

/************************************
 * Include the HTML header...
 ************************************/
include ('include/header.php');
?>
    <section class="parallax-window" id="short" data-parallax="scroll" data-image-src="<?php echo BASE_URL_RSB?>img/rv_camp_003.jpg" data-natural-width="1350" data-natural-height="465">
        <div id="subheader">
            <h1>Add Joke or Trivia Item</h1>
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
                    <h3>Add Joke or Trivia Item</h3>
                    <p>Use the form below to add the joke or trivia information. When you are done, be sure to click "Save Item" to save the changes.</p>
                    <form id="frmAddJoke" name="frmAddJoke" action="<?php echo BASE_URL_RSB?>manage-jokes-and-trivia/" method="post" class="form-light mt-20" role="form">
                        <input id="action" name="action" type="hidden" value="add_joke" />
                        <fieldset class="bordered-fieldset">
                        <legend>Item Information</legend>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Item Name</label>
                                    <input id="content_name" name="content_name" type="text" class="form-control" value="" />
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
                                            <option value="<?php echo $key?>"><?php echo $val?></option>
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
                                    <textarea id="content_data" name="content_data" class="form-control" rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                        <!-- BEGIN: Joke Images -->
                        <div class="row" style="margin-bottom:25px;">
                            <div class="col-md-12">
                                <h3>Edit Item Images</h3>
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
                                    <button id="btnCancel" name="btnCancel" type="button" class="btn btn-danger pull-left" onclick="location.href='<?php echo BASE_URL_RSB?>manage-jokes-and-trivia/';"><i class="fa fa-close"></i> Cancel</button>
                                    <button id="btnSubmit" name="btnSubmit" type="submit" class="btn btn-info pull-right"><i class="fa fa-save"></i> Save Item</button>                                    
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