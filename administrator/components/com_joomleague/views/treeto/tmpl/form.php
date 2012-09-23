<?php defined('_JEXEC') or die('Restricted access');

JHTML::_('behavior.tooltip');
jimport('joomla.html.pane');

	JToolBarHelper::title(JText::_('JL_ADMIN_TREETO_TITLE'),'Tree');

	JToolBarHelper::save();
	JToolBarHelper::apply();
	JToolBarHelper::back('Back','index.php?option=com_joomleague&view=treetos&controller=treeto');
	JToolBarHelper::help('screen.joomleague', true);
?>

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

	<div class="clr"></div>

	<input type="hidden" name="option"	value="com_joomleague" />
	<input type="hidden" name="controller"	value="treeto" />
	<input type="hidden" name="cid[]" value="<?php echo $this->treeto->id; ?>" />
	<input type="hidden" name="task"	value="" />
	<?php echo JHTML::_('form.token')."\n"; ?>
	</div>
</form>
