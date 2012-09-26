<?php 
defined( '_JEXEC' ) or die( 'Restricted access' ); 

/*
echo 'person_positions <br>';
echo '<pre>';
print_r($this->person_positions);
echo '</pre><br>';
*/

?>
<!-- EXTENDED DATA-->



<?php
//check if there is data
//$this->loadTemplate("playerpositionfield");
$hasData = false;
foreach ( $this->extended->getGroups() as $group => $groups )
	{
		$params = $this->extended->getElements($group);

		foreach ($params as $param)
		{
			if (!empty($param->value))
			{
			$hasData = true;
			}
		}
	}
?>	


<table width="100%">
<tr>
<?php
//if there is data , show it
if ($hasData)
{
?>
<td width="50%">
<h2><?php echo '&nbsp;' . JText::_( 'JL_PERSON_EXTENDED' ); ?></h2>

<table>
	<?php
			foreach ( $this->extended->getGroups() as $group => $groups )
			{
				$params = $this->extended->getElements($group);
				foreach ($params as $param)
				{
					if (!empty($param->value))
					{
					?>
					<tr>
						<td class="label">
							<?php echo $param->label; ?>
						</td>
						<td class="data">
							<?php echo $param->value; ?>
						</td>
					</tr>
					<?php
					}
				}
			}
			?>	
</table>
</td>
<br/>
<?php
}

?>

<td width="50%">
<h2><?php echo '&nbsp;' . JText::_( 'JL_PERSON_PLAYFIELD' ); ?></h2>

<?php
					
$backimage = 'media/com_joomleague/jl_person_playground/' . $this->teamPlayer->position_name . '.png'; 					
$hauptimage = 'media/com_joomleague/jl_person_playground/hauptposition.png';
$nebenimage = 'media/com_joomleague/jl_person_playground/nebenposition.png';

switch ( $this->teamPlayer->position_name )
{
case 'JL_P_GOALKEEPER':
case 'Torwart':
case 'Torhüter':
$image_class = 'hp1';
break;
case 'JL_P_DEFENDER':
case 'Abwehr':
$image_class = 'hp3l';
break;
case 'JL_P_MIDFIELDER':
case 'Mittelfeld':
$image_class = 'hp6';
break;
case 'JL_P_FORWARD':
case 'Sturm':
case 'Stürmer':
$image_class = 'hp14';
break;
}

?>
<div style="position:relative;height:170px;background-image:url(<?PHP echo $backimage;?>);background-repeat:no-repeat;">
<img src="<?PHP echo $hauptimage;?>" class="<?PHP echo $image_class;?>" alt="<?PHP echo $this->teamPlayer->position_name; ?>" title="<?PHP echo $this->teamPlayer->position_name; ?>" />

<?PHP


if ( $this->person_positions )
{

if ( is_array($this->person_positions) )
{
foreach ( $this->person_positions as $key => $value)
{
?>
<img src="<?PHP echo $nebenimage;?>" class="<?PHP echo $value;?>" alt="Nebenposition" title="Nebenposition" />
<?PHP
}
}
else
{
?>
<img src="<?PHP echo $nebenimage;?>" class="<?PHP echo $this->person_positions;?>" alt="Nebenposition" title="Nebenposition" />
<?PHP
}

}
?>
</div>

</td>
</tr>
</table>