<?php 
defined('_JEXEC') or die('Restricted access');

//echo '<pre>',print_r($this->userfields,true),'</pre><br>';

?>

<fieldset class="adminform">
<legend>
<?php
echo JText::_('JL_ADMIN_CLUB_EDIT_USERFIELDS');
?>
</legend>



<table class='admintable'>
<?php
foreach( $this->userfields as $field )
{
$fieldname = $field->fieldname;    
?>
<tr>
<td width="20%" class="key" style="text-align:right; vertical-align:top;" >
<label for="<?php echo $field->fieldname; ?>"><?php echo JText::_($field->description); ?></label>
</td>
<td style="text-align:left; vertical-align:top;" >
<?PHP
SWITCH($field->fieldtype) 
{
CASE 'date':
CASE 'birthdate':
CASE 'dateselect':
CASE 'dateselectrange':
$cType='DATE';
$lists[$fieldname]=JHTML::calendar(JoomleagueHelper::convertDate($this->club->$fieldname),$fieldname,$fieldname,'%d-%m-%Y');
?>
<td style="text-align:left; vertical-align:top;" ><?php echo $lists[$fieldname]; ?></td>
<?PHP
break;
CASE 'editorta':
CASE 'textarea':
CASE 'multiselect':
CASE 'multicheckbox':
$cType='MEDIUMTEXT';
?>
<input	class="text_area" type="text" name="<?php echo $field->fieldname; ?>" id="title" size="55"
maxlength="20" value="<?php echo $this->club->$fieldname ?>" />
<?PHP
break;
CASE 'checkbox':
$cType='TINYINT';
?>
<input	class="text_area" type="text" name="<?php echo $field->fieldname; ?>" id="title" size="55"
maxlength="20" value="<?php echo $this->club->$fieldname ?>" />
<?PHP
break;
CASE 'numericfloat':
$cType='FLOAT';
?>
<input	class="text_area" type="text" name="<?php echo $field->fieldname; ?>" id="title" size="55"
maxlength="20" value="<?php echo $this->club->$fieldname ?>" />
<?PHP
break;
CASE 'numericint':
$cType='INT';
?>
<input	class="text_area" type="text" name="<?php echo $field->fieldname; ?>" id="title" size="55"
maxlength="20" value="<?php echo $this->club->$fieldname ?>" />
<?PHP
break;
CASE 'VARCHAR':
$cType='VARCHAR';
?>
<input	class="text_area" type="text" name="<?php echo $field->fieldname; ?>" id="title" size="55"
maxlength="20" value="<?php echo $this->club->$fieldname ?>" />
<?PHP
break;

}

?>



</td>
</tr>
<?php                    
}
?>
</table>
</fieldset>            