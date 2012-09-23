<?php 
defined( '_JEXEC' ) or die( 'Restricted access' );
$url= JURI::base(). 'components/com_joomleague/extensions/jlextzetamatchreport/css/swfobject.js';
$doc = &JFactory::getDocument();
$doc->addScript($url);

// bildpositionen für die spielsysteme
// $bildpositionen = array();
// $bildpositionen[4231][0][heim][oben] = 5;
// $bildpositionen[4231][0][heim][links] = 233;
// $bildpositionen[4231][1][heim][oben] = 113;
// $bildpositionen[4231][1][heim][links] = 69;
// $bildpositionen[4231][2][heim][oben] = 113;
// $bildpositionen[4231][2][heim][links] = 179;
// $bildpositionen[4231][3][heim][oben] = 113;
// $bildpositionen[4231][3][heim][links] = 288;
// $bildpositionen[4231][4][heim][oben] = 113;
// $bildpositionen[4231][4][heim][links] = 397;
// $bildpositionen[4231][5][heim][oben] = 236;
// $bildpositionen[4231][5][heim][links] = 179;
// $bildpositionen[4231][6][heim][oben] = 236;
// $bildpositionen[4231][6][heim][links] = 288;
// $bildpositionen[4231][7][heim][oben] = 318;
// $bildpositionen[4231][7][heim][links] = 69;
// $bildpositionen[4231][8][heim][oben] = 318;
// $bildpositionen[4231][8][heim][links] = 233;
// $bildpositionen[4231][9][heim][oben] = 318;
// $bildpositionen[4231][9][heim][links] = 397;
// $bildpositionen[4231][10][heim][oben] = 400;
// $bildpositionen[4231][10][heim][links] = 233;

// $bildpositionen[433][0][gast][oben] = 970;
// $bildpositionen[433][0][gast][links] = 233;
// $bildpositionen[433][1][gast][oben] = 879;
// $bildpositionen[433][1][gast][links] = 397;
// $bildpositionen[433][2][gast][oben] = 879;
// $bildpositionen[433][2][gast][links] = 288;
// $bildpositionen[433][3][gast][oben] = 879;
// $bildpositionen[433][3][gast][links] = 179;
// $bildpositionen[433][4][gast][oben] = 879;
// $bildpositionen[433][4][gast][links] = 69;
// $bildpositionen[433][5][gast][oben] = 787;
// $bildpositionen[433][5][gast][links] = 233;
// $bildpositionen[433][6][gast][oben] = 746;
// $bildpositionen[433][6][gast][links] = 343;
// $bildpositionen[433][7][gast][oben] = 746;
// $bildpositionen[433][7][gast][links] = 124;
// $bildpositionen[433][8][gast][oben] = 623;
// $bildpositionen[433][8][gast][links] = 397;
// $bildpositionen[433][9][gast][oben] = 623;
// $bildpositionen[433][9][gast][links] = 69;
// $bildpositionen[433][10][gast][oben] = 587;
// $bildpositionen[433][10][gast][links] = 233;

// echo '<pre>';
// print_r($bildpositionen);
// echo '</pre><br>';

// echo '<pre>';
// print_r($bildpositionen);
// echo '</pre><br>';

// echo 'fav_teams -> '.$this->project->fav_team . '<br>';
// echo 'projectteam1_id -> '.$this->match->projectteam1_id . '<br>';
// echo 'projectteam2_id -> '.$this->match->projectteam2_id . '<br>';

/*
* 
*/

$favteams1 = explode(",",$this->project->fav_team);
$favteams = array();

for ($a=0; $a < sizeof($favteams1);$a++ )
{
$favteams[$favteams1[$a]] = $favteams1[$a];
}

// echo '<pre>';
// print_r($favteams);
// echo '</pre><br>';
// 
// echo 'team_id 1 -> '.$this->team1->id . '<br>';
// echo 'team_id 2 -> '.$this->team2->id . '<br>';
        
//echo JPATH_COMPONENT . '<br>';
//echo JPATH_COMPONENT_SITE . '<br>';

?>

<div class="flash">
<table align="center" style="width: 100% ;" border="0">
<tr>
<td colspan="5" align="center">
<?php

