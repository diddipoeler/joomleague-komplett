
/**
 * js script for joomleague navigation module
 */
window.addEvent('domready', function(){
	
	$$('div.jl-nav-module .jlnav-select').addEvent('change', function(){
		var form = $(this.form);
		$$('.nav-item').setStyle( "display", "none");
		$$('.team-select').setStyle( "display", "none");
	    var url = 'index.php?option=com_joomleague&controller=ajax&task=getprojectsoptions&tmpl=component&format=raw';
	    var myXhr = new XHR(
	                    {
	                    method: 'post',
	                    onSuccess: modjlnav.updateProjects.bind(this)
	                    }
	        );
	    var data = 's=' + this.form.s.value + '&l=' + this.form.l.value + '&o=' + this.form.o.value;
	    myXhr.send(url, data); 
	});

	$$('div.jl-nav-module .jlnav-project').addEvent('change', function(){
		if (this.value > 0) {
			modjlnav.customsubmit(this.form);
		}
	});

	$$('div.jl-nav-module .jlnav-team').addEvent('change', function(){
		this.form.view.value = this.form.teamview.value;
		modjlnav.customsubmit(this.form);
	});
});

var modjlnav = {
	updateProjects : function(response)
	{
		var select = $(this.form.p);
		var first = $(select.options[0]).clone();
		select.empty();
		first.injectInside(select);
		
		var options = eval(response);
		var count = options.length;
		
		var include_season = $(this.form.include_season).value;

		for (var i = 0; i < count; i++)
		{
			if (include_season == 2) {
				var txt = options[i].text + " - " + options[i].season_name;
			}
			else if (include_season == 1) {
				var txt = options[i].season_name + " - " + options[i].text;
			}
			else {
				var txt = options[i].text;
			}
			var option = new Element('option', {text: txt, value: options[i].value });
			option.injectInside(select);
		}
	},

	customsubmit : function(form)
	{
		var query = '';
		query += 'view='+form.view.value;
		query += '&p='+form.p.value;
		if (form.tid) {
			query += '&tid='+form.tid.value;
		}

	    var url = 'index.php?option=com_joomleague&controller=ajax&task=getroute&tmpl=component&format=raw';
	    var myXhr = new XHR(
	                    {
	                    method: 'post',
	                    onSuccess: this.credirect
	                    }
	        );
	    myXhr.send(url, query); 
	},
	
	credirect : function(response)
	{
		window.location = eval(response);
	}
};