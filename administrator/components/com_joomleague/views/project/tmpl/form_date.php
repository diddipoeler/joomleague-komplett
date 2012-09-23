<?php defined('_JEXEC') or die('Restricted access');
$imageTitle=JText::_('JL_ADMIN_PROJECT_INPUT_NEEDED');
$imagePath='administrator/components/com_joomleague/assets/images/crystal_xedit_small.png';
$inputNeededImage='&nbsp;&nbsp;'.JHTML::image($imagePath,$imageTitle,array('title' => $imageTitle));
?>
		<fieldset class="adminform">
			<legend><?php echo JText::_('JL_ADMIN_PROJECT_DATE_PARAMS'); ?></legend>
			<table class="admintable">
				<tr>
					<td width="100" align="right" class="key"><?php echo JText::_('JL_ADMIN_PROJECT_STARTDATE'); ?></td>
					<td><?php
						$date=JFactory::getDate($this->project->start_date)->toFormat('%d-%m-%Y');
						echo JHTML::calendar($date,'start_date','start_date','%d-%m-%Y','size="10" ');
						?></td>
				</tr>
				<tr>
					<td valign="top" align="right" class="key"><?php echo JText::_('JL_ADMIN_PROJECT_STARTTIME'); ?></td>
					<td>
						<input class="text_area" type="text" name="start_time" id="title" size="4" maxlength="5" value="<?php echo $this->project->start_time; ?>" />
					</td>
				</tr>
				<tr>
					<td valign="top" align="right" class="key"><?php echo JText::_('JL_ADMIN_SERVER_TIMEZONE'); ?></td>
					<td>
						<?php echo $this->lists['servertimezone']; ?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="right" class="key"><?php echo JText::_('JL_ADMIN_JOOMLEAGUE_TIMEZONE'); ?></td>
					<td>
						<?php echo $this->lists['joomleaguetimezone']; ?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="right" class="key"><?php echo JText::_('JL_ADMIN_PROJECT_TIMEZONE'); ?></td>
					<td>
						<?php echo $this->lists['projecttimezone']; ?>
					</td>
				</tr>	
			</table>
		</fieldset>