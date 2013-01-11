<?php
/**
 * @copyright	Copyright (C) 2006-2009 Joomleague.de. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.

j.mertann@t-online.de
w.warnke@cneweb.de
stachorra@gelsennet.de
oma_ingrid@web.de
r.broschk@gelsennet.de
kwiat2@web.de

  60  header icons 
  61  .icon-48-generic         { background-image: url(../images/header/icon-48-generic.png); }
  62  .icon-48-checkin         { background-image: url(../images/header/icon-48-checkin.png); }
  63  .icon-48-cpanel         { background-image: url(../images/header/icon-48-cpanel.png); }
  64  .icon-48-config         { background-image: url(../images/header/icon-48-config.png); }
  65  .icon-48-module         { background-image: url(../images/header/icon-48-module.png); }
  66  .icon-48-menu             { background-image: url(../images/header/icon-48-menu.png); }
  67  .icon-48-menumgr         { background-image: url(../images/header/icon-48-menumgr.png); }
  68  .icon-48-trash         { background-image: url(../images/header/icon-48-trash.png); }
  69  .icon-48-user             { background-image: url(../images/header/icon-48-user.png); }
  70  .icon-48-inbox         { background-image: url(../images/header/icon-48-inbox.png); }
  71  .icon-48-msgconfig     { background-image: url(../images/header/icon-48-message_config.png); }
  72  .icon-48-langmanager { background-image: url(../images/header/icon-48-language.png); }
  73  .icon-48-mediamanager{ background-image: url(../images/header/icon-48-media.png); }
  74  .icon-48-plugin     { background-image: url(../images/header/icon-48-plugin.png); }
  75  .icon-48-help_header { background-image: url(../images/header/icon-48-help_header.png); }
  76  .icon-48-impressions { background-image: url(../images/header/icon-48-stats.png); }
  77  .icon-48-browser         { background-image: url(../images/header/icon-48-stats.png); }
  78  .icon-48-searchtext     { background-image: url(../images/header/icon-48-stats.png); }
  79  .icon-48-thememanager{ background-image: url(../images/header/icon-48-themes.png); }
  80  .icon-48-massemail     { background-image: url(../images/header/icon-48-massemail.png); }
  81  .icon-48-frontpage     { background-image: url(../images/header/icon-48-frontpage.png); }
  82  .icon-48-sections     { background-image: url(../images/header/icon-48-section.png); }
  83  .icon-48-addedit         { background-image: url(../images/header/icon-48-article-add.png); }
  84  .icon-48-article         { background-image: url(../images/header/icon-48-article.png); }
  85  .icon-48-categories     { background-image: url(../images/header/icon-48-category.png); }
  86  .icon-48-install         { background-image: url(../images/header/icon-48-extension.png); }
  87  .icon-48-dbbackup        { background-image: url(../images/header/icon-48-backup.png); }
  88  .icon-48-dbrestore     { background-image: url(../images/header/icon-48-dbrestore.png); }
  89  .icon-48-dbquery         { background-image: url(../images/header/icon-48-query.png); }
  90  .icon-48-systeminfo     { background-image: url(../images/header/icon-48-info.png); }
  91  .icon-48-massemail     { background-image: url(../images/header/icon-48-massmail.png); }
  
 */

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

/**
 * HTML View class for the Joomleague component
 *
 * @static
 * @package		Joomleague
 * @since 0.1
 */
class JoomleagueViewJLextuserfield extends JLGView
{


