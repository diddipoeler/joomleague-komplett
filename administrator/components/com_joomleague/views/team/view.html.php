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
require_once(JPATH_COMPONENT.DS.'helpers'.DS.'imageselect.php');

/**
 * HTML View class for the Joomleague component
 *
 * @static
 * @package	JoomLeague
 * @since	0.1
 */
class JoomleagueViewTeam extends JLGView
{
	function display($tpl = null)
	{
		$mainframe	=& JFactory::getApplication();

		if($this->getLayout() == 'form')
		{
			$this->_displayForm($tpl);
			return;
		}

		parent::display($tpl);
	}

	function _displayForm($tpl)
	{
		$mainframe	=& JFactory::getApplication();
		$db			=& JFactory::getDBO();
		$uri 		=& JFactory::getURI();
		$user 		=& JFactory::getUser();
		$model		=& $this->getModel();

		$lists = array();
		//get the club
		$team	=& $this->get('data');
		$isNew	= ($team->id < 1);

		// fail if checked out not by 'me'
		if ($model->isCheckedOut( $user->get('id') ))
		{
			$msg = JText::sprintf( 'DESCBEINGEDITTED', JText::_( 'JL_ADMIN_TEAM_THETEAM' ), $team->name );
			$mainframe->redirect( 'index.php?option=com_joomleague', $msg );
		}

		// Edit or Create?
		if (!$isNew)
		{
			$model->checkout( $user->get('id') );
		}
		else
		{
			// initialise new record
			//$season->published = 1;
			$club->order 	= 0;
		}

		//build the html select list for admin
		//	$lists['admin'] = JHTML::_('list.users',  'admin', $club->admin);

		// build the html select list for ordering
		$query = $model->getOrderingAndTeamQuery();
		$lists['ordering']	= JHTML::_( 'list.specificordering', $team, $team->id, $query, 1 );

		//build the html select list for clubs
		$clubs[] = JHTML::_( 'select.option', '0', JText::_( 'JL_GLOBAL_SELECT_CLUB' ), 'id', 'name' );
		if ( $res = & $this->get('Clubs') )
		{
			$clubs = array_merge( $clubs, $res );
		}

		if($team->club_id){
			$selected_club = $team->club_id;
		} else {
			$selected_club = JRequest::getInt('cid',0);
		}

		$lists['clubs'] = JHTML::_( 'select.genericlist', $clubs, 'club_id', 'class="inputbox" size="1"', 'id', 'name', $selected_club );
		unset($clubs);

		$this->assignRef('lists',	$lists);
		$this->assignRef('team',	$team);
		/*
		 * extended data
		 */
		$paramsdata = $team->extended;
		$paramsdefs = JPATH_COMPONENT . DS . 'assets' . DS . 'extended' . DS . 'team.xml';
		$extended = new JLGExtraParams( $paramsdata, $paramsdefs );

		$this->assignRef( 'extended',		$extended );

		//if there is no image selected, use default picture
		$default = JoomleagueHelper::getDefaultPlaceholder("team");
		if (empty($team->picture)){$team->picture=$default;}

		$imageselect=ImageSelect::getSelector('picture','picture_preview','teams',$team->picture,$default);
		$this->assignRef('imageselect',		$imageselect);

		parent::display( $tpl );
	}

}
?>