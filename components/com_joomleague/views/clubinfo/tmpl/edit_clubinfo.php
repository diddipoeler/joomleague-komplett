<?php defined( '_JEXEC' ) or die( 'Restricted access' );
?>

	<table cellpadding="4" cellspacing="1" border="0">
		<tr>
			<td align="right">
				<?php echo JText::_('JL_EDIT_CLUBINFO_NAME');?>
			</td>
			<td width="270">
				<input class="inputbox" type="text" name="name" size="50" maxlength="250" value="<?php echo $this->club->name;?>" />
			</td>
		</tr>
		<tr>
			<td align="right"><?php echo JText::_('JL_EDIT_CLUBINFO_ADDRESS');?></td>
			<td width="270"><input class="inputbox" type="text" name="address" size="50" maxlength="250" value="<?php echo $this->club->address;?>" /></td>
		</tr>
		<tr>
			<td align="right">
				<?php echo JText::_('JL_EDIT_CLUBINFO_POSTAL_CODE');?>
			</td>
			<td width="270">
				<input class="inputbox" type="text" name="zipcode" size="10" maxlength="10" value="<?php echo $this->club->zipcode;?>" />
			</td>
		</tr>
		<tr>
			<td align="right">
				<?php echo JText::_('JL_EDIT_CLUBINFO_TOWN');?>
			</td>
			<td width="270">
				<input class="inputbox" type="text" name="location" size="50" maxlength="250" value="<?php echo $this->club->location;?>" />
			</td>
		</tr>
		<tr>
			<td align="right">
				<?php echo JText::_('JL_EDIT_CLUBINFO_COUNTRY');?>
			</td>
			<td width="270">
			<?php echo $this->countrieslist;?>
			</td>
		</tr>
		<tr>
			<td align="right">
				<?php echo JText::_('JL_EDIT_CLUBINFO_PHONE');?>
			</td>
			<td width="270">
				<input class="inputbox" type="text" name="phone" size="20" maxlength="20" value="<?php echo $this->club->phone;?>" />
			</td>
		</tr>
		<tr>
			<td align="right">
				<?php echo JText::_('JL_EDIT_CLUBINFO_FAX');?>
			</td>
			<td width="270">
				<input class="inputbox" type="text" name="fax" size="20" maxlength="20" value="<?php echo $this->club->fax;?>" />
			</td>
		</tr>
		<tr>
			<td align="right">
				<?php echo JText::_('JL_EDIT_CLUBINFO_MAIL');?>
			</td>
			<td width="270">
			  <input class="inputbox" type="text" name="email" size="50" maxlength="255" value="<?php echo $this->club->email;?>" />
			</td>
		</tr>
		<tr>
			<td align="right">
				<?php echo JText::_('JL_EDIT_CLUBINFO_INTERNET');?>
			</td>
			<td width="270">
			  <input class="inputbox" type="text" name="website" size="50" maxlength="250" value="<?php echo $this->club->website;?>" />
			</td>
		</tr>
		<tr>
			<td align="right">
				<?php echo JText::_('JL_EDIT_CLUBINFO_MANAGER');?>
			</td>
			<td width="270">
				<input class="inputbox" type="text" name="manager" size="50" maxlength="250" value="<?php echo $this->club->manager;?>" />
			</td>
		</tr>
		<tr>
			<td align="right">
				<?php echo JText::_('JL_EDIT_CLUBINFO_PRESIDENT');?>
			</td>
			<td width="270">
				<input class="inputbox" type="text" name="president" size="50" maxlength="250" value="<?php echo $this->club->president;?>" />
			</td>
		</tr>
		<tr>
			<td align="right">
				<?php echo JText::_('JL_EDIT_CLUBINFO_FOUNDED');?>
			</td>
			<td width="270">
				<input class="inputbox" type="text" name="founded" id="team_born" size="10" maxlength="19" value="<?php echo $this->club->founded;?>" />
			</td>
		</tr>
		<tr>
			<td width="20%" align="right">
				<?php echo JText::_('JL_EDIT_CLUBINFO_PLAYGROUNDS');?>
			</td>
			<td width="80%">
				<?php echo $this->playgroundslist; ?>
			</td>
		</tr>
	</table>