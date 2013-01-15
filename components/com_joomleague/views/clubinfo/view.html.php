<?php defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

require_once( JPATH_COMPONENT . DS . 'helpers' . DS . 'pagination.php' );
require_once(JPATH_COMPONENT.DS.'helpers'.DS.'imageselect.php');

class JoomleagueViewClubInfo extends JLGView
{

	function display( $tpl = null )
	{
		// Get a refrence of the page instance in joomla
		$document	=& JFactory::getDocument();

		$model		=& $this->getModel();
		$club		= $model->getClub() ;
		$config		= $model->getTemplateConfig( $this->getName() );

    // select userfields
    $userfields = $model->getUserfields();
    $this->assignRef('userfields',$userfields);
        
		$this->assignRef( 'project',		$model->getProject() );
		$this->assignRef( 'overallconfig',	$model->getOverallConfig() );
		$this->assignRef( 'config',			$config );

		$this->assignRef( 'showclubconfig',	$showclubconfig );
		$this->assignRef( 'club',			$club);

		$paramsdata	= $club->extended;
		$paramsdefs	= JLG_PATH_ADMIN . DS . 'assets' . DS . 'extended' . DS . 'club.xml';
		$extended	= new JLGExtraParams( $paramsdata, $paramsdefs );

    /*
    * league extended data
    */
    $paramsdata_league = $this->project->league_extended;
    $paramsdefs_league = JLG_PATH_ADMIN.DS.'assets'.DS.'extended'.DS.'league.xml';
    $extended_league = new JLGExtraParams($paramsdata_league,$paramsdefs_league);
    $this->assignRef('league_extended',$extended_league);
    $this->assign('show_debug_info', JComponentHelper::getParams('com_joomleague')->get('show_debug_info',0) );
    
    if ( ($this->config['show_club_rssfeed']) == 1 )
	  {
    $mod_name               = "mod_jw_srfr"; 
    $this->params =	$extended;
    $rssfeedlink = $this->params->get('club_rss_feed_link');
    
    //echo 'rssfeed<br><pre>'.print_r($rssfeedlink,true).'</pre><br>';
    
    if ( $rssfeedlink )
    {
    $srfrFeedsArray 							= explode("\n",$rssfeedlink);
    $perFeedItems 								= $this->overallconfig['perFeedItems'];
    $totalFeedItems 							= $this->overallconfig['totalFeedItems'];
    $feedTimeout									= $this->overallconfig['feedTimeout'];
    $this->assignRef( 'feedTitle' , $this->overallconfig['feedTitle'] );
    $this->assignRef( 'feedFavicon' , $this->overallconfig['feedFavicon'] );
    $this->assignRef( 'feedItemTitle' , $this->overallconfig['feedItemTitle'] );
    $this->assignRef( 'feedItemDate' , $this->overallconfig['feedItemDate'] );
    $feedItemDateFormat						= $this->overallconfig['feedItemDateFormat'];
    $this->assignRef( 'feedItemDescription' , $this->overallconfig['feedItemDescription'] );
    $feedItemDescriptionWordlimit	= $this->overallconfig['feedItemDescriptionWordlimit'];
    $feedItemImageHandling				= $this->overallconfig['feedItemImageHandling'];
    $feedItemImageResizeWidth			= $this->overallconfig['feedItemImageResizeWidth'];
    $feedItemImageResampleQuality	= $this->overallconfig['feedItemImageResampleQuality'];
    $this->assignRef( 'feedItemReadMore' , $this->overallconfig['feedItemReadMore'] );
    
    $this->assignRef( 'feedsBlockPreText' ,	$this->overallconfig['feedsBlockPreText'] );
    $this->assignRef( 'feedsBlockPostText' , $this->overallconfig['feedsBlockPostText'] );
    $this->assignRef( 'feedsBlockPostLink' , $this->overallconfig['feedsBlockPostLink'] );
    $feedsBlockPostLinkURL				= $this->overallconfig['feedsBlockPostLinkURL'];
    $feedsBlockPostLinkTitle			= $this->overallconfig['feedsBlockPostLinkTitle'];
    $srfrCacheTime								= $this->overallconfig['srfrCacheTime'];
    $cacheLocation								= 'cache'.DS.$mod_name;
    $this->assignRef( 'rssfeedoutput',SimpleRssFeedReaderHelper::getFeeds($srfrFeedsArray,$totalFeedItems,$perFeedItems,$feedTimeout,$feedItemDateFormat,$feedItemDescriptionWordlimit,$cacheLocation,$srfrCacheTime,$feedItemImageHandling,$feedItemImageResizeWidth,$feedItemImageResampleQuality,$this->feedFavicon) );
    $css = 'components/com_joomleague/assets/css/rssfeedstyle.css';
		$document->addStyleSheet($css); 
		}
    }
  
		$this->assignRef( 'extended',		$extended );

		$this->assignRef( 'teams',			$model->getTeams() );
		$this->assignRef( 'stadiums',		$model->getStadiums() );
		$this->assignRef( 'playgrounds',	$model->getPlaygrounds() );
		$this->assignRef( 'showediticon',	$model->getAllowed() );

		$this->assignRef( 'address_string',	$model->getAddressString() );
		$this->assignRef( 'mapconfig',		$model->getMapConfig() ); // Loads the project-template -settings for the GoogleMap

		//$this->assignRef( 'gmap',			$model->getGoogleMap( $this->mapconfig, $this->address_string ) );

    if (($this->config['show_maps'])==1)
	  {
	  
	  foreach ( $extended->getGroups() as $key => $groups )
		{
		$lat = $extended->get('JL_ADMINISTRATIVE_AREA_LEVEL_1_LATITUDE');
    $lng = $extended->get('JL_ADMINISTRATIVE_AREA_LEVEL_1_LONGITUDE');
		}
		
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
  
  //$this->map->addMarkerByAddress($this->address_string, $this->club->name, '"<a href="'.$this->club->website.'" target="_blank">'.$this->club->website.'</a>"', "http://maps.google.com/mapfiles/kml/pal2/icon49.png");  
  if ( $lat && $lng )
  {
  $this->map->addMarker($lat, $lng, $this->club->name, $this->address_string,JURI::root().'media/com_joomleague/map_icons/'.'icon49.png' );
  }
  
  $document->addScript($this->map->JLprintGMapsJS());
  $document->addScriptDeclaration($this->map->JLshowMap(false));
  
	}
	
		$pageTitle = JText::_( 'JL_CLUBINFO_PAGE_TITLE' );
		if ( isset( $this->club ) )
		{
			$pageTitle .= ': ' . $this->club->name;
		}
		$document->setTitle( $pageTitle );

		if ( $this->getLayout() == 'edit' )
		{
			$this->edit( $tpl );
		}
		else
		{
			parent::display( $tpl );
		}
	}


