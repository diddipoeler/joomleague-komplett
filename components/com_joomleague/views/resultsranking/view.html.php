<?php
defined('_JEXEC') or die('Restricted access');

require_once (JPATH_COMPONENT . DS . 'helpers' . DS . 'pagination.php');
require_once( JLG_PATH_SITE . DS . 'models' . DS . 'ranking.php' );
require_once( JLG_PATH_SITE . DS . 'models' . DS . 'results.php' );
require_once( JLG_PATH_SITE . DS . 'views' . DS . 'results' . DS . 'view.html.php' );

jimport('joomla.application.component.view');
jimport('joomla.filesystem.file');
jimport('joomla.html.pane');

class JoomleagueViewResultsranking extends JoomleagueViewResults {

	function display($tpl = null)
	{
		JHTML::_('behavior.mootools');
		$mainframe = JFactory::getApplication();
		$params = &$mainframe->getParams();
		// get a reference of the page instance in joomla
		$document = & JFactory :: getDocument();
		$uri = & JFactory :: getURI();
		// add the css files
		$version = urlencode(JoomleagueHelper::getVersion());
		$css		= 'components/com_joomleague/assets/css/tabs.css?v='.$version;
		$document->addStyleSheet($css);
		// add some javascript
		$version = urlencode(JoomleagueHelper::getVersion());
		$document->addScript( JURI::base(true).'/components/com_joomleague/assets/js/results.js?v='.$version);
		// add the ranking model
		$rankingmodel = new JoomleagueModelRanking();
		$project = $rankingmodel->getProject();
		// add the ranking config file
		$rankingconfig = $rankingmodel->getTemplateConfig('ranking');
		$rankingmodel->computeRanking();
		// add the results model		
		$resultsmodel	= new JoomleagueModelResults();
		// add the results config file

		$mdlRound = JModel::getInstance("Round", "JoomleagueModel");
		$roundcode = $mdlRound->getRoundcode($rankingmodel->round);
		$rounds = JoomleagueHelper::getRoundsOptions($project->id);
		
		$resultsconfig = $resultsmodel->getTemplateConfig('results');
		if (!isset($resultsconfig['switch_home_guest'])){$resultsconfig['switch_home_guest']=0;}
		if (!isset($resultsconfig['show_dnp_teams_icons'])){$resultsconfig['show_dnp_teams_icons']=0;}
		if (!isset($resultsconfig['show_results_ranking'])){$resultsconfig['show_results_ranking']=0;}

		// merge the 2 config files
		$config = array_merge($rankingconfig, $resultsconfig);

		$this->assignRef('project', 		$resultsmodel->getProject());
		
		/*
    * league extended data
    */
    $paramsdata_league = $this->project->league_extended;
    $paramsdefs_league = JLG_PATH_ADMIN.DS.'assets'.DS.'extended'.DS.'league.xml';
    $extended_league = new JLGExtraParams($paramsdata_league,$paramsdefs_league);
    $this->assignRef('league_extended',$extended_league);
    
		$this->assignRef('overallconfig',	$resultsmodel->getOverallConfig());
		$this->assignRef('config',			array_merge($this->overallconfig, $config));
		$this->assignRef('tableconfig',		$rankingconfig);
		$this->assignRef('params', 			$params);
		$this->assignRef('showediticon',	$resultsmodel->getShowEditIcon());
		$this->assignRef('division',		$resultsmodel->getDivision());
		$this->assignRef('divisions', 		$rankingmodel->getDivisions());
		
		/*
    * division extended data
    */
    $paramsdefs_division = JLG_PATH_ADMIN.DS.'assets'.DS.'extended'.DS.'division.xml';
		foreach ( $this->divisions as $row )
		{
    $paramsdata_division = $row->extended;
    $extended_division = new JLGExtraParams($paramsdata_division,$paramsdefs_division);
    $this->assignRef('division_extended',$extended_division);
    foreach ( $this->division_extended->getGroups() as $group => $groups )
			{
				$row->division_desc = $this->division_extended->get('JL_EXT_DIVISION_DESCRIPTION');
        /*
        $params = $this->league_extended->getElements($group);
				foreach ($params as $param)
				{
					if (!empty($param->value) && !$param->backendonly)
					{
					echo $param->label.' - '.$param->value;
					}
				}
				*/
			} 
    }
			
		
		$this->assignRef('divLevel',  		$rankingmodel->divLevel);
		$this->assignRef('matches',			$resultsmodel->getMatches());
		$this->assignRef('round',			$resultsmodel->roundid);
		$this->assignRef('roundid',			$resultsmodel->roundid);
		$this->assignRef('roundcode',		$roundcode);
		
		$rounds = $resultsmodel->getRoundOptions();
		$options = $this->getRoundSelectNavigation($rounds);
		
		$this->assignRef('matchdaysoptions',$options);
		$this->assignRef('currenturl', 		JoomleagueHelperRoute::getResultsRankingRoute($resultsmodel->getProject()->slug, $this->round));
		$this->assignRef('rounds',			$resultsmodel->getRounds());
		$this->assignRef('favteams',		$resultsmodel->getFavTeams($this->project));
		$this->assignRef('projectevents',	$resultsmodel->getProjectEvents());
		$this->assignRef('model',			$resultsmodel);
		$this->assignRef('isAllowed',		$resultsmodel->isAllowed());

		$this->assignRef('type',      $rankingmodel->type);
		$this->assignRef('from',      $rankingmodel->from);
		$this->assignRef('to',        $rankingmodel->to);

		$this->assignRef('currentRanking',  $rankingmodel->currentRanking);
		$this->assignRef('previousRanking', $rankingmodel->previousRanking);
		$this->assignRef('homeRank',     	$rankingmodel->homeRank);
		$this->assignRef('awayRank',      	$rankingmodel->awayRank);
		$this->assignRef('current_round', 	$rankingmodel->current_round);
		$this->assignRef('teams',			$rankingmodel->getTeamsIndexedByPtid());
		$this->assignRef('previousgames',   $rankingmodel->getPreviousGames());
		
		
		$ranking_reason = array();
		foreach ( $this->teams as $teams ) 
        {
        
        if ( $teams->start_points )
        {
        
        if ( $teams->start_points < 0 )
        {
        $color = "red";
        }
        else
        {
        $color = "green";
        }
        
        $ranking_reason[$teams->name] = '<font color="'.$color.'">'.$teams->name.': '.$teams->start_points.' Punkte Grund: '.$teams->reason.'</font>';
        }
        
        }
		
		$this->assign('ranking_notes', implode(", ",$ranking_reason) );
		
		$this->assign('action', $uri->toString());
		//rankingcolors
		if (!isset ($this->config['colors'])) {
			$this->config['colors'] = "";
		}
		$this->assignRef('colors', $rankingmodel->getColors($this->config['colors']));

		// Set page title
		$pageTitle = ($this->params->get('what_to_show_first', 0) == 0)
			? JText::_('JL_RESULTS_PAGE_TITLE').' & ' . JText :: _('JL_RANKING_PAGE_TITLE')
			: JText::_('JL_RANKING_PAGE_TITLE').' & ' . JText :: _('JL_RESULTS_PAGE_TITLE');
		if ( isset( $this->project->name ) )
		{
			$pageTitle .= ' - ' . $this->project->name;
		}
		$document->setTitle($pageTitle);
		
		$this->assign('show_debug_info', JComponentHelper::getParams('com_joomleague')->get('show_debug_info',0) );
		
		
		
		/*
		//build feed links
		$feed = 'index.php?option=com_joomleague&view=results&p='.$this->project->id.'&format=feed';
		$rss = array('type' => 'application/rss+xml', 'title' => JText::_('JL_RESULTS_RSSFEED'));

		// add the links
		$document->addHeadLink(JRoute::_($feed.'&type=rss'), 'alternate', 'rel', $rss);
		*/
		JLGView::display($tpl);
	}
	
	function getRoundSelectNavigation(&$rounds)
	{
		$options = array();
		foreach ($rounds as $r)
		{
			$link = JoomleagueHelperRoute::getResultsRankingRoute($this->project->slug, $r->value);
			$options[] = JHTML::_('select.option', $link, $r->text);
		}
		return $options;
	}
		
}
?>