<?php
/******************************************************
 * Created by: Randy S. Baker
 * Created on: 03-APR-2018
 * -----------------------------------------------------
 * Core Functions (functions.php)
 ******************************************************/

/*************************************************
 * Helper functions...
 *************************************************/
require_once ('functions.helper.php');

/*************************************************
 * Mailer Class...
 *************************************************/
require ('class.phpmailer.php');

/*************************************************
 * Square API...
 *************************************************/
require ('square/autoload.php');
require ('square/store_config.php');
require ('square/helper_functions.php');

/************************************
 * Generate list of plans...
 ************************************/
if (!function_exists('generateSubscriptionPlans'))
{
	function generateSubscriptionPlans($intLimit=100)
	{
		global $sqli;
		$arrData = array();
		$intLimit = $sqli->real_escape_string($intLimit);
		$arrFields = getTableFields(SUBSCRIPTION_PLAN_TABLE);
		$sql = "SELECT ".implode(',', $arrFields)." FROM `".SUBSCRIPTION_PLAN_TABLE."` WHERE `status`!=86 ORDER BY `plan` LIMIT {$intLimit};";
		$res = $sqli->query($sql);
		while ($row = $res->fetch_assoc())
		{
			$arrTemp = array();
			foreach ($arrFields as $key => $val)
			{
				$arrTemp[$val] = $row[$val];
			}
			$arrData[$row['id']] = $arrTemp;
		}
		closeMeUp($res);
		return $arrData;
	}
}

/************************************
 * Get the plan name via ID...
 ************************************/
if (!function_exists('getSubscriptionPlanName'))
{
	function getSubscriptionPlanName($intID=0)
	{
		global $sqli;
		$strData = '';
		$intID = $sqli->real_escape_string($intID);
		$sql = "SELECT `plan` FROM `".SUBSCRIPTION_PLAN_TABLE."` WHERE `id`='{$intID}' LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		$row = $res->fetch_assoc();
		$strData = $row['plan'];
		closeMeUp($res);
		return $strData;
	}
}

/************************************
 * Get subscription data...
 ************************************/
if (!function_exists('getSubscriptionData'))
{
	function getSubscriptionData($intID=0)
	{
		global $sqli;
		$arrData = array();
		$intID = $sqli->real_escape_string($intID);
		$arrFields = getTableFields(SUBSCRIPTION_PLAN_TABLE);
		$sql = "SELECT ".implode(',', $arrFields)." FROM ".SUBSCRIPTION_PLAN_TABLE." WHERE `id`={$intID} LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		$row = $res->fetch_assoc();
		foreach ($arrFields as $key => $val)
		{
			$arrData[$val] = $row[$val];
		}
		closeMeUp($res);
		return $arrData;
	}
}

/************************************
 * Generate list of categories...
 ************************************/
if (!function_exists('generatePropertyCategories'))
{
	function generatePropertyCategories($intLimit=100)
	{
		global $sqli;
		$arrData = array();
		$intLimit = $sqli->real_escape_string($intLimit);
		$arrFields = getTableFields(PROPERTY_CATEGORY_TABLE);
		$sql = "SELECT ".implode(',', $arrFields)." FROM `".PROPERTY_CATEGORY_TABLE."` WHERE `status`!=86 ORDER BY `category` LIMIT {$intLimit};";
		$res = $sqli->query($sql);
		while ($row = $res->fetch_assoc())
		{
			$arrTemp = array();
			foreach ($arrFields as $key => $val)
			{
				$arrTemp[$val] = $row[$val];
			}
			$arrData[$row['id']] = $arrTemp;
		}
		closeMeUp($res);
		return $arrData;
	}
}

/************************************
 * Generate list of category types...
 ************************************/
if (!function_exists('generatePropertyCategoryTypes'))
{
	function generatePropertyCategoryTypes($intLimit=100)
	{
		global $sqli;
		$arrData = array();
		$intLimit = $sqli->real_escape_string($intLimit);
		$arrFields = getTableFields(PROPERTY_CATEGORY_TABLE);
		$sql = "SELECT `id`,`category_type` FROM `".PROPERTY_CATEGORY_TABLE."` WHERE `status`!=86 ORDER BY `id` LIMIT {$intLimit};";
		$res = $sqli->query($sql);
		while ($row = $res->fetch_assoc())
		{
			$arrData[$row['id']] = $row['category_type'];
		}
		closeMeUp($res);
		return $arrData;
	}
}

/************************************
 * Get category data...
 ************************************/
if (!function_exists('getPropertyCategoryData'))
{
	function getPropertyCategoryData($intID=0)
	{
		global $sqli;
		$arrData = array();
		$intID = $sqli->real_escape_string($intID);
		$arrFields = getTableFields(PROPERTY_CATEGORY_TABLE);
		$sql = "SELECT ".implode(',', $arrFields).", UNIX_TIMESTAMP(`ts`) AS `updated` FROM ".PROPERTY_CATEGORY_TABLE." WHERE `id`={$intID} LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		$row = $res->fetch_assoc();
		foreach ($arrFields as $key => $val)
		{
			$arrData[$val] = $row[$val];
		}
		$arrData['updated'] = $row['updated'];
		closeMeUp($res);
		return $arrData;
	}
}

/************************************
 * Get the category ID via name...
 ************************************/
if (!function_exists('getPropertyCategoryID'))
{
	function getPropertyCategoryID($strName='')
	{
		global $sqli;
		$strData = '';
		$strName = $sqli->real_escape_string($strName);
		if ($strName != '')
		{
			$sql = "SELECT `id` FROM `".PROPERTY_CATEGORY_TABLE."` WHERE `category`='{$strName}' LIMIT 1;";
			$res = $sqli->query($sql) or die($sqli->error);
			$row = $res->fetch_assoc();
			$strData = $row['id'];
			closeMeUp($res);
		}
		return $strData;
	}
}

/************************************
 * Get the category name via ID...
 ************************************/
if (!function_exists('getPropertyCategoryName'))
{
	function getPropertyCategoryName($intID=0)
	{
		global $sqli;
		$strData = '';
		$intID = $sqli->real_escape_string($intID);
		$sql = "SELECT `category` FROM `".PROPERTY_CATEGORY_TABLE."` WHERE `id`='{$intID}' LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		$row = $res->fetch_assoc();
		$strData = $row['category'];
		closeMeUp($res);
		return $strData;
	}
}

/************************************
 * Get  property category slug...
 ************************************/
if (!function_exists('getPropertyCategorySlug'))
{
	function getPropertyCategorySlug($intID=0)
	{
		global $sqli;
		$strName = '';
		$intID = $sqli->real_escape_string($intID);
		$sql = "SELECT `url_slug` FROM `".PROPERTY_CATEGORY_TABLE."` WHERE `id`={$intID} LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		$row = $res->fetch_assoc();
		$strName = $row['url_slug'];
		closeMeUp($res);
		return $strName;
	}
}

/***************************************
 * Get property category slug by name...
 ***************************************/
if (!function_exists('getPropertyCategorySlugByName'))
{
	function getPropertyCategorySlugByName($strData='')
	{
		global $sqli;
		$strName = '';
		$strData = $sqli->real_escape_string($strData);
		$sql = "SELECT `url_slug` FROM `".PROPERTY_CATEGORY_TABLE."` WHERE `category`='{$strData}' LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		$row = $res->fetch_assoc();
		$strName = $row['url_slug'];
		closeMeUp($res);
		return $strName;
	}
}

/************************************
 * Generate list of testimonies...
 ************************************/
if (!function_exists('generateTestimonyList'))
{
	function generateTestimonyList($intLimit=10)
	{
		global $sqli;
		$arrData = array();
		$intLimit = $sqli->real_escape_string($intLimit);
		$arrFields = getTableFields(TESTIMONY_TABLE);
		$sql = "SELECT ".implode(',', $arrFields)." FROM `".TESTIMONY_TABLE."` WHERE `status`!=86 ORDER BY `ts` DESC, `id` LIMIT {$intLimit};";
		$res = $sqli->query($sql);
		while ($row = $res->fetch_assoc())
		{
			$arrTemp = array();
			foreach ($arrFields as $key => $val)
			{
				$arrTemp[$val] = $row[$val];
			}
			$arrData[$row['id']] = $arrTemp;
		}
		closeMeUp($res);
		return $arrData;
	}
}

/************************************
 * Authenticate a user...
 ************************************/
if (!function_exists('userAuthenticate'))
{
	function userAuthenticate($arrLoginData)
	{
		global $sqli;
		$arrData = array();
		$arrFields = getTableFields(USER_TABLE);
		$strEmail = $sqli->real_escape_string($arrLoginData['email']);
		$strPass = $sqli->real_escape_string($arrLoginData['pass']);
		$sql = "SELECT ".implode(',', $arrFields)." FROM `".USER_TABLE."` WHERE `email`='{$strEmail}' AND `password`='{$strPass}' AND `status` != -86 LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		if ($sqli->affected_rows > 0)
		{
			$row = $res->fetch_assoc();
			foreach ($arrFields as $key => $val)
			{
				$arrData[$val] = $row[$val];
			}
			$arrData['is_auth'] = 1;
			$_SESSION['sys_user'] = $arrData;
			saveToLog($_SESSION['sys_user']['email'].' - Logged In...');
		}
		closeMeUp($res);
		return $arrData;
	}
}

/************************************
 * Add a new user...
 ************************************/
if (!function_exists('addUserData'))
{
	function addUserData($arrData)
	{
		global $sqli;
		$strSQL = "";
		$intLastID = 0;
		foreach ($arrData as $key => $val)
		{
			if ($key != 'action')
			{
				$strSQL .= "`{$key}`='{$val}',";
			}
		}
		$strSQL = substr($strSQL, 0, strlen($strSQL) - 1);
		$sql = "INSERT INTO `".USER_TABLE."` SET {$strSQL};";
		$res = $sqli->query($sql) or die($sqli->error);
		$intLastID = $sqli->insert_id;
		closeMeUp($res);
		return $intLastID;
	}
}

/************************************
 * Save user data...
 ************************************/
if (!function_exists('saveUserData'))
{
	function saveUserData($strID, $arrData)
	{
		global $sqli;
		$strSQL = "";
		$strID = $sqli->real_escape_string($strID);
		foreach ($arrData as $key => $val)
		{
			if ($key != 'uid' && $key != 'action')
			{
				$strSQL .= "`{$key}`='{$val}',";
			}
		}
		$strSQL = substr($strSQL, 0, strlen($strSQL) - 1);
		$sql = "UPDATE `".USER_TABLE."` SET {$strSQL} WHERE `id`={$strID} LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		closeMeUp($res);
		return;
	}
}

/************************************
 * Delete a user...
 ************************************/
