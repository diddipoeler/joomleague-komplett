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
require_once (JPATH_COMPONENT.DS.'models'.DS.'item.php');

/**
 * Joomleague Component project Model
 *
 * @author	Marco Vaninetti <martizva@libero.it>
 * @package	JoomLeague
 * @since	0.1
 */
class JoomleagueModelProject extends JoomleagueModelItem
{

	/**
	 * Method to remove a project
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function delete($project_id)
	{
		$result = false;
		if ($project_id > 0)
		{
			$query = 'DELETE FROM #__joomleague_project WHERE id='.(int)$project_id;
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
	 * remove all players from a project
	 */
	function removeProjectPlayers($project_id)
	{
		$result = false;
		if ($project_id > 0)
		{
			$query = "	DELETE
						FROM #__joomleague_team_player
						WHERE projectteam_id in (SELECT id FROM #__joomleague_project_team WHERE project_id=$project_id)";
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
	 * remove all staff from a project
	 */
	function removeProjectStaff($project_id)
	{
		$result = false;
		if ($project_id > 0)
		{
			$query = "	DELETE
						FROM #__joomleague_team_staff
						WHERE projectteam_id in (SELECT id FROM #__joomleague_project_team WHERE project_id=$project_id)";
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
	* Method to return a season array (id, name)
	*
	* @access	public
	* @return	array seasons
	* @since	1.5.0a
	*/
	function getSeasons()
	{
		$query = 'SELECT id, name FROM #__joomleague_season ORDER BY name ASC ';
		$this->_db->setQuery($query);
		if (!$result = $this->_db->loadObjectList())
		{
			$this->setError($this->_db->getErrorMsg());
			return array();
		}
		return $result;
	}

	/**
	* Method to return template independent projects (id, name)
	*
	* @access	public
	* @return	array
	* @since	1.5
	*/
	function getMasters()
	{
		$query = 'SELECT id, name FROM #__joomleague_project 
					WHERE master_template=0 
					ORDER BY name ASC ';
		$this->_db->setQuery($query);
		if (!$result = $this->_db->loadObjectList())
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		return $result;
	}

	/**
	 * Method to load content project data
	 *
	 * @access	private
	 * @return	boolean	True on success
	 * @since	1.5.0a
	 */
	function _loadData()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_data))
		{
			$query = 'SELECT p.* 
						FROM #__joomleague_project AS p 
						WHERE p.id='.(int)$this->_id;
			$this->_db->setQuery($query);
			$this->_data = $this->_db->loadObject();
			return (boolean) $this->_data;
		}
		return true;
	}

	/**
	 * Method to initialise the project data
	 *
	 * @access	private
	 * @return	boolean	True on success
	 * @since	1.5.0a
	 */
	function _initData()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_data))
		{
			$project							= new stdClass();
			$project->id						= 0;

			$project->name						= null;
			$project->league_id					= 0;
			$project->season_id					= 0;

			$project->admin						= 62;
			$project->editor		 			= 62;

			$project->master_template			= 0;
			$project->sub_template_id			= 0;
			$project->extension				 	= null;
			
			//global server timezone
			$conf =& JFactory::getConfig();
			$srvTimezone = $conf->getValue('config.offset');
				
			//global joomleague timezone config setting
			$params = JComponentHelper::getParams('com_joomleague');
			$jlgTimezone = $params->get('cfg_standard_server_offset', $srvTimezone);
				
			$project->serveroffset				= $jlgTimezone;
			$project->project_type				= 0;

			$project->teams_as_referees		 	= 0;
			$project->sports_type_id			= 1;

			$project->start_date				= null;
			$project->start_time				= '15:30';

			$project->current_round_auto		= 1;
			$project->current_round			 	= 1;
			$project->auto_time				 	= 2880;

			$project->game_regular_time		 	= 90;

			$project->game_parts				= 2;
			$project->halftime					= 15;
			$project->points_after_regular_time	= '3,1,0';

			$project->use_legs					= null;

			$project->allow_add_time			= 0;
			$project->add_time					= 15;
			$project->points_after_add_time	 	= '3,1,0';
			$project->points_after_penalty		= '3,1,0';

			$project->fav_team					= null;
			$project->fav_team_color			= '';
			$project->fav_team_text_color		= '';
			$project->fav_team_highlight_type	= '';
			$project->fav_team_text_bold		= '';
			
			$project->template					= "default";

			$project->enable_sb				 	= null;
			$project->sb_catid					= 0;

			$project->published				 	= 0;
			$project->ordering					= 0;

			$project->checked_out				= 0;
			$project->checked_out_time			= 0;
			$project->ordering 					= 0;
			$project->alias						= null;
			$project->extended					= '';
			$project->modified					= null;
			$project->modified_by				= null;
			$project->picture					= null;
			
			$this->_data						= $project;
			return (boolean) $this->_data;
		}

		return true;
	}

