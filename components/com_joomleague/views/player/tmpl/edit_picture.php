<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>
<fieldset class="adminform"><legend><?php echo JText::_('JL_EDIT_PERSON_PLAYER_PICTURE'); ?></legend>
	<table class="admintable">
		<tr>
			<td>
			<table>
				<tr>
					<td align="center"><?php echo JText::_('JL_EDIT_PERSON_PLAYER_PICTURE');?></td>
				</tr>
				<tr>					
					<td width="150" align="center"><img class="imagepreview"
						src="../media/com_joomleague/placeholders/placeholder_150_2.png"
						name="picture_preview" id="picture_preview" border="2"
						alt="<?php echo JText::_('JL_GLOBAL_PREVIEW'); ?>"
						title="<?php echo JText::_('JL_GLOBAL_PREVIEW'); ?>" />
					</td>
				</tr>
				<tr>											
					<td width="270"><?php echo $this->imageselect; ?></td>	
				</tr>
			</table>
			</td>
		</tr>
	</table>		
</fieldset>