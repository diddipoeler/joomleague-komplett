<?php defined('_JEXEC') or die('Restricted access');
?>
<fieldset class="adminform"><legend><?php echo JText::_('JL_ADMIN_CLUB_LOGO'); ?></legend>
	<table class="admintable">
		<tr>
			<td>
			<table>
				<tr>
					<td class="key"><?php echo JText::_('JL_ADMIN_CLUB_LOGO_LARGE');?></td>
					<td width="270"><?php echo $this->logo_bigselect; ?></td>
					<td width="150" align="center"><img class="imagepreview"
						src="../media/com_joomleague/placeholders/placeholder_150.png"
						name="logo_big_preview" id="logo_big_preview" border="2"
						alt="<?php echo JText::_('JL_GLOBAL_PREVIEW'); ?>"
						title="<?php echo JText::_('JL_GLOBAL_PREVIEW'); ?>" /></td>
				</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td>
			<table>
				<tr>
					<td class="key"><?php echo JText::_('JL_ADMIN_CLUB_LOGO_MIDDLE');?></td>
					<td width="270"><?php echo $this->logo_middleselect; ?></td>
					<td width="150" align="center"><img class="imagepreview"
						src="../media/com_joomleague/placeholders/placeholder_50.png"
						name="logo_middle_preview" id="logo_middle_preview" border="2"
						alt="<?php echo JText::_('JL_GLOBAL_PREVIEW'); ?>"
						title="<?php echo JText::_('JL_GLOBAL_PREVIEW'); ?>" /></td>
				</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td>
			<table>
				<tr>
					<td class="key"><?php echo JText::_('JL_ADMIN_CLUB_LOGO_SMALL');?></td>
					<td width="270"><?php echo $this->logo_smallselect; ?></td>
					<td width="150" align="center"><img class="imagepreview"
						src="../media/com_joomleague/placeholders/placeholder_small.gif"
						name="logo_small_preview" id="logo_small_preview" border="2"
						alt="<?php echo JText::_('JL_GLOBAL_PREVIEW'); ?>"
						title="<?php echo JText::_('JL_GLOBAL_PREVIEW'); ?>" /></td>
				</tr>
			</table>
			</td>
		</tr>
	</table>
</fieldset>