if (!function_exists('deleteUserData'))
{
	function deleteUserData($strID=0)
	{
		global $sqli;
		$strID = $sqli->real_escape_string($strID);
		$sql = "UPDATE `".USER_TABLE."` SET `status`=86 WHERE `id`={$strID} LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		closeMeUp($res);
		return;
	}
}

/************************************
 * Retrieve a user's password...
 ************************************/
if (!function_exists('getUserPassword'))
{
	function getUserPassword($strData='')
	{
		global $sqli;
		$arrData = array();
		$strData = $sqli->real_escape_string($strData);
		$sql = "SELECT `password` FROM `".USER_TABLE."` WHERE `email`='{$strData}' LIMIT 1";;
		$res = $sqli->query($sql);
		if ($sqli->affected_rows > 0)
		{
			$row = $res->fetch_assoc();
			$arrData['user_password'] = $row['password'];
		}
		closeMeUp($res);
		return $arrData;
	}
}

/************************************
 * Get user data...
 ************************************/
if (!function_exists('getUserData'))
{
	function getUserData($intID=0)
	{
		global $sqli;
		$arrData = array();
		$intID = $sqli->real_escape_string($intID);
		$arrFields = getTableFields(USER_TABLE);
		$sql = "SELECT ".implode(',', $arrFields).", UNIX_TIMESTAMP(`ts`) AS `updated` FROM ".USER_TABLE." WHERE `id`={$intID} LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		$row = $res->fetch_assoc();
		foreach ($arrFields as $key => $val)
		{
			$arrData[$val] = $row[$val];
		}
		$arrData['updated'] = $row['updated'];
		closeMeUp($res);
		return $arrData;
	}
}

/************************************
 * Reload a user's data...
 ************************************/
if (!function_exists('reloadUserData'))
{
	function reloadUserData($intID=0)
	{
		global $sqli;
		$arrFields = getTableFields(USER_TABLE);
		$intID = $sqli->real_escape_string($intID);
		$sql = "SELECT ".implode(',', $arrFields)." FROM `".USER_TABLE."` WHERE `id`={$intID} LIMIT 1;";
		$res = $sqli->query($sql);
		$arrData = $res->fetch_assoc();
		$arrData['is_auth'] = 1;
		$_SESSION['sys_user'] = $arrData;
		closeMeUp($res);
		return;
	}
}

/************************************
 * Add a new subscriber...
 ************************************/
if (!function_exists('addSubscriberData'))
{
	function addSubscriberData($arrData)
	{
		global $sqli;
		$strSQL = "";
		foreach ($arrData as $key => $val)
		{
			if ($key != 'action' && $key != 'btnSubmit' && $key != 'btnCancel')
			{
				$strSQL .= "`{$key}`='{$val}',";
			}
		}
		$strSQL = substr($strSQL, 0, strlen($strSQL) - 1);
		$sql = "INSERT INTO `".SUBSCRIBER_TABLE."` SET {$strSQL};";
		$res = $sqli->query($sql) or die($sqli->error);
		closeMeUp($res);
		return;
	}
}

/*************************************
 * Generate list of user data items...
 *************************************/
if (!function_exists('generateUserDataListings'))
{
	function generateUserDataListings($intUserID=0, $strDataCategory='', $intLimit=100)
	{
		global $sqli;
		$arrData = array();
		$intUserID = $sqli->real_escape_string($intUserID);
		$strDataCategory = $sqli->real_escape_string($strDataCategory);
		$intLimit = $sqli->real_escape_string($intLimit);
		$arrFields = getTableFields(USER_DATA_TABLE);
		$sql = "SELECT ".implode(',', $arrFields).", UNIX_TIMESTAMP(`ts`) AS `updated` FROM `".USER_DATA_TABLE."` WHERE `status`!=86 AND `user_id`={$intUserID} AND `data_category`='{$strDataCategory}' LIMIT {$intLimit};";
		$res = $sqli->query($sql);
		while ($row = $res->fetch_assoc())
		{
			$arrTemp = array();
			foreach ($arrFields as $key => $val)
			{
				$arrTemp[$val] = $row[$val];
			}
			$arrTemp['updated'] = $row['updated'];
			$arrData[$row['id']] = $arrTemp;
		}
		closeMeUp($res);
		return $arrData;
	}
}

/************************************
 * Add trip planner user data...
 ************************************/
if (!function_exists('addTripToAccount'))
{
	function addTripToAccount($intUserID=0, $arrData=array())
	{
		global $sqli;
		$intUserID = $sqli->real_escape_string($intUserID);
		$strData = serialize($arrData);
		$strCategory = 'trip-planner';
		$sql = "INSERT INTO `".USER_DATA_TABLE."` SET `user_id`={$intUserID}, `data_category`='{$strCategory}', `data_content`='{$strData}';";
		$res = $sqli->query($sql) or die($sqli->error);
		closeMeUp($res);
		return;
	}
}

/************************************
 * Remove trip planner user data...
 ************************************/
if (!function_exists('removeTripFromAccount'))
{
	function removeTripFromAccount($intUserID=0, $intID=0)
	{
		global $sqli;
		$intID = $sqli->real_escape_string($intID);
		$intUserID = $sqli->real_escape_string($intUserID);
		$sql = "UPDATE `".USER_DATA_TABLE."` SET `status`=86 WHERE `user_id`={$intUserID} AND `id`={$intID} LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		closeMeUp($res);
	}
}

/************************************
 * Get the page ID from slug...
 ************************************/
if (!function_exists('getPageID'))
{
	function getPageID($strSlug='')
	{
		global $sqli;
		$strID = '';
		$strSlug = $sqli->real_escape_string($strSlug);
		$sql = "SELECT `id` FROM `".CONTENT_TABLE."` WHERE `page_url`='{$strSlug}' LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		$row = $res->fetch_assoc();
		$strID = $row['id'];
		closeMeUp($res);
		return $strID;
	}
}

/************************************
 * Get page data...
 ************************************/
if (!function_exists('getPageData'))
{
	function getPageData($intID=0)
	{
		global $sqli;
		$arrData = array();
		$intID = $sqli->real_escape_string($intID);
		$arrFields = getTableFields(CONTENT_TABLE);
		$sql = "SELECT ".implode(',', $arrFields)." FROM ".CONTENT_TABLE." WHERE `id`={$intID} LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		$row = $res->fetch_assoc();
		foreach ($arrFields as $key => $val)
		{
			$arrData[$val] = $row[$val];
		}
		closeMeUp($res);
		return $arrData;
	}
}

/************************************
 * Generate list of property names...
 ************************************/
if (!function_exists('generatePropertyNames'))
{
	function generatePropertyNames($strSearch='', $intLimit=100)
	{
		global $sqli;
		$arrData = array();
		$intLimit = $sqli->real_escape_string($intLimit);
		$strSearch = $sqli->real_escape_string($strSearch);
		$arrFields = getTableFields(PROPERTY_TABLE);
		$sql = "SELECT `id`,`property_name` FROM `".PROPERTY_TABLE."` WHERE `status`!=86 AND `property_name` LIKE '{$strSearch}%' ORDER BY `property_name` LIMIT {$intLimit};";
		$res = $sqli->query($sql);
		while ($row = $res->fetch_assoc())
		{
			$arrTemp = array();
			$arrTemp['id'] = $row['id'];
			$arrTemp['property_name'] = $row['property_name'];
			$arrData[$row['id']] = $arrTemp;
		}
		closeMeUp($res);
		return $arrData;
	}
}

/************************************
 * Generate list of property names...
 ************************************/
if (!function_exists('generatePropertyNamesRVParks'))
{
	function generatePropertyNamesRVParks($strSearch='', $intLimit=100)
	{
		global $sqli;
		$arrData = array();
		$intLimit = $sqli->real_escape_string($intLimit);
		$strSearch = $sqli->real_escape_string($strSearch);
		$arrFields = getTableFields(PROPERTY_TABLE);
		$sql = "SELECT `id`,`property_name` FROM `".PROPERTY_TABLE."` WHERE `status`!=86 AND `category_id`=24 AND `property_name` LIKE '{$strSearch}%' ORDER BY `property_name` LIMIT {$intLimit};";
		$res = $sqli->query($sql);
		while ($row = $res->fetch_assoc())
		{
			$arrTemp = array();
			$arrTemp['id'] = $row['id'];
			$arrTemp['property_name'] = $row['property_name'];
			$arrData[$row['id']] = $arrTemp;
		}
		closeMeUp($res);
		return $arrData;
	}
}

/************************************
 * Generate list of properties...
 ************************************/
if (!function_exists('generatePropertes'))
{
	function generatePropertes($intLimit=1000, $isRandom=false, $strOptional=false, $hasLatLon=false, $arrXMLParams=array(), $arrPropertyIDs=array())
	{
		global $sqli;
		$arrData = array();
		$strIDSearch = '';
		$strXMLSearch = '';
		$strIDSearchSQL = '';
		$intLimit = $sqli->real_escape_string($intLimit);
		$arrFields = getTableFields(PROPERTY_TABLE);
		if ($isRandom === true)
		{
			$strOrderBy = '`id`';
		} else {
			$strOrderBy = '`property_name`';
		}

		if ($strOptional === true)
		{
			$strSpecial = "AND `property_latitude` IS NULL";
		} else {
			$strSpecial = '';
		}

		if ($hasLatLon === true)
		{
			$strGeo = "AND `property_latitude` IS NOT NULL AND `property_latitude` != '' AND `property_address` IS NOT NULL";
		} else {
			$strGeo = '';
		}

		if (!empty($arrXMLParams))
		{
			if (isset($arrXMLParams['start_latitude']) && $arrXMLParams['start_latitude'] != '')
			{
				$tmpGeo[0] = array(
					'lat' => $arrXMLParams['start_latitude'],
					'lng' => $arrXMLParams['start_longitude']
				);
				$arrPropertyIDs = getProximityGEO('id', 250, $tmpGeo);
			}
		}

		if (!empty($arrPropertyIDs))
		{
			$strIDSearch = implode(',', $arrPropertyIDs);
			$strIDSearchSQL = " AND `id` IN ({$strIDSearch})";
		}

		if (!empty($arrXMLParams))
		{
			if (is_array($arrXMLParams['property_category']) && !empty($arrXMLParams['property_category']))
			{
				$strTemp = implode(',', $arrXMLParams['property_category']);
				$strXMLSearch .= " AND `category_id` IN (".$strTemp.")";
			} else {
				$strXMLSearch .= ((isset($arrXMLParams['property_category']) && $arrXMLParams['property_category'] != '')?(" AND `category_id`=".$arrXMLParams['property_category']):(''));
			}
			$strXMLSearch .= ((isset($arrXMLParams['property_name_id']) && $arrXMLParams['property_name_id'] != '')?(" AND `id`=".$arrXMLParams['property_name_id']):(''));
			$strXMLSearch .= ((isset($arrXMLParams['property_city']) && $arrXMLParams['property_city'] != '')?(" AND `property_city`='".$arrXMLParams['property_city']."'"):(''));
			$strXMLSearch .= ((isset($arrXMLParams['property_state']) && $arrXMLParams['property_state'] != '')?(" AND `property_state`='".$arrXMLParams['property_state']."'"):(''));
			$strXMLSearch .= ((isset($arrXMLParams['property_zipcode']) && $arrXMLParams['property_zipcode'] != '')?(" AND `property_zipcode`='".$arrXMLParams['property_zipcode']."'"):(''));
		} else {
			//$strXMLSearch = " AND `category_id` IN (21,22,23,24,25,26,27,28)";
			$strXMLSearch = " AND `category_id` IN (24)";
		}
		$sql = "SELECT ".implode(',', $arrFields)." FROM `".PROPERTY_TABLE."` WHERE `status`!=86 AND `is_approved`=1 {$strSpecial} {$strGeo} {$strXMLSearch} {$strIDSearchSQL} ORDER BY {$strOrderBy} LIMIT {$intLimit};";
		$res = $sqli->query($sql);
		if ($res->num_rows > 0)
		{
			while ($row = $res->fetch_assoc())
			{
				$arrTemp = array();
				foreach ($arrFields as $key => $val)
				{
					$arrTemp[$val] = $row[$val];
				}
				$arrData[$row['id']] = $arrTemp;
			}
		}
		closeMeUp($res);
		return $arrData;
	}
}

