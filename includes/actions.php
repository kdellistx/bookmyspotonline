<?php
/*****************************************************
* Created by: Randy S. Baker
* Created on: 03-APR-2018
* ----------------------------------------------------
* Core Actions (actions.php)
******************************************************/

/************************************
 * Enable / disable debugging mode...
 ************************************/
$isDebug = false;

/************************************
 * Get the arguments passed in...
 ************************************/
$intJokeID = ((isset($_REQUEST['joke_id']) && $_REQUEST['joke_id'] != '')?($_REQUEST['joke_id']):('0'));
$intEventID = ((isset($_REQUEST['event_id']) && $_REQUEST['event_id'] != '')?($_REQUEST['event_id']):('0'));
$strModifier = ((isset($_REQUEST['modifier']) && $_REQUEST['modifier'] != '')?($_REQUEST['modifier']):('news'));
$intBookingID = ((isset($_REQUEST['booking_id']) && $_REQUEST['booking_id'] != '')?($_REQUEST['booking_id']):('0'));
$intPropertyID = ((isset($_REQUEST['property_id']) && $_REQUEST['property_id'] != '')?($_REQUEST['property_id']):('0'));
$strPropertyHash = ((isset($_REQUEST['property_hash']) && $_REQUEST['property_hash'] != '')?($_REQUEST['property_hash']):(''));
$strPropertyCity = ((isset($_REQUEST['property_city']) && $_REQUEST['property_city'] != '')?($_REQUEST['property_city']):(''));
$strPropertyState = ((isset($_REQUEST['property_state']) && $_REQUEST['property_state'] != '')?($_REQUEST['property_state']):(''));
$strPropertyNameID = ((isset($_REQUEST['property_name_id']) && $_REQUEST['property_name_id'] != '')?($_REQUEST['property_name_id']):('0'));
$intSubscriptionID = ((isset($_REQUEST['subscription_id']) && $_REQUEST['subscription_id'] != '')?($_REQUEST['subscription_id']):('0'));
$intAdvertisementID = ((isset($_REQUEST['advertisement_id']) && $_REQUEST['advertisement_id'] != '')?($_REQUEST['advertisement_id']):('0'));
$strPropertyZipcode = ((isset($_REQUEST['property_zipcode']) && $_REQUEST['property_zipcode'] != '')?($_REQUEST['property_zipcode']):(''));
$strPropertyCategory = ((isset($_REQUEST['property_category']) && $_REQUEST['property_category'] != '')?($_REQUEST['property_category']):(''));
$intMarketplaceItemID = ((isset($_REQUEST['marketplace_item_id']) && $_REQUEST['marketplace_item_id'] != '')?($_REQUEST['marketplace_item_id']):('0'));
$strMarketplaceCategory = ((isset($_REQUEST['marketplace_category']) && $_REQUEST['marketplace_category'] != '')?($_REQUEST['marketplace_category']):(''));

/************************************
 * Clean up the arguments...
 ************************************/
$strModifierClean = str_replace('', '', $strModifier);

/*************************************
 * Generate the data arrays...
 *************************************/
$strXMLSearch = '';
$strPropertyIDSearch = '';
$arrStates = buildStates();
$arrAccountTypes = generateAccountTypes(true);
$arrPropertyCategories = generatePropertyCategories();
$arrPropertyCategoryTypes = generatePropertyCategoryTypes();
$arrMarketplaceCategories = generateMarketplaceCategories();

/************************************
 * Send an email...
 ************************************/
if (isset($_POST['action']) && $_POST['action'] == 'do_contact')
{
	$arrData = $_POST;
	unset($arrData['action']);
	unset($arrData['btnSubmit']);
	$arrData['from_email'] = FROM_EMAIL;
	$arrData['from_name'] = FROM_NAME;
	$arrData['email_to'] = TO_EMAIL;
	$arrData['subject'] = 'New message from your website: '. $arrData['ddlSubject'];
	$arrData['txtDate'] = date('r');
	$arrContact = array(
		'txtName' => 'Name',
		'txtPhone' => 'Phone Number',
		'txtEmail' => 'Email Address',
		'ddlSubject' => 'Reason for Email',
		'ddlContact' => 'Contact Method',
		'txtMessage' => 'Comments',
		'txtDate' => 'Date'
	);
	$body  = "<html><body>\n"; 
	$body .= "<p style='font-family:Arial, Helvetica, sans-serif; font-size:12px;'>Hey Team,<br />Someone just sent you an email from your website. Here are the details:</p>\n";
	$body .= "<p style='font-family:Arial, Helvetica, sans-serif; font-size:12px;'>\n";
	$body .= "<table style='width:700px; border:2px solid #000000;'>\n";
	$body .= "<tr><td colspan='2' style='background-color:#AAAAAA; color:#FFFFFF; font-weight:bold; textalign:center; padding-right:5px;'>ONLINE CONTACT FORM MESSAGE DETAILS</td></tr>\n";
	foreach ($arrContact as $key => $val)
	{
		$body .= "<tr><td style='font-weight:bold; text-align:right; padding-right:5px; vertical-align:top; width:125px;'>{$val}:</td><td style='padding-left:5px; text-align:left;'>".$arrData[$key]."</td></tr>";
	}
	$body .= "</p>\n";
	$body .= "</body><html>\n";
	$arrData['body'] = $body;
	sendShortMessage($arrData);
	showAlert('Your message has been sent!');
}

