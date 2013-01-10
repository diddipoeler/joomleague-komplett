<?php defined( '_JEXEC' ) or die( 'Restricted access' );?>

<!-- Main START -->
<a name="jl_top" id="jl_top"></a>

<!-- content -->
<?php
foreach ( $this->currentRanking as $division => $cu_rk )
{
	if ($division)
	{
	?>
	<table width="96%" align="center" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td class="contentheading">
				<?php
					//get the division name from the first team of the division 
					foreach( $cu_rk as $ptid => $team )
					{
					
					if ( $this->overallconfig['show_division_picture'] == "1" )
					{
						?>
						
						<?php
						echo JoomleagueHelper::getPictureThumb($this->divisions[$division]->picture,
																$this->divisions[$division]->name,
																$this->overallconfig['picture_width'],
																$this->overallconfig['picture_height'], 
																2);
						?>
						
					<?php	
			    	}
			    	
						echo $this->divisions[$division]->name;
						break;
					}
				?>
			</td>
		</tr>
		<?PHP
    if ( $this->overallconfig['show_division_desc'] == "1" )
					{
          foreach( $cu_rk as $ptid => $team )
					{
					?>
	<tr class="contentheading">
			<td>				
					<?PHP
					echo $this->divisions[$division]->division_desc;
					?>
			</td>
		</tr>
		      <?PHP
					break;
          }
          }
    ?>

	</table>

	<table width="96%" align="center" border="0" cellpadding="0" cellspacing="0">
	<?php
		foreach( $cu_rk as $ptid => $team )
		{
			echo $this->loadTemplate('rankingheading');
			break;
		}
		$this->division = $division;
		$this->current  = &$cu_rk;
		echo $this->loadTemplate('rankingrows');
	?>
	</table>
	<?php
	}
	else
	{
	?>
	<table width="96%" align="center" border="0" cellpadding="0" cellspacing="0">
		<?php
			echo $this->loadTemplate('rankingheading');
			$this->division = $division;
			$this->current  = &$cu_rk;
			echo $this->loadTemplate('rankingrows');
		?>
	</table>
	<br />
	<?php
	}
}
	?>
<!-- ranking END -->



