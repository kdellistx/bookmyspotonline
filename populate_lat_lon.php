<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 16-APR-2018
 * ---------------------------------------------------
 * Populate LAT / LON Script (populate_lat_lon.php)
 *****************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');
die('Script disabled...');

/************************************
 * Initialize data arrays...
 ************************************/
//130+Oldham+St,+Wimberley,+TX+78676,+USA
//http://maps.google.com/maps/api/geocode/json?address=130+Oldham+St,+Wimberley,+TX+78676,+USA&sensor=false
//$strGeocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$strAddress.'&sensor=false');

/************************************
 * Fix the zipcodes...
 ************************************/
/*
$arrProperties = generatePropertes(1000);
foreach ($arrProperties as $properties)
{
    $strData = '';
    $property = toObject($properties);
    if ($property->property_zipcode != '')
    {
        $intID = $property->id;
        $strZip = str_replace('.0', '', $property->property_zipcode);
        $sql = "UPDATE `".PROPERTY_TABLE."` SET `property_zipcode`='{$strZip}' WHERE `id`={$intID} LIMIT 1;";
        $res = $sqli->query($sql) or die($sqli->error);
        closeMeUp($res);
        echo 'Updated '. $property->property_zipcode .'/////'.$strZip.'<br />';
    }
}

breakpoint();
*/

/************************************
 * Generate property hash code...
 ************************************/
/*
$arrProperties = generatePropertes(1000);
foreach ($arrProperties as $properties)
{
    $property = toObject($properties);
    //showDebug($property, 'property data object', false);
    if ($property->property_hash == '')
    {
        $intID = $property->id;
        $strData = create_guid();
        $sql = "UPDATE `".PROPERTY_TABLE."` SET `property_hash`='{$strData}' WHERE `id`={$intID} LIMIT 1;";
        //showDebug($sql, 'query', false);
        $res = $sqli->query($sql) or die($sqli->error);
        closeMeUp($res);
        echo 'Updated '. $property->id .'/////'.$strData.'<br />';
    }
}

breakpoint();
*/


/************************************
 * Generate the XML...
 ************************************/
/*
$strXML = generateMapXMLFile();
//showDebug($strXML, 'xml data string', false);
@header("Content-type: text/xml");
echo $strXML;
die();
*/

/************************************
 * Update the LAT / LON (Google)...
 ************************************/
/*
$arrProperties = generatePropertes(25, false, true);
//showDebug($arrProperties, 'properties', true);
foreach ($arrProperties as $properties)
{
    $strData = '';
    $property = toObject($properties);
    $intID = $property->id;
    if ($property->property_address != '')
    {
        $strData .= trim($property->property_address);
    }
    
    if ($property->property_city != '')
    {
        $strData .= ' ' . trim($property->property_city);
    }
    
    if ($property->property_state != '')
    {
        $strData .= ' ' . trim($property->property_state);
    }

    if ($property->property_zipcode != '')
    {
        $strData .= ' ' . trim($property->property_zipcode);
    }

    echo '<hr />';
    echo $strData . '<br />';
    $strData = urlencode($strData);
    echo $strData .'<br />';

    //$strAddress = '130+Oldham+Ln,Wimberley,TX,78676';
    sleep(5);
    $arrLatLon = getLatitudeLongitude($strData);
    showDebug($arrLatLon, 'lat / lon data array', false);

    $strLat = $arrLatLon['latitude'];
    $strLon = $arrLatLon['longitude'];
    $sql = "UPDATE `".PROPERTY_TABLE."` SET `property_latitude`='{$strLat}' WHERE `id`={$intID} LIMIT 1;";
    $res = $sqli->query($sql) or die($sqli->error);
    $sql = "UPDATE `".PROPERTY_TABLE."` SET `property_longitude`='{$strLon}' WHERE `id`={$intID} LIMIT 1;";
    $res = $sqli->query($sql) or die($sqli->error);
    closeMeUp($res);
}
*/
//breakpoint();
//$strAddress = '130+Oldham+Ln,Wimberley,TX,78676';
//$arrLatLon = getLatitudeLongitude($strAddress);
//showDebug($arrLatLon, 'lat / lon data array', false);

/************************************
 * Update PROP LAT / LON (Yahoo)...
 ************************************/
/*
$arrProperties = generatePropertes(75, false, true, false);
//showDebug($arrProperties, 'properties', false);
foreach ($arrProperties as $properties)
{
    $strData = '';
    $property = arrayToObject($properties);
    $intID = $property->id;
    //showDebug($property, 'propert data object', true);
    if ($property->property_address != '')
    {
        $strData .= trim($property->property_address);
    }
    
    if ($property->property_city != '')
    {
        $strData .= ' ' . trim($property->property_city);
    }
    
    if ($property->property_state != '')
    {
        $strData .= ' ' . trim($property->property_state);
    }

    if ($property->property_zipcode != '')
    {
        $strData .= ' ' . trim($property->property_zipcode);
    }

    echo '<hr />';
    echo $strData . '<br />';
    $strData = urlencode($strData);
    echo $strData .'<br />';
    sleep(1);
    $arrLatLon = geocodeMapQuest($strData);
    //showDebug($arrLatLon, 'lat / lon data array', false);
    $objLatLonData = $arrLatLon->results[0]->locations[0]->displayLatLng;
    showDebug($objLatLonData, 'lat / lon results data array', false);

    $strLat = $objLatLonData->lat;
    $strLon = $objLatLonData->lng;
    $sql = "UPDATE `".PROPERTY_TABLE."` SET `property_latitude`='{$strLat}' WHERE `id`={$intID} LIMIT 1;";
    $res = $sqli->query($sql) or die($sqli->error);
    $sql = "UPDATE `".PROPERTY_TABLE."` SET `property_longitude`='{$strLon}' WHERE `id`={$intID} LIMIT 1;";
    $res = $sqli->query($sql) or die($sqli->error);
    closeMeUp($res);
}
*/

