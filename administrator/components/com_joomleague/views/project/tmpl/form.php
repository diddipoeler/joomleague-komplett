<?php defined('_JEXEC') or die('Restricted access');

JHTML::_('behavior.formvalidation');
JHTML::_('behavior.tooltip');
jimport('joomla.html.pane');

// Set toolbar items for the page
if ($this->copy)
{
	$old_id=$this->project->id;
	JToolBarHelper::title(JText::_('JL_ADMIN_PROJECT_COPY_PROJECT'),'ProjectSettings');
}
else
{
	$toolbarTitle=(!$this->edit) ? JText::_('JL_ADMIN_PROJECT_ADD_NEW') : JText::_('JL_ADMIN_PROJECT_EDIT');

	JToolBarHelper::title($toolbarTitle,'ProjectSettings');
	JToolBarHelper::divider();
	$old_id='0';
}

if (!$this->copy)
{
	JToolBarHelper::apply();
	JToolBarHelper::save();
}
else
{
	JToolBarHelper::save('copysave');
}

JToolBarHelper::divider();
if ((!$this->edit) || ($this->copy))
{
	JToolBarHelper::cancel();
}
else
{
	// for existing items the button is renamed `close`
	JToolBarHelper::cancel('cancel',JText::_('JL_GLOBAL_CLOSE'));
}

JToolBarHelper::help('screen.joomleague',true);
?>
<script language="javascript" type="text/javascript">

	Window.onDomReady(function()
	{
		document.formvalidator.setHandler('date',
		function (value)
		{
			if(value=="")
			{
				return true;
			}
			else
			{
				timer=new Date();
				time=timer.getTime();
				regexp=new Array();
				regexp[time]=new RegExp('^[0-9]{4}-[0-1][0-9]-[0-3][0-9]$','gi');
				return regexp[time].test(value);
			}
		}
		);

		document.formvalidator.setHandler('matchday',
		function (value)
		{
			if(value=="")
			{
				return false;
			}
			else
			{
				var regexp=new RegExp('^[0-9]+$','gi');
				if (!regexp.test(value))
				{
					return false;
				}
				else
				{
					return (getInt(value) > 0);
				}
			}
		}
		);

		document.formvalidator.setHandler('select-required',
		function (value)
		{
			return value != 0;
		}
		);
	});

	function submitbutton(pressbutton)
	{
		if (pressbutton == 'cancel')
		{
			submitform(pressbutton);
			return;
		}

		var form=document.adminForm;
		var validator=document.formvalidator;

		// do field validation
		if (validator.validate(form.name) === false)
		{
			alert("<?php echo JText::_('JL_ADMIN_PROJECT_ERROR_NAME',true); ?>");
			Form.dates.focus();
			return false;
		}
		else if (validator.validate(form['season_id'])===false && form['season_id'].disabled!=true ||
				(form.seasonNew && form.seasonNew.disabled==false && form.seasonNew.value==""))
			{
				alert("<?php echo JText::_('JL_ADMIN_PROJECT_ERROR_SEASON_NAME',true); ?>");
				return false;
			}
			else if ((validator.validate(form['league_id'])===false && form['league_id'].disabled!=true) ||
				(form.leagueNew && form.leagueNew.disabled==false && form.leagueNew.value==""))
				{
					alert("<?php echo JText::_('JL_ADMIN_PROJECT_ERROR_LEAGUE_NAME',true); ?>");
					return false;
				}
				else if (validator.validate(form['sports_type_id'])===false && form['sports_type_id'].disabled!=true ||
						(form.seasonNew && form.seasonNew.disabled==false && form.seasonNew.value==""))
					{
						alert("<?php echo JText::_('JL_ADMIN_PROJECT_ERROR_SPORTS_TYPE',true); ?>");
						return false;
					}
					else if (form['joomleague_admin'] && form['joomleague_admin'].value===0)
						{
							alert("<?php echo JText::_('JL_ADMIN_PROJECT_ERROR_ADMIN',true); ?>");
							return false;
						}
						else if (form['joomleague_editor'] && form['joomleague_editor'].value === 0)
							{
								alert("<?php echo JText::_('JL_ADMIN_PROJECT_ERROR_EDITOR',true); ?>");
								return false;
							}
							else if (form['current_round'] && validator.validate(form['current_round']) === false)
								{
									alert("<?php echo JText::_('JL_ADMIN_PROJECT_ERROR_MATCHDAY',true); ?>");
									form['league_id'].focus();
									return false;
								}
								else
								{
									submitform(pressbutton);
								}
	}

	function RoundAutoSwitch()
	{
		var form=document.adminForm;
		if (form['current_round_auto'].value==0)
		{
			form['current_round'].readOnly=false;
			form['auto_time'].readOnly=true;
		}
		else
		{
			form['current_round'].readOnly=true;
			form['auto_time'].readOnly=false;
		}
	}

	function showActOffset()
	{
		var form=document.adminForm;
		var a=new Date();
		var b=parseInt(a.getHours());
		var dummy=parseInt(<?php echo JHTML::date(time(),'%H'); ?>)-b;
		var c=parseInt(a.getMinutes());
		var timeOffsetValue=parseInt(form.timeoffset.value);
		var result=b+timeOffsetValue+dummy;
		if (result < 0){result=24+result;}
		if (result > 23){result=result-24;}
		if (result < 10){result='0'+result;}
		if (c < 10){c='0'+c;}
		form.acttime.value=result+':'+c;
	}

