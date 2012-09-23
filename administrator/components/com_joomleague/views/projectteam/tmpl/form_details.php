<?php defined('_JEXEC') or die('Restricted access');
?>		

		<fieldset class="adminform">
			<legend>
				<?php
				echo JText::sprintf(	'JL_ADMIN_P_TEAM_TITLE_DETAILS',
										'<i>' . $this->project_team->name . '</i>',
										'<i>' . $this->projectws->name . '</i>');
				?>
			</legend>

			<fieldset class="adminform">
				<table class="admintable" border="0">
					<tr>
						<td nowrap="nowrap" class="key" style="text-align:right; ">
							<?php echo JText::_('JL_ADMIN_P_TEAM_ADMIN'); ?>
						</td>
						<td>
							<?php echo $this->lists['admin']; ?>
						</td>
						<?php
						if ($this->projectws->project_type != 'DIVISIONS_LEAGUE') // No divisions
						{
							$colspan = ' colspan="3"';
						}
						else
						{
							$colspan = '';
						}
						?>
						<td width="5%" <?php echo $colspan; ?>>&nbsp;</td>
						<?php
						if ($this->projectws->project_type == 'DIVISIONS_LEAGUE') // Has divisions
						{
							?>
							<td nowrap="nowrap" class="key" style="text-align:right; ">
								<?php
								echo JText::_('JL_ADMIN_P_TEAM_DIV');
								?>
							</td>
							<td>
								<?php 
								$inputappend='';
								if ($this->project_team->division_id == 0)
								{
									$inputappend=' style="background-color:#bbffff"';
								}
								echo JHTML::_(	'select.genericlist',
								$this->lists['divisions'],
								'division_id',
								$inputappend.'class="inputbox" size="1"',
								'value','text', $this->project_team->division_id);
								?>
							</td>
							<?php
						}
						?>
					</tr>
					<tr>
						<td nowrap="nowrap" class="key" style="text-align:right; ">
							<?php echo JText::_('JL_ADMIN_P_TEAM_VENUE'); ?>
						</td>
						<td >
							<?php echo $this->lists['playgrounds']; ?>
						</td>
						<td width="5%">&nbsp;
						</td>
					</tr>
					
					<tr>						
						<td nowrap="nowrap" class="key" style="text-align:right; ">
							<?php echo JText::_('JL_ADMIN_P_TEAM_INSCORE'); ?>
						</td>					
						<td>
							<?php echo $this->lists['is_in_score']; ?>
						</td>
					</tr>
					          					
				</table>
			</fieldset>

			<fieldset class="adminform">
				<table class="admintable" border="0">
					<tr>
						<td nowrap="nowrap" class="key" style="text-align:right; ">
							<?php echo JText::_('JL_ADMIN_P_TEAM_INIT_POINTS'); ?>
						</td>
						<td>
							<input	class="text_area" type="text" name="start_points" id="title" size="5" maxlength="5"
									value="<?php echo $this->project_team->start_points;?>" />
						</td>
						<td nowrap="nowrap" class="key" style="text-align:right; ">
							<?php echo JText::_('JL_ADMIN_P_TEAM_REASON_INIT_POINTS'); ?>
						</td>
						<td colspan="3">
							<input	class="text_area" type="text" name="reason" id="title" size="60" maxlength="100"
									value="<?php echo $this->project_team->reason; ?>" />
						</td>
					</tr>
          					
				</table>
			</fieldset>			
			<fieldset class="adminform">
				<table class="admintable" border="0">

					<tr>
					<tr>
						<td nowrap="nowrap" class="key" style="text-align:right; ">
							<?php echo JText::_('JL_ADMIN_P_TEAM_USE_FINALLY'); ?>
						</td>
						<td>
							<?php echo $this->lists['use_finally']; ?>
						</td>
					</tr>
						<td nowrap="nowrap" class="key" style="text-align:right; ">
							<?php echo JText::_('JL_ADMIN_P_TEAM_TOT_MATCH'); ?>
						</td>
						<td>
							<input	class="text_area" type="text" name="matches_finally" id="title" size="5" maxlength="5"
									value="<?php echo $this->project_team->matches_finally; ?>" />
						</td>					
						<td nowrap="nowrap" class="key" style="text-align:right; ">
							<?php echo JText::_('JL_ADMIN_P_TEAM_TOT_POINTS'); ?>
						</td>
						<td>
							<input	class="text_area" type="text" name="points_finally" id="title" size="5" maxlength="5"
									value="<?php echo $this->project_team->points_finally; ?>" />
						</td>
						<td nowrap="nowrap" class="key" style="text-align:right; ">
							<?php echo JText::_('JL_ADMIN_P_TEAM_TOT_NEG_POINTS'); ?>
						</td>
						<td>
							<input	class="text_area" type="text" name="neg_points_finally" id="title" size="5" maxlength="5"
									value="<?php echo $this->project_team->neg_points_finally; ?>" />
						</td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="key" style="text-align:right; ">
							<?php echo JText::_('JL_ADMIN_P_TEAM_WON'); ?>
						</td>
						<td>
							<input	class="text_area" type="text" name="won_finally" id="title" size="5" maxlength="5"
									value="<?php echo $this->project_team->won_finally; ?>" />
						</td>
						<td nowrap="nowrap" class="key" style="text-align:right; ">
							<?php echo JText::_('JL_ADMIN_P_TEAM_DRAW'); ?>
						</td>
						<td>
							<input	class="text_area" type="text" name="draws_finally" id="title" size="5" maxlength="5"
									value="<?php echo $this->project_team->draws_finally; ?>" />
						</td>
						<td nowrap="nowrap" class="key" style="text-align:right; ">
							<?php echo JText::_('JL_ADMIN_P_TEAM_LOST'); ?>
						</td>
						<td>
							<input	class="text_area" type="text" name="lost_finally" id="title" size="5" maxlength="5"
									value="<?php echo $this->project_team->lost_finally; ?>" />
						</td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="key" style="text-align:right; ">
							<?php echo JText::_('JL_ADMIN_P_TEAM_TOT_HG'); ?>
						</td>
						<td>
							<input	class="text_area" type="text" name="homegoals_finally" id="title" size="5" maxlength="5"
									value="<?php echo $this->project_team->homegoals_finally; ?>" />
						</td>
						<td nowrap="nowrap" class="key" style="text-align:right; ">
							<?php echo JText::_('JL_ADMIN_P_TEAM_TOT_GG'); ?>
						</td>
						<td>
							<input	class="text_area" type="text" name="guestgoals_finally" id="title" size="5" maxlength="5"
									value="<?php echo $this->project_team->guestgoals_finally; ?>" />
						</td>
						<td nowrap="nowrap" class="key" style="text-align:right; ">
							<?php echo JText::_('JL_ADMIN_P_TEAM_TOT_DG'); ?>
						</td>
						<td>
							<input	class="text_area" type="text" name="diffgoals_finally" id="title" size="5" maxlength="5"
									value="<?php echo $this->project_team->diffgoals_finally; ?>" />
						</td>
					</tr>
				</table>
			</fieldset>
		</fieldset>