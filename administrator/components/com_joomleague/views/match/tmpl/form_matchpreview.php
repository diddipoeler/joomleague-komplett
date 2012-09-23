<?php  
defined( '_JEXEC' ) or die( 'Restricted access' );
?>			
		<!-- match preview -->
		<fieldset class="adminform">
			<legend>
				<?php
				echo JText::_( 'JL_ADMIN_MATCH_F_MP' );
				?>
			</legend>
			<table>
				<tr>
					<td colspan="2">
						<?php
						$editor =& JFactory::getEditor();
						$this->assignRef( 'editor', $editor );
						// parameters : areaname, content, hidden field, width, height, rows, cols
						echo $this->editor->display( 'preview', $this->match->preview, '600', '400', '70', '15');
						?>
					 </td>
				</tr>
			</table>
		</fieldset>

		<div style="text-align:right; ">
			<input type="submit" value="<?php echo JText::_( 'JL_GLOBAL_SAVE' ); ?>">
		</div>
		<br />