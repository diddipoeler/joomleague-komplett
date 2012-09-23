<?php defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.tooltip');
$massadd=JRequest::getVar('massadd');
// load the projec type params
$project_type=$this->projectws->project_type;

//load navigation menu
$this->addTemplatePath(JPATH_COMPONENT.DS.'views'.DS.'adminmenu');

// Set toolbar items for the page
JToolBarHelper::title(JText::_('JL_ADMIN_ROUNDS_TITLE'),'Matchdays');

if (!$massadd)
{
	JToolBarHelper::apply('saveshort');
	JToolBarHelper::divider();
	JToolBarHelper::custom('massadd','new.png','new_f2.png',JText::_('JL_ADMIN_ROUNDS_MASSADD_BUTTON'),false);
	JToolBarHelper::addNewX('populate', JText::_('JL_ADMIN_ROUNDS_POPULATE_BUTTON'), false);
	JToolBarHelper::addNewX('save');
	JToolBarHelper::divider();
	JToolBarHelper::deleteList(JText::_('JL_ADMIN_ROUNDS_DELETE_WARNING'),'deletematches',JText::_('JL_ADMIN_ROUNDS_MASSDEL_BUTTON'));
	JToolBarHelper::deleteList(JText::_('JL_ADMIN_ROUNDS_DELETE_WARNING'));
	JToolBarHelper::divider();
}
else
{
	JToolBarHelper::custom('cancelmassadd','cancel.png','cancel_f2.png',JText::_('JL_ADMIN_ROUNDS_MASSADD_CANCEL'),false);
}
JToolBarHelper::help('screen.joomleague',true);
?>
<script language="javascript">
window.addEvent('domready',function(){
	$$('table.adminlist tr').each(function(el){
		var cb;
		if (cb=el.getElement("input[name^=cid]")) {
			el.getElement("input[name^=roundcode]").addEvent('change',function(){
				if (isNaN(this.value)) {
					alert('<?php echo JText::_('JL_ADMIN_ROUNDS_MSG_NOTANUMBER');?>');
					return false;
				}
			});
		}
	});
});
</script>
<div id='alt_massadd_enter' style='display:<?php echo ($massadd == 0) ? 'none' : 'block'; ?>'>
	<fieldset class='adminform'>
		<legend><?php echo JText::sprintf('JL_ADMIN_ROUNDS_MASSADD_LEGEND','<i>'.$this->projectws->name.'</i>'); ?></legend>
		<form name='copyform' method='post' style='display:inline' id='copyform'>
			<input type='hidden' name='project_id' value='<?php echo $this->projectws->id; ?>' />
			<input type='hidden' name='task' value='copyfrom' />
			<?php echo JHTML::_('form.token')."\n"; ?>
			<table class='admintable'><tbody><tr>
				<td class='key' nowrap='nowrap'><?php echo JText::_('JL_ADMIN_ROUNDS_MASSADD_COUNT'); ?></td>
				<td><input type='text' name='add_round_count' id='add_round_count' value='0' size='3' class='inputbox' /></td>
				<td><input type='submit' class='button' value='<?php echo JText::_('JL_ADMIN_ROUNDS_MASSADD_SUBMIT_BUTTON'); ?>' onclick='this.form.submit();' /></td>
			</tr></tbody></table>
		</form>
	</fieldset>