/************************************
 * Recover a password...
 ************************************/
if ($_POST['action'] == 'do_recover_password')
{
	unset($_POST['action']);
	unset($_POST['btnSubmit']);
	$arrData = array();
	$arrData = $_POST;
	if ($arrData['email'] != '')
	{
		$tmpPWD = getUserPassword($arrData['email']);
		if (count($tmpPWD) > 0)
		{
			$arrData['from_email'] = FROM_EMAIL;
			$arrData['from_name'] = FROM_NAME;
			$arrData['email_to'] = $arrData['email'];
			$arrData['subject'] = 'Password Recovery Notice';
			$body  = "<html><body>"; 
			$body .= "<p style='font-family:Arial, Helvetica, sans-serif; font-size:12px;'>You asked to have your password sent to you. Here it is:</p>";
			$body .= "<p style='font-family:Arial, Helvetica, sans-serif; font-size:12px;'><br />";
			$body .= "<b>Password: </b>". $tmpPWD['password'] ."<br />";
			$body .= "</p>";
			$body .= "</body><html>";
			$arrData['body'] = $body;
			sendShortMessage($arrData);
			showAlert('Your password has been sent! Please check your email.');
			doRedirect(BASE_URL_RSB.'login/');
		} else {
			showAlert('The email address you entered was not found in our system.');
			doRedirect(BASE_URL_RSB.'forgot-password/');
		}
	} else {
		showAlert('You must enter a valid email address.');
		doRedirect(BASE_URL_RSB.'forgot-password/');
	}
}

/************************************
 * Send an email to seller...
 ************************************/
if (isset($_POST['action']) && $_POST['action'] == 'contact_seller')
{
	$arrData = $_POST;
	unset($arrData['action']);
	unset($arrData['btnSubmit']);
	$tmpEmail = trim($arrData['owner_email']);
	if ($tmpEmail != '')
	{
		if (isValidEmail($tmpEmail))
		{
			$arrData['from_email'] = FROM_EMAIL;
			$arrData['from_name'] = FROM_NAME;
			$arrData['email_to'] = $tmpEmail;
			$arrData['subject'] = 'New message about your '. $arrData['email_subject'];
			$arrData['txtDate'] = date('r');
			$arrContact = array(
				'txtDate' => 'Date',
				'full_name' => 'Name',
				'email_address' => 'Email Address',
				'email_subject' => 'Reason for Email',
				'comments' => 'Comments',
			);
			$body  = "<html><body>\n"; 
			$body .= "<p style='font-family:Arial, Helvetica, sans-serif; font-size:12px;'>Hey Team,<br />Someone just sent you an email from BookMySpotOnline.com. Here are the details:</p>\n";
			$body .= "<p style='font-family:Arial, Helvetica, sans-serif; font-size:12px;'>\n";
			$body .= "<table style='width:700px; border:2px solid #000000;'>\n";
			$body .= "<tr><td colspan='2' style='background-color:#AAAAAA; color:#FFFFFF; font-weight:bold; textalign:center; padding-right:5px;'>ONLINE CONTACT FORM MESSAGE DETAILS</td></tr>\n";
			foreach ($arrContact as $key => $val)
			{
				$body .= "<tr><td style='font-weight:bold; text-align:right; padding-right:5px; vertical-align:top; width:175px;'>{$val}:</td><td style='padding-left:5px; text-align:left;'>".$arrData[$key]."</td></tr>";
			}
			$body .= "</p>\n";
			$body .= "</body><html>\n";
			$arrData['body'] = $body;
			sendShortMessage($arrData);
			showAlert('Your message has been sent!');
		}
	}
}

