<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 18-MAY-2018
 * ---------------------------------------------------
 * Master Page (master.php)
 *****************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Initialize page data...
 ************************************/
$strPageName = 'Master';
$strPageTitle = 'Admin Area';

/************************************
 * Check if page is protected...
 ************************************/
isProtectedPage();

/************************************
 * Initialize data arrays...
 ************************************/
$user = toObject($_SESSION['sys_user']);
$arrProperties = getUserPropertyDataList($user->id, true);

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
            <!-- BEGIN: Account Content -->
            <div class="col-md-8">
                <!-- BEGIN: All Properties -->
                <div class="row" style="margin-top:30px;">
                    <!-- Data Table -->
                    <div class="col-md-12">
                        <form id="frmManageProperties" name="frmManageProperties" action="<?php echo BASE_URL_RSB?>my-account/" method="post" class="form-light mt-20" role="form">
                            <input id="action" name="action" type="hidden" value="post_new_property_link" />
                            <fieldset class="bordered-fieldset">
                            <legend>All Properties <span class="pull-right" style="font-size:14px;">To find unapproved properties, search for "<span class="red">unapproved</span>"</span></legend>
                            <table id="masterProperties" class="table table-hover table-condensed account-data-table">
                              <thead>
                                <tr>
                                  <th>Name</th>
                                  <th>Category</th>
                                  <th>City</th>
                                  <th>Status</th>
                                  <th>Actions</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                if (count($arrProperties) > 0)
                                {
                                    foreach ($arrProperties as $properties)
                                    {
                                        $property = toObject($properties);
                                        ?>
                                        <tr>
                                          <td><?php echo $property->property_name?></td>
                                          <td><?php echo getPropertyCategoryName($property->category_id)?></td>
                                          <td><?php echo $property->property_city?></td>
                                          <td><?php echo $arrApprovedStatus[$property->is_approved]?></td>
                                          <td style="white-space:nowrap;">
                                            <button type="button" class="btn btn-xs btn-success" title="View" onclick="window.location='<?php echo BASE_URL_RSB?>view-property/<?php echo $property->id?>/<?php echo urlencode($property->property_name)?>/';"><i class="table-action-button fa fa-eye"></i></button>
                                            <button type="button" class="btn btn-xs btn-danger" title="Delete" onclick="window.location='<?php echo BASE_URL_RSB?>my-account/?action=delete_property&property_id=<?php echo $property->id?>';"><i class="table-action-button fa fa-trash"></i></button>
                                            <button type="button" class="btn btn-xs btn-primary" title="Add Event" onclick="window.location='<?php echo BASE_URL_RSB?>view-property/<?php echo $property->id?>/';"><i class="table-action-button fa fa-calendar"></i></button>
                                            <?php
                                            if ($property->is_approved == 0)
                                            {
                                                ?>
                                                <button type="button" class="btn btn-xs btn-warning" title="Approve Property" onclick="window.location='<?php echo BASE_URL_RSB?>master/?action=approve_property&id=<?php echo $property->id?>';"><i class="table-action-button fa fa-check"></i></button>
                                                <?php
                                            }
                                            ?>
                                          </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <tr><td colspan="5">No properties exist.</td></tr>
                                    <?php
                                }
                                ?>
                              </tbody>
                            </table>
                            </fieldset>
                        </form>
                    </div><!-- /Data Table -->
                </div><!-- /Row -->
            </div>
            <!-- END: Account Content -->
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