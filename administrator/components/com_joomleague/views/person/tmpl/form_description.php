<?php defined('_JEXEC') or die('Restricted access');
?>
		<fieldset class="adminform">
			<legend>
				<?php
				$text = (!$this->edit) ? JText::_('JL_ADMIN_PERSON_EDIT_description') : JText::sprintf('JL_ADMIN_PERSON_EDIT_description_S',
				  JoomleagueHelper::formatName(null, $this->person->firstname, $this->person->nickname, $this->person->lastname, 0));
				echo $text;
				?>
			</legend>
			<table class="admintable" border="0">
				<tr>
					<td class="key" style="text-align:left; ">
						<?php
						$editor =& JFactory::getEditor();
						$this->assignRef('editor', $editor);
						// parameters : areaname, content, hidden field, width, height, rows, cols
						echo $this->editor->display('notes',$this->person->notes,'100%', '400', '70', '15');
					?>
					</td>
				</tr>
			</table>
		</fieldset>