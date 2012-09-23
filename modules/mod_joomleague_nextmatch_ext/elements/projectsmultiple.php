<?php

defined('_JEXEC') or die('Restricted access');

class JElementProjectsmultiple extends JElement
{

	var	$_name = 'projectsmultiple';

	function fetchElement($name, $value, &$node, $control_name){
		$db = &JFactory::getDBO();
		$lang =& JFactory::getLanguage();
		$lang->load("com_joomleague", JPATH_ADMINISTRATOR);
		
		$query = 'SELECT p.id, concat(p.name, \' ('.JText::_('JL_GLOBAL_LEAGUE').': \', l.name, \')\', \' ('.JText::_('JL_GLOBAL_SEASON').': \', s.name, \' )\' ) as name 
					FROM #__joomleague_project AS p 
					LEFT JOIN #__joomleague_season AS s ON s.id = p.season_id 
					LEFT JOIN #__joomleague_league AS l ON l.id = p.league_id 
					WHERE p.published=1 ORDER BY p.id DESC';
		$db->setQuery( $query );
		$projects = $db->loadObjectList();
		$mitems = array(JHTML::_('select.option', '-1', '- '.JText::_('Do not use').' -'));

		foreach ( $projects as $project ) {
			$mitems[] = JHTML::_('select.option',  $project->id, '&nbsp;&nbsp;&nbsp;'.$project->name );
		}
		

		$output= JHTML::_('select.genericlist',  $mitems, ''.$control_name.'['.$name.'][]', 'class="inputbox" style="width:90%;" multiple="multiple" size="10"', 'value', 'text', $value );
		return $output;
	}
}
