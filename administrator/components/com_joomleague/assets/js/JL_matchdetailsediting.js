/**
* @copyright	Copyright (C) 2005-2012 JoomLeague.net. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/
function FormSwitch(matchid, action) {
	if (action == 0) var what=true;
	if (action == 1) var what=false;
	var field1='team1_result_decision'+matchid;
	var field2='team2_result_decision'+matchid;
	var field3='decision_info'+matchid;
		document.getElementById(field1).disabled=what;
		document.getElementById(field2).disabled=what;
		document.getElementById(field3).disabled=what;
	}

function showMCE(id,linkObj) {

if(  linkObj.innerHTML == "show editor") {

		linkObj.innerHTML = "hide editor";
		tinyMCE.execCommand('mceAddControl', false, id);
	}
	else {
		linkObj.innerHTML = "show editor";
		tinyMCE.execCommand('mceRemoveControl', false, id);
	}

}