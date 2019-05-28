<?php
/*****************************************************
* Created by: Randy S. Baker
* Created on: 03-APR-2018
* ----------------------------------------------------
* Helper Functions (functions.helper.php)
******************************************************/

/************************************
 * Environment setup...
 ************************************/
if (!is_resource($sqli))
{
	$sqli = connectToDB($arrConnect);
}

/*************************************************
 * Generate raw timezone data...
 *************************************************/
$arrRawTimezones = DateTimeZone::listIdentifiers();

/*************************************************
 * Array(s) of string values to replace...
 *************************************************/
$arrFind = array('-', '/', '.');
$arrReplace = array(' ', ' ', ' ');

/************************************
 * Connect to the database...
 ************************************/
function connectToDB($arrConnect)
{
	global $sqli;
	$sqli = new mysqli($arrConnect['db_host'], $arrConnect['db_user'], $arrConnect['db_pass'], $arrConnect['db_name']);
	if ($sqli->connect_error) 
	{
		die('Connection failed: '. mysqli_connect_error());
	}
	return $sqli;
}

/*************************************************
 * Generate the image types...
 *************************************************/
if(!function_exists('buildImageTypes'))
{
	function buildImageTypes()
	{
		$arrData = array();
		$arrData[] = 'image/bmp';
		$arrData[] = 'image/x-windows-bmp';
		$arrData[] = 'image/jpg';
		$arrData[] = 'image/jpeg';
		$arrData[] = 'image/pjpeg';
		$arrData[] = 'image/gif';
		$arrData[] = 'image/png';
		$arrData[] = 'image/x-png';
		return $arrData;
	}
}

/*************************************************
 * Generate the months...
 *************************************************/
if(!function_exists('buildMonths'))
{
	function buildMonths()
	{
		$arrMonths = array();
		$arrMonths['01'] = 'January';
		$arrMonths['02'] = 'February';
		$arrMonths['03'] = 'March';
		$arrMonths['04'] = 'April';
		$arrMonths['05'] = 'May';
		$arrMonths['06'] = 'June';
		$arrMonths['07'] = 'July';
		$arrMonths['08'] = 'August';
		$arrMonths['09'] = 'September';
		$arrMonths['10'] = 'October';
		$arrMonths['11'] = 'November';
		$arrMonths['12'] = 'December';
		return $arrMonths;
	}
}

/*************************************************
 * Generate years...
 *************************************************/
if(!function_exists('buildYears'))
{
	function buildYears()
	{
		$tmpYear1 = date('Y');
		$tmpYear2 = $tmpYear1 + 10;
		$arrYears = range($tmpYear1, $tmpYear2);
		return $arrYears;
	}
}

/************************************
 * Friendly view of an array...
 ************************************/
if (!function_exists('showDebug'))
{
	function showDebug($arrData, $strTitle='', $isDead=false)
	{
		echo '<hr><b>'. strtoupper($strTitle) .':</b><br /><pre>';
		print_r($arrData);
		echo '</pre><hr>';
		if ($isDead === true)
		{
			breakpoint('Checkpoint...');
		}
		return;
	}
}

/************************************
 * Temporarily halt the script...
 ************************************/
if (!function_exists('breakpoint'))
{
	function breakpoint($strData='Checkpoint...')
	{
		die($strData);
	}
}

/************************************
 * Friendly redirect...
 ************************************/
if (!function_exists('doRedirect'))
{
	function doRedirect($strLocation)
	{
		echo "<script>\n";
		echo "  location.href='$strLocation';\n";
		echo "</script>\n";
		return;
	}
}

/************************************
 * Friendly alert...
 ************************************/
if (!function_exists('showAlert'))
{
	function showAlert($strAlert)
	{
		echo "<script>\n";
		echo "  alert('$strAlert');\n";
		echo "</script>\n";
		return;
	}
}

/************************************
 * Return specified word count...
 ************************************/
if (!function_exists('cutParagraph'))
{
	function cutParagraph($strParagraph, $limit=80)
	{
		$strParagraph = strip_tags($strParagraph);
		$arrWords = str_word_count($strParagraph, 2);
		$tmpWords = array_slice($arrWords, 0, $limit, true);
		$strMaxPos = @max(array_keys($tmpWords));
		return substr($strParagraph, 0, $strMaxPos) .'...';
	}
}

/************************************
 * Return specified string count...
 ************************************/
if (!function_exists('cutString'))
{
	function cutString($strData, $intLength=13, $strDots='...')
	{
    	return (strlen($strData) > $intLength) ? substr($strData, 0, $intLength - strlen($strDots)) . $strDots : $strData;
	}
}

/******************************************
 * Generate page URL...
 ******************************************/
if (!function_exists('generateDisplayURL'))
{
	function generateDisplayURL($strURL)
	{
		$arrFind = array(' ', ',', '.', '/', '\\', '"', "'", '?', '!', ':');
		$arrReplace = array('-', '', '', '', '', '', '', '', '', '');
		$strURL = strtolower(trim($strURL));
		$strURL = str_replace($arrFind, $arrReplace, $strURL);
		return $strURL;
	}
}

/******************************************
 * Generate SEO URL...
 ******************************************/
if (!function_exists('generateSEOURL'))
{
	function generateSEOURL($strURL)
	{
		$arrFind = array(' ', ',', '.', '"', "'", '?', '!','&');
		$arrReplace = array('-', '', '', '', '', '', '','and');
		$strURL = strtolower(trim($strURL));
		$strURL = str_replace($arrFind, $arrReplace, $strURL);
		return $strURL;
	}
}

/******************************************
 * Generate displayed text format...
 ******************************************/
if (!function_exists('generateProperString'))
{
	function generateProperString($strData)
	{
		$arrFind = array('-');
		$arrReplace = array(' ');
		$strData = str_replace($arrFind, $arrReplace, $strData);
		$strData = ucwords(strtolower(trim($strData)));
		return $strData;
	}
}

/***************************************
 * Clean up the URL...
***************************************/
if (!function_exists('cleanURL'))
{
	function cleanURL($strURL)
	{
		$arrSearch = array('http', ':', '//', 'www.');
		$arrReplace = array('', '', '', '');
		$strURL = str_replace($arrSearch, $arrReplace, $strURL);
		return $strURL;
	}
}

/***************************************
 * Parse to XML...
***************************************/
if (!function_exists('parseToXML'))
{
	function parseToXML($htmlStr)
	{
		$xmlStr = str_replace('<', '&lt;', $htmlStr);
		$xmlStr = str_replace('>', '&gt;', $xmlStr);
		$xmlStr = str_replace('"', '&quot;', $xmlStr);
		$xmlStr = str_replace("'", '&#39;', $xmlStr);
		$xmlStr = str_replace("&", '&amp;', $xmlStr);
		return $xmlStr;
	}
}

/***************************************
 * Sanitize Data...
***************************************/
if (!function_exists('sanitizeData'))
{
	function sanitizeData($strData='', $strFind='', $strReplace='')
	{
		if ($strData != '')
		{
			$strData = str_replace($strFind, $strReplace, $strData);
		}
		return $strData;
	}
}

/************************************
 * Get the microtime...
 ************************************/
function getmicrotime()
{ 
    list($usec, $sec) = explode(' ', microtime()); 
    return ((float)$usec + (float)$sec); 
}

/************************************
 * Make sure GUID is valid...
 ************************************/
if (!function_exists('is_guid'))
{
	function is_guid($guid)
	{
		if (strlen($guid) != 36)
		{
			return false;
		}
		
		if (preg_match("/\w{8}-\w{4}-\w{4}-\w{4}-\w{12}/i", $guid)) 
		{
			return true;
		}
		return true;
	}
}

/************************************
 * Create a unique GUID...
 ************************************/
if (!function_exists('create_guid'))
{
	function create_guid()
	{
		$microTime = microtime();
		list($a_dec, $a_sec) = explode(" ", $microTime);
		$dec_hex = sprintf("%x", $a_dec* 1000000);
		$sec_hex = sprintf("%x", $a_sec);
		ensure_length($dec_hex, 5);
		ensure_length($sec_hex, 6);
		$guid  = "";
		$guid .= $dec_hex;
		$guid .= create_guid_section(3);
		$guid .= '-';
		$guid .= create_guid_section(4);
		$guid .= '-';
		$guid .= create_guid_section(4);
		$guid .= '-';
		$guid .= create_guid_section(4);
		$guid .= '-';
		$guid .= $sec_hex;
		$guid .= create_guid_section(6);
		return $guid;
	}
}

/************************************
 * Create base GUID component(s)...
 ************************************/
if (!function_exists('create_guid_section'))
{
	function create_guid_section($characters)
	{
		$return = "";
		for ($i = 0; $i < $characters; $i++)
		{
			$return .= sprintf("%x", mt_rand(0,15));
		}
		return $return;
	}
}

/************************************
 * Ensure string length is valid...
 ************************************/
if (!function_exists('ensure_length'))
{
	function ensure_length(&$string, $length)
	{
		$strlen = strlen($string);
		if ($strlen < $length)
		{
			$string = str_pad($string, $length, "0");
		} else if ($strlen > $length) {
			$string = substr($string, 0, $length);
		}
		return;
	}
}

/************************************
 * Calculate the time difference...
 ************************************/
if (!function_exists('microtime_diff'))
{
	function microtime_diff($a, $b)
	{
		list($a_dec, $a_sec) = explode(" ", $a);
		list($b_dec, $b_sec) = explode(" ", $b);
		return $b_sec - $a_sec + $b_dec - $a_dec;
	}
}

/************************************
 * Free the MySQL resource...
 ************************************/
if (!function_exists('closeMeUp'))
{
	function closeMeUp($strRes)
	{
		if (is_resource($strRes))
		{
			$strRes->close();
		}
		return;
	}
}

/************************************
 * Reset the MySQL resource...
 ************************************/
if (!function_exists('resetMe'))
{
	function resetMe($strRes)
	{
		if (is_object($strRes))
		{
			$strRes->reset();
			$strRes->close();
		}
		return;
	}
}

/******************************************
 * Create an array of dates...
 ******************************************/
if (!function_exists('createDatesArray'))
{
	function createDatesArray($numDays)
	{
		$arrDates = array();
		$month = date('m');
		$day = date('d');
        $year = date('Y');
        for ($i = 1; $i <= $numDays; $i++)
        {
            $arrDates[] = date('Y-m-d', mktime(0, 0, 0, $month, ($day - $i), $year));
        }
        return $arrDates;
   }
}

/******************************************
 * Create an array of dates (unix)...
 ******************************************/