	function edit( $tpl = null )
	{
		$document =& JFactory::getDocument();
		$version = urlencode(JoomleagueHelper::getVersion());
		$css = 'components/com_joomleague/assets/css/tabs.css?v='.$version;
		$document->addStyleSheet($css);

		// Set page title
		$document->setTitle( JText::_( 'JL_EDIT_CLUBINFO_CLUB_PAGE_TITLE' ) .  ' - ' . $this->club->name );

		// Joomleague model
		$model =& $this->getModel();

		$this->assignRef( 'project', $model->getProject() );

		$countrycode = explode( "_", JText::_('JL_LOCALE') );

		// Edit Club Info model
		$model = $this->getModel( "clubinfo" );

		$club = $model->getClub();

		//build the html select list for countries
		$countries[] = JHTML::_( 'select.option', '', '- ' . JText::_( 'Select country' ) . ' -' );
		if ( $res =& Countries::getCountryOptions() )
		{
			$countries = array_merge( $countries, $res );
		}
		$countrieslist = JHTML::_(	'select.genericlist',
		$countries,
									'country',
									'class="inputbox" size="1"',
									'value',
									'text',
		$club->country );
		unset($countries);

		//build the html select list for playgrounds
		$playgrounds[] = JHTML::_( 'select.option', '0', '- ' . JText::_( 'Select playground' ) . ' -' );
		if ( $res =& $model->getPlaygrounds() )
		{
			$playgrounds = array_merge( $playgrounds, $res );
		}
		$playgroundslist = JHTML::_(	'select.genericlist',
		$playgrounds,
										'standard_playground',
										'class="inputbox" size="1"',
										'value',
										'text',
		$club->standard_playground );
		unset($playgrounds);

		// logo_big
		//if there is no logo selected,use default logo
		$default_big = JoomleagueHelper::getDefaultPlaceholder("clublogobig");
		if (empty($club->logo_big)){$club->logo_big=$default_big;}

		$logo_bigselect=ImageSelect::getSelector('logo_big','logo_big_preview','clubs_large',$club->logo_big,$default_big);

		// logo_middle
		//if there is no logo selected,use default logo
		$default_middle = JoomleagueHelper::getDefaultPlaceholder("clublogomedium");
		if (empty($club->logo_middle)){$club->logo_middle=$default_middle;}

		$logo_middleselect=ImageSelect::getSelector('logo_middle','logo_middle_preview','clubs_medium',$club->logo_middle,$default_middle);


		// logo_small
		//if there is no logo selected,use default logo
		$default_small = JoomleagueHelper::getDefaultPlaceholder("clublogosmall");
		if (empty($club->logo_small)){$club->logo_small=$default_small;}

		$logo_smallselect=ImageSelect::getSelector('logo_small','logo_small_preview','clubs_small',$club->logo_small,$default_small);

		$this->assignRef( 'club',				$club );
		$this->assignRef( 'countrieslist',		$countrieslist );
		$this->assignRef( 'playgroundslist',	$playgroundslist );
		$this->assignRef('logo_bigselect',$logo_bigselect);
		$this->assignRef('logo_middleselect',$logo_middleselect);
		$this->assignRef('logo_smallselect',$logo_smallselect);
		$this->assignRef( 'allowed',			$model->getAllowed( ) );

		parent::display( $tpl );
	}

}
?>