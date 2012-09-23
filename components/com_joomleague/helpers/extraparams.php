<?php
/**
* @version		$Id$
* @package		JoomLeague 1.5
* @copyright	Copyright (C) JoomLeague. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.html.parameter');

/**
 * override JParameters to output the params values in frontend
 * @author julien
 *
 */
class JLGExtraParams extends JParameter {
	
	function getElements($group = '_default')
	{
		if (!isset($this->_xml[$group])) {
			return false;
		}
		$results = array();
		foreach ($this->_xml[$group]->children() as $param)  {
			$results[] = $this->getParamObject($param);
		}
		return $results;
	}	

	/**
	 * Render a parameter type
	 *
	 * @param	object	A param tag node
	 * @param	string	The control name
	 * @return	array	Any array of the label, the form element and the tooltip
	 * @since	1.5
	 */
	function getParamObject(&$node, $group = '_default')
	{
		$obj = new JLGExtraParamElement();
		$obj->backendonly = $node->attributes('backendonly');
		$obj->name        = $node->attributes('name');
		$obj->type        = $node->attributes('type');
		$obj->label       = JText::_($node->attributes('label'));
		$obj->description = JText::_($node->attributes('description'));
		$cssclass = $node->attributes('cssclass');
		$cssclass = !empty($cssclass) ? 'class="'. $node->attributes('cssclass') .'"' : "";
		$value = $this->get($node->attributes('name'), $node->attributes('default'), $group);
		if(!empty($value)) {
			if($obj->type == 'link') {
				$obj->value = '<a '.$cssclass.'
								href="'.$this->get($node->attributes('name'), 
												$node->attributes('default'), $group).
									'"  target="_new">'.$this->get($node->attributes('name'), 
												$node->attributes('default'), $group).'</a>';
			} else { 
				$obj->value = $this->get($node->attributes('name'), $node->attributes('default'), $group);
			} 
		}
		return $obj;
	}
}

class JLGExtraParamElement {
	var $name;
	var $label;
	var $description;
	var $type;
	var $value;
	var $backendonly;
	var $cssclass;
}