	/**
	* Method to return a project array (id, name)
	*
	* @access	public
	* @return	array project
	* @since	1.5.0a
	*/
	function getProjects()
	{
		$query = 'SELECT id, name 
					FROM #__joomleague_project 
					ORDER BY ordering, name ASC ';
		$this->_db->setQuery($query);
		if (!$result = $this->_db->loadObjectList())
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		return $result;
	}

	/**
	* Method to return a project array (id, name)
	*
	* @access	public
	* @return	array project
	* @since	1.5.0a
	*/
	function getProjectsBySportsType($sportstype_id, $season = null)
	{
		$query = "SELECT id, name FROM #__joomleague_project as p
					WHERE sports_type_id=$sportstype_id 
					AND published=1 ";
		if ($season) {
			$query .= ' AND season_id = '.(int) $season;
		}
		$query .=	" ORDER BY p.ordering, p.name ASC ";
		$this->_db->setQuery($query);
		if (!$result = $this->_db->loadObjectList())
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		return $result;
	}

	/**
	* Method to return a project array (id, name)
	*
	* @access	public
	* @return	array project
	* @since	1.5.0a
	*/
	function getSeasonProjects($season = null)
	{
		$query = '	SELECT	joo.id,
							concat(sea.name," - ",joo.name) AS name
					FROM #__joomleague_project AS joo
					LEFT JOIN #__joomleague_season AS sea ON joo.season_id = sea.id ';
		if ($season) {
			$query .= ' WHERE season_id = '.(int) $season;
		}
		$query .= ' ORDER BY joo.ordering, joo.name ASC ';
		$this->_db->setQuery($query);
		if (!$result = $this->_db->loadObjectList())
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		return $result;
	}

	/**
	* Method to return the project teams array (id, name)
	*
	* @access	public
	* @return	array
	* @since 0.1
	*/
	function getProjectteams()
	{
		$query = "	SELECT	pt.id AS value,
							t.name AS text,
							t.notes
					FROM #__joomleague_team AS t
					LEFT JOIN #__joomleague_project_team AS pt ON pt.team_id=t.id
					WHERE pt.project_id=$this->_id
					ORDER BY name ASC ";
		$this->_db->setQuery($query);
		if (!$result = $this->_db->loadObjectList())
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		return $result;
	}

	/**
	* Method to return the project teams array by team_id (team_id, name)
	*
	* @access	public
	* @return	array
	* @since	1.5.0a
	*/
	function getProjectteamsbyID()
	{
		if (empty($this->_id)){return false;}
		$query = "	SELECT	pt.team_id AS value,
							t.name AS text
							FROM #__joomleague_team AS t
							LEFT JOIN #__joomleague_project_team AS pt ON pt.team_id=t.id
							WHERE pt.project_id=$this->_id
							ORDER BY name ASC ";
		$this->_db->setQuery($query);
		if (!$result = $this->_db->loadObjectList())
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		return $result;
	}

