<?php
/******************************************************
 * Created by: Randy S. Baker
 * Created on: 06-JAN-2016
 * ----------------------------------------------------
 * Twitter Tweets (feed) (ajax.twitter.feed.php)
 ******************************************************/

/************************************
 * Load core Twitter functions...
 ************************************/
require_once ('twitteroauth/autoload.php');
use Abraham\TwitterOAuth\TwitterOAuth;

/************************************
 * Load core Twitter functions...
 ************************************/
if (!function_exists('getConnectionWithAccessToken'))
{
	function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) 
	{
		$connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
		return $connection;
	}
}

/************************************
 * Initialize data...
 ************************************/
$arrTweets = array();
$intTweets = 10;
$strScreenname = TWITTER_SCREEN_NAME;
$consumer_key = TWITTER_CONSUMER_KEY;
$consumer_secret = TWITTER_CONSUMER_SECRET;
$oauth_access_token = TWITTER_OAUTH_ACCESS_TOKEN;
$oauth_access_token_secret = TWITTER_OAUTH_ACCESS_TOKEN_SECRET;

/************************************
 * Establish connection to API...
 ************************************/
$connection = getConnectionWithAccessToken($consumer_key, $consumer_secret, $oauth_access_token, $oauth_access_token_secret);

/************************************
 * Get tweets...
 ************************************/
$tweets = $connection->get('statuses/user_timeline', array('screen_name' => $strScreenname, 'count' => $intTweets, 'exclude_replies' => true));

/************************************
 * Parse tweets...
 ************************************/
foreach ($tweets as $tweet)
{
	$arrTemp = array();
	$arrTemp['created_at'] = $tweet->created_at;
	$arrTemp['text'] = $tweet->text;
	$arrTemp['name'] = $tweet->user->name;
	$arrTemp['screen_name'] = $tweet->user->screen_name;
	$arrTweets[] = $arrTemp;
}
?>