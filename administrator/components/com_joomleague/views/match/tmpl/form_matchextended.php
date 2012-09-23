<?php  
defined( '_JEXEC' ) or die( 'Restricted access' );
?>			
		<!-- match preview -->
		<fieldset class="adminform">
			<legend>
				<?php
				echo JText::_( 'JL_ADMIN_MATCH_F_MED' );
				?>
			</legend>
			<table>
				<tr>
					<td colspan="2">
						<?php
						foreach ( $this->extended->getGroups() as $key => $groups )
						{
							// render is defined in joomla\libraries\joomla\html\parameter.php
							echo $this->extended->render( 'extended', $key );
						}
						?>
					 </td>
				</tr>
			</table>
		</fieldset>

		<div style="text-align:right; ">
			<input type="submit" value="<?php echo JText::_( 'JL_GLOBAL_SAVE' ); ?>">
		</div>
		<br />