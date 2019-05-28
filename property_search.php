<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 26-JUL-2018
 * ---------------------------------------------------
 * Property Search Script (property_search.php)
 *****************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Parse incoming parameters...
 ************************************/
if (isset($_REQUEST['term']) && !empty($_REQUEST['term']))
{	$strSearch = $_REQUEST['term'];
	$arrProperties = generatePropertyNames($strSearch, 25);
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