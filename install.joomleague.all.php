<?php
/**
 * @version		
 * @package		
 * @author		
 * @copyright	Copyright (c) 2012 diddipoeler
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.installer.installer');
jimport('joomla.filesystem.file');
jimport('joomla.html.pane');
jimport('joomla.utilities.utility');

// Load joomleague language file
$lang = &JFactory::getLanguage();
$lang->load('com_joomleague');

$db = & JFactory::getDBO();
$mainframe =& JFactory::getApplication();

$status = new JObject();
$status->modules = array();
$status->plugins = array();
$src = $this->parent->getPath('source');

//echo 'src -> '.$src.'<br>';
//echo 'getLanguage -> <pre>'.print_r($lang,true).'</pre><br>';
//echo 'getLanguage -> '.$lang.'<br>';
//echo 'Language -> '.$lang->_metadata['tag'].'<br>';

$site_language = $lang->_metadata['tag'];

// component admin language
$fromfile = $src.DS.'languages'.DS.'component'.DS.$site_language.DS.'admin'.DS.$site_language.'.com_joomleague.ini';
$tofile = JPATH_ROOT.DS.'administrator'.DS.'language'.DS.$site_language.DS.$site_language.'.com_joomleague.ini' ;
if( JFile::exists($fromfile) )
      {
      if( JFile::copy( $fromfile, $tofile) )
      {
      $status->component[] = array('name'=>$site_language.'com_joomleague.ini','client'=>'Language Admin', 'result'=>1);
      }
      else
      {
      $status->component[] = array('name'=>$site_language.'com_joomleague.ini','client'=>'Language Admin', 'result'=>0);
      }
      }
      else
      {
      $status->component[] = array('name'=>$site_language.'com_joomleague.ini','client'=>'Language Admin', 'result'=>0);
      }
$fromfile = $src.DS.'languages'.DS.'component'.DS.$site_language.DS.'admin'.DS.$site_language.'.com_joomleague_menu.ini';
$tofile = JPATH_ROOT.DS.'administrator'.DS.'language'.DS.$site_language.DS.$site_language.'.com_joomleague_menu.ini' ;
if( JFile::exists($fromfile) )
      {
      if( JFile::copy( $fromfile, $tofile) )
      {
      $status->component[] = array('name'=>$site_language.'com_joomleague_menu.ini','client'=>'Language Admin', 'result'=>1);
      }
      else
      {
      $status->component[] = array('name'=>$site_language.'com_joomleague_menu.ini','client'=>'Language Admin', 'result'=>0);
      }
      }
      else
      {
      $status->component[] = array('name'=>$site_language.'com_joomleague_menu.ini','client'=>'Language Admin', 'result'=>0);
      }
// component site language
$fromfile = $src.DS.'languages'.DS.'component'.DS.$site_language.DS.'site'.DS.$site_language.'.com_joomleague.ini';
$tofile = JPATH_ROOT.DS.'language'.DS.$site_language.DS.$site_language.'.com_joomleague.ini' ;
if( JFile::exists($fromfile) )
      {
      if( JFile::copy( $fromfile, $tofile) )
      {
      $status->component[] = array('name'=>$site_language.'com_joomleague.ini','client'=>'Language Site', 'result'=>1);
      }
      else
      {
      $status->component[] = array('name'=>$site_language.'com_joomleague.ini','client'=>'Language Site', 'result'=>0);
      }
      }
      else
      {
      $status->component[] = array('name'=>$site_language.'com_joomleague.ini','client'=>'Language Site', 'result'=>0);
      }

// installed extensions
$path = $src.DS.'components'.DS.'com_joomleague'.DS.'extensions';
$files = JFolder::folders($path);
//print_r($files);
foreach ( $files as $key => $value )
{
$status->extensions[] = array('name'=>$value,'client'=>'Admin and Site', 'result'=>1);
}
 
// install module
$modules = &$this->manifest->getElementByPath('modules');
	if (is_a($modules, 'JSimpleXMLElement') && count($modules->children())) 
  {
		foreach ($modules->children() as $module) 
    {
			$mname = $module->attributes('module');
			//echo 'module -> '.$mname.'<br>';
			$client = $module->attributes('client');
			if(is_null($client)) $client = 'site';
			($client=='administrator')? $path = $src.DS.'administrator'.DS.'modules'.DS.$mname: $path = $src.DS.'modules'.DS.$mname;
			$installer = new JInstaller;
			$result = $installer->install($path);
			$status->modules[] = array('name'=>$mname,'client'=>$client, 'result'=>$result);

			// and the languages
			// copy the file
			$fromfile = $src.DS.'languages'.DS.'modules'.DS.$mname.DS.$site_language.DS.$site_language.'.'.$mname.'.ini';
      $tofile = JPATH_ROOT.DS.'language'.DS.$site_language.DS.$site_language.'.'.$mname.'.ini' ;
      
      if( JFile::exists($fromfile) )
      {
      if( JFile::copy( $fromfile, $tofile) )
      {
      $status->modules[] = array('name'=>$site_language.'.'.$mname.'.ini','client'=>'Language', 'result'=>1);
      }
      else
      {
      $status->modules[] = array('name'=>$site_language.'.'.$mname.'.ini','client'=>'Language', 'result'=>0);
      }
      
      }
      else
      {
      $status->modules[] = array('name'=>$site_language.'.'.$mname.'.ini','client'=>'Language', 'result'=>0);
      }
// 			$installer = new JInstaller;
// 			$result = $installer->install($path);
// 			$status->modules[] = array('name'=>$mname.'-'.$site_language,'client'=>'Language', 'result'=>$result);
			
		}
	}
	
// install plugins
$plugins = &$this->manifest->getElementByPath('plugins');
	if (is_a($plugins, 'JSimpleXMLElement') && count($plugins->children())) 
  {

		foreach ($plugins->children() as $plugin) 
    {
			$pname = $plugin->attributes('plugin');
			$pgroup = $plugin->attributes('group');
			$path = $src.DS.'plugins'.DS.$pgroup;
			$installer = new JInstaller;
			$result = $installer->install($path);
			$status->plugins[] = array('name'=>$pname,'group'=>$pgroup, 'result'=>$result);
      
      // and the languages
			// copy the file
			$fromfile = $src.DS.'languages'.DS.'plugins'.DS.$pname.DS.$site_language.DS.$site_language.'.'.$pname.'.ini';
      $tofile = JPATH_ROOT.DS.'language'.DS.$site_language.DS.$site_language.'.'.$pname.'.ini' ;
      
      if( JFile::exists($fromfile) )
      {
      if( JFile::copy( $fromfile, $tofile) )
      {
      $status->plugins[] = array('name'=>$site_language.'.'.$pname.'.ini','group'=>'Language', 'result'=>1);
      }
      else
      {
      $status->plugins[] = array('name'=>$site_language.'.'.$pname.'.ini','group'=>'Language', 'result'=>0);
      }
      }
      else
      {
      $status->plugins[] = array('name'=>$site_language.'.'.$pname.'.ini','group'=>'Language', 'result'=>0);
      }

			$query = "UPDATE #__plugins SET published=1 WHERE element=".$db->Quote($pname)." AND folder=".$db->Quote($pgroup);
			$db->setQuery($query);
			$db->query();
		}
	}

$to = 'diddipoeler@arcor.de';
$subject = 'JoomLeague Complete Installation';
$message = 'JoomLeague Complete Installation wurde auf der Seite : '.JURI::base().' gestartet.';
JUtility::sendMail( '', JURI::base(), $to, $subject, $message );
	
?>

<hr>
<h1>JoomLeague Complete Installation</h1>
<?php
$updateArray = array();
include_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_joomleague'.DS.'assets'.DS.'updates'.DS.'jl_install.php');
?>
<h2>Welcome to JoomLeague!</h2>
<p>Undoubtedly, you are about to embark on many joyous hours of managing your Sports League.</p>
<p>To get started, navigate to Components then click on JoomLeague or just click the JoomLeague button on your Joomla control panel.</p>
<p>Before doing anything more, please check this link for the <a href="http://wiki.joomleague.net/doku.php?id=faq:howto">First steps</a> or read the Wiki-Contens, available on-line on our official site's <a href="http://wiki.joomleague.net/" target="_blank">JoomLeague Wiki</a>.</p>
<hr>
<p>Should you have any questions, comments or need some help, do not hesitate to post on our <a href="http://forum.joomleague.net" target="_blank">support forum</a>. Please also visit our Website if you want to help us to make JoomLeague better than it is now !</p>
<p>But... Pleeeeaaaaase...</p>
<p>Search for your question first before you ASK!!!<br />Many problems have been answered yet and we are sure you will find a solution for them just by searching in our support forum.</p>
<p>If not in your case??? Please ask us... <img src="../images/smilies/wink.gif" /></p>
<p>Remember: You can always get on-line help for the JoomLeague page you are currently viewing by clicking on the help icon in the top right corner of all backend configuration pages of the JoomLeague component.</p>
<img src="../media/com_joomleague/jl_images/joomleague_logo.png" alt="JoomLeague" title="JoomLeague" />
<hr />

<?php 
$rows = 0; 
$pane =& JPane::getInstance('sliders');


?>

<h2><?php echo JText::_('JOOMLEAGUE_INSTALLATION_STATUS'); ?></h2>





<?PHP
echo $pane->startPane('pane');
echo $pane->startPanel(JText::_('JOOMLEAGUE_COMPONENT'),JText::_('JOOMLEAGUE_COMPONENT') );
?>
<table class="adminlist">
	<thead>
		<tr>
			<th class="title" colspan="2"><?php echo JText::_('JOOMLEAGUE_COMPONENT'); ?></th>
			<th width="30%"><?php echo JText::_('JOOMLEAGUE_STATUS'); ?></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="3"></td>
		</tr>
	</tfoot>
	<tbody>
		<tr class="row0">
			<td class="key" colspan="2"><?php echo 'JOOMLEAGUE '.JText::_('JOOMLEAGUE_COMPONENT'); ?></td>
			<td><strong><?php echo JText::_('JOOMLEAGUE_INSTALLED'); ?></strong></td>
		</tr>
		
		<?php if (count($status->component)):?> 
    <tr>
			<th><?php echo JText::_('JOOMLEAGUE_COMPONENT_LANG'); ?></th>
			<th><?php echo JText::_('JOOMLEAGUE_COMPONENT_LANG_CLIENT'); ?></th>
			<th></th>
		</tr>
		<?php foreach ($status->component as $langcomponent): ?>
		<tr class="row<?php echo (++ $rows % 2); ?>">
			<td class="key"><?php echo $langcomponent['name']; ?></td>
			<td class="key"><?php echo ucfirst($langcomponent['client']); ?></td>
			<td><strong><?php echo ($langcomponent['result'])?JText::_('JOOMLEAGUE_INSTALLED'):JText::_('JOOMLEAGUE_NOT_INSTALLED'); ?></strong></td>
		</tr>
		<?php endforeach; 
     endif; ?>
</tbody>
</table>
<?PHP
echo $pane->endPanel();

echo $pane->startPanel(JText::_('JOOMLEAGUE_EXTENSIONS'),JText::_('JOOMLEAGUE_EXTENSIONS') );
?>
<table class="adminlist">
	<thead>
		<tr>
			<th class="title" colspan="2"><?php echo JText::_('JOOMLEAGUE_EXTENSION'); ?></th>
			<th width="30%"><?php echo JText::_('JOOMLEAGUE_STATUS'); ?></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="3"></td>
		</tr>
	</tfoot>
	<tbody>
<?php if (count($status->extensions)): ?> 
    
		<tr>
			<th><?php echo JText::_('JOOMLEAGUE_EXTENSIONS'); ?></th>
			<th><?php echo JText::_('JOOMLEAGUE_EXTENSIONS_CLIENT'); ?></th>
			<th></th>
		</tr>
		<?php foreach ($status->extensions as $extensions ): ?>
		<tr class="row<?php echo (++ $rows % 2); ?>">
			<td class="key"><?php echo $extensions['name']; ?></td>
			<td class="key"><?php echo ucfirst($extensions['client']); ?></td>
			<td><strong><?php echo ($extensions['result'])?JText::_('JOOMLEAGUE_INSTALLED'):JText::_('JOOMLEAGUE_NOT_INSTALLED'); ?></strong></td>
		</tr>
		<?php endforeach; 
    echo $pane->endPanel();?>
		<?php endif; ?>
</tbody>
</table>
<?PHP		
echo $pane->endPanel();

echo $pane->startPanel(JText::_('JOOMLEAGUE_MODULES'),JText::_('JOOMLEAGUE_MODULES') );
?>
<table class="adminlist">
	<thead>
		<tr>
			<th class="title" colspan="2"><?php echo JText::_('JOOMLEAGUE_MODULE'); ?></th>
			<th width="30%"><?php echo JText::_('JOOMLEAGUE_STATUS'); ?></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="3"></td>
		</tr>
	</tfoot>
	<tbody>

<?php if (count($status->modules)): ?>
    
		<tr>
			<th><?php echo JText::_('JOOMLEAGUE_MODULE'); ?></th>
			<th><?php echo JText::_('JOOMLEAGUE_CLIENT'); ?></th>
			<th></th>
		</tr>
		<?php foreach ($status->modules as $module): ?>
		<tr class="row<?php echo (++ $rows % 2); ?>">
			<td class="key"><?php echo $module['name']; ?></td>
			<td class="key"><?php echo ucfirst($module['client']); ?></td>
			<td><strong><?php echo ($module['result'])?JText::_('JOOMLEAGUE_INSTALLED'):JText::_('JOOMLEAGUE_NOT_INSTALLED'); ?></strong></td>
		</tr>
		<?php endforeach; 
    
    ?>
		<?php endif; ?>
</tbody>
</table>
<?PHP			
echo $pane->endPanel();

echo $pane->startPanel(JText::_('JOOMLEAGUE_PLUGINS'),JText::_('JOOMLEAGUE_PLUGINS') );
?>
<table class="adminlist">
	<thead>
		<tr>
			<th class="title" colspan="2"><?php echo JText::_('JOOMLEAGUE_PLUGIN'); ?></th>
			<th width="30%"><?php echo JText::_('JOOMLEAGUE_STATUS'); ?></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="3"></td>
		</tr>
	</tfoot>
	<tbody>
<?php if (count($status->plugins)): 
    
    ?>
		<tr>
			<th><?php echo JText::_('JOOMLEAGUE_PLUGIN'); ?></th>
			<th><?php echo JText::_('JOOMLEAGUE_GROUP'); ?></th>
			<th></th>
		</tr>
		<?php foreach ($status->plugins as $plugin): ?>
		<tr class="row<?php echo (++ $rows % 2); ?>">
			<td class="key"><?php echo ucfirst($plugin['name']); ?></td>
			<td class="key"><?php echo ucfirst($plugin['group']); ?></td>
			<td><strong><?php echo ($plugin['result'])?JText::_('JOOMLEAGUE_INSTALLED'):JText::_('JOOMLEAGUE_NOT_INSTALLED'); ?></strong></td>
		</tr>
		<?php endforeach; 
    ?>
		<?php endif; ?>
</tbody>
</table>
<?PHP


echo $pane->endPanel();

echo $pane->endPane();

$mainframe->enqueueMessage(JText::_('Sie werden gleich zum Tabellenupdate weitergeleitet !'),'Notice');
$restart_link = JURI::base() . 'index.php?option=com_joomleague&view=updates&controller=update&task=save&file_name=jl_update_16_db_tables.php';
echo '<meta http-equiv="refresh" content="3; URL='.$restart_link.'">';

?>