/********************************************
 * Generate list of reservation properties...
 ********************************************/
if (!function_exists('generateReservationProperties'))
{
	function generateReservationProperties($arrSearchData=array(), $intLimit=1000)
	{
		global $sqli;
		$arrZipcodes = array();
		$intLimit = $sqli->real_escape_string($intLimit);
		if (!empty($arrSearchData))
		{
			foreach ($arrSearchData as $key => $val)
			{
				$val = $sqli->real_escape_string($val);
				$arrSearchData[$key] = $val;
			}
		}

		$arrProximity = getProximity($arrSearchData['property_zipcode'], 50, 'zipcode', $arrSearchData['property_state'], true);
		if (!empty($arrProximity))
		{
			foreach ($arrProximity as $proximities)
			{
				$proximity = toObject($proximities);
				$arrZipcodes[] = $proximity->zipcode;
			}
		}

		$arrFields = getTableFields(PROPERTY_TABLE);
		$strOrderBy = '`property_name`';
		$strGeoSearch = "AND `property_latitude` IS NOT NULL AND `property_latitude` != '' AND `property_address` IS NOT NULL";
		$strSearch = "AND `category_id`=24";
		$strSearch .= " AND `property_zipcode` IN ('". implode("','", $arrZipcodes) ."')";
		//$strSearch .= ((isset($arrSearchData['property_city']) && $arrSearchData['property_city'] != '')?(" AND `property_city`='".$arrSearchData['property_city']."'"):(''));
		//$strSearch .= ((isset($arrSearchData['property_state']) && $arrSearchData['property_state'] != '')?(" AND `property_state`='".$arrSearchData['property_state']."'"):(''));
		//$strSearch .= ((isset($arrSearchData['property_zipcode']) && $arrSearchData['property_zipcode'] != '')?(" AND `property_zipcode`='".$arrSearchData['property_zipcode']."'"):(''));
		$sql = "SELECT ".implode(',', $arrFields)." FROM `".PROPERTY_TABLE."` WHERE `status`!=86 AND `is_approved`=1 {$strSearch} ORDER BY {$strOrderBy} LIMIT {$intLimit};";
		$res = $sqli->query($sql);
		if ($res->num_rows > 0)
		{
			while ($row = $res->fetch_assoc())
			{
				$arrTemp = array();
				foreach ($arrFields as $key => $val)
				{
					$arrTemp[$val] = $row[$val];
				}
				$arrData[$row['id']] = $arrTemp;
			}
		}
		closeMeUp($res);
		return $arrData;
	}
}

/************************************
 * Get property data...
 ************************************/
if (!function_exists('getPropertyData'))
{
	function getPropertyData($intID=0)
	{
		global $sqli;
		$arrData = array();
		$intID = $sqli->real_escape_string($intID);
		$arrFields = getTableFields(PROPERTY_TABLE);
		$sql = "SELECT ".implode(',', $arrFields).", UNIX_TIMESTAMP(`ts`) AS `updated` FROM ".PROPERTY_TABLE." WHERE `id`={$intID} LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		$row = $res->fetch_assoc();
		foreach ($arrFields as $key => $val)
		{
			$arrData[$val] = $row[$val];
		}
		$arrData['updated'] = $row['updated'];
		closeMeUp($res);
		return $arrData;
	}
}

/***************************************
 * Generate property hash code...
 ***************************************/
if (!function_exists('generatePropertyHash'))
{
	function generatePropertyHash($intID=0)
	{
		global $sqli;
		$intID = $sqli->real_escape_string($intID);
		$property = toObject(getPropertyData($intID));
		if ($property->property_hash == '')
    	{
        	$intPropertyID = $property->id;
        	$strData = create_guid();
        	$sql = "UPDATE `".PROPERTY_TABLE."` SET `property_hash`='{$strData}' WHERE `id`={$intPropertyID} LIMIT 1;";
        	$res = $sqli->query($sql) or die($sqli->error);
        	closeMeUp($res);
    	}
		return;
	}
}

/***************************************
 * Get property ID via hash...
 ***************************************/
if (!function_exists('getPropertyIDFromHash'))
{
	function getPropertyIDFromHash($strData='')
	{
		global $sqli;
		$intID = '';
		$strData = $sqli->real_escape_string($strData);
		$sql = "SELECT `id` FROM `".PROPERTY_TABLE."` WHERE `property_hash`='{$strData}' LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		$row = $res->fetch_assoc();
		$intID = $row['id'];
		closeMeUp($res);
		return $intID;
	}
}

/************************************
 * Get the property name via ID...
 ************************************/
if (!function_exists('getPropertyName'))
{
	function getPropertyName($intID=0)
	{
		global $sqli;
		$strData = '';
		$intID = $sqli->real_escape_string($intID);
		$sql = "SELECT `property_name` FROM `".PROPERTY_TABLE."` WHERE `id`='{$intID}' LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		$row = $res->fetch_assoc();
		$strData = $row['property_name'];
		closeMeUp($res);
		return $strData;
	}
}

/*************************************
 * Get property name (autocomplete)...
 *************************************/
if (!function_exists('autoCompletePropertyName'))
{
	function autoCompletePropertyName($strKeyword='')
	{
		global $sqli;
		$strData = '<ul id="autocomplete-list">'.CRLF;
		$strKeyword = $sqli->real_escape_string($strKeyword);
		$sql = "SELECT `id`,`property_name` FROM `".PROPERTY_TABLE."` WHERE `property_name` LIKE '{$strKeyword}%' ORDER BY `property_name` LIMIT 5;";
		$res = $sqli->query($sql) or die($sqli->error);
		while ($row = $res->fetch_assoc())
		{
			$strData .= '  <li class="autocomplete-result-item" data-value="'.$row['property_name'].'"><a href="'.BASE_URL_RSB.'details/'.$row['id'].'/'.urlencode($row['property_name']).'/" target="_blank">'. $row['property_name'].'</a></li>'.CRLF;
			//$strData .= '  <li class="autocomplete-result-item" data-value="'.$row['property_name'].'">'. $row['property_name'].'</li>'.CRLF;
		}
		closeMeUp($res);
		$strData .= '</ul>'.CRLF;
		return $strData;
	}
}

/************************************
 * Get a user's property list...
 ************************************/
if (!function_exists('getUserPropertyDataList'))
{
	function getUserPropertyDataList($intID=0, $isAdmin=false)
	{
		global $sqli;
		$arrData = array();
		$intID = $sqli->real_escape_string($intID);
		$arrFields = getTableFields(PROPERTY_TABLE);
		if ($isAdmin == true)
		{
			$sqlSuffix = "";			
		} else {
			$sqlSuffix = "`user_id`={$intID} AND";
		}
		$sql = "SELECT ".implode(',', $arrFields).", UNIX_TIMESTAMP(`ts`) AS `updated` FROM `".PROPERTY_TABLE."` WHERE {$sqlSuffix} `status` != 86 ORDER BY `property_name`;";
		$res = $sqli->query($sql) or die($sqli->error);
		if ($res->num_rows > 0)
		{
			while ($row = $res->fetch_assoc())
			{
				$arrTemp = array();
				foreach ($arrFields as $key => $val)
				{
					$arrTemp[$val] = $row[$val];
				}
				$arrTemp['updated'] = $row['updated'];
				$arrData[$row['id']] = $arrTemp;
			}
		}
		closeMeUp($res);
		return $arrData;
	}
}

/************************************
 * Add a new property...
 ************************************/
if (!function_exists('addPropertyData'))
{
	function addPropertyData($arrData=array())
	{
		global $sqli;
		$strSQL = "";
		$user = toObject($_SESSION['sys_user']);
		if (isset($arrData['is_admin']) && $arrData['is_admin'] == 1)
		{
			unset($arrData['user_id']);
			$arrData['is_approved'] = 1;
		}

		foreach ($arrData as $key => $val)
		{
			if ($key != 'action' && $key != 'is_admin')
			{
				$val = $sqli->real_escape_string($val);
				$strSQL .= "`{$key}`='{$val}',";
			}
		}
		$strSQL = substr($strSQL, 0, strlen($strSQL) - 1);
		$sql = "INSERT INTO `".PROPERTY_TABLE."` SET {$strSQL};";
		$res = $sqli->query($sql) or die($sqli->error);
		$intLastID = $sqli->insert_id;
		closeMeUp($res);
		return $intLastID;
	}
}

/************************************
 * Save property data...
 ************************************/
if (!function_exists('savePropertyData'))
{
	function savePropertyData($intID=0, $arrData)
	{
		global $sqli;
		$strSQL = "";
		$intID = $sqli->real_escape_string($intID);
		foreach ($arrData as $key => $val)
		{
			if ($key != 'id' && $key != 'action' && $key != 'btnSubmit' && $key != 'btnCancel')
			{
				$val = $sqli->real_escape_string($val);
				$strSQL .= "{$key}='{$val}',";
			}
		}
		$strSQL = substr($strSQL, 0, strlen($strSQL) - 1);
		$sql = "UPDATE `".PROPERTY_TABLE."` SET {$strSQL} WHERE `id`={$intID} LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		closeMeUp($res);
		return;
	}
}

