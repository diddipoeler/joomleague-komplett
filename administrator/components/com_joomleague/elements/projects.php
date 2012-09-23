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

class JElementProjects extends JElement
{

	var	$_name = 'projects';

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
