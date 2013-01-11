<?php defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.html.pane');
$document =& JFactory::getDocument();
$css = 'components/com_joomleague/assets/css/tabs.css';
$document->addStyleSheet($css);
$this->_addPath( 'template', JPATH_COMPONENT . DS . 'views' . DS . 'projectheading' . DS . 'tmpl' );
$this->_addPath( 'template', JPATH_COMPONENT . DS . 'views' . DS . 'backbutton' . DS . 'tmpl' );
$this->_addPath( 'template', JPATH_COMPONENT . DS . 'views' . DS . 'footer' . DS . 'tmpl' );
?>
<div class="joomleague">
<!-- General part of person view START -->
<?php
echo $this->loadTemplate( 'projectheading' );

if ( $this->config['show_sectionheader'] == 1 )
{
	echo $this->loadTemplate( 'sectionheader' );
}


		$pane =& JPane::getInstance('tabs',array('startOffset'=>0));
		echo $pane->startPane('pane');
		
if ( $this->config['show_plinfo'] == 1 )
{		
		echo $pane->startPanel(JText::_('JL_PERSON_PERSONAL_DATA'),'panel1');
		echo $this->loadTemplate('info');
		echo $pane->endPanel();
}

if (($this->config['show_extended'])==1)
{		
		echo $pane->startPanel(JText::_('JL_PERSON_EXTENDED'),'panel2');
		echo $this->loadTemplate('extended');
		echo $pane->endPanel();
}		

if ( $this->config['show_plstatus'] == 1 )
{
if (	( isset($this->teamPlayer->injury) && $this->teamPlayer->injury > 0 ) ||
		( isset($this->teamPlayer->suspension) && $this->teamPlayer->suspension > 0 ) ||
		( isset($this->teamPlayer->away) && $this->teamPlayer->away > 0 ) )
{
		echo $pane->startPanel(JText::_('JL_PERSON_STATUS'),'panel3');
		echo $this->loadTemplate('status');
		echo $pane->endPanel();
}		
}

if ( $this->config['show_description'] == 1 )
{		
		echo $pane->startPanel(JText::_('JL_PERSON_INFO'),'panel4');
		echo $this->loadTemplate('description');
		echo $pane->endPanel();	
}

if ( $this->config['show_gameshistory'] == 1 )
{
if (count($this->games))
{
		echo $pane->startPanel(JText::_('JL_PERSON_GAMES_HISTORY'),'panel5');
		echo $this->loadTemplate('gameshistory');
		echo $pane->endPanel();
}		
}

if ( $this->config['show_plstats'] == 1 )
{
if (count($this->historyPlayer) > 0)
{
		echo $pane->startPanel(JText::_('JL_PERSON_PERSONAL_STATISTICS'),'panel6');
		echo $this->loadTemplate('playerstats');
		echo $pane->endPanel();
}    		
}

if ( $this->config['show_plcareer'] == 1 )
{
if (count($this->historyPlayer) > 0)
{
		echo $pane->startPanel(JText::_('JL_PERSON_PLAYING_CAREER'),'panel7');
		echo $this->loadTemplate('playercareer');
		echo $pane->endPanel();
}    		
}

if ( $this->config['show_stcareer'] == 1 )
{	
if (count($this->historyPlayerStaff) > 0)
{
		echo $pane->startPanel(JText::_('JL_PERSON_STAFF_CAREER'),'panel8');
		echo $this->loadTemplate('playerstaffcareer');
		echo $pane->endPanel();
}
    				
}		

if ( $this->userfields )
	{ 
	echo $pane->startPanel(JText::_('JL_PERSON_USERFIELDS'),'panel9');
	echo $this->loadTemplate('userfields');
	echo $pane->endPanel();
	}


	echo $pane->endPane();

?>
	<!-- Player specific part of person view END -->
	<?php

	echo "<div>";
	//backbutton
	echo $this->loadTemplate( 'backbutton' );
	// footer
	echo $this->loadTemplate( 'footer' );
	echo "</div>";
	//fixxme: had a domready Calendar.setup error on my local site
	echo "<script>";
	echo "Calendar = {};";
	echo "</script>";

?>
</div>