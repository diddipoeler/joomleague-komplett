<?php
/**
 * @author Wolfgang Pinitsch <andone@aon.at>
 * @copyright	Copyright (C) 2007-2012 JoomLeague.net. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

defined('_JEXEC') or die('Restricted access');

require_once (JPATH_COMPONENT.DS.'helpers'.DS.'imageselect.php');

/**
 * 
 * creates a selector to upload, select, reset, clear an image path
 * @author And_One
 * @see administrator/components/com_joomleague/helpers/imageselect.php
 *
 */
class JElementImageSelect extends JElement
{
	var	$_name = 'imageselect';

	function fetchElement($name, $value, &$node, $control_name) {
		$default = $value;
		$arrPathes = explode('/', $default);
		$filename = array_pop($arrPathes);
		$targetfolder = array_pop($arrPathes);
		$output  = ImageSelect::getSelector($name, $name.'_preview', $targetfolder, $value, $default, $control_name.$name);
		$output .= '<img class="imagepreview" src="'.JURI::root(true).'/media/com_joomleague/jl_images/spinner.gif" '; 
		$output .= ' name="'.$name.'_preview" id="'.$name.'_preview" border="3" alt="Preview" title="Preview" />';
		$output .= '<input type="hidden" id="'.$control_name.$name.'" name="'.$control_name.'['.$name.']" value="'.$value.'" />';
		return $output;
	}
}
