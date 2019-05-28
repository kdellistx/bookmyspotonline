<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 03-MAR-2018
 * ---------------------------------------------------
 * RSS Feed Parser (rss_feed.php)
 *****************************************************/

/*****************************************************
 * NOTES:
 * ---------------------------------------------------
 * public function __construct($data, $isfile=true, $savedata=false)
 * public function getDb()
 * public function getItem($inx)
 * public function getRawData()
 *****************************************************/

/************************************
 * Namespace definition...
 ************************************/
namespace bakerdiagnostics;

/************************************
 * Include external classes...
 ************************************/
use Exception;

/************************************
 * Class definition...
 ************************************/
class RssFeed 
{
  private $tdb;
  private $rawdata;
  private $values;
  private $tags;
  
  /************************************
   * Constructor...
   ************************************/
  public function __construct($data, $isfile=true, $savedata=false) 
  {
    $this->tdb = array();
    
    if ($isfile)
    {
      try 
      {
        $data = @file_get_contents($data);
        if ($data === false)
        {
          throw new Exception("file_get_contents() failed", 5001);
        }
      } catch (Exception $e) {
        throw new Exception("file_get_contents() failed", 5001);
      }
      
      if ($savedata)
      {
        $this->rawdata = $data;
      }
    }
  
    $parser = xml_parser_create();
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
    xml_parse_into_struct($parser, $data, $values, $tags);
    xml_parser_free($parser);

    $this->values = $values;
    //showDebug($values, 'values array', true);
    $this->tags = $tags;
    foreach ($tags as $key => $val)
    {
      if ($key == "item")
      {
        // each contiguous pair of array entries are the 
        // lower and upper range for each item definition
        for ($i=0; $i < count($val); $i+=2)
        {
          $offset = $val[$i] + 1;
          $len = $val[$i + 1] - $offset;
          $tdb[] = $this->parseVal(array_slice($values, $offset, $len));
        }
      } else {
        continue;
      }
    }
    //showDebug($tdb, 'tdb array', true);
    $this->tdb = $tdb;
  }

  /************************************
   * Parse value...
   ************************************/
  private function parseVal($vals)
  {
    for ($i=0; $i < count($vals); $i++)
    {
      $val[$vals[$i]['tag']] = $vals[$i]['value'];

      if ($vals[$i]['tag'] == 'media:content')
      {
        if ($vals[$i]['attributes']['url'] != '')
        {
          $val[$vals[$i]['tag']] = $vals[$i]['attributes']['url'];
          //showDebug($vals, 'vals data aray', true);
        }
      }

      if ($vals[$i]['tag'] == 'media:thumbnail')
      {
        if ($vals[$i]['attributes']['url'] != '')
        {
          $val[$vals[$i]['tag']] = $vals[$i]['attributes']['url'];
          //showDebug($vals, 'vals data aray', true);
        }
      }

      if ($vals[$i]['tag'] == 'enclosure')
      {
        $val[$vals[$i]['tag']] = $vals[$i]['attributes']['url'];
        //showDebug($vals, 'vals data aray', true);
      }
    }
    return $val;
  }

  /************************************
   * Load the feed...
   ************************************/
  public function getDb()
  {
    return $this->tdb;
  }

  /************************************
   * Get an item...
   ************************************/
  public function getItem($inx)
  {
    return $this->tdb[$inx];
  }

  /************************************
   * Get raw data...
   ************************************/
  public function getRawData()
  {
    return $this->rawdata;
  }

  /************************************
   * Get values...
   ************************************/
  public function getValues()
  {
    return $this->values;
  }

  /************************************
   * Get tags...
   ************************************/
  public function getTags()
  {
    return $this->tags;
  }
}