<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

    <table class="contentpaneopen" width="100%">
    <tbody>
	<tr>
	    <td class="contentheading"><?php echo JText::_('JL_STATS_ATTENDANCE_RANKING'); ?></td>
	</tr>
    </tbody>
    </table>

        <br />
        <div style="<?php // echo $show_att_ranking;?>float:left;width:96%;clear:both;margin:0px 0 25px 0">
        <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">

            <tr>
                <td class="sectiontableheader" style="width:6px;"></td>
                <td class="sectiontableheader" style="width:25%;">
                <?php
        JoomleagueHTML::printColumnHeadingSort(JText::_('JL_STATS_ATTENDANCE_RANKING_TEAM'), "name", null, "ASC");
        ?>
                </td>
                <td class="sectiontableheader" style="width:3%;text-align:center;">
                <?php
        echo JText::_('JL_STATS_ATTENDANCE_RANKING_MATCHES');
        ?>
                </td>
                <td class="sectiontableheader" style="width:16%;text-align:right;">
                <?php
        JoomleagueHTML::printColumnHeadingSort(JText::_('JL_STATS_ATTENDANCE_RANKING_TOTAL'), "totalattend", null);
        ?>
                </td>
                <td class="sectiontableheader" style="width:16%;text-align:right;">
                <?php
        JoomleagueHTML::printColumnHeadingSort(JText::_('JL_STATS_ATTENDANCE_RANKING_AVG'), "avgattend", null);
        ?>
                </td>
                <td class="sectiontableheader" style="width:19%;text-align:right;">
                <?php
        JoomleagueHTML::printColumnHeadingSort(JText::_('JL_STATS_ATTENDANCE_RANKING_CAPACITY'), "capacity", null);
        ?>
                </td>
                <td class="sectiontableheader" style="width:20%;text-align:right;">
                <?php
        JoomleagueHTML::printColumnHeadingSort(JText::_('JL_STATS_ATTENDANCE_RANKING_UTILISATION'), "utilisation", null);
        ?>
                </td>
            </tr>
            <?php

                //reorder table according to criteria
                if (isset($_REQUEST['order'])) {
                    switch ($_REQUEST['order']) {
                    case 'name':
                        usort($this->attendanceranking, array("JoomleagueModelStats", "teamNameCmp2"));
                        break;
                    case 'totalattend':
                        usort($this->attendanceranking, array("JoomleagueModelStats", "totalattendCmp"));
                        break;
                    case 'avgattend':
                        usort($this->attendanceranking, array("JoomleagueModelStats", "avgattendCmp"));
                        break;
                    case 'capacity':
                        usort($this->attendanceranking, array("JoomleagueModelStats", "capacityCmp"));
                        break;
                    case 'utilisation':
                        usort($this->attendanceranking, array("JoomleagueModelStats", "utilisationCmp"));
                        break;
                    }

                    if ($_REQUEST['dir'] == 'DESC') {
                        $this->attendanceranking = array_reverse($this->attendanceranking, false);
                    }
                }

              $k = 0;
              $favteam = explode(",", $this->project->fav_team);

                for ($i = 0, $n = count($this->attendanceranking); $i < $n; $i++) {
                    $row   = $this->attendanceranking[$i];
                    $color = '';

                    if (in_array($this->attendanceranking[$i]->teamid, $favteam)) {
                        if (trim($this->project->fav_team_color) != "") {
                            $color = 'background-color:'.$this->project->fav_team_color.';';
                        }
                    }
                ?>
            <tr
                class="<?php echo ($k == 0)? 'sectiontableentry1' : 'sectiontableentry2'; ?>">
                <td style="width:6px;text-align:right;<?php echo $color;?>"><b><?php echo $i+1;?></b></td>
                <td style="width:22%;<?php echo $color;?>"><?php echo $row->team;?></td>
                <td style="width:3%;text-align:center;<?php echo $color;?>"><?php if ($row->avgspectatorspt>0) echo round($row->sumspectatorspt / $row->avgspectatorspt);else echo '-';?></td>
                <td style="width:16%;text-align:right;<?php echo $color;?>"><?php echo $row->sumspectatorspt;?></td>
                <td style="width:15%;text-align:right;<?php echo $color;?>"><?php echo round($row->avgspectatorspt,0);?></td>
                <td style="width:19%;text-align:right;<?php echo $color;?>"><?php if ($row->capacity>0) echo $row->capacity; else echo '-';?></td>
                <td style="width:20%;text-align:right;<?php echo $color;?>"><?php if ($row->capacity>0) echo round(($row->avgspectatorspt / $row->capacity)*100)."%";else echo '-';?></td>
            </tr>
                <?php
                $k = 1 - $k;

            }
            ?>
        </table>
        </div>


