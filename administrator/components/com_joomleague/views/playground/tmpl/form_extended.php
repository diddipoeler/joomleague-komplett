<?php defined('_JEXEC') or die('Restricted access');

foreach ($this->extended->getGroups() as $group => $groups)
{
	$params=$this->extended->getElements($group);
	$gname=(strtolower($group) == '_default') ? JText::_('General') : $group;
	?>
	<fieldset class="adminform">
		<legend><?php echo JText::_($gname); ?></legend>
		<?php
		foreach ($this->extended->getGroups() as $key => $groups)
		{
			// render is defined in joomla\libraries\joomla\html\parameter.php
			echo $this->extended->render('extended',$key);
		}
		?>
	</fieldset>
	<?php
}
?>