if (!function_exists('createDatesArrayRaw'))
{
	function createDatesArrayRaw($numDays)
	{
		$arrDates = array();
		$month = date('m');
		$day = date('d');
        $year = date('Y');
        for ($i = 1; $i <= $numDays; $i++)
        {
       		$tmpStart = mktime(1, 0, 0, $month, ($day - $i), $year);
       		$tmpStop = mktime(23, 59, 0, $month, ($day - $i), $year);
            $arrDates[$tmpStart] = $tmpStop;
        }
        return $arrDates;
    }
}

/************************************
 * Convert array to an object...
 ************************************/
if (!function_exists('toObject'))
{
	function toObject($arrData)
	{
		$objObject = json_decode(json_encode($arrData), false);
		return $objObject;
	}
}

/************************************
 * Convert array to an object...
 ************************************/
if (!function_exists('arrayToObject'))
{
	function arrayToObject($arrData)
	{
		$arrObject = array();
		$objObject = (object) $arrObject;
		if (is_array($arrData) && count($arrData) > 0)
		{
			foreach ($arrData as $key => $val)
			{
				$key = strtolower(trim($key));
				if (!empty($key))
				{
					$objObject->$key = $val;
				}
			}
		}
		return $objObject;
	}
}
	
/************************************
 * Convert object to an array...
 ************************************/
if (!function_exists('objectToArray'))
{
	function objectToArray($objObject)
	{
		$arrData = array();
		if (is_object($objObject))
		{
			$arrData = get_object_vars($objObject);
		}
		return $arrData;
	}
}

/******************************************
 * Get the database tables...
 ******************************************/
if (!function_exists('getTables'))
{
	function getTables($strDatabase)
	{
		global $sqli;
		$arrTables = array();
		$sql = "SHOW TABLES FROM `{$strDatabase}`;";
		$res = $sqli->query($sql) or die($sqli->error);
		while ($row = $res->fetch_assoc())
		{
			$arrTables[] = $row['Tables_in_'.$strDatabase];
		}
		closeMeUp($res);
		return $arrTables;
	}
}

/******************************************
 * Get the table column definitions...
 ******************************************/
if (!function_exists('getTableFields'))
{
	function getTableFields($strTable)
	{
		global $sqli;
		$arrFields = array();
		$sql = "SHOW COLUMNS FROM `{$strTable}`;";
		$res = $sqli->query($sql) or die($sqli->error);
		while ($row = $res->fetch_assoc())
		{
			$arrFields[] = $row['Field'];
		}
		closeMeUp($res);
		return $arrFields;
	}
}

/************************************
 * Generate global status...
 ************************************/
if (!function_exists('generateGlobalStatus'))
{
	function generateGlobalStatus()
	{
		global $sqli;
		$arrData = array(
			0 => 'active',
			1 => 'active',
			2 => 'disabled',
			86 => 'deleted'
		);
		return $arrData;
	}
}

/************************************
 * Trim an array...
 ************************************/
if (!function_exists('trimArray'))
{
	function trimArray($arrData, $maxEntries)
	{
		if (is_array($arrData))
		{
			$cnt = 0;
			$tmpSize = max(array_keys($arrData));
			foreach ($arrData as $key => $val)
			{
				if ($key > $maxEntries)
				{
					unset($arrData[$key]);
				}
			}
			return $arrData;
		} else {
			return;
		}
	}
}

/******************************************
 * Generate an HTML table...
 ******************************************/
if (!function_exists('generateHTMLTable'))
{
	function generateHTMLTable($arrData)
	{
		global $sqli;
		$strTableData = '';
		return $strTableData;
	}
}

/************************************
 * Add new data to a table...
 ************************************/
if (!function_exists('addToTable'))
{
	function addToTable($arrData, $strTable)
	{
		global $sqli;
		$strSQL = "";
		foreach ($arrData as $key => $val)
		{
			if ($key != 'action')
			{
				$strSQL .= "{$key}='{$val}', ";
			}
		}
		$strSQL = substr($strSQL, 0, strlen($strSQL) - 2);
		$sql = "INSERT INTO `{$strTable}` SET {$strSQL};";
		$res = $sqli->query($sql) or die($sqli->error);
		closeMeUp($res);
		return;
	}
}

/************************************
 * Add a single table column...
************************************/
if (!function_exists('addTableColumn'))
{
	function addTableColumn($strTable, $strColumn, $strType, $strLength, $strDefault="''")
	{
		global $sqli;
		$sql = "ALTER TABLE `{$strTable}` ADD COLUMN `{$strColumn}` {$strType} ({$strLength}) DEFAULT {$strDefault};";
		$res = $sqli->query($sql) or die($sqli->error);
		closeMeUp($res);
		return;
	}
}

/************************************
 * Add additional columns (array)...
************************************/
if (!function_exists('addTableColumns'))
{
	function addTableColumns($arrSource, $arrDestination, $strDestination)
	{
		global $sqli;
		foreach ($arrSource as $key => $val)
		{
			if (!in_array($val, $arrDestination))
			{
				$sql = "ALTER TABLE `{$strDestination}` ADD COLUMN `adminurl` varchar (200) DEFAULT '';";
				$res = $sqli->query($sql) or die($sqli->error);
			}
		}
		closeMeUp($res);
		return;
	}
}

/************************************
 * Change a table column...
************************************/
if (!function_exists('changeTableColumns'))
{
	function changeTableColumns($strTable, $strColumn, $strType, $strLength, $strDefault="''")
	{
		global $sqli;
		$sql = "ALTER TABLE `{$strTable}` MODIFY `{$strColumn}` {$strType} ({$strLength}) DEFAULT {$strDefault};";
		$res = $sqli->query($sql) or die($sqli->error);
		closeMeUp($res);
		return;
	}
}

/************************************
 * Add a unique index to the table...
************************************/
if (!function_exists('addUniqueIndex'))
{
	function addUniqueIndex($strField)
	{
		global $sqli, $cntIndexes;
		$sql = "SHOW INDEXES FROM `definitions_{$strField}`;";
		$res = $sqli->query($sql) or die($sqli->error);
		while ($row = $res->fetch_assoc())
		{
			$arrIndexes[] = $row['Key_name'];
		}

		if (!in_array('my_unique_key', $arrIndexes))
		{
			$sql = "ALTER TABLE `definitions_{$strField}` ADD UNIQUE my_unique_key ({$strField}_id, {$strField}_description);";
			$res = $sqli->query($sql) or die($sqli->error);
			$cntIndexes++;
		}
		closeMeUp($res);
		return;
	}
}

/*************************************************
 * Save to log file...
 *************************************************/
if (!function_exists('saveToLog'))
{
	function saveToLog($strData, $strFilename='log.txt')
	{
		$fLogFile  = SITE_BASEPATH."data/{$strFilename}";
		$fileData .= "\n============================ BEGIN LOG ENTRY ". date('m/d/Y h:ia') ." ==================\n";
		$fileData .= $strData;
		$fileData .= "\n============================ END LOG ENTRY ===========================================\n";
		if (!file_put_contents($fLogFile, $fileData, FILE_APPEND))
		{
			$strnewExt = '-1';
			$strNewBase = str_replace('.txt', '', $fLogFile);
			$strNewFile = SITE_BASEPATH.'data/'.$strNewbase.$strNewExt.'.txt';
			@file_put_contents($strNewFile, $fileData, FILE_APPEND);
		}
		return;
	}
}

/************************************
 * Read a file into memory...
 ************************************/
if (!function_exists('getFileData'))
{
	function getFileData($strFile)
	{
		$arrData = array();
		$strFile = $strFile;
		if (file_exists($strFile))
		{
			$fh = @fopen($strFile, 'r');
			while (!feof($fh)) 
			{
        		$data = @fgets($fh, 4096);
        		if ($data{0} != '' )
        		{
        			$arrData[] = trim($data);        	
        		}
    		}
		}
		return $arrData;
	}
}

/************************************
 * Load a file into memory...
 ************************************/
if (!function_exists('loadFileData'))
{
	function loadFileData($strFile)
	{
		if ($strFile != '')
		{
			$strData = @file_get_contents($strFile);
			return $strData;
		} else {
			return;
		}
	}
}

/*************************************************
 * Write file data...
 *************************************************/
if (!function_exists('writeFileData'))
{
	function writeFileData($fileData, $strFile='')
	{
		if ($strFile != '')
		{
			@file_put_contents($strFile, $fileData);
			return;
		} else {
			return;
		}
	}
}

/*************************************************
 * Write file data...
 *************************************************/
if (!function_exists('backupFile'))
{
	function backupFile($strPath, $strFile='')
	{
		if ($strFile != '')
		{
			if (file_exists($strPath.$strFile))
			{
				$strSourceFile = $strPath.$strFile;
				$strNewDateTime = date('YmdHis').'-bak.dat';
				$strNewFile = $strPath.'bak/'.$strFile.$strNewDateTime;
				@copy($strSourceFile, $strNewFile);
			}
			return;
		} else {
			return;
		}
	}
}

/************************************
 * Read folder contents into array...
 ************************************/
if (!function_exists('getFolderContents'))
{
	function getFolderContents($strLocation='.')
	{
		$arrFiles = array();
		if ($dirHandle = @opendir($strLocation)) 
		{
			while (false !== ($file = @readdir($dirHandle))) 
			{
				if ($file != '.' && $file != '..') 
				{
					$arrFiles[] = trim($file);
				}
			}
			@closedir($dirHandle);
		}
		return $arrFiles;
	}
}

/*************************************************
 * Split a string and return an array...
 *************************************************/
if (!function_exists('splitTheString'))
{
	function splitTheString($strTemp, $tmpCharacter)
	{
		if ($tmpCharacter == '')
		{
			$tmpCharacter = "::";
		}
		$resSplit = explode($tmpCharacter, $strTemp);
		return $resSplit;
	}
}

/*************************************************
 * Remove any unwanted characters, etc...
 *************************************************/
if (!function_exists('makeItClean'))
{
	function makeItClean($strTemp)
	{
		$arrDirty   = array();
		$arrDirty[] = '&Atilde;';
		$arrDirty[] = '&nbsp;';
		$arrDirty[] = '&micro;';
		$arrDirty[] = '&Ugrave;';
		$arrDirty[] = '&Oslash;';
		$arrDirty[] = '&sect;';
		$arrDirty[] = '&Ugrave;';
		$arrDirty[] = '??';
		foreach ($arrDirty as $key => $val)
		{
			$strTemp = str_replace($val, '', $strTemp);	
		}
		return trim($strTemp);
	}
}

/*************************************************
 * Replace any characters that may cause issues...
 *************************************************/
