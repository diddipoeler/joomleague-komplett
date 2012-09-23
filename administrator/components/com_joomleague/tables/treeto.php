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
* Treeto class
*
* @package		Joomleague
* @since 0.1
*/
class TableTreeto extends JLTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;
	var $project_id;
	var $division_id;

	var $tree_i;
	var $name;
	var $global_bestof;
	var $global_matchday;
	var $global_known;
	var $global_fake;
	var $leafed;
	var $mirror;
	var $hide;
	var $trophypic;
	var $extended;

	var $published;
	var $checked_out;
	var $checked_out_time;


	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	function __construct(& $db) {
		parent::__construct('#__joomleague_treeto', 'id', $db);
	}
}
?>
