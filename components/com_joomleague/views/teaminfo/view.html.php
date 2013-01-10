<?php defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class JoomleagueViewTeamInfo extends JLGView
{
	function display( $tpl = null )
	{
		// Get a refrence of the page instance in joomla
		$document= & JFactory::getDocument();
		$model = & $this->getModel();
		$config = $model->getTemplateConfig($this->getName());

		$this->assignRef( 'project', $model->getProject() );
    /*
    * league extended data
    */
    $paramsdata_league = $this->project->league_extended;
    $paramsdefs_league = JLG_PATH_ADMIN.DS.'assets'.DS.'extended'.DS.'league.xml';
    $extended_league = new JLGExtraParams($paramsdata_league,$paramsdefs_league);
    $this->assignRef('league_extended',$extended_league);
    $this->assign('show_debug_info', JComponentHelper::getParams('com_joomleague')->get('show_debug_info',0) );
    
		if ( isset($this->project->id) )
		{
			$this->assignRef( 'overallconfig', $model->getOverallConfig() );
			$this->assignRef( 'config', $config );
			$team = $model->getTeamByProject();
			$this->assignRef( 'team',  $team);
			$this->assignRef( 'club', $model->getClub() );
			$this->assignRef( 'seasons', $model->getSeasons( $config ) );
		}
		
    // diddipoeler
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
    
    
    	
		$paramsdata = $team->teamextended;
		$paramsdefs = JLG_PATH_ADMIN . DS . 'assets' . DS . 'extended' . DS . 'team.xml';
		$extended = new JLGExtraParams( $paramsdata, $paramsdefs );

		$this->assignRef( 'extended', $extended );
		// Set page title
		$pageTitle = JText::_( 'JL_TEAMINFO_PAGE_TITLE' );
		if ( isset( $this->team ) )
		{
			$pageTitle .= ': ' . $this->team->tname;
		}
		$document->setTitle( $pageTitle );

		parent::display( $tpl );
	}
}
?>