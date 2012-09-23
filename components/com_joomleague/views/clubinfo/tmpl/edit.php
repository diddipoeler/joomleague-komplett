<?php defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.html.pane');

if ( !$this->showediticon )
{
	JFactory::getApplication()->redirect( str_ireplace('&layout=edit','',JFactory::getURI()->toString()), JText::_('ALERTNOTAUTH') );
}
$document = & JFactory::getDocument( );

$script = '
	function submitbutton(pressbutton)
	{
		var form = document.adminForm;
		if (pressbutton == "cancel" )
		{
			submitform( pressbutton );
			return;
		}
		// do field validation
		if ( form.name.value == "" )
		{
			 alert( "The club must have a name!" );
			 return;
		}
		else
		{
			submitform( pressbutton );
		}
	}
';
$document->addScriptDeclaration( $script );
$document->addScript( JURI::root().'includes/js/joomla.javascript.js' );
?>
	<table width="100%" class="contentpaneopen">
		<tr>
			<td class="contentheading">
				<?php
				echo JText::_('JL_EDIT_CLUBINFO_CLUB')." - ".$this->club->name;
				?>
			</td>
		</tr>
	</table>
<form name="adminForm" id="adminForm" method="post" action="<?php echo JURI::root();?>index.php">
	<div align="left">
		<input type="submit" name="saveInfo" value="<?php echo JText::_('JL_GLOBAL_SAVE'); ?>" onClick="javascript:submitbutton('save');">
		<input type="submit" name="cancel" value="<?php echo JText::_('JL_GLOBAL_CANCEL'); ?>" onClick="javascript:submitbutton('cancel');">
	</div>
<?php
$pane =& JPane::getInstance('tabs',array('startOffset'=>0));
echo $pane->startPane('pane');

echo $pane->startPanel(JText::_('JL_EDIT_CLUBINFO_TABS_CLUBINFO'),'panel1');
echo $this->loadTemplate('clubinfo');
echo $pane->endPanel();

echo $pane->startPanel(JText::_('JL_EDIT_CLUBINFO_TABS_PICTURE'),'panel2');
echo $this->loadTemplate('picture');
echo $pane->endPanel();

echo $pane->startPanel(JText::_('JL_EDIT_CLUBINFO_TABS_EXTENDED'),'panel3');
echo $this->loadTemplate('extended');
echo $pane->endPanel();

echo $pane->endPane();
?>

	<input type="hidden" name="p" value="<?php echo $this->project->id; ?>">
	<input type="hidden" name="cid" value="<?php echo $this->club->id; ?>">
	<input type="hidden" name="option" value="com_joomleague">
	<input type="hidden" name="controller" value="clubinfo">
	<input type="hidden" name="task" value="">
	<?php echo JHTML::_( 'form.token' ); ?>
</form><br />