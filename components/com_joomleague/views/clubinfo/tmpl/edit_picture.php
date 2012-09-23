<?php defined('_JEXEC') or die('Restricted access');
?>
<fieldset class="adminform"><legend><?php echo JText::_('JL_EDIT_CLUBINFO_CLUB_LOGO'); ?></legend>
	<table class="admintable">
		<tr>
			<td>
			<table>
				<tr>
					<td align="center"><?php echo JText::_('JL_EDIT_CLUBINFO_LOGO_LARGE');?></td>
				</tr>
				<tr>					
					<td width="150" align="center"><img class="imagepreview"
						src="../media/com_joomleague/placeholders/placeholder_150.png"
						name="logo_big_preview" id="logo_big_preview" border="2"
						alt="<?php echo JText::_('JL_GLOBAL_PREVIEW'); ?>"
						title="<?php echo JText::_('JL_GLOBAL_PREVIEW'); ?>" />
					</td>
				</tr>
				<tr>						
					<td width="270"><?php echo $this->logo_bigselect; ?></td>	
				</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td>
			<table>
				<tr>
					<td align="center"><?php echo JText::_('JL_EDIT_CLUBINFO_LOGO_MIDDLE');?></td>
				</tr>
				<tr>
					<td width="150" align="center"><img class="imagepreview"
						src="../media/com_joomleague/placeholders/placeholder_50.png"
						name="logo_middle_preview" id="logo_middle_preview" border="2"
						alt="<?php echo JText::_('JL_GLOBAL_PREVIEW'); ?>"
						title="<?php echo JText::_('JL_GLOBAL_PREVIEW'); ?>" />
					</td>
				</tr>
				<tr>						
					<td width="270"><?php echo $this->logo_middleselect; ?></td>	
				</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td>
			<table>
				<tr>
					<td align="center"><?php echo JText::_('JL_EDIT_CLUBINFO_LOGO_SMALL');?></td>
				</tr>
				<tr>					
					<td width="150" align="center"><img class="imagepreview"
						src="../media/com_joomleague/placeholders/placeholder_small.gif"
						name="logo_small_preview" id="logo_small_preview" border="2"
						alt="<?php echo JText::_('JL_GLOBAL_PREVIEW'); ?>"
						title="<?php echo JText::_('JL_GLOBAL_PREVIEW'); ?>" />
					</td>
				</tr>
				<tr>						
					<td width="270"><?php echo $this->logo_smallselect; ?></td>	
				</tr>
			</table>
			</td>
		</tr>
	</table>
</fieldset>
