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
defined('_JEXEC') or die('Restricted access');

// Include library dependencies
jimport('joomla.filter.input');

/**
 * Joomleague JLTable Table class
 *
 * @package	Joomleague
 * @since 1.50a
 */
class JLTable extends JTable {
	
	var $modified;
	var $modified_by;

	function bind($array, $ignore = '') {
		if (key_exists('extended', $array) && is_array($array['extended'])) {
			$registry = new JRegistry();
			$registry->loadArray($array['extended']);
			$array['extended'] = $registry->toString();
		}
		return parent :: bind($array, $ignore);
	}

	/**
	 * try to insert first, update if fails
	 *
	 * Can be overloaded/supplemented by the child class
	 *
	 * @access public
	 * @param boolean If false, null object variables are not updated
	 * @return null|string null if successful otherwise returns and error message
	 */
	function insertIgnore($updateNulls = false) {
		$k = $this->_tbl_key;

		$ret = $this->_insertIgnoreObject($this->_tbl, $this, $this->_tbl_key);
		if (!$ret) {
			$this->setError(get_class($this) . '::store failed - ' . $this->_db->getErrorMsg());
			return false;
		}
		return true;
	}

	/**
	 * Inserts a row into a table based on an objects properties, ignore if already exists
	 *
	 * @access  public
	 * @param string  The name of the table
	 * @param object  An object whose properties match table fields
	 * @param string  The name of the primary key. If provided the object property is updated.
	 * @return int number of affected row
	 */
	function _insertIgnoreObject($table, & $object, $keyName = NULL) {
		$fmtsql = 'INSERT IGNORE INTO ' . $this->_db->nameQuote($table) . ' ( %s ) VALUES ( %s ) ';
		$fields = array ();
		foreach (get_object_vars($object) as $k => $v) {
			if (is_array($v) or is_object($v) or $v === NULL) {
				continue;
			}
			if ($k[0] == '_') { // internal field
				continue;
			}
			$fields[] = $this->_db->nameQuote($k);
			$values[] = $this->_db->isQuoted($k) ? $this->_db->Quote($v) : (int) $v;
		}
		$this->_db->setQuery(sprintf($fmtsql, implode(",", $fields), implode(",", $values)));
		if (!$this->_db->query()) {
			return false;
		}
		$id = $this->_db->insertid();
		if ($keyName && $id) {
			$object-> $keyName = $id;
		}
		return $this->_db->getAffectedRows();
	}

}
?>