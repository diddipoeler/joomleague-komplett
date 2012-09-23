<?php defined( '_JEXEC' ) or die( 'Restricted access' );

// Make sure that in case extensions are written for mentioned (common) views,
// that they are loaded i.s.o. of the template of this view
$templatesToLoad = array('projectheading', 'backbutton', 'footer');
JoomleagueHelper::addTemplatePaths($templatesToLoad, $this);

//echo 'config <br><pre>'.print_r($this->config,true).'</pre><br>';

?>
<div class="joomleague">
	<?php 
	if ($this->config['show_projectheader'] == 1)
	{
		echo $this->loadTemplate('projectheading');
	}

	if ($this->projectteam)
	{
		if (($this->config['show_sectionheader'])==1)
		{
			echo $this->loadTemplate('sectionheader');
		}

		if (($this->config['show_team_logo'])==1)
		{
			echo $this->loadTemplate('picture');
		}

		if (($this->config['show_description'])==1)
		{
			echo $this->loadTemplate('description');
		}

		if (($this->config['show_players'])==1)
		{
			echo $this->loadTemplate('players');
		}

		if (($this->config['show_staff'])==1)
		{
			echo $this->loadTemplate('staff');
		}
    
    if (($this->config['show_training'])==1)
		{
			echo $this->loadTemplate('training');
		}
	}
	else
	{
		echo "<p>Project team could not be determined</p>";
	}

	echo "<div>";
		echo $this->loadTemplate('backbutton');
		echo $this->loadTemplate('footer');
	echo "</div>";
	?>
</div>