/************************************
 * Authenticate a user...
 ************************************/
if ($_POST['action'] == 'do_login')
{
	$arrAuthData = array();
	$arrAuthData['email'] = $sqli->real_escape_string($_POST['email']);
	$arrAuthData['pass'] = $sqli->real_escape_string($_POST['password']);
	userAuthenticate($arrAuthData);
	if ($_SESSION['sys_user']['is_auth'] != 1)
	{
		showAlert('Authentication error!');
		doRedirect(BASE_URL_RSB.'login/');
	} else {
		$cookieData = json_encode($arrAuthData);
		setcookie('auth_data', $cookieData, time() + (86400 * 30), '/');
		$arrAuthData = array();
		doRedirect(BASE_URL_RSB.'my-account/');
	}
}

/************************************
 * Register a user...
 ************************************/
if (isset($_POST['action']) && $_POST['action'] == 'do_register_user')
{
	$arrData = $_POST;
	$arrSignup = array();
	unset($arrData['action']);
	unset($arrData['chkTOS']);
	unset($arrData['btnSubmit']);
	$arrData['confirmed'] = 1;
	$arrData['account_type'] = 1;
	$tmpEmail = trim($arrData['email']);
	if (isValidEmail($tmpEmail))
	{
		if (!emailExists($tmpEmail))
		{
			addUserData($arrData);
			$arrSignup['from_email'] = FROM_EMAIL;
			$arrSignup['from_name'] = FROM_NAME;
			$arrSignup['email_to'] = TO_EMAIL;
			$arrSignup['subject'] = 'New signup from your website: '. $arrData['first_name'] .' '. $arrData['last_name'];
			$arrSignup['txtDate'] = date('r');
			$arrContact = array(
				'first_name' => 'First Name',
				'last_name' => 'Last Name',
				'address_1' => 'Address',
				'city' => 'City',
				'state' => 'State',
				'zipcode' => 'Zipcode',
				'phone' => 'Phone Number',
				'email' => 'Email Address',
				'txtDate' => 'Date'
			);
			$body  = "<html><body>\n"; 
			$body .= "<p style='font-family:Arial, Helvetica, sans-serif; font-size:12px;'>Hey Team,<br />Someone just signed up on your website. Here are the details:</p>\n";
			$body .= "<p style='font-family:Arial, Helvetica, sans-serif; font-size:12px;'>\n";
			$body .= "<table style='width:700px; border:2px solid #000000;'>\n";
			$body .= "<tr><td colspan='2' style='background-color:#AAAAAA; color:#FFFFFF; font-weight:bold; textalign:center; padding-right:5px;'>ONLINE REGISTRATION DETAILS</td></tr>\n";
			foreach ($arrContact as $key => $val)
			{
				$body .= "<tr><td style='font-weight:bold; text-align:right; padding-right:5px; vertical-align:top; width:125px;'>{$val}:</td><td style='padding-left:5px; text-align:left;'>".$arrData[$key]."</td></tr>";
			}
			$body .= "</p>\n";
			$body .= "</body><html>\n";
			$arrSignup['body'] = $body;
			sendShortMessage($arrSignup);
			// Authenticate the user...
			$arrAuthData = array();
			$arrAuthData['email'] = $arrData['email'];
			$arrAuthData['pass'] = $arrData['password'];
			userAuthenticate($arrAuthData);
			doRedirect(BASE_URL_RSB.'my-account/');
			unset($arrAuthData);
		} else {
			$_SESSION['last_user_added'] = $arrData;
			showAlert('That email already exists in our system.');
			doRedirect(BASE_URL_RSB.'register/');
		}
	} else {
		$_SESSION['last_user_added'] = $arrData;
		showAlert('You entered an invalid email address.');
		doRedirect(BASE_URL_RSB.'register/');
	}
}

/************************************
 * Perform newsletter signup...
 ************************************/
if ($_POST['action'] == 'do_newsletter_signup')
{
	$arrData = $_POST;
	unset($arrData['action']);
	unset($arrData['btnSubmit']);
	$tmpEmail = trim($arrData['email']);
	if (isValidEmail($tmpEmail))
	{
		if (!emailExists($tmpEmail, SUBSCRIBER_TABLE))
		{
			addSubscriberData($arrData);
			showAlert('Thanks for subscribing to our newsletter!');
		} else {
			showAlert('That email already exists in our system.');
		}
	} else {
		showAlert('You entered an invalid email address.');
	}
}

