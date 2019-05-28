<?php
/*********************************************************
 * Created by: Randy S. Baker
 * Created on: 20-DEC-2018
 * -------------------------------------------------------
 * Download Subscriber Data (download_subscriber_data.php)
 *********************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Initialize page data...
 ************************************/
$strPageName = 'download_subscriber_data';
$strPageTitle = 'Download Subscriber Data';

/************************************
 * Check if page is protected...
 ************************************/
isProtectedPage();

/************************************
 * Assemble the data...
 ************************************/
$arrFields = array('id','email','name');
$arrMailerData = generateMailerSubscriberData($arrFields);

/************************************
 * Send the data to the browser...
 ************************************/
@header('Content-Type: text/csv; charset=utf-8');
@header('Content-Disposition: attachment; filename=bmso_mailer_subscriber_data.csv');
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