if (!function_exists('makeSafe'))
{
	function makeSafe($strTemp)
	{
		$arrDirty   = array();
		$arrDirty[] = '"';
		$arrDirty[] = "'";
		$arrDirty[] = ",";
		$arrDirty[] = "-";
		$arrDirty[] = ".";
		$arrDirty[] = ":";
		$arrDirty[] = "/";
		foreach ($arrDirty as $key => $val)
		{
			if ($val == '-' || $val == '.' || $val == ':' || $val == '/')
			{
				$strTemp = str_replace($val, ' ', $strTemp);
			} else {
				$strTemp = str_replace($val, '', $strTemp);
			}
		}
		return trim($strTemp);
	}
}

/*************************************************
 * Build state(s) array...
 *************************************************/
if (!function_exists('buildStates'))
{
	function buildStates()
	{
		$arrStates = array(
		'AL' => 'Alabama',
		'AK' => 'Alaska',
		'AZ' => 'Arizona',
		'AR' => 'Arkansas',
		'CA' => 'California',
		'CO' => 'Colorado',
		'CT' => 'Connecticut',
		'DC' => 'District of Columbia',
		'DE' => 'Delaware',
		'FL' => 'Florida',
		'GA' => 'Georgia',
		'HI' => 'Hawaii',
		'ID' => 'Idaho',
		'IL' => 'Illinois',
		'IN' => 'Indiana',
		'IA' => 'Iowa',
		'KS' => 'Kansas',
		'KY' => 'Kentucky',
		'LA' => 'Louisiana',
		'ME' => 'Maine',
		'MD' => 'Maryland',
		'MA' => 'Massachusetts',
		'MI' => 'Michigan',
		'MN' => 'Minnesota',
		'MS' => 'Mississippi',
		'MO' => 'Missouri',
		'MT' => 'Montana',
		'NE' => 'Nebraska',
		'NV' => 'Nevada',
		'NH' => 'New Hampshire',
		'NJ' => 'New Jersey',
		'NM' => 'New Mexico',
		'NY' => 'New York',
		'NC' => 'North Carolina',
		'ND' => 'North Dakota',
		'OH' => 'Ohio',
		'OK' => 'Oklahoma',
		'OR' => 'Oregon',
		'PA' => 'Pennsylvania',
		'RI' => 'Rhode Island',
		'SC' => 'South Carolina',
		'SD' => 'South Dakota',
		'TN' => 'Tennessee',
		'TX' => 'Texas',
		'UT' => 'Utah',
		'VT' => 'Vermont',
		'VA' => 'Virginia',
		'WA' => 'Washington',
		//'DC' => 'Washington D.C.',
		'WV' => 'West Virginia',
		'WI' => 'Wisconsin',
		'WY' => 'Wyoming',
		);
		return $arrStates;
	}
}

/************************************
 * Get the state listings...
 ************************************/
if (!function_exists('compressedToFullState'))
{
	function compressedToFullState()
	{
		$arrStates = array();
		$arrStates['alaska'] = 'Alaska';
    	$arrStates['alabama'] = 'Alabama';
    	$arrStates['arizona'] = 'Arizona';
    	$arrStates['california'] = 'California';
    	$arrStates['colorado'] = 'Colorado';
    	$arrStates['connecticut'] = 'Connecticut';
    	$arrStates['delaware'] = 'Delaware';
    	$arrStates['florida'] = 'Florida';
    	$arrStates['georgia'] = 'Georgia';
    	$arrStates['hawaii'] ='Hawaii';
    	$arrStates['iowa'] = 'Iowa';
    	$arrStates['idaho'] = 'Idaho';
    	$arrStates['illinois'] = 'Illinois';
    	$arrStates['indiana'] = 'Indiana';
    	$arrStates['kansas'] = 'Kansas';
    	$arrStates['kentucky'] = 'Kentucky';
    	$arrStates['louisiana'] = 'Louisiana';
    	$arrStates['massachusetts'] = 'Massachusettes';
    	$arrStates['maryland'] = 'Maryland';
    	$arrStates['maine'] = 'Maine';
    	$arrStates['michigan'] = 'Michigan';
    	$arrStates['minnesota'] = 'Minnesota';
    	$arrStates['missouri'] = 'Missouri';
    	$arrStates['mississippi'] = 'Mississippi';
    	$arrStates['montana'] = 'Montana';
    	$arrStates['northcarolina'] = 'North Carolina';
    	$arrStates['northdakota'] = 'North Dakota';
    	$arrStates['nebraska'] = 'Nebraska';
    	$arrStates['newhampshire'] = 'New Hampshire';
    	$arrStates['newjersey'] = 'New Jersey';
    	$arrStates['newmexico'] = 'New Mexico';
    	$arrStates['nevada'] = 'Nevada';
    	$arrStates['newyork'] = 'New York';
    	$arrStates['ohio'] = 'Ohio';
    	$arrStates['oklahoma'] = 'Oklahoma';
    	$arrStates['oregon'] = 'Oregon';
    	$arrStates['pennsylvania'] = 'Pennsylvania';
    	$arrStates['rhodeisland'] = 'Rhode Island';
    	$arrStates['southcarolina'] = 'South Carolina';
    	$arrStates['southdakota'] = 'South Dakota';
    	$arrStates['tennessee'] = 'Tennessee';
    	$arrStates['texas'] = 'Texas';
    	$arrStates['utah'] = 'Utah';
    	$arrStates['virginia'] = 'Virginia';
    	$arrStates['vermont'] = 'Vermont';
    	$arrStates['washington'] = 'Washington';
    	$arrStates['wisconsin'] = 'Wisconsin';
    	$arrStates['westvirginia'] = 'West Virginia';
    	$arrStates['wyoming'] = 'Wyoming';
    	return $arrStates;
	}
}

/************************************
 * Get state abbreviation...
 ************************************/
if (!function_exists('getStateAbbr'))
{
	function getStateAbbr($strState='')
	{
		global $sqli;
		$strState = $sqli->real_escape_string($strState);
		$tmpStates = buildStates();
		$arrStates = array_flip($tmpStates);
		$strState = str_replace('-', ' ', strtolower($strState));
		$strState = ucwords($strState);
		$tmpState = $arrStates[$strState];
		return $tmpState;
	}
}

/*************************************************
 * Build country(s) array...
 *************************************************/
