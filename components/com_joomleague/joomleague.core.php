<?php

/**
* @copyright	Copyright (C) 2005-2012 JoomLeague.net. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

/**
 * this file perform the basic init and includes for joomleague
 */

defined('_JEXEC') or die('Restricted access');

// During ajax calls, the following constant might not be called
//if(!defined('JPATH_COMPONENT'))
//{
	//define('JPATH_COMPONENT', dirname(__FILE__));
//}

define('JLG_PATH_SITE',  JPATH_SITE . DS . 'components' .DS . 'com_joomleague'); 
define('JLG_PATH_ADMIN', JPATH_SITE . DS . 'administrator' . DS . 'components' . DS . 'com_joomleague');
require_once( JLG_PATH_ADMIN .DS . 'defines.php' );

require_once( JPATH_ROOT.DS.'components'.DS.'com_joomleague'.DS.'assets'.DS.'classes'.DS.'jlgcontroller.php'  );
require_once( JPATH_ROOT.DS.'components'.DS.'com_joomleague'.DS.'assets'.DS.'classes'.DS.'jlgmodel.php'  );
require_once( JPATH_ROOT.DS.'components'.DS.'com_joomleague'.DS.'assets'.DS.'classes'.DS.'jlgview.php'  );

require_once ( JLG_PATH_ADMIN .DS . 'elements' . DS . 'link.php' );

require_once( JLG_PATH_SITE . DS . 'helpers' . DS . 'route.php' );
require_once( JLG_PATH_SITE . DS . 'helpers' . DS . 'countries.php' );
require_once( JLG_PATH_SITE . DS . 'helpers' . DS . 'extraparams.php' );
require_once( JLG_PATH_SITE . DS . 'helpers' . DS . 'ranking.php' );
require_once( JLG_PATH_SITE . DS . 'helpers' . DS . 'html.php' );

include_once JLG_PATH_SITE . DS . 'helpers' . DS . 'feedreaderhelperr.php';
require_once(JLG_PATH_SITE . DS . 'helpers' . DS . 'simple-gmap-api' . DS . "simpleGMapAPI.php");
require_once(JLG_PATH_SITE . DS . 'helpers' . DS . 'simple-gmap-api' . DS . "simpleGMapGeocoder.php");

require_once( JLG_PATH_ADMIN .DS . 'helpers' . DS . 'jlcommon.php' );

require_once ( JLG_PATH_ADMIN .DS . 'tables' . DS . 'jltable.php' );
JTable::addIncludePath( JLG_PATH_ADMIN . DS . 'tables' );