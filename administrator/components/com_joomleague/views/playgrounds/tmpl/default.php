<?php defined('_JEXEC') or die('Restricted access');

//Ordering allowed ?
$ordering=($this->lists['order'] == 'v.ordering');

JHTML::_('behavior.tooltip');
?>
<script language="javascript">

	function searchPlayground(val,key)
	{
		var f=document.adminForm;
		if(f)
		{
		f.elements['search'].value=val;
		f.elements['search_mode'].value= 'matchfirst';
		f.submit();
		}
	}

</script>
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
			<td align="center" colspan="4">
				<?php for ($i=65; $i < 91; $i++){printf("<a href=\"javascript:searchPlayground('%s')\">%s</a>&nbsp;&nbsp;&nbsp;&nbsp;",chr($i),chr($i));} ?>
			</td>
		</tr>
	</table>
	<div id="editcell">
		<table class="adminlist">
			<thead>
				<tr>
					<th width="5" style="vertical-align: top; "><?php echo JText::_('JL_GLOBAL_NUM'); ?></th>
					<th width="20" style="vertical-align: top; ">
						<input  type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
					</th>
					<th width="20" style="vertical-align: top; ">&nbsp;</th>
					<th class="title" nowrap="nowrap" style="vertical-align: top; ">
						<?php
						echo JHTML::_('grid.sort','JL_ADMIN_PLAYGROUNDS_NAME','v.name',$this->lists['order_Dir'],$this->lists['order']);
						?>
					</th>
					<th class="title" style="vertical-align: top; ">
						<?php
						echo JHTML::_('grid.sort','JL_ADMIN_PLAYGROUNDS_S_NAME','v.short_name',$this->lists['order_Dir'],$this->lists['order']);
						?>
					</th>
					<th class="title" nowrap="nowrap" style="vertical-align: top; ">
						<?php
						echo JHTML::_('grid.sort','JL_ADMIN_PLAYGROUNDS_CLUBNAME','club',$this->lists['order_Dir'],$this->lists['order']);
						?>
					</th>
					<th class="title" style="vertical-align: top; ">
						<?php
						echo JHTML::_('grid.sort','JL_ADMIN_PLAYGROUNDS_CAPACITY','v.max_visitors',$this->lists['order_Dir'],$this->lists['order']);
						?>
					</th>
					<th class="title" style="vertical-align: top; ">
						<?php
						echo JHTML::_('grid.sort','JL_ADMIN_PLAYGROUNDS_IMAGE','v.picture',$this->lists['order_Dir'],$this->lists['order']);
						?>
					</th>
					<th width="85" nowrap="nowrap">
						<?php
						echo JHTML::_('grid.sort','JL_GLOBAL_ORDER','v.ordering',$this->lists['order_Dir'],$this->lists['order']);
						echo '<br />';
						echo JHTML::_('grid.order',$this->items);
						?>
					</th>
					<th style="vertical-align: top; ">
						<?php echo JHTML::_('grid.sort','JL_GLOBAL_ID','v.id',$this->lists['order_Dir'],$this->lists['order']); ?>
					</th>
				</tr>
			</thead>
			<tfoot><tr><td colspan="10"><?php echo $this->pagination->getListFooter(); ?></td></tr></tfoot>
			<tbody>
				<?php
				$k=0;
				for ($i=0,$n=count($this->items); $i < $n; $i++)
				{
					$row =& $this->items[$i];
					$link=JRoute::_('index.php?option=com_joomleague&controller=playground&task=edit&cid[]='.$row->id);
					$checked=JHTML::_('grid.checkedout',$row,$i);
					?>
					<tr class="<?php echo "row$k"; ?>">
						<td style="text-align:center; "><?php echo $this->pagination->getRowOffset($i); ?></td>
						<td style="text-align:center; "><?php echo $checked; ?></td>
						<?php
						if (JTable::isCheckedOut($this->user->get('id'),$row->checked_out))
						{
							$inputappend=' disabled="disabled" ';
							?><td style="text-align:center; ">&nbsp;</td><?php
						}
						else
						{
							$inputappend='';
							?>
							<td style="text-align:center; ">
								<a href="<?php echo $link; ?>">
									<?php
									$imageTitle=JText::_('JL_ADMIN_PLAYGROUNDS_EDIT_DETAILS');
									echo JHTML::_(	'image','administrator/components/com_joomleague/assets/images/edit.png',
													$imageTitle,'title= "'.$imageTitle.'"');
									?>
								</a>
							</td>
							<?php
						}
						?>
						<td><?php echo $row->name; ?></td>
						<td style="text-align:center; "><?php echo $row->short_name; ?></td>
						<td><?php echo $row->club; ?></td>
						<td style="text-align:center; "><?php echo $row->max_visitors; ?></td>
						<td width="5%" style="text-align:center; ">
							<?php
							if ($row->picture == '')
							{
								$imageTitle=JText::_('JL_ADMIN_PLAYGROUNDS_NO_IMAGE');
								echo JHTML::_('image','administrator/components/com_joomleague/assets/images/delete.png',
												$imageTitle,'title= "'.$imageTitle.'"');

							}
							elseif($row->picture == JoomleagueHelper::getDefaultPlaceholder("team"))
								{
									$imageTitle=JText::_('JL_ADMIN_PLAYGROUNDS_DEFAULT_IMAGE');
									echo JHTML::_(	'image','/administrator/components/com_joomleague/assets/images/information.png',
													$imageTitle,'title= "'.$imageTitle.'"');
								}
								elseif($row->picture !== '')
									{
										$imageTitle=JText::_('JL_ADMIN_PLAYGROUNDS_CUSTOM_IMAGE');
										echo JHTML::_('image','administrator/components/com_joomleague/assets/images/ok.png',
														$imageTitle,'title= "'.$imageTitle.'"');
									}
									?>
						</td>
						<td class="order">
							<span>
								<?php echo $this->pagination->orderUpIcon($i,$i > 0,'orderup','JL_GLOBAL_ORDER_UP',true); ?>
							</span>
							<span>
								<?php echo $this->pagination->orderDownIcon($i,$n,$i < $n,'orderdown','JL_GLOBAL_ORDER_DOWN',true); ?>
								<?php $disabled=true ?  '' : 'disabled="disabled"'; ?>
							</span>
							<input  type="text" name="order[]" size="5" value="<?php echo $row->ordering;?>" <?php echo $disabled ?>
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

	<input type="hidden" name="sitename" value="<?php echo $this->config->getValue('config.sitename'); ?>" />
	<input type="hidden" name="controller" value="playground" />
	<input type="hidden" name="search_mode" value="<?php echo $this->lists['search_mode']; ?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="" />
	<?php echo JHTML::_('form.token')."\n"; ?>
</form>