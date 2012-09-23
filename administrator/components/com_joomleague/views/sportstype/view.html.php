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
class JoomleagueViewSportsType extends JLGView
{

	function display($tpl=null)
	{
		$mainframe	=& JFactory::getApplication();

		if ($this->getLayout()=='form')
		{
			$this->_displayForm($tpl);
			return;
		}

		//get the project
		$season =& $this->get('data');

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
		//get the sportstype
		$sportstype =& $this->get('data');
		$isNew=($sportstype->id < 1);

		// fail if checked out not by 'me'
		if ($model->isCheckedOut($user->get('id')))
		{
			$msg=JText::sprintf('DESCBEINGEDITTED',JText::_('JL_ADMIN_SPORTTYPE'),$sportstype->name);
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
			$sportstype->order 	= 0;
		}

		$filter_order		= $mainframe->getUserStateFromRequest($option.'s_filter_order',		'filter_order',		's.ordering',	'cmd');
		$filter_order_Dir	= $mainframe->getUserStateFromRequest($option.'s_filter_order_Dir',	'filter_order_Dir',	'',				'word');
		$search				= $mainframe->getUserStateFromRequest($option.'s_search',			'search',			'',				'string');
		$search=JString::strtolower($search);

		$total =& $this->get('Total');
		$pagination =& $this->get('Pagination');

		//build the html select list for ordering
		$query = $model->getOrderingAndSportstypeQuery();
		$lists['ordering']=JHTML::_('list.specificordering',$sportstype,$sportstype->id,$query,1);

		// table ordering
		$lists['order_Dir']=$filter_order_Dir;
		$lists['order']=$filter_order;

		// search filter
		$lists['search']=$search;

		// icon
		//if there is no icon selected, use default icon
		$default = '';
		if (empty($sportstype->icon)){$sportstype->icon=$default;}

		// image selector
		$imageselect = ImageSelect::getSelector('icon','picture_preview','sportstypes',$sportstype->icon,$default);		

		$this->assignRef( 'imageselect', $imageselect);		
		$this->assignRef('user',$user);
		$this->assignRef('lists',$lists);
		$this->assignRef('sportstype',$sportstype);
		$this->assignRef('pagination',$pagination);
		$this->assignRef('request_url',$uri->toString());

		parent::display($tpl);
	}

}
?>