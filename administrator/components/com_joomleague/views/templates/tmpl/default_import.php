<?php defined('_JEXEC') or die('Restricted access'); ?>
<script type="text/javascript">
<!--
window.addEvent('domready', function()
{
	$('templateid').addEvent('change', function()
	{
		if (this.value)
		{
			$('importform').submit();
		}
	});
});
//-->
</script>
<div id="masterimport">
	<form action="<?php echo $this->request_url; ?>" method="post" name="importform" id="importform">
		<p class='helpText'><?php echo JText::sprintf('JL_ADMIN_TEMPLATES_MASTER_HINT_01','<span class="masterName" >'.$this->master.'</span>'); ?></p>
		<p class='helpText'><?php echo JText::_('JL_ADMIN_TEMPLATES_MASTER_HINT_02'); ?></p>
		<?php echo $this->lists['mastertemplates']; ?>
		<input type="hidden" name="project_id" value="<?php echo $this->projectws->id; ?>" />
		<input type="hidden" name="controller" value="template" />
		<input type="hidden" name="task" value="masterimport" />
		<?php echo JHTML::_('form.token')."\n"; ?>
	</form>
</div>