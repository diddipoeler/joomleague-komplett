<?php defined( '_JEXEC' ) or die( 'Restricted access' );

/* JoomLeague League Management and Prediction Game for Joomla!
 * Copyright (C) 2007  Robert Moss
 *
 * Homepage: http://www.joomleague.de
 * Support: htt://www.joomleague.de/forum/
 *
 * This file is part of JoomLeague.
 *
 * JoomLeague is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * Please note that the GPL states that any headers in files and
 * Copyright notices as well as credits in headers, source files
 * and output (screens, prints, etc.) can not be removed.
 * You can extend them with your own credits, though...
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 * The "GNU General Public License" (GPL) is available at
 * http://www.gnu.org/copyleft/gpl.html.
 */

//require_once( JLG_PATH_SITE .DS.'helpers'.DS.'rankingalltimeobject.php');
require_once( 'rankingalltimeobject.php');

class JLGRankingAllTime
{
    var $project;
    var $configRankingOrder;
    var $mode;
    var $teams;
    var $ranking;
    
    function &getInstance($type = null)
    {
    	if (!empty($type))
    	{
				$classname = 'JLGRankingAllTime'. ucfirst($type);
				if (!class_exists($classname))
				{
					$file = JLG_PATH_SITE.DS.'extensions'.DS.$type.DS.'ranking.php';
					if (file_exists($file)) 
					{
						require_once($file);
						$obj = new $classname();
						return $obj;
					}
				}
				else {
						$obj = new $classname();
						return $obj;				
				}
    	}
			$obj = new JLGRankingAllTime();
			return $obj;
    }

    function JLGRankingAllTime()
    {
        $this->project = null;
        $this->configRankingOrder = null;
        $this->mode = 0;
        $this->teams = array();
        $this->ranking = array();
    }

    /**
     * Init of dummy RankingObject object, for php4 compatibility
     *
     * @param unknown_type $obj
     */
    function init_stdclass( &$obj )
    {
        if (!isset($obj->cnt_matches)) $obj->cnt_matches = 0;
        if (!isset($obj->cnt_won)) $obj->cnt_won = 0;
        if (!isset($obj->cnt_lost)) $obj->cnt_lost = 0;
        if (!isset($obj->cnt_draw)) $obj->cnt_draw = 0;
        if (!isset($obj->sum_points)) $obj->sum_points = 0;
        if (!isset($obj->bonus_points)) $obj->bonus_points = 0;
        if (!isset($obj->sum_team1_result)) $obj->sum_team1_result = 0;
        if (!isset($obj->sum_team2_result)) $obj->sum_team2_result = 0;
        if (!isset($obj->sum_team1_legs)) $obj->sum_team1_legs = 0;
        if (!isset($obj->sum_team2_legs)) $obj->sum_team2_legs = 0;
        if (!isset($obj->tied_teams)) $obj->tied_teams = 0;
        for ($x = 0; $x<count($this->teams); $x++)
        {
            $team = $this->teams[$x];
            if (!isset($obj->headtohead[$team->projectteamid])) $obj->headtohead[$team->projectteamid] = 0;
            if (!isset($obj->headtohead_diff[$team->projectteamid])) $obj->headtohead_diff[$team->projectteamid] = 0;
            if (!isset($obj->headtohead_awaygoals[$team->projectteamid])) $obj->headtohead_awaygoals[$team->projectteamid] = 0;
            if (!isset($obj->headtohead_goal_for[$team->projectteamid])) $obj->headtohead_goal_for[$team->projectteamid] = 0;
        }
    }

    /**
     * set the object Ranking members (including project teams)
     *
     * @param object $project
     * @param array $configRankingOrder
     */
    function setProjectConfig( & $project, & $teams , & $points )
    {
    
    $configRankingOrder[1] = 'points';
    $configRankingOrder[2] = 'goal_diff';
    $configRankingOrder[3] = 'goal_for';
    $configRankingOrder[4] = 'goal_against';
        $this->project = $project;
        $this->points_after_regular_time = $points;
        $this->configRankingOrder = $configRankingOrder;
        $this->teams = $teams;
        
        //echo 'points_after_regular_time -> '.$this->points_after_regular_time.'<br>';
    }

