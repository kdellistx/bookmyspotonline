<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 13-APR-2018
 * ---------------------------------------------------
 * My Account: Sidebar (my_account_sidebar.php)
 *****************************************************/
?>
<h3>Perform a Quick Task...</h3>
<p class="text-left">Select one of the options below to perform a quick task, such as update your account information, change your password, etc.</p>
    <ul class="text-left">
        <?php
        if (isGuest() || !loggedIn())
        {
            ?>
            <li><a href="javascript:void(0);">Account Home</a></li>
            <li><a href="javascript:void(0);">Update Account Information</a></li>
            <li><a href="javascript:void(0);">Change Your Password</a></li>
            <li><a href="javascript:void(0);">Add A New Property, Site, or Business</a></li>
            <li><a href="javascript:void(0);">Sell An Item</a></li>
            <?php
        } else {
            ?>
            <li><a href="<?php echo BASE_URL_RSB?>my-account/">Account Home</a></li>
            <li><a href="<?php echo BASE_URL_RSB?>edit-account/">Update Account Information</a></li>
            <li><a href="<?php echo BASE_URL_RSB?>edit-account/">Change Your Password</a></li>
            <li><a href="<?php echo BASE_URL_RSB?>add-property/">Add A New Property, Site, or Business</a></li>
            <li><a href="<?php echo BASE_URL_RSB?>add-marketplace-item/">Sell An Item</a></li>
            <?php
        }
        ?>
        <?php
        if ($user->tz == 1)
        {
            ?>
            <li><a href="<?php echo BASE_URL_RSB?>add-joke-trivia/">Create A Joke / Trivia</a> <i class="fa fa-star orange"></i></li>
            <li><a href="<?php echo BASE_URL_RSB?>add-advertisement/">Create An Advertisement</a> <i class="fa fa-star orange"></i></li>
            <li><a href="<?php echo BASE_URL_RSB?>master/">Admin - Properties</a> <i class="fa fa-star orange"></i></li>
            <li><a href="<?php echo BASE_URL_RSB?>manage-for-sale-items/">Admin - For Sale Items</a> <i class="fa fa-star orange"></i></li>
            <li><a href="<?php echo BASE_URL_RSB?>manage-advertisements/">Admin - Advertisements</a> <i class="fa fa-star orange"></i></li>
            <li><a href="<?php echo BASE_URL_RSB?>manage-jokes-and-trivia/">Admin - Jokes And Trivia</a> <i class="fa fa-star orange"></i></li>
            <li><a href="<?php echo BASE_URL_RSB?>download-mailer-data/">Admin - Download Mailer Data</a> <i class="fa fa-star orange"></i></li>
            <li><a href="<?php echo BASE_URL_RSB?>download-registration-data/">Admin - Download Registration Data</a> <i class="fa fa-star orange"></i></li>
            <li><a href="<?php echo BASE_URL_RSB?>download-subscriber-data/">Admin - Download Subscriber Data</a> <i class="fa fa-star orange"></i></li>
            <?php
        }

        if (loggedIn())
        {
            ?>
            <li><a href="<?php echo BASE_URL_RSB?>logoff/">Log Out</a></li>
            <?php
        }
        ?>
    </ul>