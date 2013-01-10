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
* Project Table class
*
* @package		Joomleague
* @since 0.1
*/
class TableCountries extends JLTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;
	var $iso3 = null;
  var $iso2 = null;
  var $name = null;
  var $flag = null;
  var $fifa = null;
  var $ioc = null;
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
		parent::__construct( '#__joomleague_countries', 'id', $db );
	}
  
}
?>  	