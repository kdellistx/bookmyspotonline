<?php
/***************************************************************
 * Created by: Randy S. Baker
 * Created on: 10-FEB-2019
 * -------------------------------------------------------------
 * RV Park Property Search Script (property_search_rv_park.php)
 ***************************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Parse incoming parameters...
 ************************************/
if (isset($_REQUEST['term']) && !empty($_REQUEST['term']))
{	$strSearch = $_REQUEST['term'];
	$arrProperties = generatePropertyNamesRVParks($strSearch, 25);
} else {
	$arrProperties = array();
}
@header('Content-Type: application/json');
echo json_encode($arrProperties);

/************************************
 * Kill the script...
 ************************************/
die();
?>