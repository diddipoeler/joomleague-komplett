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
		if ( form.firstname.value == "" || form.lastname.value == "" )
		{
			 alert( "The person must have a first and last name!" );
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
				echo JText::_('JL_EDIT_PERSON')." - ".JoomleagueHelper::formatName(null, $this->person->firstname, $this->person->nickname, $this->person->lastname, $this->config["name_format"]);
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

echo $pane->startPanel(JText::_('JL_EDIT_PERSON_TABS_INFO'),'panel1');
echo $this->loadTemplate('info');
echo $pane->endPanel();

if( $this->edit_state ) {
echo $pane->startPanel(JText::_('JL_EDIT_PERSON_TABS_STATUS'),'panel2');
echo $this->loadTemplate('status');
echo $pane->endPanel();
}
if( $this->edit_picture ) {
echo $pane->startPanel(JText::_('JL_EDIT_PERSON_TABS_PICTURE'),'panel3');
echo $this->loadTemplate('picture');
echo $pane->endPanel();
}
if( $this->edit_description ) {
echo $pane->startPanel(JText::_('JL_EDIT_PERSON_TABS_DESC'),'panel4');
echo $this->loadTemplate('description');
echo $pane->endPanel();
}
echo $pane->startPanel(JText::_('JL_EDIT_PERSON_TABS_EXTENDED'),'panel5');
echo $this->loadTemplate('extended');
echo $pane->endPanel();

echo $pane->endPane();
?>	

	<input type="hidden" name="p" value="<?php echo $this->project->id; ?>">
	<input type="hidden" name="tid" value="<?php echo $this->teamPlayer->team_id; ?>">
	<input type="hidden" name="pid" value="<?php echo $this->person->id; ?>">
	<input type="hidden" name="tpid" value="<?php echo $this->teamPlayer->id; ?>">
	<input type="hidden" name="option" value="com_joomleague">
	<input type="hidden" name="controller" value="person">
	<input type="hidden" name="task" value="save">
	<?php echo JHTML::_( 'form.token' ); ?>
</form><br /> 