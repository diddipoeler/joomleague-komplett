<?php defined( '_JEXEC' ) or die( 'Restricted access' );

$this->_addPath( 'template', JPATH_COMPONENT . DS . 'views' . DS . 'projectheading' . DS . 'tmpl' );
$this->_addPath( 'template', JPATH_COMPONENT . DS . 'views' . DS . 'backbutton' . DS . 'tmpl' );
$this->_addPath( 'template', JPATH_COMPONENT . DS . 'views' . DS . 'footer' . DS . 'tmpl' );
?>
<div class="joomleague">
<?php 
//projectheading
    if (($this->config['show_projectheader']) == 1)
    {	
    echo $this->loadTemplate('projectheading');
    }

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
		
echo "<div>";
	//backbutton
	echo $this->loadTemplate('backbutton');
	// footer
	echo $this->loadTemplate('footer');
echo "</div>";
?>
</div>