if (!function_exists('buildCountries'))
{
	function buildCountries()
	{
		$arrCountries = array();
		$arrCountries['0'] = "--Select--";
		$arrCountries['AL - Albania'] = "Albania";
		$arrCountries['DZ - Algeria'] = "Algeria";
		$arrCountries['AS - American Samoa'] = "American Samoa";
		$arrCountries['AD - Andorra'] = "Andorra";
		$arrCountries['AI - Anguilla'] = "Anguilla";
		$arrCountries['AQ - Antarctica'] = "Antarctica";
		$arrCountries['AG - Antiqua and Barbuda'] = "Antiqua and Barbuda";
		$arrCountries['AR - Argentina'] = "Argentina";
		$arrCountries['AM - Armenia'] = "Armenia";
		$arrCountries['AW - Aruba'] = "Aruba";
		$arrCountries['AU - Australia'] = "Australia";
		$arrCountries['AT - Austria'] = "Austria";
		$arrCountries['AZ - Azerbaijan'] = "Azerbaijan";
		$arrCountries['BS - Bahamas'] = "Bahamas";
		$arrCountries['BH - Baharain'] = "Bahrain";
		$arrCountries['BD - Bandladesh'] = "Bangladesh";
		$arrCountries['BB - Barbados '] = "Barbados";
		$arrCountries['BY - Belarus'] = "Belarus";
		$arrCountries['BE - Belgium'] = "Belgium";
		$arrCountries['BZ - Belize'] = "Belize";
		$arrCountries['BJ - Benin'] = "Benin";
		$arrCountries['BM - Bermuda'] = "Bermuda";
		$arrCountries['BT - Bhutan'] = "Bhutan";
		$arrCountries['BO - Bolivia'] = "Bolivia";
		$arrCountries['BA - Bosnia and Herzegovina'] = "Bosnia and Herzegovina";
		$arrCountries['BW - Botswana'] = "Botswana";
		$arrCountries['BV - Bouvet Islands'] = "Bouvet Islands";
		$arrCountries['BR - Brazil'] = "Brazil";
		$arrCountries['IO - British Indian Ocean Territory'] = "British Indian Ocean Territory";
		$arrCountries['VI - British Virgin Islands'] = "British Virgin Islands";
		$arrCountries['BN - Brunei'] = "Brunei";
		$arrCountries['BG - Bulgaria'] = "Bulgaria";
		$arrCountries['BF - Burkina Faso'] = "Burkina Faso";
		$arrCountries['BI - Burundi'] = "Burundi";
		$arrCountries['KH'] = "Cambodia";
		$arrCountries['CM'] = "Cameroon";
		$arrCountries['CA'] = "Canada";
		$arrCountries['CV'] = "Cape Verde";
		$arrCountries['KY'] = "Cayman Islands";
		$arrCountries['CF'] = "Central African Republic";
		$arrCountries['TD'] = "Chad";
		$arrCountries['CL'] = "Chile";
		$arrCountries['CN'] = "China";
		$arrCountries['CX - Christmas Island'] = "Christmas Island";
		$arrCountries['CC - Cocos (Keeling) Islands'] = "Cocos (keeling) Islands";
		$arrCountries['CO'] = "Colombia";
		$arrCountries['KM'] = "Comoros";
		$arrCountries['CG'] = "Congo";
		$arrCountries['CK - Cook Islands'] = "Cook Islands";
		$arrCountries['CR'] = "Costa Rica";
		$arrCountries['CI'] = "Cote D'Ivoire";
		$arrCountries['HR'] = "Croatia";
		$arrCountries['CU - Cuba'] = "Cuba";
		$arrCountries['CY'] = "Cyprus";
		$arrCountries['CZ'] = "Czech Republic";
		$arrCountries['DK'] = "Denmark";
		$arrCountries['DJ'] = "Djibouti";
		$arrCountries['DM'] = "Dominica";
		$arrCountries['DO'] = "Dominican Republic";
		$arrCountries['EG'] = "Egypt";
		$arrCountries['SV'] = "El Salvador";
		$arrCountries['EC'] = "Equador";
		$arrCountries['GQ'] = "Equatorial Guinea";
		$arrCountries['ER'] = "Eritrea";
		$arrCountries['EE'] = "Estonia";
		$arrCountries['ET'] = "Ethiopia";
		$arrCountries['FK'] = "Falkland Islands";
		$arrCountries['FO'] = "Faroe Islands";
		$arrCountries['FM'] = "Federated States of Micronesia";
		$arrCountries['FJ'] = "Fiji";
		$arrCountries['FI'] = "Finland";
		$arrCountries['FR'] = "France";
		$arrCountries['GF'] = "French Guiana";
		$arrCountries['PF'] = "French Polynesia";
		$arrCountries['GA'] = "Gabon";
		$arrCountries['GM'] = "Gambia";
		$arrCountries['GE'] = "Georgia";
		$arrCountries['DE'] = "Germany";
		$arrCountries['GH'] = "Ghana";
		$arrCountries['GI'] = "Gibraltar";
		$arrCountries['GR'] = "Greece";
		$arrCountries['GL'] = "Greenland";
		$arrCountries['GD'] = "Grenada";
		$arrCountries['GP'] = "Guadeloupe";
		$arrCountries['GU'] = "Guam";
		$arrCountries['GT'] = "Guatemala";
		$arrCountries['GN'] = "Guinea";
		$arrCountries['GW'] = "Guinea-Bissau";
		$arrCountries['GY'] = "Guyana";
		$arrCountries['HT'] = "Haiti";
		$arrCountries['HM - Heard Island and McDonald Islands'] = "Heard Island and McDonald Islands";
		$arrCountries['VA - Holy See (Vatican City State)'] = " Holy See (Vatican City Stat";
		$arrCountries['HN'] = "Honduras";
		$arrCountries['HK'] = "Hong Kong";
		$arrCountries['HU'] = "Hungary";
		$arrCountries['IS'] = "Iceland";
		$arrCountries['IN'] = "India";
		$arrCountries['ID'] = "Indonesia";
		$arrCountries['IR - Iran'] = "Iran";
		$arrCountries['IQ - Iraq'] = "Iraq";
		$arrCountries['IE'] = "Ireland";
		$arrCountries['IM - Isle of Man'] = "Isle of Man";
		$arrCountries['IL'] = "Israel";
		$arrCountries['IT'] = "Italy";
		$arrCountries['JM'] = "Jamaica";
		$arrCountries['JP'] = "Japan";
		$arrCountries['JE - Jersey'] = "Jersey";
		$arrCountries['JO'] = "Jordan";
		$arrCountries['KZ'] = "Kazakhstan";
		$arrCountries['KE'] = "Kenya";
		$arrCountries['KI'] = "Kiribati";
		$arrCountries['KS - Korea'] = "Korea";
		$arrCountries['KW'] = "Kuwait";
		$arrCountries['KG'] = "Kyrgyzstan";
		$arrCountries['LA'] = "Laos";
		$arrCountries['LV'] = "Latvia";
		$arrCountries['LB'] = "Lebanon";
		$arrCountries['LS'] = "Lesotho";
		$arrCountries['LR'] = "Liberia";
		$arrCountries['LY - Libyan Arab Jamahiriya'] = "Libyan Arab Jamahiriya";
		$arrCountries['LI'] = "Liechtenstein";
		$arrCountries['LT'] = "Lithuania";
		$arrCountries['LU'] = "Luxembourg";
		$arrCountries['MO'] = "Macau";
		$arrCountries['MK - Macedonia'] = "Macedonia";
		$arrCountries['MG'] = "Madagascar";
		$arrCountries['MW'] = "Malawi";
		$arrCountries['MY'] = "Malaysia";
		$arrCountries['MV'] = "Maldives";
		$arrCountries['ML'] = "Mali";
		$arrCountries['MT'] = "Malta";
		$arrCountries['MH'] = "Marshall Islands";
		$arrCountries['MQ'] = "Martinique";
		$arrCountries['MR'] = "Mauritania";
		$arrCountries['YT'] = "Mayotte";
		$arrCountries['FX'] = "Metropolitan France";
		$arrCountries['MX'] = "Mexico";
		$arrCountries['MD'] = "Moldova";
		$arrCountries['MN'] = "Mongolia";
		$arrCountries['MA'] = "Morocco";
		$arrCountries['MC - Monoco '] = "Monoco";
		$arrCountries['MN - Mongolia'] = "Mongolia";
		$arrCountries['MS - Montserrat'] = "Montserrat";
		$arrCountries['MZ - Mozambique'] = "Mozambique";
		$arrCountries['MM - Myanmar'] = "Myanmar";
		$arrCountries['NA'] = "Namibia";
		$arrCountries['NR'] = "Nauru";
		$arrCountries['NP'] = "Nepal";
		$arrCountries['NL'] = "Netherlands";
		$arrCountries['AN'] = "Netherlands Antilles";
		$arrCountries['NC'] = "New Caledonia";
		$arrCountries['NZ'] = "New Zealand";
		$arrCountries['NI'] = "Nicaragua";
		$arrCountries['NE'] = "Niger";
		$arrCountries['NG'] = "Nigeria";
		$arrCountries['NU - Niuue'] = "Niuue";
		$arrCountries['NF'] = "Norfolk Islands";
		$arrCountries['MP'] = "Northern Mariana Islands";
		$arrCountries['NO'] = "Norway";
		$arrCountries['OM'] = "Oman";
		$arrCountries['PK'] = "Pakistan";
		$arrCountries['PW'] = "Palau";
		$arrCountries['PA'] = "Panama";
		$arrCountries['PG'] = "Papua New Guinea";
		$arrCountries['PY'] = "Paraguay";
		$arrCountries['PE'] = "Peru";
		$arrCountries['PH'] = "Philippines";
		$arrCountries['PN'] = "Pitcairn";
		$arrCountries['PL'] = "Poland";
		$arrCountries['PT'] = "Portugal";
		$arrCountries['PR'] = "Puerto Rico";
		$arrCountries['QA'] = "Qatar";
		$arrCountries['RE'] = "Reunion";
		$arrCountries['RO'] = "Romania";
		$arrCountries['RU'] = "Russia";
		$arrCountries['RW - Rwanda'] = "Rwanda";
		$arrCountries['SH - Saint Helena'] = "Saint Helena";
		$arrCountries['KN - Saint Kitts and Nevis'] = "St. Kitts and Nevis";
		$arrCountries['LC - Saint Lucia'] = "St. Lucia";
		$arrCountries['PM - Saint Pierre and Miquelon'] = "Saint Pierre and Miquelon";
		$arrCountries['VC - Saint Vincent and the Grenadines'] = "Saint Vincent and the Grenadines";
		$arrCountries['ST'] = "Sao Tome and Principe";
		$arrCountries['SA'] = "Saudi Arabia";
		$arrCountries['SN'] = "Senegal";
		$arrCountries['CS - Serbia and Montenegro'] = "Serbia and Montenegro";
		$arrCountries['SC'] = "Seychelles";
		$arrCountries['SL'] = "Sierra Leone";
		$arrCountries['SG'] = "Singapore";
		$arrCountries['SK'] = "Slovakia";
		$arrCountries['SI'] = "Slovenia";
		$arrCountries['SB'] = "Solomon Islands";
		$arrCountries['SO'] = "Somalia";
		$arrCountries['ZA'] = "South Africa";
		$arrCountries['GS - South Georgia And The South Sandwich Islands'] = "South Georgia And The South Sandwich Islands";
		$arrCountries['ES'] = "Spain";
		$arrCountries['LK'] = "Sri Lanka";
		$arrCountries['SD'] = "Sudan";
		$arrCountries['SR'] = "Suriname";
		$arrCountries['SJ'] = "Svalbard and Jan Mayen Islands";
		$arrCountries['SZ'] = "Swaziland";
		$arrCountries['SE'] = "Sweden";
		$arrCountries['CH'] = "Switzerland";
		$arrCountries['SY'] = "Syria";
		$arrCountries['TW'] = "Taiwan";
		$arrCountries['TJ'] = "Tajikistan";
		$arrCountries['TZ'] = "Tanzania";
		$arrCountries['TH'] = "Thailand";
		$arrCountries['TL - Timor-Leste'] = "Timor-Leste";
		$arrCountries['TG'] = "Togo";
		$arrCountries['TK - Tokelau'] = "Tokelau";
		$arrCountries['TO'] = "Tonga";
		$arrCountries['TT'] = "Trinidad and Tobago";
		$arrCountries['TN - Tunisia'] = "Tunisia";
		$arrCountries['TR'] = "Turkey";
		$arrCountries['TM'] = "Turkmenistan";
		$arrCountries['TC'] = "Turks and Caicos Islands";
		$arrCountries['TV'] = "Tuvalu";
		$arrCountries['UG'] = "Uganda";
		$arrCountries['UA'] = "Ukraine";
		$arrCountries['AE'] = "United Arab Emirates";
		$arrCountries['GB'] = "United Kingdom";
		$arrCountries['US'] = "United States";
		$arrCountries['UY'] = "Uruguay";
		$arrCountries['UZ'] = "Uzbekistan";
		$arrCountries['VU'] = "Vanuatu";
		$arrCountries['VA'] = "Vatican City";
		$arrCountries['VE'] = "Venezuela";
		$arrCountries['VN'] = "Vietnam";
		$arrCountries['VI - U.S. Virgin Islands'] = "U.S. Virgin Islands";
		$arrCountries['WF - Wallis and Futuna'] = "Wallis and Futuna";
		$arrCountries['EH'] = "Western Sahara";
		$arrCountries['YE'] = "Yemen";
		$arrCountries['YU'] = "Yugoslavia";
		$arrCountries['ZR'] = "Zaire";
		$arrCountries['ZM'] = "Zambia";
		$arrCountries['ZW'] = "Zimbabwe";
		return $arrCountries;
	}
}

/************************************
 * Generate list of countries...
 ************************************/
if (!function_exists('generateCountries'))
{
	function generateCountries($intLimit=1000)
	{
		global $sqli;
		$arrData = array();
		$intLimit = $sqli->real_escape_string($intLimit);
		$sql = "SELECT `country_id`,`country` FROM `".COUNTRY_TABLE."` WHERE `status`!=86 AND `country_id` NOT IN (254,43) ORDER BY `country` LIMIT {$intLimit};";
		$res = $sqli->query($sql);
		while ($row = $res->fetch_assoc())
		{
			$arrData[$row['country_id']] = $row['country'];
		}
		closeMeUp($res);
		return $arrData;
	}
}

/************************************
 * Generate list of provinces...
 ************************************/
if (!function_exists('generateCountryProvinces'))
{
	function generateCountryProvinces($intID=0, $intLimit=10000)
	{
		global $sqli;
		$arrData = array();
		$intID = $sqli->real_escape_string($intID);
		$intLimit = $sqli->real_escape_string($intLimit);
		$sql = "SELECT `region_code`,`region_name` FROM `".COUNTRY_REGION_TABLE."` WHERE `status`!=86 AND `country_id`={$intID} ORDER BY `region_name` LIMIT {$intLimit};";
		$res = $sqli->query($sql);
		while ($row = $res->fetch_assoc())
		{
			$arrData[$row['region_code']] = $row['region_name'];
		}
		closeMeUp($res);
		return $arrData;
	}
}

/************************************
 * Generate list of cities...
 ************************************/
