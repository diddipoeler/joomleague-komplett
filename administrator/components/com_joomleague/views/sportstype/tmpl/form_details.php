<?php defined('_JEXEC') or die('Restricted access');
?>
<fieldset class="adminform">
	<legend><?php echo JText::_('JL_ADMIN_SPORTTYPE_LEGEND'); ?></legend>
	<table class="admintable">
		<tr>
			<td width="100" align="right" class="key"><label for="name"><?php echo JText::_('JL_ADMIN_SPORTTYPE_NAME'); ?></label></td>
			<td>
				<input class="text_area" type="text" name="name" id="title" size="32" maxlength="250" value="<?php echo $this->sportstype->name; ?>" />
				&nbsp;<?php echo JText::sprintf('JL_GLOBAL_TRANSLATION_IS','<b>'.JText::_($this->sportstype->name).'</b>'); ?>
			</td>
		</tr>
		<tr>
			<td valign="top" align="right" class="key"><label for="ordering"><?php echo JText::_('JL_ADMIN_SPORTTYPE_ORDERING'); ?></label></td>
			<td><?php echo $this->lists['ordering']; ?></td>
		</tr>
	</table>
</fieldset>