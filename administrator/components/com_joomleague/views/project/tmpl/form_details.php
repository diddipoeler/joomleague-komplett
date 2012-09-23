<?php defined('_JEXEC')or die('Restricted access');
?>
		<fieldset class="adminform">
			<legend><?php echo JText::sprintf('JL_ADMIN_PROJECT_LEGEND_DETAILS','<i>'.$this->project->name.'</i>'); ?></legend>
			<table class="admintable">
				<tr>
					<td width="100" align="right" class="key">
						<label for="name"><?php echo JText::_('JL_ADMIN_PROJECT_NAME'); ?></label>
					</td>
					<td>
						<input	class="text_area required" type="text" name="name" id="title" size="68"<?php echo ((($this->project->id < 1) || (strlen($this->project->name) < 0)) ? ' style="background-color:#FFCCCC;"' : ''); ?> maxlength="100"
								value="<?php if ($this->copy){echo JText::_('JL_ADMIN_PROJECT_COPY_OF').' ';} echo $this->project->name; ?>" />
					</td>
				</tr>
				<tr>
					<td width="100" align="right" class="key"><label for="alias"><?php echo JText::_('JL_ADMIN_PROJECT_ALIAS'); ?></label></td>
					<td>
						<input class="text_area" type="text" name="alias" id="alias" size="68" maxlength="100"	value="<?php echo $this->project->alias; ?>" />
					</td>
				</tr>
				<tr>
					<td valign="top" align="right" class="key"><?php echo JText::_('JL_ADMIN_PROJECT_PUBLISHED'); ?></td>
					<td><?php echo $this->lists['published']; ?></td>
				</tr>
				<tr>
					<td valign="top" align="right" class="key"><?php echo JText::_('JL_ADMIN_PROJECT_ORDERING'); ?></td>
					<td><?php echo $this->lists['ordering']; ?></td>
				</tr>
				<tr>
					<td valign="top" align="right" class="key"><?php echo JText::_('JL_ADMIN_PROJECT_SPORTSTYPE'); ?></td>
					<td><?php echo $this->lists['sports_type']; ?></td>
				</tr>
				<tr>
					<td valign="top" align="right" class="key"><?php echo JText::_('JL_ADMIN_PROJECT_LEAGUE'); ?></td>
					<td>
						<?php
						echo $this->lists['leagues'];
						if (!$this->edit)
						{
							echo "<br />";
							echo '<input type="checkbox" name="newLeagueCheck" value="1"';
								echo ' onclick="if(this.checked){document.adminForm.league_id.disabled=true;';
								echo 'document.adminForm.leagueNew.disabled=false;';
								echo 'document.adminForm.leagueNew.value='.''.'document.adminForm.name.value} ';
								echo 'else {document.adminForm.league_id.disabled=false;document.adminForm.leagueNew.disabled=true}" />';
								echo JText::_('JL_ADMIN_PROJECT_LEAGUE_NEW').'&nbsp;';
								echo '<input type="text" name="leagueNew" id="leagueNew" size="16" disabled />';
						}
						?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="right" class="key"><?php echo JText::_('JL_ADMIN_PROJECT_SEASON'); ?></td>
					<td>
						<?php
						echo $this->lists['seasons'];
						if (!$this->edit)
						{
							 echo '<br />';
							 echo '<input type="checkbox" name="newSeasonCheck" value="1"';
							 echo ' onclick="if(this.checked){document.adminForm.season_id.disabled=true;';
							 echo 'document.adminForm.seasonNew.disabled=false} ';
							 echo ' else {document.adminForm.season_id.disabled=false;';
							 echo 'document.adminForm.seasonNew.disabled=true}" />';
							 echo JText::_('JL_ADMIN_PROJECT_SEASON_NEW'). "&nbsp;";
							 echo '<input type="text" name="seasonNew" id="seasonNew" disabled />';
						}
						?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="right" class="key"><?php echo JText::_('JL_ADMIN_PROJECT_PROJECTTYPE'); ?></td>
					<td><?php echo $this->lists['project_type']; ?></td>
				</tr>
				<tr>
					<td valign="top" align="right" class="key"><?php echo JText::_('JL_ADMIN_PROJECT_ADMIN'); ?></td>
					<td><?php echo $this->lists['admin']; ?></td>
				</tr>
				<tr>
					<td valign="top" align="right" class="key"><?php echo JText::_('JL_ADMIN_PROJECT_EDITOR'); ?></td>
					<td><?php echo $this->lists['editor']; ?></td>
				</tr>
				<tr>
					<td valign="top" align="right" class="key"><?php echo JText::_('JL_ADMIN_PROJECT_TEMPLATES'); ?></td>
					<td><?php echo $this->lists['masters']; ?></td>
				</tr>
	 			<tr>
					<td valign="top" align="right" class="key"><?php echo JText::_('JL_ADMIN_PROJECT_EXTENSION'); ?></td>
					<td><?php echo $this->lists['extensions']; ?></td>
				</tr>
			</table>
		</fieldset>