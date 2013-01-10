<?php defined( '_JEXEC' ) or die( 'Restricted access' );

require_once( JPATH_COMPONENT . DS . 'helpers' . DS . 'pagination.php' );

jimport( 'joomla.application.component.view' );

class JoomleagueViewReferees extends JLGView
{

	function display( $tpl = null )
	{
		// Get a refrence of the page instance in joomla
		$document	=& JFactory::getDocument();

		$model	=& $this->getModel();
		$config = $model->getTemplateConfig($this->getName());
		
		if ( !$config )
		{
			$config	= $model->getTemplateConfig( 'players' );
		}

		$this->assignRef( 'project', $model->getProject() );
		/*
    * league extended data
    */
    $paramsdata_league = $this->project->league_extended;
    $paramsdefs_league = JLG_PATH_ADMIN.DS.'assets'.DS.'extended'.DS.'league.xml';
    $extended_league = new JLGExtraParams($paramsdata_league,$paramsdefs_league);
    $this->assignRef('league_extended',$extended_league);
    $this->assign('show_debug_info', JComponentHelper::getParams('com_joomleague')->get('show_debug_info',0) );
    
		$this->assignRef( 'overallconfig', $model->getOverallConfig() );
		$this->assignRef( 'config', $config );

		$this->assignRef( 'rows', $model->getReferees() );
//		$this->assignRef( 'positioneventtypes', $model->getPositionEventTypes( ) );

		// Set page title
		$pagetitle=JText::_( 'JL_REFEREES_PAGE_TITLE' );
		$document->setTitle( JText::sprintf( $pagetitle, $this->project->name ) );

		parent::display( $tpl );
	}

}
?>