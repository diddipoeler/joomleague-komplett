<?php defined('_JEXEC') or die('Restricted access');
// Set toolbar items for the page
JToolBarHelper::title(JText::_('JL_ADMIN_TEMPLATES_TITLE'),'FrontendSettings');
JToolBarHelper::editListX();
JToolBarHelper::save();
if ($this->projectws->master_template)
{
	JToolBarHelper::deleteList();
}
else
{
	JToolBarHelper::custom('reset','restore','restore',JText::_('JL_GLOBAL_RESET'));
}
JToolBarHelper::divider();
JToolBarHelper::help('screen.joomleague',true);

//load navigation menu
$this->addTemplatePath(JPATH_COMPONENT.DS.'views'.DS.'adminmenu');
JHTML::_('behavior.tooltip');
$project_type=$this->projectws->project_type;
?>
<script language="javascript">

	function searchTemplate(val,key)
	{
		var f=document.adminForm;
		if(f){
			f.elements['search'].value=val;
			f.elements['search_mode'].value= 'matchfirst';
			f.submit();
		}
	}
</script>
<div id="editcell">
	<fieldset class="adminform">
		<legend><?php echo JText::sprintf('JL_ADMIN_TEMPLATES_LEGEND','<i>'.$this->projectws->name.'</i>'); ?></legend>
		<?php if ($this->projectws->master_template){echo $this->loadTemplate('import');} ?>
		<form action="<?php echo $this->request_url; ?>" method="post" name="adminForm">
			<table class="adminlist">
				<thead>
					<tr>
						<th width="5" style="vertical-align: top; "><?php echo JText::_('JL_GLOBAL_NUM'); ?></th>
						<th width="20" style="vertical-align: top; ">
							<input  type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->templates); ?>);" />
						</th>
						<th width="20" style="vertical-align: top; ">&nbsp;</th>
						<th class="title" nowrap="nowrap">
							<?php echo JHTML::_('grid.sort','JL_ADMIN_TEMPLATES_TEMPLATE','tmpl.template',$this->lists['order_Dir'],$this->lists['order']); ?>
						</th>
						<th class="title" nowrap="nowrap">
							<?php echo JHTML::_('grid.sort','JL_ADMIN_TEMPLATES_DESCR','tmpl.template',$this->lists['order_Dir'],$this->lists['order']); ?>
						</th>
						<th class="title" nowrap="nowrap">
							<?php echo JText::_('JL_ADMIN_TEMPLATES_TYPE'); ?>
						</th>
						<th style="vertical-align: top; ">
							<?php echo JHTML::_('grid.sort','JL_GLOBAL_ID','tmpl.id',$this->lists['order_Dir'],$this->lists['order']); ?>
						</th>
					</tr>
				</thead>
				<tfoot><tr><td colspan="9"><?php echo $this->pagination->getListFooter(); ?></td></tr></tfoot>
				<tbody>
					<?php
					$k=0;
					for ($i=0, $n=count($this->templates); $i < $n; $i++)
					{
						$row =& $this->templates[$i];
						$link1=JRoute::_('index.php?option=com_joomleague&controller=template&task=edit&cid[]='.$row->id);
						$checked=JHTML::_('grid.checkedout',$row,$i);
						?>
						<tr class="<?php echo "row$k"; ?>">
							<td style="text-align:center; "><?php echo $this->pagination->getRowOffset($i); ?></td>
							<td style="text-align:center; "><?php echo $checked; ?></td>
							<td style="text-align:center; "><?php
								$imageFile='administrator/components/com_joomleague/assets/images/edit.png';
								$imageTitle=JText::_('JL_ADMIN_TEMPLATES_EDIT_DETAILS');
								$imageParams='title= "'.$imageTitle.'"';
								$image=JHTML::image($imageFile,$imageTitle,$imageParams);
								$linkParams='';
								echo JHTML::link($link1,$image);
								?></td>
							<td style="text-align:left; "><?php echo $row->template; ?></td>
							<td style="text-align:left; white-space:nowrap; "><?php echo JText::_($row->title); ?></td>
							<td style="text-align:center; white-space:nowrap; "><?php
								echo '<span style="font-weigth:bold; color:';
								echo ($row->isMaster) ? 'red; ">'.JText::_('JL_ADMIN_TEMPLATES_MASTER') : 'green;">&nbsp;'.JText::_('JL_ADMIN_TEMPLATES_INDEPENDENT');
								echo '</span>';
								?></td>
							<td style="width:30; text-align:center; "><?php
								echo $row->id;
								?><input type='hidden' name='isMaster[<?php echo $row->id; ?>]' value='<?php echo $row->isMaster; ?>' /><?php ?></td>
						</tr>
						<?php
						$k=1 - $k;
					}
					?>
				</tbody>
			</table>
			<input type="hidden" name="controller" value="template" />
			<input type="hidden" name="task" value="" />
			<input type="hidden" name="boxchecked" value="0" />
			<input type="hidden" name="filter_order_Dir" value="" />
			<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
			<input type="hidden" name="search_mode" value="<?php echo $this->lists['search_mode'];?>" />
			<?php echo JHTML::_('form.token')."\n"; ?>
		</form>
	</fieldset>
</div>