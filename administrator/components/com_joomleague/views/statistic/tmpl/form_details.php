<?php defined('_JEXEC') or die('Restricted access');
?>
		<fieldset class="adminform">
			<legend>
				<?php
				echo JText::_( 'JL_ADMIN_STAT_STAT' );
				?>
			</legend>
			<table class="admintable">
				<tr>
					<td width="100" align="right" class="key"><label for="name"><?php echo JText::_('JL_GLOBAL_SPORTS_TYPE'); ?></label></td>
					<td><?php echo $this->lists['sports_type']; ?></td>
				</tr>
				<tr>
					<td width="250" align="right" class="key">
						<label for="name">
							<?php
							echo JText::_( 'JL_ADMIN_STAT_NAME' );
							?>
						</label>
					</td>
					<td>
						<input  class="text_area" type="text" name="name" id="title" size="32" maxlength="250"
								value="<?php echo $this->item->name; ?>" />
					</td>
				</tr>
				<tr>
					<td width="250" align="right" class="key">
						<label for="short">
							<?php
							echo JText::_( 'JL_ADMIN_STAT_ABBREV' );
							?>
						</label>
					</td>
					<td>
						<input  class="text_area" type="text" name="short" id="title" size="10" maxlength="10"
								value="<?php echo $this->item->short; ?>" />
					</td>
				</tr>
				<tr>
					<td width="100" align="right" class="key">
						<label for="alias">
							<?php	echo JText::_( 'JL_ADMIN_STAT_ALIAS' );	?>
						</label>
					</td>
					<td>
						<input class="text_area" type="text" name="alias" id="alias" size="32" maxlength="75"	value="<?php echo $this->item->alias; ?>" />
					</td>
				</tr>
				<tr>
					<td width="250" align="right" class="key">
						<label for="class">
							<?php
							echo JText::_( 'JL_ADMIN_STAT_TYPE' );
							?>
						</label>
					</td>
					<td>
						<?php if ($this->edit): ?>
						<?php echo $this->item->class; ?>
						<?php else: ?>
						<?php echo $this->lists['class']; ?>
						<?php endif; ?>
					</td>
				</tr>
				<tr>
		  			<td valign="top" align="right" class="key">
		   				<label for="ordering">
			  				<?php
			  				echo JText::_( 'JL_ADMIN_STAT_ORDERING' );
			  				?>
						</label>
		  			</td>
		  			<td>
						<?php
						echo $this->lists['ordering'];
						?>
		  			</td>
				</tr>
				<tr>
		  			<td valign="top" align="right" class="key">
		   				<label for="note">
			  				<?php
			  				echo JText::_( 'JL_ADMIN_STAT_NOTE' );
			  				?>
						</label>
		  			</td>
		  			<td>
							<input type="text" id="note" name="note" value="<?php echo $this->item->note; ?>" size="100"/>
		  			</td>
				</tr>
	    			
			</table>
		</fieldset>