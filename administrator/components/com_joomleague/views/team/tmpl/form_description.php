<?php defined('_JEXEC') or die('Restricted access');
?>		

	
<fieldset class="adminform">
	<legend>
		<?php
		echo JText::sprintf(	'JL_ADMIN_TEAM_DESCR_TITLE',
								'<i>' . $this->team->name . '</i>' );
		?>
	</legend>
	<table class="admintable" border="0">
		<tr>
			<td>
				<?php
				$editor =& JFactory::getEditor();
				$this->assignRef( 'editor', $editor );
				// parameters : areaname, content, hidden field, width, height, rows, cols
				echo $this->editor->display( 'notes', $this->team->notes, '100%', '400', '100', '15' );
				?>
			</td>
		</tr>
	</table>
</fieldset>