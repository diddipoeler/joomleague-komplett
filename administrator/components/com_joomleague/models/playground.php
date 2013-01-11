<?php
/**
 * @copyright	Copyright (C) 2006-2012 JoomLeague.net. All rights reserved.
 * @license		GNU/GPL,see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License,and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');
require_once (JPATH_COMPONENT.DS.'models'.DS.'item.php');

/**
 * Joomleague Component Venue Model
 *
 * @package	JoomLeague
 * @since	0.1
 */
class JoomleagueModelPlayground extends JoomleagueModelItem
{
	/**
	 * Method to remove venues
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	0.1
	 */
	function delete($cid=array())
	{
		$result=false;
		if (count($cid))
		{
			JArrayHelper::toInteger($cid);
			$cids=implode(',',$cid);
			/*
			$query="SELECT id FROM #__joomleague_club WHERE standard_playground IN ($cids)";
			//echo '<pre>'.print_r($query,true).'</pre>';
			$this->_db->setQuery($query);
			if ($this->_db->loadResult())
			{
				$this->setError(JText::_('JL_ADMIN_VENUE_MODEL_ERROR_CLUB_EXISTS'));
				return false;
			}
			*/
			$query="SELECT id FROM #__joomleague_project_team WHERE standard_playground IN ($cids)";
			$this->_db->setQuery($query);
			if ($this->_db->loadResult())
			{
				$this->setError(JText::_('JL_ADMIN_VENUE_MODEL_ERROR_P_TEAM_EXISTS'));
				return false;
			}
			$query="SELECT id FROM #__joomleague_match WHERE playground_id IN ($cids)";
			$this->_db->setQuery($query);
			if ($this->_db->loadResult())
			{
				$this->setError(JText::_('JL_ADMIN_VENUE_MODEL_ERROR_MATCH_EXISTS'));
				return false;
			}
			$query="DELETE FROM #__joomleague_playground WHERE id IN ($cids)";
			$this->_db->setQuery($query);
			if(!$this->_db->query())
			{
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}
		return true;
	}

	/**
	 * Method to load content venue data
	 *
	 * @access	private
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function _loadData()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_data))
		{
			$query='SELECT * FROM #__joomleague_playground WHERE id='.(int) $this->_id;
			$this->_db->setQuery($query);
			$this->_data=$this->_db->loadObject();
			return (boolean) $this->_data;
		}
		return true;
	}

	/**
	 * Method to initialise the venue data
	 *
	 * @access	private
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function _initData()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_data))
		{
			$venue=new stdClass();
			$venue->id					= 0;
			$venue->name				= null;
			$venue->short_name			= null;
			$venue->address				= null;
			$venue->zipcode				= null;
		  	$venue->city				= null;
			$venue->country				= null;
			$venue->picture				= null;
			$venue->notes				= null;
			$venue->max_visitors		= null;
			$venue->club_id				= null;
			$venue->website				= null;
			$venue->checked_out			= 0;
			$venue->checked_out_time	= 0;
			$venue->extended			= null;
			$venue->ordering			= 0;
			$venue->alias				= null;
			$venue->modified			= null;
			$venue->modified_by			= null;
			$this->_data				= $venue;
			return (boolean) $this->_data;
		}
		return true;
	}

  function JLgetLatLongGeoCoords($address)
{
    global $mainframe, $option;
    $mainframe	=& JFactory::getApplication();
    $coords = array();
    $mainframe->enqueueMessage(JText::_('JL_ADMIN_CLUB_GET_GOOGLE_MAP_LONGITUDE_LATITUDE'),'NOTICE');
    
    $url = 'http://maps.google.com/maps/geo?q='.urlencode($address).'&output=csv&sensor=false';
    $get = file_get_contents($url);
    $records = explode(",",$get);
    
//     echo 'JLgetLatLongGeoCoords records url<pre>',print_r($url,true),'</pre><br>';
//     echo 'JLgetLatLongGeoCoords records<pre>',print_r($records,true),'</pre><br>'; 
    return $records;
    }  

function JLgetGeoCoords($address)
{
    global $mainframe, $option;
    $mainframe	=& JFactory::getApplication();
      
    /*
      OBSOLETE, now using utf8_encode
      
      // replace special characters (eg. German "Umlaute")
      $address = str_replace("ä", "ae", $address);
      $address = str_replace("ö", "oe", $address);
      $address = str_replace("ü", "ue", $address);
      $address = str_replace("Ä", "Ae", $address);
      $address = str_replace("Ö", "Oe", $address);
      $address = str_replace("Ü", "Ue", $address);
      $address = str_replace("ß", "ss", $address);
    */
    
    //$address = utf8_encode($address);
    
    //echo 'getGeoCoords address -> '.$address.'<br>';
    
    // call geoencoding api with param json for output
    $geoCodeURL = "http://maps.google.com/maps/api/geocode/json?address=".
                  urlencode($address)."&sensor=false";
    
    //echo 'JLgetGeoCoords records geoCodeURL<pre>',print_r($geoCodeURL,true),'</pre><br>';
    //$result = json_decode(file_get_contents($geoCodeURL), true);
    
    $initial = curl_init();
curl_setopt($initial, CURLOPT_URL, $geoCodeURL);
curl_setopt($initial, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($initial, CURLOPT_CONNECTTIMEOUT, 5);
$file_content = curl_exec($initial);
curl_close($initial);
$result = json_decode($file_content, true);

/*
    $xml = simplexml_load_string($geoCodeURL);
    $xml = simplexml_load_file($geoCodeURL);
    echo 'getGeoCoords xml<br><pre>';
    print_r($xml);
    echo '</pre><br>';
*/    
    
    /*
    $coords['status'] = $result["status"];
    
    if ( isset($result["results"][0]) )
    {        
    $coords['lat'] = $result["results"][0]["geometry"]["location"]["lat"];
    $coords['lng'] = $result["results"][0]["geometry"]["location"]["lng"];
    }
    */
    
    if ( $result['status'] == 'OVER_QUERY_LIMIT' )
    {
    $mainframe->enqueueMessage(JText::_('GOOGLE MAP STATUS: OVER_QUERY_LIMIT'),'ERROR');
    return '';
    }
    else
    {
    return $result;
    }
    
    
    
}

function getAddressString( )
	{
		$playground = $this->_data;
		if ( !isset ( $playground ) ) { return null; }

		$address_parts = array();
		if (!empty($playground->address))
		{
			$address_parts[] = $playground->address;
		}
		if (!empty($playground->state))
		{
			$address_parts[] = $playground->state;
		}
		if (!empty($playground->location))
		{
			if (!empty($playground->zipcode))
			{
				$address_parts[] = $playground->zipcode. ' ' .$playground->location;
			}
			else
			{
				$address_parts[] = $playground->location;
			}
		}
		if (!empty($playground->country))
		{
			$address_parts[] = Countries::getShortCountryName($playground->country);
		}
		$address = implode(', ', $address_parts);
		return $address;
	}
      
	/**
	* Method to return the query that will obtain all ordering versus playgrounds
	* It can be used to fill a list box with value/text data.
	*
	* @access  public
	* @return  string
	* @since 1.5
	*/
	function getOrderingAndPlaygroundQuery()
	{
		return 'SELECT ordering AS value,name AS text FROM #__joomleague_playground ORDER BY ordering';
	}		
	
	/**
	* Method to return a club array (id,name)
   	*
	* @access  public
	* @return  array
	* @since 0.1
	*/
	function getClubs()
	{
		$query='SELECT id,name FROM #__joomleague_club  ORDER BY name ASC ';
		$this->_db->setQuery($query);
		if (!$result=$this->_db->loadObjectList())
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		return $result;
	}
}
?>