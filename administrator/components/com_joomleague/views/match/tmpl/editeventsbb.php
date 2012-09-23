<?php
/**
* @copyright	Copyright (C) 2005-2012 JoomLeague.net. All rights reserved.
* @license	GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/
/**
 * EditeventsBB view
 *
 * @package	Joomleague
 * @since 0.1
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.html.pane');
//set toolbar items for the page
JToolBarHelper::title( JText::_( 'JL_ADMIN_MATCH_EEBB_TITLE' ),'events' );

	JToolBarHelper::apply( 'saveeventbb' );
	
	JToolBarHelper::divider();
	JToolBarHelper::back( 'JL_GLOBAL_BACK', 'index.php?option=com_joomleague&view=matches&controller=match' );

JToolBarHelper::help( 'screen.joomleague', true );

JHTML::_( 'behavior.tooltip' );
JHTML::_( 'behavior.modal' );
?>
<form method="post" name="adminForm">
<div id="gamesevents">
<?php

$pane =& JPane::getInstance('tabs',array('startOffset'=>0));
echo $pane->startPane('pane');
echo $pane->startPanel(JText::_($this->teams->team1),'panel1');
echo $this->loadTemplate('home');
echo $pane->endPanel();

echo $pane->startPanel(JText::_($this->teams->team2),'panel2');
echo $this->loadTemplate('away');
echo $pane->endPanel();

echo $pane->endPane();

?>

	<input type="hidden" name="controller"			value="match" />
	<input type="hidden" name="task"				value="" />
	<input type="hidden" name="boxchecked"			value="0" />
	<?php echo JHTML::_( 'form.token' ); ?>
</div>
</form>
<div style="clear: both"></div>