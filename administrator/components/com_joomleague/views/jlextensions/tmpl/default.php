<?php
/**
 * @copyright	Copyright (C) 2006-2009 JoomLeague.net. All rights reserved.
 * @license		GNU/GPL,see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License,and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.tooltip');



?>

<form action="<?php echo $this->request_url; ?>" method="post" name="adminForm">


<div id="editcell">
<fieldset class="adminform">
<legend>
<?php
echo JText::_('JL_ADMIN_MASTER_DELETE_EXTENSIONS');
?>
</legend>
</fieldset>
</div>
			
<table class="adminlist">
<thead>

<tr>
<th width="60" style="vertical-align: top; ">
<?php
echo JText::_('JL_ADMIN_MASTER_GIT_DELETE_JA');
?>
</th>
<th width="" style="vertical-align: top; ">
<?php
echo JText::_('JL_ADMIN_MASTER_GIT_EXTENSION');
?>
</th>
</tr>

</thead>
<?PHP
$i = 0;
if ( $this->jlextensions )
{
foreach ( $this->jlextensions as $key => $row)
{
echo "<tr>";  
?>
<td style="text-align:center;">
								<?php
								$checked = JHTML::_( 'grid.id', $i, $i );
								echo $checked;
								?>
						</td>
<input type="hidden" name="folder[]" value="extensions" />
<input type="hidden" name="folder_name[]" value="<?PHP echo $row;?>" />						
						<?php	             
echo "<td>".$row."</td>";
echo "</tr>";
$i++;
}
}
?>
</table>

<input type='hidden' name='sent' value='2' />
<input type='hidden' name='controller' value='jlextensions' />
<input type='hidden' name='task' value='jlextensionsdelete' />
<?php echo JHTML::_('form.token')."\n"; ?>
</form>