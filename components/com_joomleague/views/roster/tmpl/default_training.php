<?php 
defined('_JEXEC') or die('Restricted access');

//echo 'trainingData <br><pre>'.print_r($this->trainingData,true).'</pre><br>';

?>
<br>
	<table width="100%" class="contentpaneopen">
		<tr>
			<td class="contentheading">
				<?php
				echo '&nbsp;';
				if ($this->config['show_team_shortform'] == 1)
				{
					echo JText::sprintf('JL_ROSTER_TRAININGDATA_OF2',$this->team->name, $this->team->short_name);
				}
				else
				{
					echo JText::sprintf('JL_ROSTER_TRAININGDATA_OF',$this->team->name);
				}
				?>
			</td>
		</tr>
	</table>
	<br />
	
<fieldset class="adminform">
				
				<table class='admintable' border='0'>
					<tr>
						
						<td class='key' style='text-align:center;' width='5%'><?php echo JText::_('JL_TRAININGDATA_P_TEAM_DAY'); ?></td>
						<td class='key' style='text-align:center;' width='5%'><?php echo JText::_('JL_TRAININGDATA_P_TEAM_STARTTIME'); ?></td>
						<td class='key' style='text-align:center;' width='5%'><?php echo JText::_('JL_TRAININGDATA_P_TEAM_ENDTIME'); ?></td>
						<td class='key' style='text-align:center;'><?php echo JText::_('JL_TRAININGDATA_P_TEAM_PLACE'); ?></td>
						<td class='key' style='text-align:center;'><?php echo JText::_('JL_TRAININGDATA_P_TEAM_NOTES'); ?></td>
					</tr>
					<?php
					if (!empty($this->trainingData))
					{
						?>
						<input type='hidden' name='tdCount' value='<?php echo count($this->trainingData); ?>' />
						<?php
						foreach ($this->trainingData AS $td)
						{
							$hours=($td->time_start / 3600); $hours=(int)$hours;
							$mins=(($td->time_start - (3600*$hours)) / 60); $mins=(int)$mins;
							$startTime=sprintf('%02d',$hours).':'.sprintf('%02d',$mins);
							$hours=($td->time_end / 3600); $hours=(int)$hours;
							$mins=(($td->time_end - (3600*$hours)) / 60); $mins=(int)$mins;
							$endTime=sprintf('%02d',$hours).':'.sprintf('%02d',$mins);
							?>
							<tr>
						
								<td style='text-align:center;' nowrap='nowrap' width='5%'><?php echo $this->lists['dayOfWeek'][$td->dayofweek]; ?></td>
								<td style='text-align:center;' nowrap='nowrap' width='5%'>
								<?php echo $startTime; ?>
									
								</td>
								<td style='text-align:center;' nowrap='nowrap' width='5%'>
								<?php echo $endTime; ?>

								</td>
								<td style='text-align:center;'>
								<?php echo $td->place; ?>

								</td>
								<td style='text-align:center;'>
								<?php echo $td->notes; ?>

								</td>
							</tr>
							<?php
						}
					}
					?>
				</table>
			</fieldset>