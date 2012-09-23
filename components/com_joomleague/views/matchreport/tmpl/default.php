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
  }



JHTML::_('behavior.tooltip');
jimport('joomla.html.pane');

// Make sure that in case extensions are written for mentioned (common) views,
// that they are loaded i.s.o. of the template of this view
$templatesToLoad = array('projectheading', 'backbutton', 'footer');

JoomleagueHelper::addTemplatePaths($templatesToLoad, $this);
?>
<div class="joomleague"><?php
	echo $this->loadTemplate('projectheading');

	if (($this->config['show_sectionheader'])==1)
	{
		echo $this->loadTemplate('sectionheader');
	}

  
  if (($this->config['show_tabs']) != 0)
	{
  
?>
<div class="jwts_tabber" id="jwts_tab">  
<?PHP   
  
	
  
  if (($this->config['show_result'])==1)
	{
	?>
<div class="jwts_tabbertab" title="<?PHP echo JText::_('JL_MATCHREPORT_RESULT'); ?>"><h2>
<a href="javascript:void(null);" name="advtab"><?PHP echo JText::_('JL_MATCHREPORT_RESULT'); ?></a></h2>
<?PHP
    
    echo $this->loadTemplate('result');
    ?>
</div>
<?PHP 
	}
  
  if (($this->config['show_details'])==1)
	{
	?>
<div class="jwts_tabbertab" title="<?PHP echo JText::_('JL_MATCHREPORT_DETAILS_2'); ?>"><h2>
<a href="javascript:void(null);" name="advtab"><?PHP echo JText::_('JL_MATCHREPORT_DETAILS_2'); ?></a></h2>
<?PHP
  
		echo $this->loadTemplate('details');
    ?>
</div>
<?PHP 
	}

	if (($this->config['show_extended'])==1)
	{
	?>
<div class="jwts_tabbertab" title="<?PHP echo JText::_('JL_MATCHREPORT_EXTENDED'); ?>"><h2>
<a href="javascript:void(null);" name="advtab"><?PHP echo JText::_('JL_MATCHREPORT_EXTENDED'); ?></a></h2>
<?PHP
  
		echo $this->loadTemplate('extended');
    ?>
</div>
<?PHP 
	}
  
  if (($this->config['show_roster'])==1)
	{
  ?>
<div class="jwts_tabbertab" title="<?PHP echo JText::_('JL_MATCHREPORT_ROSTER'); ?>"><h2>
<a href="javascript:void(null);" name="advtab"><?PHP echo JText::_('JL_MATCHREPORT_ROSTER'); ?></a></h2>
<div class="jwts_tabber" id="jwts_tab">
<?PHP
  
?>
<div class="jwts_tabbertab" title="<?PHP echo JText::_('JL_MATCHREPORT_STARTING_ROSTER'); ?>"><h2>
<a href="javascript:void(null);" name="advtab"><?PHP echo JText::_('JL_MATCHREPORT_STARTING_ROSTER'); ?></a></h2>
<?PHP

    echo $this->loadTemplate('roster');
        ?>
</div>
<?PHP 
?>
<div class="jwts_tabbertab" title="<?PHP echo JText::_('JL_MATCHREPORT_STARTING_STAFF'); ?>"><h2>
<a href="javascript:void(null);" name="advtab"><?PHP echo JText::_('JL_MATCHREPORT_STARTING_STAFF'); ?></a></h2>
<?PHP    

		echo $this->loadTemplate('staff');
        ?>
</div>
<?PHP 
?>
<div class="jwts_tabbertab" title="<?PHP echo JText::_('JL_MATCHREPORT_SUBSTITUTES'); ?>"><h2>
<a href="javascript:void(null);" name="advtab"><?PHP echo JText::_('JL_MATCHREPORT_SUBSTITUTES'); ?></a></h2>
<?PHP    

		echo $this->loadTemplate('subst');
        ?>
</div>
<?PHP 
?>
<div class="jwts_tabbertab" title="<?PHP echo JText::_('JL_MATCHREPORT_ROSTER_IMAGE'); ?>"><h2>
<a href="javascript:void(null);" name="advtab"><?PHP echo JText::_('JL_MATCHREPORT_ROSTER_IMAGE'); ?></a></h2>
<?PHP    

    echo $this->loadTemplate('rosterplayground');
        ?>
</div>
<?PHP 

    
    ?>
</div>
</div>
<?PHP 
	}
  
  if ( !empty( $this->eventtypes ) )
	{
		if (($this->config['show_timeline'])==1)
		{
		?>
<div class="jwts_tabbertab" title="<?PHP echo JText::_('JL_MATCHREPORT_TIMELINE'); ?>"><h2>
<a href="javascript:void(null);" name="advtab"><?PHP echo JText::_('JL_MATCHREPORT_TIMELINE'); ?></a></h2>
<?PHP
    
			echo $this->loadTemplate('timeline');
      ?>
</div>
<?PHP 
		}

		if (($this->config['show_events'])==1)
		{
		?>
<div class="jwts_tabbertab" title="<?PHP echo JText::_('JL_MATCHREPORT_EVENTS'); ?>"><h2>
<a href="javascript:void(null);" name="advtab"><?PHP echo JText::_('JL_MATCHREPORT_EVENTS'); ?></a></h2>
<?PHP
    
			switch ($this->config['use_tabs_events'])
			{
				case 0:
					/** No tabs */
					echo $this->loadTemplate('events');
					break;
				case 1:
					/** Tabs */
					echo $this->loadTemplate('events_tabs');
					break;
				case 2:
					/** Table/Ticker layout */
					echo $this->loadTemplate('events_ticker');
					break;
			}
      ?>
</div>
<?PHP 
		}
    
	}

	if (($this->config['show_stats'])==1)
	{
	?>
<div class="jwts_tabbertab" title="<?PHP echo JText::_('JL_MATCHREPORT_STATISTICS_2'); ?>"><h2>
<a href="javascript:void(null);" name="advtab"><?PHP echo JText::_('JL_MATCHREPORT_STATISTICS_2'); ?></a></h2>
<?PHP
  
		echo $this->loadTemplate('stats');
    ?>
</div>
<?PHP 
	}

	if (($this->config['show_summary'])==1)
	{
	?>
<div class="jwts_tabbertab" title="<?PHP echo JText::_('JL_MATCHREPORT_MATCH_SUMMARY'); ?>"><h2>
<a href="javascript:void(null);" name="advtab"><?PHP echo JText::_('JL_MATCHREPORT_MATCH_SUMMARY'); ?></a></h2>
<?PHP
  
		echo $this->loadTemplate('summary');
    ?>
</div>
<?PHP 
	}
  
  
?>
</div>
<?PHP 	
	}
  else
  {
	if (($this->config['show_result'])==1)
	{
		echo $this->loadTemplate('result');
	}

	if (($this->config['show_details'])==1)
	{
		echo $this->loadTemplate('details');
	}

	if (($this->config['show_extended'])==1)
	{
		echo $this->loadTemplate('extended');
	}

	if (($this->config['show_roster'])==1)
	{
		echo $this->loadTemplate('roster');
		echo $this->loadTemplate('staff');
		echo $this->loadTemplate('subst');
        echo $this->loadTemplate('rosterplayground');
	}

	if ( !empty( $this->eventtypes ) )
	{
		if (($this->config['show_timeline'])==1)
		{
			echo $this->loadTemplate('timeline');
		}

		if (($this->config['show_events'])==1)
		{
			switch ($this->config['use_tabs_events'])
			{
				case 0:
					/** No tabs */
					echo $this->loadTemplate('events');
					break;
				case 1:
					/** Tabs */
					echo $this->loadTemplate('events_tabs');
					break;
				case 2:
					/** Table/Ticker layout */
					echo $this->loadTemplate('events_ticker');
					break;
			}
		}
	}

	if (($this->config['show_stats'])==1)
	{
		echo $this->loadTemplate('stats');
	}

	if (($this->config['show_summary'])==1)
	{
		echo $this->loadTemplate('summary');
	}

  }


	echo "<div>";
		echo $this->loadTemplate('backbutton');
		echo $this->loadTemplate('footer');
	echo "</div>";
	?>
</div>
