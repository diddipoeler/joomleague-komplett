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
jimport('joomla.html.parameter.element.timezones');

require_once( JPATH_COMPONENT . DS . 'helpers' . DS . 'imageselect.php' );
require_once( JPATH_COMPONENT . DS . 'helpers' . DS . 'kunenaforum.php' );
require_once(JPATH_COMPONENT.DS.'models'.DS.'sportstypes.php');
require_once(JPATH_COMPONENT.DS.'models'.DS.'leagues.php');

/**
 * HTML View class for the Joomleague component
 *
 * @static
 * @package	JoomLeague
 * @since	0.1
 */
class JoomleagueViewProject extends JLGView
{
	function display($tpl=null)
	{
		$option='com_joomleague';
		$mainframe =& JFactory::getApplication();
		$db =& JFactory::getDBO();
		$uri =& JFactory::getURI();
		$user =& JFactory::getUser();
		$model =& $this->getModel();

		$lists=array();
		//get the project
		$project 	=& $this->get('data');
		$isNew		= ($project->id < 1);
		$append		= '';
		if ($isNew)
		{
			$append	= ' style="background-color:#FFCCCC;"';
		}
		$edit=JRequest::getVar('edit');
		$copy=JRequest::getVar('copy');

		// fail if checked out not by 'me'
		if ($model->isCheckedOut($user->get('id')))
		{
			$msg=JText::sprintf('DESCBEINGEDITTED',JText::_('JL_ADMIN_PROJECT_THE_PROJECT'),$project->name);
			$mainframe->redirect('index.php?option='.$option,$msg);
		}

		// Edit or Create?
		if (!$isNew)
		{
			$model->checkout($user->get('id'));
		}
		else
		{
			// initialise new record
			$project->published=1;
			$project->order=0;
		}

		// add javascript
		$document =& JFactory::getDocument();
		$version = urlencode(JoomleagueHelper::getVersion());
		$document->addScript(JURI::base().'components/com_joomleague/assets/js/301a.js?v='.$version);

		//build the html select list for league
		$allLeagues = array();
		$leagues[]=JHTML::_('select.option','0',JText::_('JL_GLOBAL_SELECT_LEAGUE'),'id','name');
		if($allLeagues =& JoomleagueModelLeagues::getLeagues()) {
			$leagues=array_merge($leagues,$allLeagues);
		}
		$lists['leagues']=JHTMLSelect::genericlist($leagues,'league_id','class="inputbox validate-select-required" size="1"'.$append.'','id','name',$project->league_id);
		unset($leagues);

		//build the html select list for season
		$seasons[]=JHTMLSelect::option('0',JText::_('JL_GLOBAL_SELECT_SEASON'),'id','name');
		if ($res =& $this->get('Seasons')){
			$seasons=array_merge($seasons,$res);
		}
		$lists['seasons']=JHTMLSelect::genericlist($seasons,'season_id','class="inputbox validate-select-required" size="1"'.$append.'','id','name',$project->season_id);
		unset($seasons);

		//build the html select list for sports_type
		$allSportstypes = array();
		$sports_type[]=JHTMLSelect::option('0',JText::_('JL_GLOBAL_SELECT_SPORTSTYPE'),'id','name');
		if($allSportstypes =& JoomleagueModelSportsTypes::getSportsTypes()) {
			$sports_type=array_merge($sports_type,$allSportstypes);
		}
		$lists['sports_type']=JHTMLSelect::genericlist($sports_type,'sports_type_id','class="inputbox validate-select-required" size="1"'.$append.'','id','name',$project->sports_type_id);
		unset($sports_type);

		//build the html select list for admin
		$lists['admin']=JHTML::_('list.users','admin',$project->admin,0,ltrim($append));

		//build the html select list for editor
		$lists['editor']=JHTML::_('list.users','editor',$project->editor,0,ltrim($append),'name',0);

		//build the html select list for masters templates (projects)
		$masters[]=JHTMLSelect::option('0',JText::_('JL_GLOBAL_SELECT_TEMPLATE'),'id','name');
		if ($res =& $this->get('Masters')){
			$masters=array_merge($masters,$res);
		}
		$lists['masters']=JHTMLSelect::genericlist($masters,'master_template','class="inputbox" size="1"','id','name',$project->master_template);
		unset($masters);

		// list of folders in frontend (for extensions)
		$folder=array();
		$handle=opendir(''.JPATH_ROOT.'/components/com_joomleague/extensions');
		while ($file=readdir($handle))
		{
			if ($file!='index.html' && $file!='.' && $file!='..'){
				$folder[]=JHTMLSelect::option($file,$file,'id','name');
			}
		}
		closedir($handle);
		$extensions=@explode(",",$project->extension);
		$lists['extensions']=JHTMLSelect::genericlist($folder,'extension[]',' multiple="true" class="inputbox" size="5" width="20"','id','name',$extensions);
		unset($folder);
		
		//project specific setting
		$prjTimezone  = $project->serveroffset;
		
		//global joomleague timezone config setting
		$params = JComponentHelper::getParams('com_joomleague');
		$jlgTimezone = $params->get('cfg_standard_server_offset', $prjTimezone);
		
		//global joomla timezone setting
		$conf =& JFactory::getConfig();
		$srvTimezone = $conf->getValue('config.offset');
		
		// LOCALE SETTINGS
		$timezones = array (
			JHTML::_('select.option', -12, JText::_('(UTC -12:00) International Date Line West')),
			JHTML::_('select.option', -11, JText::_('(UTC -11:00) Midway Island, Samoa')),
			JHTML::_('select.option', -10, JText::_('(UTC -10:00) Hawaii')),
			JHTML::_('select.option', -9.5, JText::_('(UTC -09:30) Taiohae, Marquesas Islands')),
			JHTML::_('select.option', -9, JText::_('(UTC -09:00) Alaska')),
			JHTML::_('select.option', -8, JText::_('(UTC -08:00) Pacific Time (US &amp; Canada)')),
			JHTML::_('select.option', -7, JText::_('(UTC -07:00) Mountain Time (US &amp; Canada)')),
			JHTML::_('select.option', -6, JText::_('(UTC -06:00) Central Time (US &amp; Canada), Mexico City')),
			JHTML::_('select.option', -5, JText::_('(UTC -05:00) Eastern Time (US &amp; Canada), Bogota, Lima')),
			JHTML::_('select.option', -4, JText::_('(UTC -04:00) Atlantic Time (Canada), Caracas, La Paz')),
			JHTML::_('select.option', -4.5, JText::_('(UTC -04:30) Venezuela')),
			JHTML::_('select.option', -3.5, JText::_('(UTC -03:30) St. John\'s, Newfoundland, Labrador')),
			JHTML::_('select.option', -3, JText::_('(UTC -03:00) Brazil, Buenos Aires, Georgetown')),
			JHTML::_('select.option', -2, JText::_('(UTC -02:00) Mid-Atlantic')),
			JHTML::_('select.option', -1, JText::_('(UTC -01:00) Azores, Cape Verde Islands')),
			JHTML::_('select.option', 0, JText::_('(UTC 00:00) Western Europe Time, London, Lisbon, Casablanca')),
			JHTML::_('select.option', 1, JText::_('(UTC +01:00) Amsterdam, Berlin, Brussels, Copenhagen, Madrid, Paris')),
			JHTML::_('select.option', 2, JText::_('(UTC +02:00) Istanbul, Jerusalem, Kaliningrad, South Africa')),
			JHTML::_('select.option', 3, JText::_('(UTC +03:00) Baghdad, Riyadh, Moscow, St. Petersburg')),
			JHTML::_('select.option', 3.5, JText::_('(UTC +03:30) Tehran')),
			JHTML::_('select.option', 4, JText::_('(UTC +04:00) Abu Dhabi, Muscat, Baku, Tbilisi')),
			JHTML::_('select.option', 4.5, JText::_('(UTC +04:30) Kabul')),
			JHTML::_('select.option', 5, JText::_('(UTC +05:00) Ekaterinburg, Islamabad, Karachi, Tashkent')),
			JHTML::_('select.option', 5.5, JText::_('(UTC +05:30) Bombay, Calcutta, Madras, New Delhi, Colombo')),
			JHTML::_('select.option', 5.75, JText::_('(UTC +05:45) Kathmandu')),
			JHTML::_('select.option', 6, JText::_('(UTC +06:00) Almaty, Dhaka')),
			JHTML::_('select.option', 6.5, JText::_('(UTC +06:30) Yagoon')),
			JHTML::_('select.option', 7, JText::_('(UTC +07:00) Bangkok, Hanoi, Jakarta')),
			JHTML::_('select.option', 8, JText::_('(UTC +08:00) Beijing, Perth, Singapore, Hong Kong')),
			JHTML::_('select.option', 8.75, JText::_('(UTC +08:00) Ulaanbaatar, Western Australia')),
			JHTML::_('select.option', 9, JText::_('(UTC +09:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk')),
			JHTML::_('select.option', 9.5, JText::_('(UTC +09:30) Adelaide, Darwin, Yakutsk')),
			JHTML::_('select.option', 10, JText::_('(UTC +10:00) Eastern Australia, Guam, Vladivostok')),
			JHTML::_('select.option', 10.5, JText::_('(UTC +10:30) Lord Howe Island (Australia)')),
			JHTML::_('select.option', 11, JText::_('(UTC +11:00) Magadan, Solomon Islands, New Caledonia')),
			JHTML::_('select.option', 11.5, JText::_('(UTC +11:30) Norfolk Island')),
			JHTML::_('select.option', 12, JText::_('(UTC +12:00) Auckland, Wellington, Fiji, Kamchatka')),
			JHTML::_('select.option', 12.75, JText::_('(UTC +12:45) Chatham Island')),
			JHTML::_('select.option', 13, JText::_('(UTC +13:00) Tonga')),
			JHTML::_('select.option', 14, JText::_('(UTC +14:00) Kiribati')),);

		$lists['servertimezone']	= JHTML::_('select.genericlist', $timezones, 'servertimezone', ' disabled class="inputbox"', 'value', 'text', $srvTimezone);
		$lists['joomleaguetimezone']= JHTML::_('select.genericlist', $timezones, 'joomleaguetimezone', ' disabled class="inputbox"', 'value', 'text', $jlgTimezone);
		$lists['projecttimezone']	= JHTML::_('select.genericlist', $timezones, 'serveroffset', ' class="inputbox"', 'value', 'text', $prjTimezone);
		
		$project_type=array (	JHTMLSelect::option('SIMPLE_LEAGUE',JText::_('SIMPLE_LEAGUE'),'id','name'),
								JHTMLSelect::option('DIVISIONS_LEAGUE',JText::_('DIVISIONS_LEAGUE'),'id','name'),
								//JHTMLSelect::option('SIMPLE_KO',JText::_('SIMPLE_KO'),'id','name'),
								JHTMLSelect::option('TOURNAMENT_MODE',JText::_('TOURNAMENT_MODE'),'id','name'),
								JHTMLSelect::option('FRIENDLY_MATCHES',JText::_('FRIENDLY_MATCHES'),'id','name')
							);
		$lists['project_type']=JHTMLSelect::genericlist($project_type,'project_type','class="inputbox" size="1"','id','name',$project->project_type);
		unset($project_type);

		// build the html select list for ordering
		$query = $model->getOrderingAndProjectQuery();
		$lists['ordering']=JHTML::_('list.specificordering',$project,$project->id,$query,1);

		// build the html select list
		$lists['teams_as_referees']=JHTMLSelect::booleanlist('teams_as_referees','class="inputbox"',$project->teams_as_referees);

		// build the html radio for team as referee
		$lists['published']=JHTMLSelect::booleanlist('published','class="inputbox"',$project->published);

		// build the html list for current_round_auto
		$current_round_auto=array(	JHTMLSelect::option('0',JText::_('JL_ADMIN_PROJECT_ROUND_MANUAL'),'id','name'),
									JHTMLSelect::option('1',JText::_('JL_ADMIN_PROJECT_ROUND_START'),'id','name'),
									JHTMLSelect::option('2',JText::_('JL_ADMIN_PROJECT_ROUND_END'),'id','name'),
									JHTMLSelect::option('3',JText::_('JL_ADMIN_PROJECT_ROUND_FIRST'),'id','name'),
									JHTMLSelect::option('4',JText::_('JL_ADMIN_PROJECT_ROUND_LAST'),'id','name')
									);
		$lists['current_round_auto']=JHTMLSelect::genericlist($current_round_auto,'current_round_auto','class="inputbox" size="1" onchange="RoundAutoSwitch();"','id','name',$project->current_round_auto);
		unset($current_round_auto);
		$rounds = JoomleagueHelper::getRoundsOptions($project->id);
		$lists['rounds']=JHTMLSelect::genericlist($rounds,'current_round','class="inputbox" size="1"','value','text',$project->current_round);
		
		
		// build the html radio for allow_add_time
		$lists['allow_add_time']=JHTMLSelect::booleanlist('allow_add_time',null,$project->allow_add_time);

		// build the html select list
		$lists['use_legs']=JHTMLSelect::booleanlist('use_legs','class="inputbox"',$project->use_legs);

		//build the html select list for project assigned teams
		$ress=array();
		$favlist=@explode(",",$project->fav_team);
		if ($ress =& $model->getProjectteamsbyID())
		{
			$favteamslist=array();
			foreach($ress as $res){$project_teamslist[]=JHTMLSelect::option($res->value,$res->text);}

			$lists['fav_team']=JHTMLSelect::genericlist($project_teamslist,'fav_team[]',' style="width:150px" class="inputbox" multiple="true" size="'.max(10,count($ress)).'"','value','text',$favlist);
		}
		else
		{
			$lists['fav_team']='<select name="fav_team[]" id="fav_team[]" style="width:150px" class="inputbox" multiple="true" size="10"></select>';
		}
		$lists['fav_team_highlight_type']=JHTMLSelect::booleanlist('fav_team_highlight_type','class="inputbox"', $project->fav_team_highlight_type, 'JL_ADMIN_PROJECT_HIGHLIGHT_TYPE_ENTIRE_ROW', 'JL_ADMIN_PROJECT_HIGHLIGHT_TYPE_NAME_ONLY');
		$lists['fav_team_text_bold']=JHTMLSelect::booleanlist('fav_team_text_bold','class="inputbox"', $project->fav_team_text_bold);
		$res =& $this->get('Leagues');

		$this->assignRef('edit',$edit);
		$this->assignRef('copy',$copy);
		$this->assignRef('lists',$lists);
		$this->assignRef('project',$project);
		$this->assignRef('leagues',$res);
		
		// image selector
		$default = JoomleagueHelper::getDefaultPlaceholder('clublogomedium');
		if (empty($project->picture)){
			$project->picture=$default;
		}
		
		$imageselect = ImageSelect::getSelector('picture','picture_preview','projects',$project->picture, $default);
		
		$this->assignRef( 'imageselect', $imageselect);
		
    /*
		 * kunena forum
		 */
    $isforumexist = JLKunenaForum::getKunenaForum();
    $this->assignRef( 'isforumexist',		$isforumexist );
    if ( $isforumexist )
    {
    // make a standard yes/no list
	  $yesno = array ();
	  $yesno [] = JHTML::_ ( 'select.option', '1', JText::_('JL_ADMIN_PROJECT_FORUM_ENABLE_YES') );
	  $yesno [] = JHTML::_ ( 'select.option', '0', JText::_('JL_ADMIN_PROJECT_FORUM_ENABLE_NO') );
	  $lists['forumLocked'] = JHTML::_ ( 'select.genericlist', $yesno, 'enable_sb', 'class="inputbox" size="1"', 'value', 'text', $project->enable_sb );
    $categories = JLKunenaForum::getKunenaCategories($project->sb_catid);
    $this->assignRef('forumcategories',$categories);
    }
    
		/*
		 * extended data
		 */
		$paramsdata = $project->extended;
		$paramsdefs = JPATH_COMPONENT . DS . 'assets' . DS . 'extended' . DS . 'project.xml';
		$extended = new JParameter( $paramsdata, $paramsdefs );

		$this->assignRef( 'extended',		$extended );
		
		parent::display($tpl);
	}

}
?>