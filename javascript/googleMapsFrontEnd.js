$(document).ready(function() {
	
	if(!points) return;
	if(center == 'undefined') mapCenter = new google.maps.LatLng(center.Lat, center.Lon);
	else mapCenter = new google.maps.LatLng(points[0].Lat, points[0].Lon);

	var myOptions = {
		zoom: zoom,
		center: mapCenter,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	}
	var map = new google.maps.Map(document.getElementById("map_canvas"),myOptions);

	$.each(points, function(key, value) {
		var myLatLng = new google.maps.LatLng(value.Lat, value.Lon);
		var marker = new google.maps.Marker({
			position: myLatLng,
			map: map
		});
		var infowindow = new google.maps.InfoWindow({
			content: value.Popup,
			maxWidth: 200
		}); 
		google.maps.event.addListener(marker, 'click', function() {
			infowindow.open(map,marker);
		}); 
	});
});
