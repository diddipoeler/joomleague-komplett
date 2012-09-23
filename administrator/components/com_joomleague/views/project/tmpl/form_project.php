<?php defined('_JEXEC') or die('Restricted access');
?>
		<fieldset class="adminform">
			<legend><?php echo JText::_('JL_ADMIN_PROJECT_PR_PARAMS'); ?></legend>
			<table class="admintable">
				<tr>
					<td valign="top" align="right" class="key"><?php echo JText::_('JL_ADMIN_PROJECT_AUTO_CURRENT_MD'); ?></td>
					<td><?php echo $this->lists['current_round_auto']; ?></td>
				</tr>
				<tr>
					<td align="right" class="key"><?php echo JText::_('JL_ADMIN_PROJECT_CURRENT_MD'); ?></td>
					<td>
						<!-- input class="text_area" type="text" name="current_round" id="current_round" size="2" maxlength="6" value="<?php echo $this->project->current_round; ?>" /-->
						<?php echo $this->lists['rounds']; ?>
					</td>
				</tr>
				<tr>
					<td align="right" class="key"><?php echo JText::_('JL_ADMIN_PROJECT_CHANGE_CURRENT_MD'); ?></td>
					<td>
						<input class="text_area" type="text" name="auto_time" id="title" size="8" maxlength="8" value="<?php echo $this->project->auto_time; ?>" />
					</td>
				</tr>
			</table>
		</fieldset>