    /**
     * returns ordered rankingobjects
     *
     * @param int mode 0 for home, 1 for away, 2 for global
     * @param int division_id for ranking of a particular division, 0 for global
     * @param int round_from
     * @param int round_to
     * @return array RankingObjects
     */
    function getRanking( $mode, $division=0, $round_from = 1, $round_to = 0 )
    {
        $this->buildRanking($mode, $division, $round_from, $round_to);

        //print_r($this->ranking[$mode][$round]);
        return $this->ranking[$mode][$round_to];
    }

    /**
     * orders RankingObjects
     *
     * @param int $mode
     * @param int $round
     * @param int $roundbegin
     * @param boolean $shownegpoints
     * @param boolean $showfordate
     * @param int $division
     */
    function buildRanking( $mode, $division=0, $roundbegin=1, $round )
    {
        $database = & JFactory::getDBO();
        //$rounds = $this->project->getRounds( $round, $roundbegin );

        //$roundlist = implode( ",", $rounds );

        $query = "
            SELECT m.id,
                   m.projectteam1_id,
                   m.projectteam2_id,
                   t1.name as team1,
                   t2.name as team2,
                   t1.id as team1_id,
                   t2.id as team2_id,
                   m.team1_result AS home_score,
                   m.team2_result AS away_score,
                   m.team1_bonus AS home_bonus,
                   m.team2_bonus AS away_bonus,
                   m.team1_legs AS l1,
                   m.team2_legs AS l2,
                   m.match_result_type,
                   m.alt_decision as decision,
                   m.team1_result_decision AS home_score_decision,
                   m.team2_result_decision AS away_score_decision,
                   r.roundcode as roundcode,
                   r.name as round_name
            FROM #__joomleague_match m
            INNER JOIN #__joomleague_project_team AS pt1 ON m.projectteam1_id = pt1.id
            INNER JOIN #__joomleague_team AS t1 ON pt1.team_id = t1.id
            INNER JOIN #__joomleague_project_team AS pt2 ON m.projectteam2_id = pt2.id
            INNER JOIN #__joomleague_team AS t2 ON pt2.team_id = t2.id
            INNER JOIN #__joomleague_round AS r ON m.round_id = r.id
            WHERE ((m.team1_result IS NOT NULL AND m.team2_result IS NOT NULL) OR
                   (m.alt_decision=1)) AND
                  m.count_result AND
                  m.published AND
                  pt1.project_id IN (".$this->project.") AND
                  (m.cancel IS NULL OR m.cancel = 0)
        ";

        /*
        if($roundlist) 
        {
          $query .= sprintf( "AND m.round_id IN (%s)", $roundlist );
        }
        */
        
        $database->setQuery( $query );
        //echo($database->getQuery($query));
		   	
        if ( ! $matches = $database->loadObjectList())
        {
            //echo $this->project->_db->getErrorMsg();
            $this->ranking[$mode][$round] = array();
            //return;
            #echo $this->_db->getErrorMsg();
            #echo "<pre>Error in model/playground.php-function getNextGames: " . $this->project->_db->getErrorMsg() . "</pre>";
            #echo "<pre>Error in helpers/ranking.php-function buildranking: " . $this->_db->getErrorMsg() . "</pre>";
        }
        
        $data = array();
        
    /*    
    echo 'helpers rankingalltime this->teams<br>';    
    echo '<pre>';
		print_r($this->teams);
		echo '</pre>';
		*/
		
		/*
		echo 'helpers rankingalltime this->project_ids<br>';    
    echo '<pre>';
		print_r($this->project);
		echo '</pre>';
		*/
        foreach ( $this->teams as $team )
        {
            $ro = new JoomleagueRankingAllTimeObject( $team );
            $ro->setRankingOrder( $this->configRankingOrder );
            if (!isset($team->start_points)) 
            {
                $team->start_points = 0;
            } # Added by Kurt 2009-08-16
            $ro->sum_points = $team->start_points;
            //$data[$team->projectteamid] = $ro;
            $data[$team->team_id] = $ro;
        }

        for ( $x = 0; $x < count($matches); $x++ )
        {
            $this->collectPoints( $data, $mode, $matches[$x]);
        }
        
        //keep only teams of division or subdivisions of division
        //FIXME
        if ( $division > 0 )
        {
            //$childs = LeagueDivision::getChilds( $division );
		  	$query = "SELECT id FROM #__joomleague_division WHERE parent_id=".$division;
		    $database->setQuery($query);
		    //echo($database->getQuery($query));
		   	$childs = $database->loadResultArray();
		    
            //build filter variable $div for inline callback function
            $arr_string_decl = '$div = array ( '.$division;
            if (is_array($childs) && count($childs > 0))
            {
                foreach ($childs as $c)
                {
                    $arr_string_decl .= ", $c";
                }
            }
            $arr_string_decl .=");";

            // create callback function for filtering.
            $divFilter = create_function('$obj', $arr_string_decl.'return ( in_array($obj->team->division_id, $div) );' );
            $data = array_filter( $data, $divFilter );
        }

        // before sorting, identify which teams need to be compared headtohead
        if ( array_key_exists( 'headtohead', $this->configRankingOrder ) )
        {
            if ( count( $data ) > 0 )
            {
                //Loop through all the teams of the $data array
                foreach ( $data AS $team1 )
                {
                    $this->getTiedTeams( $data, $team1 );
                }
            }
        }

        // now first $data is sorted for else somehow it wasn' right for
        // first ranks
        uasort( $data, array( "JoomleagueRankingAllTimeObject", "compareWithAlpha" ));
        //uasort($data, array ("RankingObject", "compare"));

        // loop after sorting for assigning ranks. Allows to give same rank to tied
        // teams (check with compare instead of comparewithalpha)

        if (count($data) > 0)
        {
            $rank=1;
            $previous_team = null;
            foreach ($data AS $key => $team)
            {
                if ( ( $previous_team != null ) and
                ( $team->compare($previous_team, $team ) == 0 ) )
                {
                    $data[$key]->rank = $previous_team->rank;
                }
                else
                {
                    $data[$key]->rank = $rank;
                }
                $rank++;
                $previous_team=$data[$key];
            }
        }
        $this->ranking[$mode][$round] = $data;

    }

