<?php
/**
 * @copyright	Copyright (C) 2006-2012 JoomLeague.net. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

// Include library dependencies
jimport( 'joomla.filter.input' );

/**
 * Position Statistic Table class
 *
 * @package	JoomLeague
 * @since	1.5
 */
class TablePositionStatistic extends JLTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;

	/**
	 * default position
	 * @var int
	 */
	var $position_id;

	/**
	 * default statistic
	 * @var int
	 */
	var $statistic_id;

	/**
	 * saves ordering of content of table in frontend
	 * @var int
	 */
	var $ordering;

	/**
	 * saves status of table and if it is checked out or not by a user
	 * @var int
	 */
	var $checked_out;
	/**
	 * saves time of checkout by a user
	 * @var int
	 */
	var $checked_out_time;

	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	function __construct( & $db )
	{
		parent::__construct( '#__joomleague_position_statistic', 'id', $db );
	}

// Just taken from script file of table#__joomleague_statistic. Don't know if that is true. SORRY...
// Kurt ;)

	/**
	 * Overloaded check method to ensure data integrity
	 *
	 * @access public
	 * @return boolean True on success
	 * @since 1.0
	 */
	function check()
	{
		if ( ! ( $this->statistic_id && $this->projectteam_id && $this->match_id ) )
		{
			$this->setError( JText::_( 'CHECK FAILED' ) );
			return false;
		}
		return true;
	}

}
?>