//$teamname = 'Testverein';
// $matchpart2_picmidle = '';
// $schema= '442';
// $image = '/media/com_joomleague/placeholders/placeholder_150_2.png';
// $sost = '';

// schema der mannschaften
$schemahome = $this->extended->get('formation1');
$schemaguest = $this->extended->get('formation2');

// foreach ( $this->extended->getGroups() as $group => $groups )
// 	{
// 		$params = $this->extended->getElements($group);
// 		foreach ($params as $param)
// 		{
// 			if (!empty($param->value))
// 			{
// 			$hasData = true;
// 			}
// 		}
// 	}

// 	
// // hometeam
// $listadat1=$this->team1->name."|";
// $listadat1=$listadat1.$this->team1_club->logo_big."|";
// $listadat1=$listadat1.$schemahome."|";
// 
// // guesteam
// $listadat2=$this->team2->name."|";
// $listadat2=$listadat2.$this->team2_club->logo_big."|";
// $listadat2=$listadat2.$schemaguest."|";
// 
// // list of hometeam
// $homeplayer = 0;
// $guestplayer = 0;
// foreach ($this->matchplayers as $player)
// {
// if ( $player->ptid == $this->match->projectteam1_id )
// {
// $listadat1=$listadat1.$player->lastname.";".$player->firstname.";".$sost.";".$player->picture.",";
// $homeplayer++;
// }
// }	
// 
// if ( $homeplayer < 11 )
// {
// for ($a=$homeplayer; $a <= 11; $a++)
// {
// $listadat1=$listadat1.'nicht belegt'.";".''.";".$sost.";".$image.",";
// }
// 
// }
// 
// // list of guestteam
// foreach ($this->matchplayers as $player)
// {
// if ( $player->ptid == $this->match->projectteam2_id )
// {
// $listadat2=$listadat2.$player->lastname.";".$player->firstname.";".$sost.";".$player->picture.",";
// $guestplayer++;
// }
// }	
// 
// if ( $guestplayer < 11 )
// {
// for ($a=$guestplayer; $a <= 11; $a++)
// {
// $listadat2=$listadat2.'nicht belegt'.";".''.";".$sost.";".$image.",";
// }
// 
// }

// aufbau für den link
// $listadati=$listadati.$player->lastname.";".$player->firstname.";".$sost.";".$image.";".$provvedimento.";".$inoutstat[0]->played.";".$playerStats[$player_id][$gol].";".$playerStats[$player_id][$yellow].";".$playerStats[$player_id][$yellowred].";".$playerStats[$player_id][$red].",";				
// 
// $comando='
// <div id="flashcontent">
//   Se leggi questa scritta, è perchè non hai installato il player per flash.
// </div>
// 
// <script type="text/javascript">  var so = new SWFObject("components/com_joomleague/extensions/jlextzetamatchreport/css/matchreport.swf", "sotester", "450", "280", "9", "#FFFFFF");
// so.addVariable("var1", "components/com_joomleague/extensions/jlextzetamatchreport/views/matchreport/tmpl/formazione.php?variabili='.$listadat1.'");
//    so.write("flashcontent");
// </script>';
// 
// $comando2='
// <div id="flashcontent2">
//   Se leggi questa scritta, è perchè non hai installato il player per flash.
// </div>
// 
// <script type="text/javascript">  var so = new SWFObject("components/com_joomleague/extensions/jlextzetamatchreport/css/matchreport.swf", "sotester", "450", "280", "9", "#FFFFFF");
// so.addVariable("var1", "components/com_joomleague/extensions/jlextzetamatchreport/views/matchreport/tmpl/formazione.php?variabili='.$listadat2.'");
//    so.write("flashcontent2");
// </script>';


//$pane =& JPane::getInstance('tabs',array('startOffset'=>0));
//echo $pane->startPane('rosterpane');

// echo $pane->startPanel(JText::_('Spielsystem Heim ['.$schemahome.']'),'panel1');
// if ( !$schemahome )
// {
// echo 'kein Spielsystem hinterlegt!';
// }		
// echo utf8_encode($comando);
// echo $pane->endPanel();
// echo $pane->startPanel(JText::_('Spielsystem Gast ['.$schemaguest.']'),'panel2');
// if ( !$schemaguest )
// {
// echo 'kein Spielsystem hinterlegt!';
// }
// echo utf8_encode($comando2);
// echo $pane->endPanel();

