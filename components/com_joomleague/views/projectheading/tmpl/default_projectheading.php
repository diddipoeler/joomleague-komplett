<?php defined( '_JEXEC' ) or die( 'Restricted access' );

$nbcols = 2;
if ( $this->overallconfig['show_project_picture'] ) { $nbcols++; }
if ( $this->overallconfig['show_division_picture'] ) { $nbcols++; }
if ( $this->overallconfig['show_league_picture'] ) { $nbcols++; }

if ( $this->overallconfig['show_project_heading'] == "1" && $this->project)
{
	?>
	<div class="componentheading">
		<table class="contentpaneopen">
			<tbody>
				<?PHP
				if ( $this->overallconfig['show_project_country'] == "1" )
				{
					?>
				<tr class="contentheading">
					<td colspan="<?php echo $nbcols; ?>">
					<?php
					$country = $this->project->country;
					echo Countries::getCountryFlag($country) . ' ' . Countries::getCountryName($country);
					?>
					</td>
				</tr>
				<?php	
			   	}
				?>
				<tr class="contentheading">
					<?php
          if ( $this->overallconfig['show_league_picture'] == "1" )
					{
						?>
						<td>
						<?php
						echo JoomleagueHelper::getPictureThumb($this->project->league_picture,
																$this->project->league_name,
																$this->overallconfig['picture_width'],
																$this->overallconfig['picture_height'], 
																2);
						?>
						</td>
					<?php	
			    	}
            	
			    	if ( $this->overallconfig['show_project_picture'] == "1" )
					{
						?>
						<td>
						<?php
						echo JoomleagueHelper::getPictureThumb($this->project->picture,
																$this->project->name,
																$this->overallconfig['picture_width'],
																$this->overallconfig['picture_height'], 
																2);
						?>
						</td>
					<?php	
			    	}
			    	?>
					<td>
					<?php
					echo $this->project->name;
					if (isset( $this->division))
					{
					  if ( $this->overallconfig['show_division_picture'] == "1" )
					{
						?>
						<td>
						<?php
						echo JoomleagueHelper::getPictureThumb($this->division->picture,
																$this->division->name,
																$this->overallconfig['picture_width'],
																$this->overallconfig['picture_height'], 
																2);
						?>
						</td>
					<?php	
			    	}
					
					
						echo ' - ' . $this->division->name;
					}
					?>
					</td>
					
          <?php
          if ( $this->project->enable_sb && $this->project->sb_catid )
          {
          $link = JoomleagueHelperRoute::getKunenaForumRoute( $this->project->sb_catid );
          ?>
          <td class="buttonheading" align="right">
					<?php
					//echo $link;
          //$imageTitle = 'Zum Forum';
			    $image = JHTML::_(	'image',
														'media/com_joomleague/jl_images/forum_kunena.png',
														JText::_( 'JL_KUNENA_FORUM_TITLE' ),
														'title= "' . JText::_( 'JL_KUNENA_FORUM_TITLE' ) . '"' );
			
    			$temp = JHTML::link( $link, $image );
    			echo '  ' . $temp;
					?>
					</td>
          <?PHP
          }
          ?>
          <td class="buttonheading" align="right">
					<?php
					if(JRequest::getVar('print') != 1) {
						echo JoomleagueHelper::printbutton(null, $this->overallconfig);
					}
					?>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
<?php 
}
?>