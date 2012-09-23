<?php
/**
 * @copyright  Copyright (C) 2005-2012 JoomLeague.net. All rights reserved.
 * @license    GNU/GPL,see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License,and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

defined('_JEXEC') or die('Restricted access');
jimport('joomla.html.pane');
?>
<h1><?php echo JText::sprintf('JL_ADMIN_MATCH_ELU_TITLE',$this->teamname); ?></h1>
<div class="clear"></div>
<div id="lineup">
	<form id="startingSquadsForm" name="startingSquadsForm" method="post">

<?php
$pane =& JPane::getInstance('tabs',array('startOffset'=>1));
echo $pane->startPane('pane');
echo $pane->startPanel(JText::_('JL_TABS_SUBST'),'panel1');
echo $this->loadTemplate('substitutions');
echo $pane->endPanel();

echo $pane->startPanel(JText::_('JL_TABS_PLAYERS'),'panel2');
echo $this->loadTemplate('players');
echo $pane->endPanel();

echo $pane->startPanel(JText::_('JL_TABS_STAFF'),'panel3');
echo $this->loadTemplate('staff');
echo $pane->endPanel();

echo $pane->endPane();
?>
		<input type="hidden" name="task" value="saveroster" />
		<input type="hidden" name="view" value="match" />
		<input type="hidden" name="controller" value="match" />
		<input type="hidden" name="cid[]" value="<?php echo $this->match->id; ?>" />
		<input type="hidden" name="changes_check" value="0" id="changes_check" />
		<input type="hidden" name="option" value="com_joomleague" id="option" />
		<input type="hidden" name="team" value="<?php echo $this->tid; ?>" id="team" />
		<input type="hidden" name="positionscount" value="<?php echo count($this->positions); ?>" id="positioncount"	/>
		<?php echo JHTML::_('form.token')."\n"; ?>
	</form>
</div>