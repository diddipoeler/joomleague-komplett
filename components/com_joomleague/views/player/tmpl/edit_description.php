<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>
<fieldset class="adminform">
	<table class="admintable">
		<tr>
			<td>
				<?php
				$editor =& JFactory::getEditor();
				$this->assignRef( 'editor', $editor );
				// parameters : areaname, content, hidden field, width, height, rows, cols
				echo $this->editor->display( 'notes', $this->teamPlayer->notes, '100%', '400', '70', '15' );
			?>
			</td>
		</tr>
	</table>
</fieldset>	