    /**
     * updates teams data according to match result in ranking object table
     *
     * @param array $data array of ranking objects indexed by team ids
     * @param int $mode mode for home/away/home and away ranking
     * @param object $match data of the game
     */
    function collectPoints(&$data, $mode = 0, $match)
    {
        $mode = intval($mode);
        
        //$homeId = $match->projectteam1_id;
        //$awayId = $match->projectteam2_id;
        
        $homeId = $match->team1_id;
        $awayId = $match->team2_id;
        
        //$project = &$this->project->getProject();
        $shownegpoints = 1;
        
        $decision = $match->decision;
        if ($decision == 0)
        {
            $home_score=$match->home_score;
            $away_score=$match->away_score;
            $leg1=$match->l1;
            $leg2=$match->l2;
        }
        else
        {
            $home_score=$match->home_score_decision;
            $away_score=$match->away_score_decision;
            $leg1=$match->l1;
            $leg2=$match->l2;
        }

        if ($mode == 0 || $mode == 1)
        {
            if (isset($data[$homeId])) // 2010-10-16 - added by Kurt to prevent error messages if $data[$homeId] is not set
            {
            	$home = /*&*/ $data[$homeId];
            }
        }
        else
        {
            $home = new stdClass(); //in that case, $data wont be affected
            $this->init_stdclass($home); //and now they are also initialized in php4
        }
        if ($mode == 0 || $mode == 2)
        {
            if (isset($data[$awayId])) // 2010-10-16 - added by Kurt to prevent error messages if $data[$awayId] is not set
            {
            	$away = /*&*/ $data[$awayId];
            }
        }
        else
        {
            $away = new stdClass(); //in that case, $data wont be affected
            $this->init_stdclass($away); //and now they are also initialized in php4
        }
        if (!isset($data[$homeId]->headtohead[$awayId]))
        {
            $home->headtohead[$awayId]=0;
            $home->headtohead_diff[$awayId]=0;
            $home->headtohead_goal_for[$awayId]=0;
            $home->headtohead_awaygoals[$awayId]=0;
        }
        if (!isset($data[$awayId]->headtohead[$homeId]))
        {
            $away->headtohead[$homeId]=0;
            $away->headtohead_diff[$homeId]=0;
            $away->headtohead_goal_for[$homeId]=0;
            $away->headtohead_awaygoals[$homeId]=0;
        }

        $home->cnt_matches++;
        $away->cnt_matches++;

        $resultType = ($project->allow_add_time) ? $match->match_result_type : 0;
        $arr[0] = 0;
        $arr[1] = 0;
        $arr[2] = 0;
        switch($resultType)
        {
            case 1: $arr = explode(",",$this->points_after_add_time);break;
            case 2: $arr = explode(",",$this->points_after_penalty);break;
            default: $arr = explode(",",$this->points_after_regular_time);break;
        }
		$win_points  = (isset($arr[0])) ? $arr[0] : 0;
        $draw_points = (isset($arr[1])) ? $arr[1] : 0;
        $loss_points = (isset($arr[2])) ? $arr[2] : 0;

        if ($decision!=1 || ( $decision==1 && (isset($home_score) || isset($away_score))))
        {
            if( $home_score > $away_score )
            {
                $home->cnt_won++;
                $home->cnt_won_home++;
                $home->sum_points += $win_points; //home_score can't be null...

                $away->cnt_lost++;
                $away->sum_points += ( $decision == 0 || isset($away_score) ? $loss_points : 0);

                if ( $shownegpoints == 1 )
                {
                    $home->neg_points += $loss_points;
                    $away->neg_points += ( $decision == 0 || isset($away_score) ? $win_points : 0);
                }
                $home->headtohead[$awayId]++;
                $away->headtohead[$homeId]--;
            }
            else if ( $home_score == $away_score )
            {
                $home->cnt_draw++;
                $home->cnt_draw_home++;
                $home->sum_points += ( $decision == 0 || isset($home_score) ? $draw_points : 0);

                $away->cnt_draw++;
                $away->sum_points += ( $decision == 0 || isset($away_score) ? $draw_points : 0);

                if ($shownegpoints==1)
                {
                    $home->neg_points += ( $decision == 0 || isset($home_score) ? ($win_points-$draw_points): 0); // bug fixed, timoline 250709
                    $away->neg_points += ( $decision == 0 || isset($away_score) ? ($win_points-$draw_points) : 0);// ex. for soccer, your loss = 2 points not 1 point
                }
            }
            else if ( $home_score < $away_score )
            {
                $home->cnt_lost++;
                $home->cnt_lost_home++;
                $home->sum_points += ( $decision == 0 || isset($home_score) ? $loss_points : 0);

                $away->cnt_won++;
                $away->sum_points += $win_points;

                if ( $shownegpoints==1)
                {
                    $home->neg_points += ( $decision == 0 || isset($home_score) ? $win_points : 0);
                    $away->neg_points += $loss_points;
                }
                $home->headtohead[$awayId]--;
                $away->headtohead[$homeId]++;
            }

            /* bonus points */
            $home->sum_points += $match->home_bonus;
            $home->bonus_points += $match->home_bonus;

            $away->sum_points += $match->away_bonus;
            $away->bonus_points += $match->away_bonus;

            /* goals for/against/diff */
            $home->sum_team1_result += $home_score;
            $home->sum_team2_result += $away_score;
            $home->diff_team_results= $home->sum_team1_result - $home->sum_team2_result;
            $home->sum_team1_legs += $leg1;
            $home->sum_team2_legs += $leg2;
            $home->diff_team_legs= $home->sum_team1_legs - $home->sum_team2_legs;

            $away->sum_team1_result += $away_score;
            $away->sum_team2_result += $home_score;
            $away->diff_team_results= $away->sum_team1_result - $away->sum_team2_result;
            $away->sum_team1_legs += $leg2;
            $away->sum_team2_legs += $leg1;
            $away->diff_team_legs= $away->sum_team1_legs - $away->sum_team2_legs;

            /* head to head goal diff */
            $home->headtohead_diff[$awayId]+=($home_score-$away_score);
            $away->headtohead_diff[$homeId]-=($home_score-$away_score);

            /*head to head goals for/away goals*/
            $home->headtohead_goal_for[$awayId]+=$home_score;
            $away->headtohead_goal_for[$homeId]+=$away_score;
            $away->headtohead_awaygoals[$homeId]+=$away_score;
        }
        else
        { //none of the 2 teams gets any points
            if ($shownegpoints==1)
            {
                $home->neg_points += $loss_points;
                $away->neg_points += $loss_points;
            }
            $home->cnt_lost++;
            $away->cnt_lost++;
        }
    }

