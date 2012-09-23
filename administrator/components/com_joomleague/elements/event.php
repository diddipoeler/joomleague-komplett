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

class JElementEvent extends JElement
{

	var	$_name = 'event';

	function fetchElement($name, $value, &$node, $control_name){
		$db = &JFactory::getDBO();

		$query = 'SELECT e.id, e.name FROM #__joomleague_eventtype e WHERE published=1 ORDER BY name';
		$db->setQuery( $query );
		$events = $db->loadObjectList();
		$mitems = array(JHTML::_('select.option', '-1', '- '.JText::_('Do not use').' -'));

		foreach ( $events as $event ) {
			$mitems[] = JHTML::_('select.option',  $event->id, '&nbsp;'.JText::_($event->name). ' ('.$event->id.')' );
		}
		
		$output= JHTML::_('select.genericlist',  $mitems, ''.$control_name.'['.$name.'][]', 'class="inputbox" size="1"', 'value', 'text', $value );
		return $output;
	}
}
 