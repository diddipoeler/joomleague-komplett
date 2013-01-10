<?php defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

class JoomleagueViewClubs extends JLGView
{
	function display( $tpl = null )
	{
		// Get a refrence of the page instance in joomla
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
    
		$this->assignRef( 'division', $model->getDivision() );
		$this->assignRef( 'overallconfig', $model->getOverallConfig() );
		$this->assignRef( 'config', $config );

		$this->assignRef( 'clubs', $model->getClubs() );

		// Set page title
		$pageTitle = JText::_( 'JL_CLUBS_PAGE_TITLE' );
		if ( isset( $this->project ) )
		{
			$pageTitle .= ' - ' . $this->project->name;
			if ( isset( $this->division ) )
			{
				$pageTitle .= ' : ' . $this->division->name;
			}
		}
		$document->setTitle( $pageTitle );
    $this->assign('show_debug_info', JComponentHelper::getParams('com_joomleague')->get('show_debug_info',0) );
    
		parent::display( $tpl );
	}
}
?>