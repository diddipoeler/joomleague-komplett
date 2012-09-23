<?php defined('_JEXEC') or die('Restricted access');
?>		
			<fieldset class="adminform">
				<!-- start image import -->
				<legend>
					<?php
					echo JText::sprintf(	'JL_ADMIN_P_TEAM_TITLE_PIC',
											'<i>' . $this->project_team->name . '</i>',
											'<i>' . $this->projectws->name . '</i>');
					?>
				</legend>
				<table class='admintable' border='0'>
					<tr>
						<td>
							<table>
								<tr>
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