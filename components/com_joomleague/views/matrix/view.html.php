<?php defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class JoomleagueViewMatrix extends JLGView
{
	function display( $tpl = null )
	{
		// Get a refrence of the page instance in joomla
		$document= & JFactory::getDocument();

		$model = & $this->getModel();
		$config = $model->getTemplateConfig($this->getName());
		$project =& $model->getProject();
		
		$this->assignRef( 'project', $project);
		
		/*
    * league extended data
    */
    $paramsdata_league = $this->project->league_extended;
    $paramsdefs_league = JLG_PATH_ADMIN.DS.'assets'.DS.'extended'.DS.'league.xml';
    $extended_league = new JLGExtraParams($paramsdata_league,$paramsdefs_league);
    $this->assignRef('league_extended',$extended_league);
		
		$this->assignRef( 'overallconfig', $model->getOverallConfig() );

		$this->assignRef( 'config', $config );

		$this->assignRef( 'divisionid', $model->getDivisionID() );
		$this->assignRef( 'roundid', $model->getRoundID() );
		$this->assignRef( 'division', $model->getDivision() );
		$this->assignRef( 'round', $model->getRound() );
		$this->assignRef( 'teams', $model->getTeamsIndexedByPtid( $model->getDivisionID() ) );
		$this->assignRef( 'results', $model->getMatrixResults( $model->projectid ) );

		if ($project->project_type == 'DIVISIONS_LEAGUE' && !$this->divisionid )
		{
		$ranking_reason = array();
		$this->assignRef( 'divisions', $model->getDivisions() );
		
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
    
		foreach ( $this->results as $result ) 
      {
      foreach ( $this->teams as $teams ) 
        {
        
        if ( $result->division_id )
        {

        if ( ($result->projectteam1_id == $teams->projectteamid) || ($result->projectteam2_id == $teams->projectteamid) ) 
        {
        $teams->division_id = $result->division_id;
        
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
        
        $ranking_reason[$result->division_id][$teams->name] = '<font color="'.$color.'">'.$teams->name.': '.$teams->start_points.' Punkte Grund: '.$teams->reason.'</font>';
        }
        
        }

        }
        
        }
  
      }
		
    foreach ( $this->divisions as $row )
		{
		if ( isset($ranking_reason[$row->id]) )
		{
    $row->notes = implode(", ",$ranking_reason[$row->id]);
    }
    
    }
    
    }		
		
		if(!is_null($project)) {
			$this->assignRef( 'favteams', $model->getFavTeams() );
		}
		// Set page title
		$pageTitle = JText::_( 'JL_MATRIX_PAGE_TITLE' );
		if ( isset( $project->name ) )
		{
			$pageTitle .= ': ' . $project->name;
		}
		$document->setTitle( $pageTitle );
		
		$this->assign('show_debug_info', JComponentHelper::getParams('com_joomleague')->get('show_debug_info',0) );
		
		parent::display( $tpl );
	}
}
?>