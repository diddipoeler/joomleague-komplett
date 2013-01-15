<?php defined('_JEXEC') or die('Restricted access');
 
jimport('joomla.application.component.view');
require_once (JPATH_COMPONENT.DS.'helpers'.DS.'imageselect.php');

class JoomleagueViewPlayer extends JLGView
{

	function display($tpl=null)
	{
		// Get a refrence of the page instance in joomla
		$document =& JFactory::getDocument();
		$model =& $this->getModel();
		$config=$model->getTemplateConfig($this->getName());


    // select userfields
    $userfields = $model->getUserfields();
    $this->assignRef('userfields',$userfields);

    
		$person=$model->getPerson();
		if ($this->getLayout()=='edit'){$this->_loadEditData($config);}
		$nickname=$person->nickname;
		if(!empty($nickname)){$nickname="'".$nickname."'";}
		$this->assignRef('isContactDataVisible',$model->isContactDataVisible($config['show_contact_team_member_only']));
		$this->assignRef('project',$model->getProject());
		$this->assignRef('overallconfig',$model->getOverallConfig());
		$this->assignRef('config',$config);
		$this->assignRef('person',$person);
		$this->assignRef('nickname',$nickname);

    /*
    * league extended data
    */
    $paramsdata_league = $this->project->league_extended;
    $paramsdefs_league = JLG_PATH_ADMIN.DS.'assets'.DS.'extended'.DS.'league.xml';
    $extended_league = new JLGExtraParams($paramsdata_league,$paramsdefs_league);
    $this->assignRef('league_extended',$extended_league);
    $this->assign('show_debug_info', JComponentHelper::getParams('com_joomleague')->get('show_debug_info',0) );
    
		$this->assignRef('teamPlayers',$model->getTeamPlayers());

		// Select the teamplayer that is currently published (in case the player played in multiple teams in the project)
		$teamPlayer = null;
		if (count($this->teamPlayers))
		{
			$currentProjectTeamId=0;
			foreach ($this->teamPlayers as $teamPlayer)
			{
				if ($teamPlayer->published == 1)
				{
					$currentProjectTeamId=$teamPlayer->projectteam_id;
					break;
				}
			}
			if ($currentProjectTeamId)
			{
				$teamPlayer = $this->teamPlayers[$currentProjectTeamId];
			}
		}
		$sportstype = $config['show_plcareer_sportstype'] ? $model->getSportsType() : 0;
		$this->assignRef('teamPlayer',$teamPlayer);
		$this->assignRef('historyPlayer',$model->getPlayerHistory($sportstype, 'ASC'));
		$this->assignRef('historyPlayerStaff',$model->getPlayerHistoryStaff($sportstype, 'ASC'));
		$this->assignRef('AllEvents',$model->getAllEvents($sportstype));
		$this->assignRef('showediticon',$model->getAllowed($config['edit_own_player']));
		$this->assignRef('stats',$model->getProjectStats());

		// Get events and stats for current project
		if ($config['show_gameshistory'])
		{
			$this->assignRef('games',$model->getGames());
			$this->assignRef('teams',$model->getTeamsIndexedByPtid());
			$this->assignRef('gamesevents',$model->getGamesEvents());
			$this->assignRef('gamesstats',$model->getPlayerStatsByGame());
		}

		// Get events and stats for all projects where player played in (possibly restricted to sports type of current project)
		if ($config['show_career_stats'])
		{
			$this->assignRef('stats',$model->getStats());
			$this->assignRef('projectstats',$model->getPlayerStatsByProject($sportstype));
		}

		$paramsdata=$person->extended;
		$paramsdefs=JLG_PATH_ADMIN.DS.'assets'.DS.'extended'.DS.'person.xml';
		$extended=new JLGExtraParams($paramsdata,$paramsdefs);

    $this->params =	$extended;
    $person_positions = $this->params->get('personpositions');
    $this->assignRef('person_positions',$person_positions);
    
		$this->assignRef('extended',$extended);
		$name = JoomleagueHelper::formatName(null, $this->person->firstname, $this->person->nickname,  $this->person->lastname,  $this->config["name_format"]);
		$this->assignRef('playername', $name);
		$document->setTitle(JText::sprintf('JL_PLAYER_INFORMATION', $name));

		parent::display($tpl);
	}

