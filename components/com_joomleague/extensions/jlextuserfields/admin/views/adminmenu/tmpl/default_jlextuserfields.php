<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php
//this is an example menu for an extension

//$this->jltables;


	$imagePath='administrator/components/com_joomleague/assets/images/';
	// active pane selector
	  $active=count($this->tabs);	
    //$active=$this->active;
    
	switch (JRequest::getVar('view'))
	{
  	case 'jlextuserfields':	$active;
		break;
		default: $active;
	}
	
	$pane=new stdClass();
	$pane->id = 'Extensionjlextuserfields';
	$pane->title=JText::_('JL_T_MENU_USER_FIELDS');
	$pane->name='ExtMenuExtensionLMOIMPORT';
	$pane->alert=false;
	$tabs[]=$pane;

	$link5=array();
	$label5=array();
	$limage5=array();
  	
	foreach ( $this->jltables as $row )
	{
  $link5[]=JRoute::_('index.php?option=com_joomleague&view=jlextuserfields&active='.$active.'&jltableid='.$row->id);
	$label5[]=JText::sprintf('JL_ADMIN_USER_FIELDS_TABLE',$row->tablename);
	$limage5[]=JHTML::_('image',$imagePath.'icon-16-FrontendSettings.png',JText::_('JL_ADMIN_USER_FIELDS_TABLE'));
  }
  

	
	
	$link[]=$link5;
	$label[]=$label5;
	$limage[]=$limage5;
	
	
	$n=0;
	
	$pane =& JPane::getInstance('sliders', array('allowAllClose' => true, 
								'startOffset' => $active, 
								'startTransition' => true, 
								'alwaysHide'=>false));
	echo $pane->startPane("extpaneExtensionLMOIMPORT");
	foreach ($tabs as $tab)
	{
		$title=JText::_($tab->title);
		echo $pane->startPanel($title, $tab->id);
		?>
		<div style="float: left;">
			<table><?php
				for ($i=0;$i < count($link[$n]); $i++)
				{
					?><tr><td><b><a href="<?php echo $link[$n][$i]; ?>" title="<?php echo JText::_($label[$n][$i]); ?>">
							<?php echo $limage[$n][$i].' '.JText::_($label[$n][$i]); ?>
					</a></b></td></tr><?php
				}
				?></table>
		</div>
		<?php
		echo $pane->endPanel();
		$n++;
	}
	echo $pane->endPane();

?>
