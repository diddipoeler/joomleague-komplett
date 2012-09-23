<?php defined('_JEXEC') or die('Restricted access');

JHTML::_('behavior.tooltip');
jimport('joomla.html.pane');

// Set toolbar items for the page
JToolBarHelper::title( JText::_( $this->projectws->name ) . ': ' . JText::_( 'Divisions' ),'Divisions' );

$edit	= JRequest::getVar( 'edit', true );
$text	= !$edit ? JText::_( 'New' ) : JText::_( 'Edit' );
JToolBarHelper::save();
if (!$edit)
{
	JToolBarHelper::cancel();
}
else
{
	// for existing items the button is renamed `close` and the apply button is showed
	JToolBarHelper::apply();
	JToolBarHelper::cancel( 'cancel', 'Close' );
}
JToolBarHelper::help( 'screen.joomleague', true );

$uri 	=& JFactory::getURI();
?>
<!-- import the functions to move the events between selection lists  -->
<?php
$version = urlencode(JoomleagueHelper::getVersion());
echo JHTML::script( 'JL_eventsediting.js?v='.$version,'administrator/components/com_joomleague/assets/js/' );
?>
<script language="javascript" type="text/javascript">
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}

			// do field validation
			if (form.name.value == ""){
				alert( "<?php echo JText::_( 'Division item must have a name', true ); ?>" );
			} else {
				submitform( pressbutton );
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
	<div class="clr"></div>

	<input type="hidden" name="eventschanges_check"	id="eventschanges_check" value="0" />
	<input type="hidden" name="option"				value="com_joomleague" />
	<input type="hidden" name="controller"			value="division" />
	<input type="hidden" name="cid[]"				value="<?php echo $this->division->id; ?>" />
	<input type="hidden" name="project_id"			value="<?php echo $this->projectws->id; ?>" />
	<input type="hidden" name="task"				value="" />
	<?php echo JHTML::_( 'form.token' ); ?>
	</div>
</form>