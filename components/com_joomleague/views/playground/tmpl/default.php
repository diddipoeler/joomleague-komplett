<?php defined( '_JEXEC' ) or die( 'Restricted access' );

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
	
	if (($this->config['show_tabs']) != 0)
	{
	
	if (($this->config['show_tabs']) == 1)
	{
  // ansicht mit slider
  ?>
	
<div class="jwts_title">
<div class="jwts_title_left" onclick="javascript:initialize();"  onload="javascript:initialize();">
<a href="javascript:void(null);" title="<?php echo JText::_( 'JL_PLAYGROUND_DATA' );?>" class="jwts_title_text"><?php echo JText::_( 'JL_PLAYGROUND_DATA' );?></a>
</div>
</div>
<div class="jwts_slidewrapper">
<div>
<?PHP
if (($this->config['show_playground'])==1)
	{ 
		echo $this->loadTemplate('playground');
	}
?>
</div>
</div>

<div class="jwts_title">
<div class="jwts_title_left">
<a href="javascript:void(null);" title="<?php echo JText::_( 'JL_PLAYGROUND_EXTENDED' );?>" class="jwts_title_text"><?php echo JText::_( 'JL_PLAYGROUND_EXTENDED' );?></a>
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
<a href="javascript:void(null);" title="<?php echo JText::_( 'JL_PLAYGROUND_CLUB_PICTURE' );?>" class="jwts_title_text"><?php echo JText::_( 'JL_PLAYGROUND_CLUB_PICTURE' );?></a>
</div>
</div>
<div class="jwts_slidewrapper">
<div>
<?PHP
if (($this->config['show_picture'])==1)
	{ 
		echo $this->loadTemplate('picture');
	}
?>
</div>
</div>

<div class="jwts_title">
<div class="jwts_title_left">
<a href="javascript:void(null);" title="<?php echo JText::_( 'JL_GMAP_DIRECTIONS' );?>" class="jwts_title_text"><?php echo JText::_( 'JL_GMAP_DIRECTIONS' );?></a>
</div>
</div>
<div class="jwts_slidewrapper">
<div>
<?PHP
if (($this->config['show_maps'])==1)
	{ 
	if ( $this->jl_use_jquery_version )
	{
  	echo $this->loadTemplate('maps_jquery');
  }
  else
  {
    echo $this->loadTemplate('maps');
  }	
	}
?>
</div>
</div>

<div class="jwts_title">
<div class="jwts_title_left">
<a href="javascript:void(null);" title="<?php echo JText::_( 'JL_PLAYGROUND_NOTES' );?>" class="jwts_title_text"><?php echo JText::_( 'JL_PLAYGROUND_NOTES' );?></a>
</div>
</div>
<div class="jwts_slidewrapper">
<div>
<?PHP
if (($this->config['show_description'])==1)
	{ 
		echo $this->loadTemplate('description');
	}
?>
</div>
</div>

<div class="jwts_title">
<div class="jwts_title_left">
<a href="javascript:void(null);" title="<?php echo JText::_( 'JL_PLAYGROUND_CLUB_TEAMS' );?>" class="jwts_title_text"><?php echo JText::_( 'JL_PLAYGROUND_CLUB_TEAMS' );?></a>
</div>
</div>
<div class="jwts_slidewrapper">
<div>
<?PHP
if (($this->config['show_teams'])==1)
	{ 
		echo $this->loadTemplate('teams');
	}
?>
</div>
</div>

<div class="jwts_title">
<div class="jwts_title_left">
<a href="javascript:void(null);" title="<?php echo JText::_( 'JL_PLAYGROUND_NEXT_GAMES' );?>" class="jwts_title_text"><?php echo JText::_( 'JL_PLAYGROUND_NEXT_GAMES' );?></a>
</div>
</div>
<div class="jwts_slidewrapper">
<div>
<?PHP
if (($this->config['show_matches'])==1)
	{ 
		echo $this->loadTemplate('matches');
	}
?>
</div>
</div>


	
	<?PHP
  
  }
  
  if (($this->config['show_tabs']) == 2)
	{
  // ansicht mit tabs
  ?>
<div class="jwts_tabber" id="jwts_tab">  
<?PHP 
if (($this->config['show_playground'])==1)
	{
	?>
<div class="jwts_tabbertab" title="<?PHP echo JText::_('JL_PLAYGROUND_DATA'); ?>"><h2>
<a href="javascript:void(null);" name="advtab"><?PHP echo JText::_('JL_PLAYGROUND_DATA'); ?></a></h2>
<?PHP
		echo $this->loadTemplate('playground');
	?>
</div>
<?PHP 
	}
  
if (($this->config['show_extended'])==1 && isset($this->extended) )
	{
	?>
<div class="jwts_tabbertab" title="<?PHP echo JText::_('JL_PLAYGROUND_EXTENDED'); ?>"><h2>
<a href="javascript:void(null);" name="advtab"><?PHP echo JText::_('JL_PLAYGROUND_EXTENDED'); ?></a></h2>
<?PHP
		echo $this->loadTemplate('extended');
	?>
</div>
<?PHP 
	}
  
if (($this->config['show_picture'])==1)
	{
	?>
<div class="jwts_tabbertab" title="<?PHP echo JText::_('JL_PLAYGROUND_CLUB_PICTURE'); ?>"><h2>
<a href="javascript:void(null);" name="advtab"><?PHP echo JText::_('JL_PLAYGROUND_CLUB_PICTURE'); ?></a></h2>
<?PHP
		echo $this->loadTemplate('picture');
	?>
</div>
<?PHP 
	}
  
if (($this->config['show_maps'])==1)
	{
	?>
<div class="jwts_tabbertab" title="<?PHP echo JText::_('JL_GMAP_DIRECTIONS'); ?>"><h2>
<a href="javascript:void(null);" name="advtab"><?PHP echo JText::_('JL_GMAP_DIRECTIONS'); ?></a></h2>
<?PHP
	if ( $this->jl_use_jquery_version )
	{
  	echo $this->loadTemplate('maps_jquery');
  }
  else
  {
    echo $this->loadTemplate('maps');
  }
	?>
</div>
<?PHP 
	}
  
if (($this->config['show_description'])==1)
	{
	?>
<div class="jwts_tabbertab" title="<?PHP echo JText::_('JL_PLAYGROUND_NOTES'); ?>"><h2>
<a href="javascript:void(null);" name="advtab"><?PHP echo JText::_('JL_PLAYGROUND_NOTES'); ?></a></h2>
<?PHP
		echo $this->loadTemplate('description');
	?>
</div>
<?PHP 
	}
  
if (($this->config['show_teams'])==1)
	{
	?>
<div class="jwts_tabbertab" title="<?PHP echo JText::_('JL_PLAYGROUND_CLUB_TEAMS'); ?>"><h2>
<a href="javascript:void(null);" name="advtab"><?PHP echo JText::_('JL_PLAYGROUND_CLUB_TEAMS'); ?></a></h2>
<?PHP
		echo $this->loadTemplate('teams');
	?>
</div>
<?PHP 
	}                            
  
if (($this->config['show_matches'])==1)
	{
	?>
<div class="jwts_tabbertab" title="<?PHP echo JText::_('JL_PLAYGROUND_NEXT_GAMES'); ?>"><h2>
<a href="javascript:void(null);" name="advtab"><?PHP echo JText::_('JL_PLAYGROUND_NEXT_GAMES'); ?></a></h2>
<?PHP
		echo $this->loadTemplate('matches');
	?>
</div>
<?PHP 
	}      
  
  
  
  
  
  
  
  ?>
</div>  
<div class="jwts_clr">
</div>
<?PHP 
  }
  
  }
  else
  {	
	if (($this->config['show_playground'])==1)
	{ 
		echo $this->loadTemplate('playground');
	}
		
	if (($this->config['show_extended'])==1)
	{
		echo $this->loadTemplate('extended');
	}
		
	if (($this->config['show_picture'])==1)
	{ 
		echo $this->loadTemplate('picture');
	}
		
	if (($this->config['show_maps'])==1)
	{ 
		
	
	if ( $this->jl_use_jquery_version )
	{
  	echo $this->loadTemplate('maps_jquery');
  }
  else
  {
    echo $this->loadTemplate('maps');
  }
  	
  }
	
	
		
	if (($this->config['show_description'])==1)
	{ 
		echo $this->loadTemplate('description');
	}

	if (($this->config['show_teams'])==1)
	{ 
		echo $this->loadTemplate('teams');
	}

	if (($this->config['show_matches'])==1)
	{ 
		echo $this->loadTemplate('matches');
	}	

  }
	echo "<div>";
		echo $this->loadTemplate('backbutton');
		echo $this->loadTemplate('footer');
	echo "</div>";
	?>
</div>
