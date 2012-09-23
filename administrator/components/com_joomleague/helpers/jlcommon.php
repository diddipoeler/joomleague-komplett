<?php
/**
 * @copyright	Copyright (C) 2005-2012 JoomLeague.net. All rights reserved.
 * @license		GNU/GPL,see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License,and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
if( !defined('THUMBLIB_BASE_PATH') ) {
	require_once(JLG_PATH_SITE.DS.'assets'.DS.'classes'.DS.'PHPThumb'.DS.'ThumbLib.inc.php');
}

class JoomleagueHelper
{

	/**
	 * Method to return a project array (id,name)
	 *
	 * @access	public
	 * @return	array project
	 * @since	1.5
	 */
	function getProjects()
	{
		$db =& JFactory::getDBO();

		$query='	SELECT	id,
							name

					FROM #__joomleague_project
					ORDER BY ordering, name ASC';

		$db->setQuery($query);

		if (!$result=$db->loadObjectList())
		{
			$this->setError($db->getErrorMsg());
			return false;
		}
		else
		{
			return $result;
		}
	}

	/**
	 * Method to return the project teams array (id,name)
	 *
	 * @access	public
	 * @return	array
	 * @since	0.1
	 */
	function getProjectteams($project_id)
	{
		$db =& JFactory::getDBO();
		$query='	SELECT	pt.id AS value,
							t.name AS text,
							t.notes

					FROM #__joomleague_team AS t
					LEFT JOIN #__joomleague_project_team AS pt ON pt.team_id=t.id
					WHERE pt.project_id='.$project_id.'
					ORDER BY name ASC ';

		$db->setQuery($query);
		if (!$result=$db->loadObjectList())
		{
			$this->setError($db->getErrorMsg());
			return false;
		}
		else
		{
			return $result;
		}
	}

	/**
	 * Method to return the project teams array (id,name)
	 *
	 * @access	public
	 * @return	array
	 * @since	1.5.03a
	 */
	function getProjectteamsNew($project_id)
	{
		$db =& JFactory::getDBO();

		$query='	SELECT	pt.team_id AS value,
							t.name AS text,
							t.notes

					FROM #__joomleague_team AS t
					LEFT JOIN #__joomleague_project_team AS pt ON pt.team_id=t.id
					WHERE pt.project_id='.(int) $project_id.'
					ORDER BY name ASC ';

		$db->setQuery($query);
		if (!$result=$db->loadObjectList())
		{
			$this->setError($db->getErrorMsg());
			return false;
		}
		else
		{
			return $result;
		}
	}

	function getProjectFavTeams($project_id)
	{
		$db =& JFactory::getDBO();

		$query='	SELECT fav_team,
							fav_team_color,
							fav_team_text_color,
							fav_team_highlight_type,
							fav_team_text_bold

					FROM #__joomleague_project
					WHERE id='.(int) $project_id;

		$db->setQuery($query);
		if (!$result=$db->loadObject())
		{
			$this->setError($db->getErrorMsg());
			return false;
		}
		else
		{
			return $result;
		}
	}

	/**
	 * Method to return a SportsType name
	 *
	 * @access	public
	 * @return	array project
	 * @since	1.5
	 */
	function getSportsTypeName($sportsType)
	{
		$db =& JFactory::getDBO();
		$query='SELECT name FROM #__joomleague_sports_type WHERE id='.(int) $sportsType;
		$db->setQuery($query);
		if (!$result=$db->loadResult())
		{
			$this->setError($db->getErrorMsg());
			return false;
		}
		return JText::_($result);
	}

	/**
	 * Method to return a sportsTypees array (id,name)
	 *
	 * @access	public
	 * @return	array seasons
	 * @since	1.5.0a
	 */
	function getSportsTypes()
	{
		$db =& JFactory::getDBO();
		$query='SELECT id, name FROM #__joomleague_sports_type ORDER BY name ASC ';
		$db->setQuery($query);
		if (!$result=$db->loadObjectList())
		{
			$this->setError($db->getErrorMsg());
			return false;
		}
		foreach ($result as $sportstype){
			$sportstype->name=JText::_($sportstype->name);
		}
		return $result;
	}

	/**
	 * Method to return a SportsType name
	 *
	 * @access	public
	 * @return	array project
	 * @since	1.5
	 */
	function getPosPersonTypeName($personType)
	{
		switch ($personType)
		{
			case 2	:	$result =	JText::_('JL_F_TEAM_STAFF');
			break;
			case 3	:	$result =	JText::_('JL_F_REFEREES');
			break;
			case 4	:	$result =	JText::_('JL_F_CLUB_STAFF');
			break;
			default	:
			case 1	:	$result =	JText::_('JL_F_PLAYERS');
			break;
		}
		return $result;
	}

	/**
	 * return name of extension assigned to current project.
	 * @param int project_id
	 * @return string or false
	 */
	function getExtension($project_id=0)
	{
		$option='com_joomleague';
		if (!$project_id)
		{
			$app=&JFactory::getApplication();
			$project_id=$app->getUserState($option.'project',0);
		}
		if (!$project_id){
			return false;
		}

		$db=&JFactory::getDBO();
		$query='SELECT extension FROM #__joomleague_project WHERE id='. $db->Quote((int)$project_id);
		$db->setQuery($query);
		$res=$db->loadResult();

		return (!empty($res) ? $res : false);
	}

	function getExtensions($project_id)
	{
		$option='com_joomleague';
		$arrExtensions = array();
		$excludeExtension = array();
		if ($project_id) {
			$db=&JFactory::getDBO();
			$query='SELECT extension FROM #__joomleague_project WHERE id='. $db->Quote((int)$project_id);

			$db->setQuery($query);
			$res=$db->loadObject();
			if(!empty($res)) {
				$excludeExtension = explode(",", $res->extension);
			}
		}
		if(JFolder::exists(JPATH_SITE.DS.'components'.DS.'com_joomleague'.DS.'extensions')) {
			$folderExtensions  = JFolder::folders(JPATH_SITE.DS.'components'.DS.'com_joomleague'.DS.'extensions',
													'.', false, false, $excludeExtension);
			if($folderExtensions !== false) {
				foreach ($folderExtensions as $ext)
				{
					$arrExtensions[] = $ext;
				}
			}
		}

		return $arrExtensions;
	}

	/**
	 * returns number of years between 2 dates
	 *
	 * @param string $birthday date in YYYY-mm-dd format
	 * @param string $current_date date in YYYY-mm-dd format,default to today
	 * @return int age
	 */
	function getAge($date, $seconddate)
	{

		if ( ($date != "0000-00-00") &&
		(preg_match('/([0-9]{4})-([0-9]{2})-([0-9]{2})/',$date,$regs) ) &&
		($seconddate == "0000-00-00") )
		{
			$intAge=date('Y') - $regs[1];
			if($regs[2] > date('m'))
			{
				$intAge--;
			}
			else
			{
				if($regs[2] == date('m'))
				{
					if($regs[3] > date('d')) $intAge--;
				}
			}
			return $intAge;
		}

		if ( ($date != "0000-00-00") &&
		( preg_match('/([0-9]{4})-([0-9]{2})-([0-9]{2})/',$date,$regs) ) &&
		($seconddate != "0000-00-00") &&
		( preg_match('/([0-9]{4})-([0-9]{2})-([0-9]{2})/',$seconddate,$regs2) ) )
		{
			$intAge=$regs2[1] - $regs[1];
			if($regs[2] > $regs2[2])
			{
				$intAge--;
			}
			else
			{
				if($regs[2] == $regs2[2])
				{
					if($regs[3] > $regs2[3] ) $intAge--;
				}
			}
			return $intAge;
		}

		return '-';
	}

	/**
	 * returns the default placeholder
	 *
	 * @param string $type ,default is player
	 * @return string placeholder (path)
	 */
	public static function getDefaultPlaceholder($type="player")
	{	
		$params		 	=	JComponentHelper::getParams('com_joomleague');
		/*
		$ph_player		=	$params->get('ph_player',0);
		$ph_logo_big	=	$params->get('ph_logo_big',0);	
		$ph_logo_medium	=	$params->get('ph_logo_medium',0);		
		$ph_logo_small	=	$params->get('ph_logo_small',0);
		$ph_icon		=	$params->get('ph_icon',0);			
		$ph_team		=	$params->get('ph_team',0);
		*/
		$ph_player		=	$params->get('ph_player');
		$ph_logo_big	=	$params->get('ph_logo_big');	
		$ph_logo_medium	=	$params->get('ph_logo_medium');		
		$ph_logo_small	=	$params->get('ph_logo_small');
		$ph_icon		=	$params->get('ph_icon');			
		$ph_team		=	$params->get('ph_team');
		
			//setup the different placeholders
			switch ($type) {
				case "player": //player
					return $ph_player;
					break;
				case "clublogobig": //club logo big
					return $ph_logo_big;
					break;
				case "clublogomedium": //club logo medium
					return $ph_logo_medium;
					break;
				case "clublogosmall": //club logo small
					return $ph_logo_small;
					break;
				case "icon": //icon
					return $ph_icon;
					break;
				case "team": //team picture
					return $ph_team;;
					break;					
				default:
					$picture=null;
				break;
			}	
	}
	
	/**
	 *
	 * static method which return a <img> tag with the given picture
	 * @param string $picture
	 * @param string $alttext
	 * @param int $width=40, if set to 0 the original picture width will be used
	 * @param int $height=40, if set to 0 the original picture height will be used
	 * @param int $type=0, 0=player, 1=club logo big, 2=club logo medium, 3=club logo small
	 * @return string
	 */
	public static function getPictureThumb($picture, $alttext, $width=40, $height=40, $type=0)
	{
		$ret = "";
		$picturepath 	= 	JPath::clean(JPATH_SITE.DS.str_replace(JPATH_SITE.DS, '', $picture));
		$params		 	=	JComponentHelper::getParams('com_joomleague');
		$ph_player		=	$params->get('ph_player',0);
		$ph_logo_big	=	$params->get('ph_logo_big',0);	
		$ph_logo_medium	=	$params->get('ph_logo_medium',0);		
		$ph_logo_small	=	$params->get('ph_logo_small',0);
		$ph_icon		=	$params->get('ph_icon',0);			
		$ph_team		=	$params->get('ph_team',0);
		
		if (!file_exists($picturepath) || $picturepath == JPATH_SITE.DS)
		{
			//setup the different placeholders
			switch ($type) {
				case 0: //player
					$picture=JPATH_SITE.DS.$ph_player;
					break;
				case 1: //club logo big
					$picture=JPATH_SITE.DS.$ph_logo_big;
					break;
				case 2: //club logo medium
					$picture=JPATH_SITE.DS.$ph_logo_medium;
					break;
				case 3: //club logo small
					$picture=JPATH_SITE.DS.$ph_logo_small;
					break;
				case 4: //icon
					$picture=JPATH_SITE.DS.$ph_icon;
					break;
				case 5: //team picture
					$picture=JPATH_SITE.DS.$ph_team;
					break;					
				default:
					$picture=null;
				break;
			}
		}
		if (!empty($picture))
		{
			$params = JComponentHelper::getParams('com_joomleague');
			$format = "JPG"; //PNG is not working in IE8
			$format = $params->get('thumbformat', 'PNG');
			$bUseThumbLib = $params->get('usethumblib', false);
			if($bUseThumbLib) {
				if (file_exists($picturepath)) {
					$picture = $picturepath;
				}
				$thumb=PhpThumbFactory::create($picture);
				$thumb->setFormat($format);

				//height and width set, resize it with the thumblib
				if($height>0 && $width>0) {
					$thumb->setMaxHeight($height);
					$thumb->adaptiveResizeQuadrant ($width, $height, $quadrant = 'C');
					$pic=$thumb->getImageAsString();
					$ret .= '<img src="data:image/'.$format.';base64,'. base64_encode($pic);
					$ret .='" alt="'.$alttext.'" title="'.$alttext.'"/>';
				}
				//height==0 and width set, let the browser resize it
				if($height==0 && $width>0) {
					$thumb->setMaxWidth($width);
					$pic=$thumb->getImageAsString();
					$ret .= '<img src="data:image/'.$format.';base64,'. base64_encode($pic);
					$ret .='" width="'.$width.'" alt="'.$alttext.'" title="'.$alttext.'"/>';
				}
				//width==0 and height set, let the browser resize it
				if($height>0 && $width==0) {
					$thumb->setMaxHeight($height);
					$pic=$thumb->getImageAsString();
					$ret .= '<img src="data:image/'.$format.';base64,'. base64_encode($pic);
					$ret .='" height="'.$height.'" alt="'.$alttext.'" title="'.$alttext.'"/>';
				}
				//width==0 and height==0, use original picture size
				if($height==0 && $width==0) {
					$thumb->setMaxHeight($height);
					$pic=$thumb->getImageAsString();
					$ret .= '<img src="data:image/'.$format.';base64,'. base64_encode($pic);
					$ret .='" alt="'.$alttext.'" title="'.$alttext.'"/>';
				}
			} else {
				$picture = JURI::root(true).'/'.str_replace(JPATH_SITE.DS, "", $picture);
				//height and width set, let the browser resize it
				if($height>0 && $width>0) {
					$ret .= '<img src="'.$picture;
					$ret .='" width="'.$width.'" height="'.$height.'"
							alt="'.$alttext.'" title="'.$alttext.'"/>';
				}
				//height==0 and width set, let the browser resize it
				if($height==0 && $width>0) {
					$ret .= '<img src="'.$picture;
					$ret .='" width="'.$width.'" alt="'.$alttext.'" title="'.$alttext.'"/>';
				}
				//width==0 and height set, let the browser resize it
				if($height>0 && $width==0) {
					$ret .= '<img src="'.$picture;
					$ret .='" height="'.$height.'" alt="'.$alttext.'" title="'.$alttext.'"/>';
				}
				//width==0 and height==0, use original picture size
				if($height==0 && $width==0) {
					$ret .= '<img src="'.$picture;
					$ret .='" alt="'.$alttext.'" title="'.$alttext.'"/>';
				}

			}
				
		}
			
		return $ret;
	}

	/**
	 * static method which extends template path for given view names
	 * Can be used by views to search for extensions that implement parts of common views
	 * and add their path to the template search path.
	 * (e.g. 'projectheading', 'backbutton', 'footer')
	 * @param array(string) $viewnames, names of views for which templates need to be loaded,
	 *                      so that extensions are used when available
	 * @param JLGView       $view to which the template paths should be added
	 */
	public static function addTemplatePaths($templatesToLoad, &$view)
	{
		$extensions = JoomleagueHelper::getExtensions(JRequest::getInt('p'));
		foreach ($templatesToLoad as $template)
		{
			$view->addTemplatePath(JPATH_COMPONENT . DS . 'views' . DS . $template . DS . 'tmpl');
			if (is_array($extensions) && count($extensions) > 0)
			{
				foreach ($extensions as $e => $extension) 
				{
					$extension_views = JPATH_COMPONENT_SITE . DS . 'extensions' . DS . $extension . DS . 'views';
					$tmpl_path = $extension_views . DS . $template . DS . 'tmpl';
					if (JFolder::exists($tmpl_path))
					{
						$view->addTemplatePath($tmpl_path);
					}
				}
			}
		}
	}

	/**
	 * get unix timestamp of specified date
	 *
	 * @param string $date now if null
	 * @param boolean $use_offset use time offset
	 * @param int $project_serveroffset custom time offset in hours. Use default joomla timeoffset if null
	 */
	function getTimestamp($date = null, $use_offset = 0, $offset = null)
	{
		$date = $date ? $date : 'now';
		$app = Jfactory::getApplication();
		$res = JFactory::getDate(strtotime($date));

		if ($use_offset)
		{
			if ($offset)
			{
				$serveroffset=explode(':', $offset);
				$res->setOffset($serveroffset[0]);
			}
			else
			{
				$res->setOffset($app->getCfg('offset'));
			}
		}
		return $res->toUnix('true');
	}

	/**
	 * Method to convert a date from 0000-00-00 to 00-00-0000 or back
	 * return a date string
	 * $direction == 1 means from convert from 0000-00-00 to 00-00-0000
	 * $direction != 1 means from convert from 00-00-0000 to 0000-00-00
	 * call by JoomleagueHelper::convertDate($date) inside the script
	 *
	 * When no "-" are given in $date two short date formats (DDMMYYYY and DDMMYY) are supported
	 * for example "31122011" or "311211" for 31 december 2011
	 * 
	 * @access	public
	 * @return	array
	 *
	 */
	function convertDate($DummyDate,$direction=1)
	{
		if(!strpos($DummyDate,"-")!==false)
		{
			// for example 31122011 is used for 31 december 2011
			if (strlen($DummyDate) == 8 )
			{
				$result  = substr($DummyDate,4,4);
				$result .= '-';
				$result .= substr($DummyDate,2,2);
				$result .= '-';
				$result .= substr($DummyDate,0,2);
			}
			// for example 311211 is used for 31 december 2011
			elseif (strlen($DummyDate) == 6 )
 			{
 				$result  = substr(date("Y"),0,2);
				$result .= substr($DummyDate,4,4);
				$result .= '-';
				$result .= substr($DummyDate,2,2);
				$result .= '-';
				$result .= substr($DummyDate,0,2);
			}
		}
		else
		{

			if ($direction == 1)
			{
				$result  = substr($DummyDate,8);
				$result .= '-';
				$result .= substr($DummyDate,5,2);
				$result .= '-';
				$result .= substr($DummyDate,0,4);
			}
			else
			{
				$result  = substr($DummyDate,6,4);
				$result .= '-';
				$result .= substr($DummyDate,3,2);
				$result .= '-';
				$result .= substr($DummyDate,0,2);
			}
		}

		return $result;
	}

	function showTeamIcons(&$teamInfo,&$config,$project=0)
	{
		if(!isset($teamInfo->projectteamid)) return "";
		$projectteamid	= $teamInfo->projectteamid;
		$teamname		= $teamInfo->name;
		$teamid			= $teamInfo->team_id;
		$teamSlug		= (isset($teamInfo->team_slug) ? $teamInfo->team_slug : $teamid);
		$division_slug	= (isset($teamInfo->team_slug) ? $teamInfo->division_slug : $teamInfo->division_id);
		$projectSlug	= ($project > 0 ? $project : (isset($teamInfo->project_slug) ? $teamInfo->project_slug : $teamid));
		$output			= '';

		if ($config['show_team_link'])
		{
			$link =JoomleagueHelperRoute::getPlayersRoute($projectSlug,$teamSlug);
			$title=JText::_('JL_TEAMICONS_ROSTER_LINK').'&nbsp;'.$teamname;
			$picture = 'media/com_joomleague/jl_images/team_icon.png';
			$desc = self::getPictureThumb($picture, $title, 0, 0, 99);
			$output .= JHTML::link($link,$desc);
		}

		if (((!isset($team_plan)) || ($teamid!=$team_plan->id)) && ($config['show_plan_link']))
		{
			$link =JoomleagueHelperRoute::getTeamPlanRoute($projectSlug,$teamSlug,$division_slug);
			$title=JText::_('JL_TEAMICONS_TEAMPLAN_LINK').'&nbsp;'.$teamname;
			$picture = 'media/com_joomleague/jl_images/calendar_icon.gif';
			$desc = self::getPictureThumb($picture, $title, 0, 0, 99);
			$output .= JHTML::link($link,$desc);
		}

		if ($config['show_curve_link'])
		{
			$link =JoomleagueHelperRoute::getCurveRoute($projectSlug,$teamSlug,0,$division_slug);
			$title=JText::_('JL_TEAMICONS_CURVE_LINK').'&nbsp;'.$teamname;
			$picture = 'media/com_joomleague/jl_images/curve_icon.gif';
			$desc = self::getPictureThumb($picture, $title, 0, 0, 99);
			$output .= JHTML::link($link,$desc);
		}

		if ($config['show_teaminfo_link'])
		{
			$link =JoomleagueHelperRoute::getTeamInfoRoute($projectSlug,$teamSlug);
			$title=JText::_('JL_TEAMICONS_TEAMINFO_LINK').'&nbsp;'.$teamname;
			$picture = 'media/com_joomleague/jl_images/teaminfo_icon.png';
			$desc = self::getPictureThumb($picture, $title, 0, 0, 99);
			$output .= JHTML::link($link,$desc);
		}

		if ($config['show_club_link'])
		{
			$clubSlug=(isset($teamInfo->club_slug) ? $teamInfo->club_slug : $teamInfo->club_id);
			$link =JoomleagueHelperRoute::getClubInfoRoute($projectSlug,$clubSlug);
			$title=JText::_('JL_TEAMICONS_CLUBINFO_LINK').'&nbsp;'.$teamname;
			$picture = 'media/com_joomleague/jl_images/mail.gif';
			$desc = self::getPictureThumb($picture, $title, 0, 0, 99);
			$output .= JHTML::link($link,$desc);
		}

		if ($config['show_teamstats_link'])
		{
			$link =JoomleagueHelperRoute::getTeamStatsRoute($projectSlug,$teamSlug);
			$title=JText::_('JL_TEAMICONS_TEAMSTATS_LINK').'&nbsp;'.$teamname;
			$picture = 'media/com_joomleague/jl_images/teamstats_icon.png';
			$desc = self::getPictureThumb($picture, $title, 0, 0, 99);
			$output .= JHTML::link($link,$desc);
		}

		if ($config['show_clubplan_link'])
		{
			$clubSlug=(isset($teamInfo->club_slug) ? $teamInfo->club_slug : $teamInfo->club_id);
			$link =JoomleagueHelperRoute::getClubPlanRoute($projectSlug,$clubSlug);
			$title=JText::_('JL_TEAMICONS_CLUBPLAN_LINK').'&nbsp;'.$teamname;
			$picture = 'media/com_joomleague/jl_images/clubplan_icon.png';
			$desc = self::getPictureThumb($picture, $title, 0, 0, 99);
			$output .= JHTML::link($link,$desc);
		}

		return $output;
	}

	function formatTeamName($team,$containerprefix,&$config,$fav=0,$plan=0,$projectId=0)
	{
		$projectId		= ($projectId > 0 ? $projectId : $team->project_id);
		$projectteam_id	= $team->projectteamid;
		$output			= '';
		$desc			= '';
		$js_func		= 'switchMenu';
		$style_append	= 'display:none';
		$container		= 'div';

		//$joomleague		=& JTable::getInstance('Project','Table');
		//$joomleague->load($projectId);

		if ((isset($config['results_below'])) && ($config['results_below']) && ($config['show_logo_small']))
		{
			$js_func		= 'visibleMenu';
			$style_append	= 'visibility:hidden';
			$container		= 'span';
		}
		$showIcons=(
		($config['show_icons']==2) && ($fav)
		) || (
		($config['show_icons']==1) &&	(
		($config['show_club_link']) ||
		($config['show_team_link']) ||
		($config['show_curve_link']) ||
		($config['show_plan_link']) ||
		($config['show_teaminfo_link']) ||
		($config['show_teamstats_link']) ||
		($config['show_clubplan_link'])
		)
		);
		if ($showIcons)
		{
			$link		= 'javascript:void(0);';
			$onclick	= $js_func.'(\''.$containerprefix.'t'.$team->team_id.'p'.$team->project_id.'\');return false;';
			$params		= array('onclick' => $onclick);
		}

		if (($config['highlight_fav']) && ($fav == 1))
		{
			$favs = self::getProjectFavTeams($projectId);
			$desc .= '<span style="padding:2px;';
			$desc .= ($favs->fav_team_text_bold != '') ? 'font-weight:bold;' : '';
			$desc .= (trim($favs->fav_team_text_color) != '') ? 'color:'.trim($favs->fav_team_text_color).';' : '';
			$desc .= (trim($favs->fav_team_color) != '') ? 'background-color:'.trim($favs->fav_team_color).';' : '';
			$desc .= '">';
		}

		if ($plan==1)
		{
			$desc .=  '<b>';
		}

		if ($config['names']=='short_name')
		{
			$desc .=  '<acronym title="'.$team->name.'">'.$team->short_name.'</acronym>';
		}
		else
		{
			$desc .= (isset($team->$config['names'])) ? $team->$config['names'] : $team->name;
		}

		if ($plan==1)
		{
			$desc .=  '</b>';
		}

		if (($config['highlight_fav']) && ($fav==1))
		{
			$desc .=  '</span>';
		}

		if ($showIcons)
		{
			$output .= JHTML::link($link,$desc,$params);
			$output .= '<'.$container.' id="'.$containerprefix.'t'.$team->id.'p'.$team->project_id.'" style="'.$style_append.';">';
			$output .= self::showTeamIcons ($team,$config,$projectId);
			$output .= '</'.$container.'>';
		}
		else
		{
			$output=$desc;
		}

		return $output;
	}

	function showClubIcon(&$team,$type=1,$with_space=0)
	{
		if (($type==1) && (isset($team->country)))
		{
			if ($team->logo_small!='')
			{
				echo JHTML::image($team->logo_small,'');
				if ($with_space==1){
					echo ' style="padding:1px;"';
				}
			}
			else
			{
				echo '&nbsp;';
			}
		}
		elseif (($type==2) && (isset($team->country)))
		{
			echo Countries::getCountryFlag($team->country);
		}
		elseif (($type==3) && (isset($team->country)))
		{
		  echo JHTML::image($team->logo_small,'').' '.Countries::getCountryFlag($team->country);
		}
    elseif (($type==4) && (isset($team->country)))
		{
		  echo Countries::getCountryFlag($team->country).' '.JHTML::image($team->logo_small,'');
		}
		
	}

	function showColorsLegend($colors)
	{
		$favshow=JRequest::getVar('func','');
		if (($favshow!='showCurve') && ($this->project->fav_team))
		{
			$fav=array('color'=>$this->project->fav_team_color,'description'=> JText::_('JL_RANKING_FAVTEAM'));
			array_push($colors,$fav);
		}
		foreach($colors as $color)
		{
			if (trim($color['description'])!='')
			{
				echo '<td align="center" style="background-color:'.$color['color'].';"><b>'.$color['description'].'</b>&nbsp;</td>';
			}

		}
	}


	/**
	 * Removes invalid XML
	 *
	 * @access public
	 * @param string $value
	 * @return string
	 */
	public function stripInvalidXml($value)
	{
		$ret='';
		$current;
		if (is_null($value)){
			return $ret;
		}

		$length=strlen($value);
		for ($i=0; $i < $length; $i++)
		{
			$current=ord($value{$i});
			if (($current == 0x9) ||
			($current == 0xA) ||
			($current == 0xD) ||
			(($current >= 0x20) && ($current <= 0xD7FF)) ||
			(($current >= 0xE000) && ($current <= 0xFFFD)) ||
			(($current >= 0x10000) && ($current <= 0x10FFFF)))
			{
				$ret .= chr($current);
			}
			else
			{
				$ret .= ' ';
			}
		}
		return $ret;
	}

	function getVersion()
	{
		$database =& JFactory::getDBO();

		$query="SELECT CONCAT(major,'.',minor,'.',build,'.',revision) AS version
				  FROM #__joomleague_version 
				  ORDER BY date DESC LIMIT 1";
		$database->setQuery($query);
		$result=$database->loadResult();
		return $result;
	}

	/**
	 * returns formatName
	 *
	 * @param prefix
	 * @param firstName
	 * @param nickName
	 * @param lastName
	 * @param format
	 */
	function formatName($prefix, $firstName, $nickName, $lastName, $format)
	{
		$name = array();
		if ($prefix)
		{
			$name[] = $prefix;
		}
		switch ($format)
		{
			case 0: //Firstname 'Nickname' Lastname
				if ($firstName != "") {
					$name[] = $firstName;
				}
				if ($nickName != "") {
					$name[] = "'" . $nickName . "'";
				}
				if ($lastName != "") {
					$name[] = $lastName;
				}
				break;
			case 1: //Lastname, 'Nickname' Firstname
				if ($lastName != "") {
					$name[] = $lastName . ",";
				}
				if ($nickName != "") {
					$name[] = "'" . $nickName . "'";
				}
				if ($firstName != "") {
					$name[] = $firstName;
				}
				break;
			case 2: //Lastname, Firstname 'Nickname'
				if ($lastName != "") {
					$name[] = $lastName . ",";
				}
				if ($firstName != "") {
					$name[] = $firstName;
				}
				if ($nickName != "") {
					$name[] = "'" . $nickName . "'";
				}
				break;
			case 3: //Firstname Lastname
				if ($firstName != "") {
					$name[] = $firstName;
				}
				if ($lastName != "") {
					$name[] = $lastName;
				}
				break;
			case 4: //Lastname, Firstname
				if ($lastName != "") {
					$name[] = $lastName . ",";
				}
				if ($firstName != "") {
					$name[] = $firstName;
				}
				break;
			case 5: //'Nickname' - Firstname Lastname
				if ($nickName != "") {
					$name[] = "'" . $nickName . "' - ";
				}
				if ($firstName != "") {
					$name[] = $firstName;
				}
				if ($lastName != "") {
					$name[] = $lastName;
				}
				break;
			case 6: //'Nickname' - Lastname, Firstname
				if ($nickName != "") {
					$name[] = "'" . $nickName . "' - ";
				}
				if ($lastName != "") {
					$name[] = $lastName . ",";
				}
				if ($firstName != "") {
					$name[] = $firstName;
				}
				break;
			case 7: //Firstname Lastname (Nickname)
				if ($firstName != "") {
					$name[] = $firstName;
				}
				if ($lastName != "") {
					$name[] = $lastName ;
				}
				if ($nickName != "") {
					$name[] = "(" . $nickName . ")";
				}
				break;
			case 8: //F. Lastname
				if ($firstName != "") {
					$name[] = $firstName[0] . ".";
				}
				if ($lastName != "") {
					$name[] = $lastName;
				}
				break;
			case 9: //Lastname, F.
				if ($lastName != "") {
					$name[] = $lastName.",";
				}
				if ($firstName != "") {
					$name[] = $firstName[0] . ".";
				}
				break;
			case 10: //Lastname
				if ($lastName != "") {
					$name[] = $lastName;
				}
				break;
			case 11: //Firstname 'Nickname' L.
				if ($firstName != "") {
					$name[] = $firstName;
				}
				if ($nickName != "") {
					$name[] = "'" . $nickName . "'";
				}
				if ($lastName != "") {
					$name[] = $lastName[0]. ".";
				}
				break;
			case 12: //Nickname
				if ($nickName != "") {
					$name[] = $nickName;
				}
				break;
			case 13: //Firstname L.
				if ($firstName != "") {
					$name[] = $firstName;
				}
				if ($lastName != "") {
					$name[] = $lastName[0]. ".";
				}
				break;
			case 14: //Lastname Firstname
				if ($lastName != "") {
					$name[] = $lastName;
				}
				if ($firstName != "") {
					$name[] = $firstName;
				}
				break;
		}

		return implode(" ", $name);
	}

	/**
	 * Creates the print button
	 *
	 * @param string $print_link
	 * @param array $config
	 * @since 1.5.2
	 */
	function printbutton($print_link, &$config)
	{
		if ($config['show_print_button'] == 1) {
			JHTML::_('behavior.tooltip');
			$status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=800,height=600,directories=no,location=no';
			// checks template image directory for image, if non found default are loaded
			if ($config['show_icons'] == 1 ) {
				$image = JHTML::_('image.site', 'printButton.png', 'images/M_images/', NULL, NULL, JText::_( 'Print' ));
			} else {
				$image = JText::_( 'Print' );
			}
			if (JRequest::getInt('pop')) {
				//button in popup
				$output = '<a href="javascript: void(0)" onclick="window.print();return false;">'.$image.'</a>';
			} else {
				//button in view
				$overlib = JText::_( 'JL_GLOBAL_PRINT_TIP' );
				$text = JText::_( 'JL_GLOBAL_PRINT' );
				$sef = JFactory::getConfig()->getValue('config.sef', false);
				$print_urlparams = ($sef ? "?tmpl=component&print=1" : "&tmpl=component&print=1");

				if(is_null($print_link)) {
				    $output	= '<a href="javascript: void(0)" class="editlinktip hasTip" onclick="window.open(window.location.href + \''.$print_urlparams.'\',\'win2\',\''.$status.'\'); return false;" rel="nofollow" title="'.$text.'::'.$overlib.'">'.$image.'</a>';
				} else {
				    $output	= '<a href="'. JRoute::_($print_link) .'" class="editlinktip hasTip" onclick="window.open(window.location.href + \''.$print_urlparams.'\',\'win2\',\''.$status.'\'); return false;" rel="nofollow" title="'.$text.'::'.$overlib.'">'.$image.'</a>';
				}
			}
			return $output;
		}
		return;
	}

	/**
	 * return true if mootools upgrade is enabled
	 *
	 * @return boolean
	 */
	function isMootools12()
	{
		$version = new JVersion();
		if ($version->RELEASE == '1.5' && $version->DEV_LEVEL >= 19 && JPluginHelper::isEnabled( 'system', 'mtupgrade' ) ) {
			return true;
		}
		else {
			return false;
		}
	}
		
	/**
	* return project rounds as array of objects(roundid as value, name as text)
	*
	* @param string $ordering
	* @return array
	*/
	function getRoundsOptions($project_id, $ordering='ASC')
	{
		$db = &JFactory::getDBO();
		$query = ' SELECT id as value '
		       . '      , CASE LENGTH(name) when 0 then CONCAT('.$db->Quote(JText::_('JL_GLOBAL_MATCHDAY_NAME')). ', " ", id)	else name END as text '
		       . '      , id, name, round_date_first, round_date_last, roundcode '
		       . ' FROM #__joomleague_round '
		       . ' WHERE project_id= ' .$project_id
		       . ' ORDER BY roundcode '.$ordering;
	
		$db->setQuery($query);
		return $db->loadObjectList();
	}
	
	/**
	 * returns -1/0/1 if the team lost/drew/won in specified game, or false if not played/cancelled
	 *  
	 * @param object $game date from match table
	 * @param int $ptid project team id
	 * @return false|int
	 */
	function getTeamMatchResult($game, $ptid)
	{
		if (!isset($game->team1_result)) {
			return false;
		}
		if ($game->cancel) {
			return false;
		}
		
		if (!$game->alt_decision)
		{
			$result1 = $game->team1_result;
			$result2 = $game->team2_result;
		}
		else
		{
			$result1 = $game->team1_result_decision;
			$result2 = $game->team2_result_decision;
		}
		if ($result1 == $result2) {
			return 0;
		}
		
		if ($ptid == $game->projectteam1_id) {
			return ($result1 > $result2) ? 1 : -1;
		}
		else {
			return ($result1 > $result2) ? -1 : 1;
		}
	}
}
?>