<?php
/**
 * Joomleague Component script file to CREATE all tables of JoomLeague 1.5
 *
 * @author	Kurt Norgaz
 * @package	JoomLeague
 * @since	1.5 - 2010-08-18
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.html.pane');

$version			= '1.6.0-diddipoeler';
$updateFileDate		= '2013-01-04';
$updateFileTime		= '23:10';
$updateDescription	='<span style="color:orange">Update all tables using actual install sql-file of JoomLeague v1.6.0</span>';
$excludeFile		='false';

$maxImportTime=JComponentHelper::getParams('com_joomleague')->get('max_import_time',0);
if (empty($maxImportTime))
{
	$maxImportTime=880;
}
if ((int)ini_get('max_execution_time') < $maxImportTime){@set_time_limit($maxImportTime);}

$maxImportMemory=JComponentHelper::getParams('com_joomleague')->get('max_import_memory',0);
if (empty($maxImportMemory))
{
	$maxImportMemory='150M';
}
if ((int)ini_get('memory_limit') < (int)$maxImportMemory){ini_set('memory_limit',$maxImportMemory);}

function getUpdatePart()
{
	$option='com_joomleague';
	$mainframe =& JFactory::getApplication();
	$update_part=$mainframe->getUserState($option.'update_part');
	return $update_part;
}

function setUpdatePart($val=1)
{
	$option='com_joomleague';
	$mainframe =& JFactory::getApplication();
	$update_part=$mainframe->getUserState($option.'update_part');
	if ($val!=0)
	{
		if ($update_part=='')
		{
			$update_part=1;
		}
		else
		{
			$update_part++;
		}
	}
	else
	{
		$update_part=0;
	}
	$mainframe->setUserState($option.'update_part',$update_part);
}

function ImportTables()
{
	$db =& JFactory::getDBO();
  $config = JFactory::getConfig();
  $app = JFactory::getApplication();  
  
  $jl_tables = array();
  $jl_tables_fields = array();
  
	$imports=file_get_contents(JPATH_ADMINISTRATOR.'/components/com_joomleague/sql/install.mysql.utf8.sql');
	$imports=preg_replace("%/\*(.*)\*/%Us",'',$imports);
	$imports=preg_replace("%^--(.*)\n%mU",'',$imports);
	$imports=preg_replace("%^$\n%mU",'',$imports);

	$imports=explode(';',$imports);
	foreach ($imports as $import)
	{
		$import=trim($import);
		if (!empty($import))
		{
			$DummyStr=$import;
			$DummyStr=substr($DummyStr,strpos($DummyStr,'`')+1);
			$DummyStr=substr($DummyStr,0,strpos($DummyStr,'`'));
			$db->setQuery($import);
			
			$pane =& JPane::getInstance('sliders');
			echo $pane->startPane('pane');
			echo $pane->startPanel($DummyStr,$DummyStr);
			
			//echo "<pre>$import</pre>";
			echo '<table class="adminlist" style="width:100%; " border="0"><thead><tr><td colspan="2" class="key" style="text-align:center;"><h3>';
			echo "Checking existence of table [$DummyStr] - <span style='color:";
				if ($db->query()){echo "green'>".JText::_('Success');}else{echo "red'>".JText::_('Failed');}
			echo '</span>';
			echo '</h3></td></tr></thead><tbody>';
			$DummyStr=$import;
			$DummyStr=substr($DummyStr,strpos($DummyStr,'`')+1);
			$tableName=substr($DummyStr,0,strpos($DummyStr,'`'));
			
      // diddipoeler
      //echo "tableName<br />$tableName<br />";
      
      $jl_tables[] = $tableName;

			$DummyStr=substr($DummyStr,strpos($DummyStr,'(')+1);
			$DummyStr=substr($DummyStr,0,strpos($DummyStr,'ENGINE'));
			$keysIndexes=trim(trim(substr($DummyStr,strpos($DummyStr,'PRIMARY KEY'))),')');
			$indexes=explode("\r\n",$keysIndexes);
			if ($indexes[0]==$keysIndexes)
			{
				$indexes=explode("\n",$keysIndexes);
				if ($indexes[0]==$keysIndexes)
				{
					$indexes=explode("\r",$keysIndexes);
				}
			}
			//echo '<pre>'.print_r($indexes,true).'</pre>';
			//echo '<pre>'.print_r($keysIndexes,true).'</pre>';

			$DummyStr=trim(trim(substr($DummyStr,0,strpos($DummyStr,'PRIMARY KEY'))),',');
			$fields=explode("\r\n",$DummyStr);
			if ($fields[0]==$DummyStr)
			{
				$fields=explode("\n",$DummyStr);
				if ($fields[0]==$DummyStr){$fields=explode("\r",$DummyStr);}
			}
			
      // diddipoeler
      //echo 'fields <br><pre>'.print_r($fields,true).'</pre><br>';

			$newIndexes=array();
			$i=(-1);
			foreach ($indexes AS $index)
			{
				$dummy=trim($index,' ,');
				if (!empty($dummy))
				{
					$i++;
					$newIndexes[$i]=$dummy;
				}
			}
			//echo '<pre>'.print_r($newIndexes,true).'</pre>';

			$newFields=array();
			$i=(-1);
			foreach ($fields AS $field)
			{
				$dummy=trim($field,' ,');
				if (!empty($dummy))
				{
					$i++;
					$newFields[$i]=$dummy;
				}
			}
			
      // diddipoeler
      //echo 'newFields <br><pre>'.print_r($newFields,true).'</pre><br>';
      
			$rows=count($newIndexes)+1;
			echo '<tr><th class="key" style="vertical-align:top; width:10; white-space:nowrap; " rowspan="'.$rows.'">';
			echo JText::sprintf('Table needs following<br />keys/indexes:',$tableName);
			echo '</th></tr>';
			$k=0;
			foreach ($newIndexes AS $index)
			{
				$index=trim($index);
				echo '<tr class="row'.$k.'"><td>';
				if (!empty($index)){echo $index;}
				echo '</td></tr>';
				$k=(1-$k);
			}

			$rows=count($newIndexes)+1;
			echo '<tr><th class="key" style="vertical-align:top; width:10; white-space:nowrap; " rowspan="'.$rows.'">';
			echo JText::_('Dropping keys/indexes:');
			echo '</th></tr>';
			foreach ($newIndexes AS $index)
			{
				$query='';
				$index=trim($index);
				echo '<tr class="row'.$k.'"><td>';
				if (substr($index,0,11)!='PRIMARY KEY')
				{
					$keyName='';
					$queryDelete='';
					if (substr($index,0,3)=='KEY')
					{
						$keyName=substr($index,0,strpos($index,'('));
						$queryDelete="ALTER TABLE `$tableName` DROP $keyName";
					}
					elseif (substr($index,0,5)=='INDEX')
					{
						$keyName=substr($index,0,strpos($index,'('));
						$queryDelete="ALTER TABLE `$tableName` DROP $keyName";
					}
					elseif (substr($index,0,6)=='UNIQUE')
					{
						$keyName=trim(substr($index,6));
						$keyName=substr($keyName,0,strpos($keyName,'('));
						$queryDelete="ALTER TABLE `$tableName` DROP $keyName";
					}
					$db->setQuery($queryDelete);
					echo "$queryDelete - <span style='color:";
						if ($db->query()){echo "green'>".JText::_('Success');}else{echo "red'>".JText::_('Failed');}
					echo '</span>';
				}
				else
				{
					echo "<span style='color:orange; '>".JText::sprintf('Skipping handling of %1$s',$index).'</span>';
				}
				echo '&nbsp;</td></tr>';
				$k=(1-$k);
			}

			$rows=count($newFields)+1;
			echo '<tr><th class="key" style="vertical-align:top; width:10; white-space:nowrap; " rowspan="'.$rows.'">';
			echo JText::_('Updating fields:');
			echo '</th></tr>';
			foreach ($newFields AS $field)
			{
				$dFfieldName=substr($field,strpos($field,'`')+1);
				$fieldName=substr($dFfieldName,0,strpos($dFfieldName,'`'));
				$dFieldSetting=substr($dFfieldName,strpos($dFfieldName,'`')+1);
				$query="ALTER TABLE `$tableName` ADD `$fieldName` $dFieldSetting";
				$db->setQuery($query);
				echo '<tr class="row'.$k.'"><td>';
				if (!$db->query())
				{
					$query="ALTER TABLE `$tableName` CHANGE `$fieldName` `$fieldName` $dFieldSetting";
					$db->setQuery($query);
					echo "$query - <span style='color:";
						if ($db->query()){echo "green'>".JText::_('Success');}else{echo "red'>".JText::_('Failed');} //fehlgeschlagen
					echo '</span>';
				}
				else
				{
					echo "$query - <span style='color:green'>".JText::_('Success').'</span>';
				}
				echo '&nbsp;</td></tr>';
				$k=(1-$k);
        
  switch ($tableName)
  {
  case '#__joomleague_jltable_fields':
  case '#__joomleague_jltable_tables':  
  break;
  
  default:
  $temp = new stdClass();
  $temp->dffieldname = $dFfieldName;  
  $temp->fieldname = $fieldName;
  $temp->dfieldsetting = $dFieldSetting;
  $jl_tables_fields[$tableName][] = $temp;
  break;
  }
        /*
        if ( $tableName != '#__joomleague_jltable_fields' )
        {
        $temp = new stdClass();
        $temp->dffieldname = $dFfieldName;  
        $temp->fieldname = $fieldName;
        $temp->dfieldsetting = $dFieldSetting;
        $jl_tables_fields[$tableName][] = $temp;
        }
        */
			}

			$rows=count($newIndexes)+1;
			echo '<tr><th class="key" style="vertical-align:top; width:10; white-space:nowrap; " rowspan="'.$rows.'">';
			echo JText::_('Adding keys/indexes:');
			echo '</th></tr>';
			foreach ($newIndexes AS $index)
			{
				$query='';
				$index=trim($index);
				echo '<tr class="row'.$k.'"><td>';
				if (substr($index,0,11)!='PRIMARY KEY')
				{
					$keyName='';
					$queryAdd='';
					if (substr($index,0,3)=='KEY')
					{
						$keyName=substr($index,0,strpos($index,'('));
						$queryAdd="ALTER TABLE `$tableName` ADD $index";
					}
					elseif (substr($index,0,5)=='INDEX')
					{
						$keyName=substr($index,0,strpos($index,'('));
						$queryAdd="ALTER TABLE `$tableName` ADD $index";
					}
					elseif (substr($index,0,6)=='UNIQUE')
					{
						$keyName=trim(substr($index,6));
						$keyName=substr($keyName,0,strpos($keyName,'('));
						$queryAdd="ALTER TABLE `$tableName` ADD $index";
					}
					$db->setQuery($queryAdd);
					echo "$queryAdd - <span style='color:";
						if ($db->query()){echo "green'>".JText::_('Success');}else{echo "red'>".JText::_('Failed');}
					echo '</span>';
				}
				else
				{
					echo "<span style='color:orange; '>".JText::sprintf('Skipping handling of %1$s',$index).'</span>';
				}
				echo '&nbsp;</td></tr>';
				$k=(1-$k);
			}
			echo '</tbody></table>';
			unset($newIndexes);
			unset($newFields);
			
			echo $pane->endPanel();
			echo $pane->endPane();
      
		}
		unset($import);
	}
  
  //echo 'jl_tables_fields <br><pre>'.print_r($jl_tables_fields,true).'</pre><br>';
  
  JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_joomleague'.DS.'tables');
  
  //echo 'config <br><pre>'.print_r($config,true).'</pre><br>';
  //$prefix = $config->get('dbprefix');
  //$database = $config->get('db');
  //echo 'database -><br>'.$database.'<br>';
  //echo 'prefix -><br>'.$prefix.'<br>';
  
