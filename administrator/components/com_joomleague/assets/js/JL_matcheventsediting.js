function selectitems() {
	var f = document.startingSquadsForm;
	var count = f.elements['positioncount'].value;

	for (var key=1; key<=count;key++){
				var mylist = document.getElementById('sqad'+key)
				for(var i=0; i<mylist.length; i++) {
					mylist[i].selected = true;
			}
	}
}
function jl_load_new_match_events (sender, targetcontainer) {
	var from = sender;
	var to = document.getElementById(targetcontainer);
	if (checkforchanges()) {
	if (from.selectedIndex!=0) {

		if (document.getElementById('changes_check')) document.getElementById('changes_check').value=0;
		to.innerHTML = "";


		jl_ajaxLoad(from.value, targetcontainer);
	}
	else {
		if (document.getElementById('changes_check')) document.getElementById('changes_check').value=0;
		to.innerHTML = "";
	}
	}
	else {return false;}
}
function checkforchanges() {
	if (document.getElementById('changes_check') && document.getElementById('changes_check').value > 0) {
	if ( confirm('You made roster changes and did not save... ARE YOU REALLY SURE?') ) {
		document.getElementById('changes_check').value=0;
		return true;
	}
	else return false;
	}
	else {
	if (document.getElementById('changes_check')) document.getElementById('changes_check').value=0;
	return true;
	}
}
function move(fbox, tbox) {
		 var arrFbox = new Array();
		 var arrTbox = new Array();
		 var arrLookup = new Array();
		 var i;
		 for(i=0; i<tbox.options.length; i++) {
			arrLookup[tbox.options[i].text] = tbox.options[i].value;
			arrTbox[i] = tbox.options[i].text;
		 }
		 var fLength = 0;
		 var tLength = arrTbox.length
		 for(i=0; i<fbox.options.length; i++) {
			arrLookup[fbox.options[i].text] = fbox.options[i].value;
			if(fbox.options[i].selected && fbox.options[i].value != "") {
				 arrTbox[tLength] = fbox.options[i].text;
				 tLength++;
			} else {
				 arrFbox[fLength] = fbox.options[i].text;
				 fLength++;
			}
		 }
		 fbox.length = 0;
		 tbox.length = 0;
		 var c;
		 for(c=0; c<arrFbox.length; c++) {
			var no = new Option();
			no.value = arrLookup[arrFbox[c]];
			no.text = arrFbox[c];
			fbox[c] = no;
		 }
		 for(c=0; c<arrTbox.length; c++) {
	 	var no = new Option();
	 	no.value = arrLookup[arrTbox[c]];
	 	no.text = arrTbox[c];
	 	tbox[c] = no;
		 }
	}
	function selectAll(box) {

	for(var i=0; i<box.options.length; i++) {
		box.options[i].selected = true;
	}
	}
	jl_ajaxPost = function(frmName, el)	{

				var log = document.getElementById('log_res').addClass('ajax-loading');
		document.getElementById(frmName).send({update: document.getElementById(el), onComplete: function()	{
			log.removeClass('ajax-loading');

			if (document.getElementById('guestteam')) document.getElementById('guestteam').disabled = false;
			document.getElementById('guestteam2').disabled = false;

			if (document.getElementById('hometeam'))	document.getElementById('hometeam').disabled = false;
			document.getElementById('hometeam2').disabled = false;

			document.getElementById('home_team_id').disabled=false;
			document.getElementById('guest_team_id').disabled=false;

			document.getElementById('showhometeam2').style.display='none';
			document.getElementById('showguestteam2').style.display='none';

			 if (document.getElementById(frmName)) document.getElementById(frmName).reset();
			}
			}
		);

		return false;

	}

	function jl_PostForm( parameters, container )
	{
	var httpRequest;

	if (window.XMLHttpRequest) { // Mozilla, Safari, ...
		httpRequest = new XMLHttpRequest();
		if (httpRequest.overrideMimeType) {
			httpRequest.overrideMimeType('text/xml');
			// See note below about this line
		}
	}
	else if (window.ActiveXObject) { // IE
		try {
			httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
			}
			catch (e) {
						 try {
							httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
							 }
						 catch (e) {}
						}
									 }

	if (!httpRequest) {
		alert('Giving up :( Cannot create an XMLHTTP instance');
		return false;
	}

	httpRequest.onreadystatechange = function() { updateEventsContainer(httpRequest, container); };
	httpRequest.open('POST', 'index2.php', true);
	httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	httpRequest.send( parameters );
	}

	function serializeLineupForm(obj)
	{

		var getstr = "";
		var i = 0;
		if ( !obj.hasChildNodes() ) return getstr;
		for (i=0; i<obj.childNodes.length; i++) {
		 if (obj.childNodes[i].tagName == "INPUT") {

			if ( obj.childNodes[i].disabled == false ) {
				if (obj.childNodes[i].type == "text" || obj.childNodes[i].type == "hidden") {
					 getstr += obj.childNodes[i].name + "=" + obj.childNodes[i].value + "&";
				}
				if (obj.childNodes[i].type == "checkbox") {
					 if (obj.childNodes[i].checked) {
						getstr += obj.childNodes[i].name + "=" + obj.childNodes[i].value + "&";
					 } else {
						getstr += obj.childNodes[i].name + "=&";
					 }
				}
				if (obj.childNodes[i].type == "radio") {
					 if (obj.childNodes[i].checked) {
						getstr += obj.childNodes[i].name + "=" + obj.childNodes[i].value + "&";
					 }
				}
			}
		 }
		 else if (obj.childNodes[i].tagName == "SELECT") {

			if ( obj.childNodes[i].disabled == false ) {
				var sel = obj.childNodes[i];
				if ( sel.type == "select-one" ) {
					if ( sel.selectedIndex != -1 ) {
						getstr += sel.name + "=" + sel.options[sel.selectedIndex].value + "&";
					}
				}
				else if ( sel.type == "select-multiple" ) {

					//getstr += sel.name + "=";
					for ( j=0; j< sel.options.length ; j++) {
					if ( sel.options[j].selected && sel.options[j].value ) {
						getstr += sel.name + "=" + sel.options[j].value + "&";

					}
					}
				}
			}
		 }
		 else if ( obj.childNodes[i].hasChildNodes() ) {
			getstr += serializeLineupForm(obj.childNodes[i]);
			var dummy = 0;
		 }
		}
		return getstr;
	 }
