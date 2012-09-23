<?php
/**
* @copyright	Copyright (C) 2005-2012 JoomLeague.net. All rights reserved.
* @license	GNU/GPL,see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License,and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

defined('_JEXEC') or die('Restricted access');
jimport('joomla.html.pane');
/**
 * Match Form
 *
 * @author Marco Vaninetti <martizva@tiscali.it>
 * @package	 JoomLeague
 * @since 0.1
 */
?>
<div id="matchdetails">
	<h1>
		<?php
		echo JText::sprintf('JL_ADMIN_MATCH_F_TITLE',$this->match->hometeam,$this->match->awayteam);
		?>
	</h1>
	<form action="index.php" method="post" name="adminForm" id="adminForm">
		<!-- Score Table START -->
<?php
// focus matchreport tab when the match was already played
$startOffset = 0;

if (strtotime($this->match->match_date) < time() )
{
	$startOffset = 4;
}

$pane =& JPane::getInstance('tabs',array('startOffset'=>$startOffset));
echo $pane->startPane('pane');

echo $pane->startPanel(JText::_('JL_TABS_MATCHPREVIEW'),'panel5');
echo $this->loadTemplate('matchpreview');
echo $pane->endPanel();

echo $pane->startPanel(JText::_('JL_TABS_MATCHDETAILS'),'panel1');
echo $this->loadTemplate('matchdetails');
echo $pane->endPanel();

echo $pane->startPanel(JText::_('JL_TABS_SCOREDETAILS'),'panel2');
echo $this->loadTemplate('scoredetails');
echo $pane->endPanel();

echo $pane->startPanel(JText::_('JL_TABS_ALTDECISION'),'panel3');
echo $this->loadTemplate('altdecision');
echo $pane->endPanel();

echo $pane->startPanel(JText::_('JL_TABS_MATCHREPORT'),'panel4');
echo $this->loadTemplate('matchreport');
echo $pane->endPanel();

echo $pane->startPanel(JText::_('JL_TABS_MATCHRELATION'),'panel6');
echo $this->loadTemplate('matchrelation');
echo $pane->endPanel();

echo $pane->startPanel(JText::_('JL_TABS_EXTENDED'),'panel7');
echo $this->loadTemplate('matchextended');
echo $pane->endPanel();

echo $pane->endPane();
?>
		<!-- Additional Details Table END -->
		<div class="clr"></div>
		<input type="hidden" name="controller" value="match"/>
		<input type="hidden" name="option" value="com_joomleague"/>
		<input type="hidden" name="task" value="savedetails"/>
		<input type="hidden" name="cid[]" value="<?php echo $this->match->id; ?>"/>
		<?php echo JHTML::_('form.token')."\n"; ?>
	</form>
</div>