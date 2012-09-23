<?php defined('_JEXEC') or die('Restricted access');
?>		
		<fieldset class="adminform">
			<legend>
				<?php
				echo JText::sprintf('JL_ADMIN_TEAMPLAYER_DESCR_TITLE',
				  JoomleagueHelper::formatName(null, $this->project_player->firstname, $this->project_player->nickname, $this->project_player->lastname, 0));
				?>
			</legend>
			<table class="admintable">
				<tr>
					<td>
						<?php
						$editor =& JFactory::getEditor();
						$this->assignRef( 'editor', $editor );
						// parameters : areaname, content, hidden field, width, height, rows, cols
						echo $this->editor->display( 'notes', $this->project_player->notes, "100%"  , '400', '70', '15' );
					?>
					</td>
				</tr>
			</table>
		</fieldset>