<?php
/*********************************************************
 * Created by: Randy S. Baker
 * Created on: 20-DEC-2018
 * -------------------------------------------------------
 * Download Registration Data (download_registration_data.php)
 *********************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Initialize page data...
 ************************************/
$strPageName = 'download_registration_data';
$strPageTitle = 'Download Registration Data';

/************************************
 * Check if page is protected...
 ************************************/
isProtectedPage();

/************************************
 * Assemble the data...
 ************************************/
$arrFields = array('id','email','first_name','last_name','address_1','city','state','zipcode','phone');
$arrMailerData = generateMailerRegistrationData($arrFields);

/************************************
 * Send the data to the browser...
 ************************************/
@header('Content-Type: text/csv; charset=utf-8');
@header('Content-Disposition: attachment; filename=bmso_mailer_registration_data.csv');
$output = fopen('php://output', 'w');
fputcsv($output, $arrFields);
foreach ($arrMailerData as $key => $val)
{
	fputcsv($output, $val);
}

/************************************
 * Exit the script...
 ************************************/
die();
?>