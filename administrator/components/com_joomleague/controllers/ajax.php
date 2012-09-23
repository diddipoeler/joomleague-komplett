<?php
/**
 * @copyright	Copyright (C) 2005-2012 JoomLeague.net. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');

/**
 * Joomleague Ajax Controller
 *
 * @package		Joomleague
 * @since 1.5
 */
class JoomleagueControllerAjax extends JLGController
{

	function __construct()
	{
		parent::__construct();
	}

	function projectdivisionsoptions()
	{
		$model = $this->getModel('ajax');
		echo json_encode((array) $model->getProjectDivisionsOptions(JRequest::getInt( 'p' )));
		exit;
	}

	function projecteventsoptions()
	{
		$model = $this->getModel('ajax');
		echo json_encode((array) $model->getProjectEventsOptions(JRequest::getInt( 'p' )));
		exit;
	}

	function projectteamsbydivisionoptions()
	{
		$model = $this->getModel('ajax');
		echo json_encode((array) $model->getProjectTeamsByDivisionOptions(JRequest::getInt( 'p' ), JRequest::getInt( 'division' )));
		exit;
	}

	function projectsbysportstypesoptions()
	{
		$model = $this->getModel('ajax');
		echo json_encode((array) $model->getProjectsBySportsTypesOptions(JRequest::getInt( 'sportstype' )));
		exit;
	}

	function projectsbycluboptions()
	{
		$model = $this->getModel('ajax');
		echo json_encode((array) $model->getProjectsByClubOptions(JRequest::getInt( 'cid' )));
		exit;
	}

	function projectteamsoptions()
	{
		$model = $this->getModel('ajax');
		echo json_encode((array) $model->getProjectTeamOptions(JRequest::getInt( 'p' )));
		exit;
	}
	
	function projectteamsptidoptions()
	{
		$model = $this->getModel('ajax');
		echo json_encode((array) $model->getProjectTeamPtidOptions(JRequest::getInt( 'p' )));
		exit;
	}
	
	function projectstaffoptions()
	{
		$model = $this->getModel('ajax');
		echo json_encode((array) $model->getProjectStaffOptions(JRequest::getInt( 'p' )));
		exit;
	}

	function projectclubsoptions()
	{
		$model = $this->getModel('ajax');
		echo json_encode((array) $model->getProjectClubOptions(JRequest::getInt( 'p' )));
		exit;
	}

	function projectstatsoptions()
	{
		$model = $this->getModel('ajax');
		echo json_encode((array) $model->getProjectStatOptions(JRequest::getInt( 'p' )));
		exit;
	}

	function matchesoptions()
	{
		$model = $this->getModel('ajax');
		echo json_encode((array) $model->getMatchesOptions(JRequest::getInt( 'p' )));
		exit;
	}

	function refereesoptions()
	{
		$model = $this->getModel('ajax');
		echo json_encode((array) $model->getRefereesOptions(JRequest::getInt( 'p' )));
		exit;
	}

	function roundsoptions()
	{
		echo json_encode((array) JoomleagueHelper::getRoundsOptions(JRequest::getInt( 'p' )));
		exit;
	}

	function predictionmembersoptions()
	{
		$model = $this->getModel('ajax');
		echo json_encode((array) $model->getPredictionMemberOptions(JRequest::getInt( 'p' )));
		exit;
	}

	function projecttreenodeoptions()
	{
		$model = $this->getModel('ajax');
		echo json_encode((array) $model->getProjectTreenodeOptions(JRequest::getInt( 'p' )));
		exit;
	}
	
	function sportstypesoptions()
	{
		echo json_encode((array) JoomleagueModelSportsTypes::getSportsTypes());
		exit;
	}

}
?>
