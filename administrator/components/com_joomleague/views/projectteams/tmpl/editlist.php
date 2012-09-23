<?php defined( '_JEXEC' ) or die( 'Restricted access' );

JHTML::_( 'behavior.tooltip' );

// Set toolbar items for the page
//$edit = JRequest::getVar('edit',true);

JToolBarHelper::title( JText::_( 'JL_ADMIN_PROJECTTEAMS_ASSIGN' ) );
#JToolBarHelper::title( $this->projectws->name . ' - ' . JText::_( 'Teams' ) . ' ' );
JToolBarHelper::save( 'save_teamslist' );

// for existing items the button is renamed `close` and the apply button is showed
JToolBarHelper::cancel( 'cancel', 'JL_GLOBAL_CLOSE' );

JToolBarHelper::help( 'screen.joomleague', true );

$uri =& JFactory::getURI();
?>
<!-- import the functions to move the events between selection lists  -->
<?php
$version = urlencode(JoomleagueHelper::getVersion());
echo JHTML::script( 'JL_eventsediting.js?v='.$version,'administrator/components/com_joomleague/assets/js/');
?>
<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton)
	{
		var form = document.adminForm;
		if (pressbutton == 'cancel')
		{
			submitform( pressbutton );
			return;
		}
		var mylist = document.getElementById('project_teamslist');
		for(var i=0; i<mylist.length; i++)
		{
			  mylist[i].selected = true;
		}
		submitform( pressbutton );
	}
</script>

<style type="text/css">
	table.paramlist td.paramlist_key {
		width: 92px;
		text-align: left;
		height: 30px;
	}
</style>

<form action="<?php echo $this->request_url; ?>" method="post" name="adminForm">
	<div class="col50">
		<fieldset class="adminform">
			<legend>
				<?php
				echo JText::sprintf( 'JL_ADMIN_PROJECTTEAMS_ASSIGN_TITLE', '<i>' . $this->projectws->name . '</i>');
				?>
			</legend>
			<table class="admintable" border="0">
				<tr>
					<td>
						<b>
							<?php
							echo JText::_( 'JL_ADMIN_PROJECTTEAMS_ASSIGN_AVAIL_TEAMS' );
							?>
						</b><br />
						<?php
						echo $this->lists['teams'];
						?>
					</td>
					<td style="text-align:center; ">
						&nbsp;&nbsp;
						<input	type="button" class="inputbox"
								onclick="document.getElementById('teamschanges_check').value=1;move(document.getElementById('teamslist'), document.getElementById('project_teamslist'));selectAll(document.getElementById('project_teamslist'));"
								value="&gt;&gt;" />
						&nbsp;&nbsp;<br />&nbsp;&nbsp;
					 	<input	type="button" class="inputbox"
					 			onclick="document.getElementById('teamschanges_check').value=1;move(document.getElementById('project_teamslist'), document.getElementById('teamslist'));selectAll(document.getElementById('project_teamslist'));"
								value="&lt;&lt;" />
						&nbsp;&nbsp;
					</td>
					<td>
						<b>
							<?php
							echo JText::_( 'JL_ADMIN_PROJECTTEAMS_ASSIGN_PROJ_TEAMS' );
							?>
						</b><br />
						<?php
						echo $this->lists['project_teams'];
						?>
					</td>
			   </tr>
			</table>
		</fieldset>
		<div class="clr"></div>

		<input type="hidden" name="teamschanges_check"	value="0"	id="teamschanges_check" />
		<input type="hidden" name="option"				value="com_joomleague" />
		<input type="hidden" name="controller"			value="projectteam" />
		<input type="hidden" name="cid[]"				value="<?php echo $this->projectws->id; ?>" />
		<input type="hidden" name="task"				value="save_matcheslist" />
	</div>
</form>