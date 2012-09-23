<?php
defined('_JEXEC') or die('Restricted access');



jimport('joomla.application.component.view');



class JoomleagueViewjlextcsseditor extends JLGView {
	
	function display($tpl = null) 
	{
		// Get a refrence of the page instance in joomla
		$document = & JFactory :: getDocument();
		$uri = & JFactory :: getURI();

    $model = & $this->getModel();
    $jlcss = $model->chooseTemplateCSS();
//		$this->assignRef('allseasons',    $leagueallseasons);

    $jlcssxmltitle = $model->_CHOOSE_TITLE();

  //JToolBarHelper::title( JText::_( 'Joomleague-CSS Editor' ), 'thememanager' );
	//JToolBarHelper::custom( 'edit_css', 'edit.png', 'edit_f2.png', 'Edit', true );
	//JToolBarHelper::cancel('edit');
	//JToolBarHelper::help( 'screen.templates' );
		
		parent :: display($tpl);
	}
}
?>