<?php defined('_JEXEC') or die('Restricted access');
?>
		<fieldset class="adminform">
			<legend><?php echo JText::_('JL_ADMIN_PROJECT_COMP_PARAMS'); ?></legend>
				<table class="admintable">
					<tr>
						<td width="100" align="right" class="key"><?php echo JText::_('JL_ADMIN_PROJECT_REGULAR_PLAY_TIME'); ?></td>
						<td>
							<input class="text_area" type="text" name="game_regular_time" id="title" size="4" maxlength="6" value="<?php echo $this->project->game_regular_time; ?>" />
						</td>
					</tr>
					<tr>
						<td width="100" align="right" class="key"><?php echo JText::_('JL_ADMIN_PROJECT_NR_PLAY_PERIODS'); ?></td>
						<td>
							<input class="text_area" type="text" name="game_parts" id="title" size="4" maxlength="6" value="<?php echo $this->project->game_parts; ?>" />
						</td>
					</tr>
					<tr>
						<td width="100" align="right" class="key"><?php echo JText::_('JL_ADMIN_PROJECT_LENGTH_BREAK'); ?></td>
						<td>
							<input class="text_area" type="text" name="halftime" id="title" size="4" maxlength="6" value="<?php echo $this->project->halftime; ?>" />
						</td>
					</tr>
					<tr>
						<td width="100" align="right" class="key"><?php echo JText::_('JL_ADMIN_PROJECT_REGULAR_POINTS'); ?></td>
						<td>
							<input class="text_area" type="text" name="points_after_regular_time" id="title" size="8" maxlength="10" value="<?php echo $this->project->points_after_regular_time; ?>" />
						</td>
					</tr>
					<tr>
						<td valign="top" align="right" class="key"><?php echo JText::_('JL_ADMIN_PROJECT_USE_SETS'); ?></td>
						<td><?php echo $this->lists['use_legs']; ?></td>
					</tr>
					<tr>
						<td valign="top" align="right" class="key"><?php echo JText::_('JL_ADMIN_PROJECT_OT_OR_PENALTY'); ?></td>
						<td><?php echo $this->lists['allow_add_time']; ?></td>
					</tr>
					<tr>
						<td width="100" align="right" class="key"><?php echo JText::_('JL_ADMIN_PROJECT_LENGTH_EXTRA_TIME'); ?></td>
						<td>
							<input class="text_area" type="text" name="add_time" id="title" size="4" maxlength="6" value="<?php echo $this->project->add_time; ?>" />
						</td>
					</tr>
					<tr>
						<td width="100" align="right" class="key"><?php echo JText::_('JL_ADMIN_PROJECT_POINTS_AFTER_EXTRA_TIME'); ?></td>
						<td>
							<input class="text_area" type="text" name="points_after_add_time" id="title" size="8" maxlength="10" value="<?php echo $this->project->points_after_add_time; ?>" />
						</td>
					</tr>
					<tr>
						<td width="100" align="right" class="key"><?php echo JText::_('JL_ADMIN_PROJECT_POINTS_AFTER_PENALTY'); ?></td>
						<td>
							<input class="text_area" type="text" name="points_after_penalty" id="title" size="8" maxlength="10" value="<?php echo $this->project->points_after_penalty; ?>" />
						</td>
					</tr>
					<?php /*
					?>
					<tr>
						<td valign="top" align="right" class="key"><?php echo JText::_('Use teams as referees'); ?></td>
						<td><?php echo $this->lists['teams_as_referees']; ?></td>
					</tr>
					<?php */
					?>
				</table>
		</fieldset>