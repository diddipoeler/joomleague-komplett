<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
?>

		<!-- match report -->
		<fieldset class="adminform">
			<legend>
				<?php
				echo JText::_( 'JL_ADMIN_MATCH_F_MR' );
				?>
			</legend>
			<table class='admintable'>
				<!-- Game Report -->
				<tr>
					 <td width="5%" nowrap="nowrap" class="key" style="text-align=right;">
						<label >
							<?php
							echo JText::_('JL_ADMIN_MATCH_F_MR_SHOW');
							?>
						</label>
					</td>
					<td>
						<?php
						echo $this->lists['show_report'];
						//index.php?option=com_content&task=element&tmpl=component&object=id
						?>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<?php
						$editor =& JFactory::getEditor();
						$this->assignRef( 'editor', $editor );
						// parameters : areaname, content, hidden field, width, height, rows, cols
						echo $this->editor->display( 'summary', $this->match->summary, '600', '400', '70', '15' );
						?>
					 </td>
				</tr>
				<!-- Game Report END -->
			</table>
		</fieldset>

		<br />
		<div style="text-align:right; ">
			<input type="submit" value="<?php echo JText::_( 'JL_GLOBAL_SAVE' ); ?>">
		</div>
		<br />