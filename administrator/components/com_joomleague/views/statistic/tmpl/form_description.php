<?php defined('_JEXEC') or die('Restricted access');
?>

			<fieldset class="adminform">
				<legend>
					<?php
					echo JText::_( 'JL_ADMIN_STAT_DESCR' );
					?>
				</legend>
				<?php
				// render is defined in joomla\libraries\joomla\html\parameter.php
				echo $this->classparams->getDescription();
				?>
			</fieldset>