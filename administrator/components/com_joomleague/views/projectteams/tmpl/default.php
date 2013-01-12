<?php defined('_JEXEC') or die('Restricted access');
jimport('joomla.filesystem.file');
JHTML::_('behavior.tooltip');

// Set toolbar items for the page
JToolBarHelper::title(JText::_('JL_ADMIN_PROJECTTEAMS_TITLE'),'Teams');

JToolBarHelper::apply('saveshort');
JToolBarHelper::custom('changeteams','move.png','move_f2.png',JText::_('JL_ADMIN_PROJECTTEAMS_BUTTON_CHANGE_TEAMS'),false);
JToolBarHelper::custom('editlist','upload.png','upload_f2.png',JText::_('JL_ADMIN_PROJECTTEAMS_BUTTON_ASSIGN'),false);
JToolBarHelper::custom('copy','copy','copy', JText::_('JL_GLOBAL_COPY'), true);
JToolBarHelper::divider();

//JToolBarHelper::back('Back',JRoute::_('index.php?option=com_joomleague&controller=cpanel&task=workspace&layout=panel'));
JToolBarHelper::help('screen.joomleague',true);

//Ordering allowed ?
$ordering=($this->lists['order'] == 't.name');

//load navigation menu
$this->addTemplatePath(JPATH_COMPONENT.DS.'views'.DS.'adminmenu');

?>
<script language="javascript">

	function searchTeam(val,key)
	{
		var f=document.adminForm;
		if(f)
		{
		f.elements['search'].value=val;
		f.elements['search_mode'].value= 'matchfirst';
		f.submit();
		}
	}

	var quickaddsearchurl = '<?php echo JURI::root();?>administrator/index.php?option=com_joomleague&controller=quickadd&task=searchteam&project_id=<?php echo $this->projectws->id; ?>';
	
</script>
<fieldset class="adminform">
	<legend>
	<?php
	echo JText::_('JL_ADMIN_PROJECTTEAMS_QUICKADD_TEAM');
	?>
	</legend>
	<form name="quickaddForm" action="<?php echo JRoute::_(JURI::root().'administrator/index.php?option=com_joomleague&controller=quickadd&task=addteam'); ?>" method="post">
	<input type="hidden" name="project_id" id="project_id" value="<?php echo $this->projectws->id; ?>" />
	<input type="hidden" id="cteamid" name="cteamid" value="">
	<table>
		<tr>
			<td><?php echo JText::_('JL_ADMIN_PROJECTTEAMS_QUICKADD_DESCR'); ?></td>
			<td><input type="text" name="quickadd" id="quickadd" size="50" /></td>
			<td><input type="submit" name="submit" id="submit" value="<?php echo JText::_('JL_GLOBAL_ADD');?>" /></td>
		</tr>
	</table>
	<?php echo JHTML::_('form.token')."\n"; ?>
	</form>