/************************************
 * Edit account information...
 ************************************/
if ($_POST['action'] == 'edit_account_information')
{
	$arrData = $_POST;
	unset($arrData['action']);
	unset($arrData['btnSubmit']);
	$intID = $_SESSION['sys_user']['id'];
	saveUserData($intID, $arrData);
	reloadUserData($intID);
	doRedirect(BASE_URL_RSB.'my-account/');
}

/************************************
 * Add item to the shopping cart...
 ************************************/
if ($_POST['action'] == 'add_item_to_cart')
{
	$arrData = $_POST;
	unset($arrData['action']);
	unset($arrData['btnSubmit']);
	$_SESSION['cart_data'][$arrData['product_id']] = $arrData;
}

/************************************
 * Perform home header search...
 ************************************/
if ($_REQUEST['action'] == 'home_header_search')
{
	$arrData = $_REQUEST;
	unset($arrData['action']);
	unset($arrData['btnSubmit']);
	unset($arrData['property_name_search']);
	$strXMLSearch = serialize($arrData);
}

/************************************
 * Perform home map search...
 ************************************/
if ($_REQUEST['action'] == 'home_map_search')
{
	$arrData = $_REQUEST;
	unset($arrData['action']);
	unset($arrData['btnSubmit']);
	$strXMLSearch = serialize($arrData);
}

/************************************
 * Perform marketplace map search...
 ************************************/
if ($_REQUEST['action'] == 'marketplace_map_search')
{
	$arrData = $_REQUEST;
	unset($arrData['action']);
	unset($arrData['btnSubmit']);
	$strXMLSearch = serialize($arrData);
}


/************************************
 * Perform destination search...
 ************************************/
if ($_POST['action'] == 'select_destination_category')
{
	$arrData = $_POST;
	unset($arrData['action']);
	unset($arrData['btnSubmit']);
}

/************************************
 * Perform marketplace search...
 ************************************/
if ($_POST['action'] == 'select_marketplace_category')
{
	$arrData = $_POST;
	unset($arrData['action']);
	unset($arrData['btnSubmit']);
}

/************************************
 * Reservation search (home)...
 ************************************/
if ($_POST['action'] == 'home_rv_park_search')
{
	$arrData = $_POST;
	unset($arrData['action']);
	unset($arrData['btnSubmit']);
	$arrProperties = generateReservationProperties($arrData, 50);
	$_SESSION['booking_data'] = $arrData;
}

/************************************
 * Perform reservation search...
 ************************************/
if ($_POST['action'] == 'search_reservation_destinations')
{
	$arrData = $_POST;
	unset($arrData['action']);
	unset($arrData['btnSubmit']);
	$arrProperties = generateReservationProperties($arrData, 50);
	$_SESSION['booking_data'] = $arrData;
}

/************************************
 * Add a new property...
 ************************************/
if ($_POST['action'] == 'add_property')
{
	$arrData = $_POST;
	$arrFileData = $_FILES;
	unset($arrData['action']);
	unset($arrData['btnSubmit']);
	unset($arrData['is_claimed']);
	unset($arrData['property_id']);
	$intPropertyID = addPropertyData($arrData);
	generatePropertyHash($intPropertyID);
	geocodeFromDatabase($intPropertyID, PROPERTY_TABLE);
	processFileUploadProperty($arrData, $arrFileData, $intPropertyID);
	$property = toObject(getPropertyData($intPropertyID));
	if (loggedIn())
	{
		if (isset($arrData['is_admin']) && $arrData['is_admin'] == 1)
		{
			// Do nothing...
		} else {
			showAlert('Your location will appear after a content review.');
		}
		doRedirect(BASE_URL_RSB.'my-account/');
		//doRedirect(BASE_URL_RSB.'view-property/'.$intPropertyID.'/'.generateSEOURL($property->property_name).'/');
		//doRedirect(BASE_URL_RSB.'pricing/?property_hash='.$property->property_hash);
	} else {
		doRedirect(BASE_URL_RSB.'pricing/?property_hash='.$property->property_hash);
	}
}

/************************************
 * Save a property...
 ************************************/
if ($_POST['action'] == 'save_property')
{
	$arrData = $_POST;
	$arrFileData = $_FILES;
	$intID = $_POST['id'];
	unset($arrData['action']);
	unset($arrData['btnSubmit']);
	savePropertyData($intID, $arrData);
	processFileUploadProperty($arrData, $arrFileData, $intID);
}

