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
* Match player Table class
*
* @package		Joomleague
* @since 1.5
*/
class TableMatchplayer extends JTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id= NULL;

	/**
	 * match id
	 *
	 * @var int
	 */
	var $match_id;

	/**
	 * player id
	 *
	 * @var int
	 */
	var $teamplayer_id;

	/**
	 * player position
	 * @var int
	 */
	var $project_position_id;	
	
	/**
	 * player was not a starter
	 * @var int / bool
	 */
	var $came_in;
	/**
	 * teamplayer_id that was replaced
	 * @var int
	 */
	var $in_for;
	/**
	 * player was replaced
	 * @var int / bool
	 */
	var $out;
	/**
	 * time of the replacement
	 * @var int
	 */
	var $in_out_time = null;

	var $ordering;
	var $checked_out;
	var $checked_out_time;

	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	function __construct( & $db )
	{
		parent::__construct( '#__joomleague_match_player', 'id', $db );
	}

	/**
	 * Overloaded check method to ensure data integrity
	 *
	 * @access public
	 * @return boolean True on success
	 * @since 1.0
	 */
	function check()
	{
		if ( ! ( $this->match_id && $this->teamplayer_id ) )
		{
			$this->setError( JText::_( 'CHECK FAILED' ) );
			return false;
		}
		return true;
	}
}
?>