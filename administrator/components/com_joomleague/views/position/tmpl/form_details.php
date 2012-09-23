<?php defined('_JEXEC') or die('Restricted access');
?>
		<fieldset class="adminform">
			<legend><?php echo JText::_('JL_ADMIN_POSITION_DETAILS_LEGEND'); ?></legend>
			<table class="admintable">
				<tr>
					<td width="100" align="right" class="key"><label for="name"><?php echo JText::_('JL_ADMIN_POSITION_NAME'); ?></label>
					</td>
					<td>
						<input class="text_area" type="text" name="name" id="title" size="32" maxlength="250" value="<?php echo $this->position->name; ?>" />
						&nbsp;<?php echo JText::sprintf('JL_GLOBAL_TRANSLATION_IS','<b>'.JText::_($this->position->name).'</b>'); ?>
					</td>
				</tr>
				<tr>
					<td width="100" align="right" class="key"><label for="alias"><?php echo JText::_('JL_ADMIN_POSITION_ALIAS'); ?></label></td>
					<td>
						<input class="text_area" type="text" name="alias" id="alias" size="32" maxlength="75" value="<?php echo $this->position->alias; ?>" />
					</td>
				</tr>
				<tr>
					<td width="100" align="right" class="key"><label for="name"><?php echo JText::_('JL_ADMIN_POSITION_SPORTS_TYPE'); ?></label></td>
					<td><?php echo $this->lists['sports_type']; ?></td>
				</tr>
				<tr>
					<td width="100" align="right" class="key"><label for="name"><?php echo JText::_('JL_ADMIN_POSITION_PERSON_TYPE'); ?></label></td>
					<td><?php echo $this->lists['person_type']; ?></td>
				</tr>
				<tr>
					<td valign="top" align="right" class="key"><?php echo JText::_('JL_ADMIN_POSITION_P_POSITION'); ?></td>
					<td><?php echo $this->lists['parents']; ?></td>
				</tr>
			</table>
		</fieldset>