	function display( $tpl = null )
	{
		global $mainframe;
		
    if ( $this->getLayout() == 'default')
		{
			$this->_displayDefault( $tpl );
			return;
		}
		
		if ( $this->getLayout() == 'formfield')
		{
			$this->_displayFormField( $tpl );
			return;
		}
		
		//get the 
		$userfield	=& $this->get( 'data' );
		
		parent::display( $tpl );
		
	}
	
	
	function _displayFormField( $tpl )
	{
		global $mainframe, $option;

		$db		=& JFactory::getDBO();
		$document	= & JFactory::getDocument();
		$uri 	=& JFactory::getURI();
		$user 	=& JFactory::getUser();
		$mainframe	=& JFactory::getApplication();
		$model	=& $this->getModel();
		
		//get the 
		$userfield	=& $this->get( 'data' );
		
		//add css and submenu to document
    //$document->addStyleSheet(JURI::base().'components/com_joomleague/extensions/jlextuserfields/admin/assets/css/cpanel.css');
    $stylelink = '<link rel="stylesheet" href="'.JURI::root().'components/com_joomleague/extensions/jlextuserfields/admin/assets/css/cpanel.css'.'" type="text/css" />' ."\n";
    $document->addCustomTag($stylelink);
    
    $types[] = JHTML::_('select.option',  'VARCHAR', 'Textfeld' );
    $types[] = JHTML::_('select.option',  'checkbox', 'Check Box (Single)' );
	$types[] = JHTML::_('select.option',  'multicheckbox', 'Check Box (Muliple)' );
	$types[] = JHTML::_('select.option',  'date', 'Date' );
	$types[] = JHTML::_('select.option',  'birthdate', 'Date (with allowed Range1)' );          //fix 2011-04-01 CBE-TEAM range
	$types[] = JHTML::_('select.option',  'dateselect', 'Date (triple DropDown)' );
	//$types[] = JHTML::_('select.option',  'dateselectrange', 'Date (triple DropDown & Range)' );
	$types[] = JHTML::_('select.option',  'select', 'Drop Down (Single Select)' );
	$types[] = JHTML::_('select.option',  'multiselect', 'Drop Down (Multi-Select)' );
	$types[] = JHTML::_('select.option',  'emailaddress', 'Email Address' );
	//$types[] = JHTML::_('select.option',  'password', 'Password Field' );
	$types[] = JHTML::_('select.option',  'editorta', 'Editor Text Area' );
	$types[] = JHTML::_('select.option',  'textarea', 'Text Area' );
	$types[] = JHTML::_('select.option',  'text', 'Text Field' );
	$types[] = JHTML::_('select.option',  'radio', 'Radio Button' );
	$types[] = JHTML::_('select.option',  'webaddress', 'Web Address' );
	$types[] = JHTML::_('select.option',  'numericfloat', 'Number Field (Float)' );
	$types[] = JHTML::_('select.option',  'numericint', 'Number Field (Integer)' );
	$types[] = JHTML::_('select.option',  'spacer', 'Spacer Line' );
	
	$lists['type'] = JHTML::_('select.genericlist',  $types, 'fieldtype', 'class="inputbox" size="'.sizeof($types).'" onchange="selType(this.options[this.selectedIndex].value);"', 'value', 'text', $userfield->fieldtype );

    $this->assignRef('request_url',$uri->toString());
    $this->assignRef( 'userfield',	$userfield );
    $this->assignRef('lists',$lists);
    parent::display( $tpl );
  }

    /*
	function _displayDefault( $tpl )
	{
		global $mainframe, $option;

		$db		=& JFactory::getDBO();
		$document	= & JFactory::getDocument();
		$uri 	=& JFactory::getURI();
		$user 	=& JFactory::getUser();
		$mainframe	=& JFactory::getApplication();
		$model	=& $this->getModel();
		
		//add css and submenu to document
    //$document->addStyleSheet(JURI::base().'components/com_joomleague/extensions/jlextuserfields/admin/assets/css/cpanel.css');
    $stylelink = '<link rel="stylesheet" href="'.JURI::root().'components/com_joomleague/extensions/jlextuserfields/admin/assets/css/cpanel.css'.'" type="text/css" />' ."\n";
    $document->addCustomTag($stylelink);
		$tablefields =& $model->getJLTableFields() ; 
		
		$this->assignRef( 'tablefields',		$tablefields );
		$this->assignRef('request_url',$uri->toString());
		
		
		
		parent::display( $tpl );
	}
	*/
	
  
  
}
?>