/************************************
 * Delete a property...
 ************************************/
if ($_REQUEST['action'] == 'delete_property')
{
	$intID = $_REQUEST['property_id'];
	deletePropertyData($intID, false);
	doRedirect(BASE_URL_RSB.'my-account/');
}

/************************************
 * Remove a property from account...
 ************************************/
if ($_REQUEST['action'] == 'delete_property_from_account')
{
	$intID = $_REQUEST['property_id'];
	deletePropertyData($intID, true);
	doRedirect(BASE_URL_RSB.'my-account/');
}

/************************************
 * Claim a property...
 ************************************/
if ($_REQUEST['action'] == 'claim_property')
{
	$arrSignup = array();
	$intID = $_REQUEST['property_id'];
	$user = toObject($_SESSION['sys_user']);
	claimPropertyData($intID);
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
	doRedirect(BASE_URL_RSB.'my-account/');
}

/************************************
 * Add a new event...
 ************************************/
if ($_POST['action'] == 'add_event')
{
	$arrData = $_POST;
	$arrFileData = $_FILES;
	unset($arrData['action']);
	unset($arrData['files']);
	unset($arrData['btnSubmit']);
	$intEventID = addEventData($arrData);
	processFileUploadEvent($arrData, $arrFileData, $intEventID);
}

/************************************
 * Save an event...
 ************************************/
if ($_POST['action'] == 'save_event')
{
	$arrData = $_POST;
	$intID = $_POST['id'];
	unset($arrData['action']);
	unset($arrData['files']);
	saveEventData($intID, $arrData);
	processFileUploadEvent($arrData, $arrFileData, $intID);
}

/************************************
 * Delete an event...
 ************************************/
if ($_REQUEST['action'] == 'delete_event')
{
	$intID = $_REQUEST['event_id'];
	deleteEventData($intID);
}

/************************************
 * Generate a trip plan...
 ************************************/
if ($_REQUEST['action'] == 'do_trip_planner')
{
	$arrDirectionData = $_REQUEST;
	$tmpCategoryFilters = array();
	$arrCategoryFilters = array();
	$arrSelectedCategories = array();
	parse_str($_REQUEST['selected_categories'], $arrSelectedCategories);
	if (is_array($arrSelectedCategories) && !empty($arrSelectedCategories))
	{
		foreach ($arrSelectedCategories as $key => $val)
		{
			$tmpCategoryFilters[$val] = getPropertyCategoryID($val);
		}
		$arrCategoryFilters = array_flip($tmpCategoryFilters);
	}
	$_SESSION['current_trip_planner'] = $arrDirectionData;
	unset($arrDirectionData['action']);
	unset($arrDirectionData['btnSubmit']);
	unset($arrDirectionData['selected_categories']);
	$objDirectionData = json_decode(generateRemoteDirectionData($arrDirectionData));
	$arrDirectionMarkerData = processDirectionData($objDirectionData);
	$arrLegsGeoData = populateLegsGeoData($arrDirectionMarkerData['legs']);
	$arrProximityData = getProximityGEO('id', 100, $arrLegsGeoData, $arrCategoryFilters); // Was 20 miles...
	$strPropertyIDSearch = serialize($arrProximityData);
	$strXMLSearch = serialize($arrDirectionData['property_category']);
}

/************************************
 * Add a new marketplace item...
 ************************************/
if ($_POST['action'] == 'add_marketplace_item')
{
	$arrData = $_POST;
	$arrFileData = $_FILES;
	unset($arrData['action']);
	unset($arrData['btnSubmit']);
	$intMarketplaceID = addMarketplaceData($arrData);
	generateMarketplaceHash($intMarketplaceID);
	geocodeFromDatabase($intMarketplaceID, MARKETPLACE_TABLE);
	processFileUploadMarketplace($arrData, $arrFileData, $intMarketplaceID);
	doRedirect(BASE_URL_RSB.'my-account/');
}

/************************************
 * Save a marketplace item...
 ************************************/
if ($_POST['action'] == 'save_marketplace_item')
{
	$arrData = $_POST;
	$arrFileData = $_FILES;
	$intID = $_POST['id'];
	saveMarketplaceData($intID, $arrData);
	processFileUploadMarketplace($arrData, $arrFileData, $intID);
}

/************************************
 * Delete a marketplace item...
 ************************************/
