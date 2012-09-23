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
require_once(JPATH_COMPONENT.DS.'helpers'.DS.'imageselect.php');

/**
 * HTML View class for the Joomleague component
 *
 * @static
 * @package	JoomLeague
 * @since	0.1
 */
class JoomleagueViewClub extends JLGView
{

	function display($tpl=null)
	{
		if ($this->getLayout() == 'form')
		{
			$this->_displayForm($tpl);
			return;
		}

		//get the club
		$club =& $this->get('data');

		parent::display($tpl);
	}

	function _displayForm($tpl)
	{
		$option='com_joomleague';
		$mainframe =& JFactory::getApplication();
		$db		=& JFactory::getDBO();
		$uri 	=& JFactory::getURI();
		$user 	=& JFactory::getUser();
		$model	=& $this->getModel();

		$edit	= JRequest::getVar('edit',true);

		$lists=array();
		//get the club
		$club	=& $this->get('data');
		$isNew	= ($club->id < 1);

		// fail if checked out not by 'me'
		if ($model->isCheckedOut($user->get('id')))
		{
			$msg=JText::sprintf('DESCBEINGEDITTED',JText::_('JL_ADMIN_CLUB'),$club->name);
			$mainframe->redirect('index.php?option='.$option,$msg);
		}

		// Edit or Create?
		if (!$isNew)
		{
			$model->checkout($user->get('id'));
		}
		else
		{
			// initialise new record
			$club->order=0;
		}

		//build the html select list for admin
		$lists['admin']=JHTML::_('list.users','admin',$club->admin);

		// build the html select list for ordering
		$query = $model->getOrderingAndClubQuery();
		$lists['ordering'] 	= JHTML::_('list.specificordering',$club,$club->id,$query,1);

		//build the html select list for countries
		$countries[]=JHTML::_('select.option','',JText::_('JL_GLOBAL_SELECT_COUNTRY'));
		if ($res =& Countries::getCountryOptions())
		{
			$countries=array_merge($countries,$res);
		}
		$lists['countries']=JHTML::_(	'select.genericlist',
										$countries,
										'country',
										'class="inputbox" size="1"',
										'value',
										'text',
										$club->country);
		unset($countries);

		//build the html select list for playgrounds
		$playgrounds[]=JHTML::_('select.option','0',JText::_('JL_GLOBAL_SELECT_PLAYGROUND'));
		if ($res =& $model->getPlaygrounds())
		{
			$playgrounds=array_merge($playgrounds,$res);
		}
		$lists['playgrounds']=JHTML::_(	'select.genericlist',
										$playgrounds,
										'standard_playground',
										'class="inputbox" size="1"',
										'value',
										'text',
										$club->standard_playground);
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

		/*
		 * extended data
		 */
		$paramsdata=$club->extended;
		$paramsdefs=JPATH_COMPONENT.DS.'assets'.DS.'extended'.DS.'club.xml';
		$extended=new JLGExtraParams($paramsdata,$paramsdefs);
    $this->assignRef( 'address_string',	$model->getAddressString() );
    $this->assignRef( 'address_geocode',	$model->JLgetGeoCoords($this->address_string) );
    
    foreach ( $extended->getGroups() as $key => $groups )
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
    
		$this->assignRef('edit',$edit);
		$this->assignRef('extended',$extended);
		$this->assignRef('logo_bigselect',$logo_bigselect);
		$this->assignRef('logo_middleselect',$logo_middleselect);
		$this->assignRef('logo_smallselect',$logo_smallselect);
		$this->assignRef('lists',$lists);
		$this->assignRef('club',$club);

		parent::display($tpl);
	}

}
?>
