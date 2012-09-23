<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

	<table cellpadding="4" cellspacing="1" border="0">
		<tr>
			<td align="right">
				<?php echo JText::_('JL_EDIT_PERSON_FIRST_NAME');?>
			</td>
			<td width="270">
				<input class="inputbox" type="text" name="firstname" size="50" maxlength="45" value="<?php echo $this->person->firstname;?>" />
			</td>
		</tr>
		<tr>
			<td align="right">
				<?php echo JText::_('JL_EDIT_PERSON_LAST_NAME');?>
			</td>
			<td width="270">
				<input class="inputbox" type="text" name="lastname" size="50" maxlength="45" value="<?php echo $this->person->lastname;?>" />
			</td>
		</tr>
		<tr>
			<td align="right">
				<?php echo JText::_('JL_EDIT_PERSON_NICK_NAME');?>
			</td>
			<td width="270">
				<input class="inputbox" type="text" name="nickname" size="50" maxlength="45" value="<?php echo $this->person->nickname;?>" />
			</td>
		</tr>
		<tr>
			<td align="right">
				<?php echo JText::_('JL_EDIT_PERSON_BIRTHDAY');?>
			</td>
			<td width="270">
				<?php echo $this->lists['birthday']; ?> 
			</td>
		</tr>
		<tr>
			<td align="right">
				<?php echo JText::_('JL_EDIT_PERSON_DEATHDAY');?>
			</td>
			<td width="270">
				<?php echo $this->lists['deathday']; ?> 
			</td>
		</tr>
		<tr>
			<td align="right">
				<?php echo JText::_('JL_EDIT_PERSON_NATIONALITY');?>
			</td>
			<td width="270">
				<?php echo $this->lists['countries'];?>
			</td>
		</tr>
		
		<tr>
			<td align="right"><?php echo JText::_('JL_EDIT_PERSON_ADDRESS');?></td>
			<td width="270"><input class="inputbox" type="text" name="address" size="50" maxlength="100" value="<?php echo $this->person->address;?>" /></td>
		</tr>
		<tr>
			<td align="right">
				<?php echo JText::_('JL_EDIT_PERSON_POSTAL_CODE');?>
			</td>
			<td width="270">
				<input class="inputbox" type="text" name="zipcode" size="10" maxlength="10" value="<?php echo $this->person->zipcode;?>" />
			</td>
		</tr>
		<tr>
			<td align="right">
				<?php echo JText::_('JL_EDIT_PERSON_CITY');?>
			</td>
			<td width="270">
				<input class="inputbox" type="text" name="location" size="50" maxlength="50" value="<?php echo $this->person->location;?>" />
			</td>
		</tr>
		<tr>
			<td align="right">
				<?php echo JText::_('JL_EDIT_PERSON_COUNTRY');?>
			</td>
			<td width="270">
			<?php echo $this->lists['address_countries'];?>
			</td>
		</tr>
		<tr>
			<td align="right">
				<?php echo JText::_('JL_EDIT_PERSON_STATE');?>
			</td>
			<td width="270">
				<input class="inputbox" type="text" name="state" size="50" maxlength="50" value="<?php echo $this->person->state;?>" />
			</td>
		</tr>
		<tr>
			<td align="right">
				<?php echo JText::_('JL_EDIT_PERSON_PHONE');?>
			</td>
			<td width="270">
				<input class="inputbox" type="text" name="phone" size="20" maxlength="20" value="<?php echo $this->person->phone;?>" />
			</td>
		</tr>
		<tr>
			<td align="right">
				<?php echo JText::_('JL_EDIT_PERSON_MOBIL');?>
			</td>
			<td width="270">
				<input class="inputbox" type="text" name="mobile" size="20" maxlength="20" value="<?php echo $this->person->mobile;?>" />
			</td>
		</tr>
		<tr>
			<td align="right">
				<?php echo JText::_('JL_EDIT_PERSON_EMAIL');?>
			</td>
			<td width="270">
			  <input class="inputbox" type="text" name="email" size="50" maxlength="50" value="<?php echo $this->person->email;?>" />
			</td>
		</tr>
		<tr>
			<td align="right">
				<?php echo JText::_('JL_EDIT_PERSON_WEBSITE');?>
			</td>
			<td width="270">
			  <input class="inputbox" type="text" name="website" size="50" maxlength="250" value="<?php echo $this->person->website;?>" />
			</td>
		</tr>
		<tr>
			<td align="right">
				<?php echo JText::_('JL_EDIT_PERSON_HEIGHT');?>
			</td>
			<td width="270">
				<?php
					echo JText::sprintf('JL_EDIT_PERSON_HEIGHT_FORM', 
						'<input class="inputbox" type="text" name="height" size="5" maxlength="3" value="'. $this->person->height.'" />');
						?>			
			</td>
		</tr>
		<tr>
			<td align="right">
				<?php echo JText::_('JL_EDIT_PERSON_WEIGHT');?>
			</td>
			<td width="270">
				<?php
					echo JText::sprintf('JL_EDIT_PERSON_WEIGHT_FORM', 
						'<input class="inputbox" type="text" name="weight" size="5" maxlength="3" value="'. $this->person->weight.'" />');
						?>			
			</td>
		</tr>
	</table>