if (!function_exists('generateProvinceCities'))
{
	function generateProvinceCities($strCountry='', $strRegion='', $intLimit=10000)
	{
		global $sqli;
		$arrData = array();
		$strCountry = $sqli->real_escape_string($strCountry);
		$StrRegion = $sqli->real_escape_string($strRegion);
		$intLimit = $sqli->real_escape_string($intLimit);
		$sql = "SELECT `id`,`accent_city` FROM `".GLOBAL_CITIES_TABLE."` WHERE `status`!=86 AND `country`='{$strCountry}' AND `region`='{$strRegion}' ORDER BY `city` LIMIT {$intLimit};";
		$res = $sqli->query($sql);
		while ($row = $res->fetch_assoc())
		{
			$arrData[$row['id']] = $row['accent_city'];
		}
		closeMeUp($res);
		return $arrData;
	}
}

/*************************************************
 * Perform a few functions on an array...
 * -----------------------------------------------
 *************************************************/
if (!function_exists('arrayChecker'))
{
	function arrayChecker($arrTemp)
	{
		$rows1 = array();
		foreach ($arrTemp as $key => $val)
		{
			if (trim($val) == '')
			{
				unset($arrTemp[$key]);
			}
		}
		
		foreach ($arrTemp as $key => $val)
		{
			if (strlen(trim($val)) < 3)
			{
				unset($arrTemp[$key]);
			}
		}

		foreach ($arrTemp as $key => $val)
		{
			$rows1[] = trim($val);
		}
		
		unset($arrAccented, $arrTemp, $key, $key2, $val, $val2);
		return $rows1;
	}
}

/************************************
 * Perform simple regEx check(s)...
 ************************************/
if (!function_exists('checkRegEx'))
{
	function checkRegEx($text, $regex)
	{
		if (preg_match($regex, $text)) 
		{
			return true;
		} else {
			return false;
		}
	}
}

/************************************
 * Generate the ignore fields...
 ************************************/
if (!function_exists('generateIgnoreFields'))
{
	function generateIgnoreFields($strTable, $arrData)
	{
		$arrIgnore = array();
		$arrFields = getTableFields($strTable);
		foreach ($arrFields as $key => $val)
		{
			if (!in_array($val, $arrData))
			{
				$arrIgnore[] = $val;
			}
		}
		return $arrIgnore;
	}
}

/************************************
 * Get the initial page data...
 ************************************/
if (!function_exists('getInitialPageData'))
{
	function getInitialPageData($strURL)
	{
 		$ch = curl_init();
 		$cookie_path = 'cookies.txt';
    	curl_setopt($ch, CURLOPT_URL, $strURL);
    	curl_setopt($ch, CURLOPT_VERBOSE, true);
    	curl_setopt($ch, CURLOPT_HEADER, true);
    	curl_setopt($ch, CURLOPT_NOBODY, false);
    	curl_setopt($ch, CURLOPT_POST, false);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_USERPWD, 'username:password'); 
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.0.5) Gecko/2008120122 Firefox/3.0.5");
    	$data = curl_exec($ch); 
    	curl_close($ch); 
		return $data;
	}
}

/************************************
 * Get the initial page (no POST)...
 ************************************/
if (!function_exists('getInitialPage'))
{
	function getInitialPage($strURL)
	{
 		$ch = curl_init();
 		$cookie_path = getcwd() . '/cookies.txt';
    	curl_setopt($ch, CURLOPT_URL, $strURL);
    	curl_setopt($ch, CURLOPT_VERBOSE, true);
    	curl_setopt($ch, CURLOPT_HEADER, true);
    	curl_setopt($ch, CURLOPT_NOBODY, false);
    	curl_setopt($ch, CURLOPT_POST, false);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_path);
		curl_setopt($ch, CURLOPT_COOKIESESSION, true);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.0.5) Gecko/2008120122 Firefox/3.0.5");
    	$data = curl_exec($ch); 
    	curl_close($ch); 
		return $data;
	}
}

/***************************************
 * Get the initial XML page (no POST)...
 ***************************************/
if (!function_exists('getInitialXMLPage'))
{
	function getInitialXMLPage($strURL)
	{
 		$ch = curl_init();
 		$cookie_path = 'cookies.txt';
    	curl_setopt($ch, CURLOPT_URL, $strURL);
    	curl_setopt($ch, CURLOPT_VERBOSE, true);
    	curl_setopt($ch, CURLOPT_HEADER, false);
    	curl_setopt($ch, CURLOPT_NOBODY, false);
    	curl_setopt($ch, CURLOPT_POST, false);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.0.5) Gecko/2008120122 Firefox/3.0.5");
    	$data = curl_exec($ch); 
    	curl_close($ch); 
		return $data;
	}
}

/***************************************
 * Advanced HTML strip_tags...
 ***************************************/
if (!function_exists('strip_html_tags'))
{
	function strip_html_tags($text)
	{
		$text = preg_replace(
		array(
			/* Remove invisible content... */
			'@<head[^>]*?>.*?</head>@siu',
			'@<style[^>]*?>.*?</style>@siu',
			'@<script[^>]*?.*?</script>@siu',
			'@<object[^>]*?.*?</object>@siu',
			'@<embed[^>]*?.*?</embed>@siu',
			'@<applet[^>]*?.*?</applet>@siu',
			'@<noframes[^>]*?.*?</noframes>@siu',
			'@<noscript[^>]*?.*?</noscript>@siu',
			'@<noembed[^>]*?.*?</noembed>@siu',
			/* Add line breaks before & after blocks... */
			'@<((br)|(hr))@iu',
			'@</?((address)|(blockquote)|(center)|(del))@iu',
			'@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
			'@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
			'@</?((table)|(th)|(td)|(caption))@iu',
			'@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
			'@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
			'@</?((frameset)|(frame)|(iframe))@iu',
		),
		array(
			' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
			"\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0",
			"\n\$0", "\n\$0",
		),
		$text);
	return strip_tags($text);
	}
}

/***************************************
 * Build an array of page content...
 ***************************************/
if (!function_exists('buildPageDataArray'))
{
	function buildPageDataArray($strData)
	{
		$arrData   = array();
		$regEX     = '/\b\d+\b/';
		$arrTemp   = split("\n", $strData);
		$arrIgnore = generateIgnoreList();
		foreach ($arrTemp as $key => $val)
		{
			if (trim($val) == '')
			{
				unset($arrTemp[$key]);
			}
		
			if (in_array(trim($val), $arrIgnore))
			{
				unset($arrTemp[$key]);
			}
			
			if (checkRegEx(trim($val), $regEX))
			{
				unset($arrTemp[$key]);
			}
		}
		
		// Clean up the array...
		foreach ($arrTemp as $key => $val)
		{
			$val = str_replace('&nbsp;', '', $val);
			$arrData[] = makeSafe(trim($val));
		}
		
		unset($arrTemp, $arrIgnore, $regEX);
		return $arrData;
	}
}

/***************************************
 * Remove blank array entries...
 ***************************************/
if (!function_exists('removeBlankArrayEntries'))
{
	function removeBlankArrayEntries($arrData)
	{
		foreach ($arrData as $key => $val)
		{
			$arrData[$key] = trim($val);
		}
		
		foreach ($arrData as $key => $val)
		{
			if (trim($val) == '' || trim($val) == '&nbsp;')
			{
				unset($arrData[$key]);
			}
		}
		
		foreach ($arrData as $key => $val)
		{
			$arrData[$key] = trim($val);
		}
		return $arrData;
	}
}

/************************************
 * Get state founded information...
 ************************************/
if (!function_exists('buildDataArray'))
{
	function buildDataArray($strTable, $arrFields)
	{
		global $sqli;
		$arrData = array();
		$strTable = $sqli->real_escape_string($strTable);
		$sql = "SELECT ". implode(',', $arrFields) ." FROM `{$strTable}`;";
		$res = $sqli->query($sql) or die($sqli->error);
		while ($row = $res->fetch_assoc())
		{
			$tmpData = array();
			foreach ($arrFields as $key => $val)
			{
				$tmpData[$val] = $row[$val];
			}
			$arrData[$row['property_type']] = $tmpData;
		}
		closeMeUp($res);
		return $arrData;
	}
}

/************************************
 * Generate the timezones (db)...
 ************************************/
if (!function_exists('generateTimezones'))
{
	function generateTimezones()
	{
		global $sqli;
		$arrData = array();
		$sql = "SELECT `id`,`name` FROM `".TIMEZONE_TABLE."` WHERE `status` != 86 ORDER BY `name`;";
		$res = $sqli->query($sql) or die($sqli->error);
		while ($row = $res->fetch_assoc())
		{
			$arrData[$row['id']] = $row['name'];
		}
		closeMeUp($res);
		return $arrData;
	}
}

/*************************************************
 * Email format verification check...
 *************************************************/
if (!function_exists('isValidEmail'))
{
	function isValidEmail($strEmail)
	{
		if (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $strEmail))
		{
			return false;
		} else {
			return true;
		}
	}
}

/*************************************************
 * Get the ~real~ IP address...
 *************************************************/
if (!function_exists('getRealIP'))
{
	function getRealIP()
	{
    	$ip = false;
    	if (!empty($_SERVER['HTTP_CLIENT_IP'])) 
    	{
        	$ip = $_SERVER['HTTP_CLIENT_IP'];
    	}
    	
    	if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) 
    	{
        	$ips = explode(', ', $_SERVER['HTTP_X_FORWARDED_FOR']);
        	if ($ip) 
        	{
            	array_unshift($ips, $ip);
            	$ip = false;
        	}
        	
        	for ($i=0; $i < count($ips); $i++) 
        	{
            	if (!eregi("^(10|172\.16|192\.168)\.", $ips[$i])) 
            	{
                	if (version_compare(phpversion(), "5.0.0", ">=")) 
                	{
                    	if (ip2long($ips[$i]) != false) 
                    	{
                        	$ip = $ips[$i];
                        	break;
                    	}
                	} else {
                    	if (ip2long($ips[$i]) != -1) 
                    	{
                        	$ip = $ips[$i];
                        	break;
                    	}
                	}
            	}
        	}
    	}
    	return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
	}
}

/*************************************************
 * Remove Microsoft Word special characters...
 *************************************************/
