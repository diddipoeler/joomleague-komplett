<?php defined('_JEXEC') or die('Restricted access');
jimport('joomla.filesystem.file');
$this->addTemplatePath(JPATH_COMPONENT.DS.'views'.DS.'adminmenu');
?>
<script language="javascript">

	function searchPerson(val)
	{
		var f=document.adminForm;
		if(f)
		{
			f.elements['search'].value=val;
			f.elements['search_mode'].value= 'matchfirst';
			f.submit();
		}
	}

	function onupdatebirthday(cal)
	{
		$($(cal.params.inputField).getProperty('cb')).setProperty('checked','checked');
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
				<button onclick="document.getElementById('search').value='';this.form.submit(); ">
					<?php
					echo JText::_('JL_GLOBAL_RESET');
					?>
				</button>
			</td>
			<td align="center" colspan="4">
				<?php
				for ($i=65; $i < 91; $i++)
				{
					printf("<a href=\"javascript:searchPerson('%s')\">%s</a>&nbsp;&nbsp;&nbsp;&nbsp;",chr($i),chr($i));
				}
				?>
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
						echo JHTML::_('grid.sort','JL_ADMIN_PERSONS_F_NAME','pl.firstname',$this->lists['order_Dir'],$this->lists['order']);
						?>
					</th>
					<th class="title" nowrap="nowrap" style="vertical-align: top; ">
						<?php
						echo JHTML::_('grid.sort','JL_ADMIN_PERSONS_N_NAME','pl.nickname',$this->lists['order_Dir'],$this->lists['order']);
						?>
					</th>
					<th class="title" nowrap="nowrap" style="vertical-align: top; ">
						<?php
						echo JHTML::_('grid.sort','JL_ADMIN_PERSONS_L_NAME','pl.lastname',$this->lists['order_Dir'],$this->lists['order']);
						?>
					</th>
					<th class="title" nowrap="nowrap" style="vertical-align: top; "><?php echo JText::_('JL_ADMIN_PERSONS_IMAGE'); ?>
					</th>
					<th class="title" nowrap="nowrap" style="vertical-align: top; ">
						<?php
						echo JHTML::_('grid.sort','JL_ADMIN_PERSONS_BIRTHDAY','pl.birthday',$this->lists['order_Dir'],$this->lists['order']);
						?>
					</th>
					<th class="title" nowrap="nowrap" style="vertical-align: top; ">
						<?php
						echo JHTML::_('grid.sort','JL_ADMIN_PERSONS_NATIONALITY','pl.country',$this->lists['order_Dir'],$this->lists['order']);
						?>
					</th>
					<th class="title" nowrap="nowrap" style="vertical-align: top; ">
						<?php
						echo JHTML::_('grid.sort','JL_ADMIN_PERSONS_POSITION','pl.position_id',$this->lists['order_Dir'],$this->lists['order']);
						?>
					</th>
					<th class="title" nowrap="nowrap" style="vertical-align: top; ">
					<?php
						echo JHTML::_('grid.sort','JL_GLOBAL_PUBLISHED','pl.published',$this->lists['order_Dir'],$this->lists['order']);
						?>
					</th>
					<th nowrap="nowrap" style="vertical-align: top; ">
						<?php
						echo JHTML::_('grid.sort','JL_GLOBAL_ID','pl.id',$this->lists['order_Dir'],$this->lists['order']);
						?>
					</th>
				</tr>
			</thead>
			<tfoot><tr><td colspan='12'><?php echo $this->pagination->getListFooter(); ?></td></tr></tfoot>
			<tbody>
				<?php
				$k=0;
				for ($i=0,$n=count($this->items); $i < $n; $i++)
				{
					$row=&$this->items[$i];
					if (($row->firstname != '!Unknown') && ($row->lastname != '!Player')) // Ghostplayer for match-events
					{
						$link       = JRoute::_('index.php?option=com_joomleague&controller=person&task=edit&cid[]='.$row->id);
						$checked    = JHTML::_('grid.checkedout',$row,$i);
						$is_checked = JTable::isCheckedOut($this->user->get('id'),$row->checked_out);
                                                $published  = JHTML::_('grid.published',$row,$i);
						?>
						<tr class="<?php echo "row$k"; ?>">
							<td style="text-align:center; "><?php echo $this->pagination->getRowOffset($i); ?></td>
							<td style="text-align:center; "><?php echo $checked; ?></td>
							<?php
							if ($is_checked)
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
										$imageTitle=JText::_('JL_ADMIN_PERSONS_EDIT_DETAILS');
										echo JHTML::_(	'image','administrator/components/com_joomleague/assets/images/edit.png',
														$imageTitle,'title= "'.$imageTitle.'"');
										?>
									</a>
								</td>
								<?php
							}
							?>
							<td style="text-align:center; ">
								<input	<?php echo $inputappend; ?> type="text" size="15"
										class="inputbox" name="firstname<?php echo $row->id; ?>"
										value="<?php echo stripslashes(htmlspecialchars($row->firstname)); ?>"
										onchange="document.getElementById('cb<?php echo $i; ?>').checked=true" />
							</td>
							<td style="text-align:center; ">
								<input	<?php echo $inputappend; ?> type="text" size="15"
										class="inputbox" name="nickname<?php echo $row->id; ?>"
										value="<?php echo stripslashes(htmlspecialchars($row->nickname)); ?>"
										onchange="document.getElementById('cb<?php echo $i; ?>').checked=true" />
							</td>
							<td style="text-align:center; ">
								<input	<?php echo $inputappend; ?> type="text" size="15"
										class="inputbox" name="lastname<?php echo $row->id; ?>"
										value="<?php echo stripslashes(htmlspecialchars($row->lastname)); ?>"
										onchange="document.getElementById('cb<?php echo $i; ?>').checked=true" />
							</td>
							<td style="text-align:center; ">
								<?php
								if (empty($row->picture) || !JFile::exists(JPATH_SITE.DS.$row->picture))
								{
									$imageTitle=JText::_('JL_ADMIN_PERSONS_NO_IMAGE').$row->picture;
									echo JHTML::_(	'image','administrator/components/com_joomleague/assets/images/delete.png',
													$imageTitle,'title= "'.$imageTitle.'"');
								}
								elseif ($row->picture == JoomleagueHelper::getDefaultPlaceholder("player"))
								{
									$imageTitle=JText::_('JL_ADMIN_PERSONS_DEFAULT_IMAGE');
									echo JHTML::_(	'image','administrator/components/com_joomleague/assets/images/information.png',
													$imageTitle,'title= "'.$imageTitle.'"');
								}
								else
								{
									$playerName = JoomleagueHelper::formatName(null ,$row->firstname, $row->nickname, $row->lastname, 0);
									echo JoomleagueHelper::getPictureThumb($row->picture, $playerName, 0, 21, 4);
								}
								?>
							</td>
							<td nowrap="nowrap" style="text-align:center; ">
								<?php
								$append='';
								if ($row->birthday == '0000-00-00')
								{
									$append=' style="background-color:#FFCCCC;"';
								}
								if ($is_checked)
								{
									echo $row->birthday;
								}
								else
								{
									echo $this->calendar(	JoomleagueHelper::convertDate($row->birthday),
															'birthday'.$row->id,
															'birthday'.$row->id,
															'%d-%m-%Y',
															'size="10" '.$append.' cb="cb'.$i.'"',
															'onupdatebirthday',
															$i);
								}
								?>
							</td>
							<td nowrap="nowrap" style="text-align:center; ">
								<?php
								$append='';
								if (empty($row->country)){$append=' background-color:#FFCCCC;';}
								echo JHTMLSelect::genericlist(	$this->lists['nation'],
																'country'.$row->id,
																$inputappend.' class="inputbox" style="width:140px; '.$append.'" onchange="document.getElementById(\'cb'.$i.'\').checked=true"',
																'value',
																'text',
																$row->country);
								?>
							</td>
							<td nowrap="nowrap" style="text-align:center; ">
								<?php
								$append='';
								if (empty($row->position_id)){$append=' background-color:#bbffff;';}
								echo JHTMLSelect::genericlist(	$this->lists['positions'],
																'position'.$row->id,
																$inputappend.'class="inputbox" style="width:140px; '.$append.'" onchange="document.getElementById(\'cb'.$i.'\').checked=true"',
																'value',
																'text',
																$row->position_id);
								?>
							</td>
							<td style="text-align:center; "><?php echo $published; ?></td>
							<td style="text-align:center; "><?php echo $row->id; ?></td>
						</tr>
						<?php
						$k=1 - $k;
					}
				}
				?>
			</tbody>
		</table>
	</div>
	<input type="hidden" name="sitename" value="<?php echo $this->config->getValue('config.sitename'); ?>" />
	<input type="hidden" name="controller" value="person" />
	<input type="hidden" name="search_mode" value="<?php echo $this->lists['search_mode'];?>" id="search_mode" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="" />
	<?php echo JHTML::_('form.token')."\n"; ?>
</form>