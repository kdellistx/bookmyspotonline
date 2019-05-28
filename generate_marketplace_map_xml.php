<?php
/************************************************************************
 * Created by: Randy S. Baker
 * Created on: 05-JUN-2018
 * ----------------------------------------------------------------------
 * Generate Marketplace MAP XML Script (generate_marketplace_map_xml.php)
 ************************************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Parse incoming parameters...
 ************************************/
$arrSearchData = unserialize($_REQUEST['lookup']);
$arrPropertyIDSearchData = unserialize($_REQUEST['property_id_search']);

/************************************
 * Generate the XML...
 ************************************/
$strXML = generateMapXMLFileMarketPlace(500, $arrSearchData, $arrPropertyIDSearchData);
@header("Content-type: text/xml");
echo $strXML;

/************************************
 * Kill the script...
 ************************************/
die();
?>