<?php defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class JoomleagueViewReferee extends JLGView
{

	function display($tpl=null)
	{
		// Get a refrence of the page instance in joomla
		$document =& JFactory::getDocument();
		$model =& $this->getModel();
		$config=$model->getTemplateConfig($this->getName());
		$person=$model->getPerson();

		$this->assignRef('project',$model->getProject());
		$this->assignRef('overallconfig',$model->getOverallConfig());
		$this->assignRef('config',$config);
		$this->assignRef('person',$person);

		$ref=&$model->getReferee();
		if ($ref)
		{
			$titleStr=JText::sprintf('JL_REFEREE_ABOUT_AS_A_REFEREE',JoomleagueHelper::formatName(null, $ref->firstname, $ref->nickname, $ref->lastname, $this->config["name_format"]));
		}
		else
		{
			$titleStr=JText::_('Unknown referee within project');
		}

		$this->assignRef('referee',$ref);
		$this->assignRef('history',$model->getHistory('ASC'));

		$this->assign('title',$titleStr);

		if ($config['show_gameshistory'])
		{
			$this->assignRef('games',$model->getGames());
			$this->assignRef('teams',$model->getTeamsIndexedByPtid());
		}

		if ($person)
		{
			$paramsdata=$person->extended;
			$paramsdefs=JLG_PATH_ADMIN.DS.'assets'.DS.'extended'.DS.'person.xml';
			$extended=new JLGExtraParams($paramsdata,$paramsdefs);
		}
		else
		{
			$extended = null;
		}

		$this->assignRef('extended',$extended);

		$document->setTitle($titleStr);

		parent::display($tpl);
	}

}
?>