<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>
<table width="100%" class="contentpaneopen">
	<tr>
		<td class="contentheading">
			<?php
	echo JText::sprintf('JL_PLAYER_INFORMATION', JoomleagueHelper::formatName(null, $this->person->firstname, $this->person->nickname, $this->person->lastname, $this->config["name_format"]));
	
	if ( $this->showediticon )
	{
		$link = JoomleagueHelperRoute::getPlayerRoute( $this->project->id, $this->teamPlayer->team_id, $this->person->id, "edit" );
		$desc = JHTML::image(
			"media/com_joomleague/jl_images/edit.png",
			JText::_( 'JL_PERSON_EDIT' ),
			array( "title" => JText::_( "JL_PERSON_EDIT" ) )
		);
	    echo " ";
	    echo JHTML::_('link', $link, $desc );
	}

	if ( isset($this->teamPlayer->injury) && $this->teamPlayer->injury )
	{
		$imageTitle = JText::_( 'JL_PERSON_INJURED' );
		echo "&nbsp;&nbsp;" . JHTML::image(	'media/com_joomleague/event_icons/injured.gif',
							$imageTitle,
							array( 'title' => $imageTitle ) );
	}

	if ( isset($this->teamPlayer->suspension) && $this->teamPlayer->suspension )
	{
		$imageTitle = JText::_( 'JL_PERSON_SUSPENDED' );
		echo "&nbsp;&nbsp;" . JHTML::image(	'media/com_joomleague/event_icons/suspension.gif',
							$imageTitle,
							array( 'title' => $imageTitle ) );
	}


	if ( isset($this->teamPlayer->away) && $this->teamPlayer->away )
	{
		$imageTitle = JText::_( 'JL_PERSON_AWAY' );
		echo "&nbsp;&nbsp;" . JHTML::image(	'media/com_joomleague/event_icons/away.gif',
							$imageTitle,
							array( 'title' => $imageTitle ) );
	}
			?>
		</td>
	</tr>
</table>