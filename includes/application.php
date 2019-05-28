<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 03-APR-2018
 * ---------------------------------------------------
 * Application Setup (application.php)
 *****************************************************/

/************************************
 * Setup the environment...
 ************************************/
@ini_set('memory_limit', '1024M');
@set_time_limit(172800);
@date_default_timezone_set('America/Chicago');
@error_reporting(E_ERROR | E_WARNING | E_PARSE);
@header('Access-Control-Allow-Origin: *');

/************************************
 * Session management...
 ************************************/
if (!isset($_SESSION))
{
	@session_start();
}

/************************************
 * Initialize the environment...
 ************************************/
define ('ACCOUNT_TYPE_TABLE', 'system_account_types');
define ('ADVERTISEMENT_TABLE', 'site_advertisements');
define ('BOOKING_TABLE', 'site_property_bookings');
define ('CATEGORY_TABLE', 'site_content_categories');
define ('CONTENT_TABLE', 'site_content');
define ('COUNTRY_TABLE', 'system_countries');
define ('COUNTRY_REGION_TABLE', 'system_country_region_codes');
define ('EVENT_TABLE', 'site_events');
define ('FAQ_TABLE', 'site_faqs');
define ('GEO_DATA_TABLE', 'geo_city_data');
define ('GLOBAL_CITIES_TABLE', 'system_global_cities');
define ('GOOGLE_API_KEY', 'AIzaSyA0fQ6VzELgy41vezWjigudS4upY1WgOe0');
define ('GOOGLE_DIRECTION_API', 'https://maps.googleapis.com/maps/api/directions/json?');
define ('JOKE_TABLE', 'site_jokes');
define ('MARKETPLACE_CATEGORY_TABLE', 'site_marketplace_categories');
define ('MARKETPLACE_TABLE', 'site_marketplace');
define ('NEWS_TABLE', 'site_news');
define ('PROPERTY_TABLE', 'site_properties');
define ('PROPERTY_CATEGORY_TABLE', 'site_property_categories');
define ('REVIEW_TABLE', 'site_reviews');
define ('SETTING_TABLE', 'site_settings');
define ('SQUARE_PAID_STATUS_TABLE', 'square_paid_status');
define ('SQUARE_TRANSACTION_TABLE', 'square_transactions');
define ('STRIPE_PAID_STATUS_TABLE', 'stripe_paid_status');
define ('STRIPE_TRANSACTION_TABLE', 'stripe_transactions');
define ('SUBSCRIBER_TABLE', 'site_subscribers');
define ('SUBSCRIPTION_PLAN_TABLE', 'site_subscription_plans');
define ('SYSTEM_TABLE', 'system_config');
define ('TESTIMONY_TABLE', 'site_testimonies');
define ('USER_TABLE', 'site_users');
define ('USER_DATA_TABLE', 'site_users_data');
define ('USER_PAYMENT_TABLE', 'site_users_payment_data');
define ('USER_REGISTRATION_TABLE', 'site_user_registrations');
define ('USER_REQUEST_INFORMATION_TABLE', 'site_user_request_information');
define ('ZIPCODE_TABLE', 'zipcodes');
define ('LF', "\n");
define ('CRLF', "\r\n");
define ('TO_NAME', 'Book My Spot Online');
define ('TO_EMAIL', 'rvspot.com@yahoo.com');
define ('FROM_NAME', 'Book My Spot Online');
define ('FROM_EMAIL', 'noreply@bookmyspotonline.com');
define ('MAPQUEST_API_KEY', 'SRMQdfxzkiPw3bd5ZFeFcRyKZyKMOrHm');
define ('SQUARE_ACCESSS_TOKEN', 'sq0atp-RQ3ueSrSNtSUd66zQJvNtA');
define ('SQUARE_LOCATION_ID', '4ZFYGGNEVFV8W');
define ('SQUARE_STORE_NAME', 'bookmyspotonline.com');
//define ('SQUARE_ACCESSS_TOKEN', 'sandbox-sq0atb-fYhif-3AnffNWhRy0YS4mA');
//define ('SQUARE_LOCATION_ID', 'CBASEIJl_rRmcbfdhUT4xhXkuZogAQ');
//define ('SQUARE_STORE_NAME', 'Coffee & Toffee SF');

