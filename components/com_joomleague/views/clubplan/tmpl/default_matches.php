<?php defined('_JEXEC') or die('Restricted access'); ?>
<!-- START: matches -->
<table width="96%" align="center" border="0" cellpadding="0" cellspacing="0">
<?php
if ($this->config['type_matches'] != 0) {
?>
	<tr class="sectiontableheader">
		<?php if ($this->config['show_matchday']==1) { ?>
		<th><?php echo JText::_('JL_CLUBPLAN_MATCHDAY'); ?></th>
		<?php } ;?>
		<?php if ($this->config['show_match_nr']==1) { ?>
		<th><?php echo JText::_('JL_CLUBPLAN_MATCH_NR'); ?></th>
		<?php } ;?>		
		<?php if ($this->config['show_match_date']==1) { ?>
		<th><?php echo JText::_('JL_CLUBPLAN_DATE');?></th>
		<?php } ;?>
		<?php if ($this->config['show_match_time']==1) { ?>
		<th><?php echo JText::_('JL_CLUBPLAN_TIME'); ?></th>
		<?php } ;?>
		<?php if ($this->config['show_time_present']==1) { ?>
		<th><?php echo JText::_('JL_CLUBPLAN_TIME_PRESENT'); ?></th>
		<?php } ;?>
		<?php if ($this->config['show_league']==1) { ?>		
		<th><?php echo JText::_('JL_CLUBPLAN_LEAGUE'); ?></th>
		<?php } ;?>		
		<?php if ($this->config['show_club_logo']==1) { ?>
		<th></th>
		<?php } ?>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		<?php if ($this->config['show_club_logo']==1) { ?>
		<th>&nbsp;</th>
		<?php } ?>
		<th>&nbsp;</th>
		<?php if ($this->config['show_referee']==1) { ?>
		<th><?php echo JText::_('JL_CLUBPLAN_REFEREE'); ?></th>
		<?php } ;?>
		<?php if ($this->config['show_playground']==1) { ?>
		<th><?php echo JText::_('JL_CLUBPLAN_PLAYGROUND'); ?></th>
		<?php } ;?>
		<th colspan=3 align="center"><?php echo JText::_('JL_CLUBPLAN_RESULT'); ?></th>
		<?php if ($this->config['show_thumbs_picture']==1) { ?>
		<th align="center">&nbsp;</th>
		<?php } ;?>
	</tr>
<?php
}
		$k=0;
		$club_id = JRequest::getInt('cid') != -1 ? JRequest::getInt('cid') : false;
		$prevDate = '';
		foreach ($this->matches as $game)
		{
			if ($this->config['type_matches'] == 0) {
			   $gameDate = strftime("%Y-%m-%d",strtotime($game->match_date));
			   if ($gameDate != $prevDate) {
				?>
					<tr class="sectiontableheader">
						<th colspan="16">
							<?php echo JHTML::date($game->match_date,JText::_('JL_CLUBPLAN_MATCHDATE'));?>
						</th>
					</tr>
				<?php
					$prevDate = $gameDate;
				}
			}


			$class=($k==0)? $this->config['style_class1'] : $this->config['style_class2'];
			$result_link=JoomleagueHelperRoute::getResultsRoute($game->project_id,$game->roundid);
			$nextmatch_link=JoomleagueHelperRoute::getNextmatchRoute($game->project_id,$game->id);
			$teaminfo1_link =JoomleagueHelperRoute::getTeamInfoRoute($game->project_id,$game->team1_id);
			$teaminfo2_link =JoomleagueHelperRoute::getTeamInfoRoute($game->project_id,$game->team2_id);
			$teamstats1_link =JoomleagueHelperRoute::getTeamStatsRoute($game->project_id,$game->team1_id);
			$teamstats2_link =JoomleagueHelperRoute::getTeamStatsRoute($game->project_id,$game->team2_id);
			$playground_link =JoomleagueHelperRoute::getPlaygroundRoute($game->project_id,$game->playground_id);
			$favs = JoomleagueHelper::getProjectFavTeams($game->project_id);
			$favteams = explode(",",$favs->fav_team);
			$hometeam				= $game;
			$awayteam				= $game;
			
			$isFavTeam				= false;
			$isFavTeam				= in_array($game->team1_id,$favteams);
			$hometeam->name			= $game->tname1. ' ('.$game->tinfo1.')';
			$hometeam->team_id		= $game->team1_id;
			$hometeam->id 			= $game->team1_id;
			$hometeam->short_name	= $game->tname1_short. ' ('.$game->tinfo1.')';
			$hometeam->middle_name	= $game->tname1_middle. ' ('.$game->tinfo1.')';
			$hometeam->project_id	= $game->prid;
			$hometeam->club_id		= $game->t1club_id;
			$hometeam->projectteamid = $game->projectteam1_id;
			$tname1 = JoomleagueHelper::formatTeamName($hometeam,'clubplanhome',$this->config,$isFavTeam,0);
			
			$isFavTeam				= false;
			$isFavTeam				= in_array($game->team2_id,$favteams);
			$awayteam->name			= $game->tname2. ' ('.$game->tinfo2.')';
			$awayteam->team_id		= $game->team2_id;
			$awayteam->id 			= $game->team2_id;
			$awayteam->short_name	= $game->tname2_short. ' ('.$game->tinfo2.')';
			$awayteam->middle_name	= $game->tname2_middle. ' ('.$game->tinfo2.')';
			$awayteam->project_id	= $game->prid;
			$awayteam->club_id		= $game->t2club_id;
			$awayteam->projectteamid = $game->projectteam2_id;
			$tname2 = JoomleagueHelper::formatTeamName($awayteam,'clubplanaway',$this->config,$isFavTeam,0);

			$favStyle = '';
			if ($this->config['highlight_fav'] == 1 && !$club_id) {
				$isFavTeam = in_array($game->team1_id,$favteams) ? 1 : in_array($game->team2_id, $favteams);
				if ( $isFavTeam && $favs->fav_team_highlight_type == 1 )
				{
					if( trim( $favs->fav_team_color ) != "" )
					{
						$color = trim($favs->fav_team_color);
					}
					$format = "%s";
					$favStyle = ' style="';
					$favStyle .= ($favs->fav_team_text_bold != '') ? 'font-weight:bold;' : '';
					$favStyle .= (trim($favs->fav_team_text_color) != '') ? 'color:'.trim($favs->fav_team_text_color).';' : '';
					$favStyle .= ($color != '') ? 'background-color:' . $color . ';' : '';
					if ($favStyle != ' style="')
					{
					  $favStyle .= '"';
					}
					else {
					  $favStyle = '';
					}
				}
			}

			?>
			<tr class="<?php echo $class; ?>"<?php echo $favStyle; ?>>
					<?php if ($this->config['show_matchday']==1) { ?>
				<td>
					<?php if ($this->config['which_link']==0) { ?>
					<?php
					echo $game->roundcode ;
					}
					?>
					<?php if ($this->config['which_link']==1) { ?>
					<?php
					echo JHTML::link($result_link,$game->roundcode);
					}
					?>
					<?php if ($this->config['which_link']==2) { ?>
					<?php
					echo JHTML::link($nextmatch_link,$game->roundcode);
					}
					?>
				</td>
					<?php } ;?>
					
					<?php if ($this->config['show_match_nr']==1) { ?>
				<td>
					<?php echo $game->match_number ; ?>
				</td>
					<?php } ;?>
				
				<?php if ($this->config['show_match_date']==1) { ?>
				<td>
					<?php
					echo JHTML::date($game->match_date,JText::_('JL_CLUBPLAN_MATCHDATE'));
					?>
				</td>
					<?php } ;?>
					
				<?php if ($this->config['show_match_time']==1) { ?>
				<td nowrap="nowrap">
					<?php
					echo JoomleagueHelperHtml::showMatchTime($game, $this->config, $this->overallconfig, $this->project);
					?>
				</td>
					<?php } ;?>
					
				<?php if ($this->config['show_time_present']==1) { ?>
				<td nowrap="nowrap">
					<?php
					echo $game->time_present;
					?>
				</td>
					<?php } ?>
					
				<?php if ($this->config['show_league']==1) { ?>							
				<td>
					<?php
					echo $game->l_name;
					?>
				</td>
					<?php } ?>				
				<td class="td_r">
					<?php if ($this->config['which_link2']==0) { ?>
					<?php
					echo $tname1 ;
					}
					?>
					<?php if ($this->config['which_link2']==1) { ?>
					<?php
					echo JHTML::link($teaminfo1_link,$tname1);
					}
					?>
					<?php if ($this->config['which_link2']==2) { ?>
					<?php
					echo JHTML::link($teamstats1_link,$tname1);
					}
					?>
				</td>
					<?php if ($this->config['show_club_logo']==1) { ?>
				<td>
					<?php echo JoomleagueModelClubPlan::getClubIconHtmlSimple($game->home_logo_small,1); ?>
				</td>
					<?php } ?>				
				<td>
					-
				</td>
					<?php if ($this->config['show_club_logo']==1) { ?>
				<td>
					<?php echo JoomleagueModelClubPlan::getClubIconHtmlSimple($game->away_logo_small,1); ?>
				</td>
					<?php } ?>
				<td>
					<?php if ($this->config['which_link2']==0) { ?>
					<?php
					echo $tname2 ;
					}
					?>
					<?php if ($this->config['which_link2']==1) { ?>
					<?php
					echo JHTML::link($teaminfo2_link, $tname2);
					}
					?>
					<?php if ($this->config['which_link2']==2) { ?>
					<?php
					echo JHTML::link($teamstats2_link, $tname2);
					}
					?>
				</td>
					<?php if ($this->config['show_referee']==1) { ?>
				<td>
					<?php
					$matchReferees=&$this->model->getMatchReferees($game->id);
					foreach ($matchReferees AS $matchReferee)
					{
						$referee_link=JoomleagueHelperRoute::getRefereeRoute($game->project_id,$matchReferee->id);
						echo JHTML::link($referee_link,$matchReferee->firstname." ".$matchReferee->lastname);
						echo '<br />';
					}
					?>
				</td>
					<?php } ;?>
					<?php if ($this->config['show_playground']==1) { ?>
				<td>
					<?php
					echo JHTML::link($playground_link,$game->pl_name);
					?>
				</td>
					<?php } ;?>
					<?php
					$score="";
					if (!$game->alt_decision)
					{
						$e1 =$game->team1_result;
						$e2 =$game->team2_result;
					}
					else
					{
						$e1 =(isset($game->team1_result_decision)) ? $game->team1_result_decision : 'X';
						$e2 =(isset($game->team2_result_decision)) ? $game->team2_result_decision : 'X';
					}
					
					if ($game->cancel==0) {
						$score .= '<td align="center">';
						$score .= $e1;
						$score .= '</td><td align="center">-</td><td align="center">';
						$score .= $e2;
					} else {
						$score .= '<td align="center" valign="top" colspan="3">'.$game->cancel_reason.'</td>';
					}
					echo $score;
					if ($this->config['show_thumbs_picture']==1) {
					   switch ($this->config['type_matches']) {
					   case 1 : // home matches
							$team1=$e1;
							$team2=$e2;
							break;
					   case 2 : // away matches
							$team2=$e1;
							$team1=$e2;
							break;
						default : // home+away matches, but take care of the select club from the menu item to have the icon correct displayed
							if ($game->club1_id == $club_id) {
								$team1=$e1;
								$team2=$e2;
							} else if ($game->club2_id == $club_id) {
								$team1=$e2;
								$team2=$e1;
							} else {
								$team1=$e1;
								$team2=$e2;
							}
					   }
						if(isset($team1) && isset($team2) && ($team1==$team2)) {
							echo '<td align="center" valign="middle">' .
							JHTML::image("media/com_joomleague/jl_images/draw.png",
							"draw.png",
							array("title" => JText::_('JL_CLUBPLAN_MATCH_DRAW'))
							)."&nbsp;</td>";
						} else {
							if($team1 > $team2) {
								echo '<td align="center" valign="middle">' .
								JHTML::image("media/com_joomleague/jl_images/thumbs_up.png",
								"thumbs_up.png",
								array("title" => JText::_('JL_CLUBPLAN_MATCH_WON'))
								)."&nbsp;</td>";
							} elseif($team2 > $team1) {
								echo '<td align="center" valign="middle">' .
								JHTML::image("media/com_joomleague/jl_images/thumbs_down.png",
								"thumbs_down.png",
								array("title" => JText::_('JL_CLUBPLAN_MATCH_LOST'))
								)."&nbsp;</td>";
							}
							else
							{
								echo "<td>&nbsp;</td>";
							}
						}
					}
					?>
				</tr>
		<?php
		$k=1 - $k;
		} ;
		?>
</table>
<br />
<!-- END: matches -->