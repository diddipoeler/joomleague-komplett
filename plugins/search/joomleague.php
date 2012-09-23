<?php
 /**
 * @package		JoomLeague
 * @subpackage	search
 * @copyright	Copyright (c)2010 JoomLeague Developers
 * @license		GNU General Public License version 2, or later
 * @since		1.5.0a
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
 
$mainframe->registerEvent( 'onSearch', 'plgSearch' );
$mainframe->registerEvent( 'onSearchAreas', 'plgSearchAreas' );

JPlugin::loadLanguage( 'plg_search_joomleague' );
 
function &plgSearchAreas()
{
	static $areas = array
	(
            'Joomleague' => 'Joomleague'
	);
	return $areas;
}

function &plgSearch($text, $phrase='', $order='', $areas=null)
{
	$db 	=& JFactory::getDBO();
	$user	=& JFactory::getUser();
	 
	if (is_array( $areas ))
	{
		if (!array_intersect( $areas, array_keys( plgSearchAreas() ) ))
		{
			return array();
		}
	}

	// load plugin params info
	$plugin			=& JPluginHelper::getPlugin('search', 'joomleague');
	$pluginParams		= new JParameter( $plugin->params );
	$search_clubs 		= $pluginParams->get( 'search_clubs', 		1 );
	$search_teams 		= $pluginParams->get( 'search_teams', 		1 );
	$search_persons 	= $pluginParams->get( 'search_persons', 	1 );
	$search_playground 	= $pluginParams->get( 'search_playground', 	1 );

	$text = trim( $text );
	if ($text == '') { return array(); }
	 
	$wheres = array();
	 
	switch ($phrase)
	{
		 
		case 'any':
		default:
			$words = explode( ' ', $text );
			$wheres = array();
			$wheresteam = array();
			$wheresperson = array();
			$wheresplayground = array();

			if ( $search_clubs )
			{
				foreach ($words as $word)
				{
					$word		= $db->Quote( '%'.$db->getEscaped( $word, true ).'%', false );
					$wheres2 	= array();
					$wheres2[] 	= 'c.name LIKE '.$word;
					$wheres2[] 	= 'c.alias LIKE '.$word;
					$wheres2[] 	= 'c.location LIKE '.$word;

					$wheres[] 	= implode( ' OR ', $wheres2 );
				}
			}


			if ( $search_teams )
			{
				foreach ($words as $word)
				{
					$word		= $db->Quote( '%'.$db->getEscaped( $word, true ).'%', false );
					$wheres2 	= array();
					$wheres2[] 	= 't.name LIKE '.$word;
					$wheresteam[] 	= implode( ' OR ', $wheres2 );
				}
			}

			if ( $search_persons )
			{
				foreach ($words as $word)
				{
					$word		= $db->Quote( '%'.$db->getEscaped( $word, true ).'%', false );
					$wheres2 	= array();
					$wheres2[] 	= 'pe.firstname LIKE '.$word;
					$wheres2[] 	= 'pe.lastname LIKE '.$word;
					$wheres2[] 	= 'pe.nickname LIKE '.$word;
					$wheresperson[] 	= implode( ' OR ', $wheres2 );
				}
			}

			if ( $search_playground )
			{
				foreach ($words as $word)
				{
					$word		= $db->Quote( '%'.$db->getEscaped( $word, true ).'%', false );
					$wheres2 	= array();
					$wheres2[] 	= 'pl.name LIKE '.$word;
					$wheres2[] 	= 'pl.city LIKE '.$word;


					$wheresplayground[] 	= implode( ' OR ', $wheres2 );
				}
			}
				
				
			$where = '(' . implode( ($phrase == 'all' ? ') AND (' : ') OR ('), $wheres ) . ')';
			$whereteam = '(' . implode( ($phrase == 'all' ? ') AND (' : ') OR ('), $wheresteam ) . ')';
			$wheresperson = '(' . implode( ($phrase == 'all' ? ') AND (' : ') OR ('), $wheresperson ) . ')';
			$wheresplayground = '(' . implode( ($phrase == 'all' ? ') AND (' : ') OR ('), $wheresplayground ) . ')';
			break;
				
			 
	}
	 
	 
	$rows = array();
	 
	if ( $search_clubs )
	{
		$query = "SELECT CONCAT( 'Club: ', c.name ) AS title,"
		." c.founded AS created,"
		." CONCAT( 'Address: ',c.address,' ',c.zipcode,' ',c.location,' Phone: ',c.phone,' Fax: ',c.fax,' E-Mail: ',c.email ) AS text,"
		." pt.project_id AS project,"
		." CONCAT( 'index.php?option=com_joomleague"
		."&view=clubinfo&cid=', c.id,'&p=', pt.project_id ) AS href,"
		." '2' AS browsernav"
		." FROM #__joomleague_club AS c"
		." LEFT JOIN #__joomleague_team AS t"
		." ON c.id = t.club_id"
		." LEFT JOIN #__joomleague_project_team AS pt"
		." ON pt.team_id = t.id"
		." WHERE ( ".$where." ) "
		." GROUP BY c.name ORDER BY c.name";

		$db->setQuery( $query );
		//echo($db->getQuery()."<hr>");
		$list1 = $db->loadObjectList();
		$rows[] = $list1;
	}
	 
	if ( $search_teams )
	{
		$query = "SELECT CONCAT( 'Team: ', t.name ) AS title,"
		." t.checked_out_time AS created,"
		." t.notes AS text,"
		." pt.project_id AS project, "
		." CONCAT( 'index.php?option=com_joomleague"
		."&view=teaminfo&tid=', t.id,'&p=', pt.project_id ) AS href,"
		." '2' AS browsernav"
		." FROM #__joomleague_team AS t"
		." LEFT JOIN #__joomleague_project_team AS pt"
		." ON pt.team_id = t.id"
		." WHERE ( ".$whereteam." ) "
		." GROUP BY t.name ORDER BY t.name";
		 
		$db->setQuery( $query );
		//echo($db->getQuery()."<hr>");
		$list2 = $db->loadObjectList();
		$rows[] = $list2;
	}
	 
	 
	if ( $search_persons )
	{

		$query = "SELECT REPLACE(CONCAT('Person: ', pe.firstname, ' \'', pe.nickname, '\' ' , pe.lastname ),'\'\'','') AS title,"
		." pe.birthday AS created,"
		." CONCAT( 'Birthday:',pe.birthday , ' Notes:', pe.notes ) AS text,"
		." CONCAT( '<img src=\"',pe.picture ,'\" width=\"50\" height=\"\" >' ) AS section,"
		." pt.project_id AS project,"
		." CONCAT( 'index.php?option=com_joomleague"
		."&view=player&pid=', pe.id,'&p=', pt.project_id ) AS href,"
		." '2' AS browsernav"
		." FROM #__joomleague_person AS pe"
		." LEFT JOIN #__joomleague_team_player AS tp"
		." ON tp.person_id = pe.id"
		." LEFT JOIN #__joomleague_project_team AS pt"
		." ON pt.id = tp.projectteam_id"
		." WHERE ( ".$wheresperson." ) "
                ." AND pe.published = '1' "
		." GROUP BY pe.lastname, pe.firstname, pe.nickname ORDER BY pe.lastname,pe.firstname,pe.nickname";

		$db->setQuery( $query );
		//echo($db->getQuery()."<hr>");
		$list3 = $db->loadObjectList();
		$rows[] = $list3;
		 
	}

	if ( $search_playground )
	{

		$query = "SELECT CONCAT( 'Playground: ', pl.name ) AS title,"
		." pl.checked_out_time AS created,"
		." pl.notes AS text,"
		." r.project_id AS project,"
		." CONCAT( 'index.php?option=com_joomleague"
		."&view=playground&pgid=', pl.id,'&p=', r.project_id ) AS href,"
		." '2' AS browsernav"
		." FROM #__joomleague_playground AS pl"
		." LEFT JOIN #__joomleague_club AS c"
		." ON c.id = pl.club_id"
		." LEFT JOIN #__joomleague_match AS m"
		." ON m.playground_id = pl.id"
		." LEFT JOIN #__joomleague_round AS r"
		." ON m.round_id = r.id"
		." WHERE ( ".$wheresplayground." ) "
		." GROUP BY pl.name ORDER BY pl.name ";

		$db->setQuery( $query );
		//echo($db->getQuery()."<hr>");
		$list4 = $db->loadObjectList();
		$rows[] = $list4;
	}

	$results = array();
	 
	if(count($rows))
	{
		foreach($rows as $row)
		{
			$results = array_merge($results, (array) $row);
		}
	}
	return $results;
}

?>