</div>
<form action="<?php echo $this->request_url; ?>" method="post" name="adminForm">
	<div id="editcell">
		<fieldset class="adminform">
			<legend><?php echo JText::sprintf('JL_ADMIN_ROUNDS_LEGEND','<i>'.$this->projectws->name.'</i>'); ?></legend>
			<table class="adminlist">
				<thead>
					<tr>
						<th style="vertical-align: top; " width="5" ><?php echo JText::_('JL_GLOBAL_NUM'); ?></th>
						<th style="vertical-align: top; " width="20" ><input  type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->matchday); ?>);" /></th>
						<th width="20">&nbsp;</th>
 						<th class="title" style="vertical-align: top; " width="20" ><?php echo JHTML::_( 'grid.sort', 'JL_ADMIN_ROUNDS_ROUND_NR', 'r.roundcode', $this->lists['order_Dir'], $this->lists['order'] ); ?></th>
						<th class="title" style="vertical-align: top; "><?php echo JText::_('JL_ADMIN_ROUNDS_ROUND_TITLE'); ?></th>
						<th class="title" style="vertical-align: top; text-align:right; " nowrap="nowrap" ><?php echo JText::_('JL_ADMIN_ROUNDS_STARTDATE'); ?></th>
						<th class="title" style="vertical-align: top; ">&nbsp;</th>
						<th class="title" style="vertical-align: top; text-align:left; " nowrap="nowrap" ><?php echo JText::_('JL_ADMIN_ROUNDS_ENDDATE'); ?></th>
						<th class="title" style="vertical-align: top; " width="20" nowrap="nowrap" ><?php echo JText::_('JL_ADMIN_ROUNDS_EDIT_MATCHES'); ?></th>
						<th class="title" style="vertical-align: top; " width="20" ><?php echo JText::_('JL_ADMIN_ROUNDS_PUBLISHED_CHECK'); ?></th>
						<th class="title" style="vertical-align: top; " width="20" ><?php echo JText::_('JL_ADMIN_ROUNDS_RESULT_CHECK'); ?></th>
						<th class="title" style="vertical-align: top; " width="20" "><?php echo JHTML::_( 'grid.sort', 'JL_GLOBAL_ID', 'r.id', $this->lists['order_Dir'], $this->lists['order'] ); ?></th>
					</tr>
				</thead>
				<tfoot><tr><td colspan="12"><?php echo $this->pagination->getListFooter(); ?></td></tr></tfoot>
				<tbody>
					<?php
					$k=0;
					for ($i=0,$n=count($this->matchday); $i < $n; $i++)
					{
						$row =& $this->matchday[$i];
						$link1=JRoute::_('index.php?option=com_joomleague&controller=round&task=edit&cid[]='.$row->id);
						$link2=JRoute::_('index.php?option=com_joomleague&controller=match&view=matches&rid[]='.$row->id);
						$checked=JHTML::_('grid.checkedout',$row,$i);
						?>
						<tr class="<?php echo "row$k"; ?>">
							<td style="text-align:center; "><?php echo $this->pagination->getRowOffset($i); ?></td>
							<td style="text-align:center; "><?php echo $checked; ?></td>
							<td style="text-align:center; "><?php
								$imageTitle=JText::_('JL_ADMIN_ROUNDS_EDIT_DETAILS');
								$imageFile='administrator/components/com_joomleague/assets/images/edit.png';
								$imageParams="title='$imageTitle'";
								echo JHTML::link($link1,JHTML::image($imageFile,$imageTitle,$imageParams));
							?></td>
							<td style="text-align:center; ">
								<input tabindex="1" type="text" size="1" class="inputbox" name="roundcode<?php echo $row->id; ?>" value="<?php echo $row->roundcode; ?>" onchange="document.getElementById('cb<?php echo $i; ?>').checked=true" />
							</td>
							<td width="160" style="text-align:center; ">
								<input tabindex="2" type="text" size="30" maxlength="64" class="inputbox" name="name<?php echo $row->id; ?>" value="<?php echo $row->name; ?>" onchange="document.getElementById('cb<?php echo $i; ?>').checked=true" />
							</td>
							<td width="160" style="text-align:right; ">
								<?php
								$date1= JoomleagueHelper::convertDate($row->round_date_first, 1);
								$append='';
								if (($date1 == '00-00-0000') || ($date1 == ''))
								{
									$append=' style="background-color:#FFCCCC;" ';
								}
								echo JHTML::calendar(	$date1,
														'round_date_first'.$row->id,
														'round_date_first'.$row->id,
														'%d-%m-%Y',
														'size="10" '.$append .
														'tabindex="3" '.
														'onchange="document.getElementById(\'cb'.$i.'\').checked=true"');
								?>
							</td>
							<td width="1" style="text-align:center; ">&nbsp;-&nbsp;</td>
							<td width="160" style="text-align:left; "><?php
								$date2= JoomleagueHelper::convertDate($row->round_date_last, 1);
								$append='';
								if (($date2 == '00-00-0000') || ($date2 == ''))
								{
									$append=' style="background-color:#FFCCCC;"';
								}
								echo JHTML::calendar(	$date2,
														'round_date_last'.$row->id,
														'round_date_last'.$row->id,
														'%d-%m-%Y',
														'size="10" '.$append .
														'tabindex="3" '.
														'onchange="document.getElementById(\'cb'.$i.'\').checked=true"');
								?></td>
							<td style="text-align:center; " nowrap="nowrap"><?php
								$link2Title=JText::_('JL_ADMIN_ROUNDS_EDIT_MATCHES_LINK');
								$link2Params="title='$link2Title'";
								echo JHTML::link($link2,$link2Title,$link2Params);
					  			?></td>
							<td style="text-align:center; " nowrap="nowrap"><?php
								if (($row->countUnPublished == 0) && ($row->countMatches > 0))
								{
									$imageTitle=JText::sprintf('JL_ADMIN_ROUNDS_ALL_PUBLISHED',$row->countMatches);
									$imageFile='administrator/components/com_joomleague/assets/images/ok.png';
									$imageParams="title='$imageTitle'";
									echo JHTML::image($imageFile,$imageTitle,$imageParams);
								}
								else
								{
									if ($row->countMatches == 0)
									{
										$imageTitle=JText::_('JL_ADMIN_ROUNDS_ANY_MATCHES');
									}
									else
									{
										$imageTitle=JText::sprintf('JL_ADMIN_ROUNDS_PUBLISHED_NR',$row->countUnPublished);
									}
									$imageFile='administrator/components/com_joomleague/assets/images/delete.png';
									$imageParams="title='$imageTitle'";
									echo JHTML::image($imageFile,$imageTitle,$imageParams);
								}
								?></td>
					  		<td style="text-align:center; " nowrap="nowrap"><?php
								if (($row->countNoResults == 0) && ($row->countMatches > 0))
								{
									$imageTitle=JText::sprintf('JL_ADMIN_ROUNDS_ALL_RESULTS',$row->countMatches);
									$imageFile='administrator/components/com_joomleague/assets/images/ok.png';
									$imageParams="title='$imageTitle'";
									echo JHTML::image($imageFile,$imageTitle,$imageParams);
								}
								else
								{
									if ($row->countMatches == 0)
									{
										$imageTitle=JText::_('JL_ADMIN_ROUNDS_ANY_MATCHES');
									}
									else
									{
										$imageTitle=JText::sprintf('JL_ADMIN_ROUNDS_RESULTS_MISSING',$row->countNoResults);
									}
									$imageFile='administrator/components/com_joomleague/assets/images/delete.png';
									$imageParams="title='$imageTitle'";
									echo JHTML::image($imageFile,$imageTitle,$imageParams);
								}
								?></td>
							<td style="text-align:center; "><?php echo $row->id; ?></td>
						</tr>
						<?php
						$k=1 - $k;
					}
					?>
				</tbody>
			</table>
		</fieldset>
	</div>
	<input type="hidden" name="controller" value="round" />
	<input type="hidden" name="project_id" value="<?php echo $this->projectws->id; ?>" />
	<input type="hidden" name="next_roundcode" value="<?php echo count($this->matchday) + 1; ?>" />
<!--	<input type="hidden" name="search_mode"	value="<?php //echo $this->lists['search_mode'];?>" id="search_mode" /> -->
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="" />
	<?php echo JHTML::_('form.token')."\n"; ?>
</form>