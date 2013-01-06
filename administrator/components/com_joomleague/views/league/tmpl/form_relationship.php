<?php 
defined('_JEXEC') or die('Restricted access');
?>

<fieldset class="adminform">
<legend><?php echo JText::_( 'JL_ADMIN_LEAGUE_RELATIONSHIP' );?>
</legend>
<table class="admintable">

<?php 
if ( $this->lists['promotion_to'] )
{
?>
<tr>
<td valign="top" align="right" class="key"><?php echo JText::_('JL_ADMIN_LEAGUE_PROMOTION_TO'); ?></td>
<td><?php echo $this->lists['promotion_to']; ?></td>
</tr>
<?php 
}

if ( $this->lists['relegation_to'] )
{
?>        
<tr>
<td valign="top" align="right" class="key"><?php echo JText::_('JL_ADMIN_LEAGUE_RELEGATION_TO'); ?></td>
<td><?php echo $this->lists['relegation_to']; ?></td>
</tr>
<?php 
}
?>                			
</table>
</fieldset>			