    function getTiedTeams ( $data, $team1 )
    {
        $team1 = &$data[$team1->team->projectteamid];

        //get the key with the value "headtohead" from the configRankingOrder
        $h2hKey = array_search('headtohead', $team1->configRankingOrder);

        //2nd loop to compare team1 with all the other teams in the $data array
        foreach ( $data AS $team2 )
        {
            $i = 1;
            //Check the sorting criteria that are applied prior to headtohead for tie situations
            while ($i < $h2hKey)
            {
                switch ($team1->configRankingOrder[$i++])
                {
                    case 'points':
                        //if this case is the first sorting criterion, build the arrays of tied teams
                        if ($i == 2)
                        {
                            if ( ($team1->sum_points == $team2->sum_points) and ($team1 != $team2) )
                            {
                                $this->addTiedTeam ($team1, $team2);
                            }
                        }
                        //If this case isn't the first sorting criteria, check whether the teams are still tied.
                        //If they aren't tied, remove the team from the corresponding array.
                        else
                        {
                            if ((in_array($team2->team->projectteamid, $team1->tied_teams)) and
                            ($team1->sum_points != $team2->sum_points))
                            {
                                $this->removeTiedTeam ($team1, $team2);
                            }
                        }
                        break;

                    case 'goal_diff':
                        if ($i == 2)
                        {
                            if ( ($team1->diff_team_results == $team2->diff_team_results) and ($team1 != $team2) ) {
                                $this->addTiedTeam ($team1, $team2);
                            }
                        }
                        else
                        {
                            if ((in_array($team2->team->projectteamid, $team1->tied_teams)) and ($team1->diff_team_results != $team2->diff_team_results)) {
                                $this->removeTiedTeam ($team1, $team2);
                            }
                        }
                        break;

                    case 'goal_for':
                        if ($i == 2)
                        {
                            if ( ($team1->sum_team1_result == $team2->sum_team1_result) and ($team1 != $team2) )
                            {
                                $this->addTiedTeam ($team1, $team2);
                            }
                        }
                        else
                        {
                            if ((in_array($team2->team->projectteamid, $team1->tied_teams)) and ($team1->sum_team1_result != $team2->sum_team1_result))
                            {
                                $this->removeTiedTeam ($team1, $team2);
                            }
                        }
                        break;

                    case 'goal_against':
                        if ($i == 2)
                        {
                            if ( ($team1->sum_team2_result == $team2->sum_team2_result) and ($team1 != $team2) )
                            {
                                $this->addTiedTeam ($team1, $team2);
                            }
                        }
                        else
                        {
                            if ((in_array($team2->team->projectteamid, $team1->tied_teams)) and ($team1->sum_team2_result != $team2->sum_team2_result))
                            {
                                $this->removeTiedTeam ($team1, $team2);
                            }
                        }
                        break;

                    case 'legs_diff':
                        if ($i == 2)
                        {
                            if ( ($team1->diff_team_legs == $team2->diff_team_legs) and ($team1 != $team2) )
                            {
                                $this->addTiedTeam ($team1, $team2);
                            }
                        }
                        else
                        {
                            if ((in_array($team2->team->projectteamid, $team1->tied_teams)) and ($team1->diff_team_legs != $team2->diff_team_legs))
                            {
                                $this->removeTiedTeam ($team1, $team2);
                            }
                        }
                        break;

                    case 'win_legs':
                        if ($i == 2)
                        {
                            if ( ($team1->sum_team1_legs == $team2->sum_team1_legs) and ($team1 != $team2) )
                            {
                                $this->addTiedTeam ($team1, $team2);
                            }
                        }
                        else
                        {
                            if ((in_array($team2->team->projectteamid, $team1->tied_teams)) and ($team1->sum_team1_legs != $team2->sum_team1_legs))
                            {
                                $this->removeTiedTeam ($team1, $team2);
                            }
                        }
                        break;

                    case 'win_pct':
                        if ($i == 2)
                        {
                            if ( ($team1->winPct() == $team2->winPct()) and ($team1 != $team2) )
                            {
                                $this->addTiedTeam ($team1, $team2);
                            }
                        }
                        else
                        {
                            if ((in_array($team2->team->projectteamid, $team1->tied_teams)) and ($team1->winPct() != $team2->winPct()))
                            {
                                $this->removeTiedTeam ($team1, $team2);
                            }
                        }
                        break;

                    case 'bonus_points':
                        if ($i == 2)
                        {
                            if ( ($team1->bonus_points == $team2->bonus_points) and ($team1 != $team2) )
                            {
                                $this->addTiedTeam ($team1, $team2);
                            }
                        }
                        else
                        {
                            if ((in_array($team2->team->projectteamid, $team1->tied_teams)) and ($team1->bonus_points != $team2->bonus_points))
                            {
                                $this->removeTiedTeam ($team1, $team2);
                            }
                        }
                        break;

                    case 'gameback':
                        if ($i == 2)
                        {
                            if ( (($team1->cnt_won-$team2->cnt_won)+($team2->cnt_lost-$team1->cnt_lost)==0) and ($team1 != $team2) )
                            {
                                $this->addTiedTeam ($team1, $team2);
                            }
                        }
                        else {
                            if ((in_array($team2->team->projectteamid, $team1->tied_teams)) and (($team1->cnt_won-$team2->cnt_won)+($team2->cnt_lost-$team1->cnt_lost)!=0) )
                            {
                                $this->removeTiedTeam ($team1, $team2);
                            }
                        }
                        break;

                    case 'total_wins':
                        if ($i == 2)
                        {

                            if ( ($team1->cnt_won == $team2->cnt_won) and ($team1 != $team2) )
                            {
                                $this->addTiedTeam ($team1, $team2);
                            }
                        }
                        else
                        {
                            if ((in_array($team2->team->projectteamid, $team1->tied_teams)) and ($team1->cnt_won != $team2->cnt_won))
                            {
                                $this->removeTiedTeam ($team1, $team2);
                            }
                        }
                        break;

                    case 'goal_average':
                        if ($i == 2)
                        {

                            if ( ($team1->goalAvg() == $team2->goalAvg()) and ($team1 != $team2) )
                            {
                                $this->addTiedTeam ($team1, $team2);
                            }
                        }
                        else
                        {
                            if ((in_array($team2->team->projectteamid, $team1->tied_teams)) and ($team1->goalAvg() != $team2->goalAvg() ))
                            {
                                $this->removeTiedTeam ($team1, $team2);
                            }
                        }
                        break;

                    case 'leg_ratio':
                        if ($i == 2)
                        {

                            if ( ($team1->legRatio() == $team2->legRatio()) and ($team1 != $team2) )
                            {
                                $this->addTiedTeam ($team1, $team2);
                            }
                        }
                        else
                        {
                            if ((in_array($team2->team->projectteamid, $team1->tied_teams)) and ($team1->legRatio() != $team2->legRatio() ))
                            {
                                $this->removeTiedTeam ($team1, $team2);
                            }
                        }
                        break;

                    default:
                        break;
                }
            }
        }
    }