if (!function_exists('cleanUpMSWord'))
{
	function cleanUpMSWord($strData)
	{
		$arrFind = array(
			chr(130) => ',',
			chr(131) => 'NLG',
			chr(132) => '"',
			chr(133) => '...',
			chr(134) => '**',
			chr(135) => '***',
			chr(136) => '^',
			chr(137) => 'o/oo',
			chr(138) => 'Sh',
			chr(139) => '<',
			chr(140) => 'OE',
			chr(145) => "'",
			chr(146) => "'",
			chr(147) => '"',
			chr(148) => '"',
			chr(149) => '-',
			chr(150) => '-',
			chr(151) => '--',
			chr(152) => '~',
			chr(153) => '(TM)',
			chr(154) => 'sh',
			chr(155) => '>',
			chr(156) => 'oe',
			chr(159) => 'Y');
		foreach ($arrFind as $key => $val)
		{
			$strData = str_replace($key, $val, $strData);
		}
		return $strData;
	}
}

/*************************************************************
 * Replaces special characters with non-special equivalents...
 *************************************************************/
if (!function_exists('normalizeSpecialCharacters'))
{
	function normalizeSpecialCharacters($strData)
	{
		// Quotes...
		$strData = ereg_replace(chr(ord("`")), "'", $strData);
		$strData = ereg_replace(chr(ord("´")), "'", $strData);
		$strData = ereg_replace(chr(ord("„")), ",", $strData);
		$strData = ereg_replace(chr(ord("`")), "'", $strData);
		$strData = ereg_replace(chr(ord("´")), "'", $strData);
		$strData = ereg_replace(chr(ord("“")), "\"", $strData);
		$strData = ereg_replace(chr(ord("”")), "\"", $strData);
		$strData = ereg_replace(chr(ord("´")), "'", $strData);
		$arrUnwanted = array(
			'Š' => 'S',
			'š' => 's',
			'Ž' => 'Z',
			'ž' => 'z',
			'À' => 'A',
			'Á' => 'A',
			'Â' => 'A',
			'Ã' => 'A',
			'Ä' => 'A',
			'Å' => 'A',
			'Æ' => 'A',
			'Ç' => 'C',
			'È' => 'E',
			'É' => 'E',
			'Ê' => 'E',
			'Ë' => 'E',
			'Ì' => 'I',
			'Í' => 'I',
			'Î' => 'I',
			'Ï' => 'I',
			'Ñ' => 'N',
			'Ò' => 'O',
			'Ó' => 'O',
			'Ô' => 'O',
			'Õ' => 'O',
			'Ö' => 'O',
			'Ø' => 'O',
			'Ù' => 'U',
        	'Ú' => 'U',
			'Û' => 'U',
			'Ü' => 'U',
			'Ý' => 'Y',
			'Þ' => 'B',
			'ß' => 'Ss',
			'à' => 'a',
			'á' => 'a',
			'â' => 'a',
			'ã' => 'a',
			'ä' => 'a',
			'å' => 'a',
			'æ' => 'a',
			'ç' => 'c',
        	'è' => 'e',
			'é' => 'e',
			'ê' => 'e',
			'ë' => 'e',
			'ì' => 'i',
			'í' => 'i',
			'î' => 'i',
			'ï' => 'i',
			'ð' => 'o',
			'ñ' => 'n',
			'ò' => 'o',
			'ó' => 'o',
			'ô' => 'o',
			'õ' => 'o',
        	'ö' => 'o',
			'ø' => 'o',
			'ù' => 'u',
			'ú' => 'u',
			'û' => 'u',
			'ý' => 'y',
			'ý' => 'y',
			'þ' => 'b',
			'ÿ' => 'y');
		$strData = strtr($strData, $arrUnwanted);

		// Bullets, dashes, and trademarks...
    	$strData = ereg_replace(chr(149), "&#8226;", $strData);
    	$strData = ereg_replace(chr(150), "&ndash;", $strData);
    	$strData = ereg_replace(chr(151), "&mdash;", $strData);
    	$strData = ereg_replace(chr(153), "&#8482;", $strData);
    	$strData = ereg_replace(chr(169), "&copy;", $strData);
    	$strData = ereg_replace(chr(174), "&reg;", $strData);
		return $strData;
	}
}

/*************************************************
 * Get the first word of the output data...
 *************************************************/
if (!function_exists('firstWord'))
{
	function firstWord($strData) 
	{
		list($strData) = preg_split('/[ ;]/', $strData);
		return $strData;
	}
}

/*************************************************
 * Dump output to the screen...
 *************************************************/
if (!function_exists('ajaxDump'))
{
	function ajaxDump($strPrompt, $strData) 
	{
		echo "{$strPrompt}\n{$strData}";
		return;
	}
}

/*************************************************
 * Remove slashes from output...
 *************************************************/
if (!function_exists('gpcClearSlashes'))
{
	function gpcClearSlashes($strData) 
	{
		if (ini_get('magic_quotes_gpc'))
    	{
    		$strData = stripslashes($strData);
    	}
    	return $strData;
	}
}

/*************************************************
 * Send an email alert...
 *************************************************/
if (!function_exists('triggerEmail'))
{
	function triggerEmail($strSubject, $strMessage) 
	{
		global $arrAdminEmail;
		$tmpMessage  = "<p>{$strMessage}</p>";
		$tmpMessage .= "<p> --Admin</p>";
		$mail = new PHPMailer();
		$mail->IsMail();
		$mail->IsHTML(true);
		$mail->From = 'bakerdiagnostics.com';
		$mail->FromName = 'Baker Diagnostics';
		foreach ($arrAdminEmail as $key => $val)
		{
			$mail->AddAddress($key, $val);
		}
		$mail->WordWrap = 100;
		$mail->CharSet = 'UTF-8';
		$mail->Subject = $strSubject;
		$mail->Body = $tmpMessage;
		$mail->AltBody = strip_tags($tmpMessage);
		if (!$mail->Send()) 
		{
			return $mail->ErrorInfo;
		} else {
			return true;
		}
	}
}

/*************************************************
 * Send a short email message...
 *************************************************/
if (!function_exists('sendShortMessage'))
{
	function sendShortMessage($arrData)
	{
		if ($arrData['email_to'] == '')
		{
			return;
		}

		$mail = new PHPMailer();
 		$mail->IsMail(true);
 		$mail->From = $arrData['from_email'];
 		$mail->FromName = $arrData['from_name'];
 		$mail->AddAddress($arrData['email_to']); 
 		$mail->AddReplyTo($arrData['from_email']);
 		//$mail->AddBCC('randysbaker@gmail.com', 'Randy S. Baker');
 		$mail->WordWrap = 150; 	
 		$mail->IsHTML(true);
 		$mail->Subject = $arrData['subject'];
 		$mail->Body = $arrData['body'];
 		$mail->AltBody = strip_tags($arrData['body']);
 	 	if (!$mail->Send())
 	 	{
    		exit;
 	 	}
		return;
	}
}

/************************************
 * Search a multi-dimensional array...
 ************************************/
if (!function_exists('search_multi_array'))
{
	function search_multi_array($needle, $haystack)
	{
		foreach($haystack as $pos => $val)
		{
			if (is_array($val))
			{
				if (search_multi_array($needle, $val))
				{
					return 1;
				}
			} else {
				if ($val == $needle)
				{
					return 1;
				}
			}
		}
	}
}

/************************************
 * Unique multi-dimensional array...
 ************************************/
if (!function_exists('superUniqueArray'))
{
	function superUniqueArray($arrData)
	{
		$tmpData = array_map('unserialize', array_unique(array_map('serialize', $arrData)));
		foreach ($tmpData as $key => $val)
		{
			if (is_array($val))
			{
				$tmpData[$key] = superUniqueArray($val);
			}
		}
		return $tmpData;
	}
}

/************************************
 * Display a <ul> from an array...
 ************************************/
if (!function_exists('doRecursor'))
{
	function doRecursor($arrData)
	{ 
		echo "<ul type='disc'> \n"; 
		foreach ($arrData as $key => $val)
		{ 
			if (is_array($val))
			{
				doRecursor($val); 
			} else {
				if ($key == 'category')
				{
					echo " <li>{$val}</li> \n";
				}
			} 
		} 
		echo "</ul> \n"; 
	}
}

/************************************
 * Print a NAV list...
 ************************************/
if (!function_exists('printNavList'))
{
	function printNavList($arrData)
	{ 
		foreach ($arrData as $key => $val)
		{ 
			if (is_array($val))
			{
				printNavList($val); 
			} else {
				if ($key == 'category')
				{
					echo "<a href='#'>{$val}</a> <br /> \n";
				}
			} 
		} 
	}
}

/************************************
 * Get the system config settings...
 ************************************/