/************************************
 * Approve a property...
 ************************************/
if (!function_exists('approvePropertyData'))
{
	function approvePropertyData($intID=0)
	{
		global $sqli;
		$intID = $sqli->real_escape_string($intID);
		$sql = "UPDATE `".PROPERTY_TABLE."` SET `is_approved`=1 WHERE `id`={$intID} LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		closeMeUp($res);
		return;
	}
}

/************************************
 * Delete a property...
 ************************************/
if (!function_exists('deletePropertyData'))
{
	function deletePropertyData($intID=0, $isRemoveUser=false)
	{
		global $sqli;
		$intID = $sqli->real_escape_string($intID);
		if ($isRemoveUser == true)
		{
			$sql = "UPDATE `".PROPERTY_TABLE."` SET `user_id`=0 WHERE `id`={$intID} LIMIT 1;";
		} else {
			$sql = "UPDATE `".PROPERTY_TABLE."` SET `status`=86 WHERE `id`={$intID} LIMIT 1;";
		}
		$res = $sqli->query($sql) or die($sqli->error);
		closeMeUp($res);
		return;
	}
}

/************************************
 * Claim a property...
 ************************************/
if (!function_exists('claimPropertyData'))
{
	function claimPropertyData($intID=0)
	{
		global $sqli;
		$intID = $sqli->real_escape_string($intID);
		$user = toObject($_SESSION['sys_user']);
		$sql = "UPDATE `".PROPERTY_TABLE."` SET `user_id`={$user->id} WHERE `id`={$intID} LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		closeMeUp($res);
		return;
	}
}

/************************************
 * Generate list of events...
 ************************************/
if (!function_exists('generateEvents'))
{
	function generateEvents($intLimit=100, $isRandom=false)
	{
		global $sqli;
		$arrData = array();
		$intLimit = $sqli->real_escape_string($intLimit);
		$arrFields = getTableFields(EVENT_TABLE);
		if ($isRandom === true)
		{
			$strOrderBy = '`id`';
		} else {
			$strOrderBy = '`ts` DESC';
		}
		$sql = "SELECT ".implode(',', $arrFields).", UNIX_TIMESTAMP(`ts`) AS `updated`, UNIX_TIMESTAMP(`start_date`) AS `event_start_date`, UNIX_TIMESTAMP(`end_date`) AS `event_end_date` FROM `".EVENT_TABLE."` WHERE `status`!=86 ORDER BY {$strOrderBy} LIMIT {$intLimit};";
		$res = $sqli->query($sql);
		if ($res->num_rows > 0)
		{
			while ($row = $res->fetch_assoc())
			{
				$arrTemp = array();
				foreach ($arrFields as $key => $val)
				{
					$arrTemp[$val] = $row[$val];
				}
				$arrTemp['updated'] = $row['updated'];
				$arrTemp['event_start_date'] = $row['event_start_date'];
				$arrTemp['event_end_date'] = $row['event_end_date'];
				$arrData[$row['id']] = $arrTemp;
			}
		}
		closeMeUp($res);
		return $arrData;
	}
}

/************************************
 * Get event data...
 ************************************/
if (!function_exists('getEventData'))
{
	function getEventData($intID=0)
	{
		global $sqli;
		$arrData = array();
		$intID = $sqli->real_escape_string($intID);
		$arrFields = getTableFields(EVENT_TABLE);
		$sql = "SELECT ".implode(',', $arrFields).", UNIX_TIMESTAMP(`ts`) AS `updated`, UNIX_TIMESTAMP(`start_date`) AS `event_start_date`, UNIX_TIMESTAMP(`end_date`) AS `event_end_date` FROM ".EVENT_TABLE." WHERE `id`={$intID} LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		$row = $res->fetch_assoc();
		foreach ($arrFields as $key => $val)
		{
			$arrData[$val] = $row[$val];
		}
		$arrData['updated'] = $row['updated'];
		$arrData['event_start_date'] = $row['event_start_date'];
		$arrData['event_end_date'] = $row['event_end_date'];
		closeMeUp($res);
		return $arrData;
	}
}

/************************************
 * Add a new event...
 ************************************/
if (!function_exists('addEventData'))
{
	function addEventData($arrData=array())
	{
		global $sqli;
		$strSQL = "";
		foreach ($arrData as $key => $val)
		{
			if ($key != 'action' && $key != 'is_admin')
			{
				$val = $sqli->real_escape_string($val);
				$strSQL .= "`{$key}`='{$val}',";
			}
		}
		$strSQL = substr($strSQL, 0, strlen($strSQL) - 1);
		$sql = "INSERT INTO `".EVENT_TABLE."` SET {$strSQL};";
		$res = $sqli->query($sql) or die($sqli->error);
		$intLastID = $sqli->insert_id;
		closeMeUp($res);
		return $intLastID;
	}
}

/************************************
 * Save event data...
 ************************************/
if (!function_exists('saveEventData'))
{
	function saveEventData($intID=0, $arrData)
	{
		global $sqli;
		$strSQL = "";
		$intID = $sqli->real_escape_string($intID);
		foreach ($arrData as $key => $val)
		{
			if ($key != 'id' && $key != 'action' && $key != 'btnSubmit' && $key != 'btnCancel')
			{
				$val = $sqli->real_escape_string($val);
				$strSQL .= "{$key}='{$val}',";
			}
		}
		$strSQL = substr($strSQL, 0, strlen($strSQL) - 1);
		$sql = "UPDATE `".EVENT_TABLE."` SET {$strSQL} WHERE `id`={$intID} LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		closeMeUp($res);
		return;
	}
}

/************************************
 * Delete an event...
 ************************************/
if (!function_exists('deleteEventData'))
{
	function deleteEventData($intID=0)
	{
		global $sqli;
		$intID = $sqli->real_escape_string($intID);
		$sql = "UPDATE `".EVENT_TABLE."` SET `status`=86 WHERE `id`={$intID} LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		closeMeUp($res);
		return;
	}
}

/*************************************
 * Generate list of property events...
 *************************************/
if (!function_exists('generatePropertyEvents'))
{
	function generatePropertyEvents($intPropertyID=0, $intLimit=100)
	{
		global $sqli;
		$arrData = array();
		$intLimit = $sqli->real_escape_string($intLimit);
		$intPropertyID = $sqli->real_escape_string($intPropertyID);
		$arrFields = getTableFields(EVENT_TABLE);
		$sql = "SELECT ".implode(',', $arrFields).", UNIX_TIMESTAMP(`ts`) AS `updated`, UNIX_TIMESTAMP(`start_date`) AS `event_start_date`, UNIX_TIMESTAMP(`end_date`) AS `event_end_date` FROM `".EVENT_TABLE."` WHERE `status`!=86 AND `property_id`={$intPropertyID} ORDER BY `id` LIMIT {$intLimit};";
		$res = $sqli->query($sql);
		if ($res->num_rows > 0)
		{
			while ($row = $res->fetch_assoc())
			{
				$arrTemp = array();
				foreach ($arrFields as $key => $val)
				{
					$arrTemp[$val] = $row[$val];
				}
				$arrTemp['updated'] = $row['updated'];
				$arrTemp['event_start_date'] = $row['event_start_date'];
				$arrTemp['event_end_date'] = $row['event_end_date'];
				$arrData[$row['id']] = $arrTemp;
			}
		}
		closeMeUp($res);
		return $arrData;
	}
}

/************************************
 * Generate order data...
 ************************************/
if (!function_exists('generateOrderData'))
{
	function generateOrderData($intUserID=0, $intPropertyID=0, $intSubscriptionID=0)
	{
		global $sqli;
		$arrData = array();
		$intUserID = $sqli->real_escape_string($intUserID);
		$intPropertyID = $sqli->real_escape_string($intPropertyID);
		$intSubscriptionID = $sqli->real_escape_string($intSubscriptionID);

		// Get the relevent data...
		$user = toObject(getUserData($intUserID));
		$property = toObject(getPropertyData($intPropertyID));
		$subscription = toObject(getSubscriptionData($intSubscriptionID));
		$intSubscriptionPrice = number_format($subscription->price, 2);
		$strSubscriptionPrice = str_replace('.', '', $intSubscriptionPrice);

		// Assemble the data array...
		$arrData = array(
		    "redirect_url" => BASE_URL_RSB.'purchase-confirmation/',
		    "idempotency_key" => create_guid(),
		    "order" => array(
		        "reference_id" => "{$property->property_name}",
		        "line_items" => array(
		            array(
		                "name" => "{$subscription->plan} Plan - {$property->property_name}",
		                "quantity" => "1",
		                "base_price_money" => array(
		                    "amount" => intVal($strSubscriptionPrice),
		                    "currency" => "USD"
		                ),
		            ),
		        ),
		        "merchant_support_email" => FROM_EMAIL,
		        "pre_populate_buyer_email" => "{$user->email}",
		        "pre_populate_shipping_address" => array(
		            "address_line_1" => "{$user->address_1}",
		            "address_line_2" => "",
		            "locality" => "{$user->city}",
		            "administrative_district_level_1" => "{$user->state}",
		            "postal_code" => "{$user->zipcode}",
		            "country" => "US",
		            "first_name" => "{$user->first_name}",
		            "last_name" => "{$user->last_name}"
		        ),
		    )
		);
		return $arrData;
	}
}

/************************************
 * Store transaction data...
 ************************************/
if (!function_exists('storeTransactionDetails'))
{
	function storeTransactionDetails($arrData=array())
	{
		global $sqli;
		if (!empty($arrData))
		{
			foreach ($arrData as $key => $val)
			{
				if ($key != 'action')
				{
					$strSQL .= "`{$key}`='{$val}',";
				}
			}
			$strSQL = substr($strSQL, 0, strlen($strSQL) - 1);
			$sql = "INSERT INTO `".SQUARE_TRANSACTION_TABLE."` SET {$strSQL};";
			$res = $sqli->query($sql) or die($sqli->error);
			closeMeUp($res);
		}
		return;
	}
}

/************************************
 * Update property subscription...
 ************************************/
if (!function_exists('updatePropertySubscription'))
{
	function updatePropertySubscription($intID=0, $intPlanID=0)
	{
		global $sqli;
		$intID = $sqli->real_escape_string($intID);
		$intPlanID = $sqli->real_escape_string($intPlanID);
		$sql = "UPDATE `".PROPERTY_TABLE."` SET `subscription_id`={$intPlanID} WHERE `id`={$intID} LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		closeMeUp($res);
		return;
	}
}

/************************************
 * Generate list of categories...
 ************************************/
