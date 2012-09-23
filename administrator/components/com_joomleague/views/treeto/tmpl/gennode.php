<?php defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.tooltip');

	JToolBarHelper::title(JText::_('JL_ADMIN_TREETO_TITLE_GENERATE'));

	JToolBarHelper::back('Back','index.php?option=com_joomleague&view=treetos&controller=treeto');
	JToolBarHelper::help('screen.joomleague', true);

?>
	<fieldset class="adminform">
		<legend>
			<?php
			echo JText::_(	'JL_ADMIN_TREETOS_TITLE_GENERATENODE' );
			?>
		</legend>
		<table border='0'>

			<form name="generatenode" method="post" style="display:inline">

			<input type="hidden" name="option"		value="com_joomleague" />
			<input type="hidden" name="controller"		value="treeto" />
			<input type="hidden" name="project_id" 		value='<?php echo $this->projectws->id; ?>' />
			<input type="hidden" name="id" 			value='<?php echo $this->treeto->id; ?>' />
			<input type="hidden" name="task"		value="generatenode" />
			
			<input type="hidden" name="tree_i"		id="tree_i" />

				<tr>
					<td valign="top" align="right">
					<?php echo JText::_( 'JL_ADMIN_TREETO_INDEX' ); ?>
					</td>
					<td>
					<select id ="tree_i" name="tree_i" class="inputbox">
						<option value="0" selected="selected">
							<?php
							echo JText::_( 'JL_ADMIN_TREETO_CHOOSE' );
							?>
						</option>
						<option value="1">
							<?php
							echo JText::_( 'JL_ADMIN_TREETO_INDEX1' );
							?>
						</option>
						<option value="2">
							<?php
							echo JText::_( 'JL_ADMIN_TREETO_INDEX2' );
							?>
						</option>
						<option value="3">
							<?php
							echo JText::_( 'JL_ADMIN_TREETO_INDEX3' );
							?>
						</option>
						<option value="4">
							<?php
							echo JText::_( 'JL_ADMIN_TREETO_INDEX4' );
							?>
						</option>
						<option value="5">
							<?php
							echo JText::_( 'JL_ADMIN_TREETO_INDEX5' );
							?>
						</option>
						<option value="6">
							<?php
							echo JText::_( 'JL_ADMIN_TREETO_INDEX6' );
							?>
						</option>
					</select>
					</td>
					<td>
					</td>
					<td>
					<input type="submit" value="<?php echo JText::_( 'JL_ADMIN_TREETO_GENERATE'); ?>" />
					</td>
				</tr>
				<?php echo JHTML::_( 'form.token' ); ?>
			</form>
		</table>
	</fieldset>
