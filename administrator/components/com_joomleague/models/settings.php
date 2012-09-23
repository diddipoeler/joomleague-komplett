<?php
/**
 * @copyright	Copyright (C) 2006-2012 JoomLeague.net. All rights reserved.
 * @license		GNU/GPL,see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License,and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

/**
 * Joomleague Component Club Model
 *
 * @package	JoomLeague
 * @since	1.5.4
 */
class JoomleagueModelSettings extends JModel
{
	/**
	 * Method to update a placeholder string
	 *
	 * @author  And_One <andone@mfga.at>
	 * @access	public
	 * @return	boolean	True on success
	 * @since	1.5.4
	 */
	function updatePlaceholder($table, $field, $oldPlaceholder, $newPlaceholder)
	{
		$result=false;
		$query='UPDATE '.$table.'
				SET   '.$field.' = '.$this->_db->Quote($newPlaceholder).' 
				WHERE '.$field.' = ' . $this->_db->Quote($oldPlaceholder);
		$this->_db->setQuery($query);
		if ($this->_db->loadResult())
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		return true;
	}

}
?>