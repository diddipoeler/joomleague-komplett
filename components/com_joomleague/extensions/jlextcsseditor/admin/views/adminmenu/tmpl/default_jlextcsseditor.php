<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php
//this is an example menu for an extension

	$imagePath='administrator/components/com_joomleague/assets/images/';
	// active pane selector
	switch (JRequest::getVar('view'))
	{
		case 'jlextdfbkey':	$active=count($this->tabs);
		break;
		default: $active=count($this->tabs);
	}
	
	$pane=new stdClass();
	$pane->id = 'ExtensionDFBKEY';
	$pane->title=JText::_('JL_T_MENU_CSSXML_EDITOR');
	$pane->name='ExtMenuExtensionDFBKEY';
	$pane->alert=false;
	$tabs[]=$pane;
	
	$link5=array();
	$label5=array();
	$limage5=array();
	$link5[]=JRoute::_('index.php?option=com_joomleague&editor=CSS&view=jlextcsseditor&controller=jlextcsseditor&active='.$active);
	$label5[]=JText::_('JL_T_MENU_CSS_EDITOR');
	$limage5[]=JHTML::_('image',$imagePath.'icon-16-FrontendSettings.png',JText::_('JL_T_MENU_CSS_EDITOR'));
	
	$link[]=$link5;
	$label[]=$label5;
	$limage[]=$limage5;
	
	$link5=array();
	$label5=array();
	$limage5=array();
	$link5[]=JRoute::_('index.php?option=com_joomleague&editor=XML&view=jlextcsseditor&controller=jlextcsseditor&active='.$active);
	$label5[]=JText::_('JL_T_MENU_XML_EDITOR');
	$limage5[]=JHTML::_('image',$imagePath.'icon-16-FrontendSettings.png',JText::_('JL_T_MENU_XML_EDITOR'));
	
	$link[]=$link5;
	$label[]=$label5;
	$limage[]=$limage5;
	
	
	
	$n=0;
	
	$pane =& JPane::getInstance('sliders', array('allowAllClose' => true, 
								'startOffset' => $active, 
								'startTransition' => true, 
								'alwaysHide'=>false));
	echo $pane->startPane("extpaneExtensionDFBKEY");
	foreach ($tabs as $tab)
	{
		$title=JText::_($tab->title);
		echo $pane->startPanel($title, $tab->id);
		?>
		<div style="float: left;">
			<table><?php
			for ($h=0;$h < sizeof($link); $h++)
        {
				for ($i=0;$i < count($link[$n]); $i++)
				{
					?><tr><td><b><a href="<?php echo $link[$n][$i]; ?>" title="<?php echo JText::_($label[$n][$i]); ?>">
							<?php echo $limage[$n][$i].' '.JText::_($label[$n][$i]); ?>
					</a></b></td></tr><?php
				}
				$n++;
				}
				?></table>
		</div>
		<?php
		echo $pane->endPanel();
		$n++;
	}
	echo $pane->endPane();

?>
