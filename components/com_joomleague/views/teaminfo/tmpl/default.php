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
	if ($this->config['show_projectheader']==1)
	{	
		echo $this->loadTemplate('projectheading');
	}
		
	if ($this->config['show_sectionheader']==1)
	{
		echo $this->loadTemplate('sectionheader');
	}
	
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
	
  if ($this->config['show_teaminfo']==1)
	{
	echo $pane->startPanel(JText::_('JL_TEAMINFO'),'panel1');
		echo $this->loadTemplate('teaminfo');
		echo $pane->endPanel();
	}

	if ($this->config['show_description']==1)
	{
	echo $pane->startPanel(JText::_('JL_TEAMINFO_TEAMINFORMATION'),'panel2');
		echo $this->loadTemplate('description');
		echo $pane->endPanel();
	}
	//fix me css	
	if ($this->config['show_extended']==1)
	{
	echo $pane->startPanel(JText::_('JL_TEAMINFO_EXTENDED'),'panel3');
		echo $this->loadTemplate('extended');
		echo $pane->endPanel();
	}	
		
	if ($this->config['show_history']==1)
	{
	echo $pane->startPanel(JText::_('JL_TEAMINFO_HISTORY'),'panel4');
		echo $this->loadTemplate('history');
		echo $pane->endPanel();
	}

  if (($this->config['show_training'])==1)
		{
		echo $pane->startPanel(JText::_('JL_TEAMINFO_TRAININGSDATA'),'panel5');
			echo $this->loadTemplate('training');
			echo $pane->endPanel();
		}

  echo $pane->endPane();


 
  }
  else
  {
  	
	if ($this->config['show_teaminfo']==1)
	{
		echo $this->loadTemplate('teaminfo');
	}

	if ($this->config['show_description']==1)
	{
		echo $this->loadTemplate('description');
	}
	//fix me css	
	if ($this->config['show_extended']==1)
	{
		echo $this->loadTemplate('extended');
	}	
		
	if ($this->config['show_history']==1)
	{
		echo $this->loadTemplate('history');
	}
	
	if (($this->config['show_training'])==1)
		{
			echo $this->loadTemplate('training');
		}
		
  }
  	
	echo "<div>";
		echo $this->loadTemplate('backbutton');
		echo $this->loadTemplate('footer');
	echo "</div>";
	?>
</div>
