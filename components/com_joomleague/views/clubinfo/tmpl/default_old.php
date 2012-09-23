<?php 
defined( '_JEXEC' ) or die( 'Restricted access' );

if ( $this->config['show_tabs'] != 0)
	{

$enable_tabs 		=  1;
$enable_slides 		=  1;
$slides_slidespeed 	= 30;
$slides_timer 		= 10;
$show_tab_slide = 0;    		
$mosConfig_live_site 		= JURI::root();
$mosConfig_absolute_path 	= JPATH_COMPONENT_SITE;

$header = "<!-- JoomlaWorks \"Tabs & Slides\" Plugin (v2.3) starts here -->
						<style type=\"text/css\" media=\"screen\">
							@import \"$mosConfig_live_site/components/com_joomleague/assets/tabs_slides/tabs_slides.css\";
						</style>
						<style type=\"text/css\" media=\"print\">.jwts_tabbernav{display:none;}</style>
						<script type=\"text/javascript\">var jwts_slideSpeed=".$slides_slidespeed."; var jwts_timer=".$slides_timer.";</script>
						<script type=\"text/javascript\" src=\"$mosConfig_live_site/components/com_joomleague/assets/tabs_slides/tabs_slides_comp.js\"></script>
					  ";
$header .= "<script type=\"text/javascript\" src=\"$mosConfig_live_site/components/com_joomleague/assets/tabs_slides/tabs_slides_opt_loader.js\"></script>";
echo $header;


jimport('joomla.html.pane'); 

$document =& JFactory::getDocument();
$css = 'components/com_joomleague/assets/css/tabs.css';
$document->addStyleSheet($css);

  }


 

// Make sure that in case extensions are written for mentioned (common) views,
// that they are loaded i.s.o. of the template of this view
$templatesToLoad = array('projectheading', 'backbutton', 'footer');
JoomleagueHelper::addTemplatePaths($templatesToLoad, $this);
?>
<div class="joomleague">
	<?php 
	echo $this->loadTemplate('projectheading');

	if (($this->config['show_sectionheader'])==1)
	{ 
		echo $this->loadTemplate('sectionheader');
	}

	// Needs some changing &Mindh4nt3r
	echo $this->loadTemplate('clubinfo');
		
// 	echo "<div class='jl_defaultview_spacing'>";
// 	echo "&nbsp;";
// 	echo "</div>";

  if (($this->config['show_tabs']) != 0)
	{
	
	if (($this->config['show_tabs']) == 1)
	{
  $pane =& JPane::getInstance('sliders',array('startOffset'=>0));
	}
	if (($this->config['show_tabs']) == 2)
	{
  $pane =& JPane::getInstance('tabs',array('startOffset'=>0));
	}
	
  echo $pane->startPane('pane');
	
	if (($this->config['show_extended'])==1)
	{
	echo $pane->startPanel(JText::_('JL_CLUBINFO_EXTENDED'),'panel1');
		echo $this->loadTemplate('extended');
		echo "<div class='jl_defaultview_spacing'>";
		echo "&nbsp;";
		echo "</div>";	
		echo $pane->endPanel();
    
	}

	if (($this->config['show_maps'])==1)
	{ 
	echo $pane->startPanel(JText::_('JL_GMAP_DIRECTIONS'),'panel2');
		echo $this->loadTemplate('maps');
		
		echo "<div class='jl_defaultview_spacing'>";
		echo "&nbsp;";
		echo "</div>";
		echo $pane->endPanel();
    
	}

		
	if (($this->config['show_teams_of_club'])==1)
	{ 
	echo $pane->startPanel(JText::_('JL_CLUBINFO_TEAMS'),'panel3');
		echo $this->loadTemplate('teams');
			
		echo "<div class='jl_defaultview_spacing'>";
		echo "&nbsp;";
		echo "</div>";
		echo $pane->endPanel();
	}
  
  if (($this->config['show_club_rssfeed'])==1)
	{ 
	echo $pane->startPanel(JText::_('JL_CLUBINFO_RSSFEED'),'panel4');
		//echo $this->loadTemplate('rssfeed');
    echo $this->loadTemplate('rssfeed-table');
			
		echo "<div class='jl_defaultview_spacing'>";
		echo "&nbsp;";
		echo "</div>";
		echo $pane->endPanel();
	}
	
	echo $pane->endPane();
	
	

  }
  else
  {
  echo "<div class='jl_defaultview_spacing'>";
	echo "&nbsp;";
	echo "</div>";
	//fix me
	if (($this->config['show_extended'])==1)
	{
		echo $this->loadTemplate('extended');
		echo "<div class='jl_defaultview_spacing'>";
		echo "&nbsp;";
		echo "</div>";	
    
	}

	if (($this->config['show_maps'])==1)
	{ 
		echo $this->loadTemplate('maps');
		
		echo "<div class='jl_defaultview_spacing'>";
		echo "&nbsp;";
		echo "</div>";
    
	}

		
	if (($this->config['show_teams_of_club'])==1)
	{ 
		echo $this->loadTemplate('teams');
			
		echo "<div class='jl_defaultview_spacing'>";
		echo "&nbsp;";
		echo "</div>";
	}
  
  if (($this->config['show_club_rssfeed'])==1)
	{ 
	
		echo $this->loadTemplate('rssfeed');
			
		echo "<div class='jl_defaultview_spacing'>";
		echo "&nbsp;";
		echo "</div>";
	
	}
  

  }

	echo "<div>";
		echo $this->loadTemplate('backbutton');
		echo $this->loadTemplate('footer');
	echo "</div>";
	?>
</div>
