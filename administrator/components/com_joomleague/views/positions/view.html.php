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
 * @since	1.5.0a
 */
class JoomleagueViewPositions extends JLGView
{
	function display($tpl=null)
	{
		$option='com_joomleague';
		$mainframe =& JFactory::getApplication();

		// Set toolbar items for the page
		JToolBarHelper::title(JText::_('JL_ADMIN_POSITIONS_TITLE'),'Positions');

		JToolBarHelper::publishList();
		JToolBarHelper::unpublishList();
		JToolBarHelper::divider();

		JToolBarHelper::apply('saveshort');
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
		$model =& $this->getModel();
		
		$filter_sports_type	= $mainframe->getUserStateFromRequest($option.'.'.$this->get('identifier').'.filter_sports_type',	'filter_sports_type','',			'int');
		$filter_state		= $mainframe->getUserStateFromRequest($option.'.'.$this->get('identifier').'.filter_state',			'filter_state',		'',				'word');
		$filter_order		= $mainframe->getUserStateFromRequest($option.'.'.$this->get('identifier').'.filter_order',			'filter_order',		'po.ordering',	'cmd');
		$filter_order_Dir	= $mainframe->getUserStateFromRequest($option.'.'.$this->get('identifier').'.filter_order_Dir',		'filter_order_Dir',	'',				'word');
		$search				= $mainframe->getUserStateFromRequest($option.'.'.$this->get('identifier').'.search',				'search',			'',				'string');
		$search=JString::strtolower($search);

		$items =& $this->get('Data');
		$total =& $this->get('Total');
		$pagination =& $this->get('Pagination');

		// state filter
		$lists['state']=JHTML::_('grid.state', $filter_state);

		// table ordering
		$lists['order_Dir']=$filter_order_Dir;
		$lists['order']=$filter_order;

		// search filter
		$lists['search']=$search;

		//build the html options for parent position
		$parent_id[]=JHTML::_('select.option','',JText::_('JL_ADMIN_POSITIONS_IS_P_POSITION'));
		if ($res =& $model->getParentsPositions())
		{
			foreach ($res as $re){$re->text=JText::_($re->text);}
			$parent_id=array_merge($parent_id,$res);
		}
		$lists['parent_id']=$parent_id;
		unset($parent_id);

		//build the html select list for sportstypes
		$sportstypes[]=JHTML::_('select.option','0',JText::_('JL_ADMIN_POSITIONS_SPORTSTYPE_FILTER'),'id','name');
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