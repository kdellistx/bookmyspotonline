<?php
/*********************************************************
 * Created by: Randy S. Baker
 * Created on: 20-MAY-2018
 * -------------------------------------------------------
 * Square Store Config (store_config.php)
 *********************************************************/

/************************************
 * Initialize the config...
 ************************************/
$GLOBALS['ACCESS_TOKEN'] = SQUARE_ACCESSS_TOKEN;
$GLOBALS['STORE_NAME'] = SQUARE_STORE_NAME;
$GLOBALS['LOCATION_ID'] = SQUARE_LOCATION_ID;
$GLOBALS['API_CLIENT_SET'] = false;
if ($GLOBALS['STORE_NAME'] == null)
{
  print('[ERROR] STORE NAME NOT SET. Please set a valid store name to use Square Checkout.');
  exit;
} else if ($GLOBALS['ACCESS_TOKEN'] == null) {
  print('[ERROR] ACCESS TOKEN NOT SET. Please set a valid authorization token (Personal Access Token or OAuth Token) to use Square Checkout.');
  exit;
}

/************************************
 * Initialize the API client...
 ************************************/
function initApiClient()
{
  if ($GLOBALS['API_CLIENT_SET'])
  {
    return;
  }

  // Create and configure a new Configuration object...
  $configuration = new \SquareConnect\Configuration();
  \SquareConnect\Configuration::getDefaultConfiguration()->setAccessToken($GLOBALS['ACCESS_TOKEN']);

  // Create a LocationsApi client to load the location ID..
  $locationsApi = new \SquareConnect\Api\LocationsApi();

  // Grab the location key for the configured store...
  try {
    $apiResponse = $locationsApi->listLocations()->getLocations();
    // There may be more than one location associated with the account, so we need to run through the response and pull the right location ID...
    //foreach ($apiResponse['locations'] as $location) BY: RSB 20-MAY-2018
    foreach ($apiResponse as $location)
    {
      if ($GLOBALS['STORE_NAME'] == $location->getName())
      {
        $GLOBALS['LOCATION_ID'] = $location['id'];
        if (!in_array('CREDIT_CARD_PROCESSING', $location->getCapabilities()))
        {
          print('[ERROR] LOCATION '. $GLOBALS['STORE_NAME'] .' cannot processs payments');
          exit();
        }
      }
    }

    if ($GLOBALS['LOCATION_ID'] == null)
    {
      print('[ERROR] LOCATION ID NOT SET. A location ID for '. $GLOBALS['STORE_NAME'] .' could not be found');
      exit;
    }

    $GLOBALS['API_CLIENT_SET'] = true;
  } catch (Exception $e) {
    // Display the exception details, clear out the client since it couldn't be properly initialized, and exit...
    echo "The SquareConnect\Configuration object threw an exception while calling LocationApi->listLocations: ", $e->getMessage(), PHP_EOL;
    $GLOBALS['API_CLIENT'] = null;
    exit;
  }
}
?>