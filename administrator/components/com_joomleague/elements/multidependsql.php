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
class JElementMultiDependSQL extends JElement
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
		}
		$doc = &JFactory::getDocument();
		$doc->addScript(JURI::base() . 'components/com_joomleague/assets/js/depend.js' );

		if ($v = $node->attributes( 'class' ))
		{
			$attribs	.= ' class="mdepend '.$v;
		}
		else
		{
			$attribs	.= ' class="mdepend inputbox';
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
		$attribs	.= ' current="'.$value.'"';

		$attribs	.= ' multiple="multiple"';
		$selected = explode("|", $value);

		$key = ($node->attributes('key_field') ? $node->attributes('key_field') : 'value');
		$val = ($node->attributes('value_field') ? $node->attributes('value_field') : $name);

		// TODO: for the moment always require a selection, because when it is set to 0, the multiselection
		// will also select the empty line, next to the real selected ones. This will lead to a longer link
		// (all selected ids (e.g. events or stats) will be included in the link address), so this should
		// be fixed later, so that when nothing is selected, only id=0 will be in the link address.
		//$required = (int) $node->attributes('required');
		$required = 1;
		$attribs	.= ' isrequired="'.$required.'"';
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
		$text = JHTML::_('select.genericlist', $options, 'l'.$name, $attribs, $key, $val,
						$selected );
		$text .= '<input type="hidden" name="'.$ctrl.'" id="'.$control_name.$name.'" value="'.$value.'"/>';
		return $text;
	}
}