</script>
<style type="text/css">
	table.paramlist td.paramlist_key {
		width: 92px;
		text-align: left;
		height: 30px;
	}
</style>
<form action="index.php" method="post" name="adminForm" id="adminForm">
	<div class="col50">
		<?php
		$pane =& JPane::getInstance('tabs',array('startOffset'=>0));
		echo $pane->startPane('pane');
		echo $pane->startPanel(JText::_('JL_TABS_DETAILS'),'panel1');
		echo $this->loadTemplate('details');
		echo $pane->endPanel();

		echo $pane->startPanel(JText::_('JL_TABS_DATE'),'panel2');
		echo $this->loadTemplate('date');
		echo $pane->endPanel();

		echo $pane->startPanel(JText::_('JL_TABS_PROJECT'),'panel3');
		echo $this->loadTemplate('project');
		echo $pane->endPanel();

		echo $pane->startPanel(JText::_('JL_TABS_COMPETITION'),'panel4');
		echo $this->loadTemplate('competition');
		echo $pane->endPanel();

		echo $pane->startPanel(JText::_('JL_TABS_FAVORITE'),'panel5');
		echo $this->loadTemplate('favorite');
		echo $pane->endPanel();

		echo $pane->startPanel( JText::_( 'JL_TABS_PICTURE' ), 'panel6' );
		echo $this->loadTemplate('picture');
		echo $pane->endPanel();

		echo $pane->startPanel( JText::_( 'JL_TABS_EXTENDED' ), 'panel7' );
		echo $this->loadTemplate('extended');
		echo $pane->endPanel();
    
    if ( $this->isforumexist )
    {
    echo $pane->startPanel( JText::_( 'JL_TABS_KUNENA_FORUM' ), 'panel8' );
		echo $this->loadTemplate('forum');
		echo $pane->endPanel();
    }
    
		echo $pane->endPane();
		?>
		<div class="clr"></div>
		<?php if ($old_id > 0){$this->project->id=0;} ?>
		<input type="hidden" name="option" value="com_joomleague" />
		<input type="hidden" name="controller" value="project" />
		<input type="hidden" name="oldseason" value="<?php echo $this->project->season_id; ?>" />
		<input type="hidden" name="oldleague" value="<?php echo $this->project->league_id; ?>" />
		<input type="hidden" name="cid[]" value="<?php echo $this->project->id; ?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="old_id" value="<?php echo $old_id; ?>" />
		<?php echo JHTML::_('form.token')."\n"; ?>
	</div>
</form>
