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

/**
 * HTML View class for the Joomleague component
 *
 * @static
 * @package	JoomLeague
 * @since	0.1
 */
class JoomleagueViewProjects extends JLGView
{
	function display($tpl=null)
	{
		$option='com_joomleague';
		$mainframe	=& JFactory::getApplication();

		// Set toolbar items for the page
		JToolBarHelper::title(JText::_('JL_ADMIN_PROJECTS_TITLE'),'ProjectSettings');
		JToolBarHelper::publishList();
		JToolBarHelper::unpublishList();
		JToolBarHelper::divider();

		JToolBarHelper::addNewX();
		JToolBarHelper::editListX();
		JToolBarHelper::custom('import','upload','upload',Jtext::_('JL_GLOBAL_CSV_IMPORT'),false);
		JToolBarHelper::archiveList('export',JText::_('JL_GLOBAL_XML_EXPORT'));
		JToolBarHelper::custom('copy','copy.png','copy_f2.png',JText::_('JL_GLOBAL_COPY'),true);
		JToolBarHelper::deleteList(JText::_('JL_ADMIN_PROJECTS_DELETE_WARNING'));
		JToolBarHelper::divider();

		JToolBarHelper::help('screen.joomleague',true);

		$db	=& JFactory::getDBO();
		$uri	=& JFactory::getURI();

		$filter_league		= $mainframe->getUserStateFromRequest($option.'.'.$this->get('identifier').'.filter_league',		'filter_league','',					'int');
		$filter_sports_type	= $mainframe->getUserStateFromRequest($option.'.'.$this->get('identifier').'.filter_sports_type',	'filter_sports_type','',			'int');
		$filter_season		= $mainframe->getUserStateFromRequest($option.'.'.$this->get('identifier').'.filter_season',		'filter_season','',					'int');
		$filter_state		= $mainframe->getUserStateFromRequest($option.'.'.$this->get('identifier').'.filter_state',			'filter_state',		'',				'word');
		$filter_order		= $mainframe->getUserStateFromRequest($option.'.'.$this->get('identifier').'.filter_order',			'filter_order',		'p.ordering',	'cmd');
		$filter_order_Dir	= $mainframe->getUserStateFromRequest($option.'.'.$this->get('identifier').'.filter_order_Dir',		'filter_order_Dir',	'',				'word');
		$search				= $mainframe->getUserStateFromRequest($option.'.'.$this->get('identifier').'.search',				'search',			'',				'string');
		$search=JString::strtolower($search);
		
		// Get data from the model
		$items		= & $this->get('Data');
		$total		= & $this->get('Total');
		$pagination     =& $this->get('Pagination');

		$javascript = 'onchange="document.adminForm.submit();"';

		// state filter
		$lists['state'] = JHTML::_('grid.state',$filter_state);

		// table ordering
		$lists['order_Dir'] = $filter_order_Dir;
		$lists['order'] = $filter_order;

		// search filter
		$lists['search'] = $search;

		//build the html select list for leagues
		$leagues[]=JHTML::_('select.option','0',JText::_('JL_ADMIN_PROJECTS_LEAGUES_FILTER'),'id','name');
		$allLeagues =& JoomleagueModelLeagues::getLeagues();
		$leagues=array_merge($leagues,$allLeagues);
		$lists['leagues']=JHTML::_( 'select.genericList',
									$leagues,
									'filter_league',
									'class="inputbox" onChange="this.form.submit();" style="width:120px"',
									'id',
									'name',
									$filter_league);
		unset($leagues);
		
		
		//build the html select list for sportstypes
		$sportstypes[]=JHTML::_('select.option','0',JText::_('JL_ADMIN_PROJECTS_SPORTSTYPE_FILTER'),'id','name');
		$allSportstypes =& JoomleagueModelSportsTypes::getSportsTypes();
		$sportstypes=array_merge($sportstypes,$allSportstypes);
		$lists['sportstypes']=JHTML::_( 'select.genericList',
										$sportstypes,
										'filter_sports_type',
										'class="inputbox" onChange="this.form.submit();" style="width:120px"',
										'id',
										'name',
										$filter_sports_type);
		unset($sportstypes);
		
		
		//build the html select list for seasons
		$seasons[]=JHTML::_('select.option','0',JText::_('JL_ADMIN_PROJECTS_SEASON_FILTER'),'id','name');

		if ($res =& $this->get('Seasons')){$seasons=array_merge($seasons,$res);}
		
		$lists['seasons']=JHTML::_( 'select.genericList',
									$seasons,
									'filter_season',
									'class="inputbox" onChange="this.form.submit();" style="width:120px"',
									'id',
									'name',
									$filter_season);

		unset($seasons);

		$this->assignRef('user',JFactory::getUser());
		$this->assignRef('lists',$lists);
		$this->assignRef('items',$items);
		$this->assignRef('pagination',$pagination);
		$this->assignRef('request_url',$uri->toString());

		parent::display($tpl);
	}

}
?>