if (!function_exists('getSystemSettings'))
{
	function getSystemSettings($intID=1)
	{
		global $sqli;
		$arrData = array();
		$arrFields = getTableFields(SYSTEM_TABLE);
		$intID = $sqli->real_escape_string($intID);
		$sql = "SELECT * FROM `".SYSTEM_TABLE."` WHERE `id`={$intID} LIMIT 1;";
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
 * Generate the account types...
 ************************************/
if (!function_exists('generateAccountTypes'))
{
	function generateAccountTypes($isRegister=false)
	{
		global $sqli;
		$arrData = array();
		$arrFields = array('id','name');
		if ($isRegister === true)
		{
			$strSuffix = "AND `id` != 1";
		} else {
			$strSuffix = '';
		}
		$sql = "SELECT ".implode(',', $arrFields)." FROM `".ACCOUNT_TYPE_TABLE."` WHERE `status` != 86 {$strSuffix} ORDER BY `id`;";
		$res = $sqli->query($sql) or die($sqli->error);
		while ($row = $res->fetch_assoc())
		{
			$arrData[$row['id']] = $row['name'];
		}
		closeMeUp($res);
		return $arrData;
	}
}

/************************************
 * Check to see if email exists...
 ************************************/
if (!function_exists('emailExists'))
{
	function emailExists($strData, $strTable=USER_TABLE)
	{
		global $sqli;
		$isTaken = false;
		$strData = $sqli->real_escape_string($strData);
		$strTable = $sqli->real_escape_string($strTable);
		$sql = "SELECT `email` FROM `{$strTable}` WHERE `email`='{$strData}' LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		if ($res->num_rows > 0)
		{
			$isTaken = true;
		}
		closeMeUp($res);
		return $isTaken;
	}
}

/************************************
 * Get domain from email address...
 ************************************/
if (!function_exists('getDomainFromEmail'))
{
	function getDomainFromEmail($strEmail='')
	{
		$strDomain = '';
		if ($strEmail != '')
		{
			$strDomain = substr(strrchr($strEmail, '@'), 1);
			return $strDomain;
		}
	}
}

/******************************************
 * Check authentication status...
 ******************************************/
if (!function_exists('doAuthCheck'))
{
	function doAuthCheck()
	{
		if ($_SESSION['sys_user']['is_auth'] == 1 && $_SESSION['sys_user']['id'] > 0) 
		{
			return true;
		} else {
			return false;
		}
	}
}

/******************************************
 * Check authentication status (admin)...
 ******************************************/
if (!function_exists('doAuthCheckAdmin'))
{
	function doAuthCheckAdmin($strScript)
	{
		global $arrProtectedPages;
		if (in_array($strScript, $arrProtectedPages))
		{
			if ($_SESSION['sys_user']['is_auth'] != '1')
			{
				doRedirect(BASE_URL_RSB);
				return false;
			} else {
				return true;
			}
		} else if ($_SESSION['sys_user']['is_auth'] == '1' && $_SESSION['sys_user']['admin_id'] > 0) {
			return true;
		} else {
			return false;
		}
	}
}

/******************************************
 * Create a generic (guest) user...
 ******************************************/
if (!function_exists('createGuestUser'))
{
	function createGuestUser()
	{
		$arrData = array(
			'id' => 0,
		    'status' => 0,
		    'confirmed' => 1,
		    'membership_approved' => 1,
		    'subscription_id' => 1,
		    'email' => 'guest@guest.com',
		    'password' => 'guest',
		    'username' => 'guest',
		    'first_name' => 'Guest',
		    'last_name' => 'Account',
		    'account_type' => 2,
		    'job_title' => '',
		    'organization' => '',
		    'website' => '',
		    'blog' => '',
		    'organization_type' => 0,
		    'address_1' => '123 My Way',
		    'address_2' => '',
		    'city' => 'Demo',
		    'state' => 'TX',
		    'zipcode' => '78676',
		    'country' => 0,
		    'phone' => '(800) 555-1212',
		    'fax' => '',
		    'coverage' => '',
		    'image' => '',
		    'newsletter' => 0,
		    'referral_code' => '',
		    'discount_code' => '',
		    'tz' => 0,
		    'ts' => '2018-07-05 00:00:00',
		    'is_auth' => 0,
		);
		return $arrData;
    }
}

/******************************************
 * Check if user is logged in...
 ******************************************/
if (!function_exists('loggedIn'))
{
	function loggedIn()
	{
		if (doAuthCheck()) 
		{
			return true;
		} else {
			return false;
		}
	}
}

/******************************************
 * Check if user...
 ******************************************/
if (!function_exists('isUser'))
{
	function isUser()
	{
		if ($_SESSION['sys_user']['account_type'] == 1) 
		{
			return true;
		} else {
			return false;
		}
	}
}

/******************************************
 * Check if guest account...
 ******************************************/
if (!function_exists('isGuest'))
{
	function isGuest()
	{
		if ($_SESSION['sys_user']['username'] == 'guest') 
		{
			return true;
		} else {
			return false;
		}
	}
}

/******************************************
 * Check if page is protected...
 ******************************************/
if (!function_exists('isProtectedPage'))
{
	function isProtectedPage()
	{
		global $strPageName, $arrProtectedPages;
		if (in_array($strPageName, $arrProtectedPages)) 
		{
			if (!loggedIn())
			{
				doRedirect(BASE_URL_RSB.'login/');
			}
		}
		return;
	}
}

/************************************
 * Get lat / lon from database...
 ************************************/
if (!function_exists('getLatitudeLongitudeFromDatabase'))
{
	function getLatitudeLongitudeFromDatabase($strCity='', $strState='', $strZipcode='')
	{
		global $sqli;
		$arrData = array();
		$strCity = $sqli->real_escape_string($strCity);
		$strState = $sqli->real_escape_string($strState);
		$strZipcode = $sqli->real_escape_string($strZipcode);
		$sql = "SELECT `latitude`,`longitude` FROM `".ZIPCODE_TABLE."` WHERE `id`={$intID} LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		$row = $res->fetch_assoc();
		foreach ($arrFields as $key => $val)
		{
			$arrData[$val] = $row[$val];
		}
		$arrData['updated'] = $row['updated'];
		closeMeUp($res);
		$lat = $arrOutput->results[0]->geometry->location->lat;
		$lon = $arrOutput->results[0]->geometry->location->lng;		
		$arrData['latitude'] = $lat;
		$arrData['longitude'] = $lon;
		return $arrData;
	}
}

/************************************
 * Populate latitude / longitude...
 ************************************/
if (!function_exists('getLatitudeLongitude'))
{
	function getLatitudeLongitude($strAddress='')
	{
		global $sqli;
		$arrData = array();
		$strAddress = $sqli->real_escape_string($strAddress);
		$strGeocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$strAddress.'&sensor=false');
		$arrOutput = json_decode($strGeocode);
		$lat = $arrOutput->results[0]->geometry->location->lat;
		$lon = $arrOutput->results[0]->geometry->location->lng;		
		$arrData['latitude'] = $lat;
		$arrData['longitude'] = $lon;
		return $arrData;
	}
}

/************************************
 * Update latitude / longitude...
 ************************************/
if (!function_exists('updateLatitudeLongitude'))
{
	function updateLatitudeLongitude($intID=0, $strTable=PROPERTY_TABLE)
	{
		global $sqli;
		$intID = $sqli->real_escape_string($intID);
		if ($strTable == PROPERTY_TABLE)
		{
			$property = toObject(getPropertyData($intID));
		} else {
			$property = toObject(getMarketplaceData($intID));
		}
		
		if ($property->property_latitude == '' || $property->property_longitude == '')
		{
			$strData = '';
		    $intPropertyID = $property->id;
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

		    $strData = urlencode($strData);
		    $arrLatLon = geocodeMapQuest($strData);
		    $objLatLonData = $arrLatLon->results[0]->locations[0]->displayLatLng;
		    $strLat = $objLatLonData->lat;
		    $strLon = $objLatLonData->lng;
		    $sql = "UPDATE `{$strTable}` SET `property_latitude`='{$strLat}' WHERE `id`={$intPropertyID} LIMIT 1;";
		    $res = $sqli->query($sql) or die($sqli->error);
		    $sql = "UPDATE `{$strTable}` SET `property_longitude`='{$strLon}' WHERE `id`={$intPropertyID} LIMIT 1;";
		    $res = $sqli->query($sql) or die($sqli->error);
		    closeMeUp($res);
		}
		return;
	}
}

/***************************************
 * Geocode via database...
***************************************/
if (!function_exists('geocodeFromDatabase'))
{
	function geocodeFromDatabase($intID=0, $strTable=PROPERTY_TABLE)
	{
		global $sqli;
		$intID = $sqli->real_escape_string($intID);
		if ($strTable == PROPERTY_TABLE)
		{
			$property = toObject(getPropertyData($intID));
		} else {
			$property = toObject(getMarketplaceData($intID));
		}
		$strCity = $property->property_city;
		$strState = $property->property_state;
		$strZipcode = $property->property_zipcode;
		if ($strZipcode =! '')
		{
			//$sqlSuffix = "`city`='{$strCity}' AND `state`='{$strState}' AND `zipcode` LIKE '%{$strZipcode}'";
			$sqlSuffix = "`city`='{$strCity}' AND `state`='{$strState}'";
		} else {
			$sqlSuffix = "`city`='{$strCity}' AND `state`='{$strState}'";
		}

	    $sql = "SELECT `latitude`,`longitude` FROM `".GEO_DATA_TABLE."` WHERE {$sqlSuffix} LIMIT 1;";
	    $res = $sqli->query($sql) or die($sqli->error);
	    $row = $res->fetch_assoc();
	    $strLat = $row['latitude'];
	    $strLon = $row['longitude'];
	    $sql = "UPDATE `{$strTable}` SET `property_latitude`='{$strLat}', `property_longitude`='{$strLon}' WHERE `id`={$intID} LIMIT 1;";
	    $res = $sqli->query($sql) or die($sqli->error);
	    closeMeUp($res);
	}
}

/***************************************
 * Geocode via MapQuest...
***************************************/
if (!function_exists('geocodeMapQuest'))
{
	function geocodeMapQuest($strLocation='')
	{
		$arrResult = '';
		$strAPI = "http://open.mapquestapi.com/geocoding/v1/address";
		$api_key = "key=" . MAPQUEST_API_KEY;
		$location_str = "location=" . $strLocation;
		$strOutput = "outFormat=json";
		$strRequest = $strAPI . "?" . $api_key . "&" . $location_str . "&" . $strOutput;
		$response = file_get_contents($strRequest);
		if ($response)
		{
			$arrResult = json_decode(file_get_contents($strRequest));
		} else {
			$arrResult = array();
		}
		return $arrResult;
	}
}

/************************************
 * Generate Map XML markers...
 ************************************/
if (!function_exists('generateMapXMLFile'))
{
	function generateMapXMLFile($intLimit=25, $arrData=array(), $arrPropertyIDs=array())
	{
		global $sqli, $arrPropertyCategoryTypes;
		$intLimit = $sqli->real_escape_string($intLimit);
		$arrProperties = generatePropertes($intLimit, false, false, true, $arrData, $arrPropertyIDs);
		$strData .= "<?xml version='1.0'?>".LF;
		$strData .= '<markers>'.LF;
		$intIndex = 0;
		foreach ($arrProperties as $properties)
		{
		    $property = toObject($properties);
		    $category = toObject(getPropertyCategoryData($property->category_id));
		    $intID = $property->id;
		  	$strData .= '<marker ';
		  	$strData .= 'cat="' . $category->category_slug . '" ';
		  	$strData .= 'cat_id="' . $category->id . '" ';
		  	$strData .= 'id="' . $property->id . '" ';
		  	$strData .= 'name="' . parseToXML($property->property_name) . '" ';
		  	$strData .= 'address="' . parseToXML($property->property_address) . '" ';
		  	$strData .= 'city="' . parseToXML($property->property_city) . '" ';
		  	$strData .= 'state="' . parseToXML($property->property_state) . '" ';
		  	$strData .= 'zipcode="' . parseToXML($property->property_zipcode) . '" ';
		  	$strData .= 'lat="' . $property->property_latitude . '" ';
		  	$strData .= 'lng="' . $property->property_longitude . '" ';
		  	$strData .= 'type="' . $arrPropertyCategoryTypes[$property->category_id] .'" ';
		  	$strData .= 'url="' . BASE_URL_RSB.'details/'. $property->id .'/'. generateSEOURL($property->property_name) .'/' . '" ';
		  	$strData .= '/>'.LF;
		  	$intIndex++;
		}
		$strData .= '</markers>';
		return $strData;
	}
}

/************************************
 * Generate Map XML markers (2)...
 ************************************/
if (!function_exists('generateMapXMLFileMarketPlace'))
{
	function generateMapXMLFileMarketPlace($intLimit=25, $arrData=array(), $arrPropertyIDs=array())
	{
		global $sqli;
		$intLimit = $sqli->real_escape_string($intLimit);
		$arrItems = generateMarketplaceItems($intLimit, false, false, true, $arrData, $arrPropertyIDs);
		$strData .= "<?xml version='1.0'?>";
		$strData .= '<markers>';
		$intIndex = 0;
		foreach ($arrItems as $items)
		{
		    $item = toObject($items);
		    $intID = $item->id;
		  	$strData .= '<marker ';
		  	$strData .= 'id="' . $item->id . '" ';
		  	$strData .= 'name="' . parseToXML($item->property_name) . '" ';
		  	$strData .= 'address="' . parseToXML($item->property_address) . '" ';
		  	$strData .= 'city="' . parseToXML($item->property_city) . '" ';
		  	$strData .= 'state="' . parseToXML($item->property_state) . '" ';
		  	$strData .= 'zipcode="' . parseToXML($item->property_zipcode) . '" ';
		  	$strData .= 'lat="' . $item->property_latitude . '" ';
		  	$strData .= 'lng="' . $item->property_longitude . '" ';
		  	$strData .= 'type="' . 'sale' . '" ';
		  	$strData .= 'url="' . BASE_URL_RSB.'marketplace-item-details/'. $item->id .'/'. generateSEOURL($item->property_name) .'/' . '" ';
		  	$strData .= '/>';
		  	$intIndex++;
		}
		$strData .= '</markers>';
		return $strData;
	}
}

/************************************
 * Generate remote direction data...
 ************************************/
if (!function_exists('generateRemoteDirectionData'))
{
	function generateRemoteDirectionData($arrData=array())
	{
		global $sqli;
		$strData = '';
		if (!empty($arrData))
		{
			$strStart = urlencode(sanitizeData($arrData['trip_begin'], ',', ' '));
			$strStop = urlencode(sanitizeData($arrData['trip_end'], ',', ' '));
			$strURL = GOOGLE_DIRECTION_API.'origin='.$strStart.'&destination='.$strStop.'&key='.GOOGLE_API_KEY;
			$strData = getInitialXMLPage($strURL);
		}
		return $strData;
	}
}

/************************************
 * Parse the direction data...
 ************************************/
if (!function_exists('processDirectionData'))
{
	function processDirectionData($objData)
	{
		global $sqli;
		$strData = '';
		$arrProcessedData = array();
		if (!empty($objData))
		{
			$arrRoutes = $objData->routes;
			$arrLegs = $objData->routes['0']->legs['0']->steps;
			$arrProcessedData['routes'] = $arrRoutes;
			$arrProcessedData['legs'] = $arrLegs;
		}
		return $arrProcessedData;
	}
}

/************************************
 * Populate 'legs' geo data...
 ************************************/
if (!function_exists('populateLegsGeoData'))
{
	function populateLegsGeoData($objData)
	{
		global $sqli;
		$arrLegsGeoData = array();
		if (!empty($objData))
		{
			foreach ($objData as $marker)
			{
				$arrTemp = array();
				$arrTemp['lat'] = $marker->start_location->lat;
				$arrTemp['lng'] = $marker->start_location->lng;
				$arrLegsGeoData[] = $arrTemp;
			}
		}
		return $arrLegsGeoData;
	}
}

/************************************
 * Return string of proximity data...
 ************************************/
if (!function_exists('flattenProximityData'))
{
	function flattenProximityData($arrData, $strField='zip', $isText=false)
	{
		$strData = '';
		$arrTemp = array();
		if (count($arrData) > 0)
		{
			foreach ($arrData as $key => $val)
			{
				$arrTemp[] = $arrData[$key][$strField];
			}

			if ($isText != true)
			{
				$strData = implode(',', $arrTemp);
			} else {
				foreach ($arrTemp as $data)
				{
					$strData .= "'{$data}',";
				}
				$strData = substr($strData, 0, strlen($strData) - 1);
			}
		}
		return $strData;
	}
}

/************************************
 * Get distance (miles)...
 ************************************/
if (!function_exists('distance'))
{
	function distance($lat1, $lon1, $lat2, $lon2)
	{
		$t = $lon1 - $lon2;
		$d = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($t));
		$d = acos($d);
		$d = rad2deg($d);
		$m = $d * 60 * 1.1515;
		return $m;
	}
}

