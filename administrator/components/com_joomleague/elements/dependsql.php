<?php 
/**
* @copyright	Copyright (C) 2007-2012 JoomLeague.net. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

defined( '_JEXEC' ) or die( 'Restricted access' ); // Check to ensure this file is included in Joomla!

JHTML::_( 'behavior.mootools' );

/**
 * Renders a Dynamic SQL element
 *
 * in the xml element, the following elements must be defined:
 * - depends: list of elements name this element depends on, separated by comma (e.g: "p, tid")
 * - task: the task used to return the query, using defined depends element names as parameters for query (=> 'index.php?option=com_joomleague&controller=ajax&task=<task>&p=1&tid=34')
 * @package Joomleague
 * @subpackageParameter
 * @since1.5
 */
class JElementDependSQL extends JElement
{
	/**
	 * Element name
	 *
	 * @accessprotected
	 * @varstring
	 */
	var $_name = 'dependsql';

	function fetchElement($name, $value, &$node, $control_name)
	{
		$db =& JFactory::getDBO();
		// Base name of the HTML control.
		$ctrl	= ''.$control_name.'['.$name.']';
		
		// Construct the various argument calls that are supported.
		$attribs	= ' ';
		if ($v = $node->attributes( 'size' ))
		{
			$attribs	.= 'size="'.$v.'"';
		}

		$depends = $node->attributes('depends');
		if ($depends)
		{
			$attribs	.= ' depends="'.$depends.'"';
			$doc = &JFactory::getDocument();
			$doc->addScript(JURI::base() . 'components/com_joomleague/assets/js/depend.js' );
		}

		if ($v = $node->attributes( 'class' ))
		{
			$attribs	.= ' class="'.$v;
		}
		else
		{
			$attribs	.= ' class="inputbox';
		}
		// Optionally add "depend" to the class attribute
		if ($depends)
		{
			$attribs	.= ' depend"';
		}
		else
		{
			$attribs	.= '"';
		}

		$multiple = $node->attributes('multiple');
		if ($multiple)
		{
			$attribs	.= ' multiple="multiple"';
			$ctrl		.= '[]';
			if(empty($value) || count($value) <= 1) {
				$attribs	.= ' current="'.$value.'"';
			} else {
				$attribs	.= ' current="'.implode('|', $value).'"';
			}
		}
		else
		{
			$attribs	.= ' current="'.$value.'"';
		}

		$key = ($node->attributes('key_field') ? $node->attributes('key_field') : 'value');
		$val = ($node->attributes('value_field') ? $node->attributes('value_field') : $name);

		$required = (int) $node->attributes('required');
		$attribs .= ' isrequired="'.$required.'"';
		if ($required)
		{
			$options = array();
		}
		else
		{
			$options = array(JHTML::_('select.option', '', JText::_('Select'), $key, $val));
		}

		$query = $node->attributes('query');
		if ($query)
		{
			$db->setQuery($query);
			$options = array_merge($options, $db->loadObjectList());
		}

		$task = $node->attributes('task');
		$attribs .= ' task="'.$task.'"';
		// Render the HTML SELECT list.
		return JHTML::_('select.genericlist', $options, $ctrl, $attribs, $key, $val,
						$value, $control_name.$name );
	}
}
