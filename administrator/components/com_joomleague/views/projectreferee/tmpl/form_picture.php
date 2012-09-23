<?php defined('_JEXEC') or die('Restricted access');
?>		

		<fieldset class="adminform">
			<legend>
				<?php
				echo JText::sprintf(	'JL_ADMIN_P_REF_PIC_TITLE',
				  JoomleagueHelper::formatName(null, $this->projectreferee->firstname, $this->projectreferee->nickname, $this->projectreferee->lastname, 0));
				?>
			</legend>
			<table class="admintable">
				<tr>
					<td width="250" class="key" style="text-align:center; ">
						<label for="image">
							<span	class="hasTip" title='<?php echo JText::_('JL_ADMIN_P_REF_PIC'); ?>
									::<?php echo JText::_('JL_ADMIN_P_REF_PIC'); ?>'>
								<?php
								echo JText::_('JL_ADMIN_P_REF_PIC');
								?>
							</span>
						</label>
					</td>
					<td rowspan="10" style="text-align:center; ">
						<img	class="imagepreview" src="../media/com_joomleague/jl_images/spinner.gif" name="picture_preview"
								id="picture_preview" border="3" alt="Preview" title="Preview" /><br />
						<?php
						echo $this->imageselect;
						?>
					</td>
				</tr>
			</table>
		</fieldset>