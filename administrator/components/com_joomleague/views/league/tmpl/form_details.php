<?php defined('_JEXEC') or die('Restricted access');
?>
<fieldset class="adminform">
	<legend><?php echo JText::_('JL_ADMIN_LEAGUE_LEGEND'); ?>
	</legend>
	<table class="admintable">
		<tr>
			<td width="100" align="right" class="key"><label for="name"><?php echo JText::_('JL_ADMIN_LEAGUE_NAME'); ?></label></td>
			<td>
				<input class="text_area" type="text" name="name" id="title" size="32" maxlength="250" value="<?php echo $this->object->name; ?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key"><label for="middle_name"><?php echo JText::_('JL_ADMIN_LEAGUE_MIDDLE_NAME'); ?></label></td>
			<td>
				<input class="text_area" type="text" name="middle_name" id="title" size="32" maxlength="25" value="<?php echo $this->object->middle_name; ?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key"><label for="short_name"><?php echo JText::_('JL_ADMIN_LEAGUE_SHORT_NAME'); ?></label></td>
			<td>
				<input class="text_area" type="text" name="short_name" id="title" size="32" maxlength="15" value="<?php echo $this->object->short_name; ?>" />
			</td>
		</tr>		
		<tr>
			<td width="100" align="right" class="key"><label for="alias"><?php echo JText::_('JL_ADMIN_LEAGUE_ALIAS'); ?></label></td>
			<td>
				<input class="text_area" type="text" name="alias" id="alias" size="32" maxlength="75" value="<?php echo $this->object->alias; ?>" />
			</td>
		</tr>
		<tr>
			<td valign="top" align="right" class="key"><label for="ordering"><?php echo JText::_('JL_ADMIN_LEAGUE_COUNTRY'); ?></label></td>
			<td><?php echo $this->lists['countries']; ?>&nbsp;<?php echo Countries::getCountryFlag($this->object->country); ?>&nbsp;(<?php echo $this->object->country; ?>)</td>
		</tr>
		
		<tr>
			<td width="100" align="right" class="key"><label for="league_level"><?php echo JText::_('JL_ADMIN_LEAGUE_LEVEL'); ?></label></td>
			<td>
				<input class="text_area" type="text" name="league_level" id="league_level" size="32" maxlength="75" value="<?php echo $this->object->league_level; ?>" />
			</td>
		</tr>

		<tr>
			<td width="100" align="right" class="key"><label for="founded_year"><?php echo JText::_('JL_ADMIN_LEAGUE_FOUNDED_YEAR'); ?></label></td>
			<td>
				<input class="text_area" type="text" name="founded_year" id="founded_year" size="32" maxlength="75" value="<?php echo $this->object->founded_year; ?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key"><label for="folded_year"><?php echo JText::_('JL_ADMIN_LEAGUE_FOLDED_YEAR'); ?></label></td>
			<td>
				<input class="text_area" type="text" name="folded_year" id="folded_year" size="32" maxlength="75" value="<?php echo $this->object->folded_year; ?>" />
			</td>
		</tr>
    
    <tr>
			<td valign="top" align="right" class="key"><label for="ordering"><?php echo JText::_('JL_ADMIN_LEAGUE_ASSOCIATIONS'); ?></label></td>
			<td><?php echo $this->lists['associations']; ?></td>
		</tr>
        		
		<tr>
			<td valign="top" align="right" class="key"><label for="ordering"><?php echo JText::_('JL_ADMIN_LEAGUE_ORDERING'); ?></label></td>
			<td><?php echo $this->lists['ordering']; ?></td>
		</tr>
	</table>
</fieldset>