//   echo $app->getCfg('user').'<br>'; 
//   echo $app->getCfg('password').'<br>';
//   echo $app->getCfg('dbprefix').'<br>'; 
//   echo $app->getCfg('db').'<br>';
  
  //$database = $app->getCfg('db');
  //$result = mysql_list_fields($database, "jos_joomleague_club");
  //echo 'result <br><pre>'.print_r($result,true).'</pre><br>';
   
  foreach ( $jl_tables_fields as $table => $fields )
  {
  // diddipoeler
  
  //echo 'tabelle '.$table.'<br>';
  //$result1 = $db->getTableFields($table);
  //echo 'tabellenfelder <br><pre>'.print_r($result1,true).'</pre><br>';
  
  $query = "SHOW COLUMNS FROM ".$table;
  
  // diddipoeler
  $row_table =& JTable::getInstance('jltabletables', 'Table');
  $row_table->tablename = $table;
  
  switch ($table)
  {
  case '#__joomleague_person':
  case '#__joomleague_club':  
  $visible = 1;
  break;
  
  default:
  $visible = 0;
  break;
  }
  
  $row_table->visible = $visible;
    
  if (!$row_table->store())
	{
	   $query = "	SELECT id
FROM #__joomleague_jltable_tables
WHERE tablename like '" . $table ."'";
$db->setQuery( $query );
$jltable_id = $db->loadResult();

$rowupdate_table =& JTable::getInstance('jltabletables', 'Table');
  $rowupdate_table->load($jltable_id);
  $rowupdate_table->visible = $visible;
  
  if (!$rowupdate_table->store())
  {
  }
  else
  {
  }
	}
	else
	{
  }
  
  $result1 = $db->getTableFields($table);
  //echo 'tabellenfelder result 1<br><pre>'.print_r($result1,true).'</pre><br>';
  $query = "SHOW COLUMNS FROM ".$table;
  $db->setQuery($query);
  $result2 = $db->loadAssocList('Field');
  
  //echo 'tabellenfelder result 2<br><pre>'.print_r($result2,true).'</pre><br>'; 

 
  
  foreach ( $fields as $field )
  {
  $rowfield =& JTable::getInstance('jlextuserfield', 'Table');
  
  $rowfield->tablename		= $table;
  $rowfield->fieldname		= $field->fieldname;
  $rowfield->fieldtype = $result1[$table][$field->fieldname];
  
  
	if (!$rowfield->store())
	{
		//echo($row->getError());
    $query = "	SELECT id
FROM #__joomleague_jltable_fields
WHERE tablename like '" . $table ."' and fieldname like '".$field->fieldname."'";
$db->setQuery( $query );
$jltable_field_id = $db->loadResult();

//echo 'jltable_field_id -> '.$jltable_field_id.'<br>';
  
  $rowupdate_fields =& JTable::getInstance('jlextuserfield', 'Table');
  $rowupdate_fields->load($jltable_field_id);
  $rowupdate_fields->fieldtype = $rowfield->fieldtype;
  $rowupdate_fields->fieldlengh = preg_replace("/[(a-zA-Z)]/",'', $result2[$field->fieldname]['Type'] );
  if (!$rowupdate_fields->store())
  {
  }
  else
  {
  }
  
	}
  
  
  }
  
  
  }
  
	return '';
}

