<?php defined('_JEXEC') or die('Restricted access');
?>		
<fieldset class="adminform">
	<!-- start image import -->
	<legend>
		<?php echo JText::_('JL_ADMIN_TEAM_PIC') ?>
	</legend>
	<table class='admintable' border='0'>
		<tr>
			<td>
				<table>
					<tr>
					<td class="key"><?php echo JText::_('JL_ADMIN_TEAM_PIC');?></td>					
						<td>
							<img	class="imagepreview" src="../media/com_joomleague/jl_images/spinner.gif"
									name="picture_preview" id="picture_preview" border="2" alt="Preview" />
							<br />&nbsp;
							<?php echo $this->imageselect; ?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<!-- end image import -->
</fieldset>