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
jimport('joomla.filter.input');

/**
* projectteam Table class
*
* @package		Joomleague
* @since 0.1
*/
class TableProjectteam extends JLTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;

	var $project_id;

	var $team_id;

	var $division_id;

	var $start_points;

	var $points_finally;
	var $neg_points_finally;
	var $matches_finally;
	var $won_finally;
	var $draws_finally;
	var $lost_finally;
	var $homegoals_finally;
	var $guestgoals_finally;
	var $diffgoals_finally;

	var $is_in_score;
	var $use_finally;
	var $admin;
	var $info;
	var $picture;
	var $notes;
	var $standard_playground;
	var $reason;
	/**
	 * stores extended info
	 *
	 * @var string
	 */
	var $extended;

	var $checked_out;
	var $checked_out_time;

	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	function __construct(& $db)
	{
		parent::__construct( '#__joomleague_project_team', 'id', $db );
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
		//should check unicity of team / project
		return true;
	}


	/**
	 * Default delete method
	 **
	 * @access public
	 * @return true if successful otherwise returns and error message
	 */
	function delete( $oid=null )
	{
		//TODO: check that there are no associated players / matches / events / trainingdata

		$k = $this->_tbl_key;
		if ($oid) {
			$this->$k = intval( $oid );
		}

		$query = 'DELETE FROM '.$this->_db->nameQuote( $this->_tbl ).
				' WHERE '.$this->_tbl_key.' = '. $this->_db->Quote($this->$k);
		$this->_db->setQuery( $query );

		if ($this->_db->query())
		{
			return true;
		}
		else
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
	}

}
?>