<?php 
defined('_JEXEC') or die('Restricted access');

//echo '<pre>',print_r($this->userfields,true),'</pre><br>';

?>
<div class="no-column">
<div class="contentpaneopen">
<div class="contentheading">
<?php echo JText::_('JL_CLUB_USERFIELDS'); ?>
</div>
		

<fieldset class="adminform">
<legend>
<?php
echo JText::_('JL_CLUB_USERFIELDS_2');
?>
</legend>


<table class='admintable'>
<div class="">
<?php
foreach( $this->userfields as $field )
{
$fieldname = $field->fieldname;    
?>
<tr>
<td width="" class="key" style="text-align:left; vertical-align:top;" >
<label for="<?php echo $field->fieldname; ?>"><?php echo JText::_($field->description); ?></label>
</td>
<td style="text-align:left; vertical-align:top;" >
<?php echo $this->club->$fieldname ?>
</td>
</tr>
<?php                    
}
?>
</div>
</table>
</fieldset>  
</div>
</div>            