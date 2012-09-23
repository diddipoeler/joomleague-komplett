<?php defined( '_JEXEC' ) or die( 'Restricted access' );

$columns		= explode( ',', $this->config['ordered_columns'] );
$column_names	= explode( ',', $this->config['ordered_columns_names'] );
?>
<thead>
	<tr class="sectiontableheader">
		<th class="rankheader" colspan="3">
			<?php JoomleagueHTML::printColumnHeadingSort( JText::_( 'JL_RANKING_POSITION' ), "rank", $this->config, "ASC" ); ?>
		</th>
		
		<?php
		if ( $this->config['show_logo_small_table'] > 0 )
		{
			echo '<th align="center" style="text-align: center" width="50">&nbsp;</th>';
		}
		?>
		
		<th class="teamheader">	
			<?php JoomleagueHTML::printColumnHeadingSort( JText::_( 'JL_RANKING_TEAM' ), "name", $this->config, "ASC" ); ?>
		</th>
		
<?php
	foreach ( $columns as $k => $column )
	{
		if (empty($column_names[$k])){$column_names[$k]='???';}
		
		$c=trim( strtoupper($column));
		
		$toolTipTitle=$column_names[$k];
		$toolTipText=JText::_($c);		
		
		switch ( trim( strtoupper( $column ) ) )	
		{
			case 'JL_PLAYED':
				echo '<th class="headers">';
				echo '<span class="hasTip" title="'.$toolTipTitle.'::'.$toolTipText.'">';			
				JoomleagueHTML::printColumnHeadingSort( $column_names[$k], "played", $this->config );
				echo '</th>';
				break;

			case 'JL_WINS':
				echo '<th class="headers">';
				echo '<span class="hasTip" title="'.$toolTipTitle.'::'.$toolTipText.'">';						
				JoomleagueHTML::printColumnHeadingSort( $column_names[$k], "won", $this->config );
				echo '</th>';
				break;

			case 'JL_TIES':
				echo '<th class="headers">';
				echo '<span class="hasTip" title="'.$toolTipTitle.'::'.$toolTipText.'">';	
				JoomleagueHTML::printColumnHeadingSort( $column_names[$k], "draw", $this->config );
				echo '</th>';
				break;

			case 'JL_LOSSES':
				echo '<th class="headers">';
				echo '<span class="hasTip" title="'.$toolTipTitle.'::'.$toolTipText.'">';	
				JoomleagueHTML::printColumnHeadingSort( $column_names[$k], "loss", $this->config );
				echo '</th>';
				break;

			case 'JL_WOT':
				echo '<th class="headers">';
				echo '<span class="hasTip" title="'.$toolTipTitle.'::'.$toolTipText.'">';	
				JoomleagueHTML::printColumnHeadingSort( $column_names[$k], "wot", $this->config );
				echo '</th>';
				break;

			case 'JL_WSO':
				echo '<th class="headers">';
				echo '<span class="hasTip" title="'.$toolTipTitle.'::'.$toolTipText.'">';	
				JoomleagueHTML::printColumnHeadingSort( $column_names[$k], "wso", $this->config );
				echo '</th>';
				break;

			case 'JL_LOT':
				echo '<th class="headers">';
				echo '<span class="hasTip" title="'.$toolTipTitle.'::'.$toolTipText.'">';	
				JoomleagueHTML::printColumnHeadingSort( $column_names[$k], "lot", $this->config );
				echo '</th>';
				break;

			case 'JL_LSO':
				echo '<th class="headers">';
				echo '<span class="hasTip" title="'.$toolTipTitle.'::'.$toolTipText.'">';	
				JoomleagueHTML::printColumnHeadingSort( $column_names[$k], "lso", $this->config );
				echo '</th>';
				break;
				
			case 'JL_WINPCT':
				echo '<th class="headers">';
				echo '<span class="hasTip" title="'.$toolTipTitle.'::'.$toolTipText.'">';	
				JoomleagueHTML::printColumnHeadingSort( $column_names[$k], "winpct", $this->config );
				echo '</th>';
				break;

			case 'JL_GB':
				echo '<th class="headers">';
				echo '<span class="hasTip" title="'.$toolTipTitle.'::'.$toolTipText.'">';	
				echo $column_names[$k];
				echo '</th>';
				break;

			case 'JL_LEGS':
				echo '<th class="headers">';
				echo '<span class="hasTip" title="'.$toolTipTitle.'::'.$toolTipText.'">';	
				echo $column_names[$k];
				echo '</th>';
				break;

			case 'JL_LEGS_DIFF':
				echo '<th class="headers">';
				echo '<span class="hasTip" title="'.$toolTipTitle.'::'.$toolTipText.'">';	
				JoomleagueHTML::printColumnHeadingSort( $column_names[$k], "legsdiff", $this->config );
				echo '</th>';
				break;

			case 'JL_LEGS_RATIO':
				echo '<th class="headers">';
				echo '<span class="hasTip" title="'.$toolTipTitle.'::'.$toolTipText.'">';	
				JoomleagueHTML::printColumnHeadingSort( $column_names[$k], "legsratio", $this->config );
				echo '</th>';
				break;				
				
			case 'JL_SCOREFOR':
				echo '<th class="headers">';
				echo '<span class="hasTip" title="'.$toolTipTitle.'::'.$toolTipText.'">';	
				JoomleagueHTML::printColumnHeadingSort( $column_names[$k], "goalsfor", $this->config );
				echo '</th>';
				break;				
				
			case 'JL_SCOREAGAINST':
				echo '<th class="headers">';
				echo '<span class="hasTip" title="'.$toolTipTitle.'::'.$toolTipText.'">';	
				JoomleagueHTML::printColumnHeadingSort( $column_names[$k], "goalsagainst", $this->config );
				echo '</th>';
				break;

			case 'JL_SCOREPCT':
				echo '<th class="headers">';
				echo '<span class="hasTip" title="'.$toolTipTitle.'::'.$toolTipText.'">';	
				echo $column_names[$k];
				echo '</th>';
				break;
				
			case 'JL_RESULTS':
				echo '<th class="headers">';
				echo '<span class="hasTip" title="'.$toolTipTitle.'::'.$toolTipText.'">';	
				JoomleagueHTML::printColumnHeadingSort( $column_names[$k], "goalsp", $this->config );
				echo '</th>';
				break;

			case 'JL_DIFF':
				echo '<th class="headers">';
				echo '<span class="hasTip" title="'.$toolTipTitle.'::'.$toolTipText.'">';	
				JoomleagueHTML::printColumnHeadingSort( $column_names[$k], "diff", $this->config );
				echo '</th>';
				break;

			case 'JL_POINTS':
				echo '<th class="headers">';
				echo '<span class="hasTip" title="'.$toolTipTitle.'::'.$toolTipText.'">';	
				JoomleagueHTML::printColumnHeadingSort( $column_names[$k], "points", $this->config );
				echo '</th>';
				break;

			case 'JL_NEGPOINTS':
				echo '<th class="headers">';
				echo '<span class="hasTip" title="'.$toolTipTitle.'::'.$toolTipText.'">';	
				JoomleagueHTML::printColumnHeadingSort( $column_names[$k], "negpoints", $this->config );
				echo '</th>';
				break;

			case 'JL_OLDNEGPOINTS':
				echo '<th class="headers">';
				echo '<span class="hasTip" title="'.$toolTipTitle.'::'.$toolTipText.'">';	
				JoomleagueHTML::printColumnHeadingSort( $column_names[$k], "negpoints", $this->config );
				echo '</th>';
				break;
				
			case 'JL_POINTS_RATIO':
				echo '<th class="headers">';
				echo '<span class="hasTip" title="'.$toolTipTitle.'::'.$toolTipText.'">';	
				JoomleagueHTML::printColumnHeadingSort( $column_names[$k], "pointsratio", $this->config );
				echo '</th>';
				break;				

			case 'JL_BONUS':
				echo '<th class="headers">';
				echo '<span class="hasTip" title="'.$toolTipTitle.'::'.$toolTipText.'">';	
				JoomleagueHTML::printColumnHeadingSort( $column_names[$k], "bonus", $this->config );
				echo '</th>';
				break;

			case 'JL_START':
				echo '<th class="headers">';
				echo '<span class="hasTip" title="'.$toolTipTitle.'::'.$toolTipText.'">';	
				JoomleagueHTML::printColumnHeadingSort( $column_names[$k], "start", $this->config );
				echo '</th>';
				break;

			case 'JL_QUOT':
				echo '<th class="headers">';
				echo '<span class="hasTip" title="'.$toolTipTitle.'::'.$toolTipText.'">';	
				JoomleagueHTML::printColumnHeadingSort( $column_names[$k], "quot", $this->config );
				echo '</th>';
				break;

			case 'JL_TADMIN':
				echo '<th class="headers">';
				echo '<span class="hasTip" title="'.$toolTipTitle.'::'.$toolTipText.'">';	
				echo $column_names[$k];
				echo '</th>';
				break;

			case 'JL_GFA':
				echo '<th class="headers">';
				echo '<span class="hasTip" title="'.$toolTipTitle.'::'.$toolTipText.'">';	
				echo $column_names[$k];
				echo '</th>';
				break;

			case 'JL_GAA':
				echo '<th class="headers">';
				echo '<span class="hasTip" title="'.$toolTipTitle.'::'.$toolTipText.'">';	
				echo $column_names[$k];
				echo '</th>';
				break;
				
			case 'JL_PPG':
				echo '<th class="headers">';
				echo '<span class="hasTip" title="'.$toolTipTitle.'::'.$toolTipText.'">';
				echo $column_names[$k];
				echo '</th>';
				break;				
				
			case 'JL_PPP':
				echo '<th class="headers">';
				echo '<span class="hasTip" title="'.$toolTipTitle.'::'.$toolTipText.'">';	
				echo $column_names[$k];
				echo '</th>';
				break;	
				
			case 'JL_LASTGAMES':
				echo '<th class="headers">';
				echo '<span class="hasTip" title="'.$toolTipTitle.'::'.$toolTipText.'">';	
				echo $column_names[$k];
				echo '</th>';
				break;		
				
			default:
				echo '<th class="headers">';
				echo '<span class="hasTip" title="'.$toolTipTitle.'::'.$toolTipText.'">';	
				echo JText::_($column);
				echo '</th>';
				break;
		}
	}
?>
	</tr>
</thead>