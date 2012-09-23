<?php defined('_JEXEC') or die('Restricted access');
?>
		<fieldset class="adminform">
			<legend>
				<?php
				$text = (!$this->edit) ? JText::_('JL_ADMIN_PERSON_HEADER_ADD') : JText::sprintf('%1$s [<i>%2$s</i>]',JTEXT::_('JL_ADMIN_PERSON_HEADER_EDIT'), 
				  JoomleagueHelper::formatName(null, $this->person->firstname, $this->person->nickname, $this->person->lastname, 0));
				echo $text;
				?>
			</legend>
			<table class='admintable'>
				<tr>
					<td width="20%" class="key" nowrap="nowrap" style="text-align:right; vertical-align:top;" >
						<label for="user_id"><?php echo JText::_('JL_ADMIN_PERSON_JOOMLA_USER'); ?></label>
					</td>
					<td style="text-align:left; vertical-align:top;" ><?php echo $this->lists['jl_users']; ?>
					</td>
					<td width="20%" class="key" style="text-align:right; vertical-align:top;" >
						<label for="birthday"><?php echo JText::_('JL_ADMIN_PERSON_POSITION'); ?></label>
					</td>
					<td style="text-align:left; vertical-align:top;" ><?php echo $this->lists['positions']; ?>
					</td>					
				</tr>
				<tr>
					<td width="20%" class="key" style="text-align:right; vertical-align:top;" >
						<label for="firstname"><?php echo JText::_('JL_ADMIN_PERSON_F_NAME'); ?></label>
					</td>
					<td style="text-align:left; vertical-align:top;" >
						<input	class="text_area" type="text" name="firstname" id="title" size="55"
								maxlength="45" value="<?php echo stripslashes(htmlspecialchars($this->person->firstname)); ?>" />
					</td>
					<td width="20%" class="key" style="text-align:right; vertical-align:top;" >
						<label for="lastname"><?php echo JText::_('JL_ADMIN_PERSON_L_NAME'); ?></label>
					</td>
					<td style="text-align:left; vertical-align:top;" >
						<input	class="text_area" type="text" name="lastname" id="title" size="55"
								maxlength="45" value="<?php echo stripslashes(htmlspecialchars($this->person->lastname)); ?>" />
					</td>
				</tr>      
        
				<tr>
					<td width="20%" class="key" style="text-align:right; vertical-align:top;" >
						<label for="jl_user_id"><?php echo JText::_('JL_ADMIN_PERSON_N_NAME'); ?></label>
					</td>
					<td style="text-align:left; vertical-align:top;" >
						<input	class="text_area" type="text" name="nickname" id="title" size="55"
								maxlength="45" value="<?php echo stripslashes(htmlspecialchars($this->person->nickname)); ?>" />
					</td>
					<td width="100" align="right" class="key">
                        <label for="alias"><?php echo JText::_('JL_ADMIN_PERSON_ALIAS'); ?></label>
                     </td>
					<td>
						<input class="text_area" type="text" name="alias" id="alias" size="32" maxlength="75" value="<?php echo $this->person->alias; ?>" />
					</td>					
				</tr>
				
				<tr>
					<td width="20%" class="key" style="text-align:right; vertical-align:top;" >
						<label for="birthday"><?php echo JText::_('JL_ADMIN_PERSON_BIRTHDAY'); ?></label>
					</td>
					<td style="text-align:left; vertical-align:top;" ><?php echo $this->lists['birthday']; ?></td>
					<td width="20%" class="key" style="text-align:right; vertical-align:top;" >
						<label for="birthday"><?php echo JText::_('JL_ADMIN_PERSON_DEATHDAY'); ?></label>
					</td>
					<td style="text-align:left; vertical-align:top;" ><?php echo $this->lists['deathday']; ?></td>
				</tr>
				
				<tr>
					<td width="20%" class="key" style="text-align:right; vertical-align:top;" >
						<label for="info"><?php echo JText::_('JL_ADMIN_PERSON_INFO'); ?></label>
					</td>
					<td style="text-align:left; vertical-align:top;" >
						<input	class="text_area" type="text" name="info" id="title" size="55"
								maxlength="45" value="<?php echo stripslashes(htmlspecialchars($this->person->info)); ?>" />
					</td>
					<td width="20%" class="key" style="text-align:right; vertical-align:top;" >
						<label for="jl_user_id"><?php echo JText::_('JL_ADMIN_PERSON_REGISTRATION_NUMBER'); ?></label>
					</td>
					<td style="text-align:left; vertical-align:top;" >
						<input	class="text_area" type="text" name="knvbnr" id="title" size="55"
								maxlength="10" value="<?php echo $this->person->knvbnr; ?>" />
					</td>									
				</tr>
				<tr>
					<td valign="top" class="key" style="text-align:right; vertical-align:top;" >
						<label for="country"><?php echo JText::_('JL_ADMIN_PERSON_NATIONALITY'); ?></label>
					</td>
					<td style="text-align:left; vertical-align:top;" ><?php echo $this->lists['countries']; ?></td>
					<td width="20%" class="key" style="text-align:right; vertical-align:top;" >
					</td>
					<td style="text-align:left; vertical-align:top;" >
					</td>	
				</tr>
				<tr>
					<td width="20%" rowspan="2" class="key" style="text-align:right; vertical-align:top;" >
						<label for="address"><?php echo JText::_('JL_ADMIN_PERSON_ADDRESS'); ?></label>
					</td>
					<td rowspan="2" style="text-align:left; vertical-align:top;" >
						<textarea	class="_inputbox" name="address" cols="30" rows="2"
									maxlength="100"><?php echo stripslashes(htmlspecialchars($this->person->address)); ?></textarea>
					</td>
					<td width="20%" class="key" style="text-align:right; vertical-align:top;" >
						<label for="zipcode"><?php echo JText::_('JL_ADMIN_PERSON_POSTAL_CODE'); ?></label>
					</td>
					<td style="text-align:left; vertical-align:top;" >
						<input	class="text_area" type="text" name="zipcode" id="title" size="55"
								maxlength="10" value="<?php echo $this->person->zipcode; ?>" />
					</td>
				</tr>
				<tr>
					<td width="20%" class="key" style="text-align:right; vertical-align:top;" >
						<label for="location"><?php echo JText::_('JL_ADMIN_PERSON_CITY'); ?></label>
					</td>
					<td style="text-align:left; vertical-align:top;" >
						<input	class="text_area" type="text" name="location" id="title" size="55"
								maxlength="50" value="<?php echo stripslashes(htmlspecialchars($this->person->location)); ?>" />
					</td>
				</tr>
				<tr>
					<td width="20%" class="key" style="text-align:right; vertical-align:top;" >
						<label for="state"><?php echo JText::_('JL_ADMIN_PERSON_STATE'); ?></label>
					</td>
					<td style="text-align:left; vertical-align:top;" >
						<input	class="text_area" type="text" name="state" id="title" size="55"
								maxlength="50" value="<?php echo stripslashes(htmlspecialchars($this->person->state)); ?>" />
					</td>
					<td width="20%" class="key" style="text-align:right; vertical-align:top;" >
						<label for="country"><?php echo JText::_('JL_ADMIN_PERSON_COUNTRY'); ?></label>
					</td>
					<td style="text-align:left; vertical-align:top;" ><?php echo $this->lists['address_countries']; ?></td>
				</tr>
				<tr>
					<td width="20%" class="key" style="text-align:right; vertical-align:top;" >
						<label for="phone"><?php echo JText::_('JL_ADMIN_PERSON_PHONE'); ?></label>
					</td>
					<td style="text-align:left; vertical-align:top;" >
						<input	class="text_area" type="text" name="phone" id="title" size="55"
								maxlength="20" value="<?php echo $this->person->phone; ?>" />
					</td>
					<td width="20%" class="key" style="text-align:right; vertical-align:top;" >
						<label for="mobile"><?php echo JText::_('JL_ADMIN_PERSON_MOBILE'); ?></label>
					</td>
					<td style="text-align:left; vertical-align:top;" >
						<input	class="text_area" type="text" name="mobile" id="title" size="55"
								maxlength="20" value="<?php echo $this->person->mobile; ?>" />
					</td>
				</tr>
				<tr>
					<td width="20%" class="key" style="text-align:right; vertical-align:top;" >
						<label for="email"><?php echo JText::_('JL_ADMIN_PERSON_EMAIL'); ?></label>
					</td>
					<td style="text-align:left; vertical-align:top;" >
						<input	class="text_area" type="text" name="email" id="title" size="55"
								maxlength="50" value="<?php echo $this->person->email; ?>" />
					</td>
					<td width="20%" class="key" style="text-align:right; vertical-align:top;" >
						<label for="website"><?php echo JText::_('JL_ADMIN_PERSON_WEBSITE'); ?></label>
					</td>
					<td style="text-align:left; vertical-align:top;" >
						<input	class="text_area" type="text" name="website" id="title" size="55"
								maxlength="45" value="<?php echo $this->person->website; ?>" />
					</td>
				</tr>
				<tr>
					<td width="20%" class="key" style="text-align:right; vertical-align:top;" ><?php echo JText::_('JL_ADMIN_PERSON_HEIGHT'); ?></td>
					<td style="text-align:left; vertical-align:top;" >
						<input	class="inputbox" type="text" name="height" size="5" maxlength="3"
								value="<?php echo $this->person->height; ?>" />&nbsp;(cm)
					</td>
					<td width="20%" class="key" style="text-align:right; vertical-align:top;" ><?php echo JText::_('JL_ADMIN_PERSON_WEIGHT'); ?></td>
					<td style="text-align:left; vertical-align:top;" >
						<input	class="inputbox" type="text" name="weight" size="5" maxlength="3"
								value="<?php echo $this->person->weight; ?>" />&nbsp;(kg)
					</td>
				</tr>
			</table>
		</fieldset>