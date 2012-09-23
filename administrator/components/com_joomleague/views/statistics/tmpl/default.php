<?php defined('_JEXEC') or die('Restricted access');

//Ordering allowed ?
$ordering=($this->lists['order'] == 'obj.ordering');

JHTML::_('behavior.tooltip');
?>
<form action="<?php echo $this->request_url; ?>" method="post" name="adminForm">
	<table>
		<tr>
			<td align="left" width="100%">
				<?php
				echo JText::_('JL_GLOBAL_FILTER');
				?>&nbsp;<input	type="text" name="search" id="search"
								value="<?php echo $this->lists['search']; ?>"
								class="text_area" onchange="document.adminForm.submit(); " />
				<button onclick="this.form.submit(); "><?php echo JText::_('JL_GLOBAL_GO'); ?></button>
				<button onclick="document.getElementById('search').value='';this.form.submit(); "><?php echo JText::_('JL_GLOBAL_RESET'); ?></button>
			</td>
			<td nowrap='nowrap' align='right'><?php echo $this->lists['sportstypes'].'&nbsp;&nbsp;'; ?></td>
			<td nowrap="nowrap"><?php echo $this->lists['state']; ?></td>
		</tr>
	</table>
	<div id="editcell">
		<table class="adminlist" border="0">
			<thead>
				<tr>
					<th width="5" style="vertical-align: top; "><?php echo JText::_('JL_GLOBAL_NUM'); ?></th>
					<th width="20" style="vertical-align: top; ">
						<input  type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
					</th>
					<th width="20" style="vertical-align: top; ">&nbsp;</th>
					<th class="title" nowrap="nowrap" style="vertical-align: top; ">
						<?php
						echo JHTML::_('grid.sort','JL_ADMIN_STATISTICS_NAME','obj.name',$this->lists['order_Dir'],$this->lists['order']);
						?>
					</th>
					<th class="title" width="20" nowrap="nowrap" style="vertical-align: top; ">
						<?php
						echo JHTML::_('grid.sort','JL_ADMIN_STATISTICS_ABBREV','obj.short',$this->lists['order_Dir'],$this->lists['order']);
						?>
					</th>
					<th width="10%" class="title" style="vertical-align: top; ">
						<?php
						echo JHTML::_('grid.sort','JL_ADMIN_STATISTICS_ICON','obj.icon',$this->lists['order_Dir'],$this->lists['order']);
						?>
					</th>
					<th width="10%" class="title" style="vertical-align: top; ">
						<?php
						echo JHTML::_('grid.sort','JL_ADMIN_STATISTICS_SPORTSTYPE','obj.sports_type_id',$this->lists['order_Dir'],$this->lists['order']);
						?>
					</th>
					<th class="title" style="vertical-align: top; "><?php echo JText::_('JL_ADMIN_STATISTICS_NOTE'); ?></th>
					<th class="1%" style="vertical-align: top; "><?php echo JText::_('JL_ADMIN_STATISTICS_TYPE'); ?></th>
					<th width="1%" nowrap="nowrap" style="vertical-align: top; ">
						<?php
						echo JHTML::_('grid.sort','JL_GLOBAL_PUBLISHED','obj.published',$this->lists['order_Dir'],$this->lists['order']);
						?>
					</th>
					<th width="85" nowrap="nowrap" style="vertical-align: top; ">
						<?php echo JHTML::_('grid.sort','JL_GLOBAL_ORDER','obj.ordering',$this->lists['order_Dir'],$this->lists['order']); ?>
						<?php echo JHTML::_('grid.order',$this->items); ?>
					</th>

					<th style="vertical-align: top; ">
						<?php echo JHTML::_('grid.sort','JL_GLOBAL_ID','obj.id',$this->lists['order_Dir'],$this->lists['order']); ?>
					</th>
				</tr>
			</thead>
			<tfoot><tr><td colspan="12"><?php echo $this->pagination->getListFooter(); ?></td></tr></tfoot>
			<tbody>
				<?php
				$k=0;
				for ($i=0,$n=count($this->items); $i < $n; $i++)
				{
					$row =& $this->items[$i];
					$link=JRoute::_('index.php?option=com_joomleague&controller=statistic&task=edit&cid[]='.$row->id);
					$checked=JHTML::_('grid.checkedout',$row,$i);
					$published=JHTML::_('grid.published',$row,$i);
					?>
					<tr class="<?php echo "row$k"; ?>">
						<td><?php echo $this->pagination->getRowOffset($i); ?></td>
						<td><?php echo $checked; ?></td>
						<?php
						if (JTable::isCheckedOut($this->user->get('id'),$row->checked_out))
						{
							?><td style="text-align:center; "><?php echo $row->name; ?></td><?php
						}
						else
						{
							?><td style="text-align:center; ">
								<a href="<?php echo $link; ?>">
									<img src="<?php echo JURI::root();?>/administrator/components/com_joomleague/assets/images/edit.png"
										 border="0"
										 alt="<?php echo JText::_('JL_ADMIN_STATISTICS_EDIT_DETAILS');?>"
										 title="<?php echo JText::_('JL_ADMIN_STATISTICS_EDIT_DETAILS');?>" />
								</a>
							</td><?php
						}
						?>
						<td><?php echo $row->name; ?></td>
						<td><?php echo $row->short; ?></td>
						<td style="text-align:center; ">
							<?php
							$picture=JPATH_SITE.DS.$row->icon;
							$desc=JText::_($row->name);
							echo JoomleagueHelper::getPictureThumb($picture, $desc, 0, 21, 4);
							?>
						</td>
						<td style="text-align:center; ">
							<?php
							echo JText::_(JoomleagueHelper::getSportsTypeName($row->sports_type_id));
							?>
						</td>
						<td><?php echo $row->note; ?></td>
						<td><?php echo JText::_($row->class); ?></td>
						<td style="text-align:center; "><?php echo $published; ?>
						</td>
						<td class="order">
							<span><?php echo $this->pagination->orderUpIcon($i,$i > 0,'orderup','JL_GLOBAL_ORDER_UP',true); ?></span>
							<span><?php echo $this->pagination->orderDownIcon($i,$n,$i < $n,'orderdown','JL_GLOBAL_ORDER_DOWN',true); ?>
									<?php $disabled=true ?  '' : 'disabled="disabled"'; ?></span>
							<input  type="text" name="order[]" size="5"
									value="<?php echo $row->ordering; ?>" <?php echo $disabled; ?>
									class="text_area" style="text-align: center" />
						</td>
						<td style="text-align:center; "><?php echo $row->id; ?></td>
					</tr>
					<?php
					$k=1 - $k;
				}
				?>
			</tbody>
		</table>
	</div>
	<input type="hidden" name="sitename"			value="<?php echo $this->config->getValue('config.sitename'); ?>" />
	<input type="hidden" name="controller"			value="statistic" />
	<input type="hidden" name="task"				value="" />
	<input type="hidden" name="boxchecked"			value="0" />
	<input type="hidden" name="filter_order"		value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir"	value="" />
	<?php echo JHTML::_('form.token'); ?>
</form>