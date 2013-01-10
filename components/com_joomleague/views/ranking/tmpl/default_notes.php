<?php 
defined( '_JEXEC' ) or die( 'Restricted access' );
?>

<div>
<fieldset>
<legend>
<strong>
<?php echo JText::_('JL_RANKING_NOTES'); ?>
</strong>
</legend>
    <table width="96%" align="center" border="2" cellpadding="0" cellspacing="0">
        <tr>
            <td align="left">
                <br />
                <?php 
                echo $this->project->notes;
                ?>
        </td>
            </tr>
    </table>
</fieldset>
</div> 