if (!function_exists('generateMarketplaceCategories'))
{
	function generateMarketplaceCategories($intLimit=100)
	{
		global $sqli;
		$arrData = array();
		$intLimit = $sqli->real_escape_string($intLimit);
		$arrFields = getTableFields(MARKETPLACE_CATEGORY_TABLE);
		$sql = "SELECT ".implode(',', $arrFields)." FROM `".MARKETPLACE_CATEGORY_TABLE."` WHERE `status`!=86 ORDER BY `category` LIMIT {$intLimit};";
		$res = $sqli->query($sql);
		while ($row = $res->fetch_assoc())
		{
			$arrTemp = array();
			foreach ($arrFields as $key => $val)
			{
				$arrTemp[$val] = $row[$val];
			}
			$arrData[$row['id']] = $arrTemp;
		}
		closeMeUp($res);
		return $arrData;
	}
}

/************************************
 * Get the category name via ID...
 ************************************/
if (!function_exists('getMarketplaceCategoryName'))
{
	function getMarketplaceCategoryName($intID=0)
	{
		global $sqli;
		$strData = '';
		$intID = $sqli->real_escape_string($intID);
		$sql = "SELECT `category` FROM `".MARKETPLACE_CATEGORY_TABLE."` WHERE `id`='{$intID}' LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		$row = $res->fetch_assoc();
		$strData = $row['category'];
		closeMeUp($res);
		return $strData;
	}
}

/************************************
 * Get  marketplace category slug...
 ************************************/
if (!function_exists('getMarketplaceCategorySlug'))
{
	function getMarketplaceCategorySlug($intID=0)
	{
		global $sqli;
		$strName = '';
		$intID = $sqli->real_escape_string($intID);
		$sql = "SELECT `url_slug` FROM `".MARKETPLACE_CATEGORY_TABLE."` WHERE `id`={$intID} LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		$row = $res->fetch_assoc();
		$strName = $row['url_slug'];
		closeMeUp($res);
		return $strName;
	}
}

/***************************************
 * Get marketplace category slug by name...
 ***************************************/
if (!function_exists('getMarketplaceCategorySlugByName'))
{
	function getMarketplaceCategorySlugByName($strData='')
	{
		global $sqli;
		$strName = '';
		$strData = $sqli->real_escape_string($strData);
		$sql = "SELECT `url_slug` FROM `".MARKETPLACE_CATEGORY_TABLE."` WHERE `category`='{$strData}' LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		$row = $res->fetch_assoc();
		$strName = $row['url_slug'];
		closeMeUp($res);
		return $strName;
	}
}

/************************************
 * Generate marketplace item list...
 ************************************/
if (!function_exists('generateMarketplaceItems'))
{
	function generateMarketplaceItems($intLimit=1000, $isRandom=false, $strOptional=false, $hasLatLon=false, $arrXMLParams=array(), $arrPropertyIDs=array())
	{
		global $sqli;
		$arrData = array();
		$strIDSearch = '';
		$strXMLSearch = '';
		$strIDSearchSQL = '';
		$intLimit = $sqli->real_escape_string($intLimit);
		$arrFields = getTableFields(MARKETPLACE_TABLE);
		if ($isRandom === true)
		{
			$strOrderBy = '`id`';
		} else {
			$strOrderBy = '`property_name`';
		}

		if ($strOptional === true)
		{
			$strSpecial = "AND `property_latitude` IS NULL";
		} else {
			$strSpecial = '';
		}

		if ($hasLatLon === true)
		{
			$strGeo = "AND `property_latitude` IS NOT NULL AND `property_latitude` != '' AND `property_address` IS NOT NULL";
		} else {
			$strGeo = '';
		}

		if (!empty($arrPropertyIDs))
		{
			$strIDSearch = implode(',', $arrPropertyIDs);
			$strIDSearchSQL = " AND `id` IN ({$strIDSearch})";
		}

		if (!empty($arrXMLParams))
		{
			$strXMLSearch .= ((isset($arrXMLParams['property_category']) && $arrXMLParams['property_category'] != '')?(" AND `category_id`=".$arrXMLParams['property_category']):(''));
			$strXMLSearch .= ((isset($arrXMLParams['property_city']) && $arrXMLParams['property_city'] != '')?(" AND `property_city`='".$arrXMLParams['property_city']."'"):(''));
			$strXMLSearch .= ((isset($arrXMLParams['property_state']) && $arrXMLParams['property_state'] != '')?(" AND `property_state`='".$arrXMLParams['property_state']."'"):(''));
			$strXMLSearch .= ((isset($arrXMLParams['property_zipcode']) && $arrXMLParams['property_zipcode'] != '')?(" AND `property_zipcode`='".$arrXMLParams['property_zipcode']."'"):(''));
		}
		$sql = "SELECT ".implode(',', $arrFields)." FROM `".MARKETPLACE_TABLE."` WHERE `status`!=86 {$strSpecial} {$strGeo} {$strXMLSearch} {$strIDSearchSQL} ORDER BY {$strOrderBy} LIMIT {$intLimit};";
		$res = $sqli->query($sql);
		if ($res->num_rows > 0)
		{
			while ($row = $res->fetch_assoc())
			{
				$arrTemp = array();
				foreach ($arrFields as $key => $val)
				{
					$arrTemp[$val] = $row[$val];
				}
				$arrData[$row['id']] = $arrTemp;
			}
		}
		closeMeUp($res);
		return $arrData;
	}
}

/************************************
 * Get marketplace item data...
 ************************************/
if (!function_exists('getMarketplaceData'))
{
	function getMarketplaceData($intID=0)
	{
		global $sqli;
		$arrData = array();
		$intID = $sqli->real_escape_string($intID);
		$arrFields = getTableFields(MARKETPLACE_TABLE);
		$sql = "SELECT ".implode(',', $arrFields).", UNIX_TIMESTAMP(`ts`) AS `updated` FROM ".MARKETPLACE_TABLE." WHERE `id`={$intID} LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		$row = $res->fetch_assoc();
		foreach ($arrFields as $key => $val)
		{
			$arrData[$val] = $row[$val];
		}
		$arrData['updated'] = $row['updated'];
		closeMeUp($res);
		return $arrData;
	}
}

/***************************************
 * Generate marketplace hash code...
 ***************************************/
if (!function_exists('generateMarketplaceHash'))
{
	function generateMarketplaceHash($intID=0)
	{
		global $sqli;
		$intID = $sqli->real_escape_string($intID);
		$property = toObject(getMarketplaceData($intID));
		if ($property->property_hash == '')
    	{
        	$intPropertyID = $property->id;
        	$strData = create_guid();
        	$sql = "UPDATE `".MARKETPLACE_TABLE."` SET `property_hash`='{$strData}' WHERE `id`={$intPropertyID} LIMIT 1;";
        	$res = $sqli->query($sql) or die($sqli->error);
        	closeMeUp($res);
    	}
		return;
	}
}

/***************************************
 * Get marketplace ID via hash...
 ***************************************/
if (!function_exists('getMarketplaceIDFromHash'))
{
	function getMarketplaceIDFromHash($strData='')
	{
		global $sqli;
		$intID = '';
		$strData = $sqli->real_escape_string($strData);
		$sql = "SELECT `id` FROM `".MARKETPLACE_TABLE."` WHERE `property_hash`='{$strData}' LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		$row = $res->fetch_assoc();
		$intID = $row['id'];
		closeMeUp($res);
		return $intID;
	}
}

/************************************
 * Get the marketplace name via ID...
 ************************************/
if (!function_exists('getMarketplaceName'))
{
	function getMarketplaceName($intID=0)
	{
		global $sqli;
		$strData = '';
		$intID = $sqli->real_escape_string($intID);
		$sql = "SELECT `property_name` FROM `".MARKETPLACE_TABLE."` WHERE `id`='{$intID}' LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		$row = $res->fetch_assoc();
		$strData = $row['property_name'];
		closeMeUp($res);
		return $strData;
	}
}

/************************************
 * Get a user's marketplace list...
 ************************************/
if (!function_exists('getUserMarketplaceDataList'))
{
	function getUserMarketplaceDataList($intID=0, $isAdmin=false)
	{
		global $sqli;
		$arrData = array();
		$intID = $sqli->real_escape_string($intID);
		$arrFields = getTableFields(MARKETPLACE_TABLE);
		if ($isAdmin == true)
		{
			$sqlSuffix = "";			
		} else {
			$sqlSuffix = "`user_id`={$intID} AND";
		}
		$sql = "SELECT ".implode(',', $arrFields).", UNIX_TIMESTAMP(`ts`) AS `updated` FROM `".MARKETPLACE_TABLE."` WHERE {$sqlSuffix} `status` != 86 ORDER BY `property_name`;";
		$res = $sqli->query($sql) or die($sqli->error);
		while ($row = $res->fetch_assoc())
		{
			$arrTemp = array();
			foreach ($arrFields as $key => $val)
			{
				$arrTemp[$val] = $row[$val];
			}
			$arrTemp['updated'] = $row['updated'];
			$arrData[$row['id']] = $arrTemp;
		}
		closeMeUp($res);
		return $arrData;
	}
}

/************************************
 * Add a new marketplace item...
 ************************************/
if (!function_exists('addMarketplaceData'))
{
	function addMarketplaceData($arrData=array())
	{
		global $sqli;
		$strSQL = "";
		$user = toObject($_SESSION['sys_user']);
		if (isset($arrData['is_admin']) && $arrData['is_admin'] == 1)
		{
			unset($arrData['user_id']);
		}

		foreach ($arrData as $key => $val)
		{
			if ($key != 'action' && $key != 'is_admin')
			{
				$val = $sqli->real_escape_string($val);
				$strSQL .= "`{$key}`='{$val}',";
			}
		}
		$strSQL = substr($strSQL, 0, strlen($strSQL) - 1);
		$sql = "INSERT INTO `".MARKETPLACE_TABLE."` SET {$strSQL};";
		$res = $sqli->query($sql) or die($sqli->error);
		$intLastID = $sqli->insert_id;
		closeMeUp($res);
		return $intLastID;
	}
}

/************************************
 * Save marketplace data...
 ************************************/
if (!function_exists('saveMarketplaceData'))
{
	function saveMarketplaceData($intID=0, $arrData)
	{
		global $sqli;
		$strSQL = "";
		$intID = $sqli->real_escape_string($intID);
		foreach ($arrData as $key => $val)
		{
			if ($key != 'id' && $key != 'action' && $key != 'btnSubmit' && $key != 'btnCancel')
			{
				$val = $sqli->real_escape_string($val);
				$strSQL .= "{$key}='{$val}',";
			}
		}
		$strSQL = substr($strSQL, 0, strlen($strSQL) - 1);
		$sql = "UPDATE `".MARKETPLACE_TABLE."` SET {$strSQL} WHERE `id`={$intID} LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		closeMeUp($res);
		return;
	}
}

