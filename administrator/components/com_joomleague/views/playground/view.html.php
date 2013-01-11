<?php
/**
 * @copyright	Copyright (C) 2006-2012 JoomLeague.net. All rights reserved.
 * @license		GNU/GPL,see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License,and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

require_once (JPATH_COMPONENT.DS.'helpers'.DS.'imageselect.php');

/**
 * HTML View class for the Joomleague component
 *
 * @static
 * @package	JoomLeague
 * @since	0.1
 */
class JoomleagueViewPlayground extends JLGView
{
	function display($tpl=null)
	{
		if($this->getLayout() == 'form')
		{
			$this->_displayForm($tpl);
			return;
		}

		//get the club
		$venue =& $this->get('data');

		parent::display($tpl);
	}

	function _displayForm($tpl)
	{
		$option='com_joomleague';
		$mainframe =& JFactory::getApplication();
		$db =& JFactory::getDBO();
		$uri =& JFactory::getURI();
		$user =& JFactory::getUser();
		$model =& $this->getModel();
		$lists=array();
		//get the venue
		$venue =& $this->get('data');
		$isNew=($venue->id < 1);
		// fail if checked out not by 'me'
		if ($model->isCheckedOut($user->get('id')))
		{
			$msg=JText::sprintf('DESCBEINGEDITTED',JText::_('JL_ADMIN_PLAYGROUND_THEPLAYGROUND'),$venue->name);
			$mainframe->redirect('index.php?option='. $option,$msg);
		}

		// Edit or Create?
		if (!$isNew)
		{
			$model->checkout($user->get('id'));
		}
		else
		{
			// initialise new record
			$venue->order=0;
		}

		// build the html select list for ordering
		$query = $model->getOrderingAndPlaygroundQuery();
		$lists['ordering'] 	= JHTML::_('list.specificordering',$venue,$venue->id,$query,1);

		//build the html select list for countries
		$countries[]=JHTML::_('select.option','0',JText::_('JL_GLOBAL_SELECT_COUNTRY'));
		if ($res =& Countries::getCountryOptions()){$countries=array_merge($countries,$res);}
		$lists['countries']=JHTML::_('select.genericlist',$countries,'country','class="inputbox" size="1"','value','text',$venue->country);
    	unset($countries);

		//build the html select list for clubs
		$clubs[]=JHTML::_('select.option','0',JText::_('JL_GLOBAL_SELECT_CLUB'),'id','name');
		if ($res=& $this->get('Clubs')){$clubs=array_merge($clubs,$res);}
		$lists['clubs']=JHTML::_('select.genericlist',$clubs,'club_id','class="inputbox" size="1"','id','name',$venue->club_id);
    	unset($clubs);

		// image selector
                $default = JoomleagueHelper::getDefaultPlaceholder("clublogobig");
		if (empty($venue->picture)){$venue->picture=$default;}

		$imageselect=ImageSelect::getSelector('picture','picture_preview','playgrounds',$venue->picture,$default);

		/*
		 * extended data
		 */
		$paramsdata=$venue->extended;
		$paramsdefs=JPATH_COMPONENT.DS.'assets'.DS.'extended'.DS.'playground.xml';
		$extended=new JLGExtraParams($paramsdata,$paramsdefs);

    $this->assignRef( 'address_string',	$model->getAddressString() );
    $this->assignRef( 'address_geocode',	$model->JLgetGeoCoords($this->address_string) );
    
    foreach ( $extended->getGroups() as $key => $groups )
		{
		
    if ( $this->address_geocode )
		{
		foreach ( $this->address_geocode['results'][0]['address_components'] as $georesult )
		{
    
    if ( $georesult['types'][0] == 'administrative_area_level_1' )
    {
    $extended->set('JL_ADMINISTRATIVE_AREA_LEVEL_1_LONG_NAME', $georesult['long_name']);
    $extended->set('JL_ADMINISTRATIVE_AREA_LEVEL_1_SHORT_NAME', $georesult['short_name']);
    }
    if ( $georesult['types'][0] == 'administrative_area_level_2' )
    {
    $extended->set('JL_ADMINISTRATIVE_AREA_LEVEL_2_LONG_NAME', $georesult['long_name']);
    $extended->set('JL_ADMINISTRATIVE_AREA_LEVEL_2_SHORT_NAME', $georesult['short_name']);
    }
    if ( $georesult['types'][0] == 'administrative_area_level_3' )
    {
    $extended->set('JL_ADMINISTRATIVE_AREA_LEVEL_3_LONG_NAME', $georesult['long_name']);
    $extended->set('JL_ADMINISTRATIVE_AREA_LEVEL_3_SHORT_NAME', $georesult['short_name']);
    }
    
    if ( $georesult['types'][0] == 'locality' )
    {
    $extended->set('JL_LOCALITY_LONG_NAME', $georesult['long_name']);
    }
    if ( $georesult['types'][0] == 'sublocality' )
    {
    $extended->set('JL_SUBLOCALITY_LONG_NAME', $georesult['long_name']);
    }
    
    }
    }
		else
		{
    $this->assignRef( 'address_geocode_lat_long',	$model->JLgetLatLongGeoCoords($this->address_string) );
    $lat = $this->address_geocode_lat_long['2'];
    $lng = $this->address_geocode_lat_long['3'];
    $extended->set('JL_ADMINISTRATIVE_AREA_LEVEL_1_LATITUDE', $lat);
    $extended->set('JL_ADMINISTRATIVE_AREA_LEVEL_1_LONGITUDE', $lng);
    }
    
    }
    
		$this->assignRef('extended',$extended);
		$this->assignRef('imageselect',$imageselect);
		$this->assignRef('lists',$lists);
		$this->assignRef('venue',$venue);

		parent::display($tpl);
	}

}
?>