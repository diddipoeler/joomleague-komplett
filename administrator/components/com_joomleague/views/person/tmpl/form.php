<?php defined('_JEXEC') or die('Restricted access');

JHTML::_('behavior.tooltip');
jimport('joomla.html.pane');

// Set toolbar items for the page
$text = !$this->edit ? JText::_('JL_GLOBAL_NEW') : JText::_('JL_GLOBAL_EDIT');

JToolBarHelper::save();

if (!$this->edit)
{
	JToolBarHelper::title(JText::_('JL_ADMIN_PERSON_TITLE'));
	JToolBarHelper::divider();
	JToolBarHelper::cancel();
}
else
{
	// for existing items the button is renamed `close` and the apply button is showed
	JToolBarHelper::title(JText::_('JL_ADMIN_PERSON_TITLE2'));
	JToolBarHelper::apply();
	JToolBarHelper::divider();
	JToolBarHelper::cancel('cancel',JText::_('JL_GLOBAL_CLOSE'));
}
JToolBarHelper::divider();
JToolBarHelper::help('screen.joomleague',true);
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
		if (form.lastname.value == '' && form.nickname.value == '') {
			alert("<?php echo JText::_('JL_ADMIN_PERSON_NO_NAME',true); ?>");
		} else {
			submitform(pressbutton);
			return true;
		}
	}
</script>

<form action="index.php" method="post" name="adminForm" id="adminForm">
	<div class="col50">

<?php
$pane =& JPane::getInstance('tabs',array('startOffset'=>0));
echo $pane->startPane('pane');
echo $pane->startPanel(JText::_('JL_TABS_DETAILS'),'panel1');
echo $this->loadTemplate('details');
echo $pane->endPanel();

echo $pane->startPanel(JText::_('JL_TABS_PICTURE'),'panel2');
echo $this->loadTemplate('picture');
echo $pane->endPanel();

echo $pane->startPanel(JText::_('JL_TABS_DESCRIPTION'),'panel3');
echo $this->loadTemplate('description');
echo $pane->endPanel();

echo $pane->startPanel(JText::_('JL_TABS_EXTENDED'),'panel4');
echo $this->loadTemplate('extended');
echo $pane->endPanel();

echo $pane->startPanel(JText::_('JL_TABS_ADVANCED'),'panel5');
echo $this->loadTemplate('advanced');
echo $pane->endPanel();

if (!$this->edit) // add a selection to assign a person directly to a project and team
{
echo $pane->startPanel(JText::_('JL_TABS_ASSIGN'),'panel6');
echo $this->loadTemplate('assign');
echo $pane->endPanel();
}

echo $pane->endPane();
?>


	</div>
	<input type="hidden" name="assignperson" value="0" id="assignperson" />
	<input type="hidden" name="option" value="com_joomleague" />
	<input type="hidden" name="controller" value="person" />
	<input type="hidden" name="cid[]" value="<?php echo $this->person->id; ?>" />
	<input type="hidden" name="task" value="" />
	<?php echo JHTML::_('form.token')."\n"; ?>
</form>