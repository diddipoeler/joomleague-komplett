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
 * @package	JoomLeague
 * @since	0.1
 */
class JoomleagueViewClubs extends JLGView
{

	function display($tpl=null)
	{
		$option='com_joomleague';
		$mainframe =& JFactory::getApplication();

		// Set toolbar items for the page
		JToolBarHelper::title(JText::_('JL_ADMIN_CLUBS_TITLE'),'clubs');
		JToolBarHelper::addNewX();
		JToolBarHelper::editListX();
		JToolBarHelper::custom('import','upload','upload',JText::_('JL_GLOBAL_CSV_IMPORT'),false);
		JToolBarHelper::archiveList('export',JText::_('JL_GLOBAL_XML_EXPORT'));
		JToolBarHelper::divider();
		JToolBarHelper::deleteList();
		JToolBarHelper::divider();

		JToolBarHelper::help('screen.joomleague',true);

		$db	 	=& JFactory::getDBO();
		$uri	=& JFactory::getURI();

		$filter_state		= $mainframe->getUserStateFromRequest($option.'a_filter_state',		'filter_state',		'',				'word');
		$filter_order		= $mainframe->getUserStateFromRequest($option.'a_filter_order',		'filter_order',		'a.ordering',	'cmd');
		$filter_order_Dir	= $mainframe->getUserStateFromRequest($option.'a_filter_order_Dir',	'filter_order_Dir',	'',				'word');
		$search				= $mainframe->getUserStateFromRequest($option.'a_search',			'search',			'',				'string');
		$search_mode		= $mainframe->getUserStateFromRequest($option.'a_search_mode',		'search_mode',		'',				'string');
		$search				= JString::strtolower($search);

		$items		=& $this->get('Data');
		$total		=& $this->get('Total');
		$pagination =& $this->get('Pagination');

		// state filter
		$lists['state'] = JHTML::_('grid.state',$filter_state);

		// table ordering
		$lists['order_Dir'] = $filter_order_Dir;
		$lists['order'] = $filter_order;

		// search filter
		$lists['search'] = $search;
		$lists['search_mode'] = $search_mode;

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