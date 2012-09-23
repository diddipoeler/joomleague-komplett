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
JHTML::_( 'behavior.tooltip' );

?>
<form method="post" name="statsform" id="statsform" action="index.php">
<input type="button" class="button-submit" value="<?php echo JText::_('JL_GLOBAL_SAVE'); ?>"/>
<div id="jlstatsform">

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

<input type="hidden" name="option" value="com_joomleague" />
<input type="hidden" name="controller" value="match" />
<input type="hidden" name="tmpl" value="component" />
<input type="hidden" name="task" id="statformtask" value="" />
<input type="hidden" name="project_id"	value="<?php echo $this->match->project_id; ?>" />
<input type="hidden" name="match_id"	value="<?php echo $this->match->id; ?>" />
<input type="hidden" name="boxchecked" value="0" />

</div>
<?php echo JHTML::_( 'form.token' ); ?>
</form>
<div style="clear: both"></div>