/*************************************************
 * Application initialization...
 *************************************************/
if ($_SERVER['HTTP_HOST'] == 'localhost' || strpos($_SERVER['REMOTE_ADDR'], '192.168.1.') === 0)
{
	$arrConnect['db_user'] = 'root';
	$arrConnect['db_pass'] = '';
	$arrConnect['db_host'] = 'localhost';
	$arrConnect['db_name'] = 'bookmyspotonline';
	define ('BASE_URL_RSB', 'http://localhost/bookmyspotonline/');
	define ('BASE_URL_RSB_ADMIN', 'http://localhost/bookmyspotonline/admin/');
	define ('BASE_URL_RSB_WIZARD', 'http://localhost/bookmyspotonline/wizard/');
	define ('SITE_BASEPATH', 'C:/dev/wamp/www/bookmyspotonline/');
	define ('SITE_BASEPATH_ADMIN', 'C:/dev/wamp/www/bookmyspotonline/admin/');
	define ('SITE_BASEPATH_WIZARD', 'C:/dev/wamp/www/bookmyspotonline/wizard/');
	define ('FILE_UPLOAD_ROOT', 'files/');	
	define ('IMAGE_ROOT', 'img/');
	define ('IMAGE_UPLOAD_ROOT', 'uploads/');
	define ('PRODUCT_IMAGE_PATH', BASE_URL_RSB.IMAGE_UPLOAD_ROOT.'products/');
	define ('PRODUCT_IMAGE_BASE_PATH', SITE_BASEPATH.IMAGE_UPLOAD_ROOT.'products/');
	define ('EVENT_IMAGE_PATH', BASE_URL_RSB.IMAGE_UPLOAD_ROOT.'events/');
	define ('EVENT_IMAGE_BASE_PATH', SITE_BASEPATH.IMAGE_UPLOAD_ROOT.'events/');
	define ('PROPERTY_IMAGE_PATH', BASE_URL_RSB.IMAGE_UPLOAD_ROOT.'properties/');
	define ('PROPERTY_IMAGE_BASE_PATH', SITE_BASEPATH.IMAGE_UPLOAD_ROOT.'properties/');
	define ('MARKETPLACE_IMAGE_PATH', BASE_URL_RSB.IMAGE_UPLOAD_ROOT.'marketplace/');
	define ('MARKETPLACE_IMAGE_BASE_PATH', SITE_BASEPATH.IMAGE_UPLOAD_ROOT.'marketplace/');
	define ('AD_IMAGE_PATH', BASE_URL_RSB.IMAGE_UPLOAD_ROOT.'advertisements/');
	define ('AD_IMAGE_BASE_PATH', SITE_BASEPATH.IMAGE_UPLOAD_ROOT.'advertisements/');
	define ('JOKE_IMAGE_PATH', BASE_URL_RSB.IMAGE_UPLOAD_ROOT.'jokes/');
	define ('JOKE_IMAGE_BASE_PATH', SITE_BASEPATH.IMAGE_UPLOAD_ROOT.'jokes/');
} else {
	$arrConnect['db_user'] = 'bookmyspotonlin1';
	$arrConnect['db_pass'] = 'BookSp0t1!';
	$arrConnect['db_host'] = '23.229.231.41';
	$arrConnect['db_name'] = 'bookmyspotonline1';
	define ('BASE_URL_RSB', 'https://www.bookmyspotonline.com/');
	define ('BASE_URL_RSB_ADMIN', 'https://www.bookmyspotonline.com/admin/');
	define ('BASE_URL_RSB_WIZARD', 'https://www.bookmyspotonline.com/wizard/');
	define ('SITE_BASEPATH', '/home/pv8i9xj112of/public_html/');
	define ('SITE_BASEPATH_ADMIN', '/home/pv8i9xj112of/public_html/admin/');
	define ('SITE_BASEPATH_WIZARD', '/home/pv8i9xj112of/public_html/wizard/');
	define ('FILE_UPLOAD_ROOT', 'files/');	
	define ('IMAGE_ROOT', 'img/');
	define ('IMAGE_UPLOAD_ROOT', 'uploads/');
	define ('PRODUCT_IMAGE_PATH', BASE_URL_RSB.IMAGE_UPLOAD_ROOT.'products/');
	define ('PRODUCT_IMAGE_BASE_PATH', SITE_BASEPATH.IMAGE_UPLOAD_ROOT.'products/');
	define ('EVENT_IMAGE_PATH', BASE_URL_RSB.IMAGE_UPLOAD_ROOT.'events/');
	define ('EVENT_IMAGE_BASE_PATH', SITE_BASEPATH.IMAGE_UPLOAD_ROOT.'events/');
	define ('PROPERTY_IMAGE_PATH', BASE_URL_RSB.IMAGE_UPLOAD_ROOT.'properties/');
	define ('PROPERTY_IMAGE_BASE_PATH', SITE_BASEPATH.IMAGE_UPLOAD_ROOT.'properties/');
	define ('MARKETPLACE_IMAGE_PATH', BASE_URL_RSB.IMAGE_UPLOAD_ROOT.'marketplace/');
	define ('MARKETPLACE_IMAGE_BASE_PATH', SITE_BASEPATH.IMAGE_UPLOAD_ROOT.'marketplace/');
	define ('AD_IMAGE_PATH', BASE_URL_RSB.IMAGE_UPLOAD_ROOT.'advertisements/');
	define ('AD_IMAGE_BASE_PATH', SITE_BASEPATH.IMAGE_UPLOAD_ROOT.'advertisements/');
	define ('JOKE_IMAGE_PATH', BASE_URL_RSB.IMAGE_UPLOAD_ROOT.'jokes/');
	define ('JOKE_IMAGE_BASE_PATH', SITE_BASEPATH.IMAGE_UPLOAD_ROOT.'jokes/');
}

