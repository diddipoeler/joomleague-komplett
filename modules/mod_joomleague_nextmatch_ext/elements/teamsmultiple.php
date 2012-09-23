<?php

defined('_JEXEC') or die('Restricted access');

class JElementTeamsmultiple extends JElement
{

	var	$_name = 'teamsmultiple';

	function fetchElement($name, $value, &$node, $control_name){
		$db = &JFactory::getDBO();

		$query = 'SELECT t.id, t.name FROM #__joomleague_team t ORDER BY name';
		$db->setQuery( $query );
		$teams = $db->loadObjectList();
		$mitems = array(JHTML::_('select.option', '', '- '.JText::_('Do not use').' -'));

		foreach ( $teams as $team ) {
			$mitems[] = JHTML::_('select.option',  $team->id, '&nbsp;'.$team->name. ' ('.$team->id.')' );
		}
		
		$output= JHTML::_('select.genericlist',  $mitems, ''.$control_name.'['.$name.'][]', 'class="inputbox" multiple="multiple" size="10"', 'value', 'text', $value );
		return $output;
	}
}
 