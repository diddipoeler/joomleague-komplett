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
jimport('joomla.filesystem.file');

/**
 * HTML View class for the Joomleague component
 *
 * @static
 * @packag	JoomLeague
 * @since	1.5.0a
 */
class JoomleagueViewEventtypes extends JLGView
{
	function display($tpl=null)
	{
		$option='com_joomleague';
		$mainframe	=& JFactory::getApplication();

		// Set toolbar items for the page
		JToolBarHelper::title(JText::_('JL_ADMIN_EVENTS_TITLE'),'events');

		JToolBarHelper::publishList();
		JToolBarHelper::unpublishList();
		JToolBarHelper::divider();

		JToolBarHelper::addNewX();
		JToolBarHelper::editListX();
		JToolBarHelper::custom('import','upload','upload',JText::_('JL_GLOBAL_CSV_IMPORT'),false);
		JToolBarHelper::archiveList('export',JText::_('JL_GLOBAL_XML_EXPORT'));
		JToolBarHelper::divider();
		JToolBarHelper::deleteList();
		JToolBarHelper::divider();

		JToolBarHelper::help('screen.joomleague',true);

		$db		=& JFactory::getDBO();
		$uri	=& JFactory::getURI();
		$filter_sports_type	= $mainframe->getUserStateFromRequest($option.'.'.$this->get('identifier').'.filter_sports_type','filter_sports_type','',			'int');
		$filter_state		= $mainframe->getUserStateFromRequest($option.'.'.$this->get('identifier').'.filter_state',		'filter_state',		'',				'word');
		$filter_order		= $mainframe->getUserStateFromRequest($option.'.'.$this->get('identifier').'.filter_order',		'filter_order',		'obj.ordering',	'cmd');
		$filter_order_Dir	= $mainframe->getUserStateFromRequest($option.'.'.$this->get('identifier').'.filter_order_Dir',	'filter_order_Dir',	'',				'word');
		$search				= $mainframe->getUserStateFromRequest($option.'.'.$this->get('identifier').'.search',			'search',			'',				'string');
		$search				= JString::strtolower($search);

		$items		=& $this->get('Data');
		$total		=& $this->get('Total');
		$pagination =& $this->get('Pagination');

		// state filter
		$lists['state']	= JHTML::_('grid.state', $filter_state);

		// table ordering
		$lists['order_Dir']	= $filter_order_Dir;
		$lists['order']		= $filter_order;

		// search filter
		$lists['search']	= $search;

		//build the html select list for sportstypes
		$sportstypes[]=JHTML::_('select.option','0',JText::_('JL_ADMIN_EVENTS_SPORTSTYPE_FILTER'),'id','name');
		$allSportstypes =& JoomleagueModelSportsTypes::getSportsTypes();
		
		$sportstypes=array_merge($sportstypes,$allSportstypes);
		
		$lists['sportstypes']=JHTML::_( 'select.genericList',
										$sportstypes,
										'filter_sports_type',
										'class="inputbox" onChange="this.form.submit();" style="width:120px"',
										'id',
										'name',
										$filter_sports_type	);
		unset($sportstypes);

		$this->assignRef('user',JFactory::getUser());
		$this->assignRef('config',JFactory::getConfig());
		$this->assignRef('lists',$lists);
		$this->assignRef('items',$items);
		$this->assignRef('pagination',$pagination);
		$this->assignRef('request_url',$uri->toString());

		parent::display($tpl);
	}

}
?>