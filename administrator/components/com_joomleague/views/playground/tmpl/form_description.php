<?php defined('_JEXEC') or die('Restricted access');
?>
	<fieldset class="adminform">
		<legend><?php echo JText::_('JL_ADMIN_PLAYGROUND_DESCRIPTION_LEGEND'); ?></legend>
		<table class="admintable">
			<tr>
				<td width="100" align="right" class="key"><label for="info"><?php echo JText::_('JL_ADMIN_PLAYGROUND_DESCRIPTION'); ?></label></td>
				<td><?php
					$editor =& JFactory::getEditor();
					// parameters : areaname,content,hidden field,width,height,rows,cols
					echo $editor->display('notes',$this->venue->notes,'600','400','70','15');
					?></td>
			</tr>
		</table>
	</fieldset>