/************************************
 * Script filename declarations...
 ************************************/
$strScript = str_replace(SITE_BASEPATH, '', $_SERVER['SCRIPT_FILENAME']);
$arrProtectedPages = array('account_landing','edit_account','edit_property','purchase_subscription','purchase_confirmation','master','add_event','edit_event','view_event','view_marketplace_item','add_marketplace_item','edit_marketplace_item','master_marketplace_items','download_mailer_data','download_registration_data','download_subscriber_data','master_advertisements','view_advertisement','edit_advertisement','master_jokes','add_joke','edit_joke','view_joke');

/************************************
 * Table column definitions...
 ************************************/
$arrPageFields = array();

/************************************
 * Page name definitions...
 ************************************/
$arrMoreAccountPages = array('login','register','forgot_password','account_landing','edit_account');

/************************************
 * Data array definitions...
 ************************************/
$arrPropertyStatus = array(
	0 => 'Active',
	1 => 'Disabled',
	2 => 'Available',
	3 => 'Unavailable',
	86 => 'Deleted'
);

$arrNewsFeeds = array(
	'SPORTS' => 'https://www.si.com/rss/si_topstories.rss'
);

$arrMorePages = array(
	'travel'
);

$arrAdTypes = array(
	0 => 'Sidebar Skyscraper',
	1 => 'Sidebar Block',
	2 => 'Banner'
);

$arrJokeTypes = array(
	0 => 'Joke',
	1 => 'Trivia'
);

$arrSliderImages = array(
	0 => 'img/slides/rv_001.jpg',
	1 => 'img/slides/delicate_arch_sunset.jpg',
	2 => 'img/slides/rv_002.jpg',
	3 => 'img/slides/golden_gate_bridge_002.jpg'
);

$arrApprovedStatus = array(
	0 => 'Unapproved',
	1 => 'Approved'
);

$arrBookingStatus = array(
	0 => 'Unconfirmed',
	1 => 'Confirmed',
	86 => 'Deleted'
);

/************************************
 * Load the core functions...
 ************************************/
require_once ('functions.php');

/************************************
 * Load the core actions...
 ************************************/
require ('actions.php');
?>