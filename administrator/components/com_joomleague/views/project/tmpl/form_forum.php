<?php 
defined('_JEXEC') or die('Restricted access');
?>
<fieldset class="adminform">
			<legend><?php echo JText::_('Project Forum Parameters'); ?></legend>
			<table class="admintable">

				<tr>
					<td align="right" class="key"><?php echo JText::_('Enable Forum'); ?></td>
					<td>
						<?php echo $this->lists['forumLocked']; ?>
					</td>
				</tr>
				
        <tr>
					<td align="right" class="key"><?php echo JText::_('Forum Categories'); ?></td>
					<td>
						<?php echo $this->forumcategories; ?>
					</td>
				</tr>
				
			</table>
		</fieldset>