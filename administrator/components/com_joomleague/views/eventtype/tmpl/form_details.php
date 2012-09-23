<?php defined('_JEXEC') or die('Restricted access');
?>

<fieldset class="adminform">
			<legend><?php echo JText::_('JL_EVENTFORM_LEGEND'); ?></legend>
			<table class="admintable">
				<tr>
					<td width="100" align="right" class="key"><label for="name"><?php echo JText::_('JL_GLOBAL_SPORTS_TYPE'); ?></label></td>
					<td><?php echo $this->lists['sports_type']; ?></td>
				</tr>
				<tr>
					<td width="250" align="right" class="key"><label for="name"><?php echo JText::_('JL_GLOBAL_NAME'); ?></label></td>
					<td>
						<input	class="text_area" type="text" name="name" id="title" size="32" maxlength="250"
								value="<?php echo $this->event->name; ?>" />
						&nbsp;<?php echo JText::sprintf('JL_GLOBAL_TRANSLATION_IS','<b>'.JText::_($this->event->name).'</b>'); ?>
					</td>
				</tr>
				<tr>
					<td width="100" align="right" class="key"><label for="alias"><?php echo JText::_('JL_GLOBAL_ALIAS'); ?></label></td>
					<td>
						<input	class="text_area" type="text" name="alias" id="alias" size="32" maxlength="75"
								value="<?php echo $this->event->alias; ?>" />
					</td>
				</tr>
				<tr>
					<td valign="top" align="right" class="key"><label for="ordering"><?php echo JText::_('JL_GLOBAL_SORTING'); ?></label></td>
					<td><?php echo $this->lists['ordering']; ?></td>
				</tr>
				<tr>
					<td valign="top" align="right" class="key">
						<label for="ordering">
							<?php
							echo JText::_('JL_EVENTTYPE_NOTE');
							?>
						</label>
					</td>
					<td>
						<?php
						echo $this->lists['splitt'];
						?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="right" class="key">
						<label for="ordering">
							<?php
							echo JText::_('JL_EVENTTYPE_SORTING');
							?>
						</label>
					</td>
					<td>
						<?php
						echo $this->lists['directions'];
						?>
					</td>
				</tr>
				<tr>
			  		<td valign="top" align="right" class="key">
			   			<label for="ordering">
							<?php
							echo JText::_('JL_EVENTTYPE_PAIR_EVENT');
							?>
						</label>
					</td>
					<td>
						<?php
						echo $this->lists['double'];
						?>
					</td>
				</tr>
			</table>
		</fieldset>