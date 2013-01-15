<?php defined('_JEXEC') or die('Restricted access');

require_once(JPATH_COMPONENT.DS.'helpers'.DS.'pagination.php');

jimport('joomla.application.component.view');

class JoomleagueViewRoster extends JLGView
{

	function display($tpl=null)
	{
		// Get a refrence of the page instance in joomla
		$document =& JFactory::getDocument();
		$model =& $this->getModel();
		$config=$model->getTemplateConfig($this->getName());

		$this->assignRef('project',$model->getProject());
		$this->assignRef('overallconfig',$model->getOverallConfig());
		//$this->assignRef('staffconfig',$model->getTemplateConfig('teamstaff'));
		$this->assignRef('config',$config);
		$this->assignRef('projectteam',$model->getProjectTeam());
    
    /*
    * league extended data
    */
    $paramsdata_league = $this->project->league_extended;
    $paramsdefs_league = JLG_PATH_ADMIN.DS.'assets'.DS.'extended'.DS.'league.xml';
    $extended_league = new JLGExtraParams($paramsdata_league,$paramsdefs_league);
    $this->assignRef('league_extended',$extended_league);
    $this->assign('show_debug_info', JComponentHelper::getParams('com_joomleague')->get('show_debug_info',0) );
    
    
		if ($this->projectteam)
		{
			$this->assignRef('team',$model->getTeam());
			$this->assignRef('rows',$model->getTeamPlayers());
      $this->assignRef('userfields',$model->getUserfields());
			// events
			if ($this->config['show_events_stats'])
			{
				$this->assignRef('positioneventtypes',$model->getPositionEventTypes());
				$this->assignRef('playereventstats',$model->getPlayerEventStats());
			}
			//stats
			if ($this->config['show_stats'])
			{
				$this->assignRef('stats',$model->getProjectStats());
				$this->assignRef('playerstats',$model->getRosterStats());
			}

			$this->assignRef('stafflist',$model->getStaffList());
      
      $this->assignRef('trainingData',$model->getTrainingdata());

      $daysOfWeek=array(	0 => JText::_('JL_GLOBAL_SELECT'),
			1 => JText::_('JL_GLOBAL_MONDAY'),
			2 => JText::_('JL_GLOBAL_TUESDAY'),
			3 => JText::_('JL_GLOBAL_WEDNESDAY'),
			4 => JText::_('JL_GLOBAL_THURSDAY'),
			5 => JText::_('JL_GLOBAL_FRIDAY'),
			6 => JText::_('JL_GLOBAL_SATURDAY'),
			7 => JText::_('JL_GLOBAL_SUNDAY'));
			$dwOptions=array();
			foreach($daysOfWeek AS $key => $value){$dwOptions[]=JHTML::_('select.option',$key,$value);}
			
			if ( $this->trainingData )
			{
      foreach ($this->trainingData AS $td)
			{
				//$lists['dayOfWeek'][$td->id]=JHTML::_('select.genericlist',$dwOptions,'dw_'.$td->id,'class="inputbox"','value','text',$td->dayofweek);
				$lists['dayOfWeek'][$td->dayofweek] = $daysOfWeek[$td->dayofweek];
			}
			}
			unset($daysOfWeek);
			unset($dwOptions);
      $this->assignRef('lists',			$lists);

      //echo 'config <br><pre>'.print_r($this->config,true).'</pre><br>';
			//echo 'trainingData <br><pre>'.print_r($this->trainingData,true).'</pre><br>';
			
			// Set page title
			$document->setTitle(JText::sprintf('JL_ROSTER_TITLE',$this->team->name));
		}
		else
		{
			// Set page title
			$document->setTitle(JText::sprintf('JL_ROSTER_TITLE', "Project team does not exist"));
		}

    $document->addScript( JURI::base(true).'/components/com_joomleague/assets/js/highslide.js');
		$document->addStyleSheet( JURI::base(true) . '/components/com_joomleague/assets/css/highslide/highslide.css' );
    
    $js = "hs.graphicsDir = '".JURI::base(true) . "/components/com_joomleague/assets/css/highslide/graphics/"."';\n";
    $js .= "hs.outlineType = 'rounded-white';\n";
    
    /*
    creditsText :     'Powered by <i>Highslide JS</i>',
   creditsTitle :    'Gehe zur Highslide JS Homepage',
    */
    
    $js .= "
    hs.lang = {
   cssDirection:     'ltr',
   loadingText :     'Lade...',
   loadingTitle :    'Klick zum Abbrechen',
   focusTitle :      'Klick um nach vorn zu bringen',
   fullExpandTitle : 'Zur Originalgr&ouml;&szlig;e erweitern',
   fullExpandText :  'Vollbild',
   creditsText :     '',
   creditsTitle :    '',
   previousText :    'Voriges',
   previousTitle :   'Voriges (Pfeiltaste links)',
   nextText :        'N&auml;chstes',
   nextTitle :       'N&auml;chstes (Pfeiltaste rechts)',
   moveTitle :       'Verschieben',
   moveText :        'Verschieben',
   closeText :       'Schlie&szlig;en',
   closeTitle :      'Schlie&szlig;en (Esc)',
   resizeTitle :     'Gr&ouml;&szlig;e wiederherstellen',
   playText :        'Abspielen',
   playTitle :       'Slideshow abspielen (Leertaste)',
   pauseText :       'Pause',
   pauseTitle :      'Pausiere Slideshow (Leertaste)',
   number :          'Bild %1/%2',
   restoreTitle :    'Klick um das Bild zu schlie&szlig;en, klick und ziehe um zu verschieben. Benutze Pfeiltasten für vor und zurück.'
};

    
    \n";
    
    $document->addScriptDeclaration( $js );
    		
		parent::display($tpl);
	}

}
?>