<?php defined('_JEXEC') or die('Restricted access');
?>	
	
			<fieldset class="adminform">
				<legend>
					<?php echo JText::sprintf(	'JL_ADMIN_PROJECT_TITLE_DESCR',
												'<i>' . $this->project->name . '</i>'); ?>
				</legend>
				<table class="admintable" border="0">
					
					<tr>
						<td valign="top" align="right" class="key">
							<label for="description">
								<?php echo JText::_('JL_ADMIN_PROJECT_DESCRIPTION'); ?>:
							</label>
						</td>
						<td>
							<?php
							$editor =& JFactory::getEditor();
							$this->assignRef('editor', $editor);
							// parameters : areaname, content, hidden field, width, height, rows, cols
							echo $this->editor->display('notes',$this->project->notes,'600','400','70','15');
							?>
						</td>
					</tr>

				</table>
			</fieldset>
