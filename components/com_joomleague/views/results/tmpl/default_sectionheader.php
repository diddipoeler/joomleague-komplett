<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<!-- section header e.g. ranking, results etc. -->
<a id="jl_top"></a>

<?php
if ( $this->config['show_section_heading'] == 1 )
{
	?>
<table class="contentpaneopen">
	<tr>
		<td class="contentheading">
		<?php
		if ( $this->roundid)
		{
			$title = JText::_( 'JL_RESULTS_ROUND_RESULTS' );
			if ( isset( $this->division ) )
			{
				$title = JText::sprintf( 'JL_RESULTS_ROUND_RESULTS2', '<i>' . $this->division->name . '</i>' );
			}
			JoomleagueHelperHtml::showMatchdaysTitle(	$title, $this->roundid, $this->config );

			if ( $this->showediticon )
			{
				$link = JoomleagueHelperRoute::getResultsRoute( $this->project->id, $this->roundid, $this->model->divisionid, $this->model->mode, $this->model->order, 'form');
				$imgTitle = JText::_( 'JL_RESULTS_ENTER_EDIT_RESULTS' );
				$desc = JHTML::image( 'media/com_joomleague/jl_images/edit.png', $imgTitle, array( ' title' => $imgTitle ) );
				echo ' ';
				echo JHTML::link( $link, $desc );
			}

		}
		else
		{
			//1 request for current round
			// seems to be this shall show a plan of matches of a team???
			JoomleagueHelperHtml::showMatchdaysTitle( JText::_( 'JL_RESULTS_PLAN' ) . " - " . $team->name, 0, $this->config );
		}
		?>
		</td>
			<?php if ($this->config['show_matchday_dropdown']==1) { ?>
	            <td class="contentheading" style="text-align:right; font-size: 100%;">
			<?php echo JoomleagueHelperHtml::getRoundSelectNavigation(FALSE); ?>
				</td>
    	    <?php } ?>
		</tr>
</table>

<?php
}
?>