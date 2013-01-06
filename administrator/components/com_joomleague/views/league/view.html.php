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

require_once( JPATH_COMPONENT . DS . 'helpers' . DS . 'imageselect.php' );

/**
 * HTML View class for the Joomleague component
 *
 * @static
 * @package	JoomLeague
 * @since	0.1
 */
class JoomleagueViewLeague extends JLGView
{
	function display($tpl=null)
	{
		if ($this->getLayout() == 'form')
		{
			$this->_displayForm($tpl);
			return;
		}

		//get the object
		$object =& $this->get('data');

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
		//get the project
		$object =& $this->get('data');
		$isNew=($object->id < 1);

		// fail if checked out not by 'me'
		if ($model->isCheckedOut($user->get('id')))
		{
			$msg=JText::sprintf('DESCBEINGEDITTED',JText::_('JL_ADMIN_LEAGUE'),$object->name);
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
			$object->order=0;
		}

		//build the html select list for countries
		$countries[]=JHTML::_('select.option','',JText::_('JL_ADMIN_LEAGUE_SELECT_COUNTRY'));
		if ($res =& Countries::getCountryOptions()){$countries=array_merge($countries,$res);}
		$lists['countries']=JHTML::_('select.genericlist',$countries,'country','class="inputbox" size="1"','value','text',$object->country);
		unset($countries);

		// build the html select list for ordering
		$query = $model->getOrderingAndLeagueQuery();		
		$lists['ordering']=JHTML::_('list.specificordering',$object,$object->id,$query,1);

    // image selector
		$default = JoomleagueHelper::getDefaultPlaceholder('leaguelogo');
		if (empty($object->picture)){
			$object->picture = $default;
		}
		
		$imageselect = ImageSelect::getSelector('picture','picture_preview','leagues',$object->picture, $default);
		$this->assignRef( 'imageselect', $imageselect);

    /*
    promotion to 
    */
    $promotion = array();
    $lists['promotion_to'] = "";
    $promotion = $model->getPromotionto();
    $promotion_to = @explode(",",$object->promotion_to);
    if ( $promotion )
    {
		$lists['promotion_to'] = JHTMLSelect::genericlist($promotion,'promotion_to[]',' multiple="true" class="inputbox" size="15" width="100"','id','name',$promotion_to);
    }
    
    /*
    relegation to
    */
    $relegation = array();
    $lists['relegation_to'] = "";
    $relegation = $model->getRelegationto();
    $relegation_to = @explode(",",$object->relegation_to);
    if ( $relegation )
    {
		$lists['relegation_to'] = JHTMLSelect::genericlist($relegation,'relegation_to[]',' multiple="true" class="inputbox" size="15" width="100"','id','name',$relegation_to);
    }
    
    
		
    /*
    * extended data
    */
    $paramsdata=$object->extended;
    $paramsdefs=JPATH_COMPONENT.DS.'assets'.DS.'extended'.DS.'league.xml';
    $extended=new JLGExtraParams($paramsdata,$paramsdefs);

    $this->assignRef('extended',$extended);


		$this->assignRef('lists',$lists);
		$this->assignRef('object',$object);

		parent::display($tpl);
	}

}
?>