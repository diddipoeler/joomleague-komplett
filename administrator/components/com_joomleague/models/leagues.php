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

jimport('joomla.application.component.model');
require_once (JPATH_COMPONENT.DS.'models'.DS.'list.php');

/**
 * Joomleague Component Seasons Model
 *
 * @package	JoomLeague
 * @since	0.1
 */
class JoomleagueModelLeagues extends JoomleagueModelList
{
	var $_identifier = "leagues";
	
	function _buildQuery()
	{
		// Get the WHERE and ORDER BY clauses for the query
		$where=$this->_buildContentWhere();
		$orderby=$this->_buildContentOrderBy();

		$query='	SELECT	objleagues.*,
							u.name AS editor
					FROM #__joomleague_league AS objleagues
					LEFT JOIN #__users AS u ON u.id=objleagues.checked_out ' .
					$where .
					$orderby;
		return $query;
	}

	function _buildContentOrderBy()
	{
		$option='com_joomleague';
		$mainframe =& JFactory::getApplication();
		$filter_order		= $mainframe->getUserStateFromRequest($option.'l_filter_order',		'filter_order',		'objleagues.ordering',	'cmd');
		$filter_order_Dir	= $mainframe->getUserStateFromRequest($option.'l_filter_order_Dir',	'filter_order_Dir',	'',				'word');
		if ($filter_order == 'objleagues.ordering')
		{
			$orderby=' ORDER BY objleagues.ordering '.$filter_order_Dir;
		}
		else
		{
			$orderby=' ORDER BY '.$filter_order.' '.$filter_order_Dir.',objleagues.ordering ';
		}
		return $orderby;
	}

	function _buildContentWhere()
	{
		$option='com_joomleague';
		$mainframe =& JFactory::getApplication();
		$filter_order	= $mainframe->getUserStateFromRequest($option.'l_filter_order',		'filter_order',		'objleagues.ordering',	'cmd');
		$filter_order_Dir	= $mainframe->getUserStateFromRequest($option.'l_filter_order_Dir',	'filter_order_Dir',	'',				'word');
		
    $filter_countries	= $mainframe->getUserStateFromRequest($option.'.'.$this->_identifier.'.filter_countries',		'filter_countries',		'',		'word');
    
    $search				= $mainframe->getUserStateFromRequest($option.'l_search',			'search',			'',				'string');
		$search=JString::strtolower($search);
		$where=array();
		
		if( $filter_countries ) 
    {
			$where[] = 'objleagues.country = ' . "'" . $filter_countries . "'";
		}
		
		if ($search)
		{
			$where[]='LOWER(objleagues.name) LIKE '.$this->_db->Quote('%'.$search.'%');
		}
		$where=(count($where) ? ' WHERE '.implode(' AND ',$where) : '');
		return $where;
	}

	/**
	 * Method to return a leagues array (id,name)
	 *
	 * @access	public
	 * @return	array seasons
	 * @since	1.5.0a
	 */
	function getLeagues()
	{
		$db =& JFactory::getDBO();
		$query='SELECT id, name FROM #__joomleague_league ORDER BY name ASC ';
		$db->setQuery($query);
		if (!$result=$db->loadObjectList())
		{
			$this->setError($db->getErrorMsg());
			return array();
		}
		foreach ($result as $league){
			$league->name = JText::_($league->name); 
		}
		return $result;
	}
}
?>