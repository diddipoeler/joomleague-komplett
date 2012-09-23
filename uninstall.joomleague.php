<?php
/**
* @copyright	Copyright (C) 2005-2012 JoomLeague.net. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

defined('_JEXEC') or die('Restricted access');

function com_uninstall()
{
	$params =& JComponentHelper::getParams('com_joomleague');
	$uninstallDB = $params->get('cfg_drop_joomleague_tables_when_uninstalled',0); //Also uninstall db tables of JoomLeague?

	if ($uninstallDB)
	{
		echo JText::_('Also removing database tables of JoomLeague');
		$db =& JFactory::getDBO();
		$query = '	DROP TABLE IF EXISTS	#__joomleague_club,
								#__joomleague_dfb,
								#__joomleague_division,
								#__joomleague_eventtype,
								#__joomleague_league,
								#__joomleague_match,
								#__joomleague_match_event,
								#__joomleague_match_player,
								#__joomleague_match_referee,
								#__joomleague_match_staff,
								#__joomleague_match_staff_statistic,
								#__joomleague_match_statistic,
								#__joomleague_person,
								#__joomleague_playground,
								#__joomleague_position,
								#__joomleague_position_eventtype,
								#__joomleague_position_eventtypes,
								#__joomleague_position_statistic,
								#__joomleague_prediction_admin,
								#__joomleague_prediction_game,
								#__joomleague_prediction_point,
								#__joomleague_prediction_project,
								#__joomleague_prediction_member,
								#__joomleague_prediction_result,
								#__joomleague_predictiongame,
								#__joomleague_predictiongame_admins,
								#__joomleague_predictiongame_points,
								#__joomleague_predictiongame_project,
								#__joomleague_prediction_template,
								#__joomleague_prediction_tip_member,
								#__joomleague_prediction_tip_result,
								#__joomleague_project,
								#__joomleague_project_position,
								#__joomleague_project_referee,
								#__joomleague_project_team,
								#__joomleague_round,
								#__joomleague_season,
								#__joomleague_sports_type,
								#__joomleague_statistic,
								#__joomleague_team,
								#__joomleague_team_player,
								#__joomleague_team_staff,
								#__joomleague_team_trainingdata,
								#__joomleague_template_config,
								#__joomleague_tip_members,
								#__joomleague_tip_results,
								#__joomleague_tree,
								#__joomleague_treeto,
								#__joomleague_treeto_match,
								#__joomleague_treeto_node,
								#__joomleague_version
								';
		$db->setQuery($query);
		$db->query();
	}
	else
	{
		echo JText::_('Database tables of JoomLeague are not removed');
	}
	?>
	<div class="header">JoomLeague now has been removed from your system!</div>
	<p>We're sorry to see you go!</p>
	<p>To completely remove Joomleague from your system, be sure to also uninstall the JoomLeague modules.</p>
	<?php
}
?>