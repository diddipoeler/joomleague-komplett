<?php defined('_JEXEC') or die('Restricted access');
?>

<fieldset class="adminform"><legend><?php echo JText::_('JL_ADMIN_CLUB_LEGEND'); ?></legend>
	<table class="admintable">
		<tr>
			<td width="100" align="right" class="key"><label for="name"> <?php echo JText::_('JL_ADMIN_CLUB_NAME'); ?></label></td>
			<td>
				<input class="text_area" type="text" name="name" id="title" size="32" maxlength="100" value="<?php echo stripslashes(htmlspecialchars($this->club->name)); ?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key"><label for="alias"> <?php	echo JText::_('JL_ADMIN_CLUB_ALIAS'); ?></label></td>
			<td>
				<input class="text_area" type="text" name="alias" id="alias" size="32" maxlength="75" value="<?php echo $this->club->alias; ?>" />
			</td>
		</tr>
		<tr>
			<td valign="top" align="right" class="key"><label for="ordering"> <?php echo JText::_('JL_ADMIN_CLUB_ORDERING'); ?></label></td>
			<td><?php echo $this->lists['ordering']; ?></td>
		</tr>
		<?php
		if (!$this->edit)
		{
			?>
			<tr>
				<td width="20%" align="right"><?php echo JText::_('JL_ADMIN_CLUB_CREATE_TEAM')?></td>
				<td width="80%"><input type="checkbox" name="createTeam" /></td>
			</tr>
			<?php
		}
		?>
		<tr>
			<td valign="top" align="right" class="key"><label for="Admin"><?php echo JText::_('JL_ADMIN_CLUB_ADMINISTRATOR'); ?></label></td>
			<td><?php echo $this->lists['admin']; ?></td>
		</tr>
		<tr>
			<td width="100" align="right" class="key"><label for="address"><?php echo JText::_('JL_ADMIN_CLUB_ADDRESS'); ?></label></td>
			<td width="270">
				<textarea class="_inputbox" name="address" cols="50" rows="2" maxlength="100"><?php echo stripslashes(htmlspecialchars($this->club->address)); ?></textarea>
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key"><label for="zipcode"><?php echo JText::_('JL_ADMIN_CLUB_POSTAL_CODE'); ?></label></td>
			<td>
				<input class="text_area" type="text" name="zipcode" id="title" size="32" maxlength="250" value="<?php echo $this->club->zipcode; ?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key"><label for="location"><?php echo JText::_('JL_ADMIN_CLUB_CITY'); ?></label></td>
			<td>
				<input class="text_area" type="text" name="location" id="title" size="32" maxlength="250" value="<?php echo stripslashes(htmlspecialchars($this->club->location)); ?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key"><label for="state"><?php echo JText::_('JL_ADMIN_CLUB_STATE'); ?></label></td>
			<td>
				<input class="text_area" type="text" name="state" id="title" size="32" maxlength="250" value="<?php echo stripslashes(htmlspecialchars($this->club->state)); ?>" />
			</td>
		</tr>
		<tr>
			<td valign="top" align="right" class="key"><label for="country"><?php echo JText::_('JL_ADMIN_CLUB_COUNTRY'); ?></label></td>
			<td><?php echo $this->lists['countries']; ?></td>
		</tr>
		<tr>
			<td width="100" align="right" class="key"><label for="phone"><?php echo JText::_('JL_ADMIN_CLUB_PHONE'); ?></label></td>
			<td>
				<input class="text_area" type="text" name="phone" id="title" size="32" maxlength="250" value="<?php echo $this->club->phone; ?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key"><label for="fax"><?php echo JText::_('JL_ADMIN_CLUB_FAX'); ?></label></td>
			<td>
				<input class="text_area" type="text" name="fax" id="title" size="32" maxlength="250" value="<?php echo $this->club->fax; ?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key"><label for="email"><?php echo JText::_('JL_ADMIN_CLUB_EMAIL'); ?></label></td>
			<td>
				<input class="text_area" type="text" name="email" id="title" size="32" maxlength="250" value="<?php echo $this->club->email; ?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key"><label for="website"><?php echo JText::_('JL_ADMIN_CLUB_WEBSITE'); ?></label></td>
			<td>
				<input class="text_area" type="text" name="website" id="title" size="32" maxlength="250" value="<?php echo $this->club->website; ?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key"><label for="manager"><?php echo JText::_('JL_ADMIN_CLUB_GENERAL_MANAGER'); ?></label></td>
			<td>
				<input class="text_area" type="text" name="manager" id="title" size="32" maxlength="250" value="<?php echo stripslashes(htmlspecialchars($this->club->manager)); ?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key"><label for="president"><?php echo JText::_('JL_ADMIN_CLUB_PRESIDENT'); ?></label></td>
			<td>
				<input class="text_area" type="text" name="president" id="title" size="32" maxlength="250" value="<?php echo stripslashes(htmlspecialchars($this->club->president)); ?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key"><label for="founded"><?php echo JText::_('JL_ADMIN_CLUB_FOUNDED'); ?></label></td>
			<td>

			<?php
						$date=JFactory::getDate($this->club->founded)->toFormat('%d-%m-%Y');
						echo JHTML::calendar($date,'founded','founded','%d-%m-%Y','size="10" ');
						?>
      </td>
		</tr>
		<tr>
			<td width="100" align="right" class="key"><label for="founded_year"><?php echo JText::_('JL_ADMIN_CLUB_FOUNDED_YEAR'); ?></label></td>
			<td>
				<input class="text_area" type="text" name="founded_year" id="title" size="32" maxlength="250" value="<?php echo stripslashes(htmlspecialchars($this->club->founded_year)); ?>" />
			</td>
		</tr>
		
		<tr>
			<td width="100" align="right" class="key"><label for="dissolved"><?php echo JText::_('JL_ADMIN_CLUB_DISSOLVED'); ?></label></td>
			<td>
				
						<?php
						$date=JFactory::getDate($this->club->dissolved)->toFormat('%d-%m-%Y');
						echo JHTML::calendar($date,'dissolved','dissolved','%d-%m-%Y','size="10" ');
						?>
      </td>
		</tr>
		<tr>
			<td width="100" align="right" class="key"><label for="dissolved_year"><?php echo JText::_('JL_ADMIN_CLUB_DISSOLVED_YEAR'); ?></label></td>
			<td>
				<input class="text_area" type="text" name="dissolved_year" id="title" size="32" maxlength="250" value="<?php echo stripslashes(htmlspecialchars($this->club->dissolved_year)); ?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key"><label for="unique_id"><?php echo JText::_('JL_ADMIN_CLUB_UNIQUE_ID'); ?></label></td>
			<td>
				<input class="text_area" type="text" name="unique_id" id="title" size="32" maxlength="250" value="<?php echo stripslashes(htmlspecialchars($this->club->unique_id)); ?>" />
			</td>
		</tr>
		
		<tr>
			<td valign="top" align="right" class="key"><label for="playground"><?php echo JText::_('JL_ADMIN_CLUB_VENUE'); ?></label></td>
			<td><?php echo $this->lists['playgrounds']; ?></td>
		</tr>

	</table>
</fieldset>