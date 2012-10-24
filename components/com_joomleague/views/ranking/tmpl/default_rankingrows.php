<?php
JHTML::_('behavior.tooltip');

$current  = &$this->current;
$previous = &$this->previousRanking[$this->division];

$config   = &$this->tableconfig;

$counter = 1;
$k = 0;
$j = 0;
$temprank = 0;

$columns = explode( ",", $config['ordered_columns'] );

foreach( $current as $ptid => $team )
{
	$team->team = $this->teams[$ptid];

//	var_dump($team);			
//**********Table colors
	$class = ($k == 0)? $config['style_class1'] : $config['style_class2'];
	$color = "";
			
	if ( isset( $this->colors[$j]["from"] ) && $counter == $this->colors[$j]["from"] )
	{
		$color = $this->colors[$j]["color"];
	}

	if ( isset( $this->colors[$j]["from"] ) && isset( $this->colors[$j]["to"] ) &&
		( $counter > $this->colors[$j]["from"] && $counter <= $this->colors[$j]["to"] ) )
	{
		$color = $this->colors[$j]["color"];
	}

	if ( isset( $this->colors[$j]["to"] ) && $counter == $this->colors[$j]["to"] )
	{
		$j++;
	}

//**********Favorite Team
	$format = "%s";
	$favStyle = '';
	if ( in_array( $team->team->id, explode(",",$this->project->fav_team) ) && $this->project->fav_team_highlight_type == 1 )
	{
		if( trim( $this->project->fav_team_color ) != "" )
		{
			$color = trim($this->project->fav_team_color);
		}
		$format = "%s";
		$favStyle = ' style="';
		$favStyle .= ($this->project->fav_team_text_bold != '') ? 'font-weight:bold;' : '';
		$favStyle .= (trim($this->project->fav_team_text_color) != '') ? 'color:'.trim($this->project->fav_team_text_color).';' : '';
	
		if ($favStyle != ' style="')
		{
			$favStyle .= '"';
		}
		else 
		{
		$favStyle = '';
		}
	}
	echo "\n\n";
	echo '<tr class="' . $class . '"' . $favStyle . '>';
	echo "\n";

//**************rank row	
	echo '<td class="rankingrow_rank" ';
	if( $color != '' )
	{
		echo ' style="background-color: ' . $color . '"';
	}
	echo ' align="right" nowrap="nowrap">';

	if ( $team->rank != $temprank )
	{
		printf( $format, $team->rank );
	}
	else
	{
		echo "-";
	}

	echo '</td>';
	echo "\n";
	
//**************Last rank (image)
	echo '<td class="rankingrow_lastrankimg" ';
	if ( $color != '' && $config['row_colors'] )
	{
		echo " style='background-color: " . $color . "'";
	}
	echo ">";
	echo JoomleagueHelperHtml::getLastRankImg($team,$previous,$ptid);
	echo '</td>';
	echo "\n";				
	
//**************Last rank (number)	
  echo '<td class="rankingrow_lastrank" ';
	if ( $color != '' && $config['row_colors'] )
	{
		echo " style='background-color: " . $color . "'";
	}
	echo ">";
  
	if ( ( $this->tableconfig['last_ranking'] == 1 ) && ( isset( $previous[$ptid]->rank ) ) )
	{
		echo "(" . $previous[$ptid]->rank . ")";
	}
	echo '</span>';
	echo '</td>';
	echo "\n";
				
//**************logo - jersey
	if ( $config['show_logo_small_table'] > 0 )
	{
		
    if ( $config['show_logo_small_table'] > 2 )
    {
    echo '<td nowrap="nowrap"';
    }
    else
    {
    echo '<td class="rankingrow_logo"';
    }
    
    
		if ( $color != '' && $config['row_colors'] )
		{
			echo ' style="background-color: ' . $color . '"';
		}
		echo ">";

    JoomleagueHelper::showClubIcon($team->team, $config['show_logo_small_table']);

    echo '</td>';
		echo "\n";
	}
				
//**************Team name
	echo '<td class="rankingrow_teamname" nowrap="nowrap"';
	if ( $color != '' && $config['row_colors'] )
	{
		echo ' style="background-color: ' . $color . '"';
	}
	echo ">";
	$config['highlight_fav'] = in_array( $team->team->id, explode(",",$this->project->fav_team) ) ? 1 : 0;
	echo JoomleagueHelper::formatTeamName( $team->team, 'tr' . $team->team->id, $config, $config['highlight_fav'] );
	echo '</td>';
	echo "\n";

//**********START OPTIONAL COLUMNS DISPLAY
//var_dump($team);
			foreach ( $columns AS $c )
			{
				  switch ( trim( strtoupper( $c ) ) )
				  {
					  case 'JL_PLAYED':
						echo '<td class="rankingrow_played" ';
							if ( $color != '' && $config['row_colors']  )
							{
								echo 'style="background-color:' . $color . '"';
							}
							echo '>';
							printf( $format, $team->cnt_matches );
						echo '</td>';
						echo "\n";
					break;

					case 'JL_WINS':
						echo '<td class="rankingrow" ';
							if ( $color != '' && $config['row_colors']  )
							{
								echo 'style="background-color:' . $color . '"';
							}
							echo '>';
							if (( $config['show_wdl_teamplan_link'])==1)
							{
							$teamplan_link  = JoomleagueHelperRoute::getTeamPlanRoute($this->project->id, $team->_teamid, 0, 1);
							echo JHTML::link($teamplan_link, $team->cnt_won);
							}
							else
							{
							printf( $format, $team->cnt_won );
							}
						echo '</td>';
						echo "\n";
					break;

					case 'JL_TIES':
						echo '<td class="rankingrow" ';
							if ( $color != '' && $config['row_colors']  )
							{
								echo 'style="background-color:' . $color . '"';
							}
							echo '>';
							if (( $config['show_wdl_teamplan_link'])==1)
							{							
							$teamplan_link  = JoomleagueHelperRoute::getTeamPlanRoute($this->project->id, $team->_teamid, 0, 2);
							echo JHTML::link($teamplan_link, $team->cnt_draw); 
							}
							else
							{							
							printf( $format, $team->cnt_draw );
							}
						echo '</td>';
						echo "\n";
					break;

					case 'JL_LOSSES':
						echo '<td class="rankingrow"';
							if ( $color != '' && $config['row_colors']  )
							{
								echo 'style="background-color:' . $color . '"';
							}
							echo '>';
							if (( $config['show_wdl_teamplan_link'])==1)
							{							
							$teamplan_link  = JoomleagueHelperRoute::getTeamPlanRoute($this->project->id, $team->_teamid, 0, 3);
							echo JHTML::link($teamplan_link, $team->cnt_lost); 	
							}
							else
							{							
							printf( $format, $team->cnt_lost );
							}
						echo '</td>';
						echo "\n";
					break;

					case 'JL_WOT':   
						echo '<td class="rankingrow"';
							if ( $color != '' && $config['row_colors']  )
							{
								echo 'style="background-color:' . $color . '"';
							}
							echo '>';
							printf( $format, $team->cnt_wot );
						echo '</td>';
						echo "\n";
					break;

					case 'JL_WSO':   
						echo '<td class="rankingrow"';
							if ( $color != '' )
							{
								echo 'style="background-color:' . $color . '"';
							}
							echo '>';
							printf( $format, $team->cnt_wso );
						echo '</td>';
						echo "\n";
					break;

					case 'JL_LOT':   
						echo '<td class="rankingrow"';
							if ( $color != '' && $config['row_colors']  )
							{
								echo 'style="background-color:' . $color . '"';
							}
							echo '>';
							printf( $format, $team->cnt_lot );
						echo '</td>';
						echo "\n";
					break;
					
					case 'JL_LSO':   
						echo '<td class="rankingrow"';
							if ( $color != '' && $config['row_colors']  )
							{
								echo 'style="background-color:' . $color . '"';
							}
							echo '>';
							printf( $format, $team->cnt_lso );
						echo '</td>';
						echo "\n";
					break;					
					
					case 'JL_WINPCT':
						echo '<td class="rankingrow"';
							if ( $color != '' && $config['row_colors']  )
							{
								echo 'style="background-color:' . $color . '"';
							}
							echo '>';
							printf( $format, sprintf( "%.3F", ($team->winpct() ) ) );
						echo '</td>';
						echo "\n";
					break;

					case 'JL_GB':
						//GB calculation, store wins and loss count of the team in first place
						if ( $team->rank == 1 )
						{
							$ref_won = $team->cnt_won;
							$ref_lost = $team->cnt_lost;
						}
						echo '<td class="rankingrow"';
							if ( $color != '' && $config['row_colors']  )
							{
								echo 'style="background-color:' . $color . '"';
							}
							echo '>';
							printf( $format, round( ( ( $ref_won - $team->cnt_won ) - ( $ref_lost - $team->cnt_lost ) ) / 2, 1 ) );
						echo '</td>';
						echo "\n";

					break;

					case 'JL_LEGS':
						echo '<td class="rankingrow"';
							if ( $color != '' && $config['row_colors']  )
							{
								echo 'style="background-color:' . $color . '"';
							}
							echo '>';
							printf( $format, sprintf( "%s:%s", $team->sum_team1_legs, $team->sum_team2_legs ) );
						echo '</td>';
						echo "\n";
					break;
					
					case 'JL_LEGS_DIFF':   
						echo '<td class="rankingrow"';
							if ( $color != '' && $config['row_colors']  )
							{
								echo 'style="background-color:' . $color . '"';
							}
							echo '>';
							printf( $format, $team->diff_team_legs );
						echo '</td>';
						echo "\n";
					break;

					case 'JL_LEGS_RATIO':   
						echo '<td class="rankingrow"';
							if ( $color != '' && $config['row_colors']  )
							{
								echo 'style="background-color:' . $color . '"';
							}
							echo '>';
							$legsratio=round(($team->legsRatio()),2);
							printf( $format, $legsratio );
						echo '</td>';
						echo "\n";
					break;					
					
					case 'JL_SCOREFOR':
						echo '<td class="rankingrow"';
							if ( $color != '' && $config['row_colors']  )
							{
								echo 'style="background-color:' . $color . '"';
							}
							echo '>';
							printf( $format, sprintf( "%s" , $team->sum_team1_result ) );
						echo '</td>';
						echo "\n";
					break;

					case 'JL_SCOREAGAINST':
						echo '<td class="rankingrow"';
							if ( $color != '' && $config['row_colors']  )
							{
								echo 'style="background-color:' . $color . '"';
							}
							echo '>';
							printf( $format, sprintf( "%s", $team->sum_team2_result ) );
						echo '</td>';
						echo "\n";
					break;
					
					case 'JL_SCOREPCT':
						echo '<td class="rankingrow"';
							if ( $color != '' && $config['row_colors']  )
							{
								echo 'style="background-color:' . $color . '"';
							}
							echo '>';
							$scorepct=round(($team->scorePct()),2);
							printf( $format, $scorepct );
							
						echo '</td>';
						echo "\n";
					break;					
					
					case 'JL_RESULTS':
						echo '<td class="rankingrow"';
							if ( $color != '' && $config['row_colors']  )
							{
								echo 'style="background-color:' . $color . '"';
							}
							echo '>';
							printf( $format, sprintf( "%s" . ":" . "%s", $team->sum_team1_result, $team->sum_team2_result ) );
						echo '</td>';
						echo "\n";
					break;

					case 'JL_DIFF':
						echo '<td class="rankingrow"';
							if ( $color != '' && $config['row_colors']  )
							{
								echo 'style="background-color:' . $color . '"';
							}
							echo '>';
							printf( $format, $team->diff_team_results );
						echo '</td>';
						echo "\n";
					break;

					case 'JL_POINTS':
						echo '<td class="rankingrow_points"';
							if ( $color != '' && $config['row_colors']  )
							{
								echo 'style="background-color:' . $color . '"';
							}
							echo '>';
							printf( $format, $team->getPoints() );
						echo '</td>';
						echo "\n";
					break;

					case 'JL_NEGPOINTS':
						echo '<td class="rankingrow"';
							if ( $color != '' && $config['row_colors']  )
							{
								echo 'style="background-color:' . $color . '"';
							}
							echo '>';
							printf( $format, $team->neg_points );
						echo '</td>';
						echo "\n";
					break;

					case 'JL_OLDNEGPOINTS':
						echo '<td class="rankingrow"';
							if ( $color != '' && $config['row_colors']  )
							{
								echo 'style="background-color:' . $color . '"';
							}
							echo '>';
							printf( $format, sprintf( "%s" . ":" . "%s", $team->getPoints(), $team->neg_points ) );
						echo '</td>';
						echo "\n";
					break;
					
					case 'JL_POINTS_RATIO':   
						echo '<td class="rankingrow"';
							if ( $color != '' && $config['row_colors']  )
							{
								echo 'style="background-color:' . $color . '"';
							}
							echo '>';					
							$pointsratio=round(($team->pointsRatio()),2);
							printf( $format, $pointsratio );
						echo '</td>';
						echo "\n";
					break;	
					
					case 'JL_BONUS':
						echo '<td class="rankingrow"';
							if ( $color != '' && $config['row_colors']  )
							{
								echo 'style="background-color:' . $color . '"';
							}
							echo '>';
							printf( $format, $team->bonus_points );
						echo '</td>';
						echo "\n";
					break;

					case 'JL_START':
						echo '<td class="rankingrow"';
							if ( $color != '' && $config['row_colors']  )
							{
								echo 'style="background-color:' . $color . '"';
							}
							echo '>';
							if ((($team->team->start_points)!=0) AND (( $config['show_manipulations'])==1))
							{
								$toolTipTitle	= JText::_('JL_START');
								$toolTipText	= $team->team->reason;
								?>
								<span class="hasTip" title="<?php echo $toolTipTitle; ?> :: <?php echo $toolTipText; ?>">
								<?php
								printf( $format, $team->team->start_points );
								?>
								</span>
							
							<?php
							}
							else
							{
								printf( $format, $team->team->start_points );
							}
						echo '</td>';
						echo "\n";
					break;

					case 'JL_QUOT':
						echo '<td class="rankingrow"';
							if ( $color != '' && $config['row_colors']  )
							{
								echo 'style="background-color:' . $color . '"';
							}
							echo '>';							
							$pointsquot = number_format( $team->pointsQuot(), 3, ",", "." );
							printf($format, $pointsquot);
						echo '</td>';
						echo "\n";
					break;
					
					case 'JL_TADMIN':
						echo '<td class="rankingrow"';
							if ( $color != '' && $config['row_colors']  )
							{
								echo 'style="background-color:' . $color . '"';
							}
							echo '>';
							printf( $format, $team->team->username );
						echo '</td>';
						echo "\n";
					break;

					case 'JL_GFA':
						echo '<td class="rankingrow"';
							if ( $color != '' && $config['row_colors']  )
							{
								echo 'style="background-color:' . $color . '"';
							}
							echo '>';
							$gfa=round(($team->getGFA()),2);
							printf( $format, $gfa );
							
						echo '</td>';
						echo "\n";
					break;	
					
					case 'JL_GAA':
						echo '<td class="rankingrow"';
							if ( $color != '' && $config['row_colors']  )
							{
								echo 'style="background-color:' . $color . '"';
							}
							echo '>';
							$gaa=round(($team->getGAA()),2);
							printf( $format, $gaa );
							
						echo '</td>';
						echo "\n";
					break;						
					
					case 'JL_PPG':
						echo '<td class="rankingrow"';
							if ( $color != '' && $config['row_colors']  )
							{
								echo 'style="background-color:' . $color . '"';
							}
							echo '>';
							$gaa=round(($team->getPPG()),2);
							printf( $format, $gaa );
							
						echo '</td>';
						echo "\n";
					break;	

					case 'JL_PPP':
						echo '<td class="rankingrow"';
							if ( $color != '' && $config['row_colors']  )
							{
								echo 'style="background-color:' . $color . '"';
							}
							echo '>';
							$gaa=round(($team->getPPP()),2);
							printf( $format, $gaa );
							
						echo '</td>';
						echo "\n";
					break;	
					
					case 'JL_LASTGAMES':
						echo '<td class="rankingrow lastgames"';
							if ( $color != '' && $config['row_colors']  )
							{
								echo 'style="background-color:' . $color . '"';
							}
							echo '>';
							foreach ($this->previousgames[$ptid] as $g) 
							{
								$txt = $this->teams[$g->projectteam1_id]->name.' [ '. $g->team1_result . ' - '. $g->team2_result . ' ] '.$this->teams[$g->projectteam2_id]->name;
								$attribs = array('title' => $txt);
								if (!$img = JoomleagueHelperHtml::getThumbUpDownImg($g, $ptid, $attribs)) {
									continue;
								}
								switch (JoomleagueHelper::getTeamMatchResult($g, $ptid))
								{
									case -1:
										$attr = array('class' => 'thumblost');
										break;
									case 0:
										$attr = array('class' => 'thumbdraw');
										break;
									case 1:
										$attr = array('class' => 'thumbwon');
										break;
								}
								
								$url = JRoute::_(JoomleagueHelperRoute::getMatchReportRoute($g->project_slug, $g->slug));
								echo JHTML::link($url, $img, $attr);
							}
						echo '</td>';
						echo "\n";
					break;					
				}
			}

	echo '</tr>';
	echo "\n";
	$k = 1 - $k;
	$counter++;
	$temprank = $team->rank;
}