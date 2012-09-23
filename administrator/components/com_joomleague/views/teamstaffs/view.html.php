<?php
/**
 * @copyright	Copyright (C) 2006-2012 JoomLeague.net. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

/**
 * HTML View class for the Joomleague component
 *
 * @static
 * @author	Kurt Norgaz
 * @package	JoomLeague
 * @since	1.5
 */
class JoomleagueViewTeamStaffs extends JLGView
{

	function display( $tpl = null )
	{
		if ( $this->getLayout() == 'default' )
		{
			$this->_displayDefault( $tpl );
			return;
		}

		parent::display( $tpl );
	}

	function _displayDefault( $tpl )
	{
		$document = &JFactory::getDocument();
		$option='com_joomleague';
		$mainframe	=& JFactory::getApplication();

		$uri =& JFactory::getURI();
	
		$baseurl    = JURI::root();
		if (JoomleagueHelper::isMootools12())
		{
			$document->addScript($baseurl.'components/com_joomleague/assets/js/autocompleter/1_2/Autocompleter.js');
			$document->addScript($baseurl.'components/com_joomleague/assets/js/autocompleter/1_2/Autocompleter.Request.js');
			$document->addScript($baseurl.'components/com_joomleague/assets/js/autocompleter/1_2/Observer.js');
			$document->addScript($baseurl.'administrator/components/com_joomleague/assets/js/quickaddperson1_2.js');
			$document->addStyleSheet($baseurl.'components/com_joomleague/assets/css/Autocompleter1_2.css');			
		}
		else {
			$document->addScript($baseurl.'components/com_joomleague/assets/js/autocompleter/1_1/Autocompleter.js');
			$document->addScript($baseurl.'components/com_joomleague/assets/js/autocompleter/1_1/Observer.js');
			$document->addScript($baseurl.'administrator/components/com_joomleague/assets/js/quickaddperson1_1.js');
			$document->addStyleSheet($baseurl.'components/com_joomleague/assets/css/Autocompleter1_1.css');
		}

		$filter_state		= $mainframe->getUserStateFromRequest( $option . 'ts_filter_state',		'filter_state',		'',				'word' );
		$filter_order		= $mainframe->getUserStateFromRequest( $option . 'ts_filter_order',		'filter_order',		'ppl.ordering',	'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $option . 'ts_filter_order_Dir',	'filter_order_Dir',	'',				'word' );
		$search			= $mainframe->getUserStateFromRequest( $option . 'ts_search',			'search',			'',				'string' );
		$search_mode		= $mainframe->getUserStateFromRequest( $option . 'ts_search_mode',		'search_mode',		'',				'string' );

		$teamws	=& $this->get( 'Data', 'teamws' );
		$mainframe->setUserState( 'team_id', $teamws->team_id );

		$items		=& $this->get( 'Data' );
		$total		=& $this->get( 'Total' );
		$pagination =& $this->get( 'Pagination' );

		$model		=& $this->getModel();

		// state filter
		$lists['state'] = JHTML::_( 'grid.state', $filter_state );

		// table ordering
		$lists['order_Dir'] = $filter_order_Dir;
		$lists['order'] = $filter_order;

		// search filter
		$lists['search'] = $search;
		$lists['search_mode']= $search_mode;

		//build the html options for position
		$position_id[] = JHTML::_( 'select.option', '0', JText::_( 'JL_GLOBAL_SELECT_FUNCTION' ) );
		if ( $res = & $model->getPositions() )
		{
			$position_id = array_merge( $position_id, $res );
		}
		$lists['project_position_id'] = $position_id;
		unset( $position_id );

		$projectws		=& $this->get( 'Data', 'projectws' );
		$teamstaffws	=& $this->get( 'Data', 'teamstaffws' );

		$this->assignRef( 'user',				JFactory::getUser() );
		$this->assignRef( 'lists',				$lists );
		$this->assignRef( 'items',				$items );
		$this->assignRef( 'projectws',			$projectws );
		$this->assignRef( 'teamstaffws',		$teamstaffws );
		$this->assignRef( 'teamws',				$teamws );
		$this->assignRef( 'pagination',			$pagination );
		$this->assignRef( 'request_url',		$uri->toString() );

		parent::display( $tpl );
	}

}
?>