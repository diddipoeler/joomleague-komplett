<?php 
defined( '_JEXEC' ) or die( 'Restricted access' ); 

include_once JPATH_COMPONENT . DS . 'helpers' . DS . 'GoogleMap.php';
include_once JPATH_COMPONENT . DS . 'helpers' . DS . 'JSMin.php';

echo 'mapconfig<br><pre>';
print_r($this->mapconfig);
echo '</pre><br>';


?>

<?php
//include_once("../include/GoogleMap.php");
//include_once("../include/JSMin.php");

$MAP_OBJECT = new GoogleMapAPI(); 
$MAP_OBJECT->_minify_js = isset($_REQUEST["min"])?FALSE:TRUE;
//$MAP_OBJECT->setDSN("mysql://user:password@localhost/db_name");
$MAP_OBJECT->addMarkerByAddress($this->address_string,"Marker Title", "Marker Description");
$MAP_OBJECT->enableStreetViewControls();

$MAP_OBJECT->setWidth($this->mapconfig['width']);
$MAP_OBJECT->setHeight($this->mapconfig['height']);
$MAP_OBJECT->setZoomLevel($this->mapconfig['map_zoom']);
$MAP_OBJECT->setControlSize('large');
?>


<div style="width: 100%; float: left">

	<div class="contentpaneopen">
		<div class="contentheading">
			<?php echo JText::_('JL_GMAP_DIRECTIONS'); ?>
		</div>
	</div>

<?=$MAP_OBJECT->getHeaderJS();?>
<?=$MAP_OBJECT->getMapJS();?>

<?=$MAP_OBJECT->printOnLoad();?>
<?=$MAP_OBJECT->printMap();?>
<?=$MAP_OBJECT->printSidebar();?>

</div>