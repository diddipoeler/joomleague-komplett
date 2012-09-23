<?php 
defined('_JEXEC') or die('Restricted access');

// echo 'getGeoCoords result<br><pre>';
// print_r($this->address_geocode);
// echo '</pre><br>';

foreach ($this->extended->getGroups() as $group => $groups)
{
	$params=$this->extended->getElements($group);
	$gname=(strtolower($group) == '_default') ? JText::_('JL_ADMIN_CLUB_GENERAL') : $group;
	?>
	<fieldset class="adminform">
		<legend><?php echo JText::_($gname); ?> </legend>
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