/************************************
 * Delete a marketplace item...
 ************************************/
if (!function_exists('deleteMarketplaceData'))
{
	function deleteMarketplaceData($intID=0, $isRemoveUser=false)
	{
		global $sqli;
		$intID = $sqli->real_escape_string($intID);
		if ($isRemoveUser == true)
		{
			$sql = "UPDATE `".MARKETPLACE_TABLE."` SET `user_id`=0 WHERE `id`={$intID} LIMIT 1;";
		} else {
			$sql = "UPDATE `".MARKETPLACE_TABLE."` SET `status`=86 WHERE `id`={$intID} LIMIT 1;";
		}
		$res = $sqli->query($sql) or die($sqli->error);
		closeMeUp($res);
		return;
	}
}

/************************************
 * Upload file data (property)...
 ************************************/
if (!function_exists('processFileUploadProperty'))
{
	function processFileUploadProperty($arrData, $arrFileData, $intID=0)
	{
		global $sqli;
		if (count($arrFileData) > 0)
		{
			$data = toObject($arrData);
			if (isset($arrFileData['image_main']['name'][0]) && $arrFileData['image_main']['name'][0] != '')
			{
				if ($arrFileData['image_main']['error'][0] == '0')
				{
					$tmpFilename = $arrFileData['image_main']['tmp_name'][0];
					$strFilename = 'property-main-'.$intID.'-'.$arrFileData['image_main']['name'][0];
					@move_uploaded_file($tmpFilename, PROPERTY_IMAGE_BASE_PATH.$strFilename);

					// Update image filename in database...
					$sql = "UPDATE `".PROPERTY_TABLE."` SET `image_main`='{$strFilename}' WHERE `id`={$intID} LIMIT 1;";
					$res = $sqli->query($sql) or die($sqli->error);
					closeMeUp($res);
				}
			}

			if (isset($arrFileData['image_1']['name'][0]) && $arrFileData['image_1']['name'][0] != '')
			{
				if ($arrFileData['image_1']['error'][0] == '0')
				{
					$tmpFilename = $arrFileData['image_1']['tmp_name'][0];
					$strFilename = 'property-1-'.$intID.'-'.$arrFileData['image_1']['name'][0];
					@move_uploaded_file($tmpFilename, PROPERTY_IMAGE_BASE_PATH.$strFilename);

					// Update image filename in database...
					$sql = "UPDATE `".PROPERTY_TABLE."` SET `image_1`='{$strFilename}' WHERE `id`={$intID} LIMIT 1;";
					$res = $sqli->query($sql) or die($sqli->error);
					closeMeUp($res);
				}
			}

			if (isset($arrFileData['image_2']['name'][0]) && $arrFileData['image_2']['name'][0] != '')
			{
				if ($arrFileData['image_2']['error'][0] == '0')
				{
					$tmpFilename = $arrFileData['image_2']['tmp_name'][0];
					$strFilename = 'property-2-'.$intID.'-'.$arrFileData['image_2']['name'][0];
					@move_uploaded_file($tmpFilename, PROPERTY_IMAGE_BASE_PATH.$strFilename);

					// Update image filename in database...
					$sql = "UPDATE `".PROPERTY_TABLE."` SET `image_2`='{$strFilename}' WHERE `id`={$intID} LIMIT 1;";
					$res = $sqli->query($sql) or die($sqli->error);
					closeMeUp($res);
				}
			}

			if (isset($arrFileData['image_3']['name'][0]) && $arrFileData['image_3']['name'][0] != '')
			{
				if ($arrFileData['image_3']['error'][0] == '0')
				{
					$tmpFilename = $arrFileData['image_3']['tmp_name'][0];
					$strFilename = 'property-3-'.$intID.'-'.$arrFileData['image_3']['name'][0];
					@move_uploaded_file($tmpFilename, PROPERTY_IMAGE_BASE_PATH.$strFilename);

					// Update image filename in database...
					$sql = "UPDATE `".PROPERTY_TABLE."` SET `image_3`='{$strFilename}' WHERE `id`={$intID} LIMIT 1;";
					$res = $sqli->query($sql) or die($sqli->error);
					closeMeUp($res);
				}
			}

			if (isset($arrFileData['image_4']['name'][0]) && $arrFileData['image_4']['name'][0] != '')
			{
				if ($arrFileData['image_4']['error'][0] == '0')
				{
					$tmpFilename = $arrFileData['image_4']['tmp_name'][0];
					$strFilename = 'property-4-'.$intID.'-'.$arrFileData['image_4']['name'][0];
					@move_uploaded_file($tmpFilename, PROPERTY_IMAGE_BASE_PATH.$strFilename);

					// Update image filename in database...
					$sql = "UPDATE `".PROPERTY_TABLE."` SET `image_4`='{$strFilename}' WHERE `id`={$intID} LIMIT 1;";
					$res = $sqli->query($sql) or die($sqli->error);
					closeMeUp($res);
				}
			}
		}
		return;
	}
}

/************************************
 * Upload file data (marketplace)...
 ************************************/
if (!function_exists('processFileUploadMarketplace'))
{
	function processFileUploadMarketplace($arrData, $arrFileData, $intID=0)
	{
		global $sqli;
		if (count($arrFileData) > 0)
		{
			$data = toObject($arrData);

			if (isset($arrFileData['image_main']['name'][0]) && $arrFileData['image_main']['name'][0] != '')
			{
				if ($arrFileData['image_main']['error'][0] == '0')
				{
					$tmpFilename = $arrFileData['image_main']['tmp_name'][0];
					$strFilename = 'marketplace-main-'.$intID.'-'.$arrFileData['image_main']['name'][0];
					@move_uploaded_file($tmpFilename, MARKETPLACE_IMAGE_BASE_PATH.$strFilename);

					// Update image filename in database...
					$sql = "UPDATE `".MARKETPLACE_TABLE."` SET `image_main`='{$strFilename}' WHERE `id`={$intID} LIMIT 1;";
					$res = $sqli->query($sql) or die($sqli->error);
					closeMeUp($res);
				}
			}

			if (isset($arrFileData['image_1']['name'][0]) && $arrFileData['image_1']['name'][0] != '')
			{
				if ($arrFileData['image_1']['error'][0] == '0')
				{
					$tmpFilename = $arrFileData['image_1']['tmp_name'][0];
					$strFilename = 'marketplace-1-'.$intID.'-'.$arrFileData['image_1']['name'][0];
					@move_uploaded_file($tmpFilename, MARKETPLACE_IMAGE_BASE_PATH.$strFilename);

					// Update image filename in database...
					$sql = "UPDATE `".MARKETPLACE_TABLE."` SET `image_1`='{$strFilename}' WHERE `id`={$intID} LIMIT 1;";
					$res = $sqli->query($sql) or die($sqli->error);
					closeMeUp($res);
				}
			}

			if (isset($arrFileData['image_2']['name'][0]) && $arrFileData['image_2']['name'][0] != '')
			{
				if ($arrFileData['image_2']['error'][0] == '0')
				{
					$tmpFilename = $arrFileData['image_2']['tmp_name'][0];
					$strFilename = 'marketplace-2-'.$intID.'-'.$arrFileData['image_2']['name'][0];
					@move_uploaded_file($tmpFilename, MARKETPLACE_IMAGE_BASE_PATH.$strFilename);

					// Update image filename in database...
					$sql = "UPDATE `".MARKETPLACE_TABLE."` SET `image_2`='{$strFilename}' WHERE `id`={$intID} LIMIT 1;";
					$res = $sqli->query($sql) or die($sqli->error);
					closeMeUp($res);
				}
			}

			if (isset($arrFileData['image_3']['name'][0]) && $arrFileData['image_3']['name'][0] != '')
			{
				if ($arrFileData['image_3']['error'][0] == '0')
				{
					$tmpFilename = $arrFileData['image_3']['tmp_name'][0];
					$strFilename = 'marketplace-3-'.$intID.'-'.$arrFileData['image_3']['name'][0];
					@move_uploaded_file($tmpFilename, MARKETPLACE_IMAGE_BASE_PATH.$strFilename);

					// Update image filename in database...
					$sql = "UPDATE `".MARKETPLACE_TABLE."` SET `image_3`='{$strFilename}' WHERE `id`={$intID} LIMIT 1;";
					$res = $sqli->query($sql) or die($sqli->error);
					closeMeUp($res);
				}
			}

			if (isset($arrFileData['image_4']['name'][0]) && $arrFileData['image_4']['name'][0] != '')
			{
				if ($arrFileData['image_4']['error'][0] == '0')
				{
					$tmpFilename = $arrFileData['image_4']['tmp_name'][0];
					$strFilename = 'marketplace-4-'.$intID.'-'.$arrFileData['image_4']['name'][0];
					@move_uploaded_file($tmpFilename, MARKETPLACE_IMAGE_BASE_PATH.$strFilename);

					// Update image filename in database...
					$sql = "UPDATE `".MARKETPLACE_TABLE."` SET `image_4`='{$strFilename}' WHERE `id`={$intID} LIMIT 1;";
					$res = $sqli->query($sql) or die($sqli->error);
					closeMeUp($res);
				}
			}
		}
		return;
	}
}

/*************************************
 * Upload file data (advertisement)...
 *************************************/
if (!function_exists('processFileUploadAdvertisement'))
{
	function processFileUploadAdvertisement($arrData, $arrFileData, $intID=0)
	{
		global $sqli;
		if (count($arrFileData) > 0)
		{
			$data = toObject($arrData);

			if (isset($arrFileData['image_main']['name'][0]) && $arrFileData['image_main']['name'][0] != '')
			{
				if ($arrFileData['image_main']['error'][0] == '0')
				{
					$tmpFilename = $arrFileData['image_main']['tmp_name'][0];
					$strFilename = 'advertisement-main-'.$intID.'-'.$arrFileData['image_main']['name'][0];
					@move_uploaded_file($tmpFilename, AD_IMAGE_BASE_PATH.$strFilename);

					// Update image filename in database...
					$sql = "UPDATE `".ADVERTISEMENT_TABLE."` SET `image_main`='{$strFilename}' WHERE `id`={$intID} LIMIT 1;";
					$res = $sqli->query($sql) or die($sqli->error);
					closeMeUp($res);
				}
			}
		}
		return;
	}
}

/*************************************
 * Upload file data (event)...
 *************************************/
