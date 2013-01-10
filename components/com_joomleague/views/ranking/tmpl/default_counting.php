<?php 
defined( '_JEXEC' ) or die( 'Restricted access' );

$points = explode(",",$this->project->points_after_regular_time);
?>

<div>
<fieldset>
<legend>
<strong>
<?php echo JText::_('JL_RANKING_COUNTING'); ?>
</strong>
</legend>
    <table width="96%" align="center" border="2" cellpadding="0" cellspacing="0">
        <tr>
            <td align="left">
                <br />
                <?php 
                echo JText::sprintf(	'JL_RANKING_COUNTING_POINTS',
												'<i>' . $points[0] . '</i>',
                        '<i>' . $points[1] . '</i>',
                        '<i>' . $points[2] . '</i>' );
                ?>
        </td>
            </tr>
    </table>
</fieldset>
</div> 