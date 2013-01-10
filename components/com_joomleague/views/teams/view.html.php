<?php defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

class JoomleagueViewTeams extends JLGView
{
	function display( $tpl = null )
	{
		// Get a reference of the page instance in joomla
		$document= & JFactory::getDocument();

		$model =& $this->getModel();
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
    
		$this->assignRef( 'division', $model->getDivision() );
		$this->assignRef( 'overallconfig', $model->getOverallConfig() );
		$this->assignRef( 'config', $config );

		$this->assignRef( 'teams', $model->getTeams() );

		// Set page title
		$pageTitle = JText::_( 'JL_TEAMS_TITLE' );
		if ( isset( $this->project ) )
		{
			$pageTitle .= " " . $this->project->name;
			if ( isset( $this->division ) )
			{
				$pageTitle .= " : ". $this->division->name;
			}
		}
		$document->setTitle( $pageTitle );

		parent::display( $tpl );
	}
}
?>