if (!function_exists('processFileUploadEvent'))
{
	function processFileUploadEvent($arrData, $arrFileData, $intID=0)
	{
		global $sqli;
		if (count($arrFileData) > 0)
		{
			$data = toObject($arrData);

			if (isset($arrFileData['event_image']['name'][0]) && $arrFileData['event_image']['name'][0] != '')
			{
				if ($arrFileData['event_image']['error'][0] == '0')
				{
					$tmpFilename = $arrFileData['event_image']['tmp_name'][0];
					$strFilename = 'advertisement-main-'.$intID.'-'.$arrFileData['event_image']['name'][0];
					@move_uploaded_file($tmpFilename, EVENT_IMAGE_BASE_PATH.$strFilename);

					// Update image filename in database...
					$sql = "UPDATE `".EVENT_TABLE."` SET `event_image`='{$strFilename}' WHERE `id`={$intID} LIMIT 1;";
					$res = $sqli->query($sql) or die($sqli->error);
					closeMeUp($res);
				}
			}
		}
		return;
	}
}

/*************************************
 * Upload file data (jokes)...
 *************************************/
if (!function_exists('processFileUploadJoke'))
{
	function processFileUploadJoke($arrData, $arrFileData, $intID=0)
	{
		global $sqli;
		if (count($arrFileData) > 0)
		{
			$data = toObject($arrData);

			if (isset($arrFileData['image_main']['name'][0]) && $arrFileData['image_main']['name'][0] != '')
			{
				if ($arrFileData['image_main']['error'][0] == '0')
				{
					$tmpFilename = $arrFileData['image_main']['tmp_name'][0];
					$strFilename = 'joke-main-'.$intID.'-'.$arrFileData['image_main']['name'][0];
					@move_uploaded_file($tmpFilename, JOKE_IMAGE_BASE_PATH.$strFilename);

					// Update image filename in database...
					$sql = "UPDATE `".JOKE_TABLE."` SET `image_main`='{$strFilename}' WHERE `id`={$intID} LIMIT 1;";
					$res = $sqli->query($sql) or die($sqli->error);
					closeMeUp($res);
				}
			}
		}
		return;
	}
}

/************************************
 * Generate list of reviews...
 ************************************/
if (!function_exists('generateReviews'))
{
	function generateReviews($intPropertyID=0, $intLimit=100)
	{
		global $sqli;
		$arrData = array();
		$intPropertyID = $sqli->real_escape_string($intPropertyID);
		$intLimit = $sqli->real_escape_string($intLimit);
		$arrFields = getTableFields(REVIEW_TABLE);
		$sql = "SELECT ".implode(',', $arrFields).", UNIX_TIMESTAMP(`ts`) AS `updated` FROM `".REVIEW_TABLE."` WHERE `status`!=86 AND `property_id`={$intPropertyID} LIMIT {$intLimit};";
		$res = $sqli->query($sql);
		while ($row = $res->fetch_assoc())
		{
			$arrTemp = array();
			foreach ($arrFields as $key => $val)
			{
				$arrTemp[$val] = $row[$val];
			}
			$arrTemp['updated'] = $row['updated'];
			$arrData[$row['id']] = $arrTemp;
		}
		closeMeUp($res);
		return $arrData;
	}
}

/************************************
 * Get review data...
 ************************************/
if (!function_exists('getRevieweData'))
{
	function getReviewData($intID=0)
	{
		global $sqli;
		$arrData = array();
		$intID = $sqli->real_escape_string($intID);
		$arrFields = getTableFields(REVIEW_TABLE);
		$sql = "SELECT ".implode(',', $arrFields).", UNIX_TIMESTAMP(`ts`) AS `updated` FROM `".REVIEW_TABLE."` WHERE `id`={$intID} LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		$row = $res->fetch_assoc();
		foreach ($arrFields as $key => $val)
		{
			$arrData[$val] = $row[$val];
		}
		$arrData['updated'] = $row['updated'];
		closeMeUp($res);
		return $arrData;
	}
}

/************************************
 * Add a new review...
 ************************************/
if (!function_exists('addReviewData'))
{
	function addReviewData($arrData=array())
	{
		global $sqli;
		$strSQL = "";
		foreach ($arrData as $key => $val)
		{
			if ($key != 'action' && $key != 'is_admin')
			{
				$val = $sqli->real_escape_string($val);
				$strSQL .= "`{$key}`='{$val}',";
			}
		}
		$strSQL = substr($strSQL, 0, strlen($strSQL) - 1);
		$sql = "INSERT INTO `".REVIEW_TABLE."` SET {$strSQL};";
		$res = $sqli->query($sql) or die($sqli->error);
		$intLastID = $sqli->insert_id;
		closeMeUp($res);
		return $intLastID;
	}
}

/************************************
 * Save review data...
 ************************************/
if (!function_exists('saveReviewData'))
{
	function saveReviewData($intID=0, $arrData)
	{
		global $sqli;
		$strSQL = "";
		$intID = $sqli->real_escape_string($intID);
		foreach ($arrData as $key => $val)
		{
			if ($key != 'id' && $key != 'action' && $key != 'btnSubmit' && $key != 'btnCancel')
			{
				$val = $sqli->real_escape_string($val);
				$strSQL .= "{$key}='{$val}',";
			}
		}
		$strSQL = substr($strSQL, 0, strlen($strSQL) - 1);
		$sql = "UPDATE `".REVIEW_TABLE."` SET {$strSQL} WHERE `id`={$intID} LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		closeMeUp($res);
		return;
	}
}

/************************************
 * Delete a review...
 ************************************/
if (!function_exists('deleteReviewData'))
{
	function deleteReviewData($intID=0)
	{
		global $sqli;
		$intID = $sqli->real_escape_string($intID);
		$sql = "UPDATE `".REVIEW_TABLE."` SET `status`=86 WHERE `id`={$intID} LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		closeMeUp($res);
		return;
	}
}

/************************************
 * Generate mailer data...
 ************************************/
if (!function_exists('generateMailerData'))
{
	function generateMailerData($arrFields, $intLimit=5000, $strCategory='')
	{
		global $sqli;
		$arrData = array();
		$intLimit = $sqli->real_escape_string($intLimit);
		$strCategory = $sqli->real_escape_string($strCategory);
		$sql = "SELECT `site_property_categories`.`category`,`site_properties`.`id`,`site_properties`.`property_name`,`site_properties`.`property_address`,`site_properties`.`property_city`,`site_properties`.`property_state`,`site_properties`.`property_zipcode`,`site_properties`.`property_phone`,`site_properties`.`property_website` FROM `site_properties` LEFT JOIN `site_property_categories` ON `site_property_categories`.`id` = `site_properties`.`category_id` ORDER BY `site_property_categories`.`category` LIMIT {$intLimit};";
		$res = $sqli->query($sql);
		while ($row = $res->fetch_assoc())
		{
			$arrTemp = array();
			foreach ($arrFields as $key => $val)
			{
				$arrTemp[$val] = $row[$val];
			}
			$arrData[$row['id']] = $arrTemp;
		}
		closeMeUp($res);
		return $arrData;
	}
}

/**************************************
 * Generate mailer registration data...
 **************************************/
if (!function_exists('generateMailerRegistrationData'))
{
	function generateMailerRegistrationData($arrFields, $intLimit=5000)
	{
		global $sqli;
		$arrData = array();
		$intLimit = $sqli->real_escape_string($intLimit);
		$sql = "SELECT ".implode(',', $arrFields)." FROM `site_users` ORDER BY `id` LIMIT {$intLimit};";
		$res = $sqli->query($sql);
		while ($row = $res->fetch_assoc())
		{
			$arrTemp = array();
			foreach ($arrFields as $key => $val)
			{
				$arrTemp[$val] = $row[$val];
			}
			$arrData[$row['id']] = $arrTemp;
		}
		closeMeUp($res);
		return $arrData;
	}
}

/************************************
 * Generate mailer subscriber data...
 ************************************/
if (!function_exists('generateMailerSubscriberData'))
{
	function generateMailerSubscriberData($arrFields, $intLimit=5000)
	{
		global $sqli;
		$arrData = array();
		$intLimit = $sqli->real_escape_string($intLimit);
		$sql = "SELECT ".implode(',', $arrFields)." FROM `site_subscribers` ORDER BY `id` LIMIT {$intLimit};";
		$res = $sqli->query($sql);
		while ($row = $res->fetch_assoc())
		{
			$arrTemp = array();
			foreach ($arrFields as $key => $val)
			{
				$arrTemp[$val] = $row[$val];
			}
			$arrData[$row['id']] = $arrTemp;
		}
		closeMeUp($res);
		return $arrData;
	}
}

/************************************
 * Generate list of advertisements...
 ************************************/
if (!function_exists('generateAdvertisements'))
{
	function generateAdvertisements($intType=0, $isAll=true, $intLimit=100)
	{
		global $sqli;
		$arrData = array();
		$intType = $sqli->real_escape_string($intType);
		$intLimit = $sqli->real_escape_string($intLimit);
		if ($isAll == true)
		{
			$sqlSuffix = '';
		} else {
			$sqlSuffix = " AND `ad_type`={$intType}";
		}
		$arrFields = getTableFields(ADVERTISEMENT_TABLE);
		$sql = "SELECT ".implode(',', $arrFields).", UNIX_TIMESTAMP(`ts`) AS `updated` FROM `".ADVERTISEMENT_TABLE."` WHERE `status`!=86 {$sqlSuffix} ORDER BY `id` LIMIT {$intLimit};";
		$res = $sqli->query($sql);
		while ($row = $res->fetch_assoc())
		{
			$arrTemp = array();
			foreach ($arrFields as $key => $val)
			{
				$arrTemp[$val] = $row[$val];
			}
			$arrTemp['updated'] = $row['updated'];
			$arrData[$row['id']] = $arrTemp;
		}
		closeMeUp($res);
		return $arrData;
	}
}

/************************************
 * Get advertisement data...
 ************************************/
if (!function_exists('getAdvertisementData'))
{
	function getAdvertisementData($intID=0)
	{
		global $sqli;
		$arrData = array();
		$intID = $sqli->real_escape_string($intID);
		$arrFields = getTableFields(ADVERTISEMENT_TABLE);
		$sql = "SELECT ".implode(',', $arrFields).", UNIX_TIMESTAMP(`ts`) AS `updated` FROM ".ADVERTISEMENT_TABLE." WHERE `id`={$intID} LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		$row = $res->fetch_assoc();
		foreach ($arrFields as $key => $val)
		{
			$arrData[$val] = $row[$val];
		}
		$arrData['updated'] = $row['updated'];
		closeMeUp($res);
		return $arrData;
	}
}

/************************************
 * Add a new advertisement item...
 ************************************/
