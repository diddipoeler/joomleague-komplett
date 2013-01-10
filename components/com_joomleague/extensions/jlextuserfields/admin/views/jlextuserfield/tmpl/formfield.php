<?php 
defined('_JEXEC') or die('Restricted access'); 

//$edit	= JRequest::getVar( 'edit', true );
$edit	= JRequest::getVar( 'new', true );

if ($edit)
{
JToolBarHelper::title( JText::_( 'JL_ADMIN_USER_FIELDS_FIELDMANAGER_NEW' ), 'cbe-users' );
  JToolBarHelper::save();
	JToolBarHelper::cancel();
}
else
{
JToolBarHelper::title( JText::_( 'JL_ADMIN_USER_FIELDS_FIELDMANAGER_EDIT' ), 'cbe-users' );
	// for existing items the button is renamed `close` and the apply button is showed
	JToolBarHelper::apply();
	JToolBarHelper::cancel( 'cancel', 'Close' );
}

?>

<script language="javascript" type="text/javascript">
function prep4SQL(o)
{
	if(o.value!='') 
  {
		o.value=o.value.replace('jl_','');
		o.value='jl_' + o.value.replace(/[^a-zA-Z_]+/g,'');
	}
}

</script>
<form action="<?php echo $this->request_url; ?>" method="post" name="adminForm">

<fieldset class="adminform">
<legend>
<?php
echo JText::_( 'JL_ADMIN_USER_FIELDS_FIELDMANAGER' );
?>
</legend>
<table class="admintable">

<tr>
<td width="100" align="right" class="key">
<label for="name">
<?php
echo JText::_( 'JL_ADMIN_USER_FIELDS_TABLENAME' );
?>:
</label>
</td>
<td>
<input	class="text_area" type="text" name="tablename" id="title" size="100" maxlength="250"
value="<?php echo $this->userfield->tablename; ?>" />
</td>
</tr>

<tr>
<td width="100" align="right" class="key">
<label for="name">
<?php
echo JText::_( 'JL_ADMIN_USER_FIELDS_FIELDNAME' );
?>:
</label>
</td>
<td>
<input onchange="prep4SQL(this);"	class="text_area" type="text" name="fieldname" id="title" size="100" maxlength="250"
value="<?php echo $this->userfield->fieldname; ?>" />
</td>
</tr>

<tr>
<td width="100" align="right" class="key">
<label for="name">
<?php
echo JText::_( 'JL_ADMIN_USER_FIELDS_FIELDTYPE' );
?>:
</label>
</td>
<td>
<input	class="text_area" type="text" name="fieldtype" id="title" size="100" maxlength="250"
value="<?php echo $this->userfield->fieldtype; ?>" />
</td>
</tr>

<tr>
<td width="100" align="right" class="key">
<label for="name">
<?php
echo JText::_( 'JL_ADMIN_USER_FIELDS_FIELDLENGTH' );
?>:
</label>
</td>
<td>
<input	class="text_area" type="text" name="fieldlengh" id="title" size="100" maxlength="250"
value="<?php echo $this->userfield->fieldlengh; ?>" />
</td>
</tr>

<tr>
<td width="100" align="right" class="key">
<label for="name">
<?php
echo JText::_( 'JL_ADMIN_USER_FIELDS_FIELDVISIBLE' );
?>:
</label>
</td>
<td>
<input	class="text_area" type="text" name="visible" id="title" size="100" maxlength="250"
value="<?php echo $this->userfield->visible; ?>" />
</td>
</tr>

<tr>
<td width="100" align="right" class="key">
<label for="name">
<?php
echo JText::_( 'JL_ADMIN_USER_FIELDS_FIELDDESCRIPTION' );
?>:
</label>
</td>
<td>
<input	class="text_area" type="text" name="description" id="title" size="100" maxlength="250"
value="<?php echo $this->userfield->description; ?>" />
</td>
</tr>


</table>
</fieldset>

<input type="hidden" name="userfield" value="<?php echo $this->userfield->userfield; ?>" />
<input type="hidden" name="controller" value="jlextuserfields" />
<input type="hidden" name="cid[]"				value="<?php echo $this->userfield->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<?php echo JHTML::_('form.token')."\n"; ?>
</form>