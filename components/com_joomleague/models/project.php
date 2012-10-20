<?php defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');
require_once (JLG_PATH_ADMIN .DS.'models'.DS.'rounds.php');

class JoomleagueModelProject extends JModel
{
	var $_project = null;
	var $projectid = 0;

	/**
	 * project league country
	 * @var string
	 */
	var $country = null;
	/**
	 * data array for teams
	 * @var array
	 */
	var $_teams = null;

	/**
	 * data array for matches
	 * @var array
	 */
	var $_matches = null;

	/**
	 * data array for rounds
	 * @var array
	 */
	var $_rounds = null;

	/**
	 * data project stats
	 * @var array
	 */
	var $_stats = null;

	/**
	 * data project positions
	 * @var array
	 */
	var $_positions = null;

	/**
	 * cache for project divisions
	 *
	 * @var array
	 */
	var $_divisions = null;

	/**
	 * caching for current round
	 * @var object
	 */
	var $_current_round;

	function __construct()
	{
		$this->projectid=JRequest::getInt('p',0);
		parent::__construct();
	}

	function getProject()
	{
		if (is_null($this->_project) && $this->projectid > 0)
		{
			$query='SELECT p.*, l.country,
					CASE WHEN CHAR_LENGTH( p.alias )
					THEN CONCAT_WS( \':\', p.id, p.alias )
					ELSE p.id
					END AS slug
					FROM #__joomleague_project AS p
					LEFT JOIN #__joomleague_league AS l ON p.league_id = l.id 
					WHERE p.id='. $this->_db->Quote($this->projectid);
			$this->_db->setQuery($query,0,1);
			$this->_project = $this->_db->loadObject();
		}
		return $this->_project;
	}

	function setProjectID($id=0)
	{
		$this->projectid=$id;
		$this->_project=null;
	}

	function getSportsType()
	{
		if (!$project = $this->getProject())
		{
			$this->setError(0, Jtext::_('JL_ERROR_PROJECTMODEL_PROJECT_IS_REQUIRED'));
			return false;
		}
		
		return $project->sports_type_id;
	}

	/**
	 * returns project current round id
	 * 
	 * @return int
	 */
	function getCurrentRound()
	{
		$round = $this->increaseRound();
		return ($round ? $round->id : 0);
	}

	/**
	 * returns project current round code
	 * 
	 * @return int
	 */
	function getCurrentRoundNumber()
	{
		$round = $this->increaseRound();
		return ($round ? $round->roundcode : 0);
	}

	/**
	 * method to update and return the project current round
	 * @return object
	 */
	function increaseRound()
	{
		if (!$this->_current_round)
		{
			if (!$project = $this->getProject()) {
				$this->setError(0, Jtext::_('JL_ERROR_PROJECTMODEL_PROJECT_IS_REQUIRED'));
				return false;
			}
			
			$current_date=strftime("%Y-%m-%d %H:%M:%S");
	
			// determine current round according to project settings
			switch ($project->current_round_auto)
			{
				case 0 :	 // manual mode
					$query="SELECT r.id, r.roundcode FROM #__joomleague_round AS r
							 WHERE r.id =".$project->current_round;
					break;
	
				case 1 :	 // get current round from round_date_first
					$query="SELECT r.id, r.roundcode FROM #__joomleague_round AS r
							 WHERE r.project_id=".$project->id."
								AND (r.round_date_first - INTERVAL ".($project->auto_time)." MINUTE < '".$current_date."')
							 ORDER BY r.round_date_first DESC LIMIT 1";
					break;
	
				case 2 : // get current round from round_date_last
					$query="SELECT r.id, r.roundcode FROM #__joomleague_round AS r
							  WHERE r.project_id=".$project->id."
								AND (r.round_date_last + INTERVAL ".($project->auto_time)." MINUTE > '".$current_date."')
							  ORDER BY r.round_date_first ASC LIMIT 1";
					break;
	
				case 3 : // get current round from first game of the round
					$query="SELECT r.id, r.roundcode FROM #__joomleague_round AS r,#__joomleague_match AS m
							WHERE r.project_id=".$project->id."
								AND m.round_id=r.id
								AND (m.match_date - INTERVAL ".($project->auto_time)." MINUTE < '".$current_date."')
							ORDER BY m.match_date DESC LIMIT 1";
					break;
	
				case 4 : // get current round from last game of the round
					$query="SELECT r.id, r.roundcode FROM #__joomleague_round AS r, #__joomleague_match AS m
							WHERE r.project_id=".$project->id."
								AND m.round_id=r.id
								AND (m.match_date + INTERVAL ".($project->auto_time)." MINUTE > '".$current_date."')
							ORDER BY m.match_date ASC LIMIT 1";
					break;
			}
			$this->_db->setQuery($query);
			$result = $this->_db->loadObject();
				
			// If result is empty, it probably means either this is not started, either this is over, depending on the mode. 
			// Either way, do not change current value
			if (!$result)
			{
				$query = ' SELECT r.id, r.roundcode FROM #__joomleague_round AS r '
				       . ' WHERE r.project_id = '. $project->current_round
				       ;
				$this->_db->setQuery($query);
				$result = $this->_db->loadObject();
				
				if (!$result)
				{
				/*	
          // the current value as invalid... just take the first round
					$query = ' SELECT r.id, r.roundcode FROM #__joomleague_round AS r '
					       . ' WHERE r.project_id = '. $project->id
					       . ' ORDER BY . r.roundcode ASC '
					       ;
					$this->_db->setQuery($query);
					$result = $this->_db->loadObject();
				*/
					if ($project->current_round_auto == 2) {
						// the current value is invalid... saison is over, just take the last round
						$query = ' SELECT r.id, r.roundcode FROM #__joomleague_round AS r '
							. ' WHERE r.project_id = '. $project->id
							. ' ORDER BY . r.roundcode DESC '
						;
						$this->_db->setQuery($query);
						$result = $this->_db->loadObject();
					} else {
						// the current value is invalid... just take the first round
						$query = ' SELECT r.id, r.roundcode FROM #__joomleague_round AS r '
							. ' WHERE r.project_id = '. $project->id
							. ' ORDER BY . r.roundcode ASC '
						;
						$this->_db->setQuery($query);
						$result = $this->_db->loadObject();
					}        
					
				}
			}
			
			// Update the database if determined current round is different from that in the database
			if ($result && ($project->current_round <> $result->id))
			{
				$query = ' UPDATE #__joomleague_project SET current_round = '.$result->id
				       . ' WHERE id = ' . $this->_db->Quote($project->id);
				$this->_db->setQuery($query);
				if (!$this->_db->query()) {
					JError::raiseWarning(0, JTExt::_('JL_ERROR_CURRENT_ROUND_UPDATE_FAILED'));					
				}
			}
			$this->_current_round = $result;
		}
		return $this->_current_round;
	}

	function getColors($configcolors='')
	{
		$s=substr($configcolors,0,-1);

		$arr1=array();
		if(trim($s) != "")
		{
			$arr1=explode(";",$s);
		}

		$colors=array();

		$colors[0]["from"]="";
		$colors[0]["to"]="";
		$colors[0]["color"]="";
		$colors[0]["description"]="";

		for($i=0; $i < count($arr1); $i++)
		{
			$arr2=explode(",",$arr1[$i]);
			if(count($arr2) != 4)
			{
				break;
			}

			$colors[$i]["from"]=$arr2[0];
			$colors[$i]["to"]=$arr2[1];
			$colors[$i]["color"]=$arr2[2];
			$colors[$i]["description"]=$arr2[3];
		}
		return $colors;
	}

	function getDivisionsId($divLevel=0)
	{
		$query="SELECT id from #__joomleague_division
				  WHERE project_id=".$this->projectid;
		if ($divLevel==1)
		{
			$query .= " AND (parent_id=0 OR parent_id IS NULL) ";
		}
		else if ($divLevel==2)
		{
			$query .= " AND parent_id>0";
		}
		$query .= " ORDER BY ordering";
		$this->_db->setQuery($query);
		$res = $this->_db->loadResultArray();
		if(count($res) == 0) {
			echo JText::_('JL_RANKING_NO_SUBLEVEL_DIVISION_FOUND') . $divLevel;
		}
		return $res;
	}

	/**
	 * return an array of division id and it's subdivision ids
	 * @param int division id
	 * @return int
	 */
	function getDivisionTreeIds($divisionid)
	{
		if ($divisionid == 0) {
			return $this->getDivisionsId();
		}
		$divisions=$this->getDivisions();
		$res=array($divisionid);
		foreach ($divisions as $d)
		{
			if ($d->parent_id == $divisionid) {
				$res[]=$d->id;
			}
		}
		return $res;
	}

	function getDivision($id)
	{
		$divs=$this->getDivisions();
		if ($divs && isset($divs[$id])) {
			return $divs[$id];
		}
		$div = new stdClass();
		$div->id = 0;
		$div->name = '';
		return $div;
	}

	function getDivisions($divLevel=0)
	{
		$project = $this->getProject(); 
		if ($project->project_type == 'DIVISIONS_LEAGUE')
		{
			if (empty($this->_divisions))
			{
				$query="SELECT * from #__joomleague_division
						  WHERE project_id=".$this->projectid;
				$this->_db->setQuery($query);
				$this->_divisions=$this->_db->loadObjectList('id');
			}
			if ($divLevel)
			{
				$ids=$this->getDivisionsId($divLevel);
				$res=array();
				foreach ($this->_divisions as $d)
				{
					if (in_array($d->id,$ids)) {
						$res[]=$d;
					}
				}
				return $res;
			}
			return $this->_divisions;
		}
		return array();
	}

	/**
	 * return project rounds objects ordered by roundcode
	 *
	 * @param string ordering 'ASC or 'DESC'
	 * @return array
	 */
	function getRounds($ordering='ASC')
	{
		if (empty($this->_rounds))
		{
			$query=" 	SELECT id,round_date_first,round_date_last,
				   			CASE LENGTH(name)
				    			when 0 then roundcode
				    			else name
				    		END as name,
				   			roundcode
			       		FROM #__joomleague_round
			         	WHERE project_id=". $this->projectid.
			       		" ORDER BY roundcode ASC ";

			$this->_db->setQuery($query);
			$this->_rounds=$this->_db->loadObjectList();
		}
		if ($ordering == 'DESC') {
			return array_reverse($this->_rounds);
		}
		return $this->_rounds;
	}

	/**
	 * return project rounds as array of objects(roundid as value,name as text)
	 *
	 * @param string $ordering
	 * @return array
	 */
	function getRoundOptions($ordering='ASC')
	{
		$query="SELECT
					id as value,
				    CASE LENGTH(name)
				    	when 0 then CONCAT('".JText::_('JL_GLOBAL_MATCHDAY_NAME'). "',' ', id)
				    	else name
				    END as text
				  FROM #__joomleague_round
				  WHERE project_id=".(int)$this->projectid."
				  ORDER BY roundcode ".$ordering;

		$this->_db->setQuery($query);
		return $this->_db->loadObjectList();
	}

	function getTeaminfo($projectteamid)
	{
		$query=' SELECT t.*, pt.division_id, t.id as team_id,
				pt.picture AS projectteam_picture,
				t.picture as team_picture,
				c.logo_small,
				c.logo_middle,
				c.logo_big,
				IF((ISNULL(pt.picture) OR (pt.picture="")), 
					(IF((ISNULL(t.picture) OR (t.picture="")), c.logo_big , t.picture)) , pt.picture) as picture,
				t.extended as teamextended 
				FROM #__joomleague_project_team AS pt 
				INNER JOIN #__joomleague_team AS t ON pt.team_id=t.id
				LEFT JOIN #__joomleague_club AS c ON t.club_id=c.id 
				WHERE pt.id='. $this->_db->Quote($projectteamid);
		$this->_db->setQuery($query);
		return $this->_db->loadObject();
	}

	function & _getTeams()
	{
		if (empty($this->_teams))
		{
			$query='	SELECT	tl.id AS projectteamid,
								tl.division_id,
								tl.standard_playground,
								tl.admin,
								tl.start_points,
								tl.points_finally,
								tl.neg_points_finally,
								tl.matches_finally,
								tl.won_finally,
								tl.draws_finally,
								tl.lost_finally,
								tl.homegoals_finally,
								tl.guestgoals_finally,
								tl.diffgoals_finally,
								tl.info,
								tl.reason,
								tl.team_id,
								tl.checked_out,
								tl.checked_out_time,
								tl.is_in_score,
								tl.picture AS projectteam_picture,
								t.picture as team_picture,
								IF((ISNULL(tl.picture) OR (tl.picture="")), 
									(IF((ISNULL(t.picture) OR (t.picture="")), c.logo_small , t.picture)) , t.picture) as picture,
								tl.project_id,

								t.id,t.name,
								t.short_name,
								t.middle_name,
								t.notes,
								t.club_id,

								u.username,
								u.email,

								c.email as club_email,
								c.logo_small,
								c.logo_middle,
								c.logo_big,
								c.country,
								c.website,

								d.name AS division_name,
								d.shortname AS division_shortname,
								d.parent_id AS parent_division_id,

								plg.name AS playground_name,
								plg.short_name AS playground_short_name,

								CASE WHEN CHAR_LENGTH(p.alias) THEN CONCAT_WS(\':\',p.id,p.alias) ELSE p.id END AS project_slug,
								CASE WHEN CHAR_LENGTH(t.alias) THEN CONCAT_WS(\':\',t.id,t.alias) ELSE t.id END AS team_slug,
								CASE WHEN CHAR_LENGTH(d.alias) THEN CONCAT_WS(\':\',d.id,d.alias) ELSE d.id END AS division_slug,
								CASE WHEN CHAR_LENGTH(c.alias) THEN CONCAT_WS(\':\',c.id,c.alias) ELSE c.id END AS club_slug

						FROM #__joomleague_project_team tl
							LEFT JOIN #__joomleague_team t ON tl.team_id=t.id
							LEFT JOIN #__users u ON tl.admin=u.id
							LEFT JOIN #__joomleague_club c ON t.club_id=c.id
							LEFT JOIN #__joomleague_division d ON d.id=tl.division_id
							LEFT JOIN #__joomleague_playground plg ON plg.id=tl.standard_playground
							LEFT JOIN #__joomleague_project AS p ON p.id=tl.project_id

						WHERE tl.project_id='.(int)$this->projectid;

			$this->_db->setQuery($query);
			$this->_teams=$this->_db->loadObjectList();
		}
		return $this->_teams;
	}

	/**
	 * return teams of the project
	 *
	 * @param int $division
	 * @return array
	 */
	function getTeams($division=0)
	{
		$teams=array();
		if ($division != 0)
		{
			$divids=$this->getDivisionTreeIds($division);
			foreach ((array)$this->_getTeams() as $t)
			{
				if (in_array($t->division_id,$divids))
				{
					$teams[]=$t;
				}
			}
		}
		else
		{
			$teams=$this->_getTeams();
		}

		return $teams;
	}

	/**
	 * return array of team ids
	 *
	 * @return array	 *
	 */
	function getTeamIds($division=0)
	{
		$teams=array();
		foreach ((array)$this->_getTeams() as $t)
		{
			if (!$division || $t->division_id == $division) {
				$teams[]=$t->id;
			}
		}
		return $teams;
	}

	function getTeamsIndexedById($division=0)
	{
		$result=$this->getTeams($division);
		$teams=array();
		if (count($result))
		{
			foreach($result as $r)
			{
				$teams[$r->id]=$r;
			}
		}

		return $teams;
	}

	function getTeamsIndexedByPtid($division=0)
	{
		$result=$this->getTeams($division);
		$teams=array();

		if (count($result))
		{
			foreach($result as $r)
			{
				$teams[$r->projectteamid]=$r;
			}
		}
		return $teams;
	}

	function getFavTeams()
	{
		$project = $this->getProject();
		if(!is_null($project))
		return explode(",",$project->fav_team);
		else
		return array();
	}

	function getEventTypes($evid=0)
	{
		$query="SELECT	et.id AS etid,
							me.event_type_id AS id,
							et.*
							FROM #__joomleague_eventtype AS et
							LEFT JOIN #__joomleague_match_event AS me ON et.id=me.event_type_id";
		if ($evid != 0)
		{
			if ($this->projectid > 0)
			{
				$query .= " AND";
			}
			else
			{
				$query .= " WHERE";
			}
			$query .= " me.event_type_id=".(int)$evid;
		}

		$this->_db->setQuery($query);
		return $this->_db->loadObjectList('etid');
	}

	function getprojectteamID($teamid)
	{
		$query="SELECT id
				  FROM #__joomleague_project_team
				  WHERE team_id=".(int)$teamid."
					AND project_id=".(int)$this->projectid;

		$this->_db->setQuery($query);
		$result=$this->_db->loadResult();

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
		$query='	SELECT	id AS value,
							name AS text
					FROM #__joomleague_playground
					ORDER BY text ASC ';
		$this->_db->setQuery($query);
		if (!$result=$this->_db->loadObjectList())
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		else
		{
			return $result;
		}
	}

	function getReferees()
	{
		$project=$this->getProject();
		if ($project->teams_as_referees)
		{
			$query='	SELECT	id AS value,
								name AS text
						FROM #__joomleague_team
						ORDER BY name';

			$this->_db->setQuery($query);
			$refs=$this->_db->loadObjectList();
		}
		else
		{
			$query='	SELECT	id AS value,
								firstname,
								lastname

						FROM #__joomleague_project_referee
						ORDER BY lastname';

			$this->_db->setQuery($query);
			$refs=$this->_db->loadObjectList();
			foreach($refs as $ref)
			{
				$ref->text=$ref->lastname.",".$ref->firstname;
			}
		}
		return $refs;
	}

	function getTemplateConfig($template)
	{
		//first load the default settings from the default <template>.xml file
		$paramsdata="";
		$arrStandardSettings=array();
		if(file_exists(JLG_PATH_SITE. DS.'settings'.DS."default".DS.$template.'.xml')) {
			$paramsdefs=JLG_PATH_SITE. DS.'settings'.DS."default".DS.$template.'.xml';
			$jlgparams=new JLGExtraParams($paramsdata,$paramsdefs);
			$name="params";
			foreach ($jlgparams->getGroups() as $group => $groups)
			{
				$params=$jlgparams->getElements($group);
				foreach ($params as $param)
				{
					$arrStandardSettings[$param->name]=$param->value;
				}
			}
		}
		//second load the default settings from the default extensions <template>.xml file
		$extensions=JoomleagueHelper::getExtensions(JRequest::getInt('p'));
		foreach ($extensions as $e => $extension) {
			$JLGPATH_EXTENSION= JPATH_COMPONENT_SITE.DS.'extensions'.DS.$extension;
			$paramsdata="";
			$paramsdefs=$JLGPATH_EXTENSION. DS.'settings'.DS."default".DS.$template.'.xml';
			if(file_exists($JLGPATH_EXTENSION. DS.'settings'.DS."default".DS.$template.'.xml')) {

				$jlgparams=new JLGExtraParams($paramsdata,$paramsdefs);
				$name="params";
				$arrStandardSettings=array();
				foreach ($jlgparams->getGroups() as $group => $groups)
				{
					$params=$jlgparams->getElements($group);
					foreach ($params as $param)
					{
						$arrStandardSettings[$param->name]=$param->value;
					}
				}
			}
		}

		if($this->projectid == 0) return $arrStandardSettings;

		$query= "SELECT t.params
				   FROM #__joomleague_template_config AS t
				   INNER JOIN #__joomleague_project AS p ON p.id=t.project_id
				   WHERE t.template=".$this->_db->Quote($template)."
				   AND p.id=".$this->_db->Quote($this->projectid);

		$this->_db->setQuery($query);
		if (! $result=$this->_db->loadResult())
		{
			$project=$this->getProject();
			if (!empty($project) && $project->master_template>0)
			{
				$query="SELECT t.params
						  FROM #__joomleague_template_config AS t
						  INNER JOIN #__joomleague_project AS p ON p.id=t.project_id
						  WHERE t.template=".$this->_db->Quote($template)."
						  AND p.id=".$this->_db->Quote($project->master_template);

				$this->_db->setQuery($query);
				if (! $result=$this->_db->loadResult())
				{
					JError::raiseNotice(500,JText::_('JL_GLOBAL_MASTER_TEMPLATE_MISSING')." ".$template);
					JError::raiseNotice(500,JText::_('JL_GLOBAL_MASTER_TEMPLATE_MISSING_PID'). $project->master_template);
					JError::raiseNotice(500,JText::_('JL_GLOBAL_TEMPLATE_MISSING_HINT'));
					return false;
				}
			}
			else
			{
				//JError::raiseNotice(500,JText::_('JL_GLOBAL_TEMPLATE_MISSING')." ".$template);
				//JError::raiseNotice(500,JText::_('JL_GLOBAL_MASTER_TEMPLATE_MISSING_PID'). $project->master_template);
				//JError::raiseNotice(500,JText::_('JL_GLOBAL_TEMPLATE_MISSING_HINT'));
				return false;
			}
		}

		$params=explode("\n",trim($result));
		foreach($params AS $param)
		{
			if (strstr($param, "="))
			{
				list ($name,$value)=explode("=",$param);
				$configvalues[$name]=$value;
			}
		}

		// check some defaults and init data for quicker access
		switch ($template)
		{
			case	"ranking":
			case	"table":
				// showTable contains the setup of ranking order
				// it's ensured to have a valid ranking order and the data is copied to a real integer index array
				// for faster access later

				// init ranking array with default values
				// for people updating,the tiebreaker won't be set until they edit
				// ranking.xml. In that case,use a default sorting
				if (!array_key_exists('tie_breaker_1',$configvalues))
				{
					$configvalues['rankingorder'][1]='points';
					$configvalues['rankingorder'][2]='goal_diff';
					$configvalues['rankingorder'][3]='goal_for';
					$configvalues['rankingorder'][4]='goal_against';
				}

				$j=1;
				//now extrakt the rankingorder to an integer indexed array
				while (array_key_exists('tie_breaker_'.$j,$configvalues))
				{
					$configvalues['rankingorder'][$j]=$configvalues['tie_breaker_'.$j];
					$j++;
				}
				break;

			case	"tipranking":
				// showTable contains the setup of tip ranking order
				if (!array_key_exists('sort_order_1',$configvalues))
				// for people updating,the tiebreaker won't be set until they edit
				//ranking.xml. In that case,use a default sorting
				{
					$configvalues['sort_order_1']='points';
					$configvalues['sort_order_2']='correct_tips';
					$configvalues['sort_order_3']='correct_diffs';
					$configvalues['sort_order_4']='correct_tend';
					$configvalues['sort_order_5']='count_tips_p';
				}
				break;

			default:	break;
		}
		//merge and overwrite standard settings with individual view settings
		return array_merge($arrStandardSettings,$configvalues);
	}

	function getOverallConfig()
	{
		return $this->getTemplateConfig('overall');
	}

	function getMapConfig()
	{
		return $this->getTemplateConfig('map');
	}

	function PrintIcon(&$row,&$params,$hide_js,$link,$status=NULL)
	{
		return "";

		/*
		 global $joomleague,$jl_func,$pid,$tid,$cid,$mid,$pgid,$projectteamid;
		 $pop=intval(mosGetParam($_REQUEST,'pop',0)); //popup for print function
		 $round_id=intval(mosGetParam($_REQUEST,'r',0)); //round_id
		 $uid=intval(mosGetParam($_REQUEST,'uid',0)); //user_id
		 $tid=intval(mosGetParam($_REQUEST,'tid',0)); //team_id
		 $pgid=intval(mosGetParam($_REQUEST,'pgid',0)); //team_id
		 $event_id=intval(mosGetParam($_REQUEST,"evid",'0')); //event_id
		 $mid=intval(mosGetParam($_REQUEST,"mid",'0')); //match_id
		 if (empty($round)) $round="";
		 $from=intval(mosGetParam($_REQUEST,'from',$round));
		 $to=intval(mosGetParam($_REQUEST,'to',$round));
		 $type=intval(mosGetParam($_REQUEST,'type',0));
		 $mode=mosGetParam($_REQUEST,'mode','');
		 $params=new mosParameters('');
		 $params->def('print',true);
		 $params->def('popup',false);
		 $params->def('icons',true);
		 if ($params->get('print')  && !$hide_js)
		 {
		 // use default settings if none declared
		 if (!$status)
		 {
		 $status='status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
		 }

		 // checks template image directory for image,if non found default are loaded
		 if ($params->get('icons'))
		 {
		 $image=mosAdminMenus::ImageCheck('printButton.png','/images/M_images/',NULL,NULL,_CMN_PRINT,_CMN_PRINT);
		 }
		 else
		 {
		 $image=_ICON_SEP .'&nbsp;'. _CMN_PRINT. '&nbsp;'. _ICON_SEP;
		 }

		 if ($pop == '1' && !$hide_js)
		 {
		 // Print Preview button - used when viewing page
		 ?>
		 <script language="javascript" type="text/javascript">
		 <!--
		 document.write('<div align="right">');
		 document.write('<a href="#" onclick="javascript:window.print(); return false;" title="<?php echo _CMN_PRINT;?>">');
		 document.write('<?php echo $image;?>');
		 document.write('</a>');
		 document.write('</div>');
		 //-->
		 </script>
		 <?php
		 } else {
		 if (!empty($uid)) $uid_part="&amp;uid=$uid"; else $uid_part="";
		 if (!empty($pid)) $pid_part="&amp;pid=$pid"; else $pid_part="";
		 if (!empty($tid)) $tid_part="&amp;tid=$tid"; else $tid_part="";
		 if (!empty($projectteamid)) $ttid_part="&amp;ttid=$projectteamid"; else $ttid_part="";
		 if (!empty($cid)) $cid_part="&amp;cid=$cid"; else $cid_part="";
		 if (!empty($round_id)) $round_id_part="&amp;r=$round_id"; else $round_id_part="";
		 if (!empty($event_id)) $event_id_part="&amp;evid=$event_id"; else $event_id_part="";
		 if (!empty($mid)) $mid_part="&amp;mid=$mid"; else $mid_part="";
		 if (!empty($pgid)) $pgid_part="&amp;pgid=$pgid"; else $pgid_part="";
		 if (!empty($from)) $from_part="&amp;from=$from"; else $from_part="";
		 if (!empty($to)) $to_part="&amp;to=$to"; else $to_part="";
		 if (!empty($type)) $type_part="&amp;type=$type"; else $type_part="";
		 if (!empty($mode)) $mode_part="&amp;mode=$mode"; else $mode_part="";
		 $url=_JOOMLA_JL_LIVE_SITE.'/index2.php?option=com_joomleague&amp;func='.$jl_func.'&amp;p='.$joomleague->id
		 .$uid_part.''.$pid_part.''.$tid_part.''.$ttid_part.''.$round_id_part.''.$cid_part.''.$event_id_part.''.$mid_part.''.$pgid_part.''
		 .$from_part.''.$to_part.''.$type_part.''.$mode_part.JL_ITEMID_SUFFIX.'&amp;pop=1';
		 // Print Button - used in pop-up window
		 ?>
		 <div align="right">
		 <a href="<?php echo $url; ?>" target="_blank" onclick="window.open('<?php echo $url; ?>','win2','<?php echo $status; ?>'); return false;" title="<?php echo _CMN_PRINT;?>">
		 <?php echo $image;?></a>
		 </div>
		 <div style="clear:left"></div>
		 <?php
		 }
		 }
		 */
	}

	function getPlayTime()
	{
		// tracker #15675....here my thoughts:
		//if subst=1
		//playtime=Regular playing time - (Regular playing time - subst min)
		//playtime=playtime*matches
		//else
		//playtime=Regular playing time
		//playtime=playtime*matches
		//return playtime
	}

  	/**
   	* @author diddipoeler 
   	* @since  2011-11-12
   	* @return country from project-league
   	*/
   	function getProjectCountry()
	{
		 $query = 'SELECT l.country
					from #__joomleague_league as l
					inner join #__joomleague_project as pro
					on pro.league_id = l.id 
					WHERE pro.id = '. $this->_db->Quote($this->projectid);
		  $this->_db->setQuery( $query );
		  $this->country = $this->_db->loadResult();
		  return $this->country;
  	} 
        
	/**
	 * return events assigned to the project
	 * @param int position_id if specified,returns only events assigned to this position
	 * @return array
	 */
	function getProjectEvents($position_id=0)
	{
		$query=' SELECT	et.id,
						et.name,
						et.icon
						FROM #__joomleague_eventtype AS et
						INNER JOIN #__joomleague_position_eventtype AS pet ON pet.eventtype_id=et.id
						INNER JOIN #__joomleague_project_position AS ppos ON ppos.position_id=pet.position_id
						WHERE ppos.project_id='.$this->_db->Quote($this->projectid);
		if ($position_id)
		{
			$query=' AND ppos.position_id='. $this->_db->Quote($position_id);
		}
		$query .= ' GROUP BY et.id';
		$this->_db->setQuery($query);
		$events=$this->_db->loadObjectList('id');
		return $events;
	}

	/**
	 * returns stats assigned to positions assigned to project
	 * @param int statid 0 for all stats
	 * @param int positionid 0 for all positions
	 * @return array objects
	 */
	function getProjectStats($statid=0,$positionid=0)
	{
		if (empty($this->_stats))
		{
			require_once (JLG_PATH_ADMIN .DS.'statistics'.DS.'base.php');
			$project =& $this->getProject();
			$project_id=$project->id;
			$query='	SELECT	stat.id,
								stat.name,
								stat.short,
								stat.class,
								stat.icon,
								stat.calculated,
								ppos.id as pposid,
								ppos.position_id AS position_id,
								stat.params, stat.baseparams
						FROM #__joomleague_statistic AS stat
						INNER JOIN #__joomleague_position_statistic AS ps ON ps.statistic_id=stat.id
						INNER JOIN #__joomleague_project_position AS ppos ON ppos.position_id=ps.position_id
						  AND ppos.project_id='.$project_id.' 
						INNER JOIN #__joomleague_position AS pos ON pos.id=ps.position_id
						WHERE stat.published=1 
						  AND pos.published =1 
						  ';
			$query .= ' ORDER BY pos.ordering,ps.ordering ';
			$this->_db->setQuery($query);
			$this->_stats=$this->_db->loadObjectList();

		}
		// sort into positions
		$positions=$this->getProjectPositions();
		$stats=array();
		// init
		foreach ($positions as $pos)
		{
			$stats[$pos->id]=array();
		}
		if (count($this->_stats) > 0)
		{
			foreach ($this->_stats as $k => $row)
			{
				if (!$statid || $statid == $row->id || (is_array($statid) && in_array($row->id, $statid)))
				{
					$stat=&JLGStatistic::getInstance($row->class);
					$stat->bind($row);
					$stat->set('position_id',$row->position_id);
					$stats[$row->position_id][$row->id]=$stat;
				}
			}
			if ($positionid)
			{
				return (isset($stats[$positionid]) ? $stats[$positionid] : array());
			}
			else
			{
				return $stats;
			}
		}
		else
		{
			return $stats;
		}
	}

	function getProjectPositions()
	{
		if (empty($this->_positions))
		{
			$query='	SELECT	pos.id,
								pos.persontype,
								pos.name,
								pos.ordering,
								pos.published,
								ppos.id AS pposid
						FROM #__joomleague_project_position AS ppos
						INNER JOIN #__joomleague_position AS pos ON ppos.position_id=pos.id
						WHERE ppos.project_id='.$this->_db->Quote($this->projectid);
			$this->_db->setQuery($query);
			$this->_positions=$this->_db->loadObjectList('id');
		}
		return $this->_positions;
	}

	function getClubIconHtml(&$team,$type=1,$with_space=0)
	{
		$small_club_icon=$team->logo_small;
		if ($type==1)
		{
			$params=array();
			$params['align']="top";
			$params['border']=0;
			if ($with_space==1)
			{
				$params['style']='padding:1px;';
			}
			if ($small_club_icon=='')
			{
				$small_club_icon = JoomleagueHelper::getDefaultPlaceholder("clublogosmall");
			}

			return JHTML::image($small_club_icon,'',$params);
		}
		elseif (($type==2) && (isset($team->country)))
		{
			return Countries::getCountryFlag($team->country);
		}
	}

	/**
	 * Method to store the item
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function store($data,$table='')
	{
		if ($table=='')
		{
			$row =& $this->getTable();
		}
		else
		{
			$row =& JTable::getInstance($table,'Table');
		}

		// Bind the form fields to the items table
		if (!$row->bind($data))
		{
			$this->setError(JText::_('Binding failed'));
			return false;
		}

		// Create the timestamp for the date
		$row->checked_out_time=gmdate('Y-m-d H:i:s');

		// if new item,order last,but only if an ordering exist
		if ((isset($row->id)) && (isset($row->ordering)))
		{
			if (!$row->id && $row->ordering != NULL)
			{
				$row->ordering=$row->getNextOrder();
			}
		}

		// Make sure the item is valid
		if (!$row->check())
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Store the item to the database
		if (!$row->store())
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		return $row->id;
	}

	function isUserProjectAdminOrEditor($userId=0,$project)
	{
		$result=false;
		if($userId > 0)
		{
			$result= ($userId==$project->admin || $userId==$project->editor);
		}
		return $result;
	}

	/**
	 * returns match substitutions
	 * @param int match id
	 * @return array
	 */
	function getMatchSubstitutions($match_id)
	{
		$query=' SELECT	mp.in_out_time,
							pt.team_id,
							pt.id AS ptid,
							p2.id AS out_ptid,
							p.firstname,
							p.nickname,
							p.lastname,
							pos.name AS in_position,
							pos2.name AS out_position,
							p2.firstname AS out_firstname,
							p2.nickname AS out_nickname,
							p2.lastname AS out_lastname
						FROM #__joomleague_match_player AS mp
							LEFT JOIN #__joomleague_team_player AS tp ON mp.teamplayer_id=tp.id
							  AND tp.published=1
							LEFT JOIN #__joomleague_project_team AS pt ON tp.projectteam_id=pt.id
							LEFT JOIN #__joomleague_person AS p ON tp.person_id=p.id
							LEFT JOIN #__joomleague_team_player AS tp2 ON mp.in_for=tp2.id
							  AND tp2.published=1
							LEFT JOIN #__joomleague_person AS p2 ON tp2.person_id=p2.id
							LEFT JOIN #__joomleague_project_position AS ppos ON ppos.id=mp.project_position_id
							LEFT JOIN #__joomleague_position AS pos ON ppos.position_id=pos.id
							LEFT JOIN #__joomleague_match_player AS mp2 ON mp.match_id=mp2.match_id and mp.in_for=mp2.teamplayer_id
							LEFT JOIN #__joomleague_project_position AS ppos2 ON ppos2.id=mp2.project_position_id
							LEFT JOIN #__joomleague_position AS pos2 ON ppos2.position_id=pos2.id
						WHERE	mp.match_id='.(int)$match_id.' AND
								mp.came_in=1 AND p.published = 1 AND p2.published = 1
						ORDER by (mp.in_out_time+0) ';
		$this->_db->setQuery( $query );
		return $this->_db->loadObjectList();
	}

	/**
	 * returns match events
	 * @param int match id
	 * @return array
	 */
	function getMatchEvents($match_id,$showcomments=0,$sortdesc=0)
	{
		if ($showcomments == 1) {
		    $join = 'LEFT';
		    $addline = ' me.notes,';
		} else {
		    $join = 'INNER';
		    $addline = '';
		}
		$esort = '';
		if ($sortdesc == 1) {
		    $esort = ' DESC';
		}
		$query = ' 	SELECT 	me.event_type_id,
							me.id as event_id,
							me.event_time,
							me.notice,'
							. $addline .
							'pt.team_id AS team_id, 
							et.name AS eventtype_name,
							t.name AS team_name,
							me.projectteam_id AS ptid,
							me.event_sum,
							p.id AS playerid,
							p.firstname AS firstname1,
							p.nickname AS nickname1,
							p.lastname AS lastname1,
							p.picture AS picture1,
							tp.picture AS tppicture1
					FROM #__joomleague_match_event AS me
					'.$join.' JOIN #__joomleague_eventtype AS et ON me.event_type_id = et.id
					'.$join.' JOIN #__joomleague_project_team AS pt ON me.projectteam_id = pt.id
					'.$join.' JOIN #__joomleague_team AS t ON pt.team_id = t.id
					LEFT JOIN #__joomleague_team_player AS tp ON tp.id = me.teamplayer_id
						  AND tp.published = 1
					LEFT JOIN #__joomleague_person AS p ON tp.person_id = p.id
						  AND p.published = 1
					WHERE me.match_id = ' . $match_id . ' 
					ORDER BY (me.event_time + 0)'. $esort .', me.event_type_id, me.id';
			
		$this->_db->setQuery( $query );
		return $this->_db->loadObjectList();
	}
}
?>