if (!function_exists('addAdvertisementData'))
{
	function addAdvertisementData($arrData=array())
	{
		global $sqli;
		$strSQL = "";
		$user = toObject($_SESSION['sys_user']);
		if (isset($arrData['is_admin']) && $arrData['is_admin'] == 1)
		{
			unset($arrData['user_id']);
		}

		foreach ($arrData as $key => $val)
		{
			if ($key != 'action' && $key != 'is_admin' && $key != 'image_main')
			{
				$val = $sqli->real_escape_string($val);
				$strSQL .= "`{$key}`='{$val}',";
			}
		}
		$strSQL = substr($strSQL, 0, strlen($strSQL) - 1);
		$sql = "INSERT INTO `".ADVERTISEMENT_TABLE."` SET {$strSQL};";
		$res = $sqli->query($sql) or die($sqli->error);
		$intLastID = $sqli->insert_id;
		closeMeUp($res);
		return $intLastID;
	}
}

/************************************
 * Save advertisement data...
 ************************************/
if (!function_exists('saveAdvertisementData'))
{
	function saveAdvertisementData($intID=0, $arrData)
	{
		global $sqli;
		$strSQL = "";
		$intID = $sqli->real_escape_string($intID);
		foreach ($arrData as $key => $val)
		{
			if ($key != 'id' && $key != 'action' && $key != 'btnSubmit' && $key != 'btnCancel' && $key != 'image_main')
			{
				$val = $sqli->real_escape_string($val);
				$strSQL .= "{$key}='{$val}',";
			}
		}
		$strSQL = substr($strSQL, 0, strlen($strSQL) - 1);
		$sql = "UPDATE `".ADVERTISEMENT_TABLE."` SET {$strSQL} WHERE `id`={$intID} LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		closeMeUp($res);
		return;
	}
}

/************************************
 * Delete a advertisement item...
 ************************************/
if (!function_exists('deleteAdvertisementData'))
{
	function deleteAdvertisementData($intID=0, $isRemoveUser=false)
	{
		global $sqli;
		$intID = $sqli->real_escape_string($intID);
		if ($isRemoveUser == true)
		{
			$sql = "UPDATE `".ADVERTISEMENT_TABLE."` SET `user_id`=0 WHERE `id`={$intID} LIMIT 1;";
		} else {
			$sql = "UPDATE `".ADVERTISEMENT_TABLE."` SET `status`=86 WHERE `id`={$intID} LIMIT 1;";
		}
		$res = $sqli->query($sql) or die($sqli->error);
		closeMeUp($res);
		return;
	}
}

/************************************
 * Generate list of jokes...
 ************************************/
if (!function_exists('generateJokes'))
{
	function generateJokes($isAll=false, $intType=0, $intLimit=100)
	{
		global $sqli;
		$arrData = array();
		$intLimit = $sqli->real_escape_string($intLimit);
		$intType = $sqli->real_escape_string($intType);
		$arrFields = getTableFields(JOKE_TABLE);
		if ($isAll == true)
		{
			$sqlSuffix = '';
		} else {
			$sqlSuffix = "AND `content_type`={$intType}";
		}
		$sql = "SELECT ".implode(',', $arrFields).", UNIX_TIMESTAMP(`ts`) AS `updated` FROM `".JOKE_TABLE."` WHERE `status`!=86 {$sqlSuffix} ORDER BY `id` LIMIT {$intLimit};";
		$res = $sqli->query($sql);
		while ($row = $res->fetch_assoc())
		{
			$arrTemp = array();
			foreach ($arrFields as $key => $val)
			{
				$arrTemp[$val] = $row[$val];
			}
			$arrTemp['updated'] = $row['updated'];
			$arrData[$row['id']] = $arrTemp;
		}
		closeMeUp($res);
		return $arrData;
	}
}

/************************************
 * Get joke data...
 ************************************/
if (!function_exists('getJokeData'))
{
	function getJokeData($intID=0)
	{
		global $sqli;
		$arrData = array();
		$intID = $sqli->real_escape_string($intID);
		$arrFields = getTableFields(JOKE_TABLE);
		$sql = "SELECT ".implode(',', $arrFields).", UNIX_TIMESTAMP(`ts`) AS `updated` FROM ".JOKE_TABLE." WHERE `id`={$intID} LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		$row = $res->fetch_assoc();
		foreach ($arrFields as $key => $val)
		{
			$arrData[$val] = $row[$val];
		}
		$arrData['updated'] = $row['updated'];
		closeMeUp($res);
		return $arrData;
	}
}

/************************************
 * Add a new joke item...
 ************************************/
if (!function_exists('addJokeData'))
{
	function addJokeData($arrData=array())
	{
		global $sqli;
		$strSQL = "";
		foreach ($arrData as $key => $val)
		{
			if ($key != 'action' && $key != 'is_admin' && $key != 'image_main')
			{
				$val = $sqli->real_escape_string($val);
				$strSQL .= "`{$key}`='{$val}',";
			}
		}
		$strSQL = substr($strSQL, 0, strlen($strSQL) - 1);
		$sql = "INSERT INTO `".JOKE_TABLE."` SET {$strSQL};";
		$res = $sqli->query($sql) or die($sqli->error);
		$intLastID = $sqli->insert_id;
		closeMeUp($res);
		return $intLastID;
	}
}

/************************************
 * Save joke data...
 ************************************/
if (!function_exists('saveJokeData'))
{
	function saveJokeData($intID=0, $arrData)
	{
		global $sqli;
		$strSQL = "";
		$intID = $sqli->real_escape_string($intID);
		foreach ($arrData as $key => $val)
		{
			if ($key != 'id' && $key != 'action' && $key != 'btnSubmit' && $key != 'btnCancel' && $key != 'image_main')
			{
				$val = $sqli->real_escape_string($val);
				$strSQL .= "{$key}='{$val}',";
			}
		}
		$strSQL = substr($strSQL, 0, strlen($strSQL) - 1);
		$sql = "UPDATE `".JOKE_TABLE."` SET {$strSQL} WHERE `id`={$intID} LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		closeMeUp($res);
		return;
	}
}

/************************************
 * Delete a joke item...
 ************************************/
if (!function_exists('deleteJokeData'))
{
	function deleteJokeData($intID=0)
	{
		global $sqli;
		$intID = $sqli->real_escape_string($intID);
		$sql = "UPDATE `".JOKE_TABLE."` SET `status`=86 WHERE `id`={$intID} LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		closeMeUp($res);
		return;
	}
}

/************************************
 * Generate list of bookings...
 ************************************/
if (!function_exists('generateBookings'))
{
	function generateBookings($intPropertyID=0, $isMultiple=false, $arrPropertyIDs=array(), $intLimit=500)
	{
		global $sqli;
		$arrData = array();
		$intPropertyID = $sqli->real_escape_string($intPropertyID);
		$intLimit = $sqli->real_escape_string($intLimit);
		if ($isMultiple == true)
		{
			if (!empty($arrPropertyIDs))
			{
				$strProperties = implode(',', $arrPropertyIDs);
				$sqlSuffix = "AND `property_id` IN(".$strProperties.")";
			} else {
				$sqlSuffix = "AND `property_id`=0";
			}
		} else {
			$sqlSuffix = "AND `property_id`={$intPropertyID}";
		}
		$arrFields = getTableFields(BOOKING_TABLE);
		$sql = "SELECT ".implode(',', $arrFields).", UNIX_TIMESTAMP(`ts`) AS `updated` FROM `".BOOKING_TABLE."` WHERE `status`!=86 {$sqlSuffix} LIMIT {$intLimit};";
		$res = $sqli->query($sql);
		while ($row = $res->fetch_assoc())
		{
			$arrTemp = array();
			foreach ($arrFields as $key => $val)
			{
				$arrTemp[$val] = $row[$val];
			}
			$arrTemp['updated'] = $row['updated'];
			$arrData[$row['id']] = $arrTemp;
		}
		closeMeUp($res);
		return $arrData;
	}
}

/************************************
 * Get booking data...
 ************************************/
if (!function_exists('getBookingData'))
{
	function getBookingData($intID=0)
	{
		global $sqli;
		$arrData = array();
		$intID = $sqli->real_escape_string($intID);
		$arrFields = getTableFields(BOOKING_TABLE);
		$sql = "SELECT ".implode(',', $arrFields).", UNIX_TIMESTAMP(`ts`) AS `updated` FROM `".BOOKING_TABLE."` WHERE `id`={$intID} LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		$row = $res->fetch_assoc();
		foreach ($arrFields as $key => $val)
		{
			$arrData[$val] = $row[$val];
		}
		$arrData['updated'] = $row['updated'];
		closeMeUp($res);
		return $arrData;
	}
}

/************************************
 * Add a new booking...
 ************************************/
if (!function_exists('addBookingData'))
{
	function addBookingData($arrData=array())
	{
		global $sqli;
		$strSQL = "";
		foreach ($arrData as $key => $val)
		{
			if ($key != 'action' && $key != 'is_admin')
			{
				$val = $sqli->real_escape_string($val);
				$strSQL .= "`{$key}`='{$val}',";
			}
		}
		$strSQL = substr($strSQL, 0, strlen($strSQL) - 1);
		$sql = "INSERT INTO `".BOOKING_TABLE."` SET {$strSQL};";
		$res = $sqli->query($sql) or die($sqli->error);
		$intLastID = $sqli->insert_id;
		closeMeUp($res);
		return $intLastID;
	}
}

/************************************
 * Save booking data...
 ************************************/
if (!function_exists('saveBookingData'))
{
	function saveBookingData($intID=0, $arrData)
	{
		global $sqli;
		$strSQL = "";
		$intID = $sqli->real_escape_string($intID);
		foreach ($arrData as $key => $val)
		{
			if ($key != 'id' && $key != 'action' && $key != 'btnSubmit' && $key != 'btnCancel')
			{
				$val = $sqli->real_escape_string($val);
				$strSQL .= "{$key}='{$val}',";
			}
		}
		$strSQL = substr($strSQL, 0, strlen($strSQL) - 1);
		$sql = "UPDATE `".BOOKING_TABLE."` SET {$strSQL} WHERE `id`={$intID} LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		closeMeUp($res);
		return;
	}
}

/************************************
 * Delete a booking...
 ************************************/
if (!function_exists('deleteBookingData'))
{
	function deleteBookingData($intID=0)
	{
		global $sqli;
		$intID = $sqli->real_escape_string($intID);
		$sql = "UPDATE `".BOOKING_TABLE."` SET `status`=86 WHERE `id`={$intID} LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		closeMeUp($res);
		return;
	}
}

/************************************
 * Confirm a booking...
 ************************************/
if (!function_exists('confirmBooking'))
{
	function confirmBooking($intID=0)
	{
		global $sqli;
		$intID = $sqli->real_escape_string($intID);
		$sql = "UPDATE `".BOOKING_TABLE."` SET `booking_approved`=1 WHERE `id`={$intID} LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		closeMeUp($res);
		return;
	}
}
?>