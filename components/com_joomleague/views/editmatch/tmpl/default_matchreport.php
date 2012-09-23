<?php defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<fieldset class="adminform">
	<legend><?php echo JText::_( 'JL_EDITMATCH_MATCHREPORT' ); ?></legend>
	<table border='0'>
		<tr>
			<td width="10%" nowrap="nowrap">
				<?php
				echo JText::_( 'JL_EDITMATCH_MATCHREPORT_SHOW' );
				?>
			</td>
			<td>
				<?php
				$showreport[] = JHTML::_( 'select.option', 0, JText::_( 'JL_GLOBAL_NO' ) );
				$showreport[] = JHTML::_( 'select.option', 1, JText::_( 'JL_GLOBAL_YES' ) );
				$showreportlist = JHTML::_(	'select.genericlist',
											$showreport,
											'show_report',
											'class="inputbox"',
											'value',
											'text',
											$this->match->show_report );
				echo $showreportlist;
				?>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<?php
				$editor =& JFactory::getEditor();
				$this->assignRef( 'editor', $editor );
				echo $this->editor->display( 'summary', $this->match->summary, '98%', '200', '50', '15', 'true' );
				?>
				<br />
				<!--
				<a id="control" href="" onclick="showeditor('summary', 'control');return false;">show editor</a>
				-->
			</td>
		</tr>
	</table>
</fieldset>
<div style="text-align:right; ">
	<input type="submit" value="<?php echo JText::_( 'JL_GLOBAL_SAVE' ); ?>">
</div><br />