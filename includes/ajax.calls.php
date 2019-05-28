<?php
/******************************************************
 * Created by: Randy S. Baker
 * Created on: 03-APR-2018
 * ----------------------------------------------------
 * AJAX: Generic Calls (ajax.calls.php)
 ******************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('application.php');

/************************************
 * Perform autocomplete lookup...
 ************************************/
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'do_autocomplete_property')
{
	$strKeyword = $_REQUEST['keyword'];
	$strPropertyName = autoCompletePropertyName($strKeyword);
	echo $strPropertyName;
}

/************************************
 * Save trip data...
 ************************************/
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'do_trip_save_data')
{
	$arrData = array();
	$user = toObject($_SESSION['sys_user']);
	$arrData['trip_begin'] = $_REQUEST['trip_begin'];
	$arrData['trip_end'] = $_REQUEST['trip_end'];
	$arrData['trip_action'] = $_REQUEST['trip_action'];
	addTripToAccount($user->id, $arrData);
	echo 'Done!';
}

/************************************
 * Get property information...
 ************************************/
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'do_get_property_data')
{
	$intID = $_REQUEST['id'];
	$property = getPropertyData($intID);
	echo json_encode($property);
}

/************************************
 * Claim property (AJAX)...
 ************************************/
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'do_claim_property')
{
	$intID = $_REQUEST['property_id'];
	claimPropertyData($intID);
	$user = toObject($_SESSION['sys_user']);
	$property = getPropertyData($intID);
	$arrSignup['from_email'] = FROM_EMAIL;
	$arrSignup['from_name'] = FROM_NAME;
	$arrSignup['email_to'] = TO_EMAIL;
	$arrSignup['subject'] = 'Someone claimed a property on your website: '. $property->property_name;
	$arrSignup['txtDate'] = date('r');
	$arrContact = array(
		'first_name' => 'First Name',
		'last_name' => 'Last Name',
		'email' => 'Email Address',
		'txtDate' => 'Date'
	);
	$body  = "<html><body>\n"; 
	$body .= "<p style='font-family:Arial, Helvetica, sans-serif; font-size:12px;'>Hey Team,<br />Someone just claimed a property on your website. Here are the details:</p>\n";
	$body .= "<p style='font-family:Arial, Helvetica, sans-serif; font-size:12px;'>\n";
	$body .= "<table style='width:700px; border:2px solid #000000;'>\n";
	$body .= "<tr><td colspan='2' style='background-color:#AAAAAA; color:#FFFFFF; font-weight:bold; textalign:center; padding-right:5px;'>MESSAGE DETAILS</td></tr>\n";
	foreach ($arrContact as $key => $val)
	{
		$body .= "<tr><td style='font-weight:bold; text-align:right; padding-right:5px; vertical-align:top; width:125px;'>{$val}:</td><td style='padding-left:5px; text-align:left;'>".$user->$key."</td></tr>";
	}
	$body .= "<tr><td style='font-weight:bold; text-align:right; padding-right:5px; vertical-align:top; width:125px;'>Property:</td><td style='padding-left:5px; text-align:left;'>".$property->property_name."</td></tr>";
	$body .= "</p>\n";
	$body .= "</body><html>\n";
	$arrSignup['body'] = $body;
	sendShortMessage($arrSignup);
	echo 'Done!';
}

/*************************************
 * Generate state / province list...
 *************************************/
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'do_get_country_provinces')
{
	$intID = $_REQUEST['id'];
	$arrData = generateCountryProvinces($intID);
	echo json_encode($arrData);
}

/*************************************
 * Generate city list...
 *************************************/
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'do_get_province_cities')
{
	$strCountry = $_REQUEST['country'];
	$strRegion = $_REQUEST['region'];
	$arrData = generateProvinceCities($strCountry, $strRegion);
	echo json_encode($arrData);
}
?>