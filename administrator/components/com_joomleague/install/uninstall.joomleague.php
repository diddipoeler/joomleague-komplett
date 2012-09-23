<?php defined('_JEXEC') or die('Restricted access');
function com_uninstall()
{
	$params =& JComponentHelper::getParams('com_joomleague');
	$uninstallDB = $params->get('cfg_drop_joomleague_tables_when_uninstalled',0); //Also uninstall db tables of JoomLeague?

	if ($uninstallDB)
	{
		echo JText::_('Also removing database tables of JoomLeague');
		$db =& JFactory::getDBO();
		echo '<p><strong>' . JText::_( 'DELETING ALL tables of JoomLeague 1.5 to clean your database!' ) . '</strong></p>';
		$query = "SHOW TABLES LIKE '%_joomleague_%'"; 
		$db->setQuery( $query ); 
		$results = $db->loadResultArray();
		foreach ( $tables as $result )
		{
				echo $result . ' - <span style="color:';
				$query = 'DROP TABLE IF EXISTS `' . $result . '`'; 
				$db->setQuery( $query );
				if ( $db->query() ) { 
					echo 'green">' . JText::_( 'Success' ); 
				} else { 
					echo 'red">' . JText::_( 'Failed' ); 
				}
				echo '</span><br />';
		}
	}
	else
	{
		echo JText::_('Database tables of JoomLeague are not removed');
	}
	?>
	<div class='header'><?php echo JText::_('JoomLeague now has been removed from your system!'); ?></div>
	<p><?php echo JText::_('We\'re sorry to see you go!'); ?></p>
	<p><?php echo JText::_('To completely remove Joomleague from your system, be sure to also uninstall the JoomLeague modules.'); ?></p>
	<?php
}
?>