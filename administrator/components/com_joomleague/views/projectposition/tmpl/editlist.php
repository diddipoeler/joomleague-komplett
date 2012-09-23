<?php defined('_JEXEC') or die('Restricted access');

JHTML::_('behavior.tooltip');

JToolBarHelper::title(JText::_('JL_ADMIN_P_POSITION_EDIT_TITLE'));
JToolBarHelper::save('save_positionslist');
JToolBarHelper::cancel('cancel',JText::_('JL_GLOBAL_CLOSE'));
JToolBarHelper::help('screen.joomleague',true);

?>
<!-- import the functions to move the events between selection lists  -->
<?php
$version = urlencode(JoomleagueHelper::getVersion());
echo JHTML::script('JL_eventsediting.js?v='.$version,'administrator/components/com_joomleague/assets/js/');
?>
<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton)
	{
		var form=document.adminForm;
		if (pressbutton == 'cancel')
		{
			submitform(pressbutton);
			return;
		}
		var mylist=document.getElementById('project_positionslist');
		 for(var i=0; i < mylist.length; i++)
		 {
			  mylist[i].selected=true;
		 }

		submitform(pressbutton);

	}
</script>


<style type="text/css">
	table.paramlist td.paramlist_key {
		width: 92px;
		text-align: left;
		height: 30px;
	}
</style>
<form action="index.php" method="post" name="adminForm" id="adminForm">
	<div class="col50">
		<fieldset class="adminform">
			<legend><?php echo JText::sprintf('JL_ADMIN_P_POSITION_EDIT_LEGEND','<i>'.$this->projectws->name.'</i>');?></legend>
			<table class="admintable" border='0'>
				<tr>
					<td style="text-align:center;vertical-align:top;"><b><?php echo JText::_('JL_ADMIN_P_POSITION_EDIT_AVAILABLE'); ?><br /></b>
						<?php echo $this->lists['positions']; ?></td>
					<td style="text-align:center;">
						&nbsp;&nbsp;
						<input	type="button" class="inputbox"
								onclick="document.getElementById('positionschanges_check').value=1;move(document.getElementById('positionslist'),document.getElementById('project_positionslist'));selectAll(document.getElementById('project_positionslist'));"
								value="&gt;&gt;" />
						&nbsp;&nbsp;<br />&nbsp;&nbsp;
					 	<input	type="button" class="inputbox"
					 			onclick="document.getElementById('positionschanges_check').value=1;move(document.getElementById('project_positionslist'),document.getElementById('positionslist'));selectAll(document.getElementById('project_positionslist'));"
								value="&lt;&lt;" />
						&nbsp;&nbsp;
					</td>
					<td style="text-align:center;vertical-align:top;"><b><?php echo JText::_('JL_ADMIN_P_POSITION_EDIT_ASSIGNED'); ?><br /></b>
						<?php echo $this->lists['project_positions']; ?></td>
				</tr>
			</table>
		</fieldset>
		<div class="clr"></div>
		<input type="hidden" name="positionschanges_check" value="0" id="positionschanges_check" />
		<input type="hidden" name="option" value="com_joomleague" />
		<input type="hidden" name="controller" value="projectposition" />
		<input type="hidden" name="cid[]" value="<?php echo $this->projectws->id; ?>" />
		<input type="hidden" name="task" value="" />
	</div>
	<?php echo JHTML::_('form.token')."\n"; ?>
</form>