<?php
/**
* @version		$Id: text.php 10707 2008-08-21 09:52:47Z eddieajau $
* @package		Joomla.Framework
* @subpackage	Parameter
* @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

/**
 * Renders a text element
 *
 * @package 	Joomla.Framework
 * @subpackage		Parameter
 * @since		1.5
 */

class JElementColorpicker extends JElement
{
	/**
	* Element name
	*
	* @access	protected
	* @var		string
	*/
	var	$_name = 'Colorpicker';

	function fetchTooltip($label, $description, &$node, $control_name='', $name='')
	{
		$output = '<span class="palette"><label class="to-label tooltip" title="'.JText::_( $description ).'" id="'.$control_name.$name.'-lbl" for="'.$control_name.$name.'">'.JText::_( $label ).'</label>';		
		return $output;
	}

	function fetchElement($name, $value, &$node, $control_name)
	{
		$size = ( $node->attributes('size') ? 'size="'.$node->attributes('size').'"' : '' );
		//$class = ( $node->attributes('class') ? 'class="'.$node->attributes('class').'"' : '' );
        $value = htmlspecialchars(html_entity_decode($value, ENT_QUOTES), ENT_QUOTES);

		return '<span class="picker-wrap"><input type="text" name="'.$control_name.'['.$name.']" id="'.$control_name.$name.'" value="'.$value.'" class="form-colorpicker text-input" '.$size.' /><span class="color-preview" style="background-color:'.$value.';" id="preview_'.$name.'">&nbsp;</span></span><a href="#" class="picker" id="picker_'.$name.'"><img src="' . JURI::root() . 'templates/witblits/admin/images/swatch.png" /></a></span>';
	}
}

?>