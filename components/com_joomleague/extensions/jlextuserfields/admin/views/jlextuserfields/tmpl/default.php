<?php 
defined('_JEXEC') or die('Restricted access'); 

//echo 'tabellenfelder<br><pre>',print_r($this->tablefields,true),'</pre><br>';

// echo 'Joomla root URI is ' . JURI::root() . "\n";
// echo 'Joomla root URI (path only) is ' . JURI::root( true ) . "\n";

JToolBarHelper::title( JText::_( 'JL_ADMIN_USER_FIELDS_FIELDMANAGER' ), 'cbe-fields' );
JToolBarHelper::custom( 'newField', 'new.png', 'new_f2.png', 'New Field', false );
JToolBarHelper::editList('editField');
JToolBarHelper::deleteList('The Field and all user data associated to this field will be lost and cannot be undone!','removeField');
JToolBarHelper::spacer();
JToolBarHelper::cancel();

?>


<form action="<?php echo $this->request_url; ?>" method="post" name="adminForm">

<div id="editcell">
<table class="adminlist">
<thead>
<tr>
<th width="5" style="vertical-align: top; "><?php echo JText::_('JL_GLOBAL_NUM'); ?></th>
<th width="20" style="vertical-align: top; "><input  type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->tablefields); ?>);" /></th>
<th width="20" style="vertical-align: top; ">&nbsp;</th>
<th width="5" style="vertical-align: top; "><?php echo JText::_('JL_ADMIN_USER_FIELDS_TABLENAME'); ?></th>
<th width="5" style="vertical-align: top; "><?php echo JText::_('JL_ADMIN_USER_FIELDS_FIELDNAME'); ?></th>
<th width="5" style="vertical-align: top; "><?php echo JText::_('JL_ADMIN_USER_FIELDS_USERFIELD'); ?></th>
<th width="5" style="vertical-align: top; "><?php echo JText::_('JL_ADMIN_USER_FIELDS_FIELDTYP'); ?></th>
<th width="5" style="vertical-align: top; "><?php echo JText::_('JL_ADMIN_USER_FIELDS_ORDERING'); ?></th>
<th width="5" style="vertical-align: top; "><?php echo JText::_('JL_ADMIN_USER_FIELDS_FIELDLENGH'); ?></th>
<th width="5" style="vertical-align: top; "><?php echo JText::_('JL_ADMIN_USER_FIELDS_VISIBLE'); ?></th>
<th width="5" style="vertical-align: top; "><?php echo JText::_('JL_ADMIN_USER_FIELDS_DESCRIPTION'); ?></th>
</tr>
</thead>
			
<?php
				$k=0;
				for ($i=0,$n=count($this->tablefields); $i < $n; $i++)
				{
					
          $row=&$this->tablefields[$i];	
          $link=JRoute::_('index.php?option=com_joomleague&controller=jlextuserfields&task=edit&cid[]='.$row->id);
           $checked = JHTML::_('grid.checkedout',$row,$i);
// 					$published = JHTML::_('grid.published',$row,$i);
          		
			  ?>
					<tr class="<?php echo "row$k"; ?>">
						<td>
            <?php 
            //echo $this->pagination->getRowOffset($i); 
            ?>
            </td>
						<td>
            <?php 
            echo $checked; 
            ?>
            </td>
            <td style="text-align:center; ">
								<a href="<?php echo $link; ?>">
									<?php
									$imageTitle=JText::_('JL_ADMIN_EVENTS_EDIT_DETAILS');
									echo JHTML::_(	'image','administrator/components/com_joomleague/assets/images/edit.png',
													$imageTitle, 'title= "'.$imageTitle.'"');
									?>
								</a>
							</td>
						<td><?php echo $row->tablename; ?></td>
						<td><?php echo $row->fieldname; ?></td>
						<td><?php echo $row->userfield; ?></td>
						<td><?php echo $row->fieldtype; ?></td>
						<td><?php echo $row->ordering; ?></td>
						<td><?php echo $row->fieldlengh; ?></td>
						<td><?php echo $row->visible; ?></td>
						<td><?php echo $row->description; ?></td>
						
						
						
			</tr>
					<?php
					$k=1 - $k;
				}
				?>			
</table>
</div>

<input type="hidden" name="controller" value="jlextuserfields" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<?php echo JHTML::_('form.token')."\n"; ?>
</form>