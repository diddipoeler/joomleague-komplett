<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<!-- Start of show matches through all projects -->
<?php
if ( $this->games )
{
	?>

<h2><?php echo JText::_('JL_NEXTMATCH_HISTORY'); ?></h2>
<table width="100%">
	<tr>
		<td>
		<table width="96%" align="center" border="0" cellpadding="0" cellspacing="0">
			<?php
			//sort games by dates
			$gamesByDate = Array();

			$pr_id = 0;
			$k=0;
			foreach ( $this->games as $game )
			{
				$gamesByDate[substr( $game->match_date, 0, 10 )][] = $game;
			}
			// $teams = $this->project->getTeamsFromMatches( $this->games );

			foreach ( $gamesByDate as $date => $games )
			{
				foreach ( $games as $game )
				{
					if ($game->prid != $pr_id)
					{
						?>
			<thead>
			<tr class="sectiontableheader">
				<th colspan=10><?php echo $game->project_name;?></th>
			</tr>
			</thead>
			<?php
			$pr_id = $game->prid;
					}
					?>
					<?php
					$class = ($k == 0)? 'sectiontableentry1' : 'sectiontableentry2';
					$result_link = JoomleagueHelperRoute::getResultsRoute( $game->project_id,$game->roundid);
					$report_link = JoomleagueHelperRoute::getMatchReportRoute( $game->project_id,$game->id);
					$home = $this->gamesteams[$game->projectteam1_id];
					$away = $this->gamesteams[$game->projectteam2_id];
					?>
			<tr class="<?php echo $class; ?>">
				<td><?php
				echo JHTML::link( $result_link, $game->roundcode );
				?></td>
				<td nowrap="nowrap"><?php
				echo JHTML::date( $date, JText::_( 'JL_MATCHDAYDATE' ) );
				?></td>
				<td><?php
				echo substr( $game->match_date, 11, 5 );
				?></td>
				<td nowrap="nowrap"><?php
				echo $home->name;
				?></td>
				<td nowrap="nowrap">-</td>
				<td nowrap="nowrap"><?php
				echo $away->name;
				?></td>
				<td nowrap="nowrap"><?php
				echo $game->team1_result;
				?></td>
				<td nowrap="nowrap"><?php echo $this->overallconfig['seperator']; ?></td>
				<td nowrap="nowrap"><?php
				echo $game->team2_result;
				?></td>
				<td nowrap="nowrap"><?php
				if ($game->show_report==1)
				{
					$desc = JHTML::image( "media/com_joomleague/jl_images/zoom.png",
					JText::_( 'Match Report' ),
					array( "title" => JText::_( 'Match Report' ) ) );
					echo JHTML::link( $report_link, $desc);
				}
				$k = 1 - $k;
				?></td>
			</tr>
			<?php
				}
			}
			?>
		</table>
		</td>
	</tr>
</table>
<!-- End of  show matches through all projects -->
			<?php
}
?>
