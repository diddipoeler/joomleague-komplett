<?php
/**
 * @version	 $Id$
 * @package	 Joomla
 * @subpackage  Joomleague Statistik module
 * @copyright   Copyright (C) 2008 Open Source Matters. All rights reserved.
 * @license	 GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');



/**
 * Statistik Module helper
 *
 * @package Joomla
 * @subpackage Joomleague Statistik module
 * @since		1.0
 */
class modJLGStatistikHelper
{



	/**
	 * Method to get the list
	 *
	 * @access public
	 * @return array
	 */
	function getData($params)
	{
		global $mainframe;
    $db  = &JFactory::getDBO();

    //$language=& JFactory::getLanguage(); //get the current language
    //echo 'Current language is: ' . $language->getName() . '<br>';
    //$language->load( 'mod_joomleague_statistik' );
    
if ($params->get('joomleague_stat_torschuetzen') )
{		
$query  = '	SELECT count(*) as total
FROM #__joomleague_match_event
WHERE event_type_id  = 1';

$db->setQuery( $query );
$anzahl  = $db->loadResult();

$temp  = new stdClass();
$temp->image  = 'modules/mod_joomleague_statistik/images/goal.png';
$temp->text  = JText::_( 'SHOW GOALS' );
$temp->anzahl  = $anzahl;
$result[]  = $temp;
$result  = array_merge($result);
}

if ( $params->get('joomleague_stat_gelbe_karten'))
{		
$type = $params->get('yellowcard');
$query  = '	SELECT count(*) as total
FROM #__joomleague_match_event
WHERE event_type_id  = '. $type;

$db->setQuery( $query );
$anzahl  = $db->loadResult();

$temp  = new stdClass();
$temp->image  = 'modules/mod_joomleague_statistik/images/yellow_card.gif';
$temp->text  = JText::_( 'SHOW YELLOW CARD' );
$temp->anzahl  = $anzahl;
$result[]  = $temp;
$result  = array_merge($result);
}


if ($params->get('joomleague_stat_gelb_rote_karten') )
{		
$type = $params->get('yellowredcard');
$query  = '	SELECT count(*) as total
FROM #__joomleague_match_event
WHERE event_type_id  = '.$type;

$db->setQuery( $query );
$anzahl  = $db->loadResult();

$temp  = new stdClass();
$temp->image  = 'modules/mod_joomleague_statistik/images/yellow_red_card.gif';
$temp->text  = JText::_( 'SHOW YELLOW RED CARD' );
$temp->anzahl  = $anzahl;
$result[]  = $temp;
$result  = array_merge($result);
}

if ($params->get('joomleague_stat_rote_karten') )
{		
$type = $params->get('redcard');
$query  = '	SELECT count(*) as total
FROM #__joomleague_match_event
WHERE event_type_id  = '.$type;

$db->setQuery( $query );
$anzahl  = $db->loadResult();

$temp  = new stdClass();
$temp->image  = 'modules/mod_joomleague_statistik/images/red_card.gif';
$temp->text  = JText::_( 'SHOW RED CARD' );
$temp->anzahl  = $anzahl;
$result[]  = $temp;
$result  = array_merge($result);
}


if ($params->get('joomleague_stat_vereine') )
{		
$query  = '	SELECT count(*) as total
FROM #__joomleague_club
';

$db->setQuery( $query );
$anzahl  = $db->loadResult();

$temp  = new stdClass();
$temp->image  = 'modules/mod_joomleague_statistik/images/clubs.png';
$temp->text  = JText::_( 'SHOW CLUB' );
$temp->anzahl  = $anzahl;
$result[]  = $temp;
$result  = array_merge($result);
}

if ($params->get('joomleague_stat_mannschaften') )
{		
$query  = '	SELECT count(*) as total
FROM #__joomleague_team
';

$db->setQuery( $query );
$anzahl  = $db->loadResult();

$temp  = new stdClass();
$temp->image  = 'modules/mod_joomleague_statistik/images/teams.png';
$temp->text  = JText::_( 'SHOW TEAM' );
$temp->anzahl  = $anzahl;
$result[]  = $temp;
$result  = array_merge($result);
}

if ($params->get('joomleague_stat_divisionen') )
{		
$query  = '	SELECT count(*) as total
FROM #__joomleague_division
';

$db->setQuery( $query );
$anzahl  = $db->loadResult();

$temp  = new stdClass();
$temp->image  = 'modules/mod_joomleague_statistik/images/division.png';
$temp->text  = JText::_( 'SHOW DIVISION' );
$temp->anzahl  = $anzahl;
$result[]  = $temp;
$result  = array_merge($result);
}

if ( $params->get('joomleague_stat_schiedsrichter'))
{		
$query  = '	SELECT count(*) as total
FROM #__joomleague_project_referee
';

$db->setQuery( $query );
$anzahl  = $db->loadResult();

$temp  = new stdClass();
$temp->image  = 'modules/mod_joomleague_statistik/images/referee.png';
$temp->text  = JText::_( 'SHOW REFEREE' );
$temp->anzahl  = $anzahl;
$result[]  = $temp;
$result  = array_merge($result);
}

if ($params->get('joomleague_stat_spieler') )
{		
$query  = '	SELECT count(*) as total
FROM #__joomleague_person
';

$db->setQuery( $query );
$anzahl  = $db->loadResult();

$temp  = new stdClass();
$temp->image  = 'modules/mod_joomleague_statistik/images/players.png';
$temp->text  = JText::_( 'SHOW PLAYER' );
$temp->anzahl  = $anzahl;
$result[]  = $temp;
$result  = array_merge($result);
}

if ($params->get('joomleague_stat_spielorte') )
{		
$query  = '	SELECT count(*) as total
FROM #__joomleague_playground
';

$db->setQuery( $query );
$anzahl  = $db->loadResult();

$temp  = new stdClass();
$temp->image  = 'modules/mod_joomleague_statistik/images/playground.png';
$temp->text  = JText::_( 'SHOW VENUES' );
$temp->anzahl  = $anzahl;
$result[]  = $temp;
$result  = array_merge($result);
}

if ( $params->get('joomleague_stat_spieltage'))
{		
$query  = '	SELECT count(*) as total
FROM #__joomleague_round
';

$db->setQuery( $query );
$anzahl  = $db->loadResult();

$temp  = new stdClass();
$temp->image  = 'modules/mod_joomleague_statistik/images/matchdays.png';
$temp->text  = JText::_( 'SHOW ROUNDS' );
$temp->anzahl  = $anzahl;
$result[]  = $temp;
$result  = array_merge($result);
}

if ( $params->get('joomleague_stat_projekte'))
{				
$query  = '	SELECT count(*) as total
FROM #__joomleague_project
';

$db->setQuery( $query );
$anzahl  = $db->loadResult();

$temp  = new stdClass();
$temp->image  = 'modules/mod_joomleague_statistik/images/projects.png';
$temp->text  = JText::_( 'SHOW PROJECT' );
$temp->anzahl  = $anzahl;
$result[]  = $temp;
$result  = array_merge($result);
}

if ( $params->get('joomleague_stat_spielpaarungen'))
{		
$query  = '	SELECT count(*) as total
FROM #__joomleague_match
';

$db->setQuery( $query );
$anzahl  = $db->loadResult();

$temp  = new stdClass();
$temp->image  = 'modules/mod_joomleague_statistik/images/matches.png';
$temp->text  = JText::_( 'SHOW MATCHES' );
$temp->anzahl  = $anzahl;
$result[]  = $temp;
$result  = array_merge($result);
}
		
		
		
		return $result;
		
	}
	
	

	
}