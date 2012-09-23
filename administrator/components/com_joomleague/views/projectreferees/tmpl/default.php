<?php defined('_JEXEC') or die('Restricted access');

JToolBarHelper::title(JText::_('JL_ADMIN_PREF_TITLE'),'Referees');

JToolBarHelper::apply('saveshort',JText::_('JL_ADMIN_PREF_APPLY'));
JToolBarHelper::divider();

JToolBarHelper::custom('assign','upload.png','upload_f2.png',JText::_('JL_ADMIN_PREF_ASSIGN'),false);
JToolBarHelper::custom('unassign','cancel.png','cancel_f2.png',JText::_('JL_ADMIN_PREF_UNASSIGN'),false);
JToolBarHelper::divider();

JToolBarHelper::help('screen.joomleague',true);

//Ordering allowed ?
$ordering=($this->lists['order'] == 'p.ordering');

$this->addTemplatePath(JPATH_COMPONENT.DS.'views'.DS.'adminmenu');

JHTML::_('behavior.mootools');
?>
<style>
.search-item {
    font:normal 11px tahoma,arial,helvetica,sans-serif;
    padding:3px 10px 3px 10px;
    border:1px solid #fff;
    border-bottom:1px solid #eeeeee;
    white-space:normal;
    color:#555;
}
.search-item h3 {
    display:block;
    font:inherit;
    font-weight:bold;
    color:#222;
}

.search-item h3 span {
    float: right;
    font-weight:normal;
    margin:0 0 5px 5px;
    width:100px;
    display:block;
    clear:none;
}
</style>
<script language="javascript">

	var quickaddsearchurl = '<?php echo JURI::root();?>administrator/index.php?option=com_joomleague&controller=quickadd&task=searchreferee';

	function searchPlayer(val)
	{
		var f=document.adminForm;
		if(f)
		{
			f.elements['search'].value=val;
			f.elements['search_mode'].value='matchfirst';
			f.submit();
		}
	}
</script>
<?php
$uri=JURI::root();
?>
<fieldset class="adminform">
	<legend>
	<?php
	echo JText::_('JL_ADMIN_PROJECTREFEREES_QUICKADD_REFEREE');
	?>
	</legend>
	<form name="quickaddForm" action="<?php echo JURI::root(); ?>administrator/index.php?option=com_joomleague&controller=quickadd&task=addreferee" method="post">
	<input type="hidden" id="cpersonid" name="cpersonid" value="">
	<table>
		<tr>
			<td><?php echo JText::_('JL_ADMIN_PROJECTREFEREES_QUICKADD_DESCR');?>:</td>
			<td><input type="text" name="quickadd" id="quickadd"  size="50" /></td>
			<td><input type="submit" name="submit" id="submit" value="<?php echo JText::_('Add');?>" /></td>
		</tr>
	</table>
	<?php echo JHTML::_('form.token'); ?>
	</form>
