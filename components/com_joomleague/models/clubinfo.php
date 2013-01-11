<?php defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );

require_once( JLG_PATH_SITE . DS . 'models' . DS . 'project.php' );
//include_once JPATH_COMPONENT . DS . 'helpers' . DS . 'easygooglemap.php';


//include_once JPATH_COMPONENT . DS . 'helpers' . DS . 'GoogleMap.php';
//include_once JPATH_COMPONENT . DS . 'helpers' . DS . 'JSMin.php';

/*
diddipoeler

include_once JPATH_COMPONENT . DS . 'helpers' . DS . 'feedreaderhelperr.php';
require_once(JPATH_COMPONENT_SITE . DS . 'helpers' . DS . 'simple-gmap-api' . DS . "simpleGMapAPI.php");
require_once(JPATH_COMPONENT_SITE . DS . 'helpers' . DS . 'simple-gmap-api' . DS . "simpleGMapGeocoder.php");
*/

class JoomleagueModelClubInfo extends JoomleagueModelProject
{
	var $projectid = 0;
	var $clubid = 0;
	var $club = null;
	var $jltable = '#__joomleague_club';

	function __construct( )
	{
		parent::__construct( );

		$this->projectid = JRequest::getInt( "p", 0 );
		$this->clubid = JRequest::getInt( "cid", 0 );
	}

	function getClub( )
	{
		if ( is_null( $this->club ) )
		{
			if ( $this->clubid > 0 )
			{
			$query = "SHOW COLUMNS FROM ".$this->jltable;
        $this->_db->setQuery($query);
        $result2 = $this->_db->loadAssocList('Field');
        foreach( $result2 as $key => $value )
        {
        $fields[] = 'c.'.$value['Field'];   
        }
        $fields = implode(",",$fields);
        
				$query = ' SELECT '.$fields
				       . ' FROM #__joomleague_club AS c '
				       . ' WHERE c.id = '. $this->_db->Quote($this->clubid)
				            ;
				$this->_db->setQuery($query);
				$this->club = $this->_db->loadObject();
			}
		}
		return $this->club;
	}

	function getTeams( )
	{
		$teams = array( 0 );
		if ( $this->clubid > 0 )
		{
			$query = ' SELECT id, '
				     	. ' CASE WHEN CHAR_LENGTH( alias ) THEN CONCAT_WS( \':\', id, alias ) ELSE id END AS slug, '
				       . ' name as team_name, '
				       . ' short_name as team_shortcut, '
				       . ' info as team_description '
				       . ',(select max(project_id) from #__joomleague_project_team right join #__joomleague_project p on project_id=p.id where team_id=t.id and p.published = 1) as pid'
				       . ' FROM #__joomleague_team t'
				       . ' WHERE club_id = '.(int) $this->clubid;

			$this->_db->setQuery( $query );
			$teams = $this->_db->loadObjectList();
		}
		return $teams;
	}

	function getStadiums()
	{
		$stadiums = array();
    $team_ids = array();
    
		$club = $this->getClub();
		if ( !isset( $club ) )
		{
			return null;
		}
		if ( $club->standard_playground > 0 )
		{
			$stadiums[] = $club->standard_playground;
		}
		$teams = $this->getTeams();

		if ( count( $teams > 0 ) )
		{
			foreach ($teams AS $team )
			{
			  $team_ids[] = $team->id;
// 				$query = ' SELECT distinct(standard_playground) '
// 				       . ' FROM #__joomleague_project_team '
// 				       . ' WHERE team_id = '.(int)$team->id
// 				       . ' AND standard_playground > 0';
// 				if ( $club->standard_playground > 0 )
// 				{
// 					$query .= ' AND standard_playground <> '.$club->standard_playground;
// 				}
// 				$this->_db->setQuery($query);
// 				if ( $res = $this->_db->loadResult() )
// 				{
// 					$stadiums[] = $res;
// 				}
			}
			
			$query = ' SELECT distinct(standard_playground) '
				       . ' FROM #__joomleague_project_team '
				       . ' WHERE team_id IN ('.implode(",",$team_ids).')'
				       . ' AND standard_playground > 0';
				if ( $club->standard_playground > 0 )
				{
					$query .= ' AND standard_playground <> '.$club->standard_playground;
				}
				$this->_db->setQuery($query);
				if ( $res = $this->_db->loadResult() )
				{
					$stadiums[] = $res;
				}
			
		}
		return $stadiums;
	}