// taktische aufstellung

//echo $pane->startPanel(JText::_('Taktische Aufstellung'),'panel1');

/*
$backgroundimage = 'Soccer_Field_Transparant_svg.png';
echo "<div style=\"background-image:url('media/com_joomleague/rosterground/".$backgroundimage."');background-position:left;position:relative;height:1100;width:850px;\">";
*/

$backgroundimage = 'media/com_joomleague/rosterground/spielfeld_578x1050.png';
//$backgroundimage = 'media/com_joomleague/rosterground/Soccer_Field_Transparant_svg.png';
list($width, $height, $type, $attr) = getimagesize($backgroundimage);

/*
echo 'bildgroesse width<br><pre>'.print_r($width).'</pre><br>';
echo 'bildgroesse height<br><pre>'.print_r($height).'</pre><br>';
echo 'bildgroesse type<br><pre>'.print_r($type).'</pre><br>';
echo 'bildgroesse attr<br><pre>'.print_r($attr).'</pre><br>';
*/

echo "<div style=\"background-image:url('".$backgroundimage."');background-position:left;position:relative;height:".$height."px;width:".$width."px;\">";

?>

<table class="taktischeaufstellung" summary="Taktische Aufstellung">
<tr>
<td>

<?PHP

// die logos
?>

<div style="position:absolute; width:103px; left:0px; top:0px; text-align:center;">
<img class="bild_s" style="width:90px;" src="<?PHP echo $this->team1_club->logo_big; ?>" alt="" /><br />
</div>
<div style="position:absolute; width:103px; left:0px; top:950px; text-align:center;">
<img class="bild_s" style="width:90px;" src="<?PHP echo $this->team2_club->logo_big; ?>" alt="" /><br />
</div>

<?PHP
// hometeam
$testlauf = 0;
foreach ($this->matchplayerpositions as $pos)
		{
			$personCount=0;
			foreach ($this->matchplayers as $player)
			{
				if ($player->pposid==$pos->pposid)
				{
					$personCount++;
				}
			}

if ($personCount > 0)
{

foreach ($this->matchplayers as $player)
{

if ( $player->pposid==$pos->pposid && $player->ptid == $this->match->projectteam1_id )
{
?>

<div style="position:absolute; width:103px; left:<?PHP echo $this->schemahome[$schemahome][$testlauf][heim][links]; ?>px; top:<?PHP echo $this->schemahome[$schemahome][$testlauf][heim][oben]; ?>px; text-align:center;">
<img class="bild_s" style="width:44px; height:52px;" src="<?PHP echo $player->picture; ?>" alt="" /><br />
<font color="white"><a class="link" href=""><?PHP echo $player->lastname." ".$player->firstname; ?></a></font>
</div>
                                      
<?PHP
$testlauf++;
}

}

}

}

// guestteam
$testlauf = 0;
foreach ($this->matchplayerpositions as $pos)
		{
			$personCount=0;
			foreach ($this->matchplayers as $player)
			{
				if ($player->pposid==$pos->pposid)
				{
					$personCount++;
				}
			}

if ($personCount > 0)
{			

foreach ($this->matchplayers as $player)
{

if ( $player->pposid==$pos->pposid && $player->ptid == $this->match->projectteam2_id )
{
?>

<div style="position:absolute; width:103px; left:<?PHP echo $this->schemaaway[$schemaguest][$testlauf][gast][links]; ?>px; top:<?PHP echo $this->schemaaway[$schemaguest][$testlauf][gast][oben]; ?>px; text-align:center;">
<img class="bild_s" style="width:44px; height:52px;" src="<?PHP echo $player->picture; ?>" alt="" /><br />
<font color="white"><a class="link" href=""><?PHP echo $player->lastname." ".$player->firstname; ?></a></font>
</div>
                                      
<?PHP
$testlauf++;
}

}

}

}	
?>

</td>
</tr>
</table>

<?PHP                                
echo "</div>";

//echo $pane->endPanel();
//echo $pane->endPane();




?>
</td>
</tr>
</table>
</div>