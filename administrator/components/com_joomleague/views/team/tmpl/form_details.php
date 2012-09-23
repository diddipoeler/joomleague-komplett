<?php defined('_JEXEC') or die('Restricted access');
?>	
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'JL_ADMIN_TEAM' ); ?></legend>

		<table class="admintable">
		<tr>
			<td width="100" align="right" class="key">
				<label for="name">
					<?php echo JText::_( 'JL_ADMIN_TEAM_NAME' ); ?>:
				</label>
			</td>
			<td>
				<input class="text_area" type="text" name="name" id="title" size="32" maxlength="250" value="<?php echo $this->team->name?>" />
			</td>
		</tr>
		
		<tr>
			<td width="100" align="right" class="key">
				<label for="alias">
					<?php	echo JText::_( 'JL_ADMIN_TEAM_ALIAS' );	?>
				</label>
			</td>
			<td>
				<input class="text_area" type="text" name="alias" id="alias" size="32" maxlength="75"	value="<?php echo $this->team->alias; ?>" />
			</td>
		</tr>
				
		<tr>
      			<td valign="top" align="right" class="key">
       				<label for="ordering">
          				<?php echo JText::_( 'JL_ADMIN_TEAM_ORDERING' ); ?>:
        			</label>
      			</td>
      			<td>
        			<?php echo $this->lists['ordering']; ?>
      			</td>
		</tr>
		<tr>
			<td valign="top" align="right" class="key">
				<label for="middle_name">
					<?php echo JText::_( 'JL_ADMIN_TEAM_MID_NAME' ); ?>:
				</label>
			</td>
			<td>
				<input class="text_area" type="text" name="middle_name" id="title" size="15" maxlength="25" value="<?php echo $this->team->middle_name; ?>" />
			</td>
		</tr>
		<tr>
			<td valign="top" align="right" class="key">
				<label for="short_name">
					<?php echo JText::_( 'JL_ADMIN_TEAM_SHORT_NAME' ); ?>:
				</label>
			</td>
			<td>
				<input class="text_area" type="text" name="short_name" id="title" size="5" maxlength="15" value="<?php echo $this->team->short_name; ?>" />
			</td>
		</tr>
				<tr>
			<td width="100" align="right" class="key">
				<label for="website">
					<?php echo JText::_( 'JL_ADMIN_TEAM_WEBSITE' ); ?>:
				</label>
			</td>
			<td>
				<input class="text_area" type="text" name="website" id="title" size="32" maxlength="250" value="<?php echo $this->team->website; ?>" />
			</td>
		</tr>
		<tr>
			<td valign="top" align="right" class="key">
				<label for="description">
					<?php echo JText::_( 'JL_ADMIN_TEAM_INFO' ); ?>:
				</label>
			</td>
			<td>
				<input class="text_area" type="text" name="info" id="title" size="50" maxlength="250" value="<?php echo $this->team->info; ?>" />
			</td>
		</tr>
		<tr>
			<td valign="top" align="right" class="key">
				<label for="club">
					<?php echo JText::_( 'JL_ADMIN_TEAM_CLUB' ); ?>:
				</label>
			</td>
			<td>
				<?php echo $this->lists['clubs']; ?>
			</td>
		</tr>

		</table>
</fieldset>