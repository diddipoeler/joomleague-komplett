<?php
/**
* @copyright	Copyright (C) 2005-2012 JoomLeague.net. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');
require_once (JPATH_COMPONENT.DS.'models'.DS.'item.php');

/**
 * Joomleague Component statistic Model
 *
 * @package	JoomLeague
 * @since	1.5.0a
 */
class JoomleagueModelStatistic extends JoomleagueModelItem
{
	/**
	 * Method to remove an event
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	0.1
	 */
	function delete($cid = array())
	{
		$result = false;

		if (count($cid))
		{
			JArrayHelper::toInteger($cid);
			$cids = implode(',', $cid);

			// first check that it not used in any match events
			$query = ' SELECT ms.id '
			       . ' FROM #__joomleague_match_statistic AS ms '
			       . ' WHERE ms.statistic_id IN ('. implode(',', $cid) .')'
			       ;
			$this->_db->setQuery($query);
			$this->_db->query();
			if ($this->_db->getAffectedRows()) {
				$this->setError(JText::_('JL_ADMIN_STATISTIC_MODEL_CANT_DELETE_STATS_MATCHES'));
				return false;
			}

			// then check that it is not assigned to positions
			$query = ' SELECT id '
			       . ' FROM #__joomleague_position_statistic '
			       . ' WHERE statistic_id IN ('. implode(',', $cid) .')'
			       ;
			$this->_db->setQuery($query);
			$this->_db->query();
			if ($this->_db->getAffectedRows()) {
				$this->setError(JText::_('JL_ADMIN_STATISTIC_MODEL_CANT_DELETE_STATS_MATCHES'));
				return false;
			}

			$query = ' DELETE
						FROM #__joomleague_statistic
						WHERE id IN (' . $cids . ')';

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
	 * Method to remove a statistics and associated data
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	0.1
	 */
	function fulldelete($cid = array())
	{
		$result = false;

		if (count($cid))
		{
			JArrayHelper::toInteger($cid);
			$cids = implode(',', $cid);

			// first check that it not used in any match events
			$query = ' DELETE '
			       . ' FROM #__joomleague_match_statistic '
			       . ' WHERE statistic_id IN ('. implode(',', $cid) .')'
			       ;
			$this->_db->setQuery($query);
			if (!$this->_db->query()) {
				$this->setError(JText::_('JL_ADMIN_STATISTIC_MODEL_ERROR_DELETE_STATS_MATCHES').': '.$this->_db->getErrorMsg());
				return false;
			}

			// then check that it is not assigned to positions
			$query = ' DELETE '
			       . ' FROM #__joomleague_position_statistic '
			       . ' WHERE statistic_id IN ('. implode(',', $cid) .')'
			       ;
			$this->_db->setQuery($query);
			if (!$this->_db->query()) {
				$this->setError(JText::_('JL_ADMIN_STATISTIC_MODEL_ERROR_DELETE_STATS_POS').': '.$this->_db->getErrorMsg());
				return false;
			}

			$query = ' DELETE
						FROM #__joomleague_statistic
						WHERE id IN (' . $cids . ')';

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
	 * Method to load content event data
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
			$query = '	SELECT *
						FROM #__joomleague_statistic
						WHERE id = ' . (int) $this->_id;

			$this->_db->setQuery($query);
			$this->_data = $this->_db->loadObject();
			return (boolean) $this->_data;
		}
		return true;
	}

	/**
	 * Method to initialise the event data
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
			$statistic					= new stdClass();
			$statistic->id				= 0;
			$statistic->name			= null;
			$statistic->short			= null;
			$statistic->icon			= '';
			$statistic->class			= '';
			$statistic->calculated		= 0;
			$statistic->note			= '';
			$statistic->baseparams		= null;
			$statistic->params			= null;
			$statistic->sports_type_id	= 1;
			$statistic->published		= 0;
			$statistic->ordering		= 0;
			$statistic->checked_out		= 0;
			$statistic->checked_out_time= 0;
			$statistic->alias 			= null;
			$statistic->modified		= null;
			$statistic->modified_by		= null;
			$this->_data				= $statistic;
			return (boolean) $this->_data;
		}
		return true;
	}

	/**
	* Method to return the query that will obtain all ordering versus statistics
	* It can be used to fill a list box with value/text data.
	*
	* @access  public
	* @return  string
	* @since 1.5
	*/
	function getOrderingAndStatisticQuery()
	{
		return 'SELECT ordering AS value,name AS text FROM #__joomleague_statistic ORDER BY ordering';
	}	

}
?>