/*
	jl_ajaxLoad = function(url, el)	{
		document.getElementById('log_res').empty();
		document.getElementById(el).empty();
		document.getElementById('log_res').addClass('ajax-loading');
				new Ajax(url, {
					method: 'get',
					update: document.getElementById(el)
				}).request();
			document.getElementById('log_res').removeClass('ajax-loading');

		return false;
	}
	*/
	/* Took this function from mozilla dev, getting rid of mootools */
	function jl_ajaxLoad(url, container) {
		var httpRequest;

		if (window.XMLHttpRequest) { // Mozilla, Safari, ...
			httpRequest = new XMLHttpRequest();
			if (httpRequest.overrideMimeType) {
				httpRequest.overrideMimeType('text/xml');
				// See note below about this line
			}
		}
		else if (window.ActiveXObject) { // IE
			try {
				httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch (e) {
							 try {
								httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
								 }
							 catch (e) {}
							}
										 }

		if (!httpRequest) {
			alert('Giving up :( Cannot create an XMLHTTP instance');
			return false;
		}
		httpRequest.onreadystatechange = function() { updateEventsContainer(httpRequest, container); };
		httpRequest.open('GET', url, true);
		httpRequest.send('');

	}

	function updateEventsContainer(httpRequest, container) {
			if (httpRequest.readyState == 1) {
				document.getElementById(container).className = 'ajax-loading';
				}
		if (httpRequest.readyState == 4) {
			if (httpRequest.status == 200) {
				document.getElementById(container).className = '';
					document.getElementById(container).innerHTML= httpRequest.responseText;
			} else {	 document.getElementById(container).innerHTML= httpRequest.responseText;
			document.getElementById(container).innerHTML = 'Error';
			}
		}
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