/************************************
 * Update MARKET LAT / LON (MAPQU)...
 ************************************/
/*
$arrProperties = generateMarketplaceItems(75, false, true, false);
//showDebug($arrProperties, 'marketplace items', true);
foreach ($arrProperties as $properties)
{
    $strData = '';
    $property = arrayToObject($properties);
    $intID = $property->id;
    //showDebug($property, 'propert data object', true);
    if ($property->property_address != '')
    {
        $strData .= trim($property->property_address);
    }
    
    if ($property->property_city != '')
    {
        $strData .= ' ' . trim($property->property_city);
    }
    
    if ($property->property_state != '')
    {
        $strData .= ' ' . trim($property->property_state);
    }

    if ($property->property_zipcode != '')
    {
        $strData .= ' ' . trim($property->property_zipcode);
    }

    echo '<hr />';
    echo $strData . '<br />';
    $strData = urlencode($strData);
    echo $strData .'<br />';
    sleep(1);
    $arrLatLon = geocodeMapQuest($strData);
    //showDebug($arrLatLon, 'lat / lon data array', false);
    $objLatLonData = $arrLatLon->results[0]->locations[0]->displayLatLng;
    showDebug($objLatLonData, 'lat / lon results data array', false);

    $strLat = $objLatLonData->lat;
    $strLon = $objLatLonData->lng;
    $sql = "UPDATE `".MARKETPLACE_TABLE."` SET `property_latitude`='{$strLat}' WHERE `id`={$intID} LIMIT 1;";
    $res = $sqli->query($sql) or die($sqli->error);
    $sql = "UPDATE `".MARKETPLACE_TABLE."` SET `property_longitude`='{$strLon}' WHERE `id`={$intID} LIMIT 1;";
    $res = $sqli->query($sql) or die($sqli->error);
    closeMeUp($res);
}
*/

/************************************
 * Populate property zipcodes...
 ************************************/
//$arrProperties = generatePropertes(100, true, true, false); // false, true, false
/*
$sql = "SELECT `id`,`property_city`,`property_state` FROM `".PROPERTY_TABLE."` WHERE `property_zipcode` IS NULL LIMIT 500;";
$res = $sqli->query($sql) or die($sqli->error);
while ($row = $res->fetch_assoc())
{
    showDebug($row, 'property items - blank zipcodes', false);
    $intID = $row['id'];
    $strCity = trim($row['property_city']);
    $strState = trim($row['property_state']);
    $sql2 = "SELECT `zipcode` FROM `".ZIPCODE_TABLE."` WHERE `city`='{$strCity}' AND `state`='{$strState}' LIMIT 1;";
    $res2 = $sqli->query($sql2) or die($sqli->error);
    $row2 = $res2->fetch_assoc();
    $strNewZipcode = $row2['zipcode'];
    $sql3 = "UPDATE `".PROPERTY_TABLE."` SET `property_zipcode`='{$strNewZipcode}' WHERE `id`={$intID} LIMIT 1;";
    $res3 = $sqli->query($sql3) or die($sqli->error);
    closeMeUp($res);
    closeMeUp($res2);
    closeMeUp($res3);
}
breakpoint();

/************************************
 * Update Property LAT / LON (GEO)...
 ************************************/
$arrProperties = generatePropertes(500, true, true, false); // false, true, false
//showDebug($arrProperties, 'property items', true);
foreach ($arrProperties as $properties)
{
    $strData = '';
    $property = toObject($properties);
    $intID = $property->id;
    $strCity = trim($property->property_city);
    $strState = trim($property->property_state);
    $strZipcode = trim($property->property_zipcode);
    //$sql = "SELECT `latitude`,`longitude` FROM `".GEO_DATA_TABLE."` WHERE `city`='{$strCity}' AND `state`='{$strState}' AND `zipcode` LIKE '%{$strZipcode}&' LIMIT 1;";
    $sql = "SELECT `latitude`,`longitude` FROM `".GEO_DATA_TABLE."` WHERE `city`='{$strCity}' AND `state`='{$strState}' LIMIT 1;";
    $res = $sqli->query($sql) or die($sqli->error);
    $row = $res->fetch_assoc();
    //showDebug($row, 'lat lon data row', true);
    $strLat = $row['latitude'];
    $strLon = $row['longitude'];
    $sql = "UPDATE `".PROPERTY_TABLE."` SET `property_latitude`='{$strLat}', `property_longitude`='{$strLon}' WHERE `id`={$intID} LIMIT 1;";
    $res = $sqli->query($sql) or die($sqli->error);
    closeMeUp($res);
}

/************************************
 * Kill the script...
 ************************************/
breakpoint();
?>