	/**
	 * returns associative array of parameters values from specified template
	 *
	 * @param string $template name
	 * @return array
	 */
	function getTemplateConfig ($template)
	{
		$result = '';
		$configvalues = array();
		$project =& $this->getData();

		// load template param associated to project, or to master template if none find.
		$query =	"	SELECT params
						FROM #__joomleague_template_config
						WHERE template = " . $this->_db->Quote($template) .
					"	AND project_id =" . (int) $project->id;
		$this->_db->setQuery($query);
		if (!$result=$this->_db->loadResult())
		{
			if ($project->master_template)
			{
				$query = '	SELECT	params
							FROM #__joomleague_template_config
							WHERE template = ' . $this->_db->Quote($template) . '
							AND project_id = ' . (int) $project->master_template;
				$this->_db->setQuery($query);
				if (!$result = $this->_db->loadResult())
				{
					JError::raiseWarning(	500,
											sprintf(JText::_('JL_ADMIN_PROJECT_MODEL_MISSING_MASTER_TEMPLATE'),
											$template));
					return array();
				}
			}
			else
			{
				JError::raiseWarning(	500,
										sprintf(JText::_('JL_ADMIN_PROJECT_MODEL_MISSING_TEMPLATE'),
										$template));
				return array();
			}
		}
		$params = explode("\n", trim($result));
		foreach ($params AS $param)
		{
			list($name, $value) = explode("=", $param);
			$configvalues[$name]=$value;
		}
		
		// check some defaults and init data for quicker access
		//dont think this switch is needed anymore??????
		switch ($template)
		{
		
			case	"ranking":
			case	"table":
				// showTable contains the setup of ranking order
				// it's ensured to have a valid ranking order and the data is copied to a real integer index array
				// for faster access later

				// init ranking array with default values
				// for people updating, the tiebreaker won't be set until they edit
				// table.xml. In that case, use a default sorting

				if (!array_key_exists('tie_breaker_1', $configvalues))
				{
					$configvalues['rankingorder'][1] = 'JL_POINTS';
					$configvalues['rankingorder'][2] = 'JL_PLAYEDASC';
					$configvalues['rankingorder'][3] = 'JL_DIFF';
					$configvalues['rankingorder'][4] = 'JL_FOR';
				}

				$j = 1;
				//now extrakt the rankingorder to an integer indexed array
				while (array_key_exists('tie_breaker_' . $j, $configvalues))
				{
					$configvalues['rankingorder'][$j] = $configvalues['tie_breaker_' . $j];
					$j++;
				}
				break;

			default:
				break;
		}
		return $configvalues;
	}

	/**
	 * Checkout disabled
	 * @access	public
	 * @see administrator/components/com_joomleague/models/JoomleagueModelItem#checkout($uid)
	 */
	function checkout($uid=null)
	{
		return true;
	}

	function getVersion()
	{
		$query = "SELECT CONCAT(major,'.',minor,'.',build,'.',revision) AS version 
					FROM #__joomleague_version 
					ORDER BY date DESC LIMIT 1";
		$this->_db->setQuery($query);
		if (!$result=$this->_db->loadObjectList())
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		return $result;
	}

	/**
	 * 
	 * @param $project_id
	 */
	function getProjectName($project_id)
	{
		$query = 'SELECT name 
					FROM #__joomleague_project 
					WHERE id='.$project_id;
		$this->_db->setQuery($query);
		$result = $this->_db->loadResult();
		return $result;
	}
	
	/**
	 * 
	 * Checks if an id is a valid Project
	 * @param $project_id
	 */
	function exists($project_id)
	{
		$query = 'SELECT id 
					FROM #__joomleague_project 
					WHERE id='.$project_id;
		$this->_db->setQuery($query);
		return (boolean)$this->_db->loadResult();
	}

	/**
	* Method to return the query that will obtain all ordering versus projects
	* It can be used to fill a list box with value/text data.
	*
	* @access  public
	* @return  string
	* @since 1.5
	*/
	function getOrderingAndProjectQuery()
	{
		return 'SELECT ordering AS value, name AS text FROM #__joomleague_project ORDER BY ordering';	
	}	
}
?>