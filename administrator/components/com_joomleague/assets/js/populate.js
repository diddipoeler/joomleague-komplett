/**
* @copyright	Copyright (C) 2005-2012 JoomLeague.net. All rights reserved.
* @license	GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

/**
 * javascript for populate function
 * 
 * 
 */

window.addEvent('domready', function(){
	$('buttonup').addEvent('click', function(){
		moveOptionUp('teamsorder');
	});
	$('buttondown').addEvent('click', function(){
		moveOptionDown('teamsorder');
	});
});

function submitbutton(pressbutton) {
	if (pressbutton == 'startpopulate') {
		$('teamsorder').getElements('option').each(function(el) {
			el.setProperty('selected', 'selected');
		});
		submitform(pressbutton);
		return;
	}
	submitform(pressbutton);
}


function moveOptionUp(selectId)
{
	var selectList = document.getElementById(selectId);
	var selectOptions = selectList.getElementsByTagName('option');
	for (var i = 1; i < selectOptions.length; i++) {
		var opt = selectOptions[i];
		if (opt.selected) {
			selectList.removeChild(opt);
			selectList.insertBefore(opt, selectOptions[i - 1]);
			return true;
		}
	}
}

function moveOptionDown(selectId)
{
	var selectList = document.getElementById(selectId);
	var selectOptions = selectList.getElementsByTagName('option');
	for (var i = 0; i < selectOptions.length-1; i++) {
		var opt = selectOptions[i];
		if (opt.selected) {
			var next = selectOptions[i + 1];
			selectList.removeChild(next);
			selectList.insertBefore(next, selectOptions[i]);
			return true;
		}
	}
}