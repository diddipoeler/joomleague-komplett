<?php defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );
jimport( 'joomla.html.pane' );
jimport( 'joomla.functions');
JHTML::_('behavior.tooltip');

class JoomleagueViewIcal extends JLGView
{
	function display( $tpl = null )
	{
		// Get a reference of the page instance in joomla
		$document	=& JFactory::getDocument();
		$model	 	=& $this->getModel();

		$project	=& $model->getProject();
		$config		= $model->getTemplateConfig($this->getName());
		//$config['show_playground']=1;

		$document->addScript( '/includes/js/overlib_mini.js' );

		if ( isset( $project ) )
		{

			$this->assignRef( 'project', $project );

			$this->assignRef( 'overallconfig',      $model->getOverallConfig() );
			$this->assignRef( 'config',		$this->overallconfig );

			//	$this->assignRef( 'config',		array_merge($this->overallconfig, $config) );
			$this->assignRef( 'teams',		$model->getTeamsIndexedByPtid() );
			$this->assignRef( 'matches',		$model->getMatches( $config ) );

		}

		$project_offset  = $project->serveroffset;
		$isdst 		= date("I");

		// load a class that handles ical formats.
		require_once( JLG_PATH_SITE . DS . 'helpers' . DS . 'iCalcreator.class.php' );
		// create a new calendar instance
		$v = new vcalendar();

		foreach($this->matches as $match)
		{

			$hometeam = $this->teams[$match->projectteam1_id];
			$home = sprintf('%s', $hometeam->name);
			$guestteam = $this->teams[$match->projectteam2_id];
			$guest = sprintf('%s', $guestteam->name);
			$summary= $project->name.': '.$home.' - '.$guest;

			//  check if match gots a date, if not it will not be included
			//  in ical
			if (!strstr($match->match_date , "0000-00-00"))
			{

				$syear		= JHTML::date($match->match_date, "%Y");
				$sday		= JHTML::date($match->match_date, "%d");
				$smonth		= JHTML::date($match->match_date, "%m");
				$shour		= JHTML::date($match->match_date, "%H");
				$smin	 	= JHTML::date($match->match_date, "%M");

				//$start	= JHTML::date($match->match_date, "%Y-%m-%d %H:%M:%S" );
				$start 		= strftime("%Y-%m-%d %H:%M:%S",strtotime($match->match_date));
				$start_oldphpversion = array( 'year'=>$syear, 'month'=>$smonth, 'day'=>$sday, 'hour'=>$shour, 'min'=>$smin, 'sec'=>0 );

				$time_to_ellapse = ($project->halftime * ($project->game_parts - 1)) + $project->game_regular_time;
				$endtime = JoomleagueHelper::getTimestamp( $match->match_date )+$time_to_ellapse*60;

				$year		= JHTML::date($endtime, "%Y");
				$day	 	= JHTML::date($endtime, "%d");
				$month 		= JHTML::date($endtime, "%m");
				$hour		= JHTML::date($endtime, "%H");
				$min 		= JHTML::date($endtime, "%M");

				//$end		= JHTML::date($endtime, "%Y-%m-%d %H:%M:%S" );
				$end		= strftime("%Y-%m-%d %H:%M:%S", $endtime);
				$end_oldphpversion = array( 'year'=>$year, 'month'=>$month, 'day'=>$day, 'hour'=>$hour, 'min'=>$min, 'sec'=>0 );

				// check if exist a playground in match or team or club
				if ($match->playground_id !="")
				{
					$stringlocation= $match->playground_address.", ".$match->playground_zipcode." ".$match->playground_city;
					$stringname= $match->playground_name;

				}
				else if ($match->team_playground_id !="")
				{
					$stringlocation= $match->team_playground_address.", ".$match->team_playground_zipcode." ".$match->team_playground_city;
					$stringname= $match->team_playground_name;
				}
				elseif ($match->club_playground_id !="")
				{
					$stringlocation= $match->club_playground_address.", ".$match->club_playground_zipcode." ".$match->club_playground_city;
					$stringname= $match->club_playground_name;

				}

				$location=$stringlocation;

				//if someone want to insert more in description here is the place
				$description=$stringname;

				// create an event and insert it in calendar
				$vevent = new vevent();

				// set correct dtstart/dtend time depending on which project timezone you set in joomleague backend
				// transformDateTime needs PHP >= PHP 5.2.0 (timezone_name_from_abbr needs PHP 5 >= 5.1.3)
				if ( substr( phpversion(), 0, 3 ) >= '5.2' )
				{

				    //$tzFr = "Europe/Berlin";
				    $tzFr = timezone_name_from_abbr("", ($project_offset*60*60), $isdst);

				    if ( FALSE !== iCalUtilityFunctions::transformDateTime( $start, $tzFr ))
				    {
						$vevent->setProperty( "dtstart", $start."Z" );
				    }
				    else
				    {
						$vevent->setProperty( "dtstart", $start, array( "TZID" => $tzFr ));
				    }

				    if ( FALSE !== iCalUtilityFunctions::transformDateTime( $end, $tzFr ))
				    {
						$vevent->setProperty( "dtend", $end."Z" );
				    }
				    else
				    {
						$vevent->setProperty( "dtend", $end, array( "TZID" => $tzFr ));
				    }

				}
				else
				{

				    // when PHP version is < 5.2 do it the old way (and have possibly wrong start/end times)
				    $vevent->setProperty( 'dtstart', $start_oldphpversion );
				    $vevent->setProperty( 'dtend', $end_oldphpversion );

				}

				$vevent->setProperty( 'LOCATION', $location );
				$vevent->setProperty( 'summary', $summary );
				$vevent->setProperty( 'description', $description );

				$v->setComponent ( $vevent );

			}

		}

		$v->returnCalendar();

		// exit before display
		//		parent::display( $tpl );
	}

}
?>
