<?php
/**
* @copyright	Copyright (C) 2007-2012 JoomLeague.net. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

defined('_JEXEC') or die('Restricted access');

class JElementNameFormat extends JElement
{

	var	$_name = 'nameformat';

	function fetchElement($name, $value, &$node, $control_name){
		$lang =& JFactory::getLanguage();
		$lang->load("com_joomleague", JPATH_ADMINISTRATOR);
		$mitems = array();
		$mitems[] = JHTML::_('select.option', 0, JText::_('JL_GLOBAL_NAME_FORMAT_FIRST_NICK_LAST'));
		$mitems[] = JHTML::_('select.option', 1, JText::_('JL_GLOBAL_NAME_FORMAT_LAST_NICK_FIRST'));
		$mitems[] = JHTML::_('select.option', 2, JText::_('JL_GLOBAL_NAME_FORMAT_LAST_FIRST_NICK'));
		$mitems[] = JHTML::_('select.option', 3, JText::_('JL_GLOBAL_NAME_FORMAT_FIRST_LAST'));
		$mitems[] = JHTML::_('select.option', 4, JText::_('JL_GLOBAL_NAME_FORMAT_LAST_FIRST'));
		$mitems[] = JHTML::_('select.option', 5, JText::_('JL_GLOBAL_NAME_FORMAT_NICK_FIRST_LAST'));
		$mitems[] = JHTML::_('select.option', 6, JText::_('JL_GLOBAL_NAME_FORMAT_NICK_LAST_FIRST'));
		$mitems[] = JHTML::_('select.option', 7, JText::_('JL_GLOBAL_NAME_FORMAT_FIRST_LAST_NICK'));
		$mitems[] = JHTML::_('select.option', 8, JText::_('JL_GLOBAL_NAME_FORMAT_FIRST_LAST2'));		
		$mitems[] = JHTML::_('select.option', 9, JText::_('JL_GLOBAL_NAME_FORMAT_LAST_FIRST2'));
		$mitems[] = JHTML::_('select.option',10, JText::_('JL_GLOBAL_NAME_FORMAT_LAST'));
		$mitems[] = JHTML::_('select.option',11, JText::_('JL_GLOBAL_NAME_FORMAT_FIRST_NICK_LAST2'));
		$mitems[] = JHTML::_('select.option',12, JText::_('JL_GLOBAL_NAME_FORMAT_NICK'));
		$mitems[] = JHTML::_('select.option',13, JText::_('JL_GLOBAL_NAME_FORMAT_FIRST_LAST3'));
		$mitems[] = JHTML::_('select.option',14, JText::_('JL_GLOBAL_NAME_FORMAT_LAST2_FIRST'));
		
		$output= JHTML::_('select.genericlist',  $mitems, 
							''.$control_name.'['.$name.'][]', 
							'class="inputbox" size="1"', 
							'value', 'text', $value);
		return $output;
	}
}
 