if ($_REQUEST['action'] == 'delete_marketplace_item')
{
	$intID = $_REQUEST['marketplace_item_id'];
	deleteMarketplaceData($intID, false);
	doRedirect(BASE_URL_RSB.'my-account/');
}

/************************************
 * Remove an item from account...
 ************************************/
if ($_REQUEST['action'] == 'delete_marketplace_item_from_account')
{
	$intID = $_REQUEST['marketplace_item_id'];
	deleteMarketplaceData($intID, false);
	doRedirect(BASE_URL_RSB.'my-account/');
}

/************************************
 * Add a new review...
 ************************************/
if ($_POST['action'] == 'add_review')
{
	$arrData = $_POST;
	unset($arrData['action']);
	unset($arrData['btnSubmitReview']);
	$intReviewID = addReviewData($arrData);
}

/************************************
 * Save a review...
 ************************************/
if ($_POST['action'] == 'save_review')
{
	$arrData = $_POST;
	$intID = $_POST['id'];
	unset($arrData['action']);
	unset($arrData['btnSubmit']);
	saveReviewData($intID, $arrData);
}

/************************************
 * Delete a review...
 ************************************/
if ($_REQUEST['action'] == 'delete_review')
{
	$intID = $_REQUEST['review_id'];
	deleteReviewData($intID);
}

/************************************
 * Add new advertisement (wizard)...
 ************************************/
if ($_POST['action'] == 'add_advertisement_wizard')
{
	$arrData = $_POST;
	$arrFileData = $_FILES;
	unset($arrData['action']);
	unset($arrData['btnSubmit']);
	//showDebug($arrData, 'form data array', true);
	$intAdvertisementID = addAdvertisementData($arrData);
	processFileUploadAdvertisement($arrData, $arrFileData, $intAdvertisementID);
	doRedirect(BASE_URL_RSB.'my-account/');
}

/************************************
 * Add a new advertisement item...
 ************************************/
if ($_POST['action'] == 'add_advertisement')
{
	$arrData = $_POST;
	$arrFileData = $_FILES;
	unset($arrData['action']);
	unset($arrData['btnSubmit']);
	$intAdvertisementID = addAdvertisementData($arrData);
	processFileUploadAdvertisement($arrData, $arrFileData, $intAdvertisementID);
	doRedirect(BASE_URL_RSB.'manage-advertisements/');
}

/************************************
 * Save an advertisement item...
 ************************************/
if ($_POST['action'] == 'save_advertisement')
{
	$arrData = $_POST;
	$arrFileData = $_FILES;
	unset($arrData['action']);
	unset($arrData['btnSubmit']);
	$intID = $_POST['id'];
	saveAdvertisementData($intID, $arrData);
	processFileUploadAdvertisement($arrData, $arrFileData, $intID);
}

/************************************
 * Delete an advertisement item...
 ************************************/
if ($_REQUEST['action'] == 'delete_advertisement')
{
	$intID = $_REQUEST['advertisement_id'];
	deleteAdvertisementData($intID, false);
	doRedirect(BASE_URL_RSB.'manage-advertisements/');
}

/************************************
 * Add a new joke item...
 ************************************/
if ($_POST['action'] == 'add_joke')
{
	$arrData = $_POST;
	$arrFileData = $_FILES;
	unset($arrData['action']);
	unset($arrData['btnSubmit']);
	$intJokeID = addJokeData($arrData);
	processFileUploadJoke($arrData, $arrFileData, $intJokeID);
	doRedirect(BASE_URL_RSB.'manage-jokes-and-trivia/');
}

/************************************
 * Save a joke item...
 ************************************/
if ($_POST['action'] == 'save_joke')
{
	$arrData = $_POST;
	$arrFileData = $_FILES;
	unset($arrData['action']);
	unset($arrData['btnSubmit']);
	$intID = $_POST['id'];
	saveJokeData($intID, $arrData);
	processFileUploadJoke($arrData, $arrFileData, $intID);
}

/************************************
 * Delete a joke item...
 ************************************/
if ($_REQUEST['action'] == 'delete_joke')
{
	$intID = $_REQUEST['joke_id'];
	deleteJokeData($intID, false);
	doRedirect(BASE_URL_RSB.'manage-jokes-and-trivia/');
}

/************************************
 * Send a page...
 ************************************/
