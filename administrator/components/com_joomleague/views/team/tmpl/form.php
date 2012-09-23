<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php 
JHTML::_('behavior.tooltip');
jimport('joomla.html.pane');
 ?>

<?php
	// Set toolbar items for the page
	$edit		= JRequest::getVar('edit',true);
	$text = !$edit ? JText::_( 'JL_GLOBAL_NEW' ) : JText::_( 'JL_GLOBAL_EDIT' );
	JToolBarHelper::title(   JText::_( 'JL_ADMIN_TEAM' ).': <small><small>[ ' . $text.' ]</small></small>' );
	JToolBarHelper::save();

	if (!$edit)  {
		JToolBarHelper::divider();
		JToolBarHelper::cancel();
	} else {
		// for existing items the button is renamed `close` and the apply button is showed
		JToolBarHelper::apply();
		JToolBarHelper::divider();
		JToolBarHelper::cancel( 'cancel', 'JL_GLOBAL_CLOSE' );
	}

	JToolBarHelper::help( 'screen.joomleague.edit' );
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
			alert( "<?php echo JText::_( 'JL_ADMIN_TEAM_NO_NAME', true ); ?>" );
		} else if ( form.club_id.value == 0) {
				alert( "<?php echo JText::_( 'JL_ADMIN_TEAM_NO_CLUB', true ); ?>"  );
		} else if ( form.short_name.value == 0 ) {
				alert( "<?php echo JText::_( 'JL_ADMIN_TEAM_NO_SHORTNAME', true ); ?>" );
		} else {
			submitform( pressbutton );
		}
	}

</script>

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

echo $pane->startPanel( JText::_( 'JL_TABS_DESCRIPTION' ), 'panel2' );
echo $this->loadTemplate('description');
echo $pane->endPanel();

echo $pane->startPanel( JText::_( 'JL_TABS_EXTENDED' ), 'panel3' );
echo $this->loadTemplate('extended');
echo $pane->endPanel();



echo $pane->endPane();
?>

<div class="clr"></div>

<input type="hidden" name="option" value="com_joomleague" />
<input type="hidden" name="controller" value="team" />
<input type="hidden" name="cid[]" value="<?php echo $this->team->id; ?>" />
<input type="hidden" name="task" value="" />
</div>
<?php echo JHTML::_( 'form.token' ); ?>
</form>