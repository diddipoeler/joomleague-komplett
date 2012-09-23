<?php defined('_JEXEC') or die('Restricted access');
?>
<fieldset class="adminform">
	<legend><?php echo JText::_('JL_ADMIN_POSITION_STATISTICS_LEGEND'); ?></legend>
	<table class="admintable">
		<tr>
			<td><b><?php echo JText::_('JL_ADMIN_POSITION_EXISTING_STATISTICS'); ?></b><br /><?php echo $this->lists['statistic']; ?></td>
			<td>
				<input  type="button" class="inputbox"
						onclick="document.getElementById('statschanges_check').value=1;move($('statistic'),document.getElementById('position_statistic'));selectAll(document.getElementById('position_statistic'));"
						value="&gt;&gt;" />
				<br /><br />
				<input  type="button" class="inputbox"
						onclick="document.getElementById('statschanges_check').value=1;move(document.getElementById('position_statistic'),document.getElementById('statistic'));selectAll(document.getElementById('position_statistic'));"
						value="&lt;&lt;" />
			</td>
			<td><b><?php echo JText::_('JL_ADMIN_POSITION_ASSIGNED_STATS_TO_POS'); ?></b><br /><?php echo $this->lists['position_statistic']; ?></td>
			<td align='center'>
				<input  type="button" class="inputbox"
						onclick="$('statschanges_check').value=1;moveOptionUp('position_statistic');"
						value="<?php echo JText::_('JL_GLOBAL_UP'); ?>" />
				<br /><br />
				<input type="button" class="inputbox"
					   onclick="$('statschanges_check').value=1;moveOptionDown('position_statistic');"
					   value="<?php echo JText::_('JL_GLOBAL_DOWN'); ?>" />
			</td>
			<td>
			<fieldset class="adminform">
					<?php echo JText::_('JL_ADMIN_POSITION_STATS_HINT'); ?>
			</fieldset>
			</td>			
		</tr>
	</table>
</fieldset>