<?php defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );

require_once( JLG_PATH_SITE . DS . 'extensions' .DS . 'rankingalltime' .DS . 'helpers' . DS . 'rankingalltime.php' );
//require_once( JLG_PATH_SITE . DS . 'helpers' . DS . 'ranking.php' );

//require_once( 'project.php' );

class JoomleagueModelRankingAllTime extends JModel
{
	var $projectid = 0;
	var $round = 0;
	var $league = 0;
	var $rounds = array(0);
	var $part = 0;
	var $type = 0;
	var $from = 0;
	var $to = 0;
	var $divLevel = 0;
	var $currentRanking = array();
	var $previousRanking = array();
	var $homeRank = array();
	var $awayRank = array();
	var $colors = array();
	var $result = array();
	var $pageNav = array();
	var $pageNav2 = array();
	var $current_round = 0;

	function __construct( )
	{
		
    $this->league = JRequest::getInt( "l", 0 );
    $this->points = JRequest::getVar( "points", '' );
    //echo ' __construct league -> '.$this->league.'<br>';
    
    
    /*
    $this->projectid = JRequest::getInt( "p", 0 );
		$this->round = JRequest::getInt( "r", 0 );
		$this->part  = JRequest::getInt( "part", 0);
		$this->from  = JRequest::getInt( 'from', 1 );
		$this->to	= JRequest::getInt( 'to', $this->round );
		$this->type  = JRequest::getInt( 'type', 0 );
		$this->last  = JRequest::getInt( 'last', 0 );

		$this->selDivision = JRequest::getInt( 'division', 0 );
    */
		parent::__construct( );
	}

  function getProject($league)
  {
  
  $query = 'select id 
  from #__joomleague_project
  where league_id = '.$league.' order by name ';
  $this->_db->setQuery($query);
	//$result = $this->_db->loadObjectList();
	$result = $this->_db->loadResultArray();
	$this->project_ids = implode (",", $result);	
  return $result;
    
  }
  
  function getLeagueName($league)
  {
  $query = 'select name 
  from #__joomleague_league
  where id = '.$league.' order by name ';
  $this->_db->setQuery($query);
	//$result = $this->_db->loadObject();
	$result = $this->_db->loadResult();
  
  return $result;
  }
  
  /**
	 * computes the ranking
	 *
	 */
	function computeRanking()
	{
		global $mainframe;
		
    //echo 'computeRanking ids -> '.$this->project_ids.'<br>';
    
    $this->teams = $this->getTeams($this->project_ids);
    $this->points = JRequest::getVar( "points", '' );
    
    
//     echo '<pre>';
// 		print_r($this->teams);
// 		echo '</pre>';
    
    
    $ranking = &JLGRankingAllTime::getInstance();
    $ranking->setProjectConfig( $this->project_ids, $this->teams, $this->points);
		$this->currentRanking[$division] = $ranking->getRanking(
															$reqtype,
															$division,
															$this->from,
															$this->to);
		$this->_sortRanking($this->currentRanking[$division]);													
	}	
	
	/*
	* get all teams from all projects
	*/
	function getAllTeams($project_ids)
	{
	
	$query = ' SELECT	tl.id AS projectteamid,	tl.division_id, '
			       . ' tl.standard_playground,	tl.admin,	tl.start_points, '
			       . ' tl.info,	tl.team_id,	tl.checked_out,	tl.checked_out_time, '
			       . ' tl.picture, tl.project_id, '
			       . ' t.id, t.name, t.short_name, t.middle_name,	t.notes, t.club_id, '
			       . ' u.username, u.email, '
			       . ' c.email as club_email, c.logo_small,	c.country, c.website, '
			       . ' d.name AS division_name,	d.shortname AS division_shortname, d.parent_id AS parent_division_id, '
			       . ' plg.name AS playground_name,	plg.short_name AS playground_short_name, '
				     . ' CASE WHEN CHAR_LENGTH( p.alias ) THEN CONCAT_WS( \':\', p.id, p.alias ) ELSE p.id END AS project_slug, '
				     . ' CASE WHEN CHAR_LENGTH( t.alias ) THEN CONCAT_WS( \':\', t.id, t.alias ) ELSE t.id END AS team_slug, '
				     . ' CASE WHEN CHAR_LENGTH( d.alias ) THEN CONCAT_WS( \':\', d.id, d.alias ) ELSE d.id END AS division_slug, '
				     . ' CASE WHEN CHAR_LENGTH( c.alias ) THEN CONCAT_WS( \':\', c.id, c.alias ) ELSE c.id END AS club_slug '
			       . ' FROM #__joomleague_project_team tl '
			       . ' LEFT JOIN #__joomleague_team t ON tl.team_id = t.id '
			       . ' LEFT JOIN #__users u ON tl.admin = u.id '
			       . ' LEFT JOIN #__joomleague_club c ON t.club_id = c.id '
			       . ' LEFT JOIN #__joomleague_division d ON d.id = tl.division_id '
			       . ' LEFT JOIN #__joomleague_playground plg ON plg.id = tl.standard_playground '
			       . ' LEFT JOIN #__joomleague_project AS p ON p.id = tl.project_id '
			       . ' WHERE tl.project_id IN ('.$project_ids.') group by tl.team_id'  ;

			$this->_db->setQuery($query);
			$this->_teams = $this->_db->loadObjectList();
		
		return $this->_teams;
  
  }
  