?>
<hr />
<?php
	$mtime=microtime();
	$mtime=explode(" ",$mtime);
	$mtime=$mtime[1] + $mtime[0];
	$starttime=$mtime;

	JToolBarHelper::title(JText::_('JoomLeage 1.6 (diddipoeler) - Database update process'));
	echo '<h2>'.JText::sprintf(	'JoomLeague v%1$s - %2$s - Filedate: %3$s / %4$s',
								$version,$updateDescription,$updateFileDate,$updateFileTime).'</h2>';
	$totalUpdateParts = 2;
	setUpdatePart();

	if (getUpdatePart() < $totalUpdateParts)
	{
		echo '<p><b>';
			echo JText::sprintf('Please remember that this update routine has totally %1$s update steps!',$totalUpdateParts).'</b><br />';
			echo JText::_('So please go to the bottom of this page to check if there are errors and more update steps to do!');
		echo '</p>';
		echo '<p style="color:red; font-weight:bold; ">';
			echo JText::_('DANGER!!!').'<br />';
			echo JText::_('This script WILL MAKE CHANGES in your DATABASE without any more warning!!!').'<br />';
			echo JText::_('It is recommended that you make a backup of your Database before!!!').'<br />';
			echo JText::_('Only for testing purposes of Developers or if you really know what you do!!!').'<br />';
		echo '</p>';
		echo '<hr>';
	}

	if (getUpdatePart()==$totalUpdateParts)
	{
		echo '<hr />';
		echo ImportTables();
		echo '<br /><center><hr />';
			echo JText::sprintf('Memory Limit is %1$s',ini_get('memory_limit')).'<br />';
			echo JText::sprintf('Memory Peak Usage was %1$s Bytes',number_format(memory_get_peak_usage(true),0,'','.')).'<br />';
			echo JText::sprintf('Time Limit is %1$s seconds',ini_get('max_execution_time')).'<br />';
			$mtime=microtime();
			$mtime=explode(" ",$mtime);
			$mtime=$mtime[1] + $mtime[0];
			$endtime=$mtime;
			$totaltime=($endtime - $starttime);
			echo JText::sprintf('This page was created in %1$s seconds',$totaltime);
		echo '<hr /></center>';
		setUpdatePart(0);
	}
	else
	{
		echo '<a href="javascript:location.reload(true)" ><b>';
			echo JText::sprintf('Click here to do step %1$s of %2$s steps to finish the update. PLEASE BY SURE WHAT YOU DO BY CLICKING HERE!',getUpdatePart()+1,$totalUpdateParts);
		echo '</b></a>';
	}
?>