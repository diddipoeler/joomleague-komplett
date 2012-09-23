<?php defined('_JEXEC') or die('Restricted access');
?>
<fieldset class="adminform">
	<legend><?php echo JText::_('JL_ADMIN_SEASON_LEGEND'); ?></legend>
	<table class="admintable">
		<tr>
			<td width="100" align="right" class="key"><label for="name"><?php echo JText::_('JL_ADMIN_SEASON_NAME'); ?></label></td>
			<td>
				<input class="text_area" type="text" name="name" id="title" size="32" maxlength="250" value="<?php echo $this->season->name; ?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key"><label for="alias"><?php	echo JText::_('JL_ADMIN_SEASON_ALIAS');	?></label></td>
			<td>
				<input class="text_area" type="text" name="alias" id="alias" size="32" maxlength="75" value="<?php echo $this->season->alias; ?>" />
			</td>
		</tr>
		<tr>
			<td valign="top" align="right" class="key"><label for="ordering"><?php echo JText::_('JL_ADMIN_SEASON_ORDERING'); ?></label></td>
			<td><?php echo $this->lists['ordering']; ?></td>
		</tr>
	</table>
</fieldset>