  function getAllTeamsIndexedByPtid($project_ids)
	{
		$result=$this->getAllTeams($project_ids);
		$teams=array();

		if (count($result))
		{
			foreach($result as $r)
			{
				$teams[$r->team_id]=$r;
			}
		}
		return $teams;
	}
  
  
  
  /**************************************
	 * Compare functions for ordering     *
	 **************************************/

	function _sortRanking(&$ranking)
	{
		$order     = JRequest::getVar( 'order', '' );
		$order_dir =JRequest::getVar( 'dir', 'ASC' );

		switch ($order)
		{
			case 'name':
			uasort( $ranking, array("JoomleagueModelRanking","teamNameCmp" ));
			break;
			case 'rank':
			break;
			case 'won':
			uasort( $ranking, array("JoomleagueModelRanking","wonCmp" ));
			break;
			case 'draw':
			uasort( $ranking, array("JoomleagueModelRanking","drawCmp" ));
			break;
			case 'loss':
			uasort( $ranking, array("JoomleagueModelRanking","lossCmp" ));
			break;
			case 'winpct':
			uasort( $ranking, array("JoomleagueModelRanking","winpctCmp" ));
			break;
			/*
			case 'quot':
			uasort( $current, array("HTML_joomleague","quotCmp" ));
			break;
			*/
			case 'goalsp':
			uasort( $ranking, array("JoomleagueModelRanking","goalspCmp" ));
			break;
			case 'diff':
			uasort( $ranking, array("JoomleagueModelRanking","diffCmp" ));
			break;
			case 'points':
			uasort( $ranking, array("JoomleagueModelRanking","pointsCmp" ));
			break;
			case 'start':
			uasort( $ranking, array("JoomleagueModelRanking","startCmp" ));
			break;
			case 'bonus':
			uasort( $ranking, array("JoomleagueModelRanking","bonusCmp" ));
			break;
		}
		if ($order_dir == 'DESC')
		{
			$ranking = array_reverse( $ranking, true );
		}
		return true;
	}
	
	
	function teamNameCmp( &$a, &$b){
	  return strcasecmp ($a->team->name, $b->team->name);
	}

	function wonCmp( &$a, &$b){
	  $res = $a->cnt_won - $b->cnt_won;
	  //if (!$res) $res = HTML_joomleague::teamNameCmp( $a, $b);
	  return $res;
	}

	function drawCmp( &$a, &$b){
	  $res = ($a->cnt_draw - $b->cnt_draw);
	  //if (!$res) $res = HTML_joomleague::teamNameCmp( $a, $b);
	  return $res;
	}

	function lossCmp( &$a, &$b){
	  $res = ($a->cnt_lost - $b->cnt_lost);
	  //if (!$res) $res = HTML_joomleague::teamNameCmp( $a, $b);
	  return $res;
	}

	function winpctCmp( &$a, &$b){
	  $pct_a = $a->cnt_won/($a->cnt_won+$a->cnt_lost+$a->cnt_draw);
	  $pct_b = $b->cnt_won/($b->cnt_won+$b->cnt_lost+$b->cnt_draw);
	  $res =($pct_a < $pct_b);
	  //if (!$res) $res = HTML_joomleague::teamNameCmp( $a, $b);
	  return $res;
	}

	/*
	function quotCmp( &$a, &$b){
	  # $pct_a = $a->cnt_won/($a->cnt_won+$a->cnt_lost+$a->cnt_draw);
	  # $pct_b = $b->cnt_won/($b->cnt_won+$b->cnt_lost+$b->cnt_draw);
	  $res =($pct_a < $pct_b);
	  //if (!$res) $res = $this->teamNameCmp( $a, $b);
	  return $res;
	}
	*/

	function goalspCmp( &$a, &$b){
	  $res = ($a->sum_team1_result - $b->sum_team1_result);
	  //if (!$res) $res = HTML_joomleague::teamNameCmp( $a, $b);
	  return $res;
	}

	function diffCmp( &$a, &$b){
	  $res = ($a->diff_team_results - $b->diff_team_results);
	  //if (!$res) $res = HTML_joomleague::teamNameCmp( $a, $b);
	  return $res;
	}

	function pointsCmp( &$a, &$b){
	  $res = ($a->sum_points - $b->sum_points);
	  //if (!$res) $res = HTML_joomleague::teamNameCmp( $a, $b);
	  return $res;
	}

	function bonusCmp( &$a, &$b){
	  $res = ($a->bonus_points - $b->bonus_points);
	  //if (!$res) $res = HTML_joomleague::teamNameCmp( $a, $b);
	  return $res;
	}

	function startCmp( &$a, &$b){
	  $res = ($a->team->start_points * $b->team->start_points);
	  //if (!$res) $res = HTML_joomleague::teamNameCmp( $a, $b);
	  return $res;
	}

	function teamNameCmp2( &$a, &$b){
	  return strcasecmp ($a->team, $b->team);
	}

	function totalattendCmp( &$a, &$b){
	  $res = ($a->sumspectatorspt - $b->sumspectatorspt);

	  return $res;
	}

	function avgattendCmp( &$a, &$b){
	  $res = ($a->avgspectatorspt - $b->avgspectatorspt);
	  return $res;
	}

	function capacityCmp( &$a, &$b){
	  $res = ($a->capacity - $b->capacity);
	  return $res;
	}

	function utilisationCmp( &$a, &$b){
	  $res = (($a->capacity?($a->avgspectatorspt / $a->capacity):0) - ($b->capacity>0?($b->avgspectatorspt / $b->capacity):0));
	  return $res;
	}
	
	
	
	
}
?>