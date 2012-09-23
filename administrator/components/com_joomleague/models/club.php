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
require_once(JPATH_COMPONENT.DS.'models'.DS.'item.php');

/*
diddipoeler

require_once(JPATH_COMPONENT_SITE . DS . 'helpers' . DS . 'simple-gmap-api' . DS . "simpleGMapAPI.php");
require_once(JPATH_COMPONENT_SITE . DS . 'helpers' . DS . 'simple-gmap-api' . DS . "simpleGMapGeocoder.php");
*/

/**
 * Joomleague Component Club Model
 *
 * @package	JoomLeague
 * @since	0.1
 */
class JoomleagueModelClub extends JoomleagueModelItem
{
	/**
	 * Method to remove a club
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
			$query="SELECT id FROM #__joomleague_team WHERE club_id IN ($cids)";
			//echo '<pre>'.print_r($query,true).'</pre>';
			$this->_db->setQuery($query);
			if ($this->_db->loadResult())
			{
				$this->setError(JText::_('JL_ADMIN_CLUB_MODEL_ERROR_TEAM_EXISTS'));
				return false;
			}
			$query="SELECT id FROM #__joomleague_playground WHERE club_id IN ($cids)";
			$this->_db->setQuery($query);
			if ($this->_db->loadResult())
			{
				$this->setError(JText::_('JL_ADMIN_CLUB_MODEL_ERROR_VENUE_EXISTS'));
				return false;
			}
			$query="DELETE FROM #__joomleague_club WHERE id IN ($cids)";
			$this->_db->setQuery($query);
			if (!$this->_db->query())
			{
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}
		return true;
	}

	/**
	 * Method to load content club data
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
			$query='SELECT * FROM #__joomleague_club WHERE id='.(int) $this->_id;
			$this->_db->setQuery($query);
			$this->_data=$this->_db->loadObject();
			return (boolean) $this->_data;
		}
		return true;
	}

	/**
	 * Method to initialise the club data
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
			$club=new stdClass();
			$club->id					= 0;
			$club->name					= null;
			$club->admin				= 0;
			$club->address				= null;
			$club->zipcode				= null;
			$club->location				= null;
			$club->state				= null;
			$club->country				= null;
			$club->founded				= null;
			$club->phone				= null;
			$club->fax					= null;
			$club->email				= null;
			$club->website				= null;
			$club->president			= null;
			$club->manager				= null;
			$club->logo_big				= null;
			$club->logo_middle			= null;
			$club->logo_small			= null;
			$club->logo_icon			= null;
			$club->stadium_picture		= null;
			$club->standard_playground	= null;
			$club->extended				= null;
			$club->ordering				= 0;
			$club->checked_out			= 0;
			$club->checked_out_time		= 0;
			$club->ordering				= 0;
			$club->alias				= null;
			$club->modified				= null;
			$club->modified_by			= null;
			$this->_data				= $club;
			return (boolean) $this->_data;
		}
		return true;
	}

	/**
	* Method to return the query that will obtain all ordering versus clubs
	* It can be used to fill a list box with value/text data.
	*
	* @access  public
	* @return  string
	* @since 1.5
	*/
	function getOrderingAndClubQuery()
	{
		return 'SELECT ordering AS value,name AS text FROM #__joomleague_club ORDER BY ordering';
	}	
	
	function getAddressString( )
	{
		$club = $this->_data;
		if ( !isset ( $club ) ) { return null; }

		$address_parts = array();
		if (!empty($club->address))
		{
			$address_parts[] = $club->address;
		}
		if (!empty($club->state))
		{
			$address_parts[] = $club->state;
		}
		if (!empty($club->location))
		{
			if (!empty($club->zipcode))
			{
				$address_parts[] = $club->zipcode. ' ' .$club->location;
			}
			else
			{
				$address_parts[] = $club->location;
			}
		}
		if (!empty($club->country))
		{
			$address_parts[] = Countries::getShortCountryName($club->country);
		}
		$address = implode(', ', $address_parts);
		return $address;
	}
	
	function JLgetGeoCoords($address)
{
    $coords = array();
    
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
    
    return $result;
}
	/**
	* Method to return a playgrounds array (id,name)
	*
	* @access  public
	* @return  array
	* @since 0.1
	*/
	function getPlaygrounds()
	{
		$query='SELECT id AS value, name AS text FROM #__joomleague_playground ORDER BY text ASC';
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