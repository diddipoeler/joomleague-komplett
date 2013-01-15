<?php defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class JoomleagueViewPlayground extends JLGView
{
    function display( $tpl = null )
    {
        // Get a refrence of the page instance in joomla
        $document= & JFactory::getDocument();
        $jQueryCompressed = '.min';
        $jQueryHTTP = 'https';
        
        
        
        // Set page title
        $document->setTitle( JText::_( 'JL_PLAYGROUND_TITLE' ) );

        $model = & $this->getModel();
        $config = $model->getTemplateConfig($this->getName());

        $this->assignRef( 'project', $model->getProject() );
    /*
    * league extended data
    */
    $paramsdata_league = $this->project->league_extended;
    $paramsdefs_league = JLG_PATH_ADMIN.DS.'assets'.DS.'extended'.DS.'league.xml';
    $extended_league = new JLGExtraParams($paramsdata_league,$paramsdefs_league);
    $this->assignRef('league_extended',$extended_league);
    $this->assign('show_debug_info', JComponentHelper::getParams('com_joomleague')->get('show_debug_info',0) );
    
        $this->assignRef( 'overallconfig', $model->getOverallConfig() );
        $this->assignRef( 'config', $config );

        $jl_use_jquery_version = JComponentHelper::getParams('com_joomleague')->get('jl_use_jquery_version');
        $this->assignRef( 'jl_use_jquery_version', $jl_use_jquery_version );
        if ( $jl_use_jquery_version )
        {
        $jQueryVersion = JComponentHelper::getParams('com_joomleague')->get('jqueryversionfrontend');
        $jQuerySubversion = JComponentHelper::getParams('com_joomleague')->get('jquerysubversionfrontend');
        $jQueryUIVersion = JComponentHelper::getParams('com_joomleague')->get('jqueryuiversionfrontend');
        $jQueryUISubversion = JComponentHelper::getParams('com_joomleague')->get('jqueryuisubversionfrontend');
        $this->_jqpath = $jQueryHTTP."://ajax.googleapis.com/ajax/libs/jquery/".$jQueryVersion.$jQuerySubversion."/jquery".$jQueryCompressed.".js";
        $this->_jquipath = $jQueryHTTP."://ajax.googleapis.com/ajax/libs/jqueryui/".$jQueryUIVersion.$jQueryUISubversion."/jquery-ui".$jQueryCompressed.".js";
        $document->addScript($this->_jqpath);
        $document->addScript($this->_jquipath);
        
        if ( ($this->config['show_maps']) == 1 )
        {
        $document->addScript('http://maps.google.com/maps/api/js?sensor=false');
        }
        $document->addScript(JURI::base().'components/com_joomleague/assets/js/jquerynoconflict.js');
        
        }

        		



        $model = $this->getModel( 'playground' );
        $games = $model->getNextGames();
        $gamesteams = $model->getTeamsFromMatches( $games );
        $this->assignRef( 'playground',  $model->getPlayground() );
        $this->assignRef( 'teams', $model->getTeams() );
        $this->assignRef( 'games', $games );
        $this->assignRef( 'gamesteams', $gamesteams );

        $this->assignRef( 'mapconfig', $model->getMapConfig() );
        $this->assignRef( 'address_string', $model->getAddressString() );

        //$this->assignRef( 'gmap', $model->getGoogleMap( $this->mapconfig, $this->address_string ) );
        
        $paramsdata = $this->playground->extended;
		$paramsdefs = JLG_PATH_ADMIN . DS . 'assets' . DS . 'extended' . DS . 'playground.xml';
		$extended = new JLGExtraParams( $paramsdata, $paramsdefs );

    	$this->assignRef( 'extended', $extended );
    	
        if ( ($this->config['show_maps']) == 1 && $this->jl_use_jquery_version == 0 )
	  {
	  $this->map = new simpleGMapAPI();
  $this->geo = new simpleGMapGeocoder();
  $this->map->setWidth($this->mapconfig['width']);
  $this->map->setHeight($this->mapconfig['height']);
  $this->map->setZoomLevel($this->mapconfig['map_zoom']); 
  $this->map->setMapType($this->mapconfig['default_map_type']);
  $this->map->setBackgroundColor('#d0d0d0');
  $this->map->setMapDraggable(true);
  $this->map->setDoubleclickZoom(false);
  $this->map->setScrollwheelZoom(true);
  $this->map->showDefaultUI(false);
  $this->map->showMapTypeControl(true, 'DROPDOWN_MENU');
  $this->map->showNavigationControl(true, 'DEFAULT');
  $this->map->showScaleControl(true);
  $this->map->showStreetViewControl(true);
  $this->map->setInfoWindowBehaviour('SINGLE_CLOSE_ON_MAPCLICK');
  $this->map->setInfoWindowTrigger('CLICK');
  //$this->map->addMarkerByAddress($this->address_string, $this->playground->name, '"<a href="'.$this->playground->website.'" target="_blank">'.$this->playground->website.'</a>"', "http://maps.google.com/mapfiles/kml/pal2/icon49.png");  
  
  foreach ( $extended->getGroups() as $key => $groups )
		{
		$lat = $extended->get('JL_ADMINISTRATIVE_AREA_LEVEL_1_LATITUDE');
    $lng = $extended->get('JL_ADMINISTRATIVE_AREA_LEVEL_1_LONGITUDE');
		}
  
  if ( $lat && $lng )
  {
  $this->map->addMarker($lat, $lng, $this->playground->name, $this->address_string,JURI::root().'media/com_joomleague/map_icons/'.'icon49.png' );
  }
  
  $document->addScript($this->map->JLprintGMapsJS());
  $document->addScriptDeclaration($this->map->JLshowMap(false));
  
	}
        
        
        
        
        // $gm = $this->getModel( 'googlemap' );
        // $this->assignRef('gm', $gm->getGoogleMap( $model->getMapConfig(), $model->getAddressString() ) );

		
		
        // Set page title
        $pageTitle = JText::_( 'JL_PLAYGROUND_PAGE_TITLE' );
        if ( isset( $this->playground->name ) )
        {
			$pageTitle .= ' - ' . $this->playground->name;
        }
        $document->setTitle( $pageTitle );
        $document->addCustomTag( '<meta property="og:title" content="' . $this->playground->name .'"/>' );
        $document->addCustomTag( '<meta property="og:street-address" content="' . $this->address_string .'"/>' );
        parent::display( $tpl );
    }
}
?>