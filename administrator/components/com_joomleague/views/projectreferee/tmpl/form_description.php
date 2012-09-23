<?php defined('_JEXEC') or die('Restricted access');
?>		

		<fieldset class="adminform">
			<legend>
				<?php
				echo JText::sprintf(	'JL_ADMIN_P_REF_DESCR_TITLE',
				  JoomleagueHelper::formatName(null, $this->projectreferee->firstname, $this->projectreferee->nickname, $this->projectreferee->lastname, 0));
				?>
			</legend>
			<table class="admintable">
				<tr>
					<td>
						<?php
						$editor =& JFactory::getEditor();
						$this->assignRef('editor',$editor);
						// parameters : areaname,content,hidden field,width,height,rows,cols
						echo $this->editor->display('notes',$this->projectreferee->notes,'100%','400','70','15');
					?>
					</td>
				</tr>
			</table>
		</fieldset>