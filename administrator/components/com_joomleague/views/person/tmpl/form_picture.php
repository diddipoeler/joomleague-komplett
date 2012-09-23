<?php defined('_JEXEC') or die('Restricted access');
?>
		<fieldset class="adminform">
			<legend>
				<?php
				$text = (!$this->edit) ? JText::_('JL_ADMIN_PERSON_EDIT_PICTURE') : JText::sprintf('JL_ADMIN_PERSON_EDIT_PICTURE_S',
				  JoomleagueHelper::formatName(null, $this->person->firstname, $this->person->nickname, $this->person->lastname, 0));
				echo $text;
				?>
			</legend>
			<table class="admintable">
				<tr>
					<td width="250" class="key" style="text-align:center; ">
						<label for="image">
							<span class="hasTip" title='<?php echo JText::_('JL_ADMIN_PERSON_PICTURE'); ?>::<?php echo JText::_('JL_ADMIN_PERSON_PICTURE_DESC'); ?>'><?php echo JText::_('JL_ADMIN_PERSON_PICTURE'); ?></span>
						</label>
					</td>
					<td rowspan="10" style="text-align:center; ">
						<img	class="imagepreview" src="../media/com_joomleague/jl_images/spinner.gif" name="picture_preview"
								id="picture_preview" border="3" alt="Preview" title="Preview" /><br />
						<?php
							echo $this->imageselect;
						?>
					</td>
				</tr>
			</table>
		</fieldset>