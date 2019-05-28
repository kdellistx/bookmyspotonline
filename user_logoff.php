<?php
/*********************************************************
 * Created by: Randy S. Baker
 * Created on: 13-MAR-2018
 * -------------------------------------------------------
 * Account: Logoff Page (user_logoff.php)
 *********************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Initialize page data...
 ************************************/
$strPageName = 'user_logoff';
$strPageTitle = 'User Account Logoff';

/************************************
 * Check authentication...
 ************************************/
if (!loggedIn())
{
	doRedirect(BASE_URL_RSB.'login/');
}

/************************************
 * Perform logoff actions...
 ************************************/
unset($_SESSION['sys_user']);
session_destroy();
doRedirect(BASE_URL_RSB.'login/');
?>