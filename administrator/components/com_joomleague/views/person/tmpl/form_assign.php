<?php defined('_JEXEC') or die('Restricted access');
?>		


			<fieldset class="adminform">
				<legend>
					<?php
					echo JText::_('JL_ADMIN_PERSON_ASSIGN_DESCR');
					?>
				</legend>
				<table class="admintable" border="0">
					<tr>
						<td width="20%" class="key" style="text-align:right; vertical-align:top;" >
							<label for="project_id">
								<?php
								echo JText::_('JL_ADMIN_PERSON_ASSIGN_PID');
								?>
							</label>
						</td>
						<td style="text-align:left; vertical-align:top;" >
							<input	class="text_area" type="text" name="project_id" id="project_id" value=""
									size="4" maxlength="5" />
						</td>
						<td colspan="2" rowspan="2" style="text-align:left; vertical-align:middle;" >
							<div class="button2-left" style="display:inline">
								<div class="readmore">
									<?php
									//create the button code to use in form while selecting a project and team to assign a new person to
									$button = '<a class="modal-button" title="Select" ';
									$button .= 'href="index3.php?option=com_joomleague&controller=person&view=person&task=personassign" ';
									$button .= 'rel="{handler: \'iframe\', size: {x: 600, y: 400}}">' . JText::_('Select') . '</a>';
									#echo $this->button;
									echo $button;
									?>
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td width="20%" class="key" style="text-align:right; vertical-align:top;" >
							<label for="team">
								<?php
								echo JText::_('JL_ADMIN_PERSON_ASSIGN_TID');
								?>
							</label>
						</td>
						<td style="text-align:left; vertical-align:top;" >
							<input	class="text_area" type="text" name="team_id" id="team_id" value="" size="4"
									maxlength="5" />
						</td>
					</tr>
				</table>
			</fieldset>