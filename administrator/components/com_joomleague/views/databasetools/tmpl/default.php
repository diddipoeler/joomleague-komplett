<?php defined('_JEXEC') or die('Restricted access');

JHTML::_( 'behavior.tooltip' );
?>
<form action="<?php echo $this->request_url; ?>" method="post" name="adminForm">
	<div id="editcell">
		<table class="adminlist">
			<thead>
				<tr>
					<th class="title" nowrap="nowrap">
						<?php
						echo JText::_( 'JL_ADMIN_DBTOOLS_TOOL' );
						?>
					</th>
					<th class="title" nowrap="nowrap">
						<?php
						echo JText::_( 'JL_ADMIN_DBTOOLS_DESCR' );
						?>
					</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="2">
						<?php
						echo "&nbsp;";
						?>
					</td>
				</tr>
			</tfoot>
			<tbody>
				<tr>
					<td nowrap="nowrap" valign="top">
						<?php
						$link = JRoute::_( 'index.php?option=com_joomleague&controller=databasetool&task=optimize' );
						?>
						<a href="<?php echo $link; ?>" title="<?php echo JText::_( 'JL_ADMIN_DBTOOLS_OPTIMIZE2' ); ?>">
							<?php
							echo JText::_( 'JL_ADMIN_DBTOOLS_OPTIMIZE' );
							?>
						</a>
					</td>
					<td>
						<?php
						echo JText::_( "JL_ADMIN_DBTOOLS_OPTIMIZE_DESCR" );
						?>
					</td>
				</tr>

				<tr>
					<td nowrap="nowrap" valign="top">
						<?php
						$link = JRoute::_( 'index.php?option=com_joomleague&controller=databasetool&task=repair' );
						?>
						<a href="<?php echo $link; ?>" title="<?php echo JText::_( 'JL_ADMIN_DBTOOLS_REPAIR2' ); ?>">
							<?php
							echo JText::_( 'JL_ADMIN_DBTOOLS_REPAIR' );
							?>
						</a>
					</td>
					<td>
						<?php
						echo JText::_( "JL_ADMIN_DBTOOLS_REPAIR_DESCR" );
						?>
					</td>
				</tr>

			</tbody>
		</table>
	</div>

	<input type="hidden" name="controller" value="databasetool" />
	<input type="hidden" name="task" value="execute" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>