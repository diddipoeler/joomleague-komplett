<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php
//this is an example menu for an extension

	$imagePath='administrator/components/com_joomleague/assets/images/';
	// active pane selector
	switch (JRequest::getVar('view'))
	{
		case 'jlextdfbnetplayerimport':	$active=count($this->tabs);
		break;
		default: $active=count($this->tabs);
	}
	
	$pane=new stdClass();
	$pane->id = 'ExtensionDFBNETPLAYERIMPORT';
	$pane->title=JText::_('JL_T_MENU_DFB_NET_IMPORT');
	$pane->name='ExtMenuExtensionDFBNETPLAYERLIMPORT';
	$pane->alert=false;
	$tabs[]=$pane;
	
	$link5=array();
	$label5=array();
	$limage5=array();
	$link5[]=JRoute::_('index.php?option=com_joomleague&view=jlextdfbnetplayerimport&active='.$active);
	$label5[]=JText::_('JL_T_MENU_DFB_NET_IMPORT');
	$limage5[]=JHTML::_('image',$imagePath.'icon-16-FrontendSettings.png',JText::_('JL_T_MENU_DFB_NET_IMPORT'));
	
	$link[]=$link5;
	$label[]=$label5;
	$limage[]=$limage5;
	
	
	$n=0;
	
	$pane =& JPane::getInstance('sliders', array('allowAllClose' => true, 
								'startOffset' => $active, 
								'startTransition' => true, 
								'alwaysHide'=>false));
	echo $pane->startPane("extpaneExtensionDFBNETPLAYERIMPORT");
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
