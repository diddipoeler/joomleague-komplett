<?php 
defined('_JEXEC') or die('Restricted access');

if ( $this->show_debug_info )
{
echo 'this->rows<pre>',print_r($this->rows,true),'</pre><br>';
echo 'this->userfields<pre>',print_r($this->userfields,true),'</pre><br>';

}

// Show team-players as defined
if (!empty($this->rows))
{
	$k=0;
	$position='';
	$totalEvents=array();

	// Layout of the columns in the table
	//  1. Position number  (optional : $this->config['show_player_numbers'])
	//  2. Player picture   (optional : $this->config['show_player_icon'])
	//  3. Country flag     (optional : $this->config['show_country_flag'])
	//  4. Player name
	//  5. Injured/suspended/away icons
	//  6. Birthday         (optional : $this->config['show_birthday'])
	//  7. Games played     (optional : $this->overallconfig['use_jl_substitution'] && $this->config['show_games_played'])
	//  8. Starting line-up (optional : $this->overallconfig['use_jl_substitution'] && $this->config['show_substitution_stats'])
	//  9. In               (optional : $this->overallconfig['use_jl_substitution'] && $this->config['show_substitution_stats'])
	// 10. Out              (optional : $this->overallconfig['use_jl_substitution'] && $this->config['show_substitution_stats'])
	// 10. Event type       (optional : $this->config['show_events_stats'] && count($this->playereventstats) > 0,
	//                       multiple columns possible (depends on the number of event types for the position))
	// 11. Stats type       (optional : $this->config['show_stats'] && isset($this->stats[$row->position_id]),
	//                       multiple columns possible (depends on the number of stats types for the position))

	$positionHeaderSpan = 0;
	$totalcolspan = 0;
	if ($this->config['show_player_numbers'])
	{
		$positionHeaderSpan++;
		$totalcolspan++;
	}
	if ($this->config['show_player_icon'] || $this->config['show_staff_icon'])
	{
		$positionHeaderSpan++;
		$totalcolspan++;
	}
	if ($this->config['show_country_flag'] || $this->config['show_country_flag_staff'])
	{
		$positionHeaderSpan++;
		$totalcolspan++;
	}
	// Player name and injured/suspended/away columns are always there
	$positionHeaderSpan += 2;
	$totalcolspan       += 2;
	if ($this->config['show_birthday'] || $this->config['show_birthday_staff'])
	{
		$totalcolspan++;
	}
	if ($this->overallconfig['use_jl_substitution'])
	{
		if ($this->config['show_games_played'])
		{
			$totalcolspan++;
		}
		if ($this->config['show_substitution_stats'])
		{
			$totalcolspan += 3;
		}
	}
	?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="text-align: center;">
	<?php
	$position_count = array();
	foreach ($this->rows as $position_id => $players)
	{
		// position header
		$row=current($players);
		$position=$row->position;
		$k=0;
		?>
	<thead>
	<tr class="sectiontableheader rosterheader">
		<th width="60%" colspan="<?php echo $positionHeaderSpan; ?>">
			<?php echo '&nbsp;'.JText::_($row->position); ?>
		</th>
		<?php
		if ($this->config['show_birthday'] > 0)
		{ ?>
		<th class="td_c">
		  <?php
				switch ( $this->config['show_birthday'] )
				{
					case 	1:			// show Birthday and Age
						$outputStr = 'JL_PERSON_BIRTHDAY_AGE';
						break;

					case 	2:			// show Only Birthday
						$outputStr = 'JL_PERSON_BIRTHDAY';
						break;

					case 	3:			// show Only Age
						$outputStr = 'JL_PERSON_AGE';
						break;

					case 	4:			// show Only Year of birth
						$outputStr = 'JL_PERSON_YEAR_OF_BIRTH';
						break;
				}
				echo JText::_( $outputStr );
				?>
		</th>
		<?php
		}
		elseif ($this->config['show_birthday_staff'] > 0)
		{
			// Put empty column to keep vertical alignment with the staff table
			?>
		<th class="td_c">&nbsp;</th><?php
		}
		if ($this->overallconfig['use_jl_substitution']==1)
		{
			if ($this->config['show_games_played'])
			{ ?>
		<th class="td_c"><?php
				$imageTitle=JText::_('JL_ROSTER_PLAYED');
				echo JHTML::image(	'media/com_joomleague/event_icons/played.png',
				$imageTitle,array('title'=> $imageTitle,'height'=> 20));
		?></th>
			<?php 
			}
			if ($this->config['show_substitution_stats'])
			{ ?>
		<th class="td_c"><?php
				$imageTitle=JText::_('JL_ROSTER_STARTING_LINEUP');
				echo JHTML::image(	'media/com_joomleague/event_icons/startroster.png',
				$imageTitle,array('title'=> $imageTitle,'height'=> 20));
		?></th>
		<th class="td_c"><?php
				$imageTitle=JText::_('JL_ROSTER_IN');
				echo JHTML::image(	'media/com_joomleague/event_icons/in.png',
				$imageTitle,array('title'=> $imageTitle,'height'=> 20));
		?></th>
		<th class="td_c"><?php
				$imageTitle=JText::_('JL_ROSTER_OUT');
				echo JHTML::image(	'media/com_joomleague/event_icons/out.png',
				$imageTitle,array('title'=> $imageTitle,'height'=> 20));
		?></th>
			<?php
			}
		}
		if ($this->config['show_events_stats'])
		{
			if ($this->positioneventtypes)
			{
				if (isset($this->positioneventtypes[$row->position_id]) &&
					count($this->positioneventtypes[$row->position_id]))
				{
					$eventCounter=0;

					foreach ($this->positioneventtypes[$row->position_id] AS $eventtype)
					{
						if (empty($eventtype->icon))
						{
							$eventtype_header = JText::_($eventtype->name);
						}
						else
						{
							$iconPath=$eventtype->icon;
							if (!strpos(' '.$iconPath,'/'))
							{
								$iconPath='media/com_joomleague/event_icons/'.$iconPath;
							}
							$eventtype_header = JHTML::image(	$iconPath,
																JText::_($eventtype->name),
																array(	'title'=> JText::_($eventtype->name),
																		  'align'=> 'top',
																		  'hspace'=> '2'));
						}
						?>
		<th class="td_c">
			<?php echo $eventtype_header;?>
		</th>
						<?php
					}
				}
			}
		}
		if ($this->config['show_stats'] && isset($this->stats[$row->position_id]))
		{
			foreach ($this->stats[$row->position_id] as $stat)
			{
				if ($stat->showInRoster())
				{
				    if ($stat->position_id==$row->position_id)
				    {
					?>
		<th class="td_c"><?php echo $stat->getImage(); ?></th>
					<?php
				    }
				}
			}
		}
    
    // diddipoeler
    if ( $this->userfields )
    {
    foreach ($this->userfields as $userfield)
			{
      ?>
		<th class="td_l"><?php echo $userfield->description; ?></th>
			<?php
      }
    }
    
    
		?>
	</tr>
	</thead>
	<!-- end position header -->
	<!-- Players row-->
	<?php
	foreach ($players as $row)
	{
		?>
	<tr class="<?php echo ($k==0)? $this->config['style_class1'] : $this->config['style_class2']; ?>">
		<?php
		$pnr = ($row->position_number !='') ? $row->position_number : '&nbsp;';
		if ($this->config['show_player_numbers'])
		{
			if ($this->config['player_numbers_pictures'])
			{
				$value = JHTML::image('media/com_joomleague/event_icons/shirt.php?text='.$pnr,$pnr,array('title'=> $pnr));
			}
			else
			{
				$value = $pnr;
			}
			?>
		<td width="30" class="td_c"><?php echo $value;?></td><?php
		}
		$playerName = JoomleagueHelper::formatName(null, $row->firstname, 
													$row->nickname, 
													$row->lastname, 
													$this->config["name_format"]);
		if ($this->config['show_player_icon'])
		{
			$picture = $row->picture;
			if ((empty($picture)) || ($picture == JoomleagueHelper::getDefaultPlaceholder("player") ))
			{
				$picture = $row->ppic;
			}
			if ( !file_exists( $picture ) )
			{
				$picture = JoomleagueHelper::getDefaultPlaceholder("player");
			} 
      
      if ( !$this->config['show_highslide'] )
		{
      ?>
		<td width="40" class="td_c" nowrap="nowrap">
    <?php
			echo JoomleagueHelper::getPictureThumb($picture, $playerName,
													$this->config['player_picture_width'],
													$this->config['player_picture_height']);
			?>
			</td>
			<?php
			}
			else
			{
			?>
      <td width="40" class="td_c" nowrap="nowrap">
<a href="<?php echo $picture;?>" alt="<?php echo $playerName;?>" title="<?php echo $playerName;?>" class="highslide" onclick="return hs.expand(this)">
<img src="<?php echo $picture;?>" alt="<?php echo $playerName;?>" title="zum Zoomen anklicken" width="<?php echo $this->config['player_picture_width'];?>" height="<?php echo $this->config['player_picture_height'];?>"/></a>
			
		</td>
    <?php
    }
    
		}
		elseif ($this->config['show_staff_icon'])
		{ 
			// Put empty column to keep vertical alignment with the staff table
			?>
		<td width="40" class="td_c" nowrap="nowrap">&nbsp;</td><?php
		}
		if ($this->config['show_country_flag'])
		{ ?>
		<td width="16" nowrap="nowrap" style="text-align:center; ">
			<?php echo Countries::getCountryFlag($row->country);?>
		</td><?php
		}
		elseif ($this->config['show_country_flag_staff'])
		{
			// Put empty column to keep vertical alignment with the staff table
			?>
		<td width="16" nowrap="nowrap" style="text-align:center; ">&nbsp;</td><?php
		}
		?>
		<td class="td_l"><?php
		if ($this->config['link_player']==1)
		{
			$link=JoomleagueHelperRoute::getPlayerRoute($this->project->slug,$this->team->slug,$row->slug);
			echo JHTML::link($link,'<span class="playername">'.$playerName.'</span>');
		}
		else
		{
			echo '<span class="playername">'.$playerName.'</span>';
		}
		?></td>
		<td width="5%" style="text-align: left;" nowrap="nowrap">&nbsp; <?php
		$model =& $this->getModel();
		$this->assignRef('playertool',$model->getTeamPlayer($this->project->current_round,$row->playerid));
		if (!empty($this->playertool[0]->injury))
		{
			$imageTitle=JText::_('JL_PERSON_INJURED');
			echo JHTML::image(	'media/com_joomleague/event_icons/injured.gif',
								$imageTitle,array('title'=> $imageTitle,'height'=> 20));
		}
		if (!empty($this->playertool[0]->suspension))
		{
			$imageTitle=JText::_('JL_PERSON_SUSPENDED');
			echo JHTML::image(	'media/com_joomleague/event_icons/suspension.gif',
								$imageTitle,array('title'=> $imageTitle,'height'=> 20));
		}
		if (!empty($this->playertool[0]->away))
		{
			$imageTitle=JText::_('JL_PERSON_AWAY');
			echo JHTML::image(	'media/com_joomleague/event_icons/away.gif',
								$imageTitle,array('title'=> $imageTitle,'height'=> 20));
		}
		?></td>
		<?php
		if ($this->config['show_birthday'] > 0)
		{
			?>
		<td width="10%" nowrap="nowrap" style="text-align: center;"><?php
			if ($row->birthday !="0000-00-00")
			{
				switch ($this->config['show_birthday'])
				{
					case 1:	 // show Birthday and Age
						$birthdateStr = JHTML::date($row->birthday,JText::_('JL_GLOBAL_DAYDATE'));
						$birthdateStr.="&nbsp;(".JoomleagueHelper::getAge($row->birthday,$row->deathday).")";
						break;
					case 2:	 // show Only Birthday
						$birthdateStr = JHTML::date($row->birthday,JText::_('JL_GLOBAL_DAYDATE'));
						break;
					case 3:	 // show Only Age
						$birthdateStr = "(".JoomleagueHelper::getAge($row->birthday,$row->deathday).")";
						break;
					case 4:	 // show Only Year of birth
						$birthdateStr = JHTML::date($row->birthday,JText::_('%Y'));
						break;
					default:
						$birthdateStr = "";
						break;
				}
			}
			else
			{
				$birthdateStr="-";
			}
			// deathday
			if ( $row->deathday !="0000-00-00" )
			{
				$birthdateStr .= ' [ &dagger; '.JHTML::date($row->deathday,JText::_('JL_GLOBAL_DAYDATE')).']';
			}
					
			echo $birthdateStr;
		?>
		</td><?php
		}
		elseif ($this->config['show_birthday_staff'] > 0)
		{
			?>
		<td width="10%" nowrap="nowrap" style="text-align: left;">&nbsp;</td><?php
		}
		if ($this->overallconfig['use_jl_substitution'])
		{
			// Events of JL_substitutions are shown
			$model =& $this->getModel();
			$this->assignRef('InOutStat',$model->getInOutStats($row->pid));
			if (isset($this->InOutStat) && ($this->InOutStat->played > 0))
			{
				$played  = $this->InOutStat->played;
				$started = $this->InOutStat->started;
				$subIn   = $this->InOutStat->sub_in;
				$subOut  = $this->InOutStat->sub_out;
			}
			else
			{
				$played  = 0;
				$started = 0;
				$subIn   = 0;
				$subOut  = 0;
			}
			if ($this->config['show_games_played'])
			{
				?>
		<td class="td_c" nowrap="nowrap"><?php echo $played;?></td>
				<?php
			}
			if ($this->config['show_substitution_stats'])
			{
				?>
		<td class="td_c"><?php echo $started;?></td>
		<td class="td_c"><?php echo $subIn;?></td>
		<td class="td_c"><?php echo $subOut;?></td>
				<?php
			}
		}
		
    // diddipoeler
    $total_colspan = 0;
    if ($this->config['show_events_stats'] && count($this->playereventstats) > 0)
		{
			// user_defined events in the database are shown
			foreach ($this->playereventstats[$row->pid] AS $eventId=> $stat)
			{
				?>
		<td class="td_c"><?php
				if ($stat !='' && $stat > 0)
				{
					if (!isset($totalEvents[$eventId]))
					{
						$totalEvents[$eventId]=0;
					}
					$totalEvents[$eventId]=(int) $totalEvents[$eventId] + (int) $stat;
				}
				echo $stat;
				?>
		</td>
				<?php
				$total_colspan++;
			}
		}
		
		if ($this->config['show_stats'] && isset($this->stats[$row->position_id]))
		{
			foreach ($this->stats[$row->position_id] as $stat)
			{
			    if ($stat->showInRoster() && ($stat->position_id==$row->position_id))
				{
					if (isset($this->playerstats[$row->position_id][$stat->id][$row->pid]) &&
						isset($this->playerstats[$row->position_id][$stat->id][$row->pid]->value))
					{
						$value = $this->playerstats[$row->position_id][$stat->id][$row->pid]->value;
					}
					else
					{
						$value = $stat->formatZeroValue();
					}
					?>
		<td class="td_c" class="hasTip" title="<?php echo JText::_($stat->name); ?>">
			<?php echo $value; ?>
		</td>
					<?php
			    }
			}
		}
    
    // diddipoeler
    if ( $this->userfields )
    {
    foreach ($this->userfields as $userfield)
			{
      $fieldname = $userfield->fieldname;
      switch ($userfield->fieldtype)
      {
      case 'numericint';
      $userfield->count = $userfield->count + $row->$fieldname;
      if (!isset($position_count[$position_id][$fieldname]))
					{
						$position_count[$position_id][$fieldname]=0;
					}
      //$position_count[$position_id][$fieldname] = $position_count[$position_id][$fieldname] + $row->$fieldname;
      $position_count[$position_id][$fieldname] += $row->$fieldname;
      ?>
		<td class="td_r"><?php echo number_format($row->$fieldname,0, ",", "."); ?></td>
			<?php
      break;
      default:
      $userfield->count = 0;
      if (!isset($position_count[$position_id][$fieldname]))
					{
						$position_count[$position_id][$fieldname]=0;
					}
      $position_count[$position_id][$fieldname] = 0;
      ?>
		<td class="td_r"><?php echo $row->$fieldname; ?></td>
			<?php
      break;
      }
      
      }
    }
    
		?>
	</tr>
	<?php
	$k=(1-$k);
	}
	?>
	<!-- end players rows -->
	<!-- position totals -->
	<?php
	if ($this->config['show_totals'] && ($this->config['show_stats'] || $this->config['show_events_stats']))
	{
		?>
	<tr class='<?php echo ($k==0? 'sectiontableentry1' : 'sectiontableentry2').' totals'; ?>'>
		<td class="td_r" colspan="<?php echo $totalcolspan; ?>"><b><?php echo JText::_('JL_ROSTER_TOTAL'); ?></b></td>
		<?php
		if ($this->config['show_events_stats'])
		{
			if (isset($this->positioneventtypes[$row->position_id]))
			{
				foreach ($this->positioneventtypes[$row->position_id] AS $eventtype)
				{
					$value='0';
					if (array_key_exists($eventtype->eventtype_id,$totalEvents))
					{
						$value=$totalEvents[$eventtype->eventtype_id];
					}
					?>
		<td class="td_c"><?php echo $value;?></td>
					<?php
				}
			}
		}
		if ($this->config['show_stats'] && isset($this->stats[$row->position_id]))
		{
			foreach ($this->stats[$row->position_id] as $stat)
			{
			    if ($stat->showInRoster() && $stat->position_id==$row->position_id)
				{
					$value = $this->playerstats[$row->position_id][$stat->id]['totals']->value;
				}
				else
				{
					$value = $stat->formatZeroValue();
				}
					?>
		<td class="td_c"><?php echo $value; ?></td>
					<?php
			}
		}
		
    // diddipoeler
    if ( $this->userfields )
    {
    foreach ($this->userfields as $userfield)
			{
      $fieldname = $userfield->fieldname;
      switch ($userfield->fieldtype)
      {
      case 'numericint';
      $value = $position_count[$position_id][$fieldname];
      ?>
		<td class="td_r"><?php echo number_format($value,0, ",", "."); ?></td>
			<?php
      break;
      default:
      $value = 0;
      ?>
		<td class="td_r"><?php echo ''; ?></td>
			<?php
      break;
      }
      
      }
    }
    
    ?>

	</tr>
	<?php
	}
	?>
	<!-- total end -->
	<?php
	$k=(1-$k);
	}
	
	// diddipoeler
	// gesamtsumme der userfelder
if ( $this->show_debug_info )
{
echo 'this->position_count<pre>',print_r($position_count,true),'</pre><br>';

}

	?>
	<tr class='<?php echo ($k==0? 'sectiontableentry1' : 'sectiontableentry2').' totals'; ?>'>
	<td class="td_r" colspan="<?php echo $totalcolspan; ?>"><b><?php echo JText::_('JL_ROSTER_TOTAL'); ?></b></td>
	<?php
	
	for($a=0; $a <= $total_colspan; $a++)
	{
	?>
  <td class="td_r" colspan=""><b></b></td>
	<?php
  }
	
	
	$value = 0;
	if ( $this->userfields )
    {
    foreach ($this->userfields as $userfield)
			{
      $fieldname = $userfield->fieldname;
      switch ($userfield->fieldtype)
      {
      case 'numericint';
      foreach ($position_count as $key => $valuekey)
	    {
      $value += $position_count[$key][$fieldname];
      }
      break;
      default:
      $value = 0;
      break;
      }
      ?>
  <td class="td_r"><?php echo number_format($value,0, ",", "."); ?></td>
  <?PHP
      }
    }
	?>
  
	</tr>
	<?php
	
	?>
</table>
	<?php
}
?>