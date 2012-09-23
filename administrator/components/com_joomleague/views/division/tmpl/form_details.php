<?php defined('_JEXEC') or die('Restricted access');
?>
		<fieldset class="adminform">
			<legend>
				<?php
				echo JText::_( 'JL_DIVISION_DIVISION' );
				?>
			</legend>

			<table class="admintable">
				<tr>
					<td width="100" align="right" class="key">
						<label for="name">
							<?php
							echo JText::_( 'JL_DIVISION_NAME' );
							?>:
						</label>
					</td>
					<td>
						<input	class="text_area" type="text" name="name" id="title" size="32" maxlength="250"
								value="<?php echo $this->division->name; ?>" />
					</td>
				</tr>
		
				<tr>
					<td width="100" align="right" class="key">
						<label for="alias">
							<?php	echo JText::_( 'JL_DIVISION_ALIAS' );	?>
						</label>
					</td>
					<td>
						<input class="text_area" type="text" name="alias" id="alias" size="32" maxlength="75"	value="<?php echo $this->division->alias; ?>" />
					</td>
				</tr>
		
				<tr>
					<td valign="top" align="right" class="key">
		 				<label for="ordering">
							<?php
							echo JText::_( 'JL_DIVISION_ORDERING' );
							?>:
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
		 				<label for="ordering">
							<?php
							echo JText::_( 'JL_DIVISION_S_NAME' );
							?>:
						</label>
					</td>
					<td>
						<input	class="text_area" type="text" name="shortname" id="title" size="32" maxlength="250"
						value="<?php echo $this->division->shortname; ?>" />
					</td>
				</tr>
				<tr>
					<td valign="top" align="right" class="key">
						<?php
						echo JText::_( 'JL_DIVISION_PARENT' );
						?>:
					</td>
					<td>
						<?php
						echo $this->lists['parents'];
						?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="right" class="key">
		 				<label for="ordering">
							<?php
							echo JText::_( 'JL_DIVISION_DESCR' );
							?>:
						</label>
					</td>
					<td>
						<input	class="text_area" type="text" name="notes" id="title" size="32" maxlength="250"
						value="<?php echo $this->division->notes; ?>" />
					</td>
				</tr>
			</table>
		</fieldset>