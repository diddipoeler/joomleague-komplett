<?php 
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once (JPATH_COMPONENT . DS . 'extensions' . DS . 'jlext-diddipoeler' . DS. 'helpers' . DS . 'countries.php');

$nbcols = 2;
if ( $this->overallconfig['show_project_picture'] ) { $nbcols++; }

if ( $this->overallconfig['show_project_heading'] == "1" && $this->project)
{
?>

	<?php
	
	
			
			if ( $this->project->country && $this->overallconfig['show_project_country_info'] == "1" )
            {
			
$country = JText::_( Countriesdiddipoeler::convertIso3toFIFA($this->project->country));
//$country = $this->project->country;
$countryname = JText::_( Countriesdiddipoeler::getCountryName($this->project->country));
$countryinfo = Countriesdiddipoeler::getCountryInfo($this->project->country); 

if ( !$country )
{
$country = $this->project->country;
}

echo "<div style=\"background-image:url('http://ide.fifa.com/imgml/association2/". $country ."/h.jpg');background-position:left;height:99px;\">";
echo "<div style=\"left: 110px;position: absolute;top:14px;color:#FFFFFF;font-family:Arial;font-size:26px;padding-top:19px;line-height:21px;text-transform:uppercase\">";
echo $countryname;


?>

<img alt="" src="http://ide.fifa.com/imgml/flags/reflected/m/<?PHP echo $country; ?>.png" widht="38" height="38" />

<?PHP
echo "</div>";
echo "</div>";
?>
<div class="content-wrapper-1">
<div class="content-wrapper-2">
<div class="content-wrapper-3">
<div id="mainmiddle">
<div id="mainmiddle-expand">
<div id="content">
<div id="content-shift">
<div class="floatbox">
														
<div class="&#xA;      box">
<div class="bH ">
</div>
<div class="bC ">
<div class="maInfo">
<?PHP
echo "<table>";
echo "<tr>";
echo "<td>";
?>
<img class="maImg" width="120" height="160" src="http://de.fifa.com/imgml/maps/<?PHP echo $country; ?>.gif" alt="" />
<?PHP
echo "</td>";
echo "<td>";
echo $countryinfo[0];
echo "</td>";
echo "<td>";
echo $countryinfo[1];
echo "</td>";
echo "</tr>";
echo "</table>";
?>
</div>
</div>
</div>

</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<?PHP
}
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