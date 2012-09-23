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
require_once (JPATH_COMPONENT.DS.'models'.DS.'item.php');

/**
 * Joomleague Component Template Model
 *
 * @author	Marco Vaninetti <martizva@tiscali.it>
 * @package	JoomLeague
 * @since	0.1
 */
class JoomleagueModelTemplate extends JoomleagueModelItem
{
	/**
	 * Method to remove templates of only one project
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	0.1
	 */
	function deleteOne($project_id)
	{
		if ($project_id > 0)
		{
			$query='DELETE FROM #__joomleague_template_config WHERE project_id='.(int) $project_id;
			$this->_db->setQuery($query);
			if (!$this->_db->query())
			{
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}
		return true;
	}

	/**
	 * Method to remove a template
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	0.1
	 */
	function delete($cid=array())
	{
		$result=false;
		if (count($cid))
		{
			JArrayHelper::toInteger($cid);
			$cids=implode(',',$cid);
			$query="DELETE FROM #__joomleague_template_config WHERE id IN ($cids)";
			$this->_db->setQuery($query);
			if (!$this->_db->query())
			{
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}
		return true;
	}

	/**
	 * Method to load content template data
	 *
	 * @access	private
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function _loadData()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_data))
		{
			$query='SELECT * FROM #__joomleague_template_config WHERE id='.(int) $this->_id;
			$this->_db->setQuery($query);
			$this->_data=$this->_db->loadObject();
			return (boolean) $this->_data;
		}
		return true;
	}

	/**
	 * Method to initialise the template data
	 *
	 * @access	private
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function _initData()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_data))
		{
			$template=new stdClass();
			$template->id					= 0;
			$template->title				= null;
			$template->func					= null;
			$template->params				= null;
			$template->project_id			= null;
			$template->checked_out			= 0;
			$template->checked_out_time		= 0;
			$template->modified				= null;
			$template->modified_by			= null;
			
			$this->_data					= $template;
			return (boolean) $this->_data;
		}
		return true;
	}

	/**
	 * Method to store the item
	 *
	 * @access	public
	 * @return	boolean True on success
	 * @since 1.5
	 */
	function store($data)
	{
		$row =& $this->getTable();

		// Bind the form fields to the items table
		if (!$row->bind($data))
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		// Create the timestamp for the date
		$row->checked_out_time=gmdate('Y-m-d H:i:s');
/*
		// if new item,order last,but only if an ordering exist
		if (!$row->id && $row->ordering != NULL)
		{
			$row->ordering=$row->getNextOrder();
		}
*/
		// Make sure the item is valid
		if (!$row->check())
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Store the item to the database
		if (!$row->store())
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		return true;
	}

	/**
	 * Method to copy a template in current project
	 *
	 * @access	public
	 * @return	boolean True on success
	 * @since 1.5
	 */
	function import($templateid,$projectid)
	{
		$row =& $this->getTable();

		// load record to copy
		if (!$row->load($templateid))
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		//copy to new element
		$row->id=null;
		$row->project_id=(int) $projectid;

		// Make sure the item is valid
		if (!$row->check())
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Store the item to the database
		if (!$row->store())
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		return true;
	}

	function getAllTemplatesList($project_id,$master_id)
	{
		$query='SELECT template FROM #__joomleague_template_config WHERE project_id='.$project_id;
		$this->_db->setQuery($query);
		$current=$this->_db->loadResultArray();
		$query="SELECT id as value, title as text
				FROM #__joomleague_template_config
				WHERE project_id=$master_id AND template NOT IN ('".implode("','",$current)."')
				ORDER BY title";
		$this->_db->setQuery($query);
		$result1=$this->_db->loadObjectList();
		$query="SELECT id as value, title as text
				FROM #__joomleague_template_config
				WHERE project_id=$project_id
				ORDER BY title";
		$this->_db->setQuery($query);
		$result2=$this->_db->loadObjectList();
		return array_merge($result2,$result1);
	}

}
?>