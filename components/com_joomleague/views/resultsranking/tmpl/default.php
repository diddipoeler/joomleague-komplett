<?php 
defined('_JEXEC') or die('Restricted access');

if ( $this->params->get('show_tabs', 0) != 0)
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
$templatesToLoad = array('projectheading', 'backbutton', 'footer', 'results', 'ranking');
JoomleagueHelper::addTemplatePaths($templatesToLoad, $this);
?>
<div class="joomleague">
	<a name="jl_top" id="jl_top"></a>
	<?php 
	echo $this->loadTemplate('projectheading');

	if ($this->config['show_matchday_dropdown'])
	{
		echo $this->loadTemplate('selectround');
	}

  if ( $this->params->get('show_tabs', 0) != 0)
	{
  
  if (($this->params->get('show_tabs', 0)) == 1)
	{
  $pane =& JPane::getInstance('sliders',array('startOffset'=>0));
	}
	if (($this->params->get('show_tabs', 0)) == 2)
	{
  $pane =& JPane::getInstance('tabs',array('startOffset'=>0));
	}
  
  echo $pane->startPane('pane');
  
  $results = '';
	if ($this->config['show_sectionheader'])
	{
		$results .= $this->loadTemplate('sectionheaderres');
	}
	$results .= $this->loadTemplate('results');
		
	if ($this->params->get('what_to_show_first', 0) == 0)
	{
	echo $pane->startPanel(JText::_('JL_RESULTSRANKING_RESULT'),'panel1');
		echo $results;
		echo $pane->endPanel();
	}

	if ($this->config['show_ranking']==1)
	{
	echo $pane->startPanel(JText::_('JL_RESULTSRANKING_RANKING'),'panel2');
		if ($this->config['show_sectionheader'])
		{
			echo $this->loadTemplate('sectionheaderrank');
		}
		
		if ($this->config['show_counting']==1)
	{
		echo $this->loadTemplate('counting');
	}
	
		echo $this->loadTemplate('ranking');
		
		if ($this->config['show_colorlegend'])
		{
			echo $this->loadTemplate('colorlegend');
		}
		
		if ($this->config['show_explanation']==1)
		{
			echo $this->loadTemplate('explanation');
		}
		
	if ($this->config['show_notes'] == "1")
	{
		echo $this->loadTemplate('notes');
	}
	
		echo $pane->endPanel();
	}

	if ($this->params->get('what_to_show_first', 0) == 1)
	{
	echo $pane->startPanel(JText::_('JL_RESULTSRANKING_RESULT'),'panel3');
		echo '<br />'.$results;
		echo $pane->endPanel();
	}
  
  echo $pane->endPane();

  }
  else
  {
  
	$results = '';
	if ($this->config['show_sectionheader'])
	{
		$results .= $this->loadTemplate('sectionheaderres');
	}
	$results .= $this->loadTemplate('results');
		
	if ($this->params->get('what_to_show_first', 0) == 0)
	{
		echo $results;
	}

	if ($this->config['show_ranking']==1)
	{
		if ($this->config['show_sectionheader'])
		{
			echo $this->loadTemplate('sectionheaderrank');
		}
		
		if ($this->config['show_counting']==1)
	{
		echo $this->loadTemplate('counting');
	}
	
		echo $this->loadTemplate('ranking');
		
		if ($this->config['show_colorlegend'])
		{
			echo $this->loadTemplate('colorlegend');
		}
		
	if ($this->config['show_notes'] == "1")
	{
		echo $this->loadTemplate('notes');
	}
		
		if ($this->config['show_explanation']==1)
		{
			echo $this->loadTemplate('explanation');
		}
	}

	if ($this->params->get('what_to_show_first', 0) == 1)
	{
		echo '<br />'.$results;
	}
	
  }
  	
	if ($this->config['show_pagnav']==1)
	{
		echo $this->loadTemplate('pagnav');
	}

	echo "<div>";
		echo $this->loadTemplate('backbutton');
		echo $this->loadTemplate('footer');
	echo "</div>";
	?>
</div>
