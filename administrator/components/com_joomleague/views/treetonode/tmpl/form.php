<?php defined('_JEXEC') or die('Restricted access');

JHTML::_('behavior.tooltip');
jimport('joomla.html.pane');

JToolBarHelper::title(JText::_('JL_ADMIN_TREETONODE_TITLE'));

JToolBarHelper::save();
JToolBarHelper::apply();
JToolBarHelper::back('Back','index.php?option=com_joomleague&view=treetonodes&controller=treetonode');
JToolBarHelper::custom('unpublishnode', 'delete.png','delete_f2.png', JText::_( 'JL_ADMIN_TREETONODES_UNPUBLISH' ), false);

JToolBarHelper::help('screen.joomleague',true);
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

echo $pane->startPanel( JText::_( 'JL_TABS_DESCRIPTION' ), 'panel3' );
echo $this->loadTemplate('description');
echo $pane->endPanel();

echo $pane->endPane();
?>

		<div class="clr"></div>
		<input type="hidden" name="option"		value="com_joomleague" />
		<input type="hidden" name="controller"		value="treetonode" />
		<input type="hidden" name="id"			value="<?php echo $this->node->id; ?>" />
		<input type="hidden" name="project_id"		value="<?php echo $this->projectws->id; ?>" />
		<input type="hidden" name="task"		value="" />
	</div>
	<?php echo JHTML::_('form.token'); ?>
</form>