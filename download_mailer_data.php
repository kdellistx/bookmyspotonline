<?php
/*********************************************************
 * Created by: Randy S. Baker
 * Created on: 03-JUL-2018
 * -------------------------------------------------------
 * Download Mailer Data (download_mailer_data.php)
 *********************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Initialize page data...
 ************************************/
$strPageName = 'download_mailer_data';
$strPageTitle = 'Download Mailer Data';

/************************************
 * Check if page is protected...
 ************************************/
isProtectedPage();

/************************************
 * Assemble the data...
 ************************************/
$arrFields = array('category','id','property_name','property_address','property_city','property_state','property_zipcode','property_phone','property_website');
$arrMailerData = generateMailerData($arrFields);

/************************************
 * Send the data to the browser...
 ************************************/
@header('Content-Type: text/csv; charset=utf-8');
@header('Content-Disposition: attachment; filename=bmso_mailer_data.csv');
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