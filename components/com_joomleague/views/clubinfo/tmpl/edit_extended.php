<?php defined( '_JEXEC' ) or die( 'Restricted access' );
?>
	<?php
	foreach ( $this->extended->getGroups() as $key => $groups )
	{
		$gname = ( strtolower($key) == '_default' ) ? JText::_( 'General' ) : $key;
		?>
		<fieldset class="extendform">
			<legend>
				<?php
				echo JText::_( $gname );
				?>
			</legend>
			<?php
			// render is defined in joomla\libraries\joomla\html\parameter.php
			echo $this->extended->render( 'extended', $key );
			?>
		</fieldset>
		<?php
	}
	?>