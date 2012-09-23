<?php defined('_JEXEC')or die('Restricted access');
?>
		<fieldset class="adminform">
			<legend><?php echo JText::_('JL_ADMIN_PROJECT_FAV_TEAM' ); ?></legend>
			<table class="admintable">
				<tr>
					<td width="100" align="right" class="key"><?php echo JText::_('JL_ADMIN_PROJECT_SELECT_TEAM' ); ?></td>
					<td><?php echo $this->lists['fav_team']; ?></td>
				</tr>
				<tr>
					<td width="100" align="right" class="key"><?php echo JText::_('JL_ADMIN_PROJECT_HIGHLIGHT_TYPE' ); ?></td>
					<td>
						<?php echo $this->lists['fav_team_highlight_type']; ?>
					</td>
				</tr>
				<tr>
					<td width="100" align="right" class="key"><?php echo JText::_('JL_ADMIN_PROJECT_HIGHLIGHT_COLOR' ); ?></td>
					<td>
						<input class="inputbox" type="text" ID="sample_2" size="1" value="">&nbsp;
						<input type="text" name="fav_team_color" ID="input_field_2" size="9" value="<?php echo $this->project->fav_team_color;?>" class="inputbox"/>&nbsp;
						<input type="button" class="inputbox"
								onclick="showColorGrid3('input_field_2','sample_2');return overlib(document.getElementById('colorpicker301').innerHTML, CAPTION,'Farbe:', BELOW, RIGHT,FOLLOWMOUSE=false, CLOSEBTN=true, CLOSEBTNCOLORS=['white', 'white', 'white', 'white'], STICKY=false);"
								value="..."/>
						<div id="colorpicker301" class="colorpicker301" style="position:absolute;top:0px;left:0px;z-index:1000;display:none;"></div>
						<script>document.getElementById('sample_2').style.backgroundColor=document.getElementById('input_field_2').value;</script>
					</td>
				</tr>
				<tr>
					<td width="100" align="right" class="key"><?php echo JText::_('JL_ADMIN_PROJECT_HIGHLIGHT_TEXT_COLOR' ); ?></td>
					<td>
						<input class="inputbox" type="text" ID="sample_3" size="1" value="">&nbsp;
						<input type="text" name="fav_team_text_color" ID="input_field_3" size="9" value="<?php echo $this->project->fav_team_text_color;?>" class="inputbox"/>&nbsp;
						<input	type="button" class="inputbox"
								onclick="showColorGrid3('input_field_3','sample_3');return overlib(document.getElementById('colorpicker301').innerHTML, CAPTION,'Farbe:', BELOW, RIGHT,FOLLOWMOUSE=false, CLOSEBTN=true, CLOSEBTNCOLORS=['white', 'white', 'white', 'white'], STICKY=false);"
								value="..."/>
						<div	id="colorpicker301" class="colorpicker301" style="position:absolute;top:0px;left:0px;z-index:1000;display:none;"></div>
						<script>document.getElementById('sample_3').style.backgroundColor=document.getElementById('input_field_3').value;</script>
					</td>
				</tr>
				<tr>
					<td width="100" align="right" class="key"><?php echo JText::_('JL_ADMIN_PROJECT_HIGHLIGHT_TEXT_BOLD' ); ?></td>
					<td>
						<?php echo $this->lists['fav_team_text_bold']; ?>
					</td>
				</tr>
			</table>
		</fieldset>