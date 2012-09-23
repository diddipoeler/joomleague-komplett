<?php defined('_JEXEC') or die('Restricted access');
?>
		<fieldset class="adminform">
			<legend>
				<?php
				echo JText::sprintf(	'JL_ADMIN_ROUND_TITLE2',
										'<i>' . $this->projectws->name . '</i>',
										'<i>' . $this->matchday->name . '</i>');
				?>
			</legend>

			<table class="admintable">
				<tr>
					<td valign="top" align="right" class="key">
						<label for="roundcode">
							<?php
							echo JText::_('JL_ADMIN_ROUND_NR');
							?>
						</label>
					</td>
					<td>
						<input	class="text_area" type="text" name="roundcode" size="2" maxlength="2"
								value="<?php echo $this->matchday->roundcode; ?>" />
					</td>
				</tr>
				<tr>
					<td width="100" align="right" class="key">
						<label for="name">
							<?php
							echo JText::_('JL_ADMIN_ROUND_NAME');
							?>
						</label>
					</td>
					<td>
						<input	class="text_area" type="text" name="name" id="title" size="32" maxlength="250"
								value="<?php echo $this->matchday->name; ?>" />
					</td>
				</tr>
				
				<tr>
					<td width="100" align="right" class="key">
						<label for="alias">
							<?php	echo JText::_('JL_ADMIN_ROUND_ALIAS');	?>
						</label>
					</td>
					<td>
						<input class="text_area" type="text" name="alias" id="alias" size="32" maxlength="75"	value="<?php echo $this->matchday->alias; ?>" />
					</td>
				</tr>
				
				<tr>
					<td width="100" align="right" class="key">
						<label for="round_date_first">
							<?php
							echo JText::_('JL_ADMIN_ROUND_START');
							?>
						</label>
					</td>
					<td>
						<?php
						echo JHTML::calendar(	JoomleagueHelper::convertDate($this->matchday->round_date_first),
												'round_date_first', 'round_date_first', '%d-%m-%Y');
						?>
					</td>
				</tr>
				<tr>
					<td width="100" align="right" class="key">
						<label for="round_date_last">
							<?php
							echo JText::_('JL_ADMIN_ROUND_END');
							?>
						</label>
					</td>
					<td>
						<?php
						echo JHTML::calendar(	JoomleagueHelper::convertDate($this->matchday->round_date_last),
												'round_date_last', 'round_date_last', '%d-%m-%Y');
						?>
					</td>
				</tr>
			</table>
		</fieldset>