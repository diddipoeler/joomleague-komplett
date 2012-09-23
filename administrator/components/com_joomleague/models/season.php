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
 * Joomleague Component Season Model
 *
 * @author	Julien Vonthron <julien.vonthron@gmail.com>
 * @package	JoomLeague
 * @since	0.1
 */
class JoomleagueModelSeason extends JoomleagueModelItem
{
	/**
	 * Method to remove a season
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
			$query="SELECT id FROM #__joomleague_project WHERE sports_type_id IN ($cids)";
			//echo '<pre>'.print_r($query,true).'</pre>';
			$this->_db->setQuery($query);
			if ($this->_db->loadResult())
			{
				$this->setError(JText::_('JL_ADMIN_SEASON_MODEL_ERROR_PROJECT_EXISTS'));
				return false;
			}
			$query="DELETE FROM #__joomleague_season WHERE id IN ($cids)";
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
	 * Method to load content season data
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
			$query='SELECT * FROM #__joomleague_season WHERE id='.(int) $this->_id;
			$this->_db->setQuery($query);
			$this->_data=$this->_db->loadObject();
			return (boolean) $this->_data;
		}
		return true;
	}

	/**
	 * Method to initialise the season data
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
			$season						= new stdClass();
			$season->id					= 0;
			$season->name				= null;
			$season->alias				= null;
			$season->checked_out		= 0;
			$season->checked_out_time	= 0;
			$season->extended			= null;
			$season->ordering			= 0;
			$season->modified			= null;
			$season->modified_by		= null;
			
			$this->_data				= $season;

			return (boolean) $this->_data;
		}

		return true;
	}

	/**
	* Method to return the query that will obtain all ordering versus seasons
	* It can be used to fill a list box with value/text data.
	*
	* @access  public
	* @return  string
	* @since 1.5
	*/
	function getOrderingAndSeasonQuery()
	{
		return 'SELECT ordering AS value,name AS text FROM #__joomleague_season ORDER BY ordering';
	}		
	
	/**
	 * Method to add a new season if not already exists
	 *
	 * @access	private
	 * @return	boolean	True on success
	 * @since	1.5
	 **/
	function addSeason($newseason)
	{
		//check if season exists. If not add a new season to table
		$query="SELECT * FROM #__joomleague_season WHERE name='$newseason'";
		$this->_db->setQuery($query);
		if ($seasonObject=$this->_db->loadObject())
		{
			//season already exists
			return $seasonObject->id;
		}
		//season does NOT exist and has to be created
		$p_season =& $this->getTable();
		$p_season->set('name',$newseason);
		if (!$p_season->store())
		{
			$seasonObject->id=0;
		}
		else
		{
			$seasonObject->id=$this->_db->insertid(); //mysql_insert_id();
		}
		return $seasonObject->id;
	}

}
?>