<?php defined('_JEXEC') or die('Restricted access');

JHTML::_('behavior.tooltip');
jimport('joomla.html.pane');

// Set toolbar items for the page
$edit = JRequest::getVar('edit', true);
$text = !$edit ? JText::_('JL_GLOBAL_NEW') : JText::_('JL_GLOBAL_EDIT');
JToolBarHelper::title(JText::_('JL_ADMIN_ROUND_TITLE'),'Matchdays');
#$this->projectws->name . ': ' . $this->matchday->name);
JToolBarHelper::save();
JToolBarHelper::apply();
if (!$edit)
{
	JToolBarHelper::cancel();
}
else
{
	// for existing items the button is renamed `close`
	JToolBarHelper::cancel('cancel', 'JL_GLOBAL_CLOSE');
}
JToolBarHelper::help('screen.joomleague', true);
?>

<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton)
	{
		var form = document.adminForm;
		if (pressbutton == 'cancel')
		{
			submitform(pressbutton);
			return;
		}

		// do field validation
		if (form.name.value == "")
		{
			alert("<?php echo JText::_('JL_ADMIN_ROUND_NO_NAME', true); ?>");
		} else {
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
		echo $pane->endPane();
		?>
	</div>

	<div class="clr"></div>

	<input type="hidden" name="option"		value="com_joomleague" />
	<input type="hidden" name="controller"	value="round" />
	<input type="hidden" name="project_id"	value="<?php echo $this->projectws->id; ?>" />
	<input type="hidden" name="id"		value="<?php echo $this->matchday->id; ?>" />
	<input type="hidden" name="task"		value="" />
	<?php echo JHTML::_('form.token'); ?>
</form>