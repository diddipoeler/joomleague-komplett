<?php

/**
* @copyright	Copyright (C) 2005-2012 JoomLeague.net. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

class JoomleagueHTML
{

	function printColumnHeadingSort( $columnTitle, $paramName, $config = null, $default="DESC" )
	{
		$output = "";
		$img='';
		if ( $config['column_sorting'] || $config == null)
		{
			$params = array(
				"option" => "com_joomleague",
				"view"   => JRequest::getVar("view", "ranking"),
				"p" => JRequest::getInt( "p", 0 ),
				"r" => JRequest::getInt( "r", 0 ),
				"type" => JRequest::getVar( "type", "" ) );

			if ( JRequest::getVar( 'order', '' ) == $paramName )
			{
				$params["order"] = $paramName;
				$params["dir"] = ( JRequest::getVar( 'dir', '') == 'ASC' ) ? 'DESC' : 'ASC';
				$imgname = 'sort'.(JRequest::getVar( 'dir', '') == 'ASC' ? "02" :"01" ).'.gif';
				$img = JHTML::image(
									'media/com_joomleague/jl_images/' . $imgname,
				$params["dir"] );
			}
			else
			{
				$params["order"] = $paramName;
				$params["dir"] = $default;
			}
			$query = JURI::buildQuery( $params );
			echo JHTML::link(
			JRoute::_( "index.php?".$query ),
			JText::_($columnTitle),
			array( "class" => "jl_rankingheader" ) ).$img;
		}
		else
		{
			echo JText::_($columnTitle);
		}
	}

	function nextLastPages( $url, $text, $maxentries, $limitstart = 0, $limit = 10 )
	{
		$latestlimitstart = 0;
		if ( intval( $limitstart - $limit ) > 0 )
		{
			$latestlimitstart = intval( $limitstart - $limit );
		}
		$nextlimitstart = 0;
		if ( ( $limitstart + $limit ) < $maxentries )
		{
			$nextlimitstart = $limitstart + $limit;
		}
		$lastlimitstart = ( $maxentries - ( $maxentries % $limit ) );
		if ( ( $maxentries % $limit ) == 0 )
		{
			$lastlimitstart = ( $maxentries - ( $maxentries % $limit ) - $limit );
		}

		echo '<center>';
		echo '<table style="width: 50%; align: center;" cellspacing="0" cellpadding="0" border="0">';
		echo '<tr>';
		echo '<td style="width: 10%; text-align: left;" nowrap="nowrap">';
		if ( $limitstart > 0 )
		{
			$query = JURI::buildQuery(
			array(
				"limit" => $limit,
				"limitstart" => 0 ) );
			echo JHTML::link( $url.$query, '&lt;&lt;&lt;' );
			echo '&nbsp;&nbsp;&nbsp';
			$query = JURI::buildQuery(
			array(
				"limit" => $limit,
				"limitstart" => $latestlimitstart ) );
			echo JHTML::link( $url.$query, '&lt;&lt;' );
			echo '&nbsp;&nbsp;&nbsp;';
		}
		echo '</td>';
		echo '<td style="text-align: center;" nowrap="nowrap">';
		$players_to = $maxentries;
		if ( ( $limitstart + $limit ) < $maxentries )
		{
			$players_to = ( $limitstart + $limit );
		}
		echo sprintf( $text, $maxentries, ($limitstart+1).' - '.$players_to );
		echo '</td>';
		echo '<td style="width: 10%; text-align: right;" nowrap="nowrap">';
		if ( $nextlimitstart > 0 )
		{
			echo '&nbsp;&nbsp;&nbsp;';
			$query = JURI::buildQuery(
			array(
				"limit" => $limit,
				"limitstart" => $nextlimitstart ) );
			echo JHTML::link( $url.$query, '&gt;&gt;' );
			echo '&nbsp;&nbsp;&nbsp';
			$query = JURI::buildQuery(
			array(
				"limit" => $limit,
				"limitstart" => $lastlimitstart ) );
			echo JHTML::link( $url.$query, '&gt;&gt;&gt;' );
		}
		echo '</td>';
		echo '</tr>';
		echo '</table>';
		echo '</center>';
	}

}
?>