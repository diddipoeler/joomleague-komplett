<?php defined('_JEXEC') or die('Restricted access');

JHTMLBehavior::formvalidation();
JHTML::_('behavior.tooltip');
jimport('joomla.html.pane');

// Set toolbar items for the page
$edit=JRequest::getVar('edit',true);

JToolBarHelper::save();
JToolBarHelper::apply();

if (!$edit)
{
	JToolBarHelper::title(JText::_('JL_ADMIN_TEMPLATE_ADD_NEW'),'FrontendSettings');
	JToolBarHelper::divider();
	JToolBarHelper::cancel();
}
else
{
	JToolBarHelper::title(JText::_('JL_ADMIN_TEMPLATE_EDIT'),'FrontendSettings');
	JToolBarHelper::divider();
	// for existing items the button is renamed `close`
	JToolBarHelper::cancel('cancel',JText::_('JL_GLOBAL_CLOSE'));
}

JToolBarHelper::help('screen.joomleague',true);

$pane =& JPane::getInstance('tabs');
$i=1;
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

		// do field validation
		if (document.formvalidator.isValid(form))
		{
			submitform(pressbutton);
			return true;
		}
		else
		{
			alert('JL_ADMIN_TEMPLATE_WRONG_VALUES');
		}
		return false;
	}
</script>
<form action="<?php echo $this->request_url; ?>" method="post" name="adminForm" id="adminForm">
	<div style='text-align:right; '><?php echo $this->lists['templates']; ?></div>
	<?php
	if ($this->project->id != $this->template->project_id)
	{
		JError::raiseNotice(0,JText::_('JL_ADMIN_TEMPLATE_MASTER_WARNING'));
		?><input type="hidden" name="master_id" value="<?php echo $this->template->project_id; ?>" /><?php
	}
	?>
	<fieldset class="adminform">
		<legend><?php echo JText::sprintf('JL_ADMIN_TEMPLATE_LEGEND','<i>'.$this->params->name.'</i>','<i>'.$this->project->name.'</i>'); ?></legend>
		<fieldset class="adminform"><?php echo JText::_($this->params->description); ?></fieldset>
		<?php
		echo $pane->startPane('pane');
		foreach ($this->params->getGroups() as $key => $groups)
		{
			if (strtolower($key)!='_default')
			{
				echo $pane->startPanel(JText::_($key),'panel'.$i++);
				echo $this->params->render('params',$key);
				$pane->endPanel();
			}
		}
		echo $pane->endPane();
		?>
	</fieldset>
	<input type="hidden" name="option" value="com_joomleague" />
	<input type="hidden" name="controller" value="template" />
	<input type="hidden" name="task" value="" />
	<input type='hidden' name='user_id' value='<?php echo $this->user->id; ?>' />
	<input type="hidden" name="cid[]" value="<?php echo $this->template->id; ?>" />
	<input type="hidden" name="title" value="<?php echo $this->params->name; ?>" />
	<input type="hidden" name="template" value="<?php echo $this->template->template; ?>" />
	<?php echo JHTML::_('form.token')."\n"; ?>
</form>