</fieldset>
<form action="<?php echo $this->request_url; ?>" method="post" name="adminForm">
	<div id="editcell">
		<fieldset class="adminform">
			<legend><?php echo JText::sprintf('JL_ADMIN_PROJECTTEAMS_LEGEND','<i>'.$this->projectws->name.'</i>'); ?></legend>
			<?php $cell_count=22; ?>
			<table class="adminlist">
				<thead>
					<tr>
						<th width="5" style="vertical-align: top; "><?php echo JText::_('JL_GLOBAL_NUM'); ?></th>
						<th width="20" style="vertical-align: top; ">
							<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->projectteam); ?>);" />
						</th>
						<th width="20" style="vertical-align: top; ">&nbsp;</th>
						<th class="title" nowrap="nowrap" style="vertical-align:top; ">
							<?php echo JHTML::_('grid.sort','JL_ADMIN_PROJECTTEAMS_TEAMNAME','t.name',$this->lists['order_Dir'],$this->lists['order']); ?>
							<a href="mailto:<?php
											$first_dest=1;
											foreach ($this->projectteam as $r)
											{
												if (($r->club_id) > 0 and strlen($r->club_email) > 0)
												{
													if (!$first_dest)
													{
														echo ",%20".str_replace(" ","%20",$r->club_email);
													}
													else
													{
														$first_dest=0;
														echo str_replace(" ","%20",$r->club_email);
													}
												}
											}
											?>?subject=[<?php echo $mainframe->getCfg('sitename'); ?>]">
								<?php
								$imageFile='administrator/components/com_joomleague/assets/images/mail.png';
								$imageTitle=JText::_('JL_ADMIN_PROJECTTEAMS_SEND_MAIL_TEAMS');
								$imageParams='title= "'.$imageTitle.'"';
								$image=JHTML::image($imageFile,$imageTitle,$imageParams);
								$linkParams='';
								//echo JHTML::link($link3,$image);
								echo $image;
								?>
							</a>
						</th>
						<th colspan="2" style="vertical-align:top; "><?php echo JText::_('JL_ADMIN_PROJECTTEAMS_MANAGE_PERSONNEL'); ?></th>
						<th style="vertical-align:top; ">
							<?php echo JHTML::_('grid.sort','JL_ADMIN_PROJECTTEAMS_ADMIN','tl.admin',$this->lists['order_Dir'],$this->lists['order']); ?>
							<a href="mailto:<?php
											$first_dest=1;
											foreach ($this->projectteam as $r)
											{
												if (strlen($r->editor) > 0 and strlen($r->email) > 0)
												{
													if (!$first_dest)
													{
														echo ",%20".str_replace(" ","%20",$r->email);
													}
													else
													{
														$first_dest=0;
														echo str_replace(" ","%20",$r->email);
													}
												}
											}
											?>?subject=[<?php echo $mainframe->getCfg('sitename'); ?>]">
								<?php
								$imageFile='administrator/components/com_joomleague/assets/images/mail.png';
								$imageTitle=JText::_('JL_ADMIN_PROJECTTEAMS_SEND_MAIL_ADMINS');
								$imageParams='title= "'.$imageTitle.'"';
								$image=JHTML::image($imageFile,$imageTitle,$imageParams);
								$linkParams='';
								//echo JHTML::link($link3,$image);
								echo $image;
								?></a>
						</th>						<?php
						if ($this->projectws->project_type == 'DIVISIONS_LEAGUE')
						{
							$cell_count++;
							?><th class="title" style="vertical-align:top; " nowrap="nowrap">
								<?php echo JHTML::_('grid.sort','JL_ADMIN_PROJECTTEAMS_DIVISION','d.name',$this->lists['order_Dir'],$this->lists['order']); 
									echo '<br>'.JHTML::_(	'select.genericlist',
														$this->lists['divisions'],
														'division',
														'class="inputbox" size="1" onchange="window.location.href=window.location.href.split(\'&division=\')[0]+\'&division=\'+this.value"',
														'value','text', $this->division);
								?>
							</th><?php
						}
						?>
						<th style="vertical-align:top;white-space:nowrap;">
							<?php echo JHTML::_('grid.sort','JL_ADMIN_PROJECTTEAMS_PICTURE','tl.picture',$this->lists['order_Dir'],$this->lists['order']); ?>
						</th>
                        <th class="title" style="vertical-align:top; "><?php echo JText::_('JL_ADMIN_PROJECTTEAMS_USE_FINAL_POINTS'); ?></th>
                        <th class="title" style="vertical-align:top; "><?php echo JText::_('JL_ADMIN_PROJECTTEAMS_IS_IN_SCORE'); ?></th>
                        
						<th class="title" style="vertical-align:top; "><?php echo JText::_('JL_ADMIN_PROJECTTEAMS_INITIAL_POINTS'); ?></th>
						<th class="title" style="vertical-align:top; "><?php echo JText::_('JL_ADMIN_PROJECTTEAMS_MA'); ?></th>						
						<th class="title" style="vertical-align:top; "><?php echo JText::_('JL_ADMIN_PROJECTTEAMS_PLUS_P'); ?></th>
						<th class="title" style="vertical-align:top; "><?php echo JText::_('JL_ADMIN_PROJECTTEAMS_MINUS_P'); ?></th>
						<th class="title" style="vertical-align:top; "><?php echo JText::_('JL_ADMIN_PROJECTTEAMS_W'); ?></th>
						<th class="title" style="vertical-align:top; "><?php echo JText::_('JL_ADMIN_PROJECTTEAMS_D'); ?></th>
						<th class="title" style="vertical-align:top; "><?php echo JText::_('JL_ADMIN_PROJECTTEAMS_L'); ?></th>
						<th class="title" style="vertical-align:top; "><?php echo JText::_('JL_ADMIN_PROJECTTEAMS_HG'); ?></th>
						<th class="title" style="vertical-align:top; "><?php echo JText::_('JL_ADMIN_PROJECTTEAMS_GG'); ?></th>
						<th class="title" style="vertical-align:top; "><?php echo JText::_('JL_ADMIN_PROJECTTEAMS_DG'); ?></th>
						<th width="1%" class="title" style="vertical-align:top; ">
							<?php echo JHTML::_('grid.sort','TID','team_id',$this->lists['order_Dir'],$this->lists['order']); ?>
						</th>
						<th width="1%" class="title" style="vertical-align:top; ">
							<?php echo JHTML::_('grid.sort','JL_GLOBAL_ID','tl.id',$this->lists['order_Dir'],$this->lists['order']); ?>
						</th>
					</tr>
				</thead>
				<tfoot><tr><td colspan="<?php echo $cell_count; ?>"><?php echo $this->pagination->getListFooter(); ?></td></tr></tfoot>
				<tbody>
					<?php
					$k=0;
					for ($i=0, $n=count($this->projectteam); $i < $n; $i++)
					{
						$row = &$this->projectteam[$i];
						$link1=JRoute::_('index.php?option=com_joomleague&controller=projectteam&task=edit&cid[]='.$row->id);
						$link2=JRoute::_('index.php?option=com_joomleague&controller=teamplayer&task=select&project_team_id='.$row->id."&team_id=".$row->team_id);
						$link3=JRoute::_('index.php?option=com_joomleague&controller=teamstaff&task=select&project_team_id='.$row->id."&team_id=".$row->team_id);
						$checked=JHTML::_('grid.checkedout',$row,$i);
						?>
						<tr class="<?php echo "row$k"; ?>">
							<td style="text-align:center; "><?php echo $this->pagination->getRowOffset($i); ?></td>
							<td style="text-align:center;"><?php echo $checked;?></td>
							<?php
							if (JTable::isCheckedOut($this->user->get('id'),$row->checked_out))
							{
								$inputappend=' disabled="disabled"';
								?><td style="text-align:center; ">&nbsp;</td><?php
							}
							else
							{
								$inputappend='';
								?>
								<td style="text-align:center; "><?php
									$imageFile='administrator/components/com_joomleague/assets/images/edit.png';
									$imageTitle=JText::_('JL_ADMIN_PROJECTTEAMS_EDIT_DETAILS');
									$imageParams='title= "'.$imageTitle.'"';
									$image=JHTML::image($imageFile,$imageTitle,$imageParams);
									$linkParams='';
									echo JHTML::link($link1,$image);
									?></td>
								<?php
							}
							?>
							<td><?php echo $row->name; ?></td>
							<td style="text-align:center;"><?php
								if($row->playercount==0) {
									$image = "players_add.png";
								} else {
									$image = "players_edit.png";
								}
								$imageFile='administrator/components/com_joomleague/assets/images/'.$image;
								$imageTitle=JText::_('JL_ADMIN_PROJECTTEAMS_MANAGE_PLAYERS');
								$imageParams='title= "'.$imageTitle.'"';
								$image=JHTML::image($imageFile,$imageTitle,$imageParams).' <sub>'.$row->playercount.'</sub>';
								$linkParams='';
								echo JHTML::link($link2,$image);
								?></td>
							<td style="text-align:center;"><?php
								if($row->staffcount==0) {
									$image = "players_add.png";
								} else {
									$image = "players_edit.png";
								}
								$imageFile='administrator/components/com_joomleague/assets/images/'.$image;
								$imageTitle=JText::_('JL_ADMIN_PROJECTTEAMS_MANAGE_STAFF');
								$imageParams='title= "'.$imageTitle.'"';
								$image=JHTML::image($imageFile,$imageTitle,$imageParams).' <sub>'.$row->staffcount.'</sub>';
								$linkParams='';
								echo JHTML::link($link3,$image);
								?></td>
							<td style="text-align:center;"><?php echo $row->editor; ?></td>
							<?php
							if ($this->projectws->project_type == 'DIVISIONS_LEAGUE')
							{
								?>
								<td nowrap="nowrap" style="text-align:center;">
									<?php
									$append='';
									if ($row->division_id == 0)
									{
										$append=' style="background-color:#bbffff"';
									}
									echo JHTML::_(	'select.genericlist',
													$this->lists['divisions'],
													'division_id'.$row->id,
													$inputappend.'class="inputbox" size="1" onchange="document.getElementById(\'cb' .
													$i.'\').checked=true"'.$append,
													'value','text',$row->division_id);
									?>
								</td>
								<?php
							}
							?>
							<td width="5%" style="text-align:center;">
								<?php
								if (empty($row->picture) || !JFile::exists(JPATH_SITE.DS.$row->picture))
								{
									$imageTitle=JText::_('JL_ADMIN_PROJECTTEAMS_NO_IMAGE').$row->picture;
									echo JHTML::image(	'administrator/components/com_joomleague/assets/images/delete.png',
														$imageTitle,'title= "'.$imageTitle.'"');
								}
								elseif ($row->picture == JoomleagueHelper::getDefaultPlaceholder("team"))
								{
									$imageTitle=JText::_('JL_ADMIN_PROJECTTEAMS_DEFAULT_IMAGE');
									echo JHTML::image('administrator/components/com_joomleague/assets/images/information.png',
														$imageTitle,'title= "'.$imageTitle.'"');
								}
								else
								{
									$imageTitle=JText::_('JL_ADMIN_PROJECTTEAMS_CUSTOM_IMAGE');
									$imageParams=array();
									$imageParams['title']=$imageTitle ;
									$imageParams['height']=30;
									//$imageParams['width'] =40;
									echo JHTML::image($row->picture,$imageTitle,$imageParams);
								}
								?>
							</td>
                            
                            <td>
                            <?php
                            $append = '';
                            //echo JHTML::_('select.genericlist', $this->noyes, 'use_finally'.$row->id, 'class="inputbox" size="1" '.$append, 'value', 'text', $row->use_finally );
                            echo JHTML::_(	'select.genericlist',
													$this->noyes,
													'use_finally'.$row->id,
													$inputappend.'class="inputbox" size="1" onchange="document.getElementById(\'cb' .
													$i.'\').checked=true"'.$append,
													'value','text',$row->use_finally);
                            ?>
                            </td>
                            <td>
                            <?php
                            $append = '';
                            //echo JHTML::_('select.genericlist', $this->noyes, 'is_in_score'.$row->id, 'class="inputbox" size="1" '.$append, 'value', 'text', $row->is_in_score );
                            echo JHTML::_(	'select.genericlist',
													$this->noyes,
													'is_in_score'.$row->id,
													$inputappend.'class="inputbox" size="1" onchange="document.getElementById(\'cb' .
													$i.'\').checked=true"'.$append,
													'value','text',$row->is_in_score);?>
                            </td>
                            
							<td style="text-align:center;">
								<input<?php echo $inputappend; ?>	type="text" size="1" class="inputbox"
																	name="start_points<?php echo $row->id; ?>"
																	value="<?php echo $row->start_points; ?>"
																	onchange="document.getElementById('cb<?php echo $i; ?>').checked=true" />
							</td>
							<td style="text-align:center;">
								<input<?php echo $inputappend; ?>	type="text" size="2" class="inputbox"
																	name="matches_finally<?php echo $row->id; ?>"
																	value="<?php echo $row->matches_finally; ?>"
																	onchange="document.getElementById('cb<?php echo $i; ?>').checked=true" />
							</td>							
							<td style="text-align:center;">
								<input<?php echo $inputappend; ?>	type="text" size="2" class="inputbox"
																	name="points_finally<?php echo $row->id; ?>"
																	value="<?php echo $row->points_finally; ?>"
																	onchange="document.getElementById('cb<?php echo $i; ?>').checked=true" />
							</td>
							<td style="text-align:center;">
								<input<?php echo $inputappend; ?>	type="text" size="2" class="inputbox"
																	name="neg_points_finally<?php echo $row->id; ?>"
																	value="<?php echo $row->neg_points_finally; ?>"
																	onchange="document.getElementById('cb<?php echo $i; ?>').checked=true" />
							</td>
							<td style="text-align:center;">
								<input<?php echo $inputappend; ?>	type="text" size="2" class="inputbox"
																	name="won_finally<?php echo $row->id; ?>"
																	value="<?php echo $row->won_finally; ?>"
																	onchange="document.getElementById('cb<?php echo $i; ?>').checked=true" />
							</td>
							<td style="text-align:center;">
								<input<?php echo $inputappend; ?>	type="text" size="2" class="inputbox"
																	name="draws_finally<?php echo $row->id; ?>"
																	value="<?php echo $row->draws_finally; ?>"
																	onchange="document.getElementById('cb<?php echo $i; ?>').checked=true" />
							</td>
							<td style="text-align:center;">
								<input<?php echo $inputappend; ?>	type="text" size="2" class="inputbox"
																	name="lost_finally<?php echo $row->id; ?>"
																	value="<?php echo $row->lost_finally; ?>"
																	onchange="document.getElementById('cb<?php echo $i; ?>').checked=true" />
							</td>
							<td style="text-align:center;">
								<input<?php echo $inputappend; ?>	type="text" size="2" class="inputbox"
																	name="homegoals_finally<?php echo $row->id; ?>"
																	value="<?php echo $row->homegoals_finally; ?>"
																	onchange="document.getElementById('cb<?php echo $i; ?>').checked=true" />
							</td>
							<td style="text-align:center;">
								<input<?php echo $inputappend; ?>	type="text" size="2" class="inputbox"
																	name="guestgoals_finally<?php echo $row->id; ?>"
																	value="<?php echo $row->guestgoals_finally; ?>"
																	onchange="document.getElementById('cb<?php echo $i; ?>').checked=true" />
							</td>
							<td style="text-align:center;">
								<input<?php echo $inputappend; ?>	type="text" size="2" class="inputbox"
																	name="diffgoals_finally<?php echo $row->id; ?>"
																	value="<?php echo $row->diffgoals_finally; ?>"
																	onchange="document.getElementById('cb<?php echo $i; ?>').checked=true" />
							</td>
							<td style="text-align:center;"><?php echo $row->team_id; ?></td>
							<td style="text-align:center;"><?php echo $row->id; ?></td>
						</tr>
						<?php
						$k=(1-$k);
					}
					?>
				</tbody>

			</table>
		</fieldset>
	</div>
	<input type="hidden" name="controller" value="projectteam" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order_Dir" value="" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="search_mode" value="<?php echo $this->lists['search_mode']; ?>" />
	<?php echo JHTML::_('form.token')."\n"; ?>
</form>