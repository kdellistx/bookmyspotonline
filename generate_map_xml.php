<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 16-APR-2018
 * ---------------------------------------------------
 * Generate MAP XML Script (generate_map_xml.php)
 *****************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Parse incoming parameters...
 ************************************/
$arrSearchData = unserialize($_REQUEST['lookup']);
$arrPropertyIDSearchData = unserialize($_REQUEST['property_id_search']);
if (isset($_REQUEST['getLatitude']) && $_REQUEST['geoLatitude'] != '')
{
	$strLatitude = $_REQUEST['geoLatitude'];
	$strLongitude = $_REQUEST['geoLongitude'];
	$arrSearchData['start_latitude'] = $strLatitude;
	$arrSearchData['start_longitude'] = $strLongitude;
}

if (isset($_REQUEST['category_lookup']) && $_REQUEST['category_lookup'] != '')
{
	$arrSearchData['property_category'] = $_REQUEST['category_lookup'];
}

/************************************
 * Generate the XML...
 ************************************/
$strXML = generateMapXMLFile(2000, $arrSearchData, $arrPropertyIDSearchData);
@header("Content-type: text/xml");
echo $strXML;

/************************************
 * Kill the script...
 ************************************/
die();
?>