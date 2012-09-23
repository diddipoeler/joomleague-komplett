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

class JElementPlaygrounds extends JElement
{

	var	$_name = 'playgrounds';

	function fetchElement($name, $value, &$node, $control_name){
		$db = &JFactory::getDBO();

		$query = 'SELECT pl.id, pl.name FROM #__joomleague_playground pl ORDER BY name';
		$db->setQuery( $query );
		$playgrounds = $db->loadObjectList();
	//	$mitems = array(JHTML::_('select.option', '', '- '.JText::_('Do not use').' -'));

		foreach ( $playgrounds as $playground ) {
			$mitems[] = JHTML::_('select.option',  $playground->id, '&nbsp;'.$playground->name. ' ('.$playground->id.')' );
		}
		
		$output= JHTML::_('select.genericlist',  $mitems, ''.$control_name.'['.$name.'][]', 'class="inputbox" multiple="multiple" size="10"', 'value', 'text', $value );
		return $output;
	}
}
 