</fieldset>
<form action="<?php echo $this->request_url; ?>" method="post" name="adminForm">
	<fieldset class="adminform">
		<legend>
			<?php
			echo JText::sprintf('JL_ADMIN_PREF_TITLE2','<i>'.$this->projectws->name.'</i>');
			?>
		</legend>
		<table>
			<tr>
				<td align="left" width="100%">
					<?php
					echo JText::_('JL_GLOBAL_FILTER');
					?>
					<input	type="text" name="search" id="search"
							value="<?php echo $this->lists['search']; ?>" class="text_area"
							onchange="document.getElementById('search_mode').value=''; document.adminForm.submit(); " />
					<button onclick="document.getElementById('search_mode').value=''; this.form.submit(); ">
						<?php
						echo JText::_('JL_GLOBAL_GO');
						?>
					</button>
					<button onclick="document.getElementById('search').value=''; document.getElementById('search_mode').value=''; this.form.submit(); ">
						<?php
						echo JText::_('JL_GLOBAL_RESET');
						?>
					</button>
				</td>
				<td align="center" colspan="4">
					<?php
					for ($i=65; $i < 91; $i++)
					{
						printf("<a href=\"javascript:searchPlayer('%s')\">%s</a>&nbsp;&nbsp;&nbsp;&nbsp;",chr($i),chr($i));
					}
					?>
				 </td>
			</tr>
		</table>
		<div id="editcell">
			<table class="adminlist">
				<thead>
					<tr>
						<th width="5" style="vertical-align: top; ">
							<?php
							echo JText::_('JL_GLOBAL_NUM');
							?>
						</th>
						<th width="20" style="vertical-align: top; ">
							<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
						</th>
						<th width="20" style="vertical-align: top; ">
							&nbsp;
						</th>
						<th class="title" nowrap="nowrap" style="vertical-align: top; ">
							<?php
							echo JHTML::_('grid.sort','JL_ADMIN_PREF_NAME','p.lastname',$this->lists['order_Dir'],$this->lists['order']);
							?>
						</th>
						<th width="20" style="vertical-align: top; ">
							<?php
							echo JText::_('JL_ADMIN_PREF_PID');
							?>
						</th>
						<th class="title" nowrap="nowrap" style="vertical-align: top; ">
							<?php
							echo JText::_('JL_ADMIN_PREF_IMAGE');
							?>
						</th>
						<th class="title" nowrap="nowrap" style="vertical-align: top; ">
							<?php
							echo JHTML::_('grid.sort',JText::_('JL_ADMIN_PREF_POS'),'pref.project_position_id',$this->lists['order_Dir'],$this->lists['order']);
							?>
						</th>
						<th class="title" nowrap="nowrap" style="vertical-align: top; ">
							<?php
							echo JHTML::_('grid.sort',JText::_('JL_ADMIN_PREF_PHONE'),'p.phone',$this->lists['order_Dir'],$this->lists['order']);
							?>
						</th>
						<th class="title" nowrap="nowrap" style="vertical-align: top; ">
							<?php
							echo JHTML::_('grid.sort',JText::_('JL_ADMIN_PREF_MOBILE'),'p.mobile',$this->lists['order_Dir'],$this->lists['order']);
							?>
						</th>
						<th class="title" nowrap="nowrap" style="vertical-align: top; ">
							<?php
							echo JHTML::_('grid.sort',JText::_('JL_ADMIN_PREF_EMAIL'),'p.email',$this->lists['order_Dir'],$this->lists['order']);
							?>
						</th>
						<th width="85" style="vertical-align: top; ">
							<?php
							echo JHTML::_('grid.sort',JText::_('JL_GLOBAL_ORDER'),'pref.ordering',$this->lists['order_Dir'],$this->lists['order']);
							echo '<br />';
							echo JHTML::_('grid.order',$this->items);
							?>
						</th>
						<th style="vertical-align: top; ">
							<?php
							echo JHTML::_('grid.sort','JL_GLOBAL_ID','p.id',$this->lists['order_Dir'],$this->lists['order']);
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
						$row =& $this->items[$i];
						$link=JRoute::_('index.php?option=com_joomleague&controller=projectreferee&task=edit&cid[]='.$row->id);
						$checked=JHTML::_('grid.checkedout',$row,$i);
						$inputappend='';
						?>
						<tr class="<?php echo "row$k"; ?>">
							<td style="text-align:center; ">
								<?php
								echo $this->pagination->getRowOffset($i);
								?>
							</td>
							<td style="text-align:center; ">
								<?php
								echo $checked;
								?>
							</td>
							<?php
							if (JTable::isCheckedOut($this->user->get('id'),$row->checked_out))
							{
								$inputappend=' disabled="disabled"';
								?>
								<td>
									&nbsp;
								</td>
								<?php
							}
							else
							{
								?>
								<td style="text-align:center; ">
									<a href="<?php echo $link; ?>">
										<?php
										$imageTitle=JText::_('JL_ADMIN_PREF_EDIT_DETAILS');
										echo JHTML::_(	'image','administrator/components/com_joomleague/assets/images/edit.png',
														$imageTitle,
														'title= "'.$imageTitle.'"');
										?>
									</a>
								</td>
								<?php
							}
							?>
							<td>
								<?php echo JoomleagueHelper::formatName(null, $row->firstname, $row->nickname, $row->lastname, 1) ?>
							</td>
							<td style="text-align:center; ">
								<?php
								echo $row->person_id;
								?>
							</td>
							<td style="text-align:center; ">
								<?php
								if ($row->picture == '')
								{
									$imageTitle=JText::_('JL_ADMIN_PREF_NO_IMAGE');
									echo JHTML::_(	'image',
													'administrator/components/com_joomleague/assets/images/delete.png',
													$imageTitle,
													'title= "'.$imageTitle.'"');

								}
								elseif ($row->picture == JoomleagueHelper::getDefaultPlaceholder("player"))
								{
										$imageTitle=JText::_('JL_ADMIN_PREF_DEFAULT_IMAGE');
										echo JHTML::_(	'image',
														'administrator/components/com_joomleague/assets/images/information.png',
														$imageTitle,
														'title= "'.$imageTitle.'"');
								}
								elseif ($row->picture == !'')
								{
									$playerName = JoomleagueHelper::formatName(null ,$row->firstname, $row->nickname, $row->lastname, 0);
									$picture=JPATH_SITE.DS.$row->picture;
									echo JoomleagueHelper::getPictureThumb($picture, $playerName, 0, 21, 4);
								}
								?>
							</td>
							<td style="text-align:center; ">
								<?php
								if ($row->project_position_id != 0)
								{
									$selectedvalue=$row->project_position_id;
									$append='';
								}
								else
								{
									$selectedvalue=0;
									$append=' style="background-color:#FFCCCC"';
								}

								if ($append != '')
								{
									?>
									<script language="javascript">document.getElementById('cb<?php echo $i; ?>').checked=true;</script>
									<?php
								}

								if ($row->project_position_id == 0)
								{
									$append=' style="background-color:#FFCCCC"';
								}

								echo JHTML::_('select.genericlist',
												$this->lists['project_position_id'],'project_position_id'.$row->id,
												$inputappend.'class="inputbox" size="1" onchange="document.getElementById(\'cb'.$i.'\').checked=true"'.$append,
												'value','text',$selectedvalue);
								?>
							</td>
							<td style="text-align:center; "><?php echo $row->phone; ?></td>
							<td style="text-align:center; "><?php echo $row->mobile; ?></td>
							<td style="text-align:center; "><?php echo '<a href="mailto:'.$row->email.'">'.$row->email.'</a>'; ?></td>
							<td class="order">
								<span>
									<?php
									echo $this->pagination->orderUpIcon($i,$i > 0,'orderup','JL_GLOBAL_ORDER_UP',true);
									?>
								</span>
								<span>
									<?php
									echo $this->pagination->orderDownIcon($i,$n,$i < $n,'orderdown','JL_GLOBAL_ORDER_DOWN',true);
									?>
								</span>
								<?php
								$disabled=true ?	'' : 'disabled="disabled"';
								?>
								<input	type="text" name="order[]" size="5"
										value="<?php echo $row->ordering; ?>" <?php echo $disabled; ?> class="text_area"
										style="text-align: center; " />
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
	</fieldset>
	<input type="hidden" name="controller"			value="projectreferee" />
	<input type="hidden" name="search_mode"			value="<?php echo $this->lists['search_mode'];?>" id="search_mode" />
	<input type="hidden" name="task"				value="" />
	<input type="hidden" name="boxchecked"			value="0" />
	<input type="hidden" name="filter_order"		value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir"	value="" />
	<?php echo JHTML::_('form.token'); ?>
</form>