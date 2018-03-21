(function() {
	'use strict';

	var maplibphp = 'lib/map.php';
	var maplocations = [];

	$.ajax({
		url: maplibphp,
		data: {
			functionname: 'getlocations'
		},
		type: 'post',
		success: function(output) {
			maplocations = JSON.parse(output);
		}
	}).then(function() {
		if(!maplocations['error']) {
			var source = $('#hb_map').html();
			var template = Handlebars.compile(source);
			var data = {
				start_options : maplocations['start_options'],
				end_options   : maplocations['end_options']
			};
			var $html = template(data);
			$('#map-wrapper').html($html);
		}
		else {
			console.log(maplocations['error']);
		}
	});

})(window)

function initMap() {
	var directionsService = new google.maps.DirectionsService;
	var directionsDisplay = new google.maps.DirectionsRenderer;
	var map = new google.maps.Map(document.getElementById('map'), {
		zoom: 16,
		center: {lat: 30.550113, lng: -87.217905}
	});
	directionsDisplay.setMap(map);

	var onChangeHandler = function() {
		calculateAndDisplayRoute(directionsService, directionsDisplay);
	};
	document.getElementById('start').addEventListener('change', onChangeHandler);
	document.getElementById('end').addEventListener('change', onChangeHandler);
}

function calculateAndDisplayRoute(directionsService, directionsDisplay) {
	directionsService.route({
		origin: document.getElementById('start').value,
		destination: document.getElementById('end').value,
		travelMode: 'WALKING'
	}, function(response, status) {
		if (status === 'OK') {
			directionsDisplay.setDirections(response);
		} else {
			window.alert('Directions request failed due to ' + status);
		}
	});
}
