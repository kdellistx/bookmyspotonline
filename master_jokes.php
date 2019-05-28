<?php
/**************************************************************
 * Created by: Randy S. Baker
 * Created on: 23-AUG-2018
 * ------------------------------------------------------------
 * Master Jokes & Trivia Page (master_jokes.php)
 **************************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Initialize page data...
 ************************************/
$strPageName = 'master_jokes';
$strPageTitle = 'Admin Area - Jokes and Trivia';

/************************************
 * Check if page is protected...
 ************************************/
isProtectedPage();

/************************************
 * Initialize data arrays...
 ************************************/
$user = toObject($_SESSION['sys_user']);
$arrJokes = generateJokes(true, 0, 500);
//showDebug($arrJokes, 'jokes', true);

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
            <!-- BEGIN: Overall Content -->
            <div class="col-md-8">
                <!-- BEGIN: All Joke Items -->
                <div class="row" style="margin-top:30px;">
                    <!-- Data Table -->
                    <div class="col-md-12">
                        <form id="frmManageJokes" name="frmManageJokes" action="<?php echo BASE_URL_RSB?>my-account/" method="post" class="form-light mt-20" role="form">
                            <input id="action" name="action" type="hidden" value="post_new_joke_item_link" />
                            <fieldset class="bordered-fieldset">
                            <legend>All Jokes &amp; Trivia</legend>
                            <table class="table table-hover table-condensed account-data-table">
                              <thead>
                                <tr>
                                  <th>ID</th>
                                  <th>Title</th>
                                  <th>Type</th>
                                  <th>Updated</th>
                                  <th>Actions</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                if (count($arrJokes) > 0)
                                {
                                    foreach ($arrJokes as $items)
                                    {
                                        $item = toObject($items);
                                        ?>
                                        <tr>
                                          <td><?php echo $item->id?></td>
                                          <td><?php echo $item->content_name?></td>
                                          <td><?php echo $arrJokeTypes[$item->content_type]?></td>
                                          <td><?php echo date('m-d-Y h:i a', $item->updated)?></td>
                                          <td style="white-space:nowrap;">
                                            <button type="button" class="btn btn-xs btn-success" title="View" onclick="window.location='<?php echo BASE_URL_RSB?>view-joke-trivia/<?php echo $item->id?>/<?php echo urlencode($item->content_name)?>/';"><i class="table-action-button fa fa-eye"></i></button>
                                            <button type="button" class="btn btn-xs btn-warning" title="Edit" onclick="window.location='<?php echo BASE_URL_RSB?>edit-joke-trivia/<?php echo $item->id?>/<?php echo urlencode($item->content_name)?>/';"><i class="table-action-button fa fa-pencil"></i></button>
                                            <button type="button" class="btn btn-xs btn-danger" title="Remove advertisement" onclick="window.location='<?php echo BASE_URL_RSB?>my-account/?action=delete_joke&joke_id=<?php echo $item->id?>';"><i class="table-action-button fa fa-trash"></i></button>
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
                    </div>
                    <!-- /Data Table -->
                </div>
                <!-- /Row -->
            </div>
            <!-- END: Overall Content -->
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