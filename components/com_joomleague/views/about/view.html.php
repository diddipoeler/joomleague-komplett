<?php defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class JoomleagueViewAbout extends JLGView
{
	function display($tpl=null)
	{
		// Get a refrence of the page instance in joomla
		$document =& JFactory::getDocument();

		$model =& $this->getModel();

		$this->assignRef('about',	$model->getAbout());
		$this->assignRef('version',	JoomleagueHelper::getVersion());

		// Set page title
		$document->setTitle(JText::_('JL_ABOUT_PAGE_TITLE'));

		parent::display($tpl);
	}

}
?>