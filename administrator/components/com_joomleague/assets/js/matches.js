/**
 * this function copies the value of the first found form field to all other fields with the same name
 * @param string from which field 
 */
function copyValue(from) {
	var fields = document.adminForm.elements;
	var default_time = '';
	for ( var i = 0; i < fields.length; i++) {
		var ele = fields[i];
		if (ele.name.indexOf(from) != -1) {
			if (default_time == '') {
				default_time = ele.value;
			} else {
				ele.value = default_time;
			}
			ele.onchange();
		}
	}
}

function handleRosterIconClick(type, ele, alert1, alert2) {
	if(type == '3') {
		if(!askPrefillRosterByLastMatch(alert1)) {
			if(askPrefillRosterByProjectTeamPlayer(alert2)) {
				ele.href = ele.href.substr(0, ele.href.indexOf('prefill')) + 'prefill=2';
				return true;
			} 
		} else {
			ele.href = ele.href.substr(0, ele.href.indexOf('prefill')) + 'prefill=1';
			return true;
		}
	}
	ele.href = ele.href.substr(0, ele.href.indexOf('prefill')) + 'prefill=0';
	return true;
}

function askPrefillRosterByLastMatch(alert1) {
	return confirm(alert1);
}

function askPrefillRosterByProjectTeamPlayer(alert2) {
	return confirm(alert2);
}