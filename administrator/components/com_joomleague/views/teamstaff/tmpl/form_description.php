<?php defined('_JEXEC') or die('Restricted access');
?>		
		<fieldset class="adminform">
			<legend>
				<?php
				echo JText::sprintf('JL_ADMIN_TEAMSTAFF_DESCR_TITLE',
				  JoomleagueHelper::formatName(null, $this->project_teamstaff->firstname, $this->project_teamstaff->nickname, $this->project_teamstaff->lastname, 0))

				?>
			</legend>
			<table class="admintable">
				<tr>
					<td>
						<?php
						$editor =& JFactory::getEditor();
						$this->assignRef( 'editor', $editor );
						// parameters : areaname, content, hidden field, width, height, rows, cols
						echo $this->editor->display( 'notes', $this->project_teamstaff->notes, '100%', '400', '70', '15' );
					?>
					</td>
				</tr>
			</table>
		</fieldset>