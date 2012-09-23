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
 * Joomleague Component sportstype Model
 *
 * @author	Julien Vonthron <julien.vonthron@gmail.com>
 * @package	JoomLeague
 * @since	0.1
 */
class JoomleagueModelSportsType extends JoomleagueModelItem
{
	/**
	 * Method to remove a sportstype
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
			$query="SELECT COUNT(id) FROM #__joomleague_sports_type";
			$this->_db->setQuery($query);
			if ($this->_db->loadResult()==count($cid))
			{
				$this->setError(JText::_('JL_ADMIN_SPORTTYPE_MODEL_ERROR_LAST_SPORTSTYPE'));
				return false;
			}
			$query="SELECT id FROM #__joomleague_eventtype WHERE sports_type_id IN ($cids)";
			$this->_db->setQuery($query);
			if ($this->_db->loadResult())
			{
				$this->setError(JText::_('JL_ADMIN_SPORTTYPE_MODEL_ERROR_EVENT_EXISTS'));
				return false;
			}
			$query="SELECT id FROM #__joomleague_position WHERE sports_type_id IN ($cids)";
			$this->_db->setQuery($query);
			if ($this->_db->loadResult())
			{
				$this->setError(JText::_('JL_ADMIN_SPORTTYPE_MODEL_ERROR_POSITION_EXISTS'));
				return false;
			}
			$query="SELECT id FROM #__joomleague_project WHERE sports_type_id IN ($cids)";
			$this->_db->setQuery($query);
			if ($this->_db->loadResult())
			{
				$this->setError(JText::_('JL_ADMIN_SPORTTYPE_MODEL_ERROR_PROJECT_EXISTS'));
				return false;
			}
			$query="DELETE FROM #__joomleague_sports_type WHERE id IN ($cids)";
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
	 * Method to load content sportstype data
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
			$query='SELECT * FROM #__joomleague_sports_type WHERE id='.(int) $this->_id;
			$this->_db->setQuery($query);
			$this->_data=$this->_db->loadObject();
			return (boolean) $this->_data;
		}
		return true;
	}

	/**
	 * Method to initialise the sportstype data
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
			$sportstype						= new stdClass();
			$sportstype->id					= 0;
			$sportstype->name				= null;
			$sportstype->icon			= '';
			$sportstype->ordering			= 0;
			$sportstype->checked_out		= 0;
			$sportstype->checked_out_time	= 0;
			$sportstype->modified			= null;
			$sportstype->modified_by		= null;
				
			$this->_data					= $sportstype;

			return (boolean) $this->_data;
		}

		return true;
	}

	/**
	* Method to return the query that will obtain all ordering versus sportstypes
	* It can be used to fill a list box with value/text data.
	*
	* @access  public
	* @return  string
	* @since 1.5
	*/
	function getOrderingAndSportstypeQuery()
	{
		return 'SELECT ordering AS value,name AS text FROM #__joomleague_sports_type ORDER BY ordering';
	}		
	
	/**
	 * Method to add a new sportstype if not already exists
	 *
	 * @access	private
	 * @return	boolean	True on success
	 * @since	1.5
	 **/
	function addSportsType($newsportstype)
	{
		//check if sportstype exists. If not add a new sportstype to table
		$query="SELECT * FROM #__joomleague_sport_type WHERE name=".$this->_db->Quote($newsportstype);
		$this->_db->setQuery($query);
		$sportstypeObject=$this->_db->loadObject();
		if ($sportstypeObject->id)
		{
			//sportstype already exists
			return $sportstypeObject->id;
		}

		//sportstype does NOT exist and has to be created
		$p_sportstype =& $this->getTable();
		$p_sportstype->set('name',$newsportstype);

		if (!$p_sportstype->store())
		{
			$sportstypeObject->id=0;
		}
		else
		{
			$sportstypeObject->id=$this->_db->insertid(); //mysql_insert_id();
		}
		return $sportstypeObject->id;
	}

}
?>