	function _loadEditData($config)
	{

		$document = & JFactory::getDocument( );
		$version = urlencode(JoomleagueHelper::getVersion());
		$css = 'components/com_joomleague/assets/css/tabs.css?v='.$version;
		$document->addStyleSheet($css);

		// Listen for editView
		$lists=array();
		$model =& $this->getModel();
		$person=$model->getPerson();
		
		$this->assignRef('teamPlayers',$model->getTeamPlayers());

		// Select the teamplayer that is currently published (in case the player played in multiple teams in the project)
		$teamPlayer = null;
		if (count($this->teamPlayers))
		{
			$currentProjectTeamId=0;
			foreach ($this->teamPlayers as $teamPlayer)
			{
				if ($teamPlayer->published == 1)
				{
					$currentProjectTeamId=$teamPlayer->projectteam_id;
					break;
				}
			}
			if ($currentProjectTeamId)
			{
				$teamPlayer = $this->teamPlayers[$currentProjectTeamId];
			}
		}
		$this->assignRef('teamPlayer',$teamPlayer);

		// config parameter
		$config_editOwnPlayer=$config['edit_own_player'];
		$editState=$model->isEditAllowed($config_editOwnPlayer,$config['edit_own_player_state']);
		$editPicture=$model->isEditAllowed($config_editOwnPlayer,$config['edit_own_player_picture']);
		$editDescription=$model->isEditAllowed($config_editOwnPlayer,$config['edit_own_player_description']);

		$countries[]=JHTML::_('select.option','',JText::_('JL_EDIT_PERSON_SELECT_COUNTRY'));
		if ($res =& Countries::getCountryOptions()){$countries=array_merge($countries,$res);}
		$lists['countries']=JHTML::_(	'select.genericlist',$countries,'country','class="inputbox" size="1"',
										'value','text',$person->country);
		$lists['address_countries']=JHTML::_(	'select.genericlist',$countries,'address_country','class="inputbox" size="1"','value',
												'text',$person->address_country);
		unset($countries);
		$lists['birthday']=JHTML::calendar(JoomleagueHelper::convertDate($person->birthday,1),'birthday','birthday','%d-%m-%Y','class="inputbox"');
		$lists['deathday']=JHTML::calendar(JoomleagueHelper::convertDate($person->deathday,1),'deathday','deathday','%d-%m-%Y','class="inputbox"');
		
		// matchdays
		$matchdays[]=JHTML::_('select.option','0',JText::_('JL_EDIT_PERSON_SELECT_MATCHDAY'));
		if ($res =& $model->getRoundOptions()){$matchdays=array_merge($matchdays,$res);}
		if($editState)
		{
			// injury details
			$myoptions=array();
			$myoptions[]=JHTML::_('select.option','0',JText::_('JL_GLOBAL_NO'));
			$myoptions[]=JHTML::_('select.option','1',JText::_('JL_GLOBAL_YES'));
			$lists['injury']=JHTML::_(	'select.radiolist',
			$myoptions,
										'injury',
										'class="inputbox" size="1"',
										'value',
										'text',
			$this->teamPlayer->injury);
			unset($myoptions);

			$lists['injury_date']=JHTML::_(	'select.genericlist',
			$matchdays,
											'injury_date',
											'class="inputbox" size="1"',
											'value',
											'text',
			$this->teamPlayer->injury_date);
			$lists['injury_end']=JHTML::_(	'select.genericlist',
			$matchdays,
											'injury_end',
											'class="inputbox" size="1"',
											'value',
											'text',
			$this->teamPlayer->injury_end);
			// suspension details
			$myoptions=array();
			$myoptions[]=JHTML::_('select.option','0',JText::_('JL_GLOBAL_NO'));
			$myoptions[]=JHTML::_('select.option','1',JText::_('JL_GLOBAL_YES'));
			$lists['suspension']=JHTML::_(	'select.radiolist',
			$myoptions,
											'suspension',
											'class="inputbox" size="1"',
											'value',
											'text',
			$this->teamPlayer->suspension);
			unset($myoptions);
			$lists['suspension_date']=JHTML::_(	'select.genericlist',
			$matchdays,
												'suspension_date',
												'class="inputbox" size="1"',
												'value',
												'text',
			$this->teamPlayer->suspension_date);
			$lists['suspension_end']=JHTML::_(	'select.genericlist',
			$matchdays,
												'suspension_end',
												'class="inputbox" size="1"',
												'value',
												'text',
			$this->teamPlayer->suspension_end);
			// away details
			$myoptions=array();
			$myoptions[]=JHTML::_('select.option','0',JText::_('JL_GLOBAL_NO'));
			$myoptions[]=JHTML::_('select.option','1',JText::_('JL_GLOBAL_YES'));
			$lists['away']=JHTML::_(	'select.radiolist',
			$myoptions,
										'away',
										'class="inputbox" size="1"',
										'value',
										'text',
			$this->teamPlayer->away);
			unset($myoptions);
			$lists['away_date']=JHTML::_(	'select.genericlist',
			$matchdays,
											'away_date',
											'class="inputbox" size="1"',
											'value',
											'text',
			$this->teamPlayer->away_date);
			$lists['away_end']=JHTML::_(	'select.genericlist',
			$matchdays,
											'away_end',
											'class="inputbox" size="1"',
											'value',
											'text',
			$this->teamPlayer->away_end);
		}
		if($editPicture)
		{

			//if there is no image selected,use default picture
			$default = JoomleagueHelper::getDefaultPlaceholder("player");
			if (empty($this->teamPlayer->picture)){$this->teamPlayer->picture=$default;}

			// image selector
			$imageselect=ImageSelect::getSelector('picture','picture_preview','persons',$this->teamPlayer->picture, $default);

			$this->assignRef('imageselect',$imageselect);
		}
		$this->assignRef('lists',$lists);
		$this->assignRef('teamplayer',$teamplayer);
		//edit options
		$this->assignRef('edit_state',$editState);
		$this->assignRef('edit_picture',$editPicture);
		$this->assignRef('edit_description',$editDescription);
	}

}
?>