/************************************
 * Get proximity (miles)...
 ************************************/
if (!function_exists('getProximity'))
{
	function getProximity($strFind, $intMiles=20, $strSearch, $strState='', $isZipTable=false)
	{
		global $sqli, $arrStates;
		$arrProximity = array();
		$tmpProximity = array();
		$miles = $sqli->real_escape_string($intMiles);      			// Range in miles..
		$strFind = $sqli->real_escape_string($strFind);     			// Data to query...
		$strSearch = $sqli->real_escape_string($strSearch); 			// Field to query...
		$strState = strtoupper($sqli->real_escape_string($strState)); 	// State...
		if ($isZipTable == true)
		{
			$strDBTable = 'zipcodes'; // Target table: zipcode data
			$strLatField = 'latitude';
			$strLongField = 'longitude';
			$strQueryField = 'zipcode';
			$strCityField = 'city';
			$strStateField = 'state';
			$strSearch = 'zipcode';
		} else {
			$strDBTable = 'site_properties';
			$strLatField = 'property_latitude';
			$strLongField = 'property_longitude';
			$strQueryField = 'property_zipcode';
			$strCityField = 'property_city';
			$strStateField = 'property_state';
			$strSearch = 'property_zipcode';
		}

		if ($strState != '')
		{
			$sqlSuffix = "AND `{$strStateField}`='{$strState}'";
		} else {
			$sqlSuffix = "";
		}
		
		$sql = "SELECT `{$strLatField}`, `{$strLongField}` FROM `{$strDBTable}` WHERE `{$strQueryField}`='{$strFind}' {$sqlSuffix} LIMIT 1;";
		if (!$result = $sqli->query($sql))
		{
			die($sqli->error);
		} elseif ($result == '') {
			echo "The {$strSearch} was not found in the database...";
		} else {
			$row = $result->fetch_assoc();
			$lat = $row[$strLatField];
			$lon = $row[$strLongField];
		
			// Get the min / max latitudes and longitudes for the radius search...
			$lat_range = $miles / 69.172;
			$lon_range = abs($miles / (cos($lon) * 69.172));
			$min_lat = $lat - $lat_range; 
			$max_lat = $lat + $lat_range;
			$min_lon = $lon - $lon_range;
			$max_lon = $lon + $lon_range;

			// Apply the min / max coordinates to the MySQL query to only select those items within the specified range...
			$sql2 = "SELECT * FROM `{$strDBTable}` WHERE ((`{$strLatField}` >= {$min_lat} AND `{$strLatField}` <= {$max_lat}) AND (`{$strLongField}` >= {$min_lon} AND `{$strLongField}` <= {$max_lon})) AND `{$strQueryField}` != '';";
			if (!$result2 = $sqli->query($sql2))
			{
				die($sqli->error);
			} else {
				while ($row2 = $result2->fetch_assoc())
				{
					if (!in_array($row2[$strQueryField], $tmpProximity))
					{
						$dist = distance($lat, $lon, $row2[$strLatField], $row2[$strLongField]);
						if ($dist <= $miles)
						{
							$dist = round($dist, 1);
							$tmpState = strtoupper($row2[$strStateField]);
							$myProximity[$strQueryField] = ucwords($row2[$strQueryField]);
							$myProximity['city'] = $row2[$strCityField];
							$myProximity['state'] = strtoupper($row2[$strStateField]);
							$myProximity['state_name'] = $arrStates[$tmpState];
							$myProximity['distance'] = $dist;
							$arrProximity[] = $myProximity;
						}
						$tmpProximity[] = $row2[$strQueryField];
					}
				}
			}
		}
		closeMeUp($result);
		closeMeUp($result2);
		return $arrProximity;
	}
}

/************************************
 * Get proximity - GEO (miles)...
 ************************************/
if (!function_exists('getProximityGEO'))
{
	function getProximityGEO($strField='', $intMiles=20, $arrData=array(), $arrCategories=array())
	{
		global $sqli, $arrStates;
		$arrProximity = array();
		$tmpProximity = array();
		$miles = $sqli->real_escape_string($intMiles);
		$strField = $sqli->real_escape_string($strField);
		$strDBTable = 'site_properties';
		$strLatField = 'property_latitude';
		$strLongField = 'property_longitude';
		if (!empty($arrCategories))
		{
			$arrCats = array_keys($arrCategories);
			$sqlSuffix = " AND `category_id` IN (".implode(',', $arrCats).")";
		} else {
			$sqlSuffix = '';
		}

		if (!empty($arrData))
		{
			foreach ($arrData as $items)
			{
				$item = toObject($items);
				$lat = $item->lat;
				$lon = $item->lng;
			
				// Get the min / max latitudes and longitudes for the radius search...
				$lat_range = $miles / 69.172;
				$lon_range = abs($miles / (cos($lon) * 69.172));
				$min_lat = $lat - $lat_range; 
				$max_lat = $lat + $lat_range;
				$min_lon = $lon - $lon_range;
				$max_lon = $lon + $lon_range;

				// Apply the min / max coordinates to the MySQL query to only select those items within the specified range...
				$sql = "SELECT `{$strField}`,`{$strLatField}`,`{$strLongField}` FROM `{$strDBTable}` WHERE ((`{$strLatField}` >= {$min_lat} AND `{$strLatField}` <= {$max_lat}) AND (`{$strLongField}` >= {$min_lon} AND `{$strLongField}` <= {$max_lon})) AND `status` != 86 AND `property_latitude` != '' AND `property_longitude` != '' {$sqlSuffix};";
				if (!$result = $sqli->query($sql))
				{
					die($sqli->error);
				} else {
					while ($row = $result->fetch_assoc())
					{
						$dist = distance($lat, $lon, $row[$strLatField], $row[$strLongField]);
						if ($dist <= $miles)
						{
							$dist = round($dist, 1);
							$tmpProximity[] = $row[$strField];
						}
					}
				}
			}
			closeMeUp($result);
			$arrProximity = array_unique($tmpProximity);
		}
		return $arrProximity;
	}
}

/************************************
 * Generate list of dates in range...
 ************************************/
if (!function_exists('generateDatesInRange'))
{
    function generateDatesInRange($arrDates=array())
    {
        $arrData = array();
        if (!empty($arrDates))
        {
            foreach ($arrDates as $strDateRange)
            {
                $tmpDates = explode(' - ', $strDateRange);
                $begin = new DateTime($tmpDates[0]);
                $end = new DateTime($tmpDates[1]);
                $end = $end->modify('+1 day'); 
                $interval = new DateInterval('P1D');
                $daterange = new DatePeriod($begin, $interval, $end);
                foreach ($daterange as $date)
                {
                    $arrData[] = $date->format('Y-m-d');
                }
            }
        }
        return $arrData;
    }
}
?>