<?php defined('_JEXEC') or die('Restricted access');
?>

		<?php	foreach ( $this->baseparams->getGroups() as $key => $groups )
		{
			$gname = ( strtolower($key) == '_default' ) ? JText::_( 'JL_ADMIN_STAT_GENERAL_PARAMS' ) : $key;
			?>
			<fieldset class="adminform">
				<legend>
					<?php
					echo JText::_( $gname );
					?>
				</legend>
				<?php
				// render is defined in joomla\libraries\joomla\html\parameter.php
				echo $this->baseparams->render( 'baseparams', $key );
				?>
			</fieldset>
			<?php
		}
		?>