if ($_POST['action'] == 'do_send_page')
{
	$arrData = $_POST;
	$arrPage = array();
	unset($arrData['action']);
	unset($arrData['btnSendPage']);
	$arrPage['from_email'] = (($arrData['from_email'] != '')?($arrData['from_email']):(FROM_EMAIL));
	$arrPage['from_name'] = (($arrData['full_name'] != '')?($arrData['full_name']):(FROM_NAME));
	$arrPage['email_to'] = ($arrData['to_email']);
	$arrPage['subject'] = 'Someone just sent you a page suggesstion from BOOKMYSPOTONLINE.COM';
	$arrPage['txtDate'] = date('r');
	$arrFormData = array(
		'page_url' => 'Page URL',
		'full_name' => 'Name',
		'from_email' => 'Email',
		'to_email' => 'Sent To',
		'comments' => 'Comments',
		'txtDate' => 'Date'
	);
	$body  = "<html><body>\n"; 
	$body .= "<p style='font-family:Arial, Helvetica, sans-serif; font-size:12px;'>Hey,<br />Someone just sent you a page suggestion from the BOOKMYSPOTONLINE.COM. Here are the details:</p>\n";
	$body .= "<p style='font-family:Arial, Helvetica, sans-serif; font-size:12px;'>\n";
	$body .= "<table style='width:700px; border:2px solid #000000;'>\n";
	$body .= "<tr><td colspan='2' style='background-color:#AAAAAA; color:#FFFFFF; font-weight:bold; textalign:center; padding-right:5px;'>MESSAGE DETAILS</td></tr>\n";
	foreach ($arrFormData as $key => $val)
	{
		$body .= "<tr><td style='font-weight:bold; text-align:right; padding-right:5px; vertical-align:top; width:125px;'>{$val}:</td><td style='padding-left:5px; text-align:left;'>".$arrData[$key]."</td></tr>";
	}
	$body .= "</p>\n";
	$body .= "</body><html>\n";
	$arrPage['body'] = $body;
	sendShortMessage($arrPage);
	showAlert('Message sent!');
}

/************************************
 * Approve a property...
 ************************************/
if ($_REQUEST['action'] == 'approve_property')
{
	$intID = $_REQUEST['id'];
	approvePropertyData($intID);
	showAlert('Property has been approved!');
	doRedirect(BASE_URL_RSB.'master/');
}

/************************************
 * Add a new reservation...
 ************************************/