    //Function to build an array of tied teams
    function addTiedTeam (&$team1, $team2)
    {
        array_push ($team1->tied_teams, $team2->team->projectteamid);
        if (array_key_exists($team2->team->projectteamid, $team1->headtohead))
        {
            $team1->sum_h2hPoints += $team1->headtohead[$team2->team->projectteamid];
            $team1->sum_h2hGoalDiff += $team1->headtohead_diff[$team2->team->projectteamid];
            $team1->sum_h2hGoalFor += $team1->headtohead_goal_for[$team2->team->projectteamid];
            $team1->sum_h2hAwayGoals += $team1->headtohead_awaygoals[$team2->team->projectteamid];
        }
    }

    //Function to remove a team from the tied_teams array
    function removeTiedTeam (&$team1, $team2)
    {
        $team1->tied_teams = array_diff($team1->tied_teams, array($team2->team->projectteamid));
        if (array_key_exists($team2->team->projectteamid, $team1->headtohead))
        {
            $team1->sum_h2hPoints -= $team1->headtohead[$team2->team->projectteamid];
            $team1->sum_h2hGoalDiff -= $team1->headtohead_diff[$team2->team->projectteamid];
            $team1->sum_h2hGoalFor -= $team1->headtohead_goal_for[$team2->team->projectteamid];
            $team1->sum_h2hAwayGoals -= $team1->headtohead_awaygoals[$team2->team->projectteamid];
        }
    }
}

?>
