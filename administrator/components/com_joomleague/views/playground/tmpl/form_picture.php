<?php defined('_JEXEC') or die('Restricted access');
?>
	<fieldset class="adminform">
		<legend><?php echo JText::_('JL_ADMIN_PLAYGROUND_PICTURE_LEGEND'); ?></legend>
		<table class="admintable">
			<tr>
				<td width="250" align="right" class="key">
					<label for="image">
						<span class="hasTip" title='<?php echo JText::_('JL_ADMIN_PLAYGROUND_PICTURE'); ?>::<?php echo JText::_('JL_ADMIN_PLAYGROUND_PICTURE_DESC'); ?>'>
						<?php echo JText::_('JL_ADMIN_PLAYGROUND_PICTURE'); ?>
						</span>
					</label>
				</td>
				<td>
					<table>
						<tr>
							<td><?php echo $this->imageselect; ?></td>
						  	<img class="imagepreview" src="../media/com_joomleague/jl_images/spinner.gif" name="picture_preview" id="picture_preview" border="2" alt="Preview" />
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</fieldset>