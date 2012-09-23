<?php 
defined( '_JEXEC' ) or die( 'Restricted access' ); 

?>

<html>
  <head>
    <title>Geocoding with GMap v3</title>
  <script>

//Useful links:
// http://code.google.com/apis/maps/documentation/javascript/reference.html#Marker
// http://code.google.com/apis/maps/documentation/javascript/services.html#Geocoding
// http://jqueryui.com/demos/autocomplete/#remote-with-cache
      
var geocoder;
var map;
var marker;
    
function initialize(){
//MAP
  var latlng = new google.maps.LatLng(41.659,-4.714);
  var options = {
    zoom: 16,
    center: latlng,
    mapTypeId: google.maps.MapTypeId.SATELLITE
  };
        
  map = new google.maps.Map(document.getElementById("map_canvas"), options);
        
  //GEOCODER
  geocoder = new google.maps.Geocoder();
        
  marker = new google.maps.Marker({
    map: map,
    draggable: true
  });
				
}
		
jQuery(document).ready(function() { 
         
  initialize();
				  
  jQuery(function() {
    jQuery("#address").autocomplete({
      //This bit uses the geocoder to fetch address values
      source: function(request, response) {
        geocoder.geocode( {'address': request.term }, function(results, status) {
          response(jQuery.map(results, function(item) {
            return {
              label:  item.formatted_address,
              value: item.formatted_address,
              latitude: item.geometry.location.lat(),
              longitude: item.geometry.location.lng()
            }
          }));
        })
      },
      //This bit is executed upon selection of an address
      select: function(event, ui) {
        jQuery("#latitude").val(ui.item.latitude);
        jQuery("#longitude").val(ui.item.longitude);
        var location = new google.maps.LatLng(ui.item.latitude, ui.item.longitude);
        marker.setPosition(location);
        map.setCenter(location);
      }
    });
  });
	
  //Add listener to marker for reverse geocoding
  google.maps.event.addListener(marker, 'drag', function() {
    geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        if (results[0]) {
          jQuery('#address').val(results[0].formatted_address);
          jQuery('#latitude').val(marker.getPosition().lat());
          jQuery('#longitude').val(marker.getPosition().lng());
        }
      }
    });
  });
  
});

  
  </script>  
  </head>
  <body>
    <label>Address: </label><input id="address"  type="text"/>
    <div id="map_canvas" style="width:300px; height:300px"></div><br/>
    <label>latitude: </label><input id="latitude" type="text"/><br/>
    <label>longitude: </label><input id="longitude" type="text"/>
  </body>
</html>


