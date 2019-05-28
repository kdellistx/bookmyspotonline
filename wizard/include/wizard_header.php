<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 15-DEC-2018
 * ---------------------------------------------------
 * Wizard Public HTML Header (wizard_header.php)
 *****************************************************/
@header('Access-Control-Allow-Origin: *');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="keywords" content="book my spot online" />
        <meta name="description" content="Book My Spot Online - bookmyspotonline.com" />
        <meta name="author" content="Baker Diagnostics" />
        <meta name="msapplication-TileColor" content="#DA532C" />
        <meta name="theme-color" content="#FFFFFF" />
        <title><?php echo (($strPageTitle != '') ? ($strPageTitle . ' | Book My Spot Online') : ('Book My Spot Online'))?></title>
        <link rel="manifest" href="<?php echo BASE_URL_RSB?>img/favicons/site.webmanifest" />
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo BASE_URL_RSB?>favicon.ico" />
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo BASE_URL_RSB?>img/favicons/apple-touch-icon.png" />
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo BASE_URL_RSB?>img/favicons/favicon-32x32.png" />
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo BASE_URL_RSB?>img/favicons/favicon-16x16.png" />
        <link rel="mask-icon" href="<?php echo BASE_URL_RSB?>img/favicons/safari-pinned-tab.svg" color="#5BBAD5" />
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL_RSB_WIZARD?>assets/css/wizard-base.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL_RSB_WIZARD?>assets/css/wizard-ad.css" />
        <script src="<?php echo BASE_URL_RSB?>js/jquery-3.3.1.min.js"></script>
        <!--[if lt IE 9]>
          <script src="<?php echo BASE_URL_RSB?>js/html5shiv.min.js"></script>
          <script src="<?php echo BASE_URL_RSB?>js/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="layer"></div>
        <div id="preloader">
            <div data-loader="circle-side"></div>
        </div>
        <header>
            <div class="container">
                <div class="row">
                    <div class="col-md-2">
                        <a href="<?php echo BASE_URL_RSB?>" id="logo"><img src="<?php echo BASE_URL_RSB?>img/logo.png" width="190px" height="23px" alt="logo" data-retina="true" /></a>
                    </div>
                    <nav class="col-md-10">
                        <a class="cmn-toggle-switch cmn-toggle-switch__htx open_close" href="javascript:void(0);"><span>Mobile Menu</span></a>
                        <ul id="lang_top">
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="https://www.instagram.com/bookmyspotonline/" target="_blank"><i class="fa fa-instagram"></i></a></li>
                            <li><a href="#"><i class="fa fa-youtube"></i></a></li>
                        </ul>
                        <div class="main-menu">
                            <div id="header_menu">
                                <img src="<?php echo BASE_URL_RSB?>img/logo.png" width="141px" height="40px" alt="logo" data-retina="true" />
                            </div>
                            <a href="#" class="open_close" id="close_in"><i class="icon_set_1_icon-77"></i></a>
                            <ul>
                                <li><a href="<?php echo BASE_URL_RSB?>">Home</a></li>
                                <li><a href="<?php echo BASE_URL_RSB?>events/">Events</a></li>
                                <li><a href="<?php echo BASE_URL_RSB?>for-sale/">For Sale</a></li>
                                <li><a href="<?php echo BASE_URL_RSB?>destinations/">Destinations</a></li>
                                <li><a href="<?php echo BASE_URL_RSB?>trip-planner/">Trip Planner</a></li>
                                <li class="menu">
                                <a href="javascript:void(0);" class="show-submenu">Sign In<i class="icon-down-open-mini"></i></a>
                                <ul>
                                    <li><a href="<?php echo BASE_URL_RSB?>my-account/">My Account</a></li>
                                    <?php
                                    if (loggedIn())
                                    {
                                        ?>
                                        <li><a href="<?php echo BASE_URL_RSB?>logoff/">Log Out</a></li>
                                        <?php
                                    } else {
                                        ?>
                                        <li><a href="<?php echo BASE_URL_RSB?>login/">Log In</a></li>
                                        <li><a href="<?php echo BASE_URL_RSB?>register/">Register</a></li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                                </li>
                                <li><a href="<?php echo BASE_URL_RSB?>faq/">FAQ</a></li>
                                <li><a href="<?php echo BASE_URL_RSB?>contact/">Contact Us</a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </header>
