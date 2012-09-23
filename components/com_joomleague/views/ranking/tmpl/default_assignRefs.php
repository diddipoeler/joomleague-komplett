<?php

		$this->assignRef( 'websiteName',		JFactory::getConfig()->getValue( 'config.sitename' ) );
		$this->assignRef( 'request_url',		JFactory::getURI()->toString() );

echo '<br /><pre>~' . print_r( 'Ahhlo', true ) . '~</pre><br />';



?>