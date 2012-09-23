<?php defined('_JEXEC') or die('Restricted access');

JHTML::_('behavior.tooltip');
jimport('joomla.html.pane');

JToolBarHelper::title(JText::_('JL_ADMIN_P_TEAM_TITLE'));

JToolBarHelper::save();
JToolBarHelper::apply();
JToolBarHelper::cancel('cancel',JText::_('JL_GLOBAL_CLOSE'));

JToolBarHelper::help('screen.joomleague',true);
?>
<!-- import the functions to move the events between selection lists	-->
<?php
$version = urlencode(JoomleagueHelper::getVersion());
echo JHTML::script('JL_eventsediting.js?v='.$version,'administrator/components/com_joomleague/assets/js/');
?>
<script language="javascript" type="text/javascript">
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'cancel') {
				submitform(pressbutton);
				return;
			}
			submitform(pressbutton);
			return;
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

$pane =& JPane::getInstance('tabs', array('startOffset'=>0)); 
echo $pane->startPane( 'pane' );
echo $pane->startPanel( JText::_( 'JL_TABS_DETAILS' ), 'panel1' );
echo $this->loadTemplate('details');
echo $pane->endPanel();

echo $pane->startPanel( JText::_( 'JL_TABS_PICTURE' ), 'panel2' );
echo $this->loadTemplate('picture');
echo $pane->endPanel();

echo $pane->startPanel( JText::_( 'JL_TABS_DESCRIPTION' ), 'panel3' );
echo $this->loadTemplate('description');
echo $pane->endPanel();

echo $pane->startPanel( JText::_( 'JL_TABS_TRAINING' ), 'panel4' );
echo $this->loadTemplate('training');
echo $pane->endPanel();

echo $pane->startPanel( JText::_( 'JL_TABS_EXTENDED' ), 'panel5' );
echo $this->loadTemplate('extended');
echo $pane->endPanel();



echo $pane->endPane();
?>

		<div class="clr"></div>
		<input type="hidden" name="eventschanges_check"	value="0"	id="eventschanges_check" />
		<input type="hidden" name="option"				value="com_joomleague" />
		<input type="hidden" name="controller"			value="projectteam" />
		<input type="hidden" name="cid[]"				value="<?php echo $this->project_team->id; ?>" />
		<input type="hidden" name="project_id"			value="<?php echo $this->projectws->id; ?>" />
		<input type="hidden" name="task"				value="" id='task'/>
	</div>
	<?php echo JHTML::_('form.token'); ?>
</form>