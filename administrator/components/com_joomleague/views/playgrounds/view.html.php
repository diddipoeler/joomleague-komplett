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
class JoomleagueViewPlaygrounds extends JLGView
{

	function display($tpl=null)
	{
		$option='com_joomleague';
		$mainframe =& JFactory::getApplication();

		// Set toolbar items for the page
		JToolBarHelper::title(JText::_('JL_ADMIN_PLAYGROUNDS_TITLE'),'playground');
		JToolBarHelper::editListX();
		JToolBarHelper::divider();
		JToolBarHelper::addNewX();
		JToolBarHelper::custom('import','upload','upload',JText::_('JL_GLOBAL_CSV_IMPORT'),false);
		JToolBarHelper::archiveList('export',JText::_('JL_GLOBAL_XML_EXPORT'));
		JToolBarHelper::divider();
		JToolBarHelper::deleteList();
		JToolBarHelper::divider();

		JToolBarHelper::help('screen.joomleague',true);

		$db =& JFactory::getDBO();
		$uri =& JFactory::getURI();

		$filter_order		= $mainframe->getUserStateFromRequest($option.'v_filter_order',		'filter_order',		'v.ordering',	'cmd');
		$filter_order_Dir	= $mainframe->getUserStateFromRequest($option.'v_filter_order_Dir',	'filter_order_Dir',	'',				'word');
		
    $filter_countries		= $mainframe->getUserStateFromRequest($option.'v_filter_countries',			'v_filter_countries',		'',	'word');
    
    $search				= $mainframe->getUserStateFromRequest($option.'v_search',			'search',			'',				'string');
		$search_mode		= $mainframe->getUserStateFromRequest($option.'t_search_mode',		'search_mode',		'',				'string');
		$search				= JString::strtolower($search);

		$items =& $this->get('Data');
		$total =& $this->get('Total');
		$pagination =& $this->get('Pagination');

    //build the html select list for countries
		$countries[] = JHTML::_('select.option','',JText::_('JL_ADMIN_LEAGUE_SELECT_COUNTRY'),'value','text');
		if ($res =& Countries::getCountryOptions()){$countries=array_merge($countries,$res);}
		$lists['countries']=JHTML::_( 'select.genericList',
										$countries,
										'v_filter_countries',
										'class="inputbox" onChange="this.form.submit();" style="width:120px"',
										'value',
										'text',
										$filter_countries);
		unset($countries);
		
		// table ordering
		$lists['order_Dir']=$filter_order_Dir;
		$lists['order']=$filter_order;

		// search filter
		$lists['search']=$search;
		$lists['search_mode']=$search_mode;

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