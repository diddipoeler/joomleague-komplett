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

jimport( 'joomla.application.component.model' );

class JoomleagueRankingAllTimeObject
{
    var $configRankingOrder;

    var $team;
    var $cnt_matches;
    var $cnt_won;
    var $cnt_draw;
    var $cnt_lost;
    var $cnt_won_home;
    var $cnt_draw_home;
    var $cnt_lost_home;
    var $sum_points;
    var $neg_points;
    var $bonus_points;
    var $sum_team1_result;
    var $sum_team2_result;
    var $sum_team1_legs;
    var $sum_team2_legs;
    var $diff_team_results;
    var $diff_team_legs;
    var $round;
    var $rank;
    var $diff_rank; //not used...
    var $headtohead;
    var $headtohead_diff;
    var $headtohead_goal_for;
    var $headtohead_awaygoals;
    var $tied_teams;
    var $sum_h2hPoints;
    var $sum_h2hGoalDiff;
    var $sum_h2hGoalFor;
    var $sum_h2hAwayGoals;
  
    function JoomleagueRankingAllTimeObject( $team )
    {
        $m1 = array("e1" =>"", "e2"=>"", "l1" =>"", "l2"=>"", "team1"=>"", "team2"=>"","round"=>"");
        $m2 = array("e1" =>"", "e2"=>"", "l1" =>"", "l2"=>"", "team1"=>"", "team2"=>"","round"=>"");
        $m3 = array("e1" =>"", "e2"=>"", "l1" =>"", "l2"=>"", "team1"=>"", "team2"=>"","round"=>"");
        $m4 = array("e1" =>"", "e2"=>"", "l1" =>"", "l2"=>"", "team1"=>"", "team2"=>"","round"=>"");

        $this->configRankingOrder = null;

        $this->team = $team;
        $this->cnt_matches = 0;
        $this->cnt_won = 0;
        $this->cnt_draw = 0;
        $this->cnt_lost = 0;
        $this->cnt_won_home = 0;
        $this->cnt_draw_home = 0;
        $this->cnt_lost_home = 0;
        $this->sum_points = 0;
        $this->neg_points = 0;
        $this->bonus_points = 0;
        $this->sum_team1_result = 0;
        $this->sum_team2_result = 0;
        $this->sum_team1_legs = 0;
        $this->sum_team2_legs = 0;
        $this->diff_team_results = 0;
        $this->diff_team_legs = 0;
        $this->rank = 0;
        $this->headtohead = array();
        $this->headtohead_diff = array();
        $this->headtohead_goal_for = array();
        $this->headtohead_awaygoals = array();
        $this->sum_h2hPoints = 0;
        $this->sum_h2hGoalDiff = 0;
        $this->sum_h2hGoalFor = 0;
        $this->sum_h2hAwayGoals = 0;
        $this->tied_teams = array();
    }
  
    function setRankingOrder( & $configRankingOrder )
    {
        $this->configRankingOrder = $configRankingOrder;
    }
  
    function winPct()
    {
        if ( $this->cnt_won + $this->cnt_lost + $this->cnt_draw == 0 ) 
        { 
            return 0; 
        }
        else 
        {
            return ($this->cnt_won/($this->cnt_won+$this->cnt_lost+$this->cnt_draw));
        }   
    }
  
    function goalAvg()
    {
        if ($this->sum_team2_result == 0)
        {
            return $this->sum_team1_result/0.1;
        }
        else
        {
            return $this->sum_team1_result/$this->sum_team2_result; 
        }
    }
  
    function legRatio()
    {
        if ($this->sum_team2_legs == 0)
        {
            return $this->sum_team1_legs/0.1;
        }
        else
        {
            return $this->sum_team1_legs/$this->sum_team2_legs; 
        }
    }

    // This is ONE decison to compare to teams in a table
    // it's call by ranking module to sort the table, and uses tie breaker defined
    // in table.xml
    // Should be declared static, but it's not ok for php4 :-(
    function compare($a, $b) 
    {
        $res=0;
        $j=1;

        // apply each tie breaker in order
        while ( array_key_exists( $j,$a->configRankingOrder ) and $res ==0 ) 
        {
            switch ($a->configRankingOrder[$j++]) 
            {
                case 'points':
                    $res=-($a->sum_points - $b->sum_points);
                    if ($res==0) 
                    {
                        $res=($a->neg_points - $b->neg_points);
                    } 
                break;

                case 'bonus_points':
                    $res=-($a->bonus_points - $b->bonus_points);
                break;
            
                case 'goal_diff':
                    $res=-($a->diff_team_results - $b->diff_team_results);
                break;
          
                case 'goal_for':
                    $res=-($a->sum_team1_result - $b->sum_team1_result);
                 break;
                  
                case 'goal_against':
                    $res=($a->sum_team2_result - $b->sum_team2_result);
                break;
                  
                case 'goal_average':
                    $res = -($a->goalAvg() - $b->goalAvg());
                    if ($res != 0) $res=($res >= 0 ? 1 : -1);
                break;
                  
                case 'win_pct':
                    $res= -($a->winPct() - $b->winPct());
                    if ($res != 0) $res=($res >= 0 ? 1 : -1); 
                break;
                  
                case 'gameback':
                    $res=-( ($a->cnt_won - $b->cnt_won) + ($b->cnt_lost - $a->cnt_lost) );
                break;
                  
                case 'headtohead':
                    //if ( array_key_exists($b->team->id,$a->headtohead) ) 
                    $res = -( $a->sum_h2hPoints - $b->sum_h2hPoints );
                 break;
                  
                case 'headtohead_diff':
                    //if ( array_key_exists($b->team->id,$a->headtohead_diff) ) 
                    $res = -( $a->sum_h2hGoalDiff - $b->sum_h2hGoalDiff );
                break;
                  
                case 'headtohead_goal_for':
                    $res = -( $a->sum_h2hGoalFor - $b->sum_h2hGoalFor );
                break;
                  
                case 'headtohead_awaygoals':
                    $res = -( $a->sum_h2hAwayGoals - $b->sum_h2hAwayGoals );
                break;
                  
                case 'legs_diff':
                    $res = -($a->diff_team_legs - $b->diff_team_legs);
                break;
                  
                case 'leg_ratio':
                    $res = -($a->legRatio() - $b->legRatio());
                    if ($res != 0) $res=($res >= 0 ? 1 : -1);
                break;
                
                case 'win_legs':
                    $res = -($a->sum_team1_legs - $b->sum_team1_legs);
                break;
                    
                case 'total_wins':
                    $res = -( $a->cnt_won - $b->cnt_won );
                break;
                    
                default;
                  break;
            }
        }
        return $res;
    }

    /* 
     * compareWithAlpha calls compare, but adds a team alphabetical sorting 
     * if compare return 0
     * Should be declared static, but it's not ok for php4 :-(
     */
    function compareWithAlpha($a, $b)
    {
        $res = JoomleagueRankingAllTimeObject::compare($a, $b);
        if (!$res)
        {
            $res = strcasecmp($a->team->name, $b->team->name);
        }
        return $res;
    }
    
    function getPoints($include_start = true)
	{
		if ($include_start) {
			return $this->sum_points + $this->_startpoints;
		}
		else {
			return $this->sum_points;
		}
	}
}

?>
