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
* Project Table class
*
* @package	JoomLeague
* @since	0.1
*/
class TableProjectReferee extends JTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;

	var $project_id;

	var $person_id;

	/**
	 * default position
	 * @var int
	 */
	var $project_position_id;

	/**
	 * complementary notes regarding this referee in project
	 * @var string
	 */
	var $notes;

	/**
	 * stores project depending picture
	 *
	 * @var string
	 */
	var $picture = null;

	/**
	 * stores extended info
	 *
	 * @var string
	 */
	var $extended = null;

	var $published=1;
	var $ordering;
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
		parent::__construct( '#__joomleague_project_referee', 'id', $db );
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
		return true;
	}
}
?>