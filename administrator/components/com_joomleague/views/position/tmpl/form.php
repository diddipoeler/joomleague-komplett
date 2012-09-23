<?php defined('_JEXEC') or die('Restricted access');

JHTML::_('behavior.tooltip');
jimport('joomla.html.pane');

// Set toolbar items for the page
$edit=JRequest::getVar('edit',true);
$text=!$edit ? JText::_('JL_GLOBAL_NEW') : JText::_('JL_GLOBAL_EDIT');

JToolBarHelper::save();

if (!$edit)
{
	JToolBarHelper::title(JText::_('JL_ADMIN_POSITION_ADD_NEW'),'Positions');
	JToolBarHelper::divider();
	JToolBarHelper::cancel();
}
else
{
	// for existing items the button is renamed `close` and the apply button is showed
	JToolBarHelper::title(JText::_('JL_ADMIN_POSITION_EDIT'),'Positions');
	JToolBarHelper::apply();
	JToolBarHelper::divider();
	JToolBarHelper::cancel('cancel','JL_GLOBAL_CLOSE');
}
JToolBarHelper::divider();
JToolBarHelper::help('screen.joomleague',true);

$uri =& JFactory::getURI();
?>
<!-- import the functions to move the events between selection lists  -->
<?php 
$version = urlencode(JoomleagueHelper::getVersion());
echo JHTML::script('JL_eventsediting.js?v='.$version,'administrator/components/com_joomleague/assets/js/'); ?>
<script language="javascript" type="text/javascript">

		function submitbutton(pressbutton)
		{
			var form=document.adminForm;
			if (pressbutton == 'cancel')
			{
				submitform(pressbutton);
				return;
			}
			var mylist=$('position_eventslist');
	 		for(var i=0; i<mylist.length; i++)
	 		{
				mylist[i].selected=true;
			}
			var mylist=$('position_statistic');
	 		for(var i=0; i<mylist.length; i++)
	 		{
				mylist[i].selected=true;
			}
			// do field validation
			if (form.name.value == "")
			{
				alert("<?php echo JText::_('JL_ADMIN_POSITION_NEEDS_NAME'); ?>");
			}
			else
			{
				submitform(pressbutton);
			}
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

<?php
$pane =& JPane::getInstance('tabs',array('startOffset'=>0));
echo $pane->startPane('pane');
echo $pane->startPanel(JText::_('JL_TABS_DETAILS'),'panel1');
echo $this->loadTemplate('details');
echo $pane->endPanel();

echo $pane->startPanel(JText::_('JL_TABS_EVENTS'),'panel2');
echo $this->loadTemplate('events');
echo $pane->endPanel();

echo $pane->startPanel(JText::_('JL_TABS_STATISTICS'),'panel3');
echo $this->loadTemplate('statistics');
echo $pane->endPanel();

echo $pane->endPane();
?>
		<div class="clr"></div>
		<input type="hidden" name="eventschanges_check" id="eventschanges_check" value="0" />
		<input type="hidden" name="statschanges_check" id="statschanges_check" value="0" />
		<input type="hidden" name="option" value="com_joomleague" />
		<input type="hidden" name="controller" value="position" />
		<input type="hidden" name="cid[]" value="<?php echo $this->position->id; ?>" />
		<input type="hidden" name="task" value="" />
	</div>
	<?php echo JHTML::_('form.token')."\n"; ?>
</form>