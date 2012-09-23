<?php defined('_JEXEC') or die('Restricted access');
?>
	<fieldset class="adminform">
		<legend><?php echo JText::_('JL_ADMIN_PLAYGROUND_LEGEND'); ?></legend>
		<table class="admintable">
			<tr>
				<td width="100" align="right" class="key"><label for="name"><?php echo JText::_('JL_ADMIN_PLAYGROUND_NAME'); ?></label></td>
				<td><input class="text_area" type="text" name="name" id="title" size="32" maxlength="250" value="<?php echo $this->venue->name; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="alias"><?php echo JText::_('JL_ADMIN_PLAYGROUND_ALIAS'); ?></label></td>
				<td><input class="text_area" type="text" name="alias" id="alias" size="32" maxlength="75" value="<?php echo $this->venue->alias; ?>" /></td>
			</tr>
			<tr>
				<td valign="top" align="right" class="key"><label for="ordering"><?php echo JText::_('JL_ADMIN_PLAYGROUND_ORDERING'); ?></label></td>
				<td><?php echo $this->lists['ordering']; ?></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="name"><?php echo JText::_('JL_ADMIN_PLAYGROUND_S_NAME'); ?></label></td>
				<td><input class="text_area" type="text" name="short_name" id="title" size="8" maxlength="4" value="<?php echo $this->venue->short_name; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="address"><?php echo JText::_('JL_ADMIN_PLAYGROUND_ADDRESS'); ?></label></td>
				<td><input class="text_area" type="text" name="address"  size="32" maxlength="100" value="<?php echo $this->venue->address; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="zipcode"><?php echo JText::_('JL_ADMIN_PLAYGROUND_ZIPCODE'); ?></label></td>
				<td><input class="text_area" type="text" name="zipcode" id="title" size="8" maxlength="16" value="<?php echo $this->venue->zipcode; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="location"><?php echo JText::_('JL_ADMIN_PLAYGROUND_CITY'); ?></label></td>
				<td><input class="text_area" type="text" name="city" id="title" size="32" maxlength="250" value="<?php echo $this->venue->city; ?>" /></td>
			</tr>
			<tr>
				<td valign="top" align="right" class="key"><label for="country"><?php echo JText::_('JL_ADMIN_PLAYGROUND_COUNTRY'); ?></label></td>
				<td><?php echo $this->lists['countries']; ?></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><label for="phone"><?php echo JText::_('JL_ADMIN_PLAYGROUND_WEBSITE'); ?></label></td>
				<td><input class="text_area" type="text" name="website" id="title" size="64" maxlength="250" value="<?php echo $this->venue->website; ?>" /></td>
			</tr>
			<tr>
				<td width="100" align="right" class="key"><?php echo JText::_('JL_ADMIN_PLAYGROUND_CAPACITY'); ?></td>
				<td><input class="text_area" type="text" name="max_visitors" id="title" size="8" maxlength="11" value="<?php echo $this->venue->max_visitors; ?>" /></td>
			</tr>
            
            <tr>
				<td width="100" align="right" class="key"><?php echo JText::_('JL_ADMIN_PLAYGROUND_UNIQUE_ID'); ?></td>
				<td><input class="text_area" type="text" name="unique_id" id="title" size="20" maxlength="20" value="<?php echo $this->venue->unique_id; ?>" /></td>
			</tr>
            
			<tr>
				<td valign="top" align="right" class="key"><label for="club"><?php echo JText::_('JL_ADMIN_PLAYGROUND_CLUB'); ?></label></td>
				<td><?php echo $this->lists['clubs']; ?></td>
			</tr>
		</table>
	</fieldset>