<?php defined('_JEXEC') or die('Restricted access');

JHTML::_( 'behavior.tooltip' );
jimport('joomla.html.pane');

JToolBarHelper::title( JText::_( 'JL_ADMIN_TEAMPLAYER_TITLE' ) );

// Set toolbar items for the page
$edit = JRequest::getVar( 'edit', true );
$text = !$edit ? JText::_( 'JL_GLOBAL_NEW' ) : JText::_( 'JL_GLOBAL_EDIT' );
JToolBarHelper::save();

if ( !$edit )
{
	JToolBarHelper::cancel();
}
else
{
	// for existing items the button is renamed `close` and the apply button is showed
	JToolBarHelper::apply();
	JToolBarHelper::cancel( 'cancel', 'JL_GLOBAL_CLOSE' );
}
JToolBarHelper::help( 'screen.joomleague', true );

?>
<!-- import the functions to move the events between selection lists	-->
<?php
$version = urlencode(JoomleagueHelper::getVersion());
echo JHTML::script( 'JL_eventsediting.js?v='.$version, 'administrator/components/com_joomleague/assets/js/' );
?>
<script language="javascript" type="text/javascript">

	function submitbutton(pressbutton)
	{
		var form = document.adminForm;
		if (pressbutton == 'cancel')
		{
			submitform( pressbutton );
			return;
		}
		submitform( pressbutton );
		return;
	}

</script>
<style type="text/css">
	table.paramlist td.paramlist_key
	{
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

echo $pane->startPanel( JText::_( 'JL_TABS_EXTENDED' ), 'panel4' );
echo $this->loadTemplate('extended');
echo $pane->endPanel();


echo $pane->endPane();
?>

		<input type="hidden" name="eventschanges_check"	id="eventschanges_check" value="0" />
		<input type="hidden" name="option"				value="com_joomleague" />
		<input type="hidden" name="controller"			value="teamplayer" />
		<input type="hidden" name="team_id"				value="<?php echo $this->teamws->team_id; ?>" />
		<input type="hidden" name="cid[]"				value="<?php echo $this->project_player->id; ?>" />
		<input type="hidden" name="task"				value="" />
	</div>
	<?php echo JHTML::_( 'form.token' ); ?>
</form>