<?php defined('_JEXEC') or die('Restricted access');
?>
<fieldset class="adminform">	
	<legend><?php echo JText::_('JL_ADMIN_POSITION_EVENTS_LEGEND'); ?></legend>
	<table class="admintable">
		<tr>
			<td><b><?php echo JText::_('JL_ADMIN_POSITION_EXISTING_EVENTS'); ?></b><br /><?php echo $this->lists['events']; ?></td>
			<td>
				<input  type="button" class="inputbox"
						onclick="document.getElementById('eventschanges_check').value=1;move(document.getElementById('eventslist'),document.getElementById('position_eventslist'));selectAll(document.getElementById('position_eventslist'));"
						value="&gt;&gt;" />
				<br /><br />
				<input  type="button" class="inputbox"
						onclick="document.getElementById('eventschanges_check').value=1;move(document.getElementById('position_eventslist'),document.getElementById('eventslist'));selectAll(document.getElementById('position_eventslist'));"
						value="&lt;&lt;" />
			</td>
			<td><b><?php echo JText::_('JL_ADMIN_POSITION_ASSIGNED_EVENTS_TO_POS'); ?></b><br /><?php echo $this->lists['position_events']; ?></td>
			<td align='center'>
				<input  type="button" class="inputbox"
						onclick="document.getElementById('eventschanges_check').value=1;moveOptionUp('position_eventslist');"
						value="<?php echo JText::_('JL_GLOBAL_UP'); ?>" />
				<br /><br />
				<input type="button" class="inputbox"
					   onclick="document.getElementById('eventschanges_check').value=1;moveOptionDown('position_eventslist');"
					   value="<?php echo JText::_('JL_GLOBAL_DOWN'); ?>" />
			</td>
			<td>
			<fieldset class="adminform">
					<?php echo JText::_('JL_ADMIN_POSITION_EVENTS_HINT'); ?>
			</fieldset>
			</td>
		</tr>
	</table>
</fieldset>
