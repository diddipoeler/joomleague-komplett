<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

$version			='1.6.0-nathalie';
$updateFileDate		='2012-04-04';
$updateFileTime		='23:10';
$updateDescription	='<span style="color:green">Installationscript called during installation.</span>';
$excludeFile		='true';

jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');

function PrintStepResult($status)
{
	switch ($status)
	{
		case 0:
				$output=' - <span style="color:red">'.JText::_('Failed').'</span><br />';
				break;
		case 1:
				$output=' - <span style="color:green">'.JText::_('Succes').'</span><br />';
				break;
		case 2:
				$output=' - <span style="color:orange">'.JText::_('Skipped').'</span><br />';
				break;
	}
	return $output;
}

function getVersion()
{	
	$db =& JFactory::getDBO();

	$version=new stdClass();
	$version->major=1;
	$version->minor=6;
	$version->build=0;
	$version->revision='nathalie';
	$version->file='joomleague';
	$version->date='0000-00-00 00:00:00';

	$query='SELECT * FROM #__joomleague_version ORDER BY date DESC';
	$db->setQuery($query);
	$result=$db->loadObject();
	if (!$result){return $version;}
	return $result;
}

/**
 * make sure the version table has the proper structure (1.0 import !)
 * if not, update it
 */
function _checkVersionTable()
{
	$db = &Jfactory::getDBO();
	
	$res = $db->getTableFields('#__joomleague_version');
	$cols = array_keys(reset($res));
	
	if (!in_array('major', $cols))
	{
		$query = ' ALTER TABLE #__joomleague_version ADD `major` INT NOT NULL ,
		           ADD `minor` INT NOT NULL ,
		           ADD `build` INT NOT NULL ,
		           ADD `count` INT NOT NULL ,
		           ADD `revision` VARCHAR(128) NOT NULL ,
		           ADD `file` VARCHAR(255) NOT NULL';
		$db->setQuery($query);
		if (!$db->query()) {
			echo JText::_('Failed updating version table');
		}
	}
}

function updateVersion($versionData)
{
	echo JText::_('Updating database version');
	
	$status=0;
	$updateVersionFile=JPATH_ADMINISTRATOR.DS.'components'.DS.'com_joomleague'.DS.'assets'.DS.'updates'.DS.'update_version.sql';

	if (JFile::exists($updateVersionFile))
	{
		$fileContent=JFile::read($updateVersionFile);
	}
	else
	{
		$fileContent="update #__joomleague_version set major='1', minor='6', build='0', revision='71351e0', version='nathalie', file='joomleague'";
	}

	$dummy=explode("'",$fileContent);
	$versionData			= new stdClass();
	$versionData->major		= $dummy[1];
	$versionData->minor		= $dummy[3];
	$versionData->build		= $dummy[5];
	$versionData->revision	= $dummy[7];
	$versionData->date		= NULL;
	$versionData->version	= $dummy[9];
	$versionData->file		= $dummy[11];
	// add additional tables
	if (file_exists( JPATH_SITE . DS . 'administrator' . DS . 'components' . DS . 'com_joomleague')) {
		JTable::addIncludePath(JPATH_ADMINISTRATOR.DS . DS . 'components' . DS . 'com_joomleague' . DS . 'tables' );
	}
	$tblVersion =& JTable::getInstance("Version", "Table");
	$tblVersion->load(1);
	echo " from '" . 
	$tblVersion->major . "." . $tblVersion->minor . "." . $tblVersion->build . "." . $tblVersion->revision . "-" . $tblVersion->version . " "
	. "' to '";
	if($tblVersion->version=="") {
		$tblVersion->id		= 0;
	} else {
		$tblVersion->id		= 1;
	}
	$tblVersion->version	= $versionData->version;
	$tblVersion->major		= $versionData->major;
	$tblVersion->minor		= $versionData->minor;
	$tblVersion->build		= $versionData->build;
	$tblVersion->revision	= $versionData->revision;
	$tblVersion->date		= NULL;
	$tblVersion->file		= $versionData->file;
	$tblVersion->count		= ++$tblVersion->count;
	if (!$tblVersion->store())
	{
		echo($tblVersion->getError());
	}
	$status=1;
	echo $versionData->major . "." . $versionData->minor . "." . $versionData->build . "." . $versionData->revision . "-" . $versionData->version . "' ";
	return $status;
}

function addGhostPlayer()
{
	echo JText::_('Inserting Ghost-Player data');
	$status=0;
	$db =& JFactory::getDBO();

	// Add new Parent position to PlayersPositions
	$queryAdd="INSERT INTO #__joomleague_person (`firstname`,`lastname`,`nickname`,`birthday`,`show_pic`,`published`,`ordering`)
				VALUES('!Unknown','!Player','!Ghost','1970-01-01','0','1','0')";

	$query="SELECT * FROM #__joomleague_person WHERE id=1 AND firstname='!Unknown' AND nickname='!Ghost' AND lastname='!Player'";
	$db->setQuery($query);
	if (!$dbresult=$db->loadObject())
	{
		$db->setQuery($queryAdd);
		$result=$db->query();
		$status=1;
	}
	else
	{
		$status=2;
	}
	return $status;
}

function addSportsType()
{
	echo JText::_('Inserting default Sports-Type');

	$status=0;
	$db=& JFactory::getDBO();
	$query="SELECT count(*) FROM #__joomleague_sports_type";
	$db->setQuery($query);
	$result=$db->loadResult();
	if ($result < 1)
	{
		// Add new sportstype Soccer to #__joomleague_sports_type
		$queryAdd="INSERT INTO #__joomleague_sports_type (`name`,`icon`) VALUES ('Soccer','media/com_joomleague/sportstypes/Soccer-Ball.gif')";
		$db->setQuery($queryAdd);
		$result=$db->query();
		$status=1;
	}
	else
	{
		$status=2;
	}
	return $status;
}
?>
<hr>
<?php
	_checkVersionTable();
	
	$versionData=getVersion();
	$major=$versionData->major;
	$minor=$versionData->minor;
	$build=$versionData->build;
	$revision=$versionData->revision;
	$version=sprintf('v%1$s.%2$s.%3$s.%4$s',$major,$minor,$build,$revision);

	echo PrintStepResult(addGhostPlayer());
	echo PrintStepResult(addSportsType());
	echo PrintStepResult(updateVersion($versionData));

	echo '<h3 style="color:green">'.JText::_('Installation finished succesfully!').'</h3></p>';
?>
<hr />