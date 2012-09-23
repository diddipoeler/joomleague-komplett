<?php defined('_JEXEC') or die('Restricted access');

// Make sure that in case extensions are written for mentioned (common) views,
// that they are loaded i.s.o. of the template of this view
$templatesToLoad = array('projectheading', 'backbutton', 'footer');
JoomleagueHelper::addTemplatePaths($templatesToLoad, $this);
?>
<div class="joomleague">
	<?php
	echo $this->loadTemplate('projectheading');

	echo $this->loadTemplate('sectionheader');

	if ($this->config['show_matchday_pagenav']==2 || $this->config['show_matchday_pagenav']==3)
	{
		echo $this->loadTemplate('pagnav');
	}
	
	echo $this->loadTemplate('results');

  if ( ($this->config['show_project_rssfeed']) == 1 && !empty($this->rssfeedoutput) )
	{ 
		//echo $this->loadTemplate('rssfeed');
    echo $this->loadTemplate('rssfeed-table');
	}
  
	if ($this->config['show_matchday_pagenav']==1 || $this->config['show_matchday_pagenav']==3)
	{
		echo $this->loadTemplate('pagnav');
	}
	/*
	if ($this->config['show_results_ranking'])
	{
		$this->_addPath( 'template', JPATH_COMPONENT . DS . 'views' . DS . 'ranking' . DS . 'tmpl' );
		echo $this->loadTemplate('ranking');
		echo $this->loadTemplate('colorlegend');
		echo $this->loadTemplate('manipulations');
	}
	*/

	echo "<div>";
		echo $this->loadTemplate('backbutton');
		echo $this->loadTemplate('footer');
	echo "</div>";
	?>
</div>

<?php
if (JComponentHelper::getParams( 'com_joomleague' )->get( 'show_debug_info', 0 ))
{
	echo '<!-- DEBUG output var test START\n\n';
		echo '<br />this->config<pre>~' . print_r( $this->config, true ) . '~</pre><br />';
	echo '\n\nDEBUG output var test END -->';
}
?>