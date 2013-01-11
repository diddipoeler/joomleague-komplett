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

/*
jimport('joomla.html.pane'); 
$document =& JFactory::getDocument();
$css = 'components/com_joomleague/assets/css/tabs.css';
$document->addStyleSheet($css);
*/

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
		
  if (($this->config['show_tabs']) != 0)
	{
	
	if (($this->config['show_tabs']) == 1)
	{
  // ansicht mit slider
  
  ?>
<div style="width: 100%; float: left">  
	
<div class="jwts_title">
<div class="jwts_title_left" onclick=""  onload="">
<a href="javascript:void(null);" title="<?PHP echo JText::_('JL_GMAP_DIRECTIONS'); ?>" class="jwts_title_text"><?PHP echo JText::_('JL_GMAP_DIRECTIONS'); ?></a>
</div>
</div>
<div class="jwts_slidewrapper">
<div>
<?PHP 
  if (($this->config['show_maps'])==1)
	{
		echo $this->loadTemplate('maps');
	}
	?>
</div>
</div>

<div class="jwts_title">
<div class="jwts_title_left">
<a href="javascript:void(null);" title="<?PHP echo JText::_('JL_CLUBINFO_TEAMS'); ?>" class="jwts_title_text"><?PHP echo JText::_('JL_CLUBINFO_TEAMS'); ?></a>
</div>
</div>
<div class="jwts_slidewrapper">
<div>
<?PHP 
  if (($this->config['show_teams_of_club'])==1)
	{
		echo $this->loadTemplate('teams');
	}
	?>
</div>
</div>	

<div class="jwts_title">
<div class="jwts_title_left">
<a href="javascript:void(null);" title="<?PHP echo JText::_('JL_CLUBINFO_EXTENDED'); ?>" class="jwts_title_text"><?PHP echo JText::_('JL_CLUBINFO_EXTENDED'); ?></a>
</div>
</div>
<div class="jwts_slidewrapper">
<div>
<?PHP 
  if (($this->config['show_extended'])==1)
	{
		echo $this->loadTemplate('extended');
	}
	?>
</div>
</div>

<div class="jwts_title">
<div class="jwts_title_left">
<a href="javascript:void(null);" title="<?PHP echo JText::_('JL_CLUBINFO_RSSFEEDS'); ?>" class="jwts_title_text"><?PHP echo JText::_('JL_CLUBINFO_RSSFEEDS'); ?></a>
</div>
</div>
<div class="jwts_slidewrapper">
<div>
<?PHP 
  if (($this->config['show_club_rssfeed']) == 1  && !empty($this->rssfeedoutput) )
	{
		echo $this->loadTemplate('rssfeed-table');
	}
	?>
</div>
</div>




	
	</div>
	
	<?PHP
  
  
  
	}
	if (($this->config['show_tabs']) == 2)
	{
	// ansicht mit tabs
  ?>
<div style="width: 100%; float: left">  
<div class="jwts_tabber" id="jwts_tab">  
<?PHP 
  if (($this->config['show_maps'])==1)
	{
	?>
<div onclick="" onload="" class="jwts_tabbertab" title="<?PHP echo JText::_('JL_GMAP_DIRECTIONS'); ?>"><h2>
<a href="javascript:void(null);" name="advtab"><?PHP echo JText::_('JL_GMAP_DIRECTIONS'); ?></a></h2>
<?PHP
		echo $this->loadTemplate('maps');
	?>
</div>
<?PHP 
	}
	
	if (($this->config['show_teams_of_club'])==1)
	{ 
		?>
<div class="jwts_tabbertab" title="<?PHP echo JText::_('JL_CLUBINFO_TEAMS'); ?>"><h2>
<a href="javascript:void(null);" name="advtab"><?PHP echo JText::_('JL_CLUBINFO_TEAMS'); ?></a></h2>
<?PHP
		echo $this->loadTemplate('teams');
		?>
</div>
<?PHP	
		
	}
	
	if (($this->config['show_extended'])==1)
	{ 
		?>
<div class="jwts_tabbertab" title="<?PHP echo JText::_('JL_CLUBINFO_EXTENDED'); ?>"><h2>
<a href="javascript:void(null);" name="advtab"><?PHP echo JText::_('JL_CLUBINFO_EXTENDED'); ?></a></h2>
<?PHP
		echo $this->loadTemplate('extended');
		?>
</div>
<?PHP	
		
	}
	
	if (($this->config['show_club_rssfeed']) == 1 && !empty($this->rssfeedoutput) )
	{ 
		?>
<div class="jwts_tabbertab" title="<?PHP echo JText::_('JL_CLUBINFO_RSSFEEDS'); ?>"><h2>
<a href="javascript:void(null);" name="advtab"><?PHP echo JText::_('JL_CLUBINFO_RSSFEEDS'); ?></a></h2>
<?PHP
		echo $this->loadTemplate('rssfeed-table');
		?>
</div>
<?PHP	
		
	}
	
	
	
	
  ?>
</div>  
<div class="jwts_clr">
</div>  
</div>  
  
<?PHP 
	}

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

  if ( $this->userfields )
	{ 
		echo $this->loadTemplate('userfields');
		
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
  
  if ( ($this->config['show_club_rssfeed']) == 1 && !empty($this->rssfeedoutput) )
	{ 
	
		echo $this->loadTemplate('rssfeed-table');
			
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