	function getPlaygrounds( )
	{
		$playgrounds = array();

		$stadiums = $this->getStadiums();
		if ( !isset ( $stadiums ) )
		{
			return null;
		}

		foreach ( $stadiums AS $stadium )
		{
			$query = '	SELECT id AS value, name AS text, pl.*, '
    			     . ' CASE WHEN CHAR_LENGTH( pl.alias ) THEN CONCAT_WS( \':\', pl.id, pl.alias ) ELSE pl.id END AS slug '
				     . ' FROM #__joomleague_playground AS pl '
				     . ' WHERE id = '. $this->_db->Quote($stadium)
			            ;
			$this->_db->setQuery($query, 0, 1);
			$playgrounds[] = $this->_db->loadObject();
		}
		return $playgrounds;
	}

	function getAllowed( )
	{
		$allowed = false;

		$user = & JFactory::getUser();

		if ( $user->id > 0 )
		{
			$club = $this->getClub();
			$auth = & JFactory::getACL();
			$project = &$this->getProject();

			$aro_group = $auth->getAroGroup( $user->id );
			if ( ( strtolower($aro_group->name) == 'super administrator' ) ||
			( strtolower($aro_group->name) == 'administrator' ) ||
			( $user->id == $project->admin ) ||
			( $user->id == $project->editor ) ||
			( $user->id == $club->admin ) )
			{
				$allowed = true;
			}
		}
		return $allowed;
	}

  function getUserfields()
    {
    $query = "SELECT * FROM #__joomleague_jltable_fields 
    where userfield = 1 
    and tablename like '".$this->jltable."'";
	$this->_db->setQuery($query);    
    $result = $this->_db->loadObjectList();    
        
        
        
    return $result;    
    }
    
	function getGoogleApiKey( )
	{
		$params =& JComponentHelper::getParams('com_joomleague');
		$apikey=$params->get('cfg_google_api_key');
		return $apikey;
	}

	function getGoogleMap( $mapconfig, $address_string = "" )
	{
		$gm = null;

		$google_api_key = $this->getGoogleApiKey();
		if ( ( trim( $google_api_key ) != "" ) &&
		( trim( $address_string ) != "" ) )
		{
			$gm = new EasyGoogleMap( $google_api_key, "jl_pg_map" );

			$width = ( is_int( $mapconfig['width'] ) ) ? $mapconfig['width'].'px' : $mapconfig['width'];

			$gm->SetMapWidth( $mapconfig['width'] );
			$gm->SetMapHeight( $mapconfig['height'] );
			$gm->SetMapControl( $mapconfig['map_control'] );
			$gm->SetMapDefaultType( $mapconfig['default_map_type'] );

			if ( intval( $mapconfig['map_zoom'] ) > 0 )
			{
				$gm->SetMapZoom( intval( $mapconfig['map_zoom'] ) );
			}

			$gm->mScale = ( intval( $mapconfig['map_scale'] ) > 0 ) ? TRUE : FALSE;
			$gm->mMapType = ( intval( $mapconfig['map_type_select']) > 0 ) ? TRUE : FALSE;
			$gm->mContinuousZoom = ( intval( $mapconfig['cont_zoom']) > 0 ) ? TRUE : FALSE;
			$gm->mDoubleClickZoom = ( intval( $mapconfig['dblclick_zoom']) > 0 ) ? TRUE : FALSE;
			$gm->mInset = ( intval( $mapconfig['map_inset'] ) > 0 ) ? TRUE : FALSE;
			$gm->mShowMarker = ( intval( $mapconfig['show_marker'] ) > 0 ) ? TRUE : FALSE;
			$gm->SetMarkerIconStyle( $mapconfig['map_icon_style'] );
			$gm->SetMarkerIconColor( $mapconfig['map_icon_color'] );
			$gm->SetAddress( $address_string );
		}
		return $gm;
	}

	function getAddressString( )
	{
		$club = $this->getClub();
		if ( !isset ( $club ) ) { return null; }

		$address_parts = array();
		if (!empty($club->address))
		{
			$address_parts[] = $club->address;
		}
		if (!empty($club->state))
		{
			$address_parts[] = $club->state;
		}
		if (!empty($club->location))
		{
			if (!empty($club->zipcode))
			{
				$address_parts[] = $club->zipcode. ' ' .$club->location;
			}
			else
			{
				$address_parts[] = $club->location;
			}
		}
		if (!empty($club->country))
		{
			$address_parts[] = Countries::getShortCountryName($club->country);
		}
		$address = implode(', ', $address_parts);
		return $address;
	}

}
?>