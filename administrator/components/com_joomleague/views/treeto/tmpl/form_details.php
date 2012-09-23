<?php defined('_JEXEC') or die('Restricted access');
?>
	<fieldset class="adminform">
		<legend>
			<?php
			echo JText::sprintf(	'JL_ADMIN_TREETO_TITLE2',
			'<i>' . $this->projectws->name . '</i>');
			?>
		</legend>

		<table class="admintable">
			<tr>
				<td width="100" align="right" class="key">
					<label for="name">
						<?php
						echo JText::_('JL_ADMIN_TREETO_NAME');
						?>
					</label>
				</td>
				<td>
					<input	class="text_area" type="text" name="name" id="title" size="32" maxlength="250"
						value="<?php echo $this->treeto->name; ?>" />
				</td>
			</tr>
			<tr>
				<td width="100" align="right" class="key">
					<label for="hide">
						<?php	echo JText::_('JL_ADMIN_TREETO_HIDE');	?>
					</label>
				</td>
				<td>
					<input class="text_area" type="text" name="hide" id="hide" size="3" maxlength="3"
					value="<?php echo $this->treeto->hide; ?>" />
				</td>
			</tr>
		</table>
	</fieldset>