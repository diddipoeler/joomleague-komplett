<?php
/**
 * @copyright	Copyright (C) 2006-2012 JoomLeague.net. All rights reserved.
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
require_once(JPATH_COMPONENT.DS.'models'.DS.'item.php');

/**
 * Joomleague Component team Model
 *
 * @author	Marco Vaninetti <martizva@libero.it>
 * @package	JoomLeague
 * @since	0.1
 */
class JoomleagueModelTeam extends JoomleagueModelItem
{

	/**
	 * Method to remove teams and assigned teamstaff of only one project
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	0.1
	 */
	function deleteOne($project_id)
	{
		if ($project_id > 0)
		{
			$query = 'DELETE FROM #__joomleague_team_trainingdata WHERE project_id='.$project_id;
			$this->_db->setQuery($query);
			if (!$this->_db->query())
			{
				$this->setError($this->_db->getErrorMsg());
				return false;
			}

			$query = 'DELETE FROM #__joomleague_project_team WHERE project_id='.$project_id;
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
	 * Method to remove a team
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	0.1
	 */
	function delete($cid=array())
	{
		if (count($cid))
		{
			JArrayHelper::toInteger($cid);
			$cids = implode(',',$cid);
			$query = "DELETE FROM #__joomleague_team WHERE id IN ($cids)";
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
	 * Method to load content team data
	 *
	 * @access	private
	 * @return	boolean	True on success
	 * @since	0.1
	 */
	function _loadData()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_data))
		{
			$query = 'SELECT * FROM #__joomleague_team WHERE id='.(int)$this->_id;

			$this->_db->setQuery($query);
			$this->_data = $this->_db->loadObject();
			return (boolean) $this->_data;
		}
		return true;
	}

	/**
	 * Method to initialise the team data
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
			$team = new stdClass();
			$team->id				= 0;
			$team->club_id			= null;
			$team->name				= null;
			$team->short_name		= null;
			$team->middle_name		= null;
			$team->info				= null;
			$team->notes			= null;
			$team->website			= null;
			$team->playground		= 0;
			$team->ordering			= 0;
			$team->checked_out		= 0;
			$team->checked_out_time = 0;
			$team->alias			= null;
			$team->extended			= null;
			$team->picture			= null;
			$team->modified			= null;
			$team->modified_by		= null;
			$this->_data			= $team;
			return (boolean) $this->_data;
		}
		return true;
	}

	/**
	* Method to return the query that will obtain all ordering versus teams
	* It can be used to fill a list box with value/text data.
	*
	* @access  public
	* @return  string
	* @since 1.5
	*/
	function getOrderingAndTeamQuery()
	{
		return 'SELECT ordering AS value,name AS text FROM #__joomleague_team ORDER BY ordering';
	}	

	/**
	 * Method to return a clubs array (id, name)
	 *
	 * @access	public
	 * @return	array
	 * @since 0.1
	 */
	function getClubs()
	{
		$query = 'SELECT id, name FROM #__joomleague_club ORDER BY name ASC ';

		$this->_db->setQuery($query);
		if (!$result = $this->_db->loadObjectList())
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		return $result;
	}

	function copyTeams()
	{
		$result=true;
		$cids = JRequest::getVar('cid',array(0),'post','array');
		JArrayHelper::toInteger($cids);

		foreach ($cids AS $cid)
		{
			$query = "SELECT * FROM #__joomleague_team WHERE id=$cid";
			$this->_db->setQuery($query);
			$this->_db->query();
			if ($object = $this->_db->loadObject())
			{
				//echo '<pre>'; print_r($object); echo '</pre>';
				$newTeamName = JText::sprintf('!Copy of %1$s',$object->name);
				$query = "SELECT id FROM #__joomleague_team WHERE name='$newTeamName'";
				$this->_db->setQuery($query);
				$this->_db->query();
				$found=$this->_db->loadResult();

				if (!$found)
				{
					$object->name=$newTeamName;
					$object->ordering=(-10);
					$teamArray=(array) $object;
					unset($teamArray['id']);
					if (!$this->store($teamArray)){echo $this->getError();}
				}
			}
		}

		return $result;
	}
}
?>