if ($_POST['action'] == 'add_booking')
{
	$arrData = $_POST;
	$strRedirectURL = $_POST['redirect_url'];
	$arrBookOwner = array();
	$arrBookClient = array();	
	unset($arrData['action']);
	unset($arrData['btnSubmitBooking']);
	unset($arrData['redirect_url']);
	$tmpBooking = explode(' - ', $arrData['dates_booking']);
	$arrData['booking_start'] = $tmpBooking[0];
	$arrData['booking_end'] = $tmpBooking[1];
	$intPropertyID = $arrData['property_id'];
	$intBookingID = addBookingData($arrData);

	// Get the property data...
	$property = toObject(getPropertyData($intPropertyID));

	// Get the owner data...
	$owner = toObject(getUserData($property->user_id));

	// Send email to property owner...
	$arrBookOwner['from_email'] = (($arrData['email_booking'] != '')?($arrData['email_booking']):(FROM_EMAIL));
	$arrBookOwner['from_name'] = (($arrData['name_booking'] != '')?($arrData['name_booking']):(FROM_NAME));
	$arrBookOwner['email_to'] = $owner->email;
	$arrBookOwner['subject'] = 'New Booking Request From BOOKMYSPOTONLINE.COM';
	$arrData['txtDate'] = date('r');
	$arrFormDataOwner = array(
		'property_id' => 'Property',
		'dates_booking' => 'Dates',
		'name_booking' => 'Name',
		'email_booking' => 'Email',
		'adults' => 'Adults',
		'children' => 'Children',
		'notes' => 'Comments',
		'txtDate' => 'Date'
	);
	$body  = "<html><body>\n"; 
	$body .= "<p style='font-family:Arial, Helvetica, sans-serif; font-size:12px;'>Hey,<br />Someone just made a booking request for your property on BOOKMYSPOTONLINE.COM. Here are the details:</p>\n";
	$body .= "<p style='font-family:Arial, Helvetica, sans-serif; font-size:12px;'>\n";
	$body .= "<table style='width:700px; border:2px solid #000000;'>\n";
	$body .= "<tr><td colspan='2' style='background-color:#AAAAAA; color:#FFFFFF; font-weight:bold; textalign:center; padding-right:5px;'>BOOKING REQUEST DETAILS</td></tr>\n";
	foreach ($arrFormDataOwner as $key => $val)
	{
		if ($key == 'property_id')
		{
			$body .= "<tr><td style='font-weight:bold; text-align:right; padding-right:5px; vertical-align:top; width:125px;'>{$val}:</td><td style='padding-left:5px; text-align:left;'>".$property->property_name. ', '.'  '.$property->property_city.', '.$property->property_state.'  '.$property->property_zipcode."</td></tr>";
		} else {
			$body .= "<tr><td style='font-weight:bold; text-align:right; padding-right:5px; vertical-align:top; width:125px;'>{$val}:</td><td style='padding-left:5px; text-align:left;'>".$arrData[$key]."</td></tr>";
		}
	}
	$body .= "<tr><td style='font-weight:bold; text-align:right; padding-right:5px; vertical-align:top; width:125px;'>ACTIONS:</td><td style='padding-left:5px; text-align:left;'><a href=\"". BASE_URL_RSB ."confirm-booking/". $intBookingID ."/". generateSEOURL($property->property_name) ."/\" target=\"_blank\" style=\"color:#FF0000;\"><strong>Click To Confirm This Booking</strong></a></td></tr>";
	$body .= "</p>\n";
	$body .= "</body><html>\n";
	$arrBookOwner['body'] = $body;
	sendShortMessage($arrBookOwner);

	// Send email to person who requested the booking...
	$arrBookClient['from_email'] = $owner->email;
	$arrBookClient['from_name'] = $owner->first_name .' '. $owner->last_name;
	$arrBookClient['email_to'] = $arrData['email_booking'];
	$arrBookClient['subject'] = 'Your Booking Request From BOOKMYSPOTONLINE.COM';
	$arrData['txtDate'] = date('r');
	$arrFormDataClient = array(
		'property_id' => 'Property',
		'dates_booking' => 'Dates',
		'name_booking' => 'Name',
		'email_booking' => 'Email',
		'adults' => 'Adults',
		'children' => 'Children',
		'notes' => 'Comments',
		'txtDate' => 'Date'
	);
	$body  = "<html><body>\n"; 
	$body .= "<p style='font-family:Arial, Helvetica, sans-serif; font-size:12px;'>Hey,<br />Here is the booking request you made at BOOKMYSPOTONLINE.COM. Below are the details:</p>\n";
	$body .= "<p style='font-family:Arial, Helvetica, sans-serif; font-size:12px;'>\n";
	$body .= "<table style='width:700px; border:2px solid #000000;'>\n";
	$body .= "<tr><td colspan='2' style='background-color:#AAAAAA; color:#FFFFFF; font-weight:bold; textalign:center; padding-right:5px;'>BOOKING REQUEST DETAILS</td></tr>\n";
	foreach ($arrFormDataClient as $key => $val)
	{
		if ($key == 'property_id')
		{
			$body .= "<tr><td style='font-weight:bold; text-align:right; padding-right:5px; vertical-align:top; width:125px;'>{$val}:</td><td style='padding-left:5px; text-align:left;'>".$property->property_name. ', '.'  '.$property->property_city.', '.$property->property_state.'  '.$property->property_zipcode."</td></tr>";
		} else {
			$body .= "<tr><td style='font-weight:bold; text-align:right; padding-right:5px; vertical-align:top; width:125px;'>{$val}:</td><td style='padding-left:5px; text-align:left;'>".$arrData[$key]."</td></tr>";
		}
	}
	$body .= "</p>\n";
	$body .= "</body><html>\n";
	$arrBookClient['body'] = $body;
	sendShortMessage($arrBookClient);
	showAlert('Your booking request has been submitted. We will contact you shortly.');
	doRedirect($strRedirectURL);
}

/************************************
 * Display debugging information...
 ************************************/
if ($isDebug === true)
{
	if (count($_SESSION) > 0)
	{
		echo 'SESSION:';
		showDebug($_SESSION);
	}
	
	if (count($_REQUEST) > 0)
	{
		echo 'REQUEST:';
		showDebug($_REQUEST);
	}
	
	if (count($_SERVER) > 0)
	{
		echo 'SERVER:';
		showDebug($_SERVER);
	}
	
	if (count($_POST) > 0)
	{
		echo 'POST:';
		showDebug($_POST);
	}
	
	if (count($_FILES) > 0)
	{
		echo 'FILES